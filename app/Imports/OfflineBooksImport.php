<?php

namespace App\Imports;

use App\Models\Author;
use App\Models\BookCategory;
use App\Models\DdcCategory;
use App\Models\OfflineBook;
use App\Models\OfflineBookCopy;
use App\Models\Publisher;
use App\Models\ReadingSpot;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OfflineBooksImport implements ToCollection, WithHeadingRow
{
    private const SOURCES = ['purchase', 'donation', 'exchange', 'other'];

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

            $spotName = trim((string) ($row['reading_spot'] ?? ''));
            $spot = $spotName !== ''
                ? ReadingSpot::where('name', 'like', $spotName)->first()
                : null;
            if (!$spot) {
                $this->skipped++;
                $this->errors[] = "Baris {$line}: reading_spot '{$spotName}' tidak ditemukan, dilewati.";
                continue;
            }

            $publisher = null;
            if ($name = trim((string) ($row['publisher'] ?? ''))) {
                $slug = Str::slug($name);
                $publisher = Publisher::where('slug', $slug)->first()
                    ?? Publisher::create(['name' => $name, 'slug' => $slug]);
            }

            $ddc = null;
            if ($code = trim((string) ($row['ddc'] ?? ''))) {
                $ddc = DdcCategory::where('code', $code)->first();
                if (!$ddc) {
                    $this->errors[] = "Baris {$line}: kode DDC '{$code}' tidak ditemukan, dilewati kolom ini (buku tetap dibuat).";
                }
            }

            $source = strtolower(trim((string) ($row['source'] ?? '')));
            if (!in_array($source, self::SOURCES, true)) $source = 'purchase';

            $book = OfflineBook::create([
                'reading_spot_id' => $spot->id,
                'isbn'            => trim((string) ($row['isbn'] ?? '')) ?: null,
                'title'           => $title,
                'subtitle'        => trim((string) ($row['subtitle'] ?? '')) ?: null,
                'publisher_id'    => $publisher?->id,
                'ddc_category_id' => $ddc?->id,
                'year_published'  => $row['year_published'] ?? null,
                'language'        => trim((string) ($row['language'] ?? '')) ?: null,
                'pages'           => $row['pages'] ?? null,
                'synopsis'        => trim((string) ($row['synopsis'] ?? '')) ?: null,
                'keywords'        => trim((string) ($row['keywords'] ?? '')) ?: null,
                'source'          => $source,
            ]);

            $categoryNames = trim((string) ($row['category'] ?? ''));
            if ($categoryNames !== '') {
                $categoryIds = collect(explode(',', $categoryNames))
                    ->map(fn ($n) => trim($n))
                    ->filter()
                    ->map(function ($name) {
                        $slug = Str::slug($name);
                        return (BookCategory::where('slug', $slug)->first()
                            ?? BookCategory::create(['name' => $name, 'slug' => $slug]))->id;
                    });
                $book->categories()->sync($categoryIds);
            }

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

            $copies = (int) ($row['jumlah'] ?? 1);
            if ($copies < 1) $copies = 1;
            for ($c = 1; $c <= $copies; $c++) {
                OfflineBookCopy::create([
                    'offline_book_id' => $book->id,
                    'reading_spot_id' => $spot->id,
                    'catalog_code'    => sprintf('%s/%s/%05d', $spot->slug ?? 'SPT', $book->id, $c),
                    'barcode'         => 'OBC' . Str::upper(Str::random(8)),
                    'condition'       => 'good',
                    'acquired_at'     => now(),
                ]);
            }

            $this->imported++;
        }
    }
}
