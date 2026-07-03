@extends('layouts.app')
@section('title','Upload E-Book')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-cloud-arrow-up',
    'title' => 'Upload E-Book',
    'desc'  => 'Tambahkan e-book baru ke koleksi digital.',
    'actions' => [
        ['url' => route('ebooks.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])

<form method="POST" action="{{ route('ebooks.store') }}" enctype="multipart/form-data" class="card grid grid-cols-1 md:grid-cols-2 gap-4">@csrf
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Judul</label>
        <input name="title" required class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Format</label>
        <select name="format" class="form-select mt-1">
            @foreach(['pdf','epub','docx','pptx','audio','video'] as $f)<option value="{{ $f }}">{{ $f }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Akses</label>
        <select name="access" class="form-select mt-1">
            <option value="public">Publik</option><option value="member">Anggota</option><option value="staff">Staff</option>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File</label>
        <input type="file" name="file" required class="form-input mt-1">
    </div>
    <label class="flex items-center gap-2 md:col-span-2 text-sm text-slate-700 dark:text-slate-200">
        <input type="checkbox" name="downloadable" value="1" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500"> Boleh diunduh
    </label>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-upload"></i> Upload</button>
        <a href="{{ route('ebooks.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
@endsection
