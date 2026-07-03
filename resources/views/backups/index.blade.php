@extends('layouts.app')
@section('title','Backup Database')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-database',
    'title' => 'Backup Database',
    'desc'  => 'Kelola dan unduh cadangan database aplikasi.',
])

<div class="flex justify-end mb-4">
    <form method="POST" action="{{ route('backups.run') }}">
        @csrf
        <button class="btn-primary"><i class="fas fa-circle-plus"></i> Buat Backup Sekarang</button>
    </form>
</div>

<div class="card overflow-x-auto">
    <p class="text-sm text-slate-500 dark:text-slate-400">
        <i class="fas fa-circle-info"></i>
        Fitur backup memerlukan paket <code class="font-mono text-xs bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded">spatie/laravel-backup</code> dan konfigurasi storage. Lihat README.
    </p>
</div>
@endsection
