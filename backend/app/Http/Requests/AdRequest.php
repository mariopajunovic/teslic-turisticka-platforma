<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
            'izdavac' => ['nullable', 'string', 'max:255'],
            'lokacija' => ['nullable', 'string', 'max:255'],
            'rok' => ['nullable', 'date'],
            'opis_dug' => ['nullable', 'string'],
            'action' => ['required', 'in:nacrt,posalji'],
        ];
    }
}
