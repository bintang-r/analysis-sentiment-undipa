<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1);
            $user = Auth::user();

            Cache::put('user-is-online-' . $user->id_232187, true, $expiresAt);

            User::query()
                ->where('id_232187', $user->id_232187)
                ->update(['last_seen_time_232187' => date('Y-m-d H:i:s')]);
        }

        return $next($request);
    }
}
