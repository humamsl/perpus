@extends('layouts.app')
@section('title','E-Book')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-tablet-screen-button',
    'title' => 'Koleksi E-Book',
    'desc'  => 'Kelola e-book digital perpustakaan.',
    'actions' => [
        ['url' => route('ebooks.create'), 'label' => 'Upload E-Book', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
])

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-8 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="{{ request('q') }}" placeholder="Cari e-book..." class="form-input pl-10">
        </div>
        <select name="format" class="form-input md:col-span-2">
            <option value="">Semua</option>
            @foreach(['pdf','epub','docx','pptx','audio','video'] as $f)<option value="{{ $f }}" @selected(request('format')===$f)>{{ $f }}</option>@endforeach
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($items as $e)
        <a href="{{ route('ebooks.read', $e) }}" class="group">
            <div class="card-tight hover:shadow-hover transition group-hover:-translate-y-1">
                <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <i class="fas fa-tablet-screen-button text-4xl text-primary-600"></i>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition">{{ $e->title }}</p>
                <p class="text-xs text-slate-500 mt-1 uppercase">{{ $e->format }}</p>
                <p class="text-xs text-slate-500 mt-1"><i class="fas fa-eye"></i> {{ $e->view_count }} pembaca</p>
            </div>
        </a>
    @empty
        <div class="col-span-full card text-center py-16">
            <i class="fas fa-inbox text-5xl text-slate-300 mb-4"></i>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Belum ada e-book.</p>
        </div>
    @endforelse
</div>
<div class="mt-6">{{ $items->links() }}</div>
@endsection
