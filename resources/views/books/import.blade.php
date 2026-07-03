@extends('layouts.app')
@section('title','Import Buku')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-file-import',
    'title' => 'Import Buku dari Excel',
    'desc'  => 'Unggah file Excel/CSV untuk menambahkan banyak buku sekaligus.',
    'actions' => [
        ['url' => route('books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])

<form method="POST" action="{{ route('books.import') }}" enctype="multipart/form-data" class="card space-y-4 max-w-2xl">@csrf
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File Excel (.xlsx)</label>
        <input type="file" name="file" accept=".xlsx,.csv" required class="form-input mt-1">
    </div>
    <div class="flex items-start gap-3 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
        <i class="fas fa-circle-info text-primary-600 mt-0.5"></i>
        <p class="text-xs text-slate-500 dark:text-slate-400">Format kolom: isbn, title, subtitle, year_published, stock, category, publisher, language, pages, synopsis, keywords.</p>
    </div>
    <button class="btn-primary"><i class="fas fa-upload"></i> Upload &amp; Import</button>
</form>
@endsection
