<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class LoginAttempts
{
    public function handle(Request $request, Closure $next)
    {
        $email = $request->input('email');
        $key = 'login-attempts-' . $email;

        if (Cache::has($key) && Cache::get($key)['attempts'] >= 3) {
            $lockoutTime = Cache::get($key)['lockout_time'];
            $remainingTime = now()->diffInSeconds($lockoutTime, false);
            if ($remainingTime > 0) {
                return response()->json([
                    'message' => 'Akun ini dikunci selama 24 jam karena terlalu banyak upaya login yang gagal. Silakan coba lagi nanti.'
                ], 423);
            }
        }

        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ($response->status() == 401) {
            $email = $request->input('email');
            $key = 'login-attempts-' . $email;

            $attempts = Cache::get($key)['attempts'] ?? 0;
            $attempts++;

            if ($attempts >= 3) {
                Cache::put($key, [
                    'attempts' => $attempts,
                    'lockout_time' => now()->addHours(24)
                ], 86400);
            } else {
                Cache::put($key, [
                    'attempts' => $attempts,
                    'lockout_time' => null
                ], 86400);
            }
        }
    }
}
