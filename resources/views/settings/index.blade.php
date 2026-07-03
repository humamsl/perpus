@extends('layouts.app')
@section('title','Pengaturan')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-gear',
    'title' => 'Pengaturan Sistem',
    'desc'  => 'Kelola konfigurasi aplikasi per kelompok pengaturan.',
])

<form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
    @csrf @method('PUT')
    @forelse($settings as $group => $items)
        <div class="card">
            <h2 class="font-bold text-lg uppercase text-sm text-primary-700 dark:text-primary-300 mb-4">{{ $group }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($items as $s)
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $s->label ?? $s->key }}</label>
                    <input name="settings[{{ $s->key }}]" value="{{ $s->value }}" class="form-input mt-1">
                </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="card text-center py-10">
            <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
            <p class="text-slate-500">Tidak ada pengaturan.</p>
        </div>
    @endforelse
    <div class="flex flex-wrap gap-2">
        <button class="btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
    </div>
</form>
@endsection
