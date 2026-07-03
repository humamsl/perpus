@extends('layouts.app')
@section('title','QR Code Buku')
@section('content')
@php $payload = $book->qr_code ?: ('BOOK:'.$book->isbn); @endphp
<div class="card max-w-md mx-auto text-center shadow-soft" id="print-area">
    <div class="h-12 w-12 mx-auto rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft mb-3 print:hidden">
        <i class="fas fa-qrcode text-lg"></i>
    </div>
    <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $book->title }}</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">ISBN: {{ $book->isbn }}</p>

    <div class="inline-flex flex-col items-center gap-3 p-6 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600">
        <div id="qrcode" class="bg-white p-3 rounded-lg"></div>
        <p class="font-mono text-xs text-slate-500 dark:text-slate-400 break-all max-w-[240px]">{{ $payload }}</p>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-2 print:hidden">
        <a href="{{ route('books.show', $book) }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <button onclick="window.print()" class="btn-primary"><i class="fas fa-print"></i> Cetak</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new QRCode(document.getElementById('qrcode'), {
            text: @json($payload),
            width: 200, height: 200,
            correctLevel: QRCode.CorrectLevel.M
        });
    });
</script>
@endsection
