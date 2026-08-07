<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateVapidKeys extends Command
{
    protected $signature = 'push:generate-vapid-keys';
    protected $description = 'Generate VAPID keys for Web Push Notifications';

    public function handle()
    {
        $key = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);

        if ($key === false) {
            $this->error('OpenSSL EC key generation failed: ' . openssl_error_string());
            $this->newLine();
            $this->warn('Alternative: Use an online VAPID key generator:');
            $this->line('  - https://web-push-codelab.github.io/');
            $this->line('  - https://pushpad.xyz/push-notifications-vapid-keys-generator');
            $this->newLine();
            $this->info('Then add the keys to your .env file:');
            $this->line('  VAPID_PUBLIC_KEY=your_public_key');
            $this->line('  VAPID_PRIVATE_KEY=your_private_key');
            return 1;
        }

        $details = openssl_pkey_get_details($key);
        $x = $details['ec']['x'];
        $y = $details['ec']['y'];
        $d = $details['ec']['d'];

        $publicKey = chr(0x04) . $x . $y;

        function base64url_encode($data) {
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        }

        $vapidPublicKey = base64url_encode($publicKey);
        $vapidPrivateKey = base64url_encode($d);

        $this->info('VAPID Keys Generated Successfully!');
        $this->newLine();
        $this->line('Add these to your .env file:');
        $this->newLine();
        $this->line("VAPID_PUBLIC_KEY={$vapidPublicKey}");
        $this->line("VAPID_PRIVATE_KEY={$vapidPrivateKey}");
        $this->newLine();

        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);

            if (strpos($envContent, 'VAPID_PUBLIC_KEY=') === false) {
                $envContent .= "\nVAPID_PUBLIC_KEY={$vapidPublicKey}\n";
                $envContent .= "VAPID_PRIVATE_KEY={$vapidPrivateKey}\n";
                file_put_contents($envPath, $envContent);
                $this->info('Keys have been added to .env file automatically.');
            } else {
                $this->warn('VAPID keys already exist in .env. Please update them manually.');
            }
        }

        openssl_pkey_free($key);
        return 0;
    }
}
