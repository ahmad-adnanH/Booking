<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->status !== 'active') {

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is inactive or suspended.'
                ], 403);
            }

            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive or suspended.');
        }

        return $next($request);
    }
}
