<?php

namespace App\Services;

use App\Models\BorrowingHistory;
use App\Models\Checkout;
use App\Models\CheckoutSetting;
use App\Models\Hold;
use App\Models\OfflineBookCopy;
use App\Models\ReadingSpot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function settings(ReadingSpot $spot): CheckoutSetting
    {
        return CheckoutSetting::firstOrCreate(
            ['reading_spot_id' => $spot->id],
            ['loan_days' => 7, 'max_books' => 3, 'daily_fine' => 1000,
             'damage_fine' => 25000, 'lost_fine' => 100000, 'renew_limit' => 1,
             'hold_expires_hours' => 48]
        );
    }

    /** Buat hold (penangguhan) untuk satu/lebih copy */
    public function placeHold(User $user, ReadingSpot $spot, array $copyIds, ?string $notes = null): Hold
    {
        $cfg = $this->settings($spot);
        return DB::transaction(function () use ($user, $spot, $copyIds, $notes, $cfg) {
            $hold = Hold::create([
                'user_id'         => $user->id,
                'reading_spot_id' => $spot->id,
                'hold_at'         => now(),
                'expires_at'      => now()->addHours($cfg->hold_expires_hours),
                'status'          => 'active',
                'notes'           => $notes,
            ]);
            $hold->offlineBookCopies()->attach($copyIds);
            return $hold;
        });
    }

    /** Checkout (peminjaman fisik) — bisa dari Hold atau langsung */
    public function checkout(User $user, ReadingSpot $spot, array $copyIds, ?int $staffId = null, ?int $days = null): Checkout
    {
        $cfg  = $this->settings($spot);
        $days = $days ?: $cfg->loan_days;

        return DB::transaction(function () use ($user, $spot, $copyIds, $staffId, $days) {
            // Validasi: setiap copy harus available
            $copies = OfflineBookCopy::whereIn('id', $copyIds)->get();
            foreach ($copies as $c) {
                abort_unless($c->isAvailable(), 422, "Copy {$c->catalog_code} tidak tersedia.");
            }

            $checkout = Checkout::create([
                'code'            => 'CO-' . Str::upper(Str::random(8)),
                'user_id'         => $user->id,
                'reading_spot_id' => $spot->id,
                'staff_id'        => $staffId,
                'start_time'      => now(),
                'end_time'        => now()->addDays($days),
                'is_returned'     => false,
            ]);
            $checkout->offlineBookCopies()->attach($copyIds);

            foreach ($copies as $c) {
                $c->offlineBook->increment('borrow_count');
            }
            return $checkout;
        });
    }

    /** Pengembalian buku fisik */
    public function checkin(Checkout $checkout, ?int $staffId = null): Checkout
    {
        return DB::transaction(function () use ($checkout, $staffId) {
            $cfg       = $this->settings($checkout->readingSpot);
            $daysLate  = $checkout->daysLate();
            $fine      = $daysLate > 0 ? $daysLate * $cfg->daily_fine : 0;

            $checkout->update([
                'is_returned' => true,
                'return_time' => now(),
                'staff_id'    => $staffId ?? $checkout->staff_id,
                'fine_amount' => $fine,
            ]);

            // Catat ke borrowing_histories per buku
            foreach ($checkout->offlineBookCopies as $copy) {
                BorrowingHistory::create([
                    'user_id'         => $checkout->user_id,
                    'offline_book_id' => $copy->offline_book_id,
                    'reading_spot_id' => $checkout->reading_spot_id,
                    'borrowed_at'     => $checkout->start_time,
                    'returned_at'     => now(),
                    'days_borrowed'   => (int) $checkout->start_time->diffInDays(now()),
                    'fine_amount'     => $fine,
                ]);
            }
            return $checkout;
        });
    }

    public function cancelHold(Hold $hold): Hold
    {
        $hold->update(['status' => 'cancelled']);
        return $hold;
    }

    public function fulfillHold(Hold $hold, ?int $staffId = null, ?int $days = null): Checkout
    {
        // Hold di-set 'fulfilled' SEBELUM checkout() dipanggil (dalam transaksi yang
        // sama) supaya OfflineBookCopy::isAvailable() tidak menganggap kopi ini masih
        // "ditahan" oleh hold aktifnya sendiri dan menolak checkout-nya sendiri.
        return DB::transaction(function () use ($hold, $staffId, $days) {
            $copyIds = $hold->offlineBookCopies()->pluck('offline_book_copies.id')->all();
            $hold->update(['status' => 'fulfilled']);
            return $this->checkout($hold->user, $hold->readingSpot, $copyIds, $staffId, $days);
        });
    }
}
