<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookActivityLog;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $r)
    {
        $books = Book::with(['authors','category'])
            ->search($r->q)
            ->when($r->category, fn($q) => $q->where('book_category_id', $r->category))
            ->when($r->author,   fn($q) => $q->whereHas('authors', fn($a) => $a->where('authors.id', $r->author)))
            ->when($r->year,     fn($q) => $q->where('year_published', $r->year))
            ->when($r->language, fn($q) => $q->where('language', $r->language))
            ->orderBy(match ($r->sort) {
                'newest'  => 'created_at',
                'popular' => 'borrow_count',
                default   => 'title',
            }, $r->sort === 'title' || $r->sort === null ? 'asc' : 'desc')
            ->paginate(24)->withQueryString();

        return view('catalog.index', [
            'books'      => $books,
            'categories' => BookCategory::orderBy('name')->get(),
        ]);
    }

    public function show(Book $book)
    {
        $book->load(['authors','category','publisher','reviews.user','ebooks','shelf']);
        $book->increment('view_count');
        BookActivityLog::logView($book);
        return view('catalog.show', compact('book'));
    }
}
