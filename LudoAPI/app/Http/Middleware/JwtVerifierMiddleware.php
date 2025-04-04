<?php

namespace App\Http\Middleware;

use App\Services\JWKSVerifier;
use Closure;
use Illuminate\Http\Request;
use League\Csv\Exception;
use Symfony\Component\HttpFoundation\Response;

class JwtVerifierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payload = (new JWKSVerifier())->decodeJwtToken($request->bearerToken());

        if (empty($payload)) {
            throw new Exception('JWT token is invalid');
        }

        $request->attributes->add(['payload' => $payload]);

        return $next($request);
    }
}
