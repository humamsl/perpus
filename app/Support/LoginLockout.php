<?php

namespace App\Support;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Penguncian login per email (web & API), berlaku dari IP mana pun:
 * - 5x gagal berturut-turut → dikunci 15 menit.
 * - 20x gagal dalam 24 jam  → dikunci sampai jendela 24 jam habis (LoginFailureCap).
 * Setiap kegagalan dicatat ke audit_logs (event "login_failed") dan laravel.log.
 * Pelengkap throttle per-IP 'login' di AppServiceProvider.
 */
class LoginLockout
{
    public const MAX_ATTEMPTS = 5;

    public const LOCK_MINUTES = 15;

    protected static function key(string $email): string
    {
        return 'login-lock:'.sha1(Str::lower(trim($email)));
    }

    public static function ensureNotLocked(string $email, string $field): void
    {
        $seconds = LoginFailureCap::blockedFor($email);
        if ($seconds !== null) {
            throw ValidationException::withMessages([$field => LoginFailureCap::message($seconds)]);
        }

        if (RateLimiter::tooManyAttempts(self::key($email), self::MAX_ATTEMPTS)) {
            $minutes = max(1, (int) ceil(RateLimiter::availableIn(self::key($email)) / 60));
            throw ValidationException::withMessages([$field => "Akun dikunci sementara. Coba lagi dalam {$minutes} menit."]);
        }
    }

    public static function failed(Request $r, string $email, string $channel): void
    {
        RateLimiter::hit(self::key($email), self::LOCK_MINUTES * 60);
        LoginFailureCap::hit($email);

        $user = User::where('email', $email)->first();
        $context = [
            'email'      => Str::limit($email, 190, ''),
            'channel'    => $channel,
            'user_agent' => Str::limit((string) $r->userAgent(), 250, ''),
        ];
        Log::warning('Login gagal', $context + ['ip' => $r->ip(), 'user_id' => $user?->id]);

        try {
            AuditLog::create([
                'user_id'        => $user?->id,
                'event'          => 'login_failed',
                'auditable_type' => User::class,
                'auditable_id'   => $user?->id ?? 0,
                'new_values'     => $context,
                'url'            => Str::limit($r->fullUrl(), 490, ''),
                'ip_address'     => $r->ip(),
            ]);
        } catch (\Throwable $e) {
            // Pencatatan tidak boleh menggagalkan alur login.
            report($e);
        }
    }

    public static function succeeded(string $email): void
    {
        RateLimiter::clear(self::key($email));
        LoginFailureCap::clear($email);
    }
}
