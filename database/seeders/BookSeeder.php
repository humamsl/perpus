<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Ebook;
use App\Models\Publisher;
use App\Models\Shelf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Buku domain publik Indonesia — gratis dan bebas hak cipta.
 *
 * Semua judul di bawah ini nyata (bukan data fiktif) dan sudah berstatus
 * domain publik di Indonesia berdasarkan Pasal 58 UU No. 28 Tahun 2014
 * Tentang Hak Cipta (masa hidup pencipta + 70 tahun sejak meninggal,
 * terhitung 1 Januari tahun berikutnya). Rujukan: "Daftar karya domain
 * publik di Indonesia", id.wikipedia.org.
 *
 * Karena terbit jauh sebelum sistem ISBN ada (baru dipakai luas sejak
 * 1970-an), buku-buku ini tidak punya ISBN asli — kolom `isbn` diisi kode
 * katalog sintetis berformat "PD-<tahun>-<urutan>" (PD = Public Domain),
 * bukan ISBN sungguhan, supaya tidak menampilkan data ISBN palsu yang
 * terlihat asli.
 */
class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Azab dan Sengsara',
                'author' => 'Merari Siregar',
                'year' => 1920,
                'category' => 'Fiksi',
                'publisher' => 'Balai Pustaka',
                'language' => 'id',
                'synopsis' => 'Kisah cinta Mariamin dan Aminuddin yang terhalang adat kawin paksa di tanah Batak. '
                    .'Diterbitkan Balai Pustaka tahun 1920 dan kerap disebut sebagai novel modern Indonesia pertama.',
            ],
            [
                'title' => 'Sengsara Membawa Nikmat',
                'author' => 'Tulis Sutan Sati',
                'year' => 1929,
                'category' => 'Fiksi',
                'publisher' => 'Balai Pustaka',
                'language' => 'id',
                'synopsis' => 'Kisah Midun, pemuda baik hati yang difitnah dan diuji berbagai cobaan sebelum akhirnya '
                    .'hidup bahagia. Salah satu novel paling populer terbitan Balai Pustaka di era 1920–30-an.',
            ],
            [
                'title' => 'Student Hidjo',
                'author' => 'Marco Kartodikromo',
                'year' => 1918,
                'category' => 'Fiksi',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Novel tentang Hidjo, pemuda Hindia Belanda yang dikirim belajar ke Belanda, sarat kritik '
                    .'sosial terhadap kolonialisme. Ditulis jurnalis pergerakan Marco Kartodikromo ("Mas Marco").',
            ],
            [
                'title' => 'Menuju Republik Indonesia',
                'author' => 'Tan Malaka',
                'year' => 1925,
                'category' => 'Sejarah',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Esai politik yang menyerukan dan meramalkan kemerdekaan Indonesia lewat bentuk republik. '
                    .'Ditulis Tan Malaka dalam pengasingan dan pertama terbit di Canton, Tiongkok, April 1925.',
            ],
            [
                'title' => 'Binasa karena Gadis Priangan',
                'author' => 'Merari Siregar',
                'year' => 1931,
                'category' => 'Fiksi',
                'publisher' => 'Balai Pustaka',
                'language' => 'id',
                'synopsis' => 'Novel karya Merari Siregar terbitan Balai Pustaka tahun 1931.',
            ],
            [
                'title' => 'Memutuskan Pertalian',
                'author' => 'Tulis Sutan Sati',
                'year' => 1932,
                'category' => 'Fiksi',
                'publisher' => 'Balai Pustaka',
                'language' => 'id',
                'synopsis' => 'Novel karya Tulis Sutan Sati terbitan Balai Pustaka tahun 1932.',
            ],
            [
                'title' => 'Tidak Membalas Guna',
                'author' => 'Tulis Sutan Sati',
                'year' => 1932,
                'category' => 'Fiksi',
                'publisher' => 'Balai Pustaka',
                'language' => 'id',
                'synopsis' => 'Novel karya Tulis Sutan Sati terbitan Balai Pustaka tahun 1932.',
            ],
            [
                'title' => 'Nyanyi Sunyi',
                'author' => 'Amir Hamzah',
                'year' => 1938,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Kumpulan puisi karya Amir Hamzah, "Raja Penyair Pujangga Baru", memuat 24 sajak dan prosa '
                    .'liris bernuansa religius-personal yang mempengaruhi gaya bahasa puisi Indonesia modern.',
            ],
            [
                'title' => 'Buah Rindu',
                'author' => 'Amir Hamzah',
                'year' => 1941,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Kumpulan puisi kedua Amir Hamzah, terbit tahun 1941.',
            ],
            [
                'title' => 'Sastra Melayu dan Raja-Rajanya',
                'author' => 'Amir Hamzah',
                'year' => 1942,
                'category' => 'Non-Fiksi',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Esai Amir Hamzah tentang sejarah dan perkembangan sastra Melayu klasik beserta raja-rajanya.',
            ],
            [
                'title' => 'Kerikil Tajam dan Yang Terampas dan Yang Putus',
                'author' => 'Chairil Anwar',
                'year' => 1949,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Kumpulan puisi Chairil Anwar, pelopor Angkatan \'45, terdiri dari dua bagian: "Kerikil '
                    .'Tajam" (29 sajak) dan "Yang Terampas dan Yang Putus" (9 sajak). Terbit tahun kematiannya, 1949.',
            ],
            [
                'title' => 'Wawacan Panji Wulung',
                'author' => 'Muhammad Musa',
                'year' => 1871,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'su',
                'synopsis' => 'Karya sastra Sunda klasik berbentuk wawacan (tembang naratif) karya pujangga Muhammad '
                    .'Musa. Salah satu naskah tertua dalam daftar domain publik Indonesia.',
            ],
            [
                'title' => 'Malajoe Batawi',
                'author' => 'Lie Kiem Hok',
                'year' => 1884,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Karya sastra Melayu-Tionghoa oleh Lie Kiem Hok, tokoh yang dijuluki "Bapak Sastra '
                    .'Melayu-Tionghoa", terbit tahun 1884.',
            ],
            [
                'title' => 'Gerakan Bangsa Tjina di Soerabaia Melawan Handelsvereeniging Amsterdam',
                'author' => 'Tirto Adhi Soerjo',
                'year' => 1904,
                'category' => 'Sejarah',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Tulisan Tirto Adhi Soerjo, "Bapak Pers Nasional Indonesia", mendokumentasikan gerakan '
                    .'protes pedagang Tionghoa di Surabaya melawan Handelsvereeniging Amsterdam, terbit tahun 1904.',
            ],
            [
                'title' => 'Rangsang Tuban',
                'author' => 'Ki Padmosoesastro',
                'year' => 1912,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'jv',
                'synopsis' => 'Karya sastra Jawa oleh pujangga Ki Padmosoesastro, terbit tahun 1912.',
            ],
            [
                'title' => 'Sarekat Islam',
                'author' => 'Sam Ratulangi',
                'year' => 1913,
                'category' => 'Sejarah',
                'publisher' => null,
                'language' => 'id',
                'synopsis' => 'Tulisan awal Dr. G.S.S.J. Ratulangi (Sam Ratulangi), Pahlawan Nasional dari Sulawesi '
                    .'Utara, membahas gerakan Sarekat Islam. Terbit tahun 1913.',
            ],
            [
                'title' => 'Tjarios Eulis Atjih',
                'author' => 'Akhmad Bassah',
                'year' => 1925,
                'category' => 'Sastra',
                'publisher' => null,
                'language' => 'su',
                'synopsis' => 'Karya sastra Sunda oleh Akhmad Bassah (nama pena "Joehanna"), terbit tahun 1925.',
            ],
        ];

        $shelves = Shelf::pluck('id', 'code');

        foreach ($books as $i => $data) {
            $author    = Author::where('slug', Str::slug($data['author']))->first();
            $category  = BookCategory::where('slug', Str::slug($data['category']))->first();
            $publisher = $data['publisher'] ? Publisher::where('slug', Str::slug($data['publisher']))->first() : null;

            $seq = str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT);

            $book = Book::updateOrCreate(
                ['isbn' => "PD-{$data['year']}-{$seq}"],
                [
                    'title'            => $data['title'],
                    'publisher_id'     => $publisher?->id,
                    'book_category_id' => $category?->id,
                    'shelf_id'         => $shelves->isNotEmpty() ? $shelves->random() : null,
                    'year_published'   => $data['year'],
                    'edition'          => 'Domain Publik',
                    'language'         => $data['language'],
                    'synopsis'         => $data['synopsis'],
                    'keywords'         => 'domain publik,klasik,'.Str::slug($data['category']),
                    'status'           => 'available',
                    'barcode'          => "PD{$data['year']}{$seq}",
                    'qr_code'          => "QR-PD-{$data['year']}-{$seq}",
                ]
            );

            if ($author) {
                $book->authors()->sync([$author->id]);
            }
        }

        $this->command?->info('BookSeeder selesai: '.count($books).' buku domain publik Indonesia berhasil di-seed.');

        $this->seedDigitalSeries();
    }

    /**
     * Contoh nyata buku digital seri terbaru — serial "Bumi" karya Tere Liye
     * (Gramedia Pustaka Utama), salah satu serial fantasi remaja Indonesia
     * terpopuler dan masih aktif ditambah judulnya. Setiap judul dibuatkan
     * satu record Ebook agar tampil sebagai koleksi "baca gratis tanpa batas"
     * di menu Buku Digital (file e-book memakai path placeholder, bukan
     * berkas berhak cipta sungguhan).
     */
    protected function seedDigitalSeries(): void
    {
        $author    = Author::where('slug', Str::slug('Tere Liye'))->first();
        $publisher = Publisher::where('slug', Str::slug('Gramedia'))->first();
        $category  = BookCategory::where('slug', Str::slug('Fiksi'))->first();
        $shelves   = Shelf::pluck('id', 'code');

        $series = [
            ['title' => 'Bumi', 'year' => 2014, 'synopsis' => 'Buku pertama Serial Bumi: Raib, siswi SMA yang menyadari dirinya bisa menghilang, tertarik ke dunia paralel Klan Bulan bersama Seli dan Ali.'],
            ['title' => 'Bulan', 'year' => 2015, 'synopsis' => 'Kelanjutan petualangan Raib, Seli, dan Ali menjelajahi Klan Bulan setelah kejadian di dunia paralel pada buku pertama.'],
            ['title' => 'Matahari', 'year' => 2016, 'synopsis' => 'Petualangan trio Raib, Seli, dan Ali berlanjut ke Klan Matahari, menyingkap konflik yang lebih besar antarklan dunia paralel.'],
            ['title' => 'Bintang', 'year' => 2017, 'synopsis' => 'Raib, Seli, dan Ali menghadapi ancaman baru di Klan Bintang dalam kelanjutan serial fantasi remaja terpopuler karya Tere Liye ini.'],
        ];

        foreach ($series as $i => $data) {
            $seq = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);

            $book = Book::updateOrCreate(
                ['isbn' => "SR-BUMI-{$seq}"],
                [
                    'title'            => $data['title'],
                    'publisher_id'     => $publisher?->id,
                    'book_category_id' => $category?->id,
                    'shelf_id'         => $shelves->isNotEmpty() ? $shelves->random() : null,
                    'year_published'   => $data['year'],
                    'edition'          => 'Cetakan Terbaru',
                    'language'         => 'id',
                    'synopsis'         => $data['synopsis'],
                    'keywords'         => 'fantasi,remaja,serial bumi,tere liye',
                    'status'           => 'available',
                    'barcode'          => "SRBUMI{$seq}",
                    'qr_code'          => "QR-SR-BUMI-{$seq}",
                ]
            );

            if ($author) {
                $book->authors()->sync([$author->id]);
            }

            Ebook::updateOrCreate(
                ['book_id' => $book->id, 'format' => 'epub'],
                [
                    'title'        => $data['title'].' (E-Book — Serial Bumi)',
                    'file_path'    => 'ebooks/serial-bumi-'.$seq.'.epub',
                    'downloadable' => true,
                    'watermark'    => true,
                    'access'       => 'public',
                ]
            );
        }

        $this->command?->info('BookSeeder: '.count($series).' buku digital Serial Bumi (Tere Liye) berhasil di-seed.');
    }
}
