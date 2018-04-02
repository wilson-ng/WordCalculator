<?php
declare(strict_types=1);

namespace AppBundle\Calculator;

class Calculator 
{
    const ADD = 'tambah';
    const MINUS = 'kurang';
    const TIMES = 'kali';

    public static function canCalculate(String $operator): bool
    {
        return in_array($operator, [self::ADD, self::MINUS, self::TIMES]);
    }

    public static function calculate(int $leftSide, int $rightSide, $operator): int
    {
        if (self::ADD === $operator) {
            return $leftSide + $rightSide;
        } elseif (self::MINUS === $operator) {
            return $leftSide - $rightSide;
        } elseif (self::TIMES === $operator) {
            return $leftSide * $rightSide;
        }
    }
}
