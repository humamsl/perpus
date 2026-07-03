@extends('layouts.app')
@section('title', $member->user?->name)
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-id-card',
    'title' => $member->user?->name,
    'desc'  => $member->member_no . ' · ' . $member->type,
    'actions' => [
        ['url' => route('members.card', $member), 'label' => 'Kartu Anggota', 'class' => 'btn-secondary', 'icon' => 'fa-id-card'],
    ],
])

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card">
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">NIS/NIP</dt><dd class="text-slate-800 dark:text-slate-100">{{ $member->nis_nip ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Kelas/Jurusan</dt><dd class="text-slate-800 dark:text-slate-100">{{ trim($member->class.' '.$member->major) ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Bergabung</dt><dd class="text-slate-800 dark:text-slate-100">{{ $member->joined_at?->format('d M Y') }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Berlaku Hingga</dt><dd class="text-slate-800 dark:text-slate-100">{{ $member->expires_at?->format('d M Y') }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Pinjaman Aktif</dt><dd class="text-slate-800 dark:text-slate-100">{{ $member->active_borrow_count }}/{{ config('library.max_per_member') }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Denda Tertunggak</dt><dd class="text-slate-800 dark:text-slate-100">Rp {{ number_format($member->unpaid_fine_total, 0, ',', '.') }}</dd></div>
        </dl>
        @can('member.update')<a href="{{ route('members.edit', $member) }}" class="btn-secondary w-full mt-4 flex justify-center"><i class="fas fa-pen"></i> Edit</a>@endcan
    </div>
    <div class="card md:col-span-2 overflow-x-auto">
        <h3 class="font-semibold mb-3 text-slate-800 dark:text-slate-100">Riwayat Peminjaman</h3>
        <table class="table-pretty">
            <thead><tr><th>Kode</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($member->borrows->take(20) as $t)
                <tr>
                    <td class="font-mono text-xs">{{ $t->code }}</td>
                    <td>{{ $t->book?->title }}</td>
                    <td>{{ $t->borrowed_at?->format('d M Y') }}</td>
                    <td>{{ $t->due_at?->format('d M Y') }}</td>
                    <td>
                        @if($t->status === 'active')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $t->status }}</span>
                        @elseif($t->status === 'returned')<span class="badge-green"><i class="fas fa-check"></i> {{ $t->status }}</span>
                        @elseif($t->status === 'overdue')<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> {{ $t->status }}</span>
                        @else<span class="badge-gray">{{ $t->status }}</span>@endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-slate-500 py-8">
                    <i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>
                    Belum ada riwayat.
                </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
