<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmailVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('student')->user();
        if ( $user && is_null($user->email_verified_at) ) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Email not verified. Please verify your email to continue.',
            ], 403);
        }

        return $next($request);
    }
}
