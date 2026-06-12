const { tambah, kurang, kali, bagi, buildProjectContent } = require('../../bab-10-javascript/Modul 10/calculator');

describe('Calculator - tambah (addition)', () => {
    test('adds two positive numbers', () => {
        expect(tambah(2, 3)).toBe(5);
    });

    test('adds negative numbers', () => {
        expect(tambah(-1, -2)).toBe(-3);
    });

    test('adds zero', () => {
        expect(tambah(5, 0)).toBe(5);
    });

    test('adds floating point numbers', () => {
        expect(tambah(1.5, 2.5)).toBe(4);
    });
});

describe('Calculator - kurang (subtraction)', () => {
    test('subtracts two positive numbers', () => {
        expect(kurang(10, 3)).toBe(7);
    });

    test('subtracts resulting in negative', () => {
        expect(kurang(3, 10)).toBe(-7);
    });

    test('subtracts zero', () => {
        expect(kurang(5, 0)).toBe(5);
    });

    test('subtracts from zero', () => {
        expect(kurang(0, 5)).toBe(-5);
    });
});

describe('Calculator - kali (multiplication)', () => {
    test('multiplies two positive numbers', () => {
        expect(kali(3, 4)).toBe(12);
    });

    test('multiplies by zero', () => {
        expect(kali(5, 0)).toBe(0);
    });

    test('multiplies negative numbers', () => {
        expect(kali(-3, -4)).toBe(12);
    });

    test('multiplies mixed sign numbers', () => {
        expect(kali(-3, 4)).toBe(-12);
    });

    test('multiplies floating point numbers', () => {
        expect(kali(2.5, 4)).toBe(10);
    });
});

describe('Calculator - bagi (division)', () => {
    test('divides two positive numbers', () => {
        expect(bagi(10, 2)).toBe(5);
    });

    test('divides resulting in decimal', () => {
        expect(bagi(7, 2)).toBe(3.5);
    });

    test('divides by zero returns error message', () => {
        expect(bagi(10, 0)).toBe("Error: Pembagi tidak boleh 0!");
    });

    test('divides zero by non-zero', () => {
        expect(bagi(0, 5)).toBe(0);
    });

    test('divides negative numbers', () => {
        expect(bagi(-10, 2)).toBe(-5);
    });
});

describe('buildProjectContent', () => {
    test('builds HTML content from project data', () => {
        const proyek = [
            { nama: "Sistem Absensi", teknologi: "HTML, CSS", tahun: "2024" },
            { nama: "Web Toko", teknologi: "Bootstrap", tahun: "2023" },
        ];
        const result = buildProjectContent(proyek);
        expect(result).toContain("Sistem Absensi");
        expect(result).toContain("HTML, CSS");
        expect(result).toContain("2024");
        expect(result).toContain("Web Toko");
        expect(result).toContain("Bootstrap");
    });

    test('returns empty string for empty array', () => {
        expect(buildProjectContent([])).toBe("");
    });

    test('handles single project', () => {
        const proyek = [
            { nama: "App", teknologi: "JS", tahun: "2025" },
        ];
        const result = buildProjectContent(proyek);
        expect(result).toContain("App");
        expect(result).toContain("JS");
        expect(result).toContain("2025");
    });
});
