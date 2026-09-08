<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class SafeHtml
{
    protected static ?HtmlSanitizer $sanitizer = null;

    public static function clean(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return $html;
        }

        return self::sanitizer()->sanitize($html);
    }

    protected static function sanitizer(): HtmlSanitizer
    {
        if (self::$sanitizer) {
            return self::$sanitizer;
        }

        $config = (new HtmlSanitizerConfig())
            ->allowElement('p')
            ->allowElement('br')
            ->allowElement('strong')
            ->allowElement('b')
            ->allowElement('em')
            ->allowElement('i')
            ->allowElement('u')
            ->allowElement('s')
            ->allowElement('del')
            ->allowElement('code')
            ->allowElement('pre')
            ->allowElement('h2')
            ->allowElement('h3')
            ->allowElement('ul')
            ->allowElement('ol')
            ->allowElement('li')
            ->allowElement('blockquote')
            ->allowElement('hr')
            ->allowElement('a', ['href', 'target', 'rel'])
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'class'])
            ->allowLinkSchemes(['http', 'https', 'mailto', 'tel'])
            ->allowMediaSchemes(['http', 'https'])
            ->allowRelativeLinks()
            ->allowRelativeMedias()
            ->dropElement('script')
            ->dropElement('style')
            ->dropElement('iframe')
            ->dropElement('object')
            ->dropElement('embed')
            ->dropElement('form')
            ->withMaxInputLength(500_000);

        return self::$sanitizer = new HtmlSanitizer($config);
    }
}
