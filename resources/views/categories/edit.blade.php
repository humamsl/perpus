@extends('layouts.app')
@section('title','Edit Kategori')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-pen',
    'title' => 'Edit Kategori',
    'desc'  => 'Perbarui data kategori: '.$category->name,
    'actions' => [
        ['url' => route('categories.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])

<form method="POST" action="{{ route('categories.update', $category) }}" class="card grid grid-cols-1 md:grid-cols-2 gap-4">@csrf @method('PUT')
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
        <input name="name" required value="{{ $category->name }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kode Dewey</label>
        <input name="dewey_code" value="{{ $category->dewey_code }}" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Deskripsi</label>
        <textarea name="description" class="form-textarea mt-1">{{ $category->description }}</textarea>
    </div>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
@endsection
