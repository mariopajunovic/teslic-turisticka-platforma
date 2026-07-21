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
            'drustvene' => ['nullable', 'array'],
            'drustvene.facebook' => ['nullable', 'string', 'max:255'],
            'drustvene.instagram' => ['nullable', 'string', 'max:255'],
            'drustvene.youtube' => ['nullable', 'string', 'max:255'],
            'drustvene.tiktok' => ['nullable', 'string', 'max:255'],
            'usluge' => ['nullable', 'string', 'max:2000'],
            'nacin_placanja' => ['nullable', 'array'],
            'nacin_placanja.gotovina' => ['boolean'],
            'nacin_placanja.kartica' => ['boolean'],
            'nacin_placanja.virman' => ['boolean'],
            'cijena_raspon' => ['nullable', 'in:€,€€,€€€'],
            'godina_osnivanja' => ['nullable', 'integer', 'min:1800', 'max:2100'],
            'jib' => ['nullable', 'digits:13'],
            'radno_vrijeme' => ['nullable', 'array'],
            'radno_vrijeme.*.zatvoreno' => ['boolean'],
            'radno_vrijeme.*.od' => ['nullable', 'string', 'max:10'],
            'radno_vrijeme.*.do' => ['nullable', 'string', 'max:10'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'action' => ['required', 'in:nacrt,posalji'],
            'naslovna' => ['nullable', 'image', 'max:4096'],
            'galerija' => ['nullable', 'array'],
            'galerija.*' => ['image', 'max:4096'],
        ];
    }
}
