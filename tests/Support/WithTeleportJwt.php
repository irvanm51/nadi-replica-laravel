<?php

namespace Tests\Support;

use Firebase\JWT\JWT;

trait WithTeleportJwt
{
    protected function setUpTeleportJwtFixture(): void
    {
        config([
            'teleport.enabled' => true,
            'teleport.header_name' => 'Teleport-Jwt-Assertion',
            'teleport.audience' => 'https://nadi.test',
            'teleport.signing_key.source' => 'static_file',
            'teleport.signing_key.static_file' => base_path('tests/fixtures/teleport-dev-key.pub.pem'),
            'teleport.trusted_proxy_cidrs' => [],
        ]);
    }

    /**
     * @param  array<int, string>  $roles
     * @param  array<string, mixed>  $overrides
     */
    protected function teleportJwtFor(string $email, array $roles, array $overrides = []): string
    {
        $now = time();

        $claims = array_merge([
            'sub' => $email,
            'username' => $email,
            'name' => $email,
            'roles' => $roles,
            'aud' => config('teleport.audience'),
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + 3600,
        ], $overrides);

        $privateKey = file_get_contents(base_path('tests/fixtures/teleport-dev-key.pem'));

        return JWT::encode($claims, $privateKey, 'RS256');
    }
}
