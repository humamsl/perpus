<?php

namespace App\Imports;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Publisher;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public int $skipped = 0;

    /** @var array<int,string> */
    public array $errors = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $line = $i + 2; // baris 1 = header

            $title = trim((string) ($row['title'] ?? ''));
            if ($title === '') {
                $this->skipped++;
                $this->errors[] = "Baris {$line}: kolom title kosong, dilewati.";
                continue;
            }

            $isbn = trim((string) ($row['isbn'] ?? ''));
            if ($isbn === '') {
                $isbn = 'IMP-' . Str::upper(Str::random(10));
            } elseif (Book::where('isbn', $isbn)->exists()) {
                $this->skipped++;
                $this->errors[] = "Baris {$line}: ISBN '{$isbn}' sudah terdaftar, dilewati.";
                continue;
            }

            $category = null;
            if ($name = trim((string) ($row['category'] ?? ''))) {
                $slug = Str::slug($name);
                $category = BookCategory::where('slug', $slug)->first()
                    ?? BookCategory::create(['name' => $name, 'slug' => $slug]);
            }

            $publisher = null;
            if ($name = trim((string) ($row['publisher'] ?? ''))) {
                $slug = Str::slug($name);
                $publisher = Publisher::where('slug', $slug)->first()
                    ?? Publisher::create(['name' => $name, 'slug' => $slug]);
            }

            $stock = (int) ($row['stock'] ?? 1);
            if ($stock < 1) $stock = 1;

            $book = Book::create([
                'isbn'             => $isbn,
                'title'            => $title,
                'subtitle'         => trim((string) ($row['subtitle'] ?? '')) ?: null,
                'publisher_id'     => $publisher?->id,
                'book_category_id' => $category?->id,
                'year_published'   => $row['year_published'] ?? null,
                'edition'          => trim((string) ($row['edition'] ?? '')) ?: null,
                'language'         => trim((string) ($row['language'] ?? '')) ?: null,
                'pages'            => $row['pages'] ?? null,
                'synopsis'         => trim((string) ($row['synopsis'] ?? '')) ?: null,
                'keywords'         => trim((string) ($row['keywords'] ?? '')) ?: null,
                'stock'            => $stock,
                'available'        => $stock,
                'barcode'          => 'BK' . Str::upper(Str::random(8)),
                'qr_code'          => 'QR-' . Str::random(10),
            ]);

            $authorNames = trim((string) ($row['authors'] ?? ''));
            if ($authorNames !== '') {
                $authorIds = collect(explode(',', $authorNames))
                    ->map(fn ($n) => trim($n))
                    ->filter()
                    ->map(function ($name) {
                        $slug = Str::slug($name);
                        return (Author::where('slug', $slug)->first()
                            ?? Author::create(['name' => $name, 'slug' => $slug]))->id;
                    });
                $book->authors()->sync($authorIds);
            }

            $this->imported++;
        }
    }
}
