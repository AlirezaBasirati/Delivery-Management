<?php

namespace App\Services\AuthenticationService\Helper\V1;

class Helper
{
    public static function standardMobile($username): string
    {
        return '0' . ltrim(self::numbersFaEn(self::numbersArEn($username)), '0');
    }

    public static function numbersArEn($number): string
    {
        $numbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        return (string)str_replace($numbers, array_keys($numbers), $number);
    }

    public static function numbersFaEn($number): string
    {
        $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return (string)str_replace($numbers, array_keys($numbers), $number);
    }

    public static function slug($string, $separator = '-')
    {
        if (is_array($string)) {
            $string = implode($separator, $string);
        }
        $string = trim($string);
        $string = mb_strtolower($string, 'UTF-8');
        $string = preg_replace('/\s+/', ' ', $string);
        $replaces = [
            [
                'search'  => [' ', '‌'],
                'replace' => $separator
            ],
            [
                'search'  => ['؟', '?', '.', ',', '(', ')', '&', '=', '/', '\\', '%'],
                'replace' => ''
            ],
        ];
        array_map(fn($item) => str_replace($item['search'], $item['replace'], $string), $replaces);

        return $string;
    }

    public static function isMobile($value): bool
    {
        return (bool)preg_match('/^((0)(9){1}[0-9]{9})+$/', $value);
    }

    public static function isEmail($value): bool
    {
        return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
