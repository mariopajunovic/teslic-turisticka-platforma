<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiznisDogadjajRequest extends FormRequest
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
            'datum' => ['required', 'date'],
            'vrijeme' => ['nullable', 'string', 'max:100'],
            'lokacija' => ['nullable', 'string', 'max:255'],
            'organizator' => ['nullable', 'string', 'max:255'],
            'opis_dug' => ['nullable', 'string'],
            'action' => ['required', 'in:nacrt,posalji'],
        ];
    }
}
