@extends('layouts.app')
@section('title','Import Anggota')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-file-import',
    'title' => 'Import Anggota dari Excel',
    'desc'  => 'Unggah file untuk mengimpor data anggota secara massal.',
])

<div class="card max-w-xl">
    <form method="POST" action="{{ route('members.import') }}" enctype="multipart/form-data" class="space-y-4">@csrf
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File Excel (.xlsx)</label>
            <input type="file" name="file" accept=".xlsx,.csv" required class="form-input mt-1">
        </div>
        <div class="flex items-start gap-2 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
            <i class="fas fa-circle-info text-primary-600 dark:text-primary-300 mt-0.5"></i>
            <p class="text-xs text-slate-500 dark:text-slate-400">Format: name, email, password, nis_nip, type, class, major.</p>
        </div>
        <button class="btn-primary"><i class="fas fa-upload"></i> Upload &amp; Import</button>
    </form>
</div>
@endsection
