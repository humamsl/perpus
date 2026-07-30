@extends('layouts.app')
@section('title','Reading Spots')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-map-location-dot',
    'title' => 'Reading Spots',
    'desc'  => 'Multi-tenant: tiap lokasi punya koleksi, anggota, dan branding sendiri.',
    'actions' => [
        ['url' => route('reading-spots.create'), 'label' => 'Reading Spot Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'setting.manage'],
    ],
])

<form method="get" class="card mb-6 grid md:grid-cols-6 gap-3">
    <div class="md:col-span-2 relative">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input name="q" value="{{ request('q') }}" placeholder="Nama spot..." class="form-input pl-10">
    </div>
    <div class="md:col-span-2 relative">
        <i class="fas fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input name="loc" value="{{ request('loc') }}" placeholder="Cari lokasi: alamat, kota, provinsi..." class="form-input pl-10">
    </div>
    <select name="type" class="form-select">
        <option value="">Semua tipe</option>
        @foreach([
            'school'=>'Sekolah',
            'library'=>'Perpustakaan',
            'community'=>'Komunitas',
            'public'=>'Umum'
        ] as $v=>$t)
            <option value="{{ $v }}" @selected(request('type')===$v)>{{ $t }}</option>
        @endforeach
    </select>
    <div class="flex gap-2">
        <button class="btn-primary flex-1"><i class="fas fa-filter"></i> Filter</button>
        @if(request('q') || request('loc') || request('type'))
            <a href="{{ route('reading-spots.index') }}" class="btn-secondary" title="Reset"><i class="fas fa-rotate-left"></i></a>
        @endif
    </div>
</form>

@if(request('loc'))
    <p class="text-sm text-slate-500 mb-4 -mt-2">
        <i class="fas fa-location-dot text-primary-500"></i>
        Menampilkan reading spot di lokasi <span class="font-semibold text-slate-700 dark:text-slate-300">"{{ request('loc') }}"</span>
        — {{ $spots->total() }} hasil
    </p>
@endif

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
@forelse($spots as $s)
    @php
        $typeIcons = ['school'=>'fa-school','library'=>'fa-book-bookmark','community'=>'fa-users','public'=>'fa-globe'];
        $icon = $typeIcons[$s->type] ?? 'fa-map-pin';
    @endphp
    <a href="{{ route('reading-spots.show', $s) }}" class="card hover:shadow-hover transition group">
        <div class="flex items-start gap-3 mb-4">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center text-xl shadow-soft shrink-0">
                <i class="fas {{ $icon }}"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold truncate group-hover:text-primary-600 transition">{{ $s->name }}</h3>
                <p class="text-xs text-slate-500 mt-0.5"><i class="fas fa-location-dot"></i> {{ $s->city ?: '-' }}{{ $s->province ? ', '.$s->province : '' }}</p>
                <div class="flex gap-2 mt-2">
                    <span class="badge-blue">{{ ucfirst($s->type) }}</span>
                    @if($s->is_active)<span class="badge-green"><i class="fas fa-circle text-[6px]"></i> Aktif</span>
                    @else<span class="badge-red">Nonaktif</span>@endif
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 text-center text-xs gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
            <div>
                <p class="text-lg font-bold text-primary-600">{{ number_format($s->members_count) }}</p>
                <p class="text-slate-500"><i class="fas fa-users"></i> Anggota</p>
            </div>
            <div>
                <p class="text-lg font-bold text-emerald-600">{{ number_format($s->books_count) }}</p>
                <p class="text-slate-500"><i class="fas fa-tablet-screen-button"></i> Digital</p>
            </div>
            <div>
                <p class="text-lg font-bold text-amber-600">{{ number_format($s->offline_books_count) }}</p>
                <p class="text-slate-500"><i class="fas fa-book"></i> Fisik</p>
            </div>
        </div>
    </a>
@empty
    <div class="col-span-full card text-center py-16">
        <i class="fas fa-map-location-dot text-5xl text-slate-300 mb-4"></i>
        <p class="font-semibold text-slate-600">Belum ada Reading Spot</p>
        @can('setting.manage')
        <a href="{{ route('reading-spots.create') }}" class="btn-primary mt-4 inline-flex"><i class="fas fa-plus"></i> Buat Reading Spot Pertama</a>
        @endcan
    </div>
@endforelse
</div>
<div class="mt-6">{{ $spots->links() }}</div>
@endsection
