@extends('layouts.app')
@section('title','Peminjaman Baru')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Peminjaman Baru',
    'desc'  => 'Buat transaksi peminjaman buku digital untuk anggota.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('borrows.store') }}">@csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Anggota</label>
                <select name="member_id" required class="form-select mt-1">
                    <option value="">Pilih anggota...</option>
                    @foreach($members as $m)<option value="{{ $m->id }}">{{ $m->member_no }} — {{ $m->user?->name }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Buku</label>
                <select name="book_id" required class="form-select mt-1">
                    <option value="">Pilih buku...</option>
                    @foreach($books as $b)<option value="{{ $b->id }}">{{ $b->title }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lama Pinjam (hari)</label>
                <input type="number" name="days" value="{{ config('library.default_loan_days') }}" min="1" max="30" class="form-input mt-1">
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Catatan</label>
                <textarea name="notes" class="form-textarea mt-1" rows="3"></textarea>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-6">
            <button class="btn-primary"><i class="fas fa-check"></i> Simpan</button>
            <a href="{{ route('borrows.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
