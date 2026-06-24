<?php

namespace App\Http\Requests;

use App\Rules\Captcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'tema' => ['nullable', 'string', 'max:255'],
            'poruka' => ['required', 'string', 'max:5000'],
            'captcha' => ['nullable', new Captcha()],
        ];
    }
}
