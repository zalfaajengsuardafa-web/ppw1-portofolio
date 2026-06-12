<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Dashboard';
$current_page = 'dashboard';

// Statistik
$total_mobil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mobil"))['total'];
$mobil_tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mobil WHERE status='tersedia'"))['total'];
$mobil_disewa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mobil WHERE status='disewa'"))['total'];
$transaksi_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE status='aktif'"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi"))['total'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_biaya), 0) as total FROM transaksi WHERE status='selesai'"))['total'];

// Transaksi terbaru
$recent = mysqli_query($conn, "SELECT t.*, m.merk, m.model, m.nopol FROM transaksi t JOIN mobil m ON t.id_mobil = m.id ORDER BY t.created_at DESC LIMIT 5");

require_once __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card stat-card bg-card-primary p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Mobil</div>
                    <div class="stat-number text-primary"><?= $total_mobil ?></div>
                </div>
                <i class="bi bi-car-front stat-icon text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card stat-card bg-card-success p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Mobil Tersedia</div>
                    <div class="stat-number text-success"><?= $mobil_tersedia ?></div>
                </div>
                <i class="bi bi-check-circle stat-icon text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card stat-card bg-card-warning p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Sedang Disewa</div>
                    <div class="stat-number text-warning"><?= $mobil_disewa ?></div>
                </div>
                <i class="bi bi-clock-history stat-icon text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card stat-card bg-card-danger p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Transaksi Aktif</div>
                    <div class="stat-number text-danger"><?= $transaksi_aktif ?></div>
                </div>
                <i class="bi bi-receipt stat-icon text-danger"></i>
            </div>
        </div>
    </div>
</div>

<!-- Info Pendapatan -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="bi bi-cash-stack text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pendapatan</div>
                    <div class="fw-bold fs-5">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-clipboard-data text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Transaksi</div>
                    <div class="fw-bold fs-5"><?= $total_transaksi ?> Transaksi</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Penyewa</th>
                        <th>Mobil</th>
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($recent)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
                        <td><?= htmlspecialchars($row['merk'] . ' ' . $row['model']) ?><br>
                            <small class="text-muted"><?= htmlspecialchars($row['nopol']) ?></small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row['tgl_sewa'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tgl_kembali'])) ?></td>
                        <td>Rp <?= number_format($row['total_biaya'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge badge-<?= $row['status'] ?>">
                                <?= ucfirst(htmlspecialchars($row['status'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
