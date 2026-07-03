@extends('layouts.app')
@section('title','Edit User')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-pen',
    'title' => 'Edit User: '.$user->name,
    'desc'  => 'Perbarui data akun dan role pengguna.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required value="{{ $user->name }}" class="form-input mt-1">
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('users.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

<div class="card max-w-3xl mt-6">
    <form method="POST" action="{{ route('users.syncRoles', $user) }}">
        @csrf
        <h2 class="font-bold text-lg mb-4">Role</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
            @foreach($roles as $r)
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="roles[]" value="{{ $r->name }}" @checked($user->hasRole($r->name)) class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    {{ $r->name }}
                </label>
            @endforeach
        </div>
        <div class="mt-6">
            <button class="btn-primary"><i class="fas fa-save"></i> Update Role</button>
        </div>
    </form>
</div>
@endsection
