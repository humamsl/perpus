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

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Reading spot yang tersedia --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-1"><i class="fas fa-map-location-dot text-primary-600"></i> Nama Reading Spot yang Bisa Dipakai</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Kolom <span class="font-mono">reading_spot</span> di file Anda harus persis sama (tidak case-sensitive) dengan salah satu nama berikut:</p>
            <div class="flex flex-wrap gap-2">
                @forelse($spots as $spot)
                    <span class="badge-blue">{{ $spot->name }}</span>
                @empty
                    <span class="text-sm text-red-600">Belum ada reading spot aktif.</span>
                @endforelse
            </div>
        </div>

        {{-- Panduan kolom --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-1"><i class="fas fa-list-check text-primary-600"></i> Panduan Kolom</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Baris pertama file harus berisi nama kolom (header) persis seperti berikut. Urutan kolom bebas.</p>
            <div class="overflow-x-auto -mx-6">
                <table class="table-pretty">
                    <thead><tr><th>Kolom</th><th>Wajib?</th><th>Keterangan</th><th>Contoh</th></tr></thead>
                    <tbody>
                        <tr><td class="font-mono text-xs">reading_spot</td><td><span class="badge-red">Wajib</span></td><td>Nama reading spot yang sudah ada (lihat daftar di atas)</td><td>SMPN 205 Jakarta</td></tr>
                        <tr><td class="font-mono text-xs">title</td><td><span class="badge-red">Wajib</span></td><td>Judul buku</td><td>Atlas Dunia</td></tr>
                        <tr><td class="font-mono text-xs">subtitle</td><td><span class="badge-gray">Opsional</span></td><td>Sub judul</td><td>&mdash;</td></tr>
                        <tr><td class="font-mono text-xs">isbn</td><td><span class="badge-gray">Opsional</span></td><td>Boleh dikosongkan (beda dgn buku digital, di sini tidak wajib unik)</td><td>&mdash;</td></tr>
                        <tr><td class="font-mono text-xs">publisher</td><td><span class="badge-gray">Opsional</span></td><td>Nama penerbit &mdash; dibuat otomatis kalau belum ada</td><td>Gramedia</td></tr>
                        <tr><td class="font-mono text-xs">ddc</td><td><span class="badge-gray">Opsional</span></td><td>Kode DDC yang <strong>sudah ada</strong> (tidak dibuat otomatis; kalau tidak ketemu, dilewati saja kolom ini)</td><td>900</td></tr>
                        <tr><td class="font-mono text-xs">category</td><td><span class="badge-gray">Opsional</span></td><td>Nama kategori, pisahkan koma untuk lebih dari satu &mdash; dibuat otomatis</td><td>Sejarah, Geografi</td></tr>
                        <tr><td class="font-mono text-xs">authors</td><td><span class="badge-gray">Opsional</span></td><td>Nama penulis, pisahkan koma &mdash; dibuat otomatis</td><td>Tere Liye</td></tr>
                        <tr><td class="font-mono text-xs">year_published</td><td><span class="badge-gray">Opsional</span></td><td>Tahun terbit</td><td>2020</td></tr>
                        <tr><td class="font-mono text-xs">language</td><td><span class="badge-gray">Opsional</span></td><td>Kode bahasa</td><td>id</td></tr>
                        <tr><td class="font-mono text-xs">pages</td><td><span class="badge-gray">Opsional</span></td><td>Jumlah halaman</td><td>150</td></tr>
                        <tr><td class="font-mono text-xs">source</td><td><span class="badge-gray">Opsional</span></td><td>purchase / donation / exchange / other (default purchase)</td><td>donation</td></tr>
                        <tr><td class="font-mono text-xs">jumlah</td><td><span class="badge-gray">Opsional</span></td><td>Jumlah kopi fisik yang dibuat sekaligus (default 1)</td><td>3</td></tr>
                        <tr><td class="font-mono text-xs">synopsis</td><td><span class="badge-gray">Opsional</span></td><td>Ringkasan buku</td><td>&mdash;</td></tr>
                        <tr><td class="font-mono text-xs">keywords</td><td><span class="badge-gray">Opsional</span></td><td>Kata kunci pencarian, pisahkan koma</td><td>peta, dunia</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Contoh baris data --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-1"><i class="fas fa-table text-primary-600"></i> Contoh Isi File</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Begini kira-kira isi spreadsheet-nya setelah header.</p>
            <div class="overflow-x-auto -mx-6">
                <table class="table-pretty text-xs">
                    <thead><tr><th>reading_spot</th><th>title</th><th>publisher</th><th>category</th><th>source</th><th>jumlah</th></tr></thead>
                    <tbody>
                        <tr>
                            <td>{{ $spots->first()->name ?? 'SMPN 205 Jakarta' }}</td>
                            <td>Atlas Dunia</td><td>Gramedia</td><td>Geografi</td><td>purchase</td><td>2</td>
                        </tr>
                        <tr>
                            <td>{{ $spots->first()->name ?? 'SMPN 205 Jakarta' }}</td>
                            <td>Sejarah Nusantara</td><td>Balai Pustaka</td><td>Sejarah, Referensi</td><td>donation</td><td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Baris kedua menunjukkan <span class="font-mono">category</span> lebih dari satu &mdash; dipisah dengan koma, akan otomatis tercatat ke dua kategori sekaligus.</p>
        </div>

        {{-- Langkah-langkah --}}
        <div class="card">
            <h2 class="font-bold text-lg mb-4"><i class="fas fa-shoe-prints text-primary-600"></i> Langkah Import</h2>
            <ol class="space-y-2 text-sm list-decimal list-inside text-slate-600 dark:text-slate-300">
                <li>Klik <strong>Unduh Template</strong> di pojok kanan atas, lalu isi baris-baris data di bawah header (jangan ubah nama kolomnya).</li>
                <li>Pastikan <strong>reading_spot</strong> diisi persis sama dengan salah satu nama di daftar atas &mdash; ini kolom yang paling sering salah ketik.</li>
                <li>Simpan file dalam format <span class="font-mono">.xlsx</span> atau <span class="font-mono">.csv</span>.</li>
                <li>Unggah file lewat form di samping, lalu klik <strong>Upload &amp; Import</strong>.</li>
                <li>Cek ringkasan hasil import &mdash; baris yang dilewati (reading spot tidak ditemukan, judul kosong, dll) akan disebutkan alasannya, kopi fisik otomatis dibuat sejumlah kolom <span class="font-mono">jumlah</span>.</li>
            </ol>
        </div>
    </div>

    {{-- Form upload --}}
    <div class="lg:col-span-1">
        <form method="POST" action="{{ route('offline-books.import') }}" enctype="multipart/form-data" class="card space-y-4 sticky top-20">@csrf
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
