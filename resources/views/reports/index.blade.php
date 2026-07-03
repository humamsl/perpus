@extends('layouts.app')
@section('title','Laporan')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-chart-column',
    'title' => 'Laporan',
    'desc'  => 'Pusat laporan aktivitas perpustakaan.',
])

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card">
        <div class="flex justify-between items-center mb-2">
            <h2 class="font-bold text-lg">Buku Populer</h2>
            <a href="{{ route('reports.pdf','popular') }}" class="btn-secondary text-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        </div>
        <ol class="list-decimal pl-5 text-sm space-y-1">
            @forelse($topBooks as $b)
                <li>{{ $b->title }} <span class="text-slate-500 dark:text-slate-400">({{ $b->borrow_count }}x)</span></li>
            @empty
                <li class="text-slate-500 list-none pl-0"><i class="fas fa-inbox"></i> Tidak ada data.</li>
            @endforelse
        </ol>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-2">
            <h2 class="font-bold text-lg">Buku Terlambat</h2>
            <a href="{{ route('reports.pdf','overdue') }}" class="btn-secondary text-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        </div>
        <ul class="text-sm space-y-1">
            @forelse($overdue as $t)
                <li>{{ $t->book?->title }} — {{ $t->member?->user?->name }} <span class="badge-red">{{ $t->daysLate() }} hari</span></li>
            @empty
                <li class="text-slate-500"><i class="fas fa-inbox"></i> Tidak ada keterlambatan.</li>
            @endforelse
        </ul>
    </div>

    <div class="card md:col-span-2">
        <h2 class="font-bold text-lg mb-2">Anggota Aktif</h2>
        <ol class="list-decimal pl-5 text-sm space-y-1">
            @forelse($activeMembers as $m)
                <li>{{ $m->member_no }} — {{ $m->borrows_count }} transaksi</li>
            @empty
                <li class="text-slate-500 list-none pl-0"><i class="fas fa-inbox"></i> Tidak ada data.</li>
            @endforelse
        </ol>
    </div>
</div>
@endsection
