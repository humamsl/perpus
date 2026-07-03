@extends('layouts.app')
@section('title', $ebook->title)
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3 min-w-0">
        <div class="h-10 w-10 shrink-0 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft">
            <i class="fas fa-book-open"></i>
        </div>
        <h1 class="text-lg md:text-xl font-bold text-slate-800 dark:text-slate-100 truncate">{{ $ebook->title }}</h1>
    </div>
    <a href="{{ route('ebooks.index') }}" class="btn-secondary shrink-0"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card p-2 md:p-4">
    @if($ebook->format === 'pdf')
        <iframe src="{{ asset('storage/'.$ebook->file_path) }}" class="w-full h-[70vh] md:h-[80vh] rounded-lg border border-slate-200 dark:border-slate-700"></iframe>
    @elseif($ebook->format === 'audio')
        <audio controls class="w-full"><source src="{{ asset('storage/'.$ebook->file_path) }}"></audio>
    @elseif($ebook->format === 'video')
        <video controls class="w-full max-h-[70vh] md:max-h-[80vh] rounded-lg"><source src="{{ asset('storage/'.$ebook->file_path) }}"></video>
    @else
        <a href="{{ asset('storage/'.$ebook->file_path) }}" class="btn-primary"><i class="fas fa-arrow-up-right-from-square"></i> Buka File ({{ strtoupper($ebook->format) }})</a>
    @endif
</div>
@endsection
