<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\BorrowService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index()
    {
        $rows = Reservation::with(['member.user','book'])->latest()->paginate(20);
        return view('reservations.index', compact('rows'));
    }

    public function store(Request $r)
    {
        $data = $r->validate(['book_id' => 'required|exists:books,id']);
        $member = $r->user()->member;
        abort_unless($member, 422, 'Akun Anda bukan anggota.');

        $position = Reservation::where('book_id', $data['book_id'])
            ->whereIn('status', ['pending','ready'])->count() + 1;

        $reservation = Reservation::create([
            'code'           => 'RSV-' . Str::upper(Str::random(8)),
            'member_id'      => $member->id,
            'book_id'        => $data['book_id'],
            'reserved_at'    => now(),
            'expires_at'     => now()->addHours(config('library.reservation_hours', 48)),
            'queue_position' => $position,
            'status'         => 'pending',
        ]);

        return redirect()->route('reservations.qrcode', $reservation)
            ->with('toast', "Reservasi tersimpan (antrean #$position). Tunjukkan kode QR ini ke petugas perpustakaan.");
    }

    /** Kode QR yang ditunjukkan siswa ke petugas untuk diambil bukunya. */
    public function qrcode(Reservation $reservation)
    {
        abort_unless(
            $reservation->member?->user_id === auth()->id() || auth()->user()->can('reservation.verify'),
            403
        );
        $reservation->load('book', 'member.user');
        return view('reservations.qrcode', compact('reservation'));
    }

    /** Halaman scan QR untuk petugas perpustakaan. */
    public function scan()
    {
        abort_unless(auth()->user()->can('reservation.verify'), 403);
        return view('reservations.scan');
    }

    /** Dipanggil oleh halaman scan (kamera atau input manual) untuk mencari reservasi berdasarkan kode QR. */
    public function lookup(Request $r)
    {
        abort_unless(auth()->user()->can('reservation.verify'), 403);
        $data = $r->validate(['code' => 'required|string']);

        $reservation = Reservation::with(['book', 'member.user'])
            ->where('code', trim($data['code']))->first();

        if (!$reservation) {
            return response()->json(['message' => 'Kode reservasi tidak ditemukan.'], 404);
        }

        return response()->json([
            'id'          => $reservation->id,
            'status'      => $reservation->status,
            'book'        => [
                'id'    => $reservation->book->id,
                'title' => $reservation->book->title,
                'cover' => $reservation->book->cover ? asset('storage/'.$reservation->book->cover) : null,
                'available' => $reservation->book->available,
            ],
            'member'      => [
                'name'      => $reservation->member->user?->name,
                'member_no' => $reservation->member->member_no,
            ],
            'reserved_at' => $reservation->reserved_at?->translatedFormat('d M Y H:i'),
        ]);
    }

    /**
     * Petugas mengonfirmasi peminjaman dari hasil scan — mengubah reservasi
     * menjadi peminjaman aktif (BorrowTransaction) lewat BorrowService yang
     * sama dipakai alur peminjaman manual, supaya stok & aturan tetap konsisten.
     */
    public function fulfill(Request $r, Reservation $reservation, BorrowService $svc)
    {
        abort_unless(auth()->user()->can('reservation.verify'), 403);
        abort_if(in_array($reservation->status, ['fulfilled', 'cancelled', 'expired']), 422, 'Reservasi ini sudah tidak aktif.');

        $tx = $svc->checkout($reservation->member, $reservation->book, auth()->id());
        $reservation->update(['status' => 'fulfilled']);

        return response()->json([
            'message'      => 'Peminjaman berhasil dikonfirmasi.',
            'borrow_code'  => $tx->code,
            'redirect_url' => route('borrows.show', $tx),
        ]);
    }

    public function verify(Reservation $reservation)
    {
        abort_unless(auth()->user()->can('reservation.verify'), 403);
        $reservation->update(['status' => 'ready']);
        return back()->with('toast', 'Reservasi siap diambil.');
    }

    public function cancel(Reservation $reservation)
    {
        abort_unless(
            $reservation->member?->user_id === auth()->id() || auth()->user()->can('reservation.verify'),
            403
        );
        $reservation->update(['status' => 'cancelled']);
        return back()->with('toast', 'Reservasi dibatalkan.');
    }

    public function destroy(Reservation $reservation) { return $this->cancel($reservation); }
}
