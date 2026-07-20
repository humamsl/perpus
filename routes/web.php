<?php

/*
|--------------------------------------------------------------------------
| Web Routes — Perpustakaan Digital
|--------------------------------------------------------------------------
| Letakkan di: routes/web.php
| Middleware default: 'web' (sudah otomatis oleh bootstrap/app.php Laravel 11)
| Middleware tambahan: 'auth', 'audit', 'role:...', 'permission:...', 'throttle:...'
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatacenterImportController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

// Katalog publik — siapa pun bisa browsing
Route::prefix('katalog')->name('catalog.')->group(function () {
    Route::get('/',          [CatalogController::class, 'index'])->name('index');
    Route::get('/{book}',    [CatalogController::class, 'show'])->name('show');
});

// Histori kunjungan — publik, siapa pun bisa melihat trafik pengunjung situs
Route::prefix('histori')->name('visitors.')->group(function () {
    Route::get('/',        [\App\Http\Controllers\VisitorLogController::class, 'history'])->name('history');
    Route::get('/{date}',  [\App\Http\Controllers\VisitorLogController::class, 'historyDay'])
        ->where('date', '\d{4}-\d{2}-\d{2}')->name('history.show');
});

// Dikirim otomatis oleh browser pengunjung jika izin lokasi diberikan
Route::post('/visitor-location', [\App\Http\Controllers\VisitorLogController::class, 'updateLocation'])
    ->middleware('throttle:20,1')->name('visitors.location');

// Healthcheck (untuk monitoring)
Route::get('/up', fn () => response()->json(['status' => 'ok', 'time' => now()->toIso8601String()]));

/*
|--------------------------------------------------------------------------
| Guest routes (login / register / password reset)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'show'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->middleware('throttle:login');

    Route::get('/login/siswa',  [StudentLoginController::class, 'show'])->name('login.siswa');
    Route::post('/login/siswa', [StudentLoginController::class, 'login'])->middleware('throttle:login');

    Route::get('/login/guru',  [TeacherLoginController::class, 'show'])->name('login.guru');
    Route::post('/login/guru', [TeacherLoginController::class, 'login'])->middleware('throttle:login');

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->middleware('throttle:6,1');

    Route::get('/forgot-password',  [LoginController::class, 'forgot'])->name('password.request');
    Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [LoginController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password',  [LoginController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated routes (semua user login)
|--------------------------------------------------------------------------
| 'audit' middleware mencatat semua aksi non-GET ke activity_logs
*/

