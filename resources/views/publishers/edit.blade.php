@extends('layouts.app')
@section('title','Edit Penerbit')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-building',
    'title' => 'Edit Penerbit',
    'desc'  => 'Perbarui data penerbit: '.$publisher->name,
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('publishers.update', $publisher) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required value="{{ $publisher->name }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kota</label>
                <input name="city" value="{{ $publisher->city }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Negara</label>
                <input name="country" value="{{ $publisher->country }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Website</label>
                <input name="website" type="url" value="{{ $publisher->website }}" class="form-input mt-1">
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat</label>
                <textarea name="address" class="form-textarea mt-1" rows="3">{{ $publisher->address }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('publishers.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
