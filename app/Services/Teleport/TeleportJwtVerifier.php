<?php

namespace App\Services\Teleport;

use App\Exceptions\TeleportJwtInvalidException;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class TeleportJwtVerifier
{
    /**
     * Verify a Teleport-signed JWT assertion and return its claims as an array.
     *
     * @throws TeleportJwtInvalidException
     */
    public function verify(string $jwt): array
    {
        try {
            $decoded = JWT::decode($jwt, $this->resolveKeys());
        } catch (Throwable $e) {
            throw new TeleportJwtInvalidException('Teleport JWT failed signature/expiry validation: '.$e->getMessage(), previous: $e);
        }

        $claims = (array) json_decode(json_encode($decoded), true);

        $this->assertAudience($claims);

        return $claims;
    }

    /**
     * @return Key|array<string, Key>
     */
    private function resolveKeys(): Key|array
    {
        $source = config('teleport.signing_key.source');

        return match ($source) {
            'static_file' => $this->keyFromStaticFile(),
            'jwks_url' => $this->keysFromJwks(),
            default => throw new TeleportJwtInvalidException("Unknown teleport.signing_key.source [{$source}]."),
        };
    }

    private function keyFromStaticFile(): Key
    {
        $path = config('teleport.signing_key.static_file');

        if (! $path || ! is_readable($path)) {
            throw new TeleportJwtInvalidException("Teleport signing key file not found/readable at [{$path}].");
        }

        $pem = file_get_contents($path);

        // Algorithm is fixed here rather than trusting the token header, since
        // a single static PEM implies a single known key/algorithm pairing.
        return new Key($pem, 'RS256');
    }

    /**
     * @return array<string, Key>
     */
    private function keysFromJwks(): array
    {
        $url = config('teleport.signing_key.jwks_url');

        if (! $url) {
            throw new TeleportJwtInvalidException('teleport.signing_key.jwks_url is not configured.');
        }

        $jwks = Cache::remember(
            config('teleport.signing_key.cache_key'),
            (int) config('teleport.signing_key.cache_ttl'),
            function () use ($url) {
                $response = Http::timeout(5)->get($url);
                $response->throw();

                return $response->json();
            }
        );

        return JWK::parseKeySet($jwks);
    }

    private function assertAudience(array $claims): void
    {
        $expected = config('teleport.audience');

        if (! $expected) {
            throw new TeleportJwtInvalidException('teleport.audience is not configured.');
        }

        $audience = $claims['aud'] ?? null;
        $audiences = is_array($audience) ? $audience : [$audience];

        if (! in_array($expected, $audiences, true)) {
            throw new TeleportJwtInvalidException('Teleport JWT audience does not match this app.');
        }
    }
}
