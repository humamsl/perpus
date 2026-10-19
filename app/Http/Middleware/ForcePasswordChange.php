<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Admin yang kredensialnya baru direset (`admin:reset-credentials`) wajib
 * mengganti password dulu — semua halaman lain diarahkan ke Profil sampai
 * password diganti (ProfileController::updatePassword menghapus tandanya).
 */
class ForcePasswordChange
{
    protected const ALLOWED_ROUTES = ['profile.*', 'logout'];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->must_change_password && ! $request->routeIs(...self::ALLOWED_ROUTES)) {
            $message = 'Demi keamanan, ganti password Anda terlebih dahulu sebelum melanjutkan.';
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 423);
            }

            return redirect()->route('profile.edit')->withErrors(['password' => $message]);
        }

        return $next($request);
    }
}