Route::middleware(['auth', 'verified', 'audit'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil pengguna (semua role)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',            [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/',          [ProfileController::class, 'update'])->name('update');
        Route::patch('/password',  [ProfileController::class, 'updatePassword'])->name('password');
        Route::post('/avatar',     [ProfileController::class, 'uploadAvatar'])->name('avatar');
        Route::delete('/',         [ProfileController::class, 'destroy'])->name('destroy');
        // 2FA
        Route::get('/2fa',         [ProfileController::class, 'show2fa'])->name('2fa.show');
        Route::post('/2fa/enable', [ProfileController::class, 'enable2fa'])->name('2fa.enable');
        Route::post('/2fa/disable',[ProfileController::class, 'disable2fa'])->name('2fa.disable');
    });

    // Notifikasi in-app
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/',                [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read',      [NotificationController::class, 'markRead'])->name('read');
        Route::post('/read-all',       [NotificationController::class, 'markAllRead'])->name('readAll');
        Route::delete('/{id}',         [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Wishlist tersedia untuk semua role login
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/',                       [WishlistController::class, 'index'])->name('index');
        Route::post('/{book}/toggle',         [WishlistController::class, 'toggle'])->name('toggle');
        Route::delete('/{book}',              [WishlistController::class, 'destroy'])->name('destroy');
    });

    // Review buku (membutuhkan permission review.create)
    Route::middleware('permission:review.create')->group(function () {
        Route::post('books/{book}/reviews',   [ReviewController::class, 'store'])->name('reviews.store');
        Route::patch('reviews/{review}',      [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('reviews/{review}',     [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::post('reviews/{review}/like',  [ReviewController::class, 'like'])->name('reviews.like');
        Route::post('reviews/{review}/report',[ReviewController::class, 'report'])->name('reviews.report');
    });

    // E-Book reader (dibuka dari halaman Buku Digital, akses dicek per item)
    Route::prefix('ebooks')->name('ebooks.')->group(function () {
        Route::get('/{ebook}/read',           [EbookController::class, 'read'])->name('read');
        Route::post('/{ebook}/bookmark',      [EbookController::class, 'bookmark'])->name('bookmark');
        Route::get('/{ebook}/download',       [EbookController::class, 'download'])->name('download');
        Route::post('/{ebook}/track',         [EbookController::class, 'track'])->name('track');
    });

    /*
    |--------------------------------------------------------------------------
    | Petugas / Admin / Super Admin
    |--------------------------------------------------------------------------
    | Manajemen koleksi, anggota, transaksi
    */

    // Buku — CRUD diatur lewat BookPolicy
    Route::resource('books', BookController::class);
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/import/form',     [BookController::class, 'importForm'])->middleware('permission:book.import')->name('import.form');
        Route::post('/import',         [BookController::class, 'import'])->middleware('permission:book.import')->name('import');
        Route::get('/import/template', [BookController::class, 'importTemplate'])->middleware('permission:book.import')->name('import.template');
        Route::get('/export/{format}', [BookController::class, 'export'])->middleware('permission:book.export')->whereIn('format', ['xlsx','csv','pdf'])->name('export');
        Route::get('/{book}/barcode',  [BookController::class, 'barcode'])->name('barcode');
        Route::get('/{book}/qrcode',   [BookController::class, 'qrcode'])->name('qrcode');
        Route::post('/bulk-delete',    [BookController::class, 'bulkDelete'])->middleware('permission:book.delete')->name('bulkDelete');
    });

    // Penerbit / Penulis / Kategori / Rak (sub-modul koleksi)
    Route::middleware('permission:book.update')->group(function () {
        Route::resource('categories', \App\Http\Controllers\BookCategoryController::class)->except(['show']);
        Route::resource('authors',    \App\Http\Controllers\AuthorController::class)->except(['show']);
        Route::resource('publishers', \App\Http\Controllers\PublisherController::class)->except(['show']);
        Route::resource('shelves',    \App\Http\Controllers\ShelfController::class)->except(['show']);
    });

    // Anggota
    Route::resource('members', MemberController::class);
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/{member}/card',  [MemberController::class, 'card'])->name('card');
        Route::get('/import/form',    [MemberController::class, 'importForm'])->middleware('permission:member.create')->name('import.form');
        Route::post('/import',        [MemberController::class, 'import'])->middleware('permission:member.create')->name('import');
        Route::get('/export/{format}',[MemberController::class, 'export'])->middleware('permission:member.view')->whereIn('format', ['xlsx','csv'])->name('export');
    });

    // Tambah Anggota dari Data Center (Tahun Ajaran -> Kelas -> pilih siswa)
    Route::prefix('members/datacenter')->name('members.datacenter.')->middleware('permission:member.create')->group(function () {
        Route::get('tahun-ajaran', [DatacenterImportController::class, 'tahunAjaran'])->name('tahunAjaran');
        Route::get('rombel',       [DatacenterImportController::class, 'rombel'])->name('rombel');
        Route::get('siswa',        [DatacenterImportController::class, 'siswa'])->name('siswa');
        Route::post('import',      [DatacenterImportController::class, 'import'])->name('import');
    });

    // Sinkronisasi Data — otomatis samakan seluruh siswa & guru dari Data Center
    // sebagai anggota perpustakaan (upsert idempoten, aman dijalankan berkali-kali).
    Route::prefix('sync-datacenter')->name('sync-datacenter.')->middleware('permission:member.create')->group(function () {
        Route::get('/',   [\App\Http\Controllers\DatacenterSyncController::class, 'index'])->name('index');
        Route::post('run',[\App\Http\Controllers\DatacenterSyncController::class, 'run'])->name('run');
    });

    // E-Book management (upload/edit) — file digital dilampirkan ke sebuah Buku Digital,
    // dikelola dari halaman detail buku (books.show), bukan menu terpisah.
    Route::middleware('permission:ebook.manage')->group(function () {
        Route::get('ebooks/create',              [EbookController::class, 'create'])->name('ebooks.create');
        Route::post('ebooks',                    [EbookController::class, 'store'])->name('ebooks.store');
        Route::get('ebooks/{ebook}/edit',        [EbookController::class, 'edit'])->name('ebooks.edit');
        Route::patch('ebooks/{ebook}',           [EbookController::class, 'update'])->name('ebooks.update');
        Route::delete('ebooks/{ebook}',          [EbookController::class, 'destroy'])->name('ebooks.destroy');
    });

    // Denda & Pembayaran — sekarang berasal dari peminjaman fisik (Checkout), bukan lagi dari peminjaman digital.
    Route::prefix('fines')->name('fines.')->group(function () {
        Route::get('/',                          [FineController::class, 'index'])->middleware('permission:fine.view')->name('index');
        Route::get('/mine',                      [FineController::class, 'mine'])->name('mine');
        Route::get('/{fine}',                    [FineController::class, 'show'])->name('show');
        Route::post('/{fine}/pay',               [FineController::class, 'pay'])->middleware('permission:payment.record')->name('pay');
        Route::post('/{fine}/waive',             [FineController::class, 'waive'])->middleware('permission:fine.waive')->name('waive');
        Route::get('/{fine}/receipt',            [FineController::class, 'receipt'])->name('receipt');
    });

    /*
    |--------------------------------------------------------------------------
    | Laporan (Admin & Super Admin)
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:report.view')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/',                  [ReportController::class, 'index'])->name('index');
        Route::get('/borrowed',          [ReportController::class, 'borrowed'])->name('borrowed');
        Route::get('/overdue',           [ReportController::class, 'overdue'])->name('overdue');
        Route::get('/popular',           [ReportController::class, 'popular'])->name('popular');
        Route::get('/active-members',    [ReportController::class, 'activeMembers'])->name('activeMembers');
        Route::get('/categories',        [ReportController::class, 'categories'])->name('categories');
        Route::get('/ebook-stats',       [ReportController::class, 'ebookStats'])->name('ebookStats');
        Route::get('/visits',            [ReportController::class, 'visits'])->name('visits');
        // Export
        Route::get('/export/pdf/{type}', [ReportController::class, 'pdf'])->middleware('permission:report.export')->name('pdf');
        Route::get('/export/excel/{type}', [ReportController::class, 'excel'])->middleware('permission:report.export')->name('excel');
        Route::get('/export/csv/{type}', [ReportController::class, 'csv'])->middleware('permission:report.export')->name('csv');
    });

    /*
    |--------------------------------------------------------------------------
    | Super Admin only — user management, settings, audit, backup
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:super_admin')->group(function () {
        // Manajemen user & role
        Route::resource('users', UserController::class);
        Route::prefix('users')->name('users.')->group(function () {
            Route::post('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggleActive');
            Route::post('/{user}/roles',         [UserController::class, 'syncRoles'])->name('syncRoles');
            Route::post('/{user}/reset-password',[UserController::class, 'resetPassword'])->name('resetPassword');
        });
        Route::resource('roles', \App\Http\Controllers\RoleController::class)->except(['show']);

        // Audit log
        Route::get('audit-logs',          [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
        Route::get('activity-logs',       [\App\Http\Controllers\AuditLogController::class, 'activity'])->name('activity.index');

        // Riwayat pengunjung
        Route::get('visitor-logs',        [\App\Http\Controllers\VisitorLogController::class, 'index'])->name('visitors.index');
        Route::get('visitor-logs/export', [\App\Http\Controllers\VisitorLogController::class, 'export'])->name('visitors.export');

        // Backup & restore
        Route::prefix('backups')->name('backups.')->group(function () {
            Route::get('/',                [\App\Http\Controllers\BackupController::class, 'index'])->name('index');
            Route::post('/run',            [\App\Http\Controllers\BackupController::class, 'run'])->name('run');
            Route::get('/download/{file}', [\App\Http\Controllers\BackupController::class, 'download'])->name('download');
            Route::delete('/{file}',       [\App\Http\Controllers\BackupController::class, 'destroy'])->name('destroy');
        });
    });

    // Settings (super admin atau permission setting.manage)
    Route::middleware('permission:setting.manage')->prefix('settings')->name('settings.')->group(function () {
        Route::get('/',          [SettingController::class, 'index'])->name('index');
        Route::put('/',          [SettingController::class, 'update'])->name('update');
        Route::post('/logo',     [SettingController::class, 'uploadLogo'])->name('logo');
        Route::post('/favicon',  [SettingController::class, 'uploadFavicon'])->name('favicon');
        Route::post('/test-mail',[SettingController::class, 'testMail'])->name('testMail');
        Route::post('/cache-clear', [SettingController::class, 'clearCache'])->name('cacheClear');
    });

    /*
    |--------------------------------------------------------------------------
    | Modul tambahan (mengadopsi konsep proyek lama)
    |--------------------------------------------------------------------------
    | Reading Spots (multi-tenant), DDC, OfflineBook + Copy, Hold + Checkout,
    | AppProfile (branding per spot)
    */

    Route::resource('reading-spots', \App\Http\Controllers\ReadingSpotController::class);
    Route::resource('ddc-categories', \App\Http\Controllers\DdcCategoryController::class)->except(['show']);

    // Static-segment routes MUST come before the resource so /offline-books/import/*
    // is not captured by the /offline-books/{offlineBook} (show) wildcard.
    Route::prefix('offline-books')->name('offline-books.')->group(function () {
        Route::get('/import/form',     [\App\Http\Controllers\OfflineBookController::class, 'importForm'])->middleware('permission:book.import')->name('import.form');
        Route::post('/import',         [\App\Http\Controllers\OfflineBookController::class, 'import'])->middleware('permission:book.import')->name('import');
        Route::get('/import/template', [\App\Http\Controllers\OfflineBookController::class, 'importTemplate'])->middleware('permission:book.import')->name('import.template');
    });
    Route::resource('offline-books', \App\Http\Controllers\OfflineBookController::class);
    Route::post('offline-books/{offlineBook}/add-copy', [\App\Http\Controllers\OfflineBookController::class, 'addCopy'])
        ->name('offline-books.addCopy');

    Route::prefix('holds')->name('holds.')->group(function () {
        // Static-segment routes MUST come before any /{hold} wildcard.
        Route::get('/scan',              [\App\Http\Controllers\HoldController::class, 'scan'])->middleware('permission:checkout.manage')->name('scan');
        Route::post('/lookup',           [\App\Http\Controllers\HoldController::class, 'lookup'])->middleware('permission:checkout.manage')->name('lookup');
        Route::get('/',                  [\App\Http\Controllers\HoldController::class, 'index'])->name('index');
        Route::post('/',                 [\App\Http\Controllers\HoldController::class, 'store'])->name('store');
        Route::get('/{hold}/qrcode',     [\App\Http\Controllers\HoldController::class, 'qrcode'])->name('qrcode');
        Route::post('/{hold}/confirm-scan', [\App\Http\Controllers\HoldController::class, 'confirmScan'])->middleware('permission:checkout.manage')->name('confirmScan');
        Route::post('/{hold}/fulfill',   [\App\Http\Controllers\HoldController::class, 'fulfill'])->name('fulfill');
        Route::post('/{hold}/cancel',    [\App\Http\Controllers\HoldController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('checkouts')->name('checkouts.')->group(function () {
        Route::get('/',                       [\App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
        Route::get('/create',                 [\App\Http\Controllers\CheckoutController::class, 'create'])->name('create');
        Route::post('/',                      [\App\Http\Controllers\CheckoutController::class, 'store'])->name('store');
        Route::get('/{checkout}',             [\App\Http\Controllers\CheckoutController::class, 'show'])->name('show');
        Route::post('/{checkout}/checkin',    [\App\Http\Controllers\CheckoutController::class, 'checkin'])->name('checkin');
        Route::get('/lookup/copy',            [\App\Http\Controllers\CheckoutController::class, 'lookupCopy'])->name('lookupCopy');
    });

    // App Profile per reading spot (branding)
    Route::middleware('permission:setting.manage')->group(function () {
        Route::get('reading-spots/{readingSpot}/profile',  [\App\Http\Controllers\AppProfileController::class, 'edit'])->name('app-profiles.edit');
        Route::put('reading-spots/{readingSpot}/profile',  [\App\Http\Controllers\AppProfileController::class, 'update'])->name('app-profiles.update');

        Route::get('reading-spots/{readingSpot}/checkout-setting',  [\App\Http\Controllers\CheckoutSettingController::class, 'edit'])->name('checkout-settings.edit');
        Route::put('reading-spots/{readingSpot}/checkout-setting',  [\App\Http\Controllers\CheckoutSettingController::class, 'update'])->name('checkout-settings.update');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => response()->view('errors.404', [], 404));
