<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAddZeroWithZero()
    {
        $this->assertEquals(0, Calculator::calculate(0, 0, Calculator::ADD)); 
    }

    public function testTwentyTimesTwenty()
    {
        $this->assertEquals(400, Calculator::calculate(20, 20, Calculator::TIMES)); 
    }

    public function testZeroMinusOne()
    {
        $this->assertEquals(-1, Calculator::calculate(0, 1, Calculator::MINUS)); 
    }
}
