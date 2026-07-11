<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowRequest;
use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Models\Member;
use App\Services\BorrowService;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index(Request $r)
    {
        $this->authorize('viewAny', BorrowTransaction::class);
        $rows = BorrowTransaction::with(['member.user','book','staff'])
            ->when($r->status, fn($q) => $q->where('status', $r->status))
            ->latest()->paginate(20)->withQueryString();
        return view('borrows.index', compact('rows'));
    }

    public function create()
    {
        $this->authorize('create', BorrowTransaction::class);
        return view('borrows.create', [
            'members' => Member::with('user')->where('is_active', true)->orderBy('id')->get(),
            'books'   => Book::orderBy('title')->get(['id','title']),
        ]);
    }

    public function store(StoreBorrowRequest $r, BorrowService $svc)
    {
        $tx = $svc->checkout(
            Member::findOrFail($r->member_id),
            Book::findOrFail($r->book_id),
            $r->user()->id,
            $r->days ? (int) $r->days : null
        );
        return redirect()->route('borrows.show', $tx)->with('toast', 'Peminjaman dicatat.');
    }

    public function show(BorrowTransaction $borrow)
    {
        $this->authorize('view', $borrow);
        $borrow->load(['member.user','book','staff','return_','fine']);
        return view('borrows.show', ['tx' => $borrow]);
    }

    public function renew(BorrowTransaction $borrow, BorrowService $svc)
    {
        $this->authorize('renew', $borrow);
        $svc->renew($borrow);
        return back()->with('toast', 'Pinjaman diperpanjang.');
    }

    public function scan() { return view('borrows.scan'); }
    public function lookup(Request $r) {
        $tx = BorrowTransaction::where('code', $r->code)->first();
        return response()->json($tx);
    }
    public function receipt(BorrowTransaction $borrow) { return view('borrows.receipt', ['tx' => $borrow]); }
}
