<?php

namespace Tests\AppBundle\Converter;

use AppBundle\Converter\NumberToWordConverter;
use PHPUnit\Framework\TestCase;

class NumberToWordConverterTest extends TestCase
{
    public function testHandleZero()
    {
        $this->assertEquals('nol', NumberToWordConverter::handle(0)); 
    }

    public function testHandleTwenty()
    {
        $this->assertEquals('dua puluh', NumberToWordConverter::handle(20)); 
    }

    public function testHandleOneHundred()
    {
        $this->assertEquals('seratus', NumberToWordConverter::handle(100)); 
    }

    public function testHandleTripleNine()
    {
        $this->assertEquals('sembilan ratus sembilan puluh sembilan', NumberToWordConverter::handle(999)); 
    }
}
