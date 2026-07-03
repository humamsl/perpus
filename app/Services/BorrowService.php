<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Models\Fine;
use App\Models\Member;
use App\Models\ReturnTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BorrowService
{
    public function checkout(Member $member, Book $book, ?int $staffId = null, ?int $days = null): BorrowTransaction
    {
        $days = $days ?: (int) config('library.default_loan_days', 7);

        return DB::transaction(function () use ($member, $book, $staffId, $days) {
            abort_unless($member->canBorrow(), 422, 'Anggota tidak memenuhi syarat peminjaman.');
            abort_unless($book->available > 0, 422, 'Stok buku tidak tersedia.');

            $book->decrement('available');
            $book->increment('borrow_count');
            if ($book->fresh()->available === 0) {
                $book->update(['status' => 'borrowed']);
            }

            return BorrowTransaction::create([
                'code'        => 'BR-' . Str::upper(Str::random(8)),
                'member_id'   => $member->id,
                'book_id'     => $book->id,
                'staff_id'    => $staffId,
                'borrowed_at' => now(),
                'due_at'      => now()->addDays($days),
                'status'      => 'active',
            ]);
        });
    }

    public function renew(BorrowTransaction $tx): BorrowTransaction
    {
        abort_if($tx->renew_count >= (int) config('library.renew_limit', 1), 422, 'Batas perpanjangan tercapai.');
        abort_if($tx->isOverdue(), 422, 'Pinjaman terlambat tidak bisa diperpanjang.');

        $tx->update([
            'due_at'      => $tx->due_at->addDays((int) config('library.default_loan_days', 7)),
            'renew_count' => $tx->renew_count + 1,
        ]);
        return $tx;
    }

    public function checkin(BorrowTransaction $tx, string $condition = 'good', ?string $damageNotes = null, ?int $staffId = null): ReturnTransaction
    {
        return DB::transaction(function () use ($tx, $condition, $damageNotes, $staffId) {
            $daysLate   = $tx->daysLate();
            $fineAmount = $this->calculateFine($daysLate, $condition);

            $ret = ReturnTransaction::create([
                'borrow_transaction_id' => $tx->id,
                'staff_id'              => $staffId,
                'returned_at'           => now(),
                'condition'             => $condition,
                'days_late'             => $daysLate,
                'fine_amount'           => $fineAmount,
                'damage_notes'          => $damageNotes,
            ]);

            $tx->update([
                'returned_at' => now(),
                'status'      => match ($condition) {
                    'lost'    => 'lost',
                    'damaged' => 'damaged',
                    default   => 'returned',
                },
            ]);

            $book = $tx->book;
            if ($condition !== 'lost') {
                $book->increment('available');
                if ($book->status === 'borrowed') $book->update(['status' => 'available']);
            } else {
                $book->decrement('stock');
            }

            if ($fineAmount > 0) {
                Fine::create([
                    'member_id'             => $tx->member_id,
                    'borrow_transaction_id' => $tx->id,
                    // Petakan kondisi pengembalian -> enum fines.type ('late','damage','lost','other').
                    'type'                  => match ($condition) {
                        'damaged' => 'damage',
                        'lost'    => 'lost',
                        default   => 'late',
                    },
                    'amount'                => $fineAmount,
                    'description'           => $this->fineLabel($daysLate, $condition),
                ]);
            }
            return $ret;
        });
    }

    public function calculateFine(int $daysLate, string $condition): int
    {
        $total = 0;
        if ($daysLate > 0) $total += $daysLate * (int) config('library.daily_fine', 1000);
        $total += match ($condition) {
            'damaged' => (int) config('library.damage_fine', 25000),
            'lost'    => (int) config('library.lost_fine', 100000),
            default   => 0,
        };
        return $total;
    }

    protected function fineLabel(int $daysLate, string $condition): string
    {
        $parts = [];
        if ($daysLate > 0) $parts[] = "Terlambat $daysLate hari";
        if ($condition === 'damaged') $parts[] = 'Kerusakan';
        if ($condition === 'lost')    $parts[] = 'Kehilangan';
        return implode(' + ', $parts) ?: 'Denda';
    }
}
