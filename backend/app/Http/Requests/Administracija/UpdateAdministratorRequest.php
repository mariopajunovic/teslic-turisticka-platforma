<?php

namespace App\Http\Requests\Administracija;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdministratorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ime' => is_string($this->ime) ? trim($this->ime) : $this->ime,
            'email' => is_string($this->email) ? trim(mb_strtolower($this->email)) : $this->email,
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('administrator')?->id;

        return [
            'ime' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('admins', 'email')->ignore($id)],
            'uloga' => ['nullable', 'string', Rule::exists('roles', 'name')->where('guard_name', 'admin')],
        ];
    }

    public function messages(): array
    {
        return [
            'ime.required' => 'Ime i prezime su obavezni.',
            'ime.min' => 'Ime mora imati najmanje 2 znaka.',
            'email.required' => 'E-mail je obavezan.',
            'email.email' => 'Unesite ispravnu e-mail adresu.',
            'email.unique' => 'Administrator s tom e-mail adresom već postoji.',
            'uloga.exists' => 'Odabrana uloga nije važeća.',
        ];
    }

    public function attributes(): array
    {
        return ['ime' => 'ime', 'email' => 'e-mail', 'uloga' => 'uloga'];
    }
}
