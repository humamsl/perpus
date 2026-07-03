@extends('layouts.app')
@section('title','Denda')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-money-bill-wave',
    'title' => 'Denda',
    'desc'  => 'Kelola denda keterlambatan dan kerusakan buku.',
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr><th>Anggota</th><th>Tipe</th><th>Jumlah</th><th>Dibayar</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($rows as $f)
            <tr>
                <td>{{ $f->member?->user?->name }}</td>
                <td>{{ $f->type }}</td>
                <td>Rp {{ number_format($f->amount,0,',','.') }}</td>
                <td>Rp {{ number_format($f->paid_amount,0,',','.') }}</td>
                <td>
                    @if($f->status === 'paid')<span class="badge-green"><i class="fas fa-check"></i> {{ $f->status }}</span>
                    @elseif($f->status === 'waived')<span class="badge-blue"><i class="fas fa-hand"></i> {{ $f->status }}</span>
                    @elseif($f->status === 'partial')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $f->status }}</span>
                    @else<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> {{ $f->status }}</span>@endif
                </td>
                <td class="text-right whitespace-nowrap">
                    <a href="{{ route('fines.show', $f) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Tidak ada denda.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $rows->links() }}</div>
</div>
@endsection
