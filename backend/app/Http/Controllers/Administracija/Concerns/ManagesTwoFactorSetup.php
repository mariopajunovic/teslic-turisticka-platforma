<?php

namespace App\Http\Controllers\Administracija\Concerns;

use App\Support\TwoFactor;

trait ManagesTwoFactorSetup
{
    protected string $pendingKey = 'administracija.2fa.setup.secret';

    protected function pendingSecret(): string
    {
        if (! session()->has($this->pendingKey)) {
            session()->put($this->pendingKey, app(TwoFactor::class)->generateSecret());
        }

        return session()->get($this->pendingKey);
    }

    protected function clearPendingSecret(): void
    {
        session()->forget($this->pendingKey);
    }

    protected function setupPayload($admin): array
    {
        $secret = $this->pendingSecret();

        return [
            'qr' => app(TwoFactor::class)->qr($admin->getAppAuthenticationHolderName(), $secret),
            'secret' => $secret,
        ];
    }

    protected function aktiviraj2fa($admin, string $code): ?array
    {
        $secret = $this->pendingSecret();

        if (! app(TwoFactor::class)->verify($secret, $code)) {
            return null;
        }

        $codes = app(TwoFactor::class)->recoveryCodes();
        $admin->saveAppAuthenticationSecret($secret);
        $admin->saveAppAuthenticationRecoveryCodes($codes);
        $this->clearPendingSecret();

        return $codes;
    }
}
