@extends('layouts.app')
@section('title', 'Tambah Anggota')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-plus',
    'title' => 'Tambah Anggota',
    'desc'  => 'Daftarkan anggota baru perpustakaan.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('members.store') }}">@csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label><input name="name" required class="form-input mt-1"></div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label><input type="email" name="email" required class="form-input mt-1"></div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label><input type="password" name="password" required class="form-input mt-1"></div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi</label><input type="password" name="password_confirmation" required class="form-input mt-1"></div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">NIS/NIP</label><input name="nis_nip" class="form-input mt-1"></div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tipe</label>
                <select name="type" class="form-select mt-1">
                    <option value="student">Siswa</option><option value="teacher">Guru</option><option value="staff">Staff</option><option value="public">Umum</option>
                </select>
            </div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kelas</label><input name="class" class="form-input mt-1"></div>
            <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Jurusan</label><input name="major" class="form-input mt-1"></div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat</label>
                <textarea name="address" class="form-textarea mt-1" rows="2"></textarea>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-6">
            <button class="btn-primary"><i class="fas fa-check"></i> Simpan</button>
            <a href="{{ route('members.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
