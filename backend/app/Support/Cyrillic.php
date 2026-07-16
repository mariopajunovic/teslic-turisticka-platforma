<?php

namespace App\Support;

class Cyrillic
{
    protected const MAP = [
        'DŽ' => 'Џ', 'Dž' => 'Џ', 'dž' => 'џ',
        'LJ' => 'Љ', 'Lj' => 'Љ', 'lj' => 'љ',
        'NJ' => 'Њ', 'Nj' => 'Њ', 'nj' => 'њ',

        'A' => 'А', 'B' => 'Б', 'C' => 'Ц', 'Č' => 'Ч', 'Ć' => 'Ћ',
        'D' => 'Д', 'Đ' => 'Ђ', 'E' => 'Е', 'F' => 'Ф', 'G' => 'Г',
        'H' => 'Х', 'I' => 'И', 'J' => 'Ј', 'K' => 'К', 'L' => 'Л',
        'M' => 'М', 'N' => 'Н', 'O' => 'О', 'P' => 'П', 'R' => 'Р',
        'S' => 'С', 'Š' => 'Ш', 'T' => 'Т', 'U' => 'У', 'V' => 'В',
        'Z' => 'З', 'Ž' => 'Ж',

        'a' => 'а', 'b' => 'б', 'c' => 'ц', 'č' => 'ч', 'ć' => 'ћ',
        'd' => 'д', 'đ' => 'ђ', 'e' => 'е', 'f' => 'ф', 'g' => 'г',
        'h' => 'х', 'i' => 'и', 'j' => 'ј', 'k' => 'к', 'l' => 'л',
        'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п', 'r' => 'р',
        's' => 'с', 'š' => 'ш', 't' => 'т', 'u' => 'у', 'v' => 'в',
        'z' => 'з', 'ž' => 'ж',
    ];

    protected const STRUCTURAL_KEYS = [
        'image', 'images', 'img', 'icon', 'color', 'colour', 'url', 'href', 'src',
        'poster', 'logo', 'avatar', 'brand_logo', 'email', 'lat', 'lng', 'height',
        'width', 'limit', 'key', 'slug', 'password', 'q', 'type', 'id', 'target',
        'variant', 'align', 'size', 'layout', 'style', 'class', 'media', 'gallery',
        'video', 'embed', 'link', 'route', 'anchor', 'value', 'kontakt_email',
        'kontakt_telefon', 'telefon', 'phone', 'brand_logo_tekst',
    ];

    protected const PROTECT = '/(<[^>]*>|&[#a-zA-Z0-9]+;|https?:\/\/[^\s"\'<>]+|[\w.+-]+@[\w-]+\.[\w.-]+)/u';

    public static function convert(?string $text): ?string
    {
        if ($text === null || $text === '') {
            return $text;
        }

        $parts = preg_split(self::PROTECT, $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $i => $part) {
            if ($i % 2 === 0 && $part !== '') {
                $parts[$i] = strtr($part, self::MAP);
            }
        }

        return implode('', $parts);
    }

    public static function deep(mixed $value, ?string $key = null): mixed
    {
        if (is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = self::deep($v, is_string($k) ? $k : $key);
            }

            return $out;
        }

        if (is_string($value)) {
            if ($key !== null && in_array($key, self::STRUCTURAL_KEYS, true)) {
                return $value;
            }

            if (self::looksStructural($value)) {
                return $value;
            }

            return self::convert($value);
        }

        return $value;
    }

    protected static function looksStructural(string $value): bool
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            return true;
        }

        if (preg_match('/^(#?[0-9a-fA-F]{3,8}|https?:\/\/|\/|#|mailto:|tel:)/', $trimmed)) {
            return true;
        }

        if (preg_match('/^[a-z0-9._\-\/]+$/', $trimmed)) {
            return true;
        }

        if (filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}
