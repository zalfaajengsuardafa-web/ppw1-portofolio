/**
 * Calculator module — extracted from portofolio.js and penugasan.html
 * Provides basic arithmetic operations.
 */

function tambah(a, b) {
    return a + b;
}

function kurang(a, b) {
    return a - b;
}

function kali(a, b) {
    return a * b;
}

function bagi(a, b) {
    if (b === 0) {
        return "Error: Pembagi tidak boleh 0!";
    }
    return a / b;
}

/**
 * Build portfolio project HTML content from project data.
 */
function buildProjectContent(proyek) {
    let isiKonten = "";
    for (let i = 0; i < proyek.length; i++) {
        isiKonten += `${proyek[i].nama} — ${proyek[i].teknologi} (${proyek[i].tahun})\n`;
    }
    return isiKonten;
}

module.exports = { tambah, kurang, kali, bagi, buildProjectContent };
