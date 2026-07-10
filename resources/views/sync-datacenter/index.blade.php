@extends('layouts.app')
@section('title','Sinkronisasi Data')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-rotate',
    'title' => 'Sinkronisasi Data',
    'desc'  => 'Samakan anggota perpustakaan dengan data siswa & guru dari Data Center.',
])

@if(!$configured)
<div class="card mb-6 border-0 bg-red-50 dark:bg-slate-800">
    <p class="text-sm text-red-700 dark:text-red-300">
        <i class="fas fa-triangle-exclamation"></i> Koneksi database ke Data Center belum bisa dijangkau
        (<span class="font-mono">DB_HOST_SECOND</span> / <span class="font-mono">DB_DATABASE_SECOND</span> dkk di <span class="font-mono">.env</span>).
        Pastikan database Perpus &amp; Data Center berada di server MySQL yang sama, lalu hubungi admin sistem sebelum menjalankan sinkronisasi.
    </p>
</div>
@endif

@php $result = session('syncResult'); @endphp
@if($result)
<div class="grid md:grid-cols-2 gap-4 mb-6">
    <div class="card">
        <div class="flex items-center gap-3 mb-2">
            <div class="h-10 w-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center"><i class="fas fa-user-graduate"></i></div>
            <div>
                <p class="text-xs uppercase text-slate-500 font-semibold">Siswa</p>
                <p class="font-bold text-lg">{{ $result['siswa_ok'] }} / {{ $result['siswa_total'] }} tersinkron</p>
            </div>
        </div>
        @if(count($result['siswa_errors']))
        <ul class="text-xs text-red-600 dark:text-red-400 list-disc list-inside space-y-0.5 mt-2 max-h-40 overflow-y-auto">
            @foreach($result['siswa_errors'] as $err)<li>{{ $err }}</li>@endforeach
        </ul>
        @endif
    </div>
    <div class="card">
        <div class="flex items-center gap-3 mb-2">
            <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="fas fa-chalkboard-user"></i></div>
            <div>
                <p class="text-xs uppercase text-slate-500 font-semibold">Guru</p>
                <p class="font-bold text-lg">{{ $result['guru_ok'] }} / {{ $result['guru_total'] }} tersinkron</p>
            </div>
        </div>
        @if(count($result['guru_errors']))
        <ul class="text-xs text-red-600 dark:text-red-400 list-disc list-inside space-y-0.5 mt-2 max-h-40 overflow-y-auto">
            @foreach($result['guru_errors'] as $err)<li>{{ $err }}</li>@endforeach
        </ul>
        @endif
    </div>
</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <h2 class="font-bold text-lg mb-3"><i class="fas fa-circle-info text-primary-600"></i> Cara Kerja</h2>
            <ul class="text-sm text-slate-600 dark:text-slate-300 space-y-2 list-disc list-inside">
                <li>Menarik <strong>seluruh data siswa &amp; guru aktif</strong> dari Data Center, lalu dicocokkan dengan anggota perpustakaan berdasarkan NISN/NIP.</li>
                <li>Anggota yang <strong>belum ada</strong> akan dibuat baru (role otomatis: siswa &rarr; <span class="font-mono">student</span>, guru &rarr; <span class="font-mono">teacher</span>).</li>
                <li>Anggota yang <strong>sudah ada</strong> akan diperbarui datanya (nama, kelas, jabatan, dll) mengikuti data terbaru dari Data Center.</li>
                <li>Aman dijalankan berkali-kali (idempoten) &mdash; tidak akan membuat data duplikat.</li>
                <li><strong>Password tidak pernah disalin.</strong> Login siswa/guru tetap diverifikasi langsung ke Data Center setiap kali login.</li>
            </ul>
        </div>

        <div class="card border-0 bg-amber-50 dark:bg-slate-800">
            <h2 class="font-bold text-sm text-amber-700 dark:text-amber-300 mb-2"><i class="fas fa-user-shield"></i> Soal akun Admin/Super Admin</h2>
            <p class="text-xs text-amber-700 dark:text-amber-300">
                Sinkronisasi ini hanya menangani <strong>siswa</strong> dan <strong>guru</strong> sebagai anggota perpustakaan.
                Data Center tidak membedakan akun admin secara khusus, jadi promosi ke role Admin/Super Admin tetap dilakukan manual
                setelah sinkron, lewat halaman <a href="{{ route('users.index') }}" class="underline font-semibold">Manajemen User</a>.
            </p>
        </div>

        <div class="card">
            <h2 class="font-bold text-lg mb-2"><i class="fas fa-clock text-primary-600"></i> Otomatisasi (Opsional)</h2>
            <p class="text-sm text-slate-600 dark:text-slate-300">
                Supaya anggota baru di Data Center otomatis terdaftar tanpa perlu klik manual, jadwalkan perintah berikut lewat cron di server (mis. tiap 10 menit):
            </p>
            <code class="block mt-2 text-xs bg-slate-100 dark:bg-slate-900 rounded-lg p-3 font-mono">php artisan datacenter:sync</code>
        </div>
    </div>

    <div class="lg:col-span-1">
        <form method="POST" action="{{ route('sync-datacenter.run') }}" class="card space-y-4 sticky top-20 text-center">
            @csrf
            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center mx-auto text-2xl">
                <i class="fas fa-rotate"></i>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Klik untuk menarik data siswa &amp; guru terbaru dari Data Center sekarang.</p>
            <button class="btn-primary w-full" @disabled(!$configured)>
                <i class="fas fa-play"></i> Jalankan Sinkronisasi Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
