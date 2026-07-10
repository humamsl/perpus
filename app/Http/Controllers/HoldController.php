<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\OfflineBookCopy;
use App\Models\ReadingSpot;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HoldController extends Controller
{
    public function index(Request $r)
    {
        $rows = Hold::with(['user','readingSpot','offlineBookCopies.offlineBook'])
            ->when($r->status, fn($q) => $q->where('status', $r->status))
            ->latest()->paginate(20);
        return view('holds.index', compact('rows'));
    }

    public function store(Request $r, CheckoutService $svc)
    {
        $data = $r->validate([
            'reading_spot_id' => 'required|exists:reading_spots,id',
            'copy_ids'        => 'required|array',
            'copy_ids.*'      => 'integer|exists:offline_book_copies,id',
            'notes'           => 'nullable|string|max:500',
        ]);
        $hold = $svc->placeHold(
            $r->user(),
            ReadingSpot::findOrFail($data['reading_spot_id']),
            $data['copy_ids'],
            $data['notes'] ?? null
        );
        $hold->update(['code' => 'HLD-' . Str::upper(Str::random(8))]);

        return redirect()->route('holds.qrcode', $hold)
            ->with('toast', 'Hold dibuat (kedaluwarsa: '.$hold->expires_at->format('d M Y H:i').'). Tunjukkan kode QR ini ke petugas perpustakaan.');
    }

    /** Kode QR yang ditunjukkan anggota ke petugas untuk mengambil buku fisiknya. */
    public function qrcode(Hold $hold)
    {
        abort_unless(
            $hold->user_id === auth()->id() || auth()->user()->can('borrow.return'),
            403
        );
        $hold->load('offlineBookCopies.offlineBook', 'readingSpot');
        return view('holds.qrcode', compact('hold'));
    }

    /** Halaman scan QR untuk petugas perpustakaan. */
    public function scan()
    {
        abort_unless(auth()->user()->can('borrow.return'), 403);
        return view('holds.scan');
    }

    /** Dipanggil oleh halaman scan (kamera atau input manual) untuk mencari hold berdasarkan kode QR. */
    public function lookup(Request $r)
    {
        abort_unless(auth()->user()->can('borrow.return'), 403);
        $data = $r->validate(['code' => 'required|string']);

        $hold = Hold::with(['user', 'readingSpot', 'offlineBookCopies.offlineBook'])
            ->where('code', trim($data['code']))->first();

        if (!$hold) {
            return response()->json(['message' => 'Kode hold tidak ditemukan.'], 404);
        }

        return response()->json([
            'id'     => $hold->id,
            'status' => $hold->status,
            'user'   => ['name' => $hold->user?->name],
            'reading_spot' => $hold->readingSpot?->name,
            'hold_at' => $hold->hold_at?->translatedFormat('d M Y H:i'),
            'books' => $hold->offlineBookCopies->map(fn ($c) => [
                'title'        => $c->offlineBook?->title,
                'catalog_code' => $c->catalog_code,
                'cover'        => $c->offlineBook?->cover ? asset('storage/'.$c->offlineBook->cover) : null,
            ]),
        ]);
    }

    /**
     * Petugas mengonfirmasi checkout dari hasil scan — dipanggil lewat AJAX
     * dari halaman scan, beda dari fulfill() di bawah (redirect biasa, dipakai
     * tombol di daftar Hold) supaya responsnya JSON.
     */
    public function confirmScan(Hold $hold, CheckoutService $svc)
    {
        abort_unless(auth()->user()->can('borrow.return'), 403);
        abort_if($hold->status !== 'active', 422, 'Hold ini sudah tidak aktif.');

        $checkout = $svc->fulfillHold($hold, auth()->id());

        return response()->json([
            'message'      => 'Checkout berhasil dikonfirmasi.',
            'checkout_code' => $checkout->code,
            'redirect_url' => route('checkouts.show', $checkout),
        ]);
    }

    public function fulfill(Hold $hold, CheckoutService $svc, Request $r)
    {
        $checkout = $svc->fulfillHold($hold, $r->user()->id);
        return redirect()->route('checkouts.show', $checkout)->with('toast', 'Hold dijadikan checkout.');
    }

    public function cancel(Hold $hold, CheckoutService $svc)
    {
        abort_unless($hold->user_id === auth()->id() || auth()->user()->can('borrow.return'), 403);
        $svc->cancelHold($hold);
        return back()->with('toast', 'Hold dibatalkan.');
    }
}
