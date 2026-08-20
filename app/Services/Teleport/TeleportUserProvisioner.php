<?php

namespace App\Services\Teleport;

use App\Exceptions\TeleportJwtInvalidException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeleportUserProvisioner
{
    /**
     * Resolve the local User for a verified Teleport JWT's claims, mapping
     * Teleport roles to this app's internal role enum and provisioning the
     * user just-in-time if this is their first request.
     *
     * @throws TeleportJwtInvalidException
     */
    public function resolve(array $claims): User
    {
        $email = $this->identityClaim($claims);
        $role = $this->mapRole($claims);

        return User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $claims['name'] ?? $email,
                'role' => $role,
                'password' => Hash::make(Str::random(40)),
            ]
        );
    }

    private function identityClaim(array $claims): string
    {
        // TODO: confirm against the deployed Teleport cluster whether `sub`
        // reliably carries an email address (e.g. when backed by an OIDC/SAML
        // upstream) or whether a dedicated identity column decoupled from
        // `email` is needed instead.
        $identity = $claims['username'] ?? $claims['sub'] ?? null;

        if (! $identity) {
            throw new TeleportJwtInvalidException('Teleport JWT is missing a username/sub claim.');
        }

        return $identity;
    }

    private function mapRole(array $claims): string
    {
        $teleportRoles = (array) ($claims['roles'] ?? []);
        $map = config('teleport.role_map');

        foreach ($map as $teleportRole => $appRole) {
            if (in_array($teleportRole, $teleportRoles, true)) {
                return $appRole;
            }
        }

        if (config('teleport.reject_unmapped_roles')) {
            throw new TeleportJwtInvalidException(
                'Teleport roles ['.implode(', ', $teleportRoles).'] do not match any entry in teleport.role_map.'
            );
        }

        throw new TeleportJwtInvalidException('No Teleport role mapped and reject_unmapped_roles is disabled with no default configured.');
    }
}
