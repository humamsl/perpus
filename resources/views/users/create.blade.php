@extends('layouts.app')
@section('title','Tambah User')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-plus',
    'title' => 'Tambah User',
    'desc'  => 'Buat akun pengguna baru beserta rolenya.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                <input type="email" name="email" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                <input type="password" name="password" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Role</label>
                <select name="role" class="form-select mt-1" required>
                    @foreach($roles as $r)<option value="{{ $r->name }}">{{ $r->name }}</option>@endforeach
                </select>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('users.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
