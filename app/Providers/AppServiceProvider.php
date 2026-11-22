<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('panel-login', function (Request $request): array {
            $username = $request->input('username');
            $limits = [Limit::perMinute(5)->by('ip:'.$request->ip())];

            if (is_string($username) && $username !== '' && Str::length($username) <= 100) {
                $limits[] = Limit::perMinutes(15, 10)
                    ->by('username:'.hash('sha256', Str::lower(trim($username))));
            }

            $blocked = function (Request $request, array $headers) {
                $seconds = (int) $headers['Retry-After'];
                $message = "Terlalu banyak percobaan masuk. Coba lagi dalam {$seconds} detik.";

                return $request->expectsJson()
                    ? response()->json(['message' => $message], 429, $headers)
                    : response()->view('admin.login', ['rateLimitMessage' => $message], 429, $headers);
            };

            return array_map(fn (Limit $limit): Limit => $limit->response($blocked), $limits);
        });
    }
}
