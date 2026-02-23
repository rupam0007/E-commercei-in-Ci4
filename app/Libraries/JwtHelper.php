<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    private string $key;
    private string $algo = 'HS256';
    private int $ttl;

    public function __construct()
    {
        $this->key = env('JWT_SECRET', 'change_this_super_secret_key_32chars');
        $this->ttl = (int) env('JWT_TTL', 86400); // 24 hours default
    }

    public function generate(array $payload): string
    {
        $now = time();
        $data = array_merge($payload, [
            'iat' => $now,
            'exp' => $now + $this->ttl,
        ]);
        return JWT::encode($data, $this->key, $this->algo);
    }

    public function decode(string $token): ?object
    {
        try {
            return JWT::decode($token, new Key($this->key, $this->algo));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }
}
