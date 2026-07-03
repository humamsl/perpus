@extends('layouts.app')
@section('title','Edit Penulis')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-feather-pointed',
    'title' => 'Edit Penulis',
    'desc'  => 'Perbarui data penulis: '.$author->name,
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('authors.update', $author) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required value="{{ $author->name }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nationality</label>
                <input name="nationality" value="{{ $author->nationality }}" class="form-input mt-1">
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Bio</label>
                <textarea name="bio" class="form-textarea mt-1" rows="4">{{ $author->bio }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('authors.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
