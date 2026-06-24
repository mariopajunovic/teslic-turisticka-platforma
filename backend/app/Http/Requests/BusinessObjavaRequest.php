<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessObjavaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'naslov' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'opis' => ['nullable', 'string', 'max:500'],
            'opis_dug' => ['nullable', 'string'],
            'lokacija' => ['nullable', 'string', 'max:255'],
            'kontakt' => ['nullable', 'array'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'action' => ['required', 'in:nacrt,posalji'],
            'naslovna' => ['nullable', 'image', 'max:4096'],
            'galerija' => ['nullable', 'array'],
            'galerija.*' => ['image', 'max:4096'],
        ];
    }
}
