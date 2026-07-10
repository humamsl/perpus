<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

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

        Reservation::create([
            'member_id'      => $member->id,
            'book_id'        => $data['book_id'],
            'reserved_at'    => now(),
            'expires_at'     => now()->addHours(config('library.reservation_hours', 48)),
            'queue_position' => $position,
            'status'         => 'pending',
        ]);
        return back()->with('toast', "Reservasi tersimpan (antrean #$position).");
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
