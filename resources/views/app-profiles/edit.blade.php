@extends('layouts.app')
@section('title','Profil Aplikasi')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-building-columns',
    'title' => 'Profil & Branding — '.$readingSpot->name,
    'desc'  => 'Kelola identitas, kontak, dan media sosial aplikasi.',
])

<form method="POST" action="{{ route('app-profiles.update', $readingSpot) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Identitas Aplikasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama Aplikasi</label>
                <input name="app_name" required value="{{ $profile->app_name }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Warna Utama</label>
                <input type="color" name="primary_color" value="{{ $profile->primary_color }}" class="form-input mt-1 h-10">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Warna Sekunder</label>
                <input type="color" name="secondary_color" value="{{ $profile->secondary_color }}" class="form-input mt-1 h-10">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Logo</label>
                <div class="flex items-center gap-3 mt-1">
                    @if($profile->logo)
                        <img src="{{ asset('storage/'.$profile->logo) }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200 dark:ring-slate-700" alt="Logo saat ini">
                    @else
                        <div class="h-12 w-12 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-400"><i class="fas fa-image"></i></div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="form-input flex-1">
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Favicon</label>
                <div class="flex items-center gap-3 mt-1">
                    @if($profile->favicon)
                        <img src="{{ asset('storage/'.$profile->favicon) }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200 dark:ring-slate-700 bg-white" alt="Favicon saat ini">
                    @else
                        <div class="h-12 w-12 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-400"><i class="fas fa-image"></i></div>
                    @endif
                    <input type="file" name="favicon" class="form-input flex-1">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Kontak</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email Kontak</label>
                <input type="email" name="contact_email" value="{{ $profile->contact_email }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Telepon Kontak</label>
                <input name="contact_phone" value="{{ $profile->contact_phone }}" class="form-input mt-1">
            </div>
        </div>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Media Sosial</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Facebook</label>
                <input name="facebook" value="{{ $profile->facebook }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Instagram</label>
                <input name="instagram" value="{{ $profile->instagram }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Twitter</label>
                <input name="twitter" value="{{ $profile->twitter }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">YouTube</label>
                <input name="youtube" value="{{ $profile->youtube }}" class="form-input mt-1">
            </div>
        </div>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Konten & Kebijakan</h2>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tentang</label>
                <textarea name="about" class="form-textarea mt-1" rows="3">{{ $profile->about }}</textarea>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Syarat & Ketentuan</label>
                <textarea name="terms" class="form-textarea mt-1" rows="4">{{ $profile->terms }}</textarea>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kebijakan Privasi</label>
                <textarea name="privacy_policy" class="form-textarea mt-1" rows="4">{{ $profile->privacy_policy }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <button class="btn-primary"><i class="fas fa-save"></i> Simpan Profil</button>
    </div>
</form>
@endsection
