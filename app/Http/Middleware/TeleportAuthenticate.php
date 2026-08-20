<?php

namespace App\Http\Middleware;

use App\Exceptions\TeleportJwtInvalidException;
use App\Services\Teleport\TeleportJwtVerifier;
use App\Services\Teleport\TeleportUserProvisioner;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class TeleportAuthenticate
{
    public function __construct(
        private readonly TeleportJwtVerifier $verifier,
        private readonly TeleportUserProvisioner $provisioner,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        // Non-bypassable safety valve: local_bypass must never be honored in
        // production regardless of what the env/config says.
        if (config('teleport.local_bypass') && app()->environment('production')) {
            abort(500, 'teleport.local_bypass must never be enabled in production.');
        }

        if (! config('teleport.enabled') && ! config('teleport.local_bypass')) {
            abort(500, 'Teleport authentication is disabled.');
        }

        if (! $this->fromTrustedPeer($request)) {
            $this->reject($request, 'untrusted peer address');
        }

        $jwt = $request->header(config('teleport.header_name'));

        if (! $jwt) {
            $this->reject($request, 'missing Teleport JWT header');
        }

        try {
            $claims = $this->verifier->verify($jwt);
            $user = $this->provisioner->resolve($claims);
        } catch (TeleportJwtInvalidException $e) {
            $this->reject($request, $e->getMessage());
        }

        Auth::guard('api')->setUser($user);

        return $next($request);
    }

    private function fromTrustedPeer(Request $request): bool
    {
        $cidrs = config('teleport.trusted_proxy_cidrs');

        if (empty($cidrs)) {
            return true;
        }

        return IpUtils::checkIp((string) $request->server('REMOTE_ADDR'), $cidrs);
    }

    private function reject(Request $request, string $reason): never
    {
        Log::warning('teleport.auth.rejected', [
            'reason' => $reason,
            'path' => $request->path(),
            'ip' => $request->server('REMOTE_ADDR'),
        ]);

        abort(403);
    }
}
