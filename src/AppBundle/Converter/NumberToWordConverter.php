<?php
declare(strict_types=1);

namespace AppBundle\Converter;

class NumberToWordConverter
{
    public static function handle(int $number): String 
    {
        if (0 === $number) {
            return 'nol';
        }

        return rtrim(ltrim(self::convert($number)));
    }

    public static function convert(int $number): String 
    {
        $wordNumber = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($number >=  0 && $number < 12) {
            return ' ' . $wordNumber[$number];
        } elseif ($number < 20) {
            return self::convert($number - 10) . ' belas';
        } elseif ($number < 100) {
            return self::convert((int) floor($number / 10)) . ' puluh' . self::convert($number % 10);
        } elseif ($number < 200) { 
            return 'seratus ' . self::convert($number - 100);
        } elseif ($number < 1000) { 
            return self::convert((int) floor($number / 100)) . ' ratus' . self::convert($number % 100);
        }
    } 
}
