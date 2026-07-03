@extends('layouts.app')
@section('title','Riwayat Pengembalian')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-clock-rotate-left',
    'title' => 'Riwayat Pengembalian',
    'desc'  => 'Daftar buku yang sudah dikembalikan.',
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Kembali</th><th>Kondisi</th><th>Denda</th></tr>
        </thead>
        <tbody>
        @forelse($rows as $t)
            <tr>
                <td class="font-mono text-xs">{{ $t->code }}</td>
                <td>{{ $t->member?->user?->name }}</td>
                <td>{{ $t->book?->title }}</td>
                <td>{{ $t->returned_at?->format('d M Y') }}</td>
                <td>
                    @if($t->return_?->condition === 'good')<span class="badge-green">{{ $t->return_?->condition }}</span>
                    @elseif($t->return_?->condition === 'damaged')<span class="badge-yellow">{{ $t->return_?->condition }}</span>
                    @elseif($t->return_?->condition === 'lost')<span class="badge-red">{{ $t->return_?->condition }}</span>
                    @else<span class="badge-gray">{{ $t->return_?->condition }}</span>@endif
                </td>
                <td>Rp {{ number_format($t->return_?->fine_amount ?? 0, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada riwayat pengembalian.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $rows->links() }}</div>
</div>
@endsection
