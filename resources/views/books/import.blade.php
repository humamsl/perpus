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

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Panduan kolom --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-1"><i class="fas fa-list-check text-primary-600"></i> Panduan Kolom</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Baris pertama file harus berisi nama kolom (header) persis seperti berikut. Urutan kolom bebas.</p>
            <div class="overflow-x-auto -mx-6">
                <table class="table-pretty">
                    <thead><tr><th>Kolom</th><th>Wajib?</th><th>Keterangan</th><th>Contoh</th></tr></thead>
                    <tbody>
                        <tr><td class="font-mono text-xs">title</td><td><span class="badge-red">Wajib</span></td><td>Judul buku</td><td>Laskar Pelangi</td></tr>
                        <tr><td class="font-mono text-xs">isbn</td><td><span class="badge-gray">Opsional</span></td><td>Kosongkan untuk digenerate otomatis</td><td>9789793062792</td></tr>
                        <tr><td class="font-mono text-xs">subtitle</td><td><span class="badge-gray">Opsional</span></td><td>Sub judul</td><td>&mdash;</td></tr>
                        <tr><td class="font-mono text-xs">year_published</td><td><span class="badge-gray">Opsional</span></td><td>Tahun terbit</td><td>2005</td></tr>
                        <tr><td class="font-mono text-xs">edition</td><td><span class="badge-gray">Opsional</span></td><td>Edisi/cetakan</td><td>Cetakan ke-3</td></tr>
                        <tr><td class="font-mono text-xs">language</td><td><span class="badge-gray">Opsional</span></td><td>Kode bahasa</td><td>id</td></tr>
                        <tr><td class="font-mono text-xs">pages</td><td><span class="badge-gray">Opsional</span></td><td>Jumlah halaman</td><td>248</td></tr>
                        <tr><td class="font-mono text-xs">category</td><td><span class="badge-gray">Opsional</span></td><td>Nama kategori &mdash; dibuat otomatis kalau belum ada</td><td>Fiksi</td></tr>
                        <tr><td class="font-mono text-xs">publisher</td><td><span class="badge-gray">Opsional</span></td><td>Nama penerbit &mdash; dibuat otomatis kalau belum ada</td><td>Bentang Pustaka</td></tr>
                        <tr><td class="font-mono text-xs">authors</td><td><span class="badge-gray">Opsional</span></td><td>Nama penulis, pisahkan dengan <strong>koma</strong> kalau lebih dari satu &mdash; dibuat otomatis</td><td>Andrea Hirata</td></tr>
                        <tr><td class="font-mono text-xs">synopsis</td><td><span class="badge-gray">Opsional</span></td><td>Ringkasan/sinopsis buku</td><td>&mdash;</td></tr>
                        <tr><td class="font-mono text-xs">keywords</td><td><span class="badge-gray">Opsional</span></td><td>Kata kunci pencarian, pisahkan koma</td><td>pendidikan, motivasi</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Contoh baris data --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-1"><i class="fas fa-table text-primary-600"></i> Contoh Isi File</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Begini kira-kira isi spreadsheet-nya setelah header (untuk kolom yang tidak muat, kolom lain di sebelah kanan disembunyikan).</p>
            <div class="overflow-x-auto -mx-6">
                <table class="table-pretty text-xs">
                    <thead><tr><th>isbn</th><th>title</th><th>category</th><th>publisher</th><th>authors</th></tr></thead>
                    <tbody>
                        <tr><td class="font-mono">9789793062792</td><td>Laskar Pelangi</td><td>Fiksi</td><td>Bentang Pustaka</td><td>Andrea Hirata</td></tr>
                        <tr><td class="font-mono text-slate-400 italic">(kosong)</td><td>Bumi Manusia</td><td>Sejarah</td><td>Hasta Mitra</td><td>Pramoedya Ananta Toer</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Baris kedua sengaja mengosongkan <span class="font-mono">isbn</span> &mdash; sistem akan membuatkan ISBN sementara otomatis untuk buku itu.</p>
        </div>

        {{-- Langkah-langkah --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-4"><i class="fas fa-shoe-prints text-primary-600"></i> Langkah Import</h2>
            <ol class="space-y-2 text-sm list-decimal list-inside text-slate-600 dark:text-slate-300">
                <li>Klik <strong>Unduh Template</strong> di pojok kanan atas, lalu isi baris-baris data di bawah header (jangan ubah nama kolomnya).</li>
                <li>Kosongkan kolom yang tidak Anda punya datanya &mdash; hanya <strong>title</strong> yang wajib diisi.</li>
                <li>Simpan file dalam format <span class="font-mono">.xlsx</span> atau <span class="font-mono">.csv</span>.</li>
                <li>Unggah file lewat form di samping, lalu klik <strong>Upload &amp; Import</strong>.</li>
                <li>Cek ringkasan hasil import setelah selesai &mdash; baris yang dilewati (ISBN duplikat, judul kosong, dll) akan disebutkan alasannya.</li>
            </ol>
        </div>
    </div>

    {{-- Form upload --}}
    <div class="lg:col-span-1">
        <form method="POST" action="{{ route('books.import') }}" enctype="multipart/form-data" class="card space-y-4 sticky top-20">@csrf
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File Excel / CSV</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="form-input mt-1">
            </div>
            <div class="flex items-start gap-3 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
                <i class="fas fa-circle-info text-primary-600 mt-0.5"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400">Belum punya file? Unduh template di pojok kanan atas dulu, lengkap dengan contoh isi.</p>
            </div>
            <button class="btn-primary w-full"><i class="fas fa-upload"></i> Upload &amp; Import</button>
        </form>
    </div>
</div>
@endsection
