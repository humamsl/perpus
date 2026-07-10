@extends('layouts.app')
@section('title','Edit Reading Spot')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-map-location-dot',
    'title' => 'Edit Reading Spot',
    'desc'  => 'Perbarui informasi lokasi/spot baca.',
])

<div class="card">
    <form method="POST" action="{{ route('reading-spots.update', $spot) }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">@csrf @method('PUT')
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
            <input name="name" required value="{{ $spot->name }}" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tipe</label>
            <select name="type" class="form-select mt-1">
                @foreach(['school'=>'Sekolah','library'=>'Perpustakaan','community'=>'Komunitas','public'=>'Umum'] as $v=>$t)
                    <option value="{{ $v }}" @selected($spot->type===$v)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">NPSN</label>
            <input name="npsn" value="{{ $spot->npsn }}" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kota</label>
            <input name="city" value="{{ $spot->city }}" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Provinsi</label>
            <input name="province" value="{{ $spot->province }}" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Telepon</label>
            <input name="phone" value="{{ $spot->phone }}" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
            <input type="email" name="email" value="{{ $spot->email }}" class="form-input mt-1">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Status</label>
            <select name="is_active" class="form-select mt-1">
                <option value="1" @selected($spot->is_active)>Aktif</option>
                <option value="0" @selected(!$spot->is_active)>Nonaktif</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat</label>
            <textarea name="address" class="form-textarea mt-1" rows="2">{{ $spot->address }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Deskripsi</label>
            <textarea name="description" class="form-textarea mt-1" rows="3">{{ $spot->description }}</textarea>
        </div>

        @include('partials.location-picker', ['latitude' => $spot->latitude, 'longitude' => $spot->longitude])

        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Logo baru</label>
            <input type="file" name="logo" accept="image/*" class="form-input mt-1">
        </div>
        <div class="md:col-span-2 flex gap-2 pt-2">
            <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
            <a href="{{ route('reading-spots.show', $spot) }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
