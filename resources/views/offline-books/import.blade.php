@extends('layouts.app')
@section('title','Import Buku Fisik')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-file-import',
    'title' => 'Import Buku Fisik dari Excel',
    'desc'  => 'Unggah file Excel/CSV untuk menambahkan banyak buku fisik sekaligus, lengkap dengan kopi fisiknya.',
    'actions' => [
        ['url' => route('offline-books.import.template'), 'label' => 'Unduh Template', 'class' => 'btn-secondary', 'icon' => 'fa-download'],
        ['url' => route('offline-books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
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

@if($spots->isEmpty())
<div class="card mb-6 border-0 bg-red-50 dark:bg-slate-800">
    <p class="text-sm text-red-700 dark:text-red-300"><i class="fas fa-circle-info"></i> Belum ada Reading Spot aktif. Buat Reading Spot dulu sebelum import, karena setiap buku fisik wajib terhubung ke satu reading spot.</p>
</div>
@endif

<form method="POST" action="{{ route('offline-books.import') }}" enctype="multipart/form-data" class="card space-y-4 max-w-2xl">@csrf
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File Excel (.xlsx)</label>
        <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="form-input mt-1">
    </div>
    <div class="flex items-start gap-3 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
        <i class="fas fa-circle-info text-primary-600 mt-0.5"></i>
        <p class="text-xs text-slate-500 dark:text-slate-400">
            Format kolom (baris pertama = header): <strong>reading_spot, title, subtitle, isbn, publisher, ddc, category, authors, year_published, language, pages, source, jumlah, synopsis, keywords</strong>.
            Kolom <strong>title</strong> dan <strong>reading_spot</strong> (harus persis nama reading spot yang sudah ada) wajib diisi.
            <strong>category</strong>/<strong>authors</strong> bisa lebih dari satu, pisahkan dengan koma — yang belum ada akan dibuat otomatis. <strong>ddc</strong> diisi kode DDC yang sudah ada (kalau tidak ditemukan akan dilewati, buku tetap dibuat).
            <strong>source</strong>: purchase/donation/exchange/other (default purchase). <strong>jumlah</strong> = jumlah kopi fisik yang dibuat (default 1).
            Unduh template di atas untuk contoh lengkap.
        </p>
    </div>
    <button class="btn-primary"><i class="fas fa-upload"></i> Upload &amp; Import</button>
</form>
@endsection
