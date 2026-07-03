@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Tambah Buku',
    'desc'  => 'Tambahkan judul buku baru ke koleksi digital perpustakaan.',
    'actions' => [
        ['url' => route('books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])
@include('books._form', ['action' => route('books.store'), 'method' => 'POST'])
@endsection
