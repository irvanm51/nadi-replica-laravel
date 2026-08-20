<?php

namespace App\Console\Commands;

use Firebase\JWT\JWT;
use Illuminate\Console\Command;

class TeleportIssueDevToken extends Command
{
    protected $signature = 'teleport:issue-dev-token {email} {--role=staf}';

    protected $description = 'Sign a Teleport-shaped dev JWT for exercising the app without a live Teleport cluster (local/testing only)';

    public function handle(): int
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->error('This command only runs in local/testing environments.');

            return self::FAILURE;
        }

        $email = $this->argument('email');
        $appRole = $this->option('role');

        $teleportRole = array_search($appRole, config('teleport.role_map'), true);

        if ($teleportRole === false) {
            $this->error("No teleport.role_map entry maps to app role [{$appRole}].");

            return self::FAILURE;
        }

        [$privateKey, $publicKeyPath] = $this->devKeyPair();

        $now = time();

        $token = JWT::encode([
            'sub' => $email,
            'username' => $email,
            'name' => $email,
            'roles' => [$teleportRole],
            'aud' => config('teleport.audience'),
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + 3600,
        ], $privateKey, 'RS256');

        $this->components->info("Dev Teleport JWT for {$email} ({$appRole})");
        $this->line($token);
        $this->newLine();
        $this->line('Try it: curl -H "'.config('teleport.header_name').': '.$token.'" '.rtrim(config('app.url'), '/').'/dashboard');
        $this->newLine();
        $this->comment('Point teleport.signing_key.static_file at: '.$publicKeyPath);

        return self::SUCCESS;
    }

    /**
     * @return array{0: string, 1: string} [privateKeyPem, publicKeyPath]
     */
    private function devKeyPair(): array
    {
        $dir = storage_path('teleport-dev');
        $privatePath = $dir.'/dev-signing-key.pem';
        $publicPath = $dir.'/dev-signing-key.pub.pem';

        if (! is_dir($dir)) {
            mkdir($dir, 0700, true);
        }

        if (! is_readable($privatePath)) {
            $resource = openssl_pkey_new([
                'private_key_bits' => 2048,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ]);

            openssl_pkey_export($resource, $privateKeyPem);
            $publicKeyPem = openssl_pkey_get_details($resource)['key'];

            file_put_contents($privatePath, $privateKeyPem);
            file_put_contents($publicPath, $publicKeyPem);
            chmod($privatePath, 0600);

            $this->components->info("Generated a new dev signing keypair at {$dir}");
        }

        return [file_get_contents($privatePath), $publicPath];
    }
}
