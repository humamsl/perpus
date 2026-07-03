@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-pen',
    'title' => 'Edit Anggota',
    'desc'  => 'Perbarui data keanggotaan.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('members.update', $member) }}">@csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kelas</label><input name="class" value="{{ $member->class }}" class="form-input mt-1"></div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Jurusan</label><input name="major" value="{{ $member->major }}" class="form-input mt-1"></div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat</label>
                <textarea name="address" class="form-textarea mt-1" rows="2">{{ $member->address }}</textarea>
            </div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Berlaku Hingga</label><input type="date" name="expires_at" value="{{ $member->expires_at?->format('Y-m-d') }}" class="form-input mt-1"></div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Aktif</label>
                <select name="is_active" class="form-select mt-1">
                    <option value="1" @selected($member->is_active)>Aktif</option>
                    <option value="0" @selected(!$member->is_active)>Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-6">
            <button class="btn-primary"><i class="fas fa-check"></i> Simpan</button>
            <a href="{{ route('members.show', $member) }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
