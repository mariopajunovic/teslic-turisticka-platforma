<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
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
            'izvod' => ['nullable', 'string'],
            'sadrzaj' => ['nullable', 'string'],
            'action' => ['required', 'in:nacrt,posalji'],
        ];
    }
}
