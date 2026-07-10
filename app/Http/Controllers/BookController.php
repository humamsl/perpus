<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Imports\BooksImport;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index(Request $r)
    {
        $this->authorize('viewAny', Book::class);
        $books = Book::with(['category','publisher','authors'])
            ->search($r->q)
            ->when($r->category, fn($q) => $q->where('book_category_id', $r->category))
            ->when($r->status,   fn($q) => $q->where('status', $r->status))
            ->orderBy($r->sort ?? 'title', $r->dir ?? 'asc')
            ->paginate(20)->withQueryString();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $this->authorize('create', Book::class);
        return view('books.create', $this->formOptions());
    }

    public function store(StoreBookRequest $r)
    {
        $data = $r->validated();
        $data['available'] = $data['stock'];
        $data['barcode']   = 'BK' . Str::upper(Str::random(8));
        $data['qr_code']   = 'QR-' . Str::random(10);
        if ($r->hasFile('cover')) $data['cover'] = $r->file('cover')->store('books', 'public');
        $authors = $data['authors'] ?? [];
        unset($data['authors']);
        $book = Book::create($data);
        if ($authors) $book->authors()->sync($authors);
        return redirect()->route('books.show', $book)->with('toast', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $this->authorize('view', $book);
        $book->load(['category','publisher','authors','shelf','reviews.user','ebooks']);
        $book->increment('view_count');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $this->authorize('update', $book);
        return view('books.edit', ['book' => $book] + $this->formOptions());
    }

    public function update(UpdateBookRequest $r, Book $book)
    {
        $data = $r->validated();
        if ($r->hasFile('cover')) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $data['cover'] = $r->file('cover')->store('books', 'public');
        }
        $authors = $r->input('authors', []);
        $book->update($data);
        if (is_array($authors)) $book->authors()->sync($authors);
        return back()->with('toast', 'Buku diperbarui.');
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        $book->delete();
        return redirect()->route('books.index')->with('toast', 'Buku dihapus.');
    }

    public function barcode(Book $book) { return view('books.barcode', compact('book')); }
    public function qrcode(Book $book)  { return view('books.qrcode', compact('book')); }
    public function importForm()        { return view('books.import'); }

    public function import(Request $r)
    {
        $r->validate(['file' => 'required|file|mimes:xlsx,xls,csv|max:10240']);

        $import = new BooksImport();
        Excel::import($import, $r->file('file'));

        return back()
            ->with('toast', "Import selesai: {$import->imported} buku ditambahkan, {$import->skipped} dilewati.")
            ->with('importErrors', $import->errors);
    }

    public function importTemplate()
    {
        $columns = ['isbn', 'title', 'subtitle', 'year_published', 'edition', 'language', 'pages', 'stock', 'category', 'publisher', 'authors', 'synopsis', 'keywords'];
        $sample  = ['9780000000001', 'Contoh Judul Buku', '', 2024, '1', 'id', 200, 3, 'Fiksi', 'Penerbit Contoh', 'Penulis Satu, Penulis Dua', 'Sinopsis singkat.', 'kata kunci, contoh'];

        return response()->streamDownload(function () use ($columns, $sample) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fputcsv($out, $sample);
            fclose($out);
        }, 'template-import-buku-digital.csv', ['Content-Type' => 'text/csv']);
    }

    public function export(string $format) { return back()->with('toast', "Export $format: implementasi Maatwebsite\Excel."); }
    public function bulkDelete(Request $r) {
        Book::whereIn('id', $r->input('ids', []))->delete();
        return back()->with('toast', 'Buku terpilih dihapus.');
    }

    protected function formOptions(): array
    {
        return [
            'categories' => \App\Models\BookCategory::orderBy('name')->get(),
            'publishers' => \App\Models\Publisher::orderBy('name')->get(),
            'shelves'    => \App\Models\Shelf::orderBy('code')->get(),
            'authors'    => \App\Models\Author::orderBy('name')->get(),
        ];
    }
}
