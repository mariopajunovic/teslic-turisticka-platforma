<?php

namespace App\Http\Requests;

use App\Rules\Captcha;
use App\Settings\SiteSettings;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $captchaOn = filled(app(SiteSettings::class)->captcha_site_key);

        return [
            'ime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'tema' => ['nullable', 'string', 'max:255'],
            'poruka' => ['required', 'string', 'max:5000'],
            'captcha' => $captchaOn ? ['required', new Captcha()] : ['nullable'],
        ];
    }
}
