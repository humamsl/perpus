<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BorrowTransaction;
use App\Models\Checkout;
use App\Models\DdcCategory;
use App\Models\Ebook;
use App\Models\Fine;
use App\Models\Hold;
use App\Models\Member;
use App\Models\OfflineBook;
use App\Models\OfflineBookCopy;
use App\Models\Payment;
use App\Models\Publisher;
use App\Models\ReadingSpot;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Shelf;
use App\Models\User;
use App\Services\BorrowService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Mengisi data contoh untuk SEMUA modul transaksional supaya setiap halaman
 * (peminjaman, denda, e-book, buku fisik, checkout, hold, reservasi, ulasan,
 * wishlist, notifikasi) tampil dengan data nyata. Idempotent: berhenti bila
 * data peminjaman sudah ada.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        if (BorrowTransaction::count() > 0) {
            $this->command?->warn('DemoDataSeeder dilewati (data transaksi sudah ada).');
            return;
        }

        $svc    = app(BorrowService::class);
        $staff  = User::role('staff')->first() ?? User::role('super_admin')->first();
        $spots  = ReadingSpot::all();
        $authors = Author::all();
        $cats    = BookCategory::all();
        $pubs    = Publisher::all();
        $ddcs    = DdcCategory::all();
        $shelves = Shelf::all();

        $members  = $this->ensureMembers();
        // Selalu ambil buku yang stoknya tersedia agar BorrowService tidak menolak.
        $nextBook = function () {
            $book = Book::where('available', '>', 0)->inRandomOrder()->first();
            abort_unless($book, 500, 'Tidak ada buku dengan stok tersedia untuk data demo.');
            return $book;
        };

        // ---- Peminjaman + pengembalian + denda (lewat BorrowService) ----
        foreach ($members as $idx => $member) {
            // 1. Dikembalikan terlambat -> menghasilkan denda
            $tx = $svc->checkout($member, $nextBook(), $staff?->id, 7);
            $tx->update(['borrowed_at' => now()->subDays(20), 'due_at' => now()->subDays(13)]);
            $svc->checkin($tx->refresh(), 'good', null, $staff?->id);

            // 2. Dikembalikan tepat waktu (tanpa denda)
            $tx = $svc->checkout($member, $nextBook(), $staff?->id, 7);
            $tx->update(['borrowed_at' => now()->subDays(5)]);
            $svc->checkin($tx->refresh(), 'good', null, $staff?->id);

            // 3. Sedang dipinjam & terlambat (masih aktif)
            $tx = $svc->checkout($member, $nextBook(), $staff?->id, 7);
            $tx->update(['borrowed_at' => now()->subDays(15), 'due_at' => now()->subDays(8)]);

            // 4. Sedang dipinjam normal (belum jatuh tempo)
            $svc->checkout($member, $nextBook(), $staff?->id, 7);

            // Satu anggota: pengembalian rusak -> denda kerusakan
            if ($idx === 1) {
                $tx = $svc->checkout($member, $nextBook(), $staff?->id, 7);
                $tx->update(['borrowed_at' => now()->subDays(10), 'due_at' => now()->subDays(3)]);
                $svc->checkin($tx->refresh(), 'damaged', 'Sampul sobek & beberapa halaman terlipat.', $staff?->id);
            }
        }

        // ---- Pembayaran sebagian pada satu denda (status partial) ----
        if ($fine = Fine::where('status', 'unpaid')->first()) {
            $half = max(1, intdiv($fine->amount, 2));
            Payment::create([
                'fine_id'     => $fine->id,
                'received_by' => $staff?->id,
                'amount'      => $half,
                'method'      => 'cash',
                'reference'   => 'DEMO-' . Str::upper(Str::random(6)),
                'paid_at'     => now()->subDay(),
            ]);
            $fine->paid_amount += $half;
            $fine->recomputeStatus();
        }

        // ---- Reservasi (antrean buku) ----
        foreach ($members->take(3) as $pos => $member) {
            Reservation::create([
                'member_id'      => $member->id,
                'book_id'        => $nextBook()->id,
                'reserved_at'    => now()->subDays($pos + 1),
                'expires_at'     => now()->addDays(2),
                'queue_position' => $pos + 1,
                'status'         => $pos === 0 ? 'ready' : 'pending',
            ]);
        }

        // ---- Ulasan + recalced rating ----
        $reviewTexts = [
            'Buku yang sangat informatif dan mudah dipahami.',
            'Penjelasannya runtut, cocok untuk pemula.',
            'Isinya bagus walau beberapa bab terasa singkat.',
            'Salah satu referensi favorit saya.',
            'Ilustrasinya membantu sekali memahami materi.',
        ];
        $reviewBooks = Book::inRandomOrder()->take(12)->get();
        foreach ($reviewBooks as $book) {
            foreach ($members->random(min(2, $members->count())) as $member) {
                Review::updateOrCreate(
                    ['user_id' => $member->user_id, 'book_id' => $book->id],
                    [
                        'rating'  => random_int(3, 5),
                        'content' => Arr::random($reviewTexts),
                        'likes'   => random_int(0, 12),
                    ]
                );
            }
            $book->recalcRating();
        }

        // ---- Wishlist (anggota siswa) ----
        foreach ($members->where('type', 'student') as $member) {
            $picks = Book::inRandomOrder()->take(random_int(2, 4))->pluck('id')->all();
            $member->user->wishlist()->syncWithoutDetaching($picks);
        }

        // ---- E-Book ----
        $formats = [
            ['format' => 'pdf',   'file' => 'ebooks/demo.pdf',   'down' => true,  'access' => 'member'],
            ['format' => 'pdf',   'file' => 'ebooks/demo.pdf',   'down' => false, 'access' => 'public'],
            ['format' => 'epub',  'file' => 'ebooks/demo.epub',  'down' => true,  'access' => 'member'],
            ['format' => 'audio', 'file' => 'ebooks/demo.mp3',   'down' => false, 'access' => 'member'],
            ['format' => 'video', 'file' => 'ebooks/demo.mp4',   'down' => false, 'access' => 'staff'],
        ];
        foreach (Book::inRandomOrder()->take(8)->get() as $n => $book) {
            $f = $formats[$n % count($formats)];
            Ebook::create([
                'book_id'          => $book->id,
                'title'            => $book->title . ' (Edisi Digital)',
                'format'           => $f['format'],
                'file_path'        => $f['file'],
                'file_size'        => random_int(500_000, 12_000_000),
                'duration_seconds' => in_array($f['format'], ['audio', 'video']) ? random_int(300, 5400) : null,
                'downloadable'     => $f['down'],
                'watermark'        => true,
                'access'           => $f['access'],
                'view_count'       => random_int(5, 400),
                'download_count'   => random_int(0, 120),
            ]);
        }

        // ---- Buku fisik (offline) + kopi per reading spot ----
        $copies = collect();
        foreach ($spots as $spot) {
            for ($b = 0; $b < 3; $b++) {
                $ob = OfflineBook::create([
                    'reading_spot_id' => $spot->id,
                    'isbn'            => '978' . random_int(1_000_000_000, 9_999_999_999),
                    'title'           => 'Koleksi Fisik ' . $spot->id . '-' . ($b + 1) . ': ' . Arr::random([
                        'Sejarah Nusantara', 'Matematika Dasar', 'Ensiklopedia Sains',
                        'Sastra Indonesia', 'Atlas Dunia', 'Biografi Pahlawan',
                    ]),
                    'publisher_id'    => $pubs->isNotEmpty() ? $pubs->random()->id : null,
                    'ddc_category_id' => $ddcs->isNotEmpty() ? $ddcs->random()->id : null,
                    'year_published'  => random_int(2008, 2024),
                    'pages'           => random_int(80, 480),
                    'source'          => Arr::random(['purchase', 'donation', 'exchange']),
                    'synopsis'        => 'Koleksi cetak yang tersedia untuk dibaca di tempat maupun dipinjam.',
                ]);
                if ($authors->isNotEmpty()) $ob->authors()->sync($authors->random(min(2, $authors->count()))->pluck('id'));
                if ($cats->isNotEmpty())    $ob->categories()->sync($cats->random(min(2, $cats->count()))->pluck('id'));

                foreach (range(1, random_int(2, 3)) as $c) {
                    $copies->push(OfflineBookCopy::create([
                        'offline_book_id' => $ob->id,
                        'reading_spot_id' => $spot->id,
                        'shelf_id'        => $shelves->isNotEmpty() ? $shelves->random()->id : null,
                        'catalog_code'    => 'INV-' . $spot->id . '-' . $ob->id . '-' . $c,
                        'barcode'         => 'OBC' . str_pad((string) ($ob->id * 10 + $c), 8, '0', STR_PAD_LEFT),
                        'condition'       => Arr::random(['new', 'good', 'good', 'damaged']),
                        'acquired_at'     => now()->subMonths(random_int(1, 36)),
                        'price'           => random_int(35_000, 150_000),
                    ]));
                }
            }
        }

        // ---- Checkout buku fisik + Hold ----
        $studentUsers = $members->where('type', 'student')->pluck('user')->values();
        $copyPool     = $copies->shuffle()->values();
        $cp           = 0;
        if ($studentUsers->isNotEmpty() && $copyPool->isNotEmpty()) {
            $scenarios = [
                ['returned' => true,  'days' => -10, 'due' => -3],   // selesai
                ['returned' => false, 'days' => -2,  'due' => 5],    // aktif
                ['returned' => false, 'days' => -9,  'due' => -2],   // aktif & terlambat
            ];
            foreach ($scenarios as $n => $s) {
                $copy = $copyPool[$cp++ % $copyPool->count()];
                $co = Checkout::create([
                    'code'            => 'CO-' . Str::upper(Str::random(8)),
                    'user_id'         => $studentUsers[$n % $studentUsers->count()]->id,
                    'reading_spot_id' => $copy->reading_spot_id,
                    'staff_id'        => $staff?->id,
                    'start_time'      => now()->addDays($s['days']),
                    'end_time'        => now()->addDays($s['due']),
                    'return_time'     => $s['returned'] ? now()->addDays($s['due'] - 1) : null,
                    'is_returned'     => $s['returned'],
                    'fine_amount'     => $s['returned'] ? 0 : 0,
                ]);
                $co->offlineBookCopies()->attach($copy->id);
            }

            // Hold aktif
            $copy = $copyPool[$cp++ % $copyPool->count()];
            $hold = Hold::create([
                'user_id'         => $studentUsers->first()->id,
                'reading_spot_id' => $copy->reading_spot_id,
                'hold_at'         => now()->subDay(),
                'expires_at'      => now()->addDay(),
                'status'          => 'active',
            ]);
            $hold->offlineBookCopies()->attach($copy->id);
        }

        // ---- Notifikasi (database) ----
        $notes = [
            ['message' => 'Pengembalian buku Anda telah jatuh tempo. Mohon segera dikembalikan.', 'read' => false],
            ['message' => 'Reservasi buku Anda sudah siap diambil di meja sirkulasi.',            'read' => false],
            ['message' => 'Selamat datang di Perpustakaan Digital! Jelajahi katalog kami.',         'read' => true],
        ];
        foreach ($members->take(3) as $member) {
            foreach ($notes as $note) {
                DB::table('notifications')->insert([
                    'id'              => (string) Str::uuid(),
                    'type'            => 'App\\Notifications\\SystemNotification',
                    'notifiable_type' => User::class,
                    'notifiable_id'   => $member->user_id,
                    'data'            => json_encode(['message' => $note['message']]),
                    'read_at'         => $note['read'] ? now() : null,
                    'created_at'      => now()->subHours(random_int(1, 72)),
                    'updated_at'      => now(),
                ]);
            }
        }

        $this->command?->info('DemoDataSeeder selesai: borrow=' . BorrowTransaction::count()
            . ' fine=' . Fine::count() . ' ebook=' . Ebook::count()
            . ' offlineBook=' . OfflineBook::count() . ' copy=' . OfflineBookCopy::count()
            . ' checkout=' . Checkout::count() . ' review=' . Review::count());
    }

    /** Pastikan ada cukup anggota untuk data demo (siswa & guru). */
    private function ensureMembers()
    {
        $extra = [
            ['Andi Pratama', 'student', 'X IPA 1'],
            ['Bunga Lestari', 'student', 'XI IPS 2'],
            ['Citra Dewi', 'student', 'XII IPA 3'],
            ['Dimas Saputra', 'student', 'X IPA 2'],
            ['Eka Wijaya', 'teacher', null],
            ['Fitri Handayani', 'teacher', null],
        ];
        foreach ($extra as [$name, $type, $class]) {
            $slug  = Str::slug($name, '.');
            $user  = User::firstOrCreate(
                ['email' => $slug . '@library.test'],
                ['name' => $name, 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $user->syncRoles([$type]);
            Member::firstOrCreate(['user_id' => $user->id], [
                'member_no'  => 'M-' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
                'type'       => $type,
                'class'      => $class,
                'gender'     => Arr::random(['M', 'F']),
                'joined_at'  => now()->subMonths(random_int(1, 18)),
                'expires_at' => now()->addYears(2),
            ]);
        }

        return Member::with('user')->get();
    }
}
