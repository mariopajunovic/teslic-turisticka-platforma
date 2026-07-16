<?php

namespace App\Support;

use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQRCode;

class TwoFactor
{
    public function generateSecret(): string
    {
        return (new Google2FA)->generateSecretKey();
    }

    public function qr(string $holder, string $secret): string
    {
        return (new Google2FAQRCode)->getQRCodeInline('TO Teslić Administracija', $holder, $secret);
    }

    public function verify(string $secret, string $code): bool
    {
        return (new Google2FA)->verifyKey($secret, preg_replace('/\D/', '', $code));
    }

    public function recoveryCodes(int $n = 8): array
    {
        return collect(range(1, $n))
            ->map(fn () => Str::lower(Str::random(4).'-'.Str::random(4)))
            ->all();
    }
}
