<?php

namespace App\Http\Controllers;

use App\Imports\OfflineBooksImport;
use App\Models\Author;
use App\Models\BookCategory;
use App\Models\DdcCategory;
use App\Models\OfflineBook;
use App\Models\OfflineBookCopy;
use App\Models\Publisher;
use App\Models\ReadingSpot;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OfflineBookController extends Controller
{
    public function index(Request $r)
    {
        $items = OfflineBook::with(['readingSpot','publisher','ddcCategory','authors'])
            ->when($r->q, fn($q) => $q->where('title', 'like', "%{$r->q}%")
                                       ->orWhere('isbn', 'like', "%{$r->q}%"))
            ->when($r->reading_spot, fn($q) => $q->where('reading_spot_id', $r->reading_spot))
            ->latest()->paginate(20)->withQueryString();
        return view('offline-books.index', [
            'items' => $items,
            'spots' => ReadingSpot::active()->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('offline-books.create', $this->formOptions());
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'reading_spot_id'  => 'required|exists:reading_spots,id',
            'isbn'             => 'nullable|string|max:20',
            'title'            => 'required|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'ddc_category_id'  => 'nullable|exists:ddc_categories,id',
            'year_published'   => 'nullable|integer|between:1500,'.date('Y'),
            'language'         => 'nullable|string|max:10',
            'pages'            => 'nullable|integer|min:1',
            'cover'            => 'nullable|image|max:5120',
            'synopsis'         => 'nullable|string',
            'keywords'         => 'nullable|string|max:255',
            'source'           => 'required|in:purchase,donation,exchange,other',
            'authors'          => 'nullable|array',
            'categories'       => 'nullable|array',
            'initial_copies'   => 'required|integer|min:1|max:100',
        ]);
        if ($r->hasFile('cover')) $data['cover'] = $r->file('cover')->store('offline-books', 'public');

        $copies = (int) $data['initial_copies'];
        unset($data['initial_copies'], $data['authors'], $data['categories']);

        $book = OfflineBook::create($data);
        if ($r->filled('authors'))    $book->authors()->sync($r->authors);
        if ($r->filled('categories')) $book->categories()->sync($r->categories);

        // Generate initial copies dengan catalog_code unik
        $spot = $book->readingSpot;
        for ($i = 1; $i <= $copies; $i++) {
            OfflineBookCopy::create([
                'offline_book_id' => $book->id,
                'reading_spot_id' => $book->reading_spot_id,
                'catalog_code'    => sprintf('%s/%s/%05d', $spot?->slug ?? 'SPT', $book->id, $i),
                'barcode'         => 'OBC' . Str::upper(Str::random(8)),
                'condition'       => 'good',
                'acquired_at'     => now(),
            ]);
        }

        return redirect()->route('offline-books.show', $book)->with('toast', "Buku fisik + $copies kopi dibuat.");
    }

    public function show(OfflineBook $offlineBook)
    {
        $offlineBook->load(['readingSpot','publisher','ddcCategory','authors','categories','copies.shelf']);
        return view('offline-books.show', ['book' => $offlineBook]);
    }

    public function edit(OfflineBook $offlineBook)
    {
        return view('offline-books.edit', ['book' => $offlineBook] + $this->formOptions());
    }

    public function update(Request $r, OfflineBook $offlineBook)
    {
        $data = $r->validate([
            'reading_spot_id'  => 'required|exists:reading_spots,id',
            'isbn'             => 'nullable|string|max:20',
            'title'            => 'required|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'ddc_category_id'  => 'nullable|exists:ddc_categories,id',
            'year_published'   => 'nullable|integer|between:1500,'.date('Y'),
            'language'         => 'nullable|string|max:10',
            'pages'            => 'nullable|integer|min:1',
            'cover'            => 'nullable|image|max:5120',
            'synopsis'         => 'nullable|string',
            'keywords'         => 'nullable|string|max:255',
            'source'           => 'required|in:purchase,donation,exchange,other',
        ]);
        if ($r->hasFile('cover')) {
            if ($offlineBook->cover) Storage::disk('public')->delete($offlineBook->cover);
            $data['cover'] = $r->file('cover')->store('offline-books', 'public');
        }
        $offlineBook->update($data);
        if ($r->filled('authors'))    $offlineBook->authors()->sync($r->authors);
        if ($r->filled('categories')) $offlineBook->categories()->sync($r->categories);

        return back()->with('toast', 'Buku fisik diperbarui.');
    }

    public function destroy(OfflineBook $offlineBook)
    {
        $offlineBook->delete();
        return redirect()->route('offline-books.index')->with('toast', 'Buku fisik dihapus.');
    }

    /** Tambah kopi baru ke buku fisik existing */
    public function addCopy(Request $r, OfflineBook $offlineBook)
    {
        $r->validate([
            'count' => 'required|integer|min:1|max:100',
            'shelf_id' => 'nullable|exists:shelves,id',
            'condition' => 'required|in:new,good,damaged,maintenance',
        ]);
        $spot = $offlineBook->readingSpot;
        $lastSeq = OfflineBookCopy::where('offline_book_id', $offlineBook->id)
            ->count();
        for ($i = 1; $i <= $r->count; $i++) {
            $seq = $lastSeq + $i;
            OfflineBookCopy::create([
                'offline_book_id' => $offlineBook->id,
                'reading_spot_id' => $offlineBook->reading_spot_id,
                'shelf_id'        => $r->shelf_id,
                'catalog_code'    => sprintf('%s/%s/%05d', $spot?->slug ?? 'SPT', $offlineBook->id, $seq),
                'barcode'         => 'OBC' . Str::upper(Str::random(8)),
                'condition'       => $r->condition,
                'acquired_at'     => now(),
            ]);
        }
        return back()->with('toast', "{$r->count} kopi ditambahkan.");
    }

    public function importForm()
    {
        return view('offline-books.import', ['spots' => ReadingSpot::active()->orderBy('name')->get()]);
    }

    public function import(Request $r)
    {
        $r->validate(['file' => 'required|file|mimes:xlsx,xls,csv|max:10240']);

        $import = new OfflineBooksImport();
        Excel::import($import, $r->file('file'));

        return back()
            ->with('toast', "Import selesai: {$import->imported} buku fisik ditambahkan, {$import->skipped} dilewati.")
            ->with('importErrors', $import->errors);
    }

    public function importTemplate()
    {
        $columns = ['reading_spot', 'title', 'subtitle', 'isbn', 'publisher', 'ddc', 'category', 'authors', 'year_published', 'language', 'pages', 'source', 'jumlah', 'synopsis', 'keywords'];
        $spotName = ReadingSpot::active()->orderBy('id')->value('name') ?? 'Nama Reading Spot';
        $sample  = [$spotName, 'Contoh Judul Buku Fisik', '', '', 'Penerbit Contoh', '', 'Fiksi', 'Penulis Satu, Penulis Dua', 2024, 'id', 200, 'purchase', 2, 'Sinopsis singkat.', 'kata kunci, contoh'];

        return response()->streamDownload(function () use ($columns, $sample) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fputcsv($out, $sample);
            fclose($out);
        }, 'template-import-buku-fisik.csv', ['Content-Type' => 'text/csv']);
    }

    protected function formOptions(): array
    {
        return [
            'spots'       => ReadingSpot::active()->orderBy('name')->get(),
            'publishers'  => Publisher::orderBy('name')->get(),
            'ddcs'        => DdcCategory::orderBy('code')->get(),
            'authors'     => Author::orderBy('name')->get(),
            'categories'  => BookCategory::orderBy('name')->get(),
            'shelves'     => Shelf::orderBy('code')->get(),
        ];
    }
}
