@extends('layouts.app')
@section('title','Tambah Reading Spot')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-map-location-dot',
    'title' => 'Tambah Reading Spot',
    'desc'  => 'Daftarkan lokasi/spot baca baru ke jaringan perpustakaan.',
])

<div class="card">
    <form method="POST" action="{{ route('reading-spots.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">@csrf
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
            <input name="name" required class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tipe</label>
            <select name="type" class="form-select mt-1">
                <option value="school">Sekolah</option>
                <option value="library">Perpustakaan</option>
                <option value="community">Komunitas</option>
                <option value="public">Umum</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">NPSN (jika sekolah)</label>
            <input name="npsn" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kota</label>
            <input name="city" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Provinsi</label>
            <input name="province" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Telepon</label>
            <input name="phone" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
            <input type="email" name="email" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Logo</label>
            <input type="file" name="logo" accept="image/*" class="form-input mt-1">
        </div>
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat</label>
            <textarea name="address" class="form-textarea mt-1" rows="2"></textarea>
        </div>
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Deskripsi</label>
            <textarea name="description" class="form-textarea mt-1" rows="3"></textarea>
        </div>
        <div class="md:col-span-2 flex gap-2 pt-2">
            <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
            <a href="{{ route('reading-spots.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
