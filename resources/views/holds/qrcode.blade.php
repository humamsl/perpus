@extends('layouts.app')
@section('title','Kode QR Peminjaman')
@section('content')

<div class="card max-w-md mx-auto text-center shadow-soft" id="print-area">
    <div class="h-12 w-12 mx-auto rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft mb-3 print:hidden">
        <i class="fas fa-qrcode text-lg"></i>
    </div>

    @if($hold->status === 'fulfilled')
        <div class="badge-green mb-3 inline-flex"><i class="fas fa-check"></i> Sudah Dipinjamkan</div>
    @elseif($hold->status === 'cancelled' || $hold->status === 'expired')
        <div class="badge-red mb-3 inline-flex"><i class="fas fa-xmark"></i> {{ ucfirst($hold->status) }}</div>
    @else
        <div class="badge-yellow mb-3 inline-flex"><i class="fas fa-clock"></i> Menunggu Diambil</div>
    @endif

    <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $hold->offlineBookCopies->count() }} Buku Fisik</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">Reading Spot: {{ $hold->readingSpot?->name }}</p>
    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Atas nama: {{ $hold->user?->name }}</p>

    <div class="text-left space-y-1.5 mb-4">
        @foreach($hold->offlineBookCopies as $c)
            <div class="flex items-center gap-2 text-sm rounded-lg bg-slate-50 dark:bg-slate-700/40 px-3 py-2">
                <i class="fas fa-book text-primary-600"></i>
                <span class="truncate">{{ $c->offlineBook?->title }}</span>
                <span class="font-mono text-xs text-slate-400 ml-auto shrink-0">{{ $c->catalog_code }}</span>
            </div>
        @endforeach
    </div>

    <div class="inline-flex flex-col items-center gap-3 p-6 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600">
        <div id="qrcode" class="bg-white p-3 rounded-lg"></div>
        <p class="font-mono text-xs text-slate-500 dark:text-slate-400 break-all max-w-[240px]">{{ $hold->code }}</p>
    </div>

    <div class="mt-5 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3 text-xs text-slate-500 dark:text-slate-400 print:hidden">
        <i class="fas fa-circle-info text-primary-600"></i> Tunjukkan kode QR ini ke petugas perpustakaan untuk mengambil buku Anda.
        @if($hold->expires_at)
            Berlaku sampai {{ $hold->expires_at->translatedFormat('d M Y H:i') }}.
        @endif
    </div>

    <div class="mt-4 grid grid-cols-2 gap-2 print:hidden">
        <a href="{{ route('offline-books.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <button onclick="window.print()" class="btn-primary"><i class="fas fa-print"></i> Cetak</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new QRCode(document.getElementById('qrcode'), {
            text: @json($hold->code),
            width: 200, height: 200,
            correctLevel: QRCode.CorrectLevel.M
        });
    });
</script>
@endsection
