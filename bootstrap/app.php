<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'audit'      => \App\Http\Middleware\AuditLog::class,
            '2fa'        => \PragmaRX\Google2FALaravel\Middleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);
        $middleware->throttleApi();
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Upload melebihi post_max_size PHP: PHP membuang SELURUH body request
        // (POST & FILES jadi kosong), jadi tanpa penanganan ini user cuma dapat
        // halaman error generik dan mengira "file tidak bisa diunggah".
        // Tampilkan batas server yang sebenarnya supaya jelas apa yang harus diubah.
        $exceptions->render(function (PostTooLargeException $e, $request) {
            $pesan = 'File terlalu besar untuk diunggah. Batas server saat ini: '
                .ini_get('upload_max_filesize').' per file (total per request '
                .ini_get('post_max_size').'). Naikkan upload_max_filesize & '
                .'post_max_size di php.ini, lalu RESTART web server.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $pesan], 413);
            }

            return back()->withErrors(['ebook_file' => $pesan]);
        });
    })
    ->create();
