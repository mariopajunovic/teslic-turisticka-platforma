<?php

namespace App\Http\Requests\Administracija;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class StoreUlogaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'naziv' => is_string($this->naziv) ? trim($this->naziv) : $this->naziv,
            'opis' => is_string($this->opis) ? trim($this->opis) : $this->opis,
        ]);
    }

    public function rules(): array
    {
        return [
            'naziv' => [
                'required',
                'string',
                'min:2',
                'max:60',
                'regex:/^[\pL0-9][\pL0-9 \-]*$/u',
                function ($attribute, $value, $fail) {
                    $kljuc = Str::lower(trim((string) $value));

                    $postoji = Role::where('guard_name', 'admin')
                        ->whereRaw('LOWER(name) = ?', [$kljuc])
                        ->exists();

                    if ($postoji) {
                        $fail('Uloga s tim nazivom već postoji.');
                    }
                },
            ],
            'opis' => ['nullable', 'string', 'max:255'],
            'dozvole' => ['array'],
            'dozvole.*' => [
                'string',
                Rule::exists('permissions', 'name')->where('guard_name', 'admin'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'naziv.required' => 'Naziv uloge je obavezan.',
            'naziv.min' => 'Naziv mora imati najmanje 2 znaka.',
            'naziv.max' => 'Naziv može imati najviše 60 znakova.',
            'naziv.regex' => 'Naziv može sadržavati samo slova, brojeve, razmak i crticu.',
            'opis.max' => 'Opis može imati najviše 255 znakova.',
            'dozvole.array' => 'Neispravan format dozvola.',
            'dozvole.*.exists' => 'Odabrana dozvola nije važeća.',
        ];
    }

    public function attributes(): array
    {
        return [
            'naziv' => 'naziv uloge',
            'opis' => 'opis',
            'dozvole' => 'dozvole',
        ];
    }
}
