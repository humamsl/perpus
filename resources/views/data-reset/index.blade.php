@extends('layouts.app')
@section('title','Reset Data')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-eraser',
    'title' => 'Reset Data',
    'desc'  => 'Hapus semua data transaksi & keanggotaan — data buku dan akun admin tetap dipertahankan.',
])

{{-- Peringatan --}}
<div class="card mb-6 border-0 bg-red-50 dark:bg-red-950/30">
    <div class="flex gap-3 items-start">
        <i class="fas fa-triangle-exclamation text-red-600 text-xl mt-0.5"></i>
        <div class="text-sm text-red-700 dark:text-red-300">
            <p class="font-bold mb-1">Tindakan ini permanen dan tidak bisa dibatalkan.</p>
            <p>Gunakan fitur ini saat menyerahkan aplikasi ke sekolah/instansi baru: seluruh data uji coba
               (anggota, peminjaman, denda, ulasan, log) dibersihkan tanpa menyentuh koleksi buku.
               Disarankan membuat <a href="{{ route('backups.index') }}" class="underline font-semibold">backup database</a> terlebih dahulu.</p>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6 mb-6">
    {{-- Yang dihapus --}}
    <div class="card">
        <h3 class="font-bold text-red-600 dark:text-red-400 mb-3"><i class="fas fa-trash-can mr-1"></i> Akan dihapus</h3>
        <ul class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
            <li class="py-1.5 flex justify-between">
                <span>User non-admin (siswa, guru, staff)</span>
                <span class="font-mono font-semibold">{{ number_format($deletedUsers) }}</span>
            </li>
            @foreach($wipe as $row)
                <li class="py-1.5 flex justify-between">
                    <span>{{ $row['label'] }}</span>
                    <span class="font-mono font-semibold">{{ number_format($row['count']) }}</span>
                </li>
            @endforeach
        </ul>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">
            Statistik pada buku (jumlah dilihat, dipinjam, rating) ikut di-reset ke 0 karena sumber datanya dihapus.
        </p>
    </div>

    {{-- Yang dipertahankan --}}
    <div class="card">
        <h3 class="font-bold text-emerald-600 dark:text-emerald-400 mb-3"><i class="fas fa-shield-halved mr-1"></i> Tetap dipertahankan</h3>
        <ul class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
            <li class="py-1.5 flex justify-between"><span>Akun super admin & admin</span><span class="font-mono font-semibold">{{ number_format($keptUsers) }}</span></li>
            <li class="py-1.5 flex justify-between"><span>Buku digital (beserta file e-book)</span><span class="font-mono font-semibold">{{ number_format($bookCount) }}</span></li>
            <li class="py-1.5 flex justify-between"><span>E-book terlampir</span><span class="font-mono font-semibold">{{ number_format($ebookCount) }}</span></li>
            <li class="py-1.5 flex justify-between"><span>Buku fisik & eksemplarnya</span><span class="font-mono font-semibold">{{ number_format($offlineCount) }}</span></li>
            <li class="py-1.5"><span>Penulis, penerbit, kategori, rak, DDC</span></li>
            <li class="py-1.5"><span>Reading spots & branding (app profile)</span></li>
            <li class="py-1.5"><span>Pengaturan aplikasi, role & permission</span></li>
        </ul>
    </div>
</div>

{{-- Form konfirmasi --}}
<div class="card border border-red-200 dark:border-red-900" x-data="{ phrase: '' }">
    <h3 class="font-bold mb-4 text-slate-800 dark:text-slate-100"><i class="fas fa-lock mr-1"></i> Konfirmasi Reset</h3>
    <form method="POST" action="{{ route('data-reset.run') }}"
          onsubmit="return confirm('YAKIN? Semua data transaksi akan dihapus permanen.')"
          class="space-y-4 max-w-lg">
        @csrf
        <div>
            <label class="text-sm font-medium">Ketik <span class="font-mono font-bold text-red-600">HAPUS SEMUA DATA</span> untuk melanjutkan</label>
            <input name="confirmation" x-model="phrase" autocomplete="off" placeholder="HAPUS SEMUA DATA" class="form-input mt-1">
            @error('confirmation')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Password Anda</label>
            <input type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="form-input mt-1">
            @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <button class="px-4 py-2.5 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed transition"
                :disabled="phrase !== 'HAPUS SEMUA DATA'">
            <i class="fas fa-eraser"></i> Hapus Semua Data Sekarang
        </button>
    </form>
</div>
@endsection
