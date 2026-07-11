<?php

namespace Database\Seeders;

use App\Models\AppProfile;
use App\Models\Author;
use App\Models\BookCategory;
use App\Models\CheckoutSetting;
use App\Models\OfflineBook;
use App\Models\OfflineBookCopy;
use App\Models\Publisher;
use App\Models\ReadingSpot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Migrasi dari data demo (3 reading spot bawaan ReadingSpotSeeder) ke satu
 * reading spot nyata "Garage Library" lengkap dengan koleksi buku fisik awal.
 * Aman dijalankan berkali-kali (idempoten):
 *   - Reading spot lama dihapus by name kalau masih ada (cascade membersihkan
 *     buku fisik/kopi/hold/checkout miliknya — lihat FK di migration terkait).
 *   - Garage Library dibuat kalau belum ada, dipakai kalau sudah ada.
 *   - Buku di-firstOrCreate per judul, kopi hanya ditambah saat buku baru dibuat
 *     (supaya tidak dobel kalau seeder dijalankan ulang).
 *
 * Jalankan: php artisan db:seed --class=GarageLibrarySetupSeeder
 */
class GarageLibrarySetupSeeder extends Seeder
{
    public function run(): void
    {
        $this->removeOldDemoSpots();
        $spot = $this->ensureGarageLibrary();
        $this->seedPhysicalBooks($spot);
    }

    protected function removeOldDemoSpots(): void
    {
        $names = ['SMPN 205 Jakarta', 'Perpustakaan Kota Bandung', 'Komunitas Baca Yogya'];

        ReadingSpot::whereIn('name', $names)->get()->each(function (ReadingSpot $spot) {
            $this->command?->info("Menghapus reading spot lama: {$spot->name}");
            $spot->forceDelete();
        });
    }

    protected function ensureGarageLibrary(): ReadingSpot
    {
        $spot = ReadingSpot::firstOrCreate(
            ['slug' => 'garage-library'],
            ['name' => 'Garage Library', 'type' => 'library', 'is_active' => true]
        );

        AppProfile::firstOrCreate(['reading_spot_id' => $spot->id], ['app_name' => $spot->name]);
        CheckoutSetting::firstOrCreate(['reading_spot_id' => $spot->id]);

        return $spot;
    }

    protected function seedPhysicalBooks(ReadingSpot $spot): void
    {
        $books = [
            ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'publisher' => 'Bentang Pustaka', 'category' => 'Fiksi', 'year' => 2005, 'copies' => 2, 'synopsis' => 'Kisah perjuangan sepuluh anak di Belitung mengejar pendidikan di tengah keterbatasan.'],
            ['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'publisher' => 'Hasta Mitra', 'category' => 'Sejarah', 'year' => 1980, 'copies' => 2, 'synopsis' => 'Novel pertama Tetralogi Buru tentang Minke di masa kolonial Hindia Belanda.'],
            ['title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'publisher' => 'Gramedia Pustaka Utama', 'category' => 'Fiksi', 'year' => 2009, 'copies' => 2, 'synopsis' => 'Perjalanan santri di Pondok Madani menggapai mimpi ke berbagai penjuru dunia.'],
            ['title' => 'Cantik Itu Luka', 'author' => 'Eka Kurniawan', 'publisher' => 'Gramedia Pustaka Utama', 'category' => 'Fiksi', 'year' => 2002, 'copies' => 1, 'synopsis' => 'Kisah magis-realis empat generasi perempuan di sebuah kota pesisir Jawa.'],
            ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'publisher' => 'Kompas', 'category' => 'Non-Fiksi', 'year' => 2018, 'copies' => 2, 'synopsis' => 'Pengantar filsafat Stoa untuk mengelola emosi di kehidupan modern.'],
            ['title' => 'Atlas Dunia', 'author' => 'Tim Redaksi', 'publisher' => 'Erlangga', 'category' => 'Referensi', 'year' => 2020, 'copies' => 1, 'synopsis' => 'Atlas geografi dunia lengkap dengan peta negara dan data demografi.'],
        ];

        foreach ($books as $b) {
            $author = Author::firstOrCreate(['slug' => Str::slug($b['author'])], ['name' => $b['author']]);
            $publisher = Publisher::firstOrCreate(['slug' => Str::slug($b['publisher'])], ['name' => $b['publisher']]);
            $category = BookCategory::firstOrCreate(['slug' => Str::slug($b['category'])], ['name' => $b['category']]);

            $book = OfflineBook::firstOrCreate(
                ['reading_spot_id' => $spot->id, 'title' => $b['title']],
                [
                    'publisher_id' => $publisher->id,
                    'year_published' => $b['year'],
                    'language' => 'id',
                    'synopsis' => $b['synopsis'],
                    'source' => 'purchase',
                ]
            );

            if (!$book->wasRecentlyCreated) {
                $this->command?->info("Lewati (sudah ada): {$book->title}");
                continue;
            }

            $book->authors()->syncWithoutDetaching([$author->id]);
            $book->categories()->syncWithoutDetaching([$category->id]);

            for ($i = 1; $i <= $b['copies']; $i++) {
                OfflineBookCopy::create([
                    'offline_book_id' => $book->id,
                    'reading_spot_id' => $spot->id,
                    'catalog_code' => sprintf('%s/%s/%05d', $spot->slug, $book->id, $i),
                    'barcode' => 'OBC' . Str::upper(Str::random(8)),
                    'condition' => 'good',
                    'acquired_at' => now(),
                ]);
            }
            $this->command?->info("Ditambahkan: {$book->title} ({$b['copies']} kopi)");
        }
    }
}
