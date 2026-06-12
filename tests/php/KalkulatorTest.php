<?php

require_once __DIR__ . '/../../bab-12-php/kalkulator_logic.php';

use PHPUnit\Framework\TestCase;

class KalkulatorTest extends TestCase
{
    public function testAddition(): void
    {
        $this->assertEquals(8, hitung(5, 3, '+'));
    }

    public function testAdditionWithNegatives(): void
    {
        $this->assertEquals(-3, hitung(-1, -2, '+'));
    }

    public function testAdditionWithZero(): void
    {
        $this->assertEquals(5, hitung(5, 0, '+'));
    }

    public function testSubtraction(): void
    {
        $this->assertEquals(7, hitung(10, 3, '-'));
    }

    public function testSubtractionResultingNegative(): void
    {
        $this->assertEquals(-7, hitung(3, 10, '-'));
    }

    public function testMultiplication(): void
    {
        $this->assertEquals(12, hitung(3, 4, '*'));
    }

    public function testMultiplicationByZero(): void
    {
        $this->assertEquals(0, hitung(5, 0, '*'));
    }

    public function testMultiplicationNegatives(): void
    {
        $this->assertEquals(12, hitung(-3, -4, '*'));
    }

    public function testDivision(): void
    {
        $this->assertEquals(5, hitung(10, 2, '/'));
    }

    public function testDivisionWithDecimalResult(): void
    {
        $this->assertEquals(3.5, hitung(7, 2, '/'));
    }

    public function testDivisionByZero(): void
    {
        $this->assertEquals('Error: Pembagi tidak boleh 0!', hitung(10, 0, '/'));
    }

    public function testDivisionOfZero(): void
    {
        $this->assertEquals(0, hitung(0, 5, '/'));
    }

    public function testUnknownOperator(): void
    {
        $this->assertEquals('Error: Operasi tidak dikenal!', hitung(5, 3, '%'));
    }

    public function testFloatingPointAddition(): void
    {
        $this->assertEquals(4.0, hitung(1.5, 2.5, '+'));
    }

    public function testFloatingPointDivision(): void
    {
        $this->assertEqualsWithDelta(3.333, hitung(10, 3, '/'), 0.001);
    }
}
