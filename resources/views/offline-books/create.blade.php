@extends('layouts.app')
@section('title','Tambah Buku Fisik')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Tambah Buku Fisik',
    'desc'  => 'Tambahkan judul buku fisik baru ke koleksi.',
    'actions' => [
        ['url' => route('offline-books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])
@include('offline-books._form', ['action' => route('offline-books.store'), 'method' => 'POST'])
@endsection
