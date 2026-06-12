<?php

require_once __DIR__ . '/../../bab-11-javascript2/Modul 11/hitung_imt.php';

use PHPUnit\Framework\TestCase;

class HitungIMTTest extends TestCase
{
    public function testNormalWeight(): void
    {
        // 55 kg, 1.60 m → IMT ≈ 21.48 → Normal
        $result = hitungIMT(55, 1.60);
        $this->assertEquals('Normal', $result['kategori']);
        $this->assertEquals(21.48, $result['imt']);
    }

    public function testUnderweight(): void
    {
        // 40 kg, 1.70 m → IMT ≈ 13.84 → Kurus
        $result = hitungIMT(40, 1.70);
        $this->assertEquals('Kurus', $result['kategori']);
        $this->assertLessThan(18.5, $result['imt']);
    }

    public function testOverweight(): void
    {
        // 80 kg, 1.70 m → IMT ≈ 27.68 → Gemuk
        $result = hitungIMT(80, 1.70);
        $this->assertEquals('Gemuk', $result['kategori']);
        $this->assertGreaterThanOrEqual(25, $result['imt']);
        $this->assertLessThan(30, $result['imt']);
    }

    public function testObese(): void
    {
        // 100 kg, 1.70 m → IMT ≈ 34.60 → Obesitas
        $result = hitungIMT(100, 1.70);
        $this->assertEquals('Obesitas', $result['kategori']);
        $this->assertGreaterThanOrEqual(30, $result['imt']);
    }

    public function testBoundaryNormalLow(): void
    {
        // Exactly at boundary: IMT = 18.5 → Normal
        // weight = 18.5 * (1^2) = 18.5
        $result = hitungIMT(18.5, 1.0);
        $this->assertEquals('Normal', $result['kategori']);
    }

    public function testBoundaryOverweight(): void
    {
        // Exactly at boundary: IMT = 25 → Gemuk
        // weight = 25 * (1^2) = 25
        $result = hitungIMT(25, 1.0);
        $this->assertEquals('Gemuk', $result['kategori']);
    }

    public function testBoundaryObese(): void
    {
        // Exactly at boundary: IMT = 30 → Obesitas
        // weight = 30 * (1^2) = 30
        $result = hitungIMT(30, 1.0);
        $this->assertEquals('Obesitas', $result['kategori']);
    }

    public function testErrorForZeroHeight(): void
    {
        $result = hitungIMT(55, 0);
        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('Tinggi', $result['error']);
    }

    public function testErrorForNegativeHeight(): void
    {
        $result = hitungIMT(55, -1.6);
        $this->assertArrayHasKey('error', $result);
    }

    public function testErrorForZeroWeight(): void
    {
        $result = hitungIMT(0, 1.6);
        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('Berat', $result['error']);
    }

    public function testErrorForNegativeWeight(): void
    {
        $result = hitungIMT(-55, 1.6);
        $this->assertArrayHasKey('error', $result);
    }
}
