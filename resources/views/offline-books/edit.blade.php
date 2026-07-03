@extends('layouts.app')
@section('title','Edit Buku Fisik')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-pen',
    'title' => 'Edit Buku Fisik',
    'desc'  => 'Perbarui data buku fisik: '.$book->title,
    'actions' => [
        ['url' => route('offline-books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])
@include('offline-books._form', ['action' => route('offline-books.update', $book), 'method' => 'PUT'])
@endsection
