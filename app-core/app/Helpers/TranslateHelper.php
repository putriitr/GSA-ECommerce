<?php

namespace App\Helpers;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TranslateHelper
{
    /**
     * Simulate a translation based on the current locale for testing.
     *
     * @param string $text
     * @param string $locale
     * @return string
     */
    public static function translate($text, $locale)
    {
        // Jika locale adalah 'id', tambahkan keterangan bahwa ini adalah terjemahan untuk pengujian
        if ($locale == 'id') {
            return $text . ' (Diterjemahkan)';
        }

        // Jika locale adalah 'en', kembalikan teks asli untuk pengujian
        return $text;
    }
}
