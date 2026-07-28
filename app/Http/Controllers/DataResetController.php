<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataResetController extends Controller
{
    /**
     * Tabel yang dikosongkan total saat reset (label => untuk tampilan).
     * Data buku (books, ebooks, offline_books + taksonomi), reading spots,
     * pengaturan, dan role/permission TIDAK ada di daftar ini.
     */
    private const WIPE_TABLES = [
        'members'                => 'Data anggota',
        'holds'                  => 'Hold / antrean buku',
        'checkouts'              => 'Peminjaman fisik',
        'borrowables'            => 'Relasi pinjaman–eksemplar',
        'borrowing_histories'    => 'Riwayat peminjaman',
        'fines'                  => 'Denda',
        'payments'               => 'Pembayaran',
        'reviews'                => 'Ulasan buku',
        'review_likes'           => 'Like ulasan',
        'wishlists'              => 'Wishlist',
        'ebook_bookmarks'        => 'Bookmark e-book',
        'notifications'          => 'Notifikasi',
        'activity_logs'          => 'Log aktivitas',
        'audit_logs'             => 'Log audit',
        'book_activity_logs'     => 'Statistik aktivitas buku',
        'visitor_logs'           => 'Log pengunjung',
        'personal_access_tokens' => 'Token API',
        'password_reset_tokens'  => 'Token reset password',
        'jobs'                   => 'Antrean tugas',
        'job_batches'            => 'Batch antrean',
        'failed_jobs'            => 'Antrean tugas gagal',
    ];

    /** ID user yang dipertahankan: pemilik role super_admin atau admin. */
    private function keepUserIds()
    {
        return User::role(['super_admin', 'admin'])->pluck('users.id')->unique()->values();
    }

    public function index()
    {
        $wipe = collect(self::WIPE_TABLES)
            ->filter(fn ($label, $table) => Schema::hasTable($table))
            ->map(fn ($label, $table) => ['label' => $label, 'count' => DB::table($table)->count()]);

        $keepIds = $this->keepUserIds();

        return view('data-reset.index', [
            'wipe'         => $wipe,
            'keptUsers'    => $keepIds->count(),
            'deletedUsers' => User::withTrashed()->whereNotIn('id', $keepIds)->count(),
            'bookCount'    => DB::table('books')->whereNull('deleted_at')->count(),
            'offlineCount' => DB::table('offline_books')->whereNull('deleted_at')->count(),
            'ebookCount'   => DB::table('ebooks')->whereNull('deleted_at')->count(),
        ]);
    }

    public function run(Request $request)
    {
        $request->validate([
            'confirmation' => ['required', 'in:HAPUS SEMUA DATA'],
            'password'     => ['required', 'current_password'],
        ], [
            'confirmation.in'           => 'Ketik persis: HAPUS SEMUA DATA',
            'password.current_password' => 'Password Anda tidak cocok.',
        ]);

        $keepIds = $this->keepUserIds();

        // Jangan sampai akun yang sedang dipakai ikut terhapus.
        abort_unless($keepIds->contains($request->user()->id), 403, 'Akun Anda tidak memiliki role admin/super admin.');

        // 1) Kosongkan seluruh tabel transaksi/log. FK checks dimatikan karena
        //    TRUNCATE menolak tabel yang direferensikan FK (mis. fines -> checkouts).
        Schema::disableForeignKeyConstraints();
        try {
            foreach (array_keys(self::WIPE_TABLES) as $table) {
                if (Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        // 2) Hapus permanen semua user selain admin/super admin — dilakukan SETELAH
        //    FK checks aktif lagi supaya cascade (reading_spot_user dll.) berjalan.
        User::withTrashed()->whereNotIn('id', $keepIds)->forceDelete();

        // 3) Tabel morph Spatie tidak punya FK ke users, bersihkan baris yatimnya.
        foreach (['model_has_roles', 'model_has_permissions'] as $table) {
            DB::table($table)
                ->where('model_type', User::class)
                ->whereNotIn('model_id', $keepIds)
                ->delete();
        }

        // 4) Reset statistik turunan pada koleksi (sumbernya — ulasan, log,
        //    peminjaman — sudah dikosongkan; buku itu sendiri tidak disentuh).
        DB::table('books')->update(['view_count' => 0, 'borrow_count' => 0, 'rating_avg' => 0, 'rating_count' => 0]);
        DB::table('ebooks')->update(['view_count' => 0, 'download_count' => 0]);
        DB::table('offline_books')->update(['view_count' => 0, 'borrow_count' => 0]);

        // 5) Putus sesi login semua user lain; sesi super admin ini tetap hidup.
        DB::table('sessions')->where('id', '!=', $request->session()->getId())->delete();

        // Cache dashboard/statistik ikut dibersihkan supaya tidak menampilkan data lama.
        try { Cache::flush(); } catch (\Throwable) {}

        return redirect()->route('data-reset.index')
            ->with('toast', 'Reset selesai. Semua data transaksi terhapus; data buku dan akun admin tetap utuh.');
    }
}
