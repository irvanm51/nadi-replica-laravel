<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Teleport Integration Enabled
    |--------------------------------------------------------------------------
    |
    | Hard kill-switch. When disabled, TeleportAuthenticate refuses every
    | request outside local/testing (see the middleware's local_bypass check).
    |
    */

    'enabled' => env('TELEPORT_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | JWT Assertion Header
    |--------------------------------------------------------------------------
    |
    | Name of the header Teleport's Application Access proxy injects the
    | signed JWT assertion under on every proxied request.
    |
    | TODO: confirm the exact header name against the Teleport cluster/version
    | actually in use before deploying — this is the documented convention,
    | not something verified against this project's cluster.
    |
    */

    'header_name' => env('TELEPORT_JWT_HEADER', 'Teleport-Jwt-Assertion'),

    /*
    |--------------------------------------------------------------------------
    | Expected Audience
    |--------------------------------------------------------------------------
    |
    | This app's public address as registered in the Teleport `app` resource.
    | Must match the `aud` claim Teleport puts in the JWT, or the token is
    | rejected.
    |
    */

    'audience' => env('TELEPORT_APP_AUDIENCE'),

    /*
    |--------------------------------------------------------------------------
    | Signing Key Source
    |--------------------------------------------------------------------------
    |
    | How to obtain Teleport's JWT-signing public key(s):
    |   - 'jwks_url'    fetch a JWKS document over HTTPS and cache it.
    |   - 'static_file' read a PEM public key from disk (local/testing, or
    |                    air-gapped deployments where JWKS can't be fetched).
    |
    | TODO: confirm the JWKS discovery URL (or the `tctl auth export
    | --type=jwt` export/rotation procedure) against the Teleport docs for
    | the cluster's actual version — do not assume a guessed URL is correct.
    |
    */

    'signing_key' => [
        'source' => env('TELEPORT_SIGNING_KEY_SOURCE', 'jwks_url'),
        'jwks_url' => env('TELEPORT_JWKS_URL'),
        'static_file' => env('TELEPORT_SIGNING_KEY_PATH'),
        'cache_key' => 'teleport:jwks',
        'cache_ttl' => env('TELEPORT_JWKS_CACHE_TTL', 3600),
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Mapping
    |--------------------------------------------------------------------------
    |
    | Ordered map of Teleport role name => this app's internal `role` enum
    | value. When a user's Teleport `roles` claim contains more than one
    | mapped role, the FIRST entry below (in declared order) that matches
    | wins — this is an explicit precedence rule, not an arbitrary one.
    |
    */

    'role_map' => [
        'nadi-staf' => 'staf',
        'nadi-dosen' => 'dosen',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reject Unmapped Roles
    |--------------------------------------------------------------------------
    |
    | If none of the user's Teleport roles match role_map, reject the
    | request (403) rather than silently defaulting to some role. A mapped
    | Teleport user with no matching entry here means role_map is out of
    | sync with Teleport RBAC and needs fixing, not a fallback.
    |
    */

    'reject_unmapped_roles' => true,

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxy CIDRs
    |--------------------------------------------------------------------------
    |
    | Defense-in-depth only — NOT the real security boundary (that's JWT
    | signature verification). Comma-separated CIDR list of the Teleport
    | proxy/agent's known IP(s). When non-empty, TeleportAuthenticate checks
    | the raw TCP peer address against this list before trusting the header
    | at all. Leave empty to skip this check (e.g. in local/testing).
    |
    */

    'trusted_proxy_cidrs' => array_filter(explode(',', (string) env('TELEPORT_TRUSTED_PROXY_CIDRS', ''))),

    /*
    |--------------------------------------------------------------------------
    | Local Bypass (dev/testing only)
    |--------------------------------------------------------------------------
    |
    | Lets local/testing environments exercise the app without a live
    | Teleport cluster in front of it, via manually-issued dev tokens (see
    | the teleport:issue-dev-token Artisan command). TeleportAuthenticate
    | hard-refuses to honor this outside local/testing regardless of this
    | value — it is not a switch that can accidentally open production.
    |
    */

    'local_bypass' => env('TELEPORT_LOCAL_BYPASS', false),

    /*
    |--------------------------------------------------------------------------
    | Logout URL
    |--------------------------------------------------------------------------
    |
    | Teleport owns the real session; this app cannot end it directly, so
    | logout redirects here instead.
    |
    | TODO: confirm the exact logout convention for Application Access on
    | the cluster in use.
    |
    */

    'logout_url' => env('TELEPORT_LOGOUT_URL', '/'),

];
