@extends('layouts.app')
@section('title', 'Anggota')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-users',
    'title' => 'Manajemen Anggota',
    'desc'  => 'Kelola data keanggotaan perpustakaan.',
    'actions' => [
        ['url' => route('members.create'), 'label' => 'Anggota Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'member.create'],
    ],
])

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <input name="q" value="{{ request('q') }}" placeholder="Nama / NIS / email..." class="form-input md:col-span-6">
        <select name="type" class="form-select md:col-span-4">
            <option value="">Semua</option>
            <option value="student" @selected(request('type')==='student')>Siswa</option>
            <option value="teacher" @selected(request('type')==='teacher')>Guru</option>
            <option value="public"  @selected(request('type')==='public')>Umum</option>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-magnifying-glass"></i> Cari</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>NIS/NIP</th><th>Tipe</th><th>Aktif</th><th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($members as $m)
            <tr>
                <td class="font-mono text-xs">{{ $m->member_no }}</td>
                <td>{{ $m->user?->name }}<br><span class="text-xs text-slate-500 dark:text-slate-400">{{ $m->user?->email }}</span></td>
                <td>{{ $m->nis_nip }}</td>
                <td>{{ $m->type }}</td>
                <td>@if($m->is_active)<span class="badge-green"><i class="fas fa-check"></i> aktif</span>@else<span class="badge-red"><i class="fas fa-xmark"></i> tidak</span>@endif</td>
                <td class="text-right whitespace-nowrap">
                    <a href="{{ route('members.show', $m) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada anggota.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $members->links() }}</div>
</div>
@endsection
