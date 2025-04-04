<?php

namespace App\Services;

namespace App\Services;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;


class JWKSVerifier
{
    protected $jwksUrl;

    public function __construct()
    {
        $this->jwksUrl = config('jwt.jwks_url');
    }

    /**
     */
    public function decodeJwtToken($token)
    {
        $jwks = $this->fetchJWKS();
        try {
            return JWT::decode($token, JWK::parseKeySet($jwks));
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     */
    protected function fetchJWKS()
    {
        return Http::get($this->jwksUrl)->json();
    }
}
