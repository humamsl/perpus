@extends('layouts.app')
@section('title','Edit Rak')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-layer-group',
    'title' => 'Edit Rak',
    'desc'  => 'Perbarui data rak: '.$shelf->name,
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('shelves.update', $shelf) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kode</label>
                <input name="code" required value="{{ $shelf->code }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required value="{{ $shelf->name }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lantai</label>
                <input name="floor" value="{{ $shelf->floor }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Ruang</label>
                <input name="room" value="{{ $shelf->room }}" class="form-input mt-1">
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('shelves.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
