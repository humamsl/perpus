<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Payment;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index(Request $r)
    {
        $rows = Fine::with(['member.user','borrow.book'])
            ->when($r->status, fn($q) => $q->where('status', $r->status))
            ->latest()->paginate(20);
        return view('fines.index', compact('rows'));
    }

    public function mine()
    {
        $member = auth()->user()->member;
        $rows = $member
            ? $member->fines()->with('borrow.book')->latest()->paginate(20)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        return view('fines.index', ['rows' => $rows]);
    }

    public function show(Fine $fine)
    {
        $fine->load(['member.user','borrow.book','payments']);
        return view('fines.show', compact('fine'));
    }

    public function pay(Request $r, Fine $fine)
    {
        $data = $r->validate([
            'amount'    => 'required|integer|min:1',
            'method'    => 'nullable|in:cash,transfer,qris,other',
            'reference' => 'nullable|string|max:100',
        ]);
        Payment::create([
            'fine_id'     => $fine->id,
            'received_by' => $r->user()->id,
            'amount'      => $data['amount'],
            'method'      => $data['method'] ?? 'cash',
            'reference'   => $data['reference'] ?? null,
            'paid_at'     => now(),
        ]);
        $fine->paid_amount += $data['amount'];
        $fine->recomputeStatus();
        return back()->with('toast', 'Pembayaran tercatat.');
    }

    public function waive(Fine $fine)
    {
        $fine->update(['status' => 'waived']);
        return back()->with('toast', 'Denda dibebaskan.');
    }

    public function receipt(Fine $fine)
    {
        return view('fines.receipt', compact('fine'));
    }
}
