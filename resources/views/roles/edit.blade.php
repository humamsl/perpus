@extends('layouts.app')
@section('title','Edit Role')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-shield-halved',
    'title' => 'Edit Role: '.$role->name,
    'desc'  => 'Perbarui nama role dan hak aksesnya.',
])

<div class="card max-w-4xl">
    <form method="POST" action="{{ route('roles.update', $role) }}">
        @csrf @method('PUT')
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama Role</label>
            <input name="name" required value="{{ $role->name }}" class="form-input mt-1 max-w-sm">
        </div>
        <div class="mt-6">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200 block mb-2">Permissions</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                @foreach($permissions as $p)
                    <label class="flex items-center gap-2 text-xs">
                        <input type="checkbox" name="permissions[]" value="{{ $p->name }}" @checked($role->permissions->contains('name', $p->name)) class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                        {{ $p->name }}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('roles.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
