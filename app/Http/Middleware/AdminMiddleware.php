<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// panggil library jwt
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $jwt = $request->bearerToken();

            $decoded = JWT::decode($jwt,new Key(env('JWT_SECRET_KEY'),'HS256'));

            if($decoded->role == 'admin') {
                return $next($request);
            } else {
                return response()->json("Unauthorized",401);
            }
        
        } catch (ExpiredException $e) {
            return response()->json($e->getMessage(),400);
        }
    }
}
