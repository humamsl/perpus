@extends('layouts.app')
@section('title','Tambah Rak')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-layer-group',
    'title' => 'Tambah Rak',
    'desc'  => 'Tambahkan data rak buku baru.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('shelves.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kode</label>
                <input name="code" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lantai</label>
                <input name="floor" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Ruang</label>
                <input name="room" class="form-input mt-1">
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('shelves.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
