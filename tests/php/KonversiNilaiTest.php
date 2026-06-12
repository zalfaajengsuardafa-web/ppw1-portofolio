<?php

require_once __DIR__ . '/../../bab-13-php_2/data_mahasiswa/konversi_nilai_logic.php';

use PHPUnit\Framework\TestCase;

class KonversiNilaiTest extends TestCase
{
    public function testGradeAForScore85(): void
    {
        $result = konversiNilai(85);
        $this->assertEquals('A', $result['grade']);
        $this->assertEquals('Sangat Baik', $result['deskripsi']);
    }

    public function testGradeAForScore100(): void
    {
        $result = konversiNilai(100);
        $this->assertEquals('A', $result['grade']);
    }

    public function testGradeBForScore70(): void
    {
        $result = konversiNilai(70);
        $this->assertEquals('B', $result['grade']);
        $this->assertEquals('Baik', $result['deskripsi']);
    }

    public function testGradeBForScore84(): void
    {
        $result = konversiNilai(84);
        $this->assertEquals('B', $result['grade']);
    }

    public function testGradeCForScore55(): void
    {
        $result = konversiNilai(55);
        $this->assertEquals('C', $result['grade']);
        $this->assertEquals('Cukup', $result['deskripsi']);
    }

    public function testGradeCForScore69(): void
    {
        $result = konversiNilai(69);
        $this->assertEquals('C', $result['grade']);
    }

    public function testGradeDForScore40(): void
    {
        $result = konversiNilai(40);
        $this->assertEquals('D', $result['grade']);
        $this->assertEquals('Kurang', $result['deskripsi']);
    }

    public function testGradeDForScore54(): void
    {
        $result = konversiNilai(54);
        $this->assertEquals('D', $result['grade']);
    }

    public function testGradeEForScore0(): void
    {
        $result = konversiNilai(0);
        $this->assertEquals('E', $result['grade']);
        $this->assertEquals('Sangat Kurang', $result['deskripsi']);
    }

    public function testGradeEForScore39(): void
    {
        $result = konversiNilai(39);
        $this->assertEquals('E', $result['grade']);
    }

    public function testErrorForNegativeValue(): void
    {
        $result = konversiNilai(-1);
        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('0 sampai 100', $result['error']);
    }

    public function testErrorForValueOver100(): void
    {
        $result = konversiNilai(101);
        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('0 sampai 100', $result['error']);
    }
}
