@extends('layouts.app')
@section('title','Tambah Kategori DDC')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Tambah Kategori DDC',
    'desc'  => 'Tambahkan klasifikasi Dewey Decimal Classification baru.',
    'actions' => [
        ['url' => route('ddc-categories.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])

<form method="POST" action="{{ route('ddc-categories.store') }}" class="card grid grid-cols-1 md:grid-cols-2 gap-4">@csrf
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kode (000, 100, ...)</label>
        <input name="code" required class="form-input mt-1 font-mono">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
        <input name="name" required class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Induk (opsional)</label>
        <select name="parent_id" class="form-select mt-1">
            <option value="">— tidak ada induk</option>
            @foreach($parents as $p)<option value="{{ $p->id }}">{{ $p->code }} — {{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Urutan</label>
        <input type="number" name="order" value="0" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Deskripsi</label>
        <textarea name="description" class="form-textarea mt-1"></textarea>
    </div>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="{{ route('ddc-categories.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
@endsection
