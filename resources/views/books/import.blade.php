@extends('layouts.app')
@section('title','Import Buku')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-file-import',
    'title' => 'Import Buku dari Excel',
    'desc'  => 'Unggah file Excel/CSV untuk menambahkan banyak buku sekaligus.',
    'actions' => [
        ['url' => route('books.import.template'), 'label' => 'Unduh Template', 'class' => 'btn-secondary', 'icon' => 'fa-download'],
        ['url' => route('books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])

@if(session('importErrors') && count(session('importErrors')))
<div class="card mb-6 border-0 bg-amber-50 dark:bg-slate-800">
    <p class="font-semibold text-amber-700 dark:text-amber-300 mb-2"><i class="fas fa-triangle-exclamation"></i> Catatan import ({{ count(session('importErrors')) }})</p>
    <ul class="text-sm text-amber-700 dark:text-amber-300 list-disc list-inside space-y-1">
        @foreach(session('importErrors') as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('books.import') }}" enctype="multipart/form-data" class="card space-y-4 max-w-2xl">@csrf
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File Excel (.xlsx)</label>
        <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="form-input mt-1">
    </div>
    <div class="flex items-start gap-3 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
        <i class="fas fa-circle-info text-primary-600 mt-0.5"></i>
        <p class="text-xs text-slate-500 dark:text-slate-400">
            Format kolom (baris pertama = header): <strong>isbn, title, subtitle, year_published, edition, language, pages, stock, category, publisher, authors, synopsis, keywords</strong>.
            Kolom <strong>title</strong> wajib diisi. <strong>authors</strong> bisa lebih dari satu, pisahkan dengan koma. Kategori &amp; penerbit yang belum ada akan dibuat otomatis. ISBN yang kosong akan digenerate otomatis.
            Unduh template di atas untuk contoh lengkap.
        </p>
    </div>
    <button class="btn-primary"><i class="fas fa-upload"></i> Upload &amp; Import</button>
</form>
@endsection
