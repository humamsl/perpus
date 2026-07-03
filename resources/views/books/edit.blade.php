@extends('layouts.app')
@section('title', 'Edit Buku')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-pen',
    'title' => 'Edit Buku',
    'desc'  => 'Perbarui data buku: '.$book->title,
    'actions' => [
        ['url' => route('books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])
@include('books._form', ['action' => route('books.update', $book), 'method' => 'PUT'])
@endsection
