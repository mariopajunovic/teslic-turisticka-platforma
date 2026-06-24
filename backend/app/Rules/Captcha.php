<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Captcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.turnstile.secret');

        if (! $secret) {
            return;
        }

        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            ['secret' => $secret, 'response' => $value],
        );

        if (! $response->json('success')) {
            $fail('Potvrda da niste robot nije uspjela. Pokušajte ponovo.');
        }
    }
}
