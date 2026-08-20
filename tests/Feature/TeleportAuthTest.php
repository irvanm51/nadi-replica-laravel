<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\WithTeleportJwt;
use Tests\TestCase;

class TeleportAuthTest extends TestCase
{
    use RefreshDatabase, WithTeleportJwt;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpTeleportJwtFixture();
    }

    public function test_staf_token_reaches_staf_dashboard(): void
    {
        $jwt = $this->teleportJwtFor('staf@nadi.ac.id', ['nadi-staf']);

        $this->withHeader('Teleport-Jwt-Assertion', $jwt)
            ->get('/staf/dashboard')
            ->assertOk();

        $this->assertDatabaseHas('users', ['email' => 'staf@nadi.ac.id', 'role' => 'staf']);
    }

    public function test_dosen_token_reaches_dosen_dashboard(): void
    {
        $jwt = $this->teleportJwtFor('dosen@nadi.ac.id', ['nadi-dosen']);

        $this->withHeader('Teleport-Jwt-Assertion', $jwt)
            ->get('/dosen/dashboard')
            ->assertOk();
    }

    public function test_staf_token_cannot_reach_dosen_dashboard(): void
    {
        $jwt = $this->teleportJwtFor('staf@nadi.ac.id', ['nadi-staf']);

        $this->withHeader('Teleport-Jwt-Assertion', $jwt)
            ->get('/dosen/dashboard')
            ->assertForbidden();
    }

    public function test_unmapped_role_is_rejected(): void
    {
        $jwt = $this->teleportJwtFor('ghost@nadi.ac.id', ['some-other-role']);

        $this->withHeader('Teleport-Jwt-Assertion', $jwt)
            ->get('/dashboard')
            ->assertForbidden();
    }

    public function test_expired_token_is_rejected(): void
    {
        $now = time();
        $jwt = $this->teleportJwtFor('dosen@nadi.ac.id', ['nadi-dosen'], [
            'iat' => $now - 7200,
            'nbf' => $now - 7200,
            'exp' => $now - 3600,
        ]);

        $this->withHeader('Teleport-Jwt-Assertion', $jwt)
            ->get('/dashboard')
            ->assertForbidden();
    }

    public function test_tampered_signature_is_rejected(): void
    {
        $jwt = $this->teleportJwtFor('dosen@nadi.ac.id', ['nadi-dosen']);
        $tampered = substr($jwt, 0, -5).'aaaaa';

        $this->withHeader('Teleport-Jwt-Assertion', $tampered)
            ->get('/dashboard')
            ->assertForbidden();
    }

    public function test_missing_header_is_rejected(): void
    {
        $this->get('/dashboard')->assertForbidden();
    }

    public function test_untrusted_peer_is_rejected_even_with_valid_token(): void
    {
        config(['teleport.trusted_proxy_cidrs' => ['10.0.0.0/8']]);

        $jwt = $this->teleportJwtFor('dosen@nadi.ac.id', ['nadi-dosen']);

        $this->withHeader('Teleport-Jwt-Assertion', $jwt)
            ->get('/dashboard')
            ->assertForbidden();
    }
}
