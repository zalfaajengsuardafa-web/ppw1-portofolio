<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Transaksi';
$current_page = 'transaksi';

// ---- DELETE ----
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Ambil data transaksi untuk update status mobil
    $stmt = mysqli_prepare($conn, "SELECT id_mobil, status FROM transaksi WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $trx = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($trx) {
        $stmt = mysqli_prepare($conn, "DELETE FROM transaksi WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            // Kembalikan status mobil jika transaksi aktif
            if ($trx['status'] === 'aktif') {
                $stmt2 = mysqli_prepare($conn, "UPDATE mobil SET status='tersedia' WHERE id=?");
                mysqli_stmt_bind_param($stmt2, "i", $trx['id_mobil']);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
            }
            $_SESSION['flash_message'] = 'Transaksi berhasil dihapus.';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menghapus transaksi.';
            $_SESSION['flash_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    }
    header('Location: transaksi.php');
    exit;
}

// ---- UPDATE STATUS ----
if (isset($_GET['selesai'])) {
    $id = (int)$_GET['selesai'];

    $stmt = mysqli_prepare($conn, "SELECT id_mobil FROM transaksi WHERE id = ? AND status = 'aktif'");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $trx = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($trx) {
        $stmt = mysqli_prepare($conn, "UPDATE transaksi SET status='selesai' WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt2 = mysqli_prepare($conn, "UPDATE mobil SET status='tersedia' WHERE id=?");
        mysqli_stmt_bind_param($stmt2, "i", $trx['id_mobil']);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        $_SESSION['flash_message'] = 'Transaksi diselesaikan. Mobil kembali tersedia.';
        $_SESSION['flash_type'] = 'success';
    }
    header('Location: transaksi.php');
    exit;
}

// ---- SEARCH ----
$search = htmlspecialchars(trim($_GET['search'] ?? ''));
$where = '';
$params = [];
$types = '';

if ($search !== '') {
    $where = "WHERE t.nama_penyewa LIKE ? OR t.no_ktp LIKE ? OR m.merk LIKE ? OR m.nopol LIKE ?";
    $like = "%$search%";
    $params = [$like, $like, $like, $like];
    $types = "ssss";
}

// ---- PAGINATION ----
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = ITEMS_PER_PAGE;
$offset = ($page - 1) * $limit;

// Count total
$count_sql = "SELECT COUNT(*) as total FROM transaksi t JOIN mobil m ON t.id_mobil = m.id $where";
$count_stmt = mysqli_prepare($conn, $count_sql);
if ($types) {
    mysqli_stmt_bind_param($count_stmt, $types, ...$params);
}
mysqli_stmt_execute($count_stmt);
$total_data = mysqli_fetch_assoc(mysqli_stmt_get_result($count_stmt))['total'];
mysqli_stmt_close($count_stmt);
$total_pages = ceil($total_data / $limit);

// Fetch data
$sql = "SELECT t.*, m.merk, m.model, m.nopol, m.harga_sewa
        FROM transaksi t
        JOIN mobil m ON t.id_mobil = m.id
        $where
        ORDER BY t.created_at DESC LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
if ($types) {
    $all_types = $types . "ii";
    $all_params = array_merge($params, [$limit, $offset]);
    mysqli_stmt_bind_param($stmt, $all_types, ...$all_params);
} else {
    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Mobil tersedia untuk dropdown
$mobil_tersedia = mysqli_query($conn, "SELECT id, nopol, merk, model, harga_sewa FROM mobil WHERE status='tersedia' ORDER BY merk, model");

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <h2 class="mb-0"><i class="bi bi-receipt me-2"></i>Data Transaksi</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTransaksi" onclick="resetFormTransaksi()">
        <i class="bi bi-plus-circle me-1"></i>Tambah Transaksi
    </button>
</div>

<!-- Search Bar -->
<div class="card mb-3">
    <div class="card-body py-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form method="GET" action="" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control search-bar"
                           placeholder="Cari penyewa, KTP, mobil..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if ($search): ?>
                    <a href="transaksi.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <span class="text-muted"><?= $total_data ?> data ditemukan</span>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Transaksi -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Penyewa</th>
                        <th>No KTP</th>
                        <th>Mobil</th>
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $offset + 1;
                    while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['nama_penyewa']) ?></strong><br>
                            <small class="text-muted"><i class="bi bi-telephone"></i> <?= htmlspecialchars($row['no_telp']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['no_ktp']) ?></td>
                        <td>
                            <?= htmlspecialchars($row['merk'] . ' ' . $row['model']) ?><br>
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
                        <td class="text-nowrap">
                            <?php if ($row['status'] === 'aktif'): ?>
                            <a href="transaksi.php?selesai=<?= $row['id'] ?>"
                               class="btn btn-success btn-action" title="Selesaikan"
                               onclick="return confirm('Selesaikan transaksi ini?')">
                                <i class="bi bi-check-lg"></i>
                            </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-warning btn-action"
                                    data-bs-toggle="modal" data-bs-target="#modalTransaksi"
                                    onclick="editTransaksi(<?= htmlspecialchars(json_encode($row)) ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="transaksi.php?delete=<?= $row['id'] ?>"
                               class="btn btn-danger btn-action btn-delete"
                               data-name="transaksi <?= htmlspecialchars($row['nama_penyewa']) ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($total_data == 0): ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada data transaksi<?= $search ? ' untuk pencarian "' . htmlspecialchars($search) . '"' : '' ?>.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<nav aria-label="Pagination" class="mt-3">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">&laquo;</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">&raquo;</a>
        </li>
    </ul>
</nav>
<?php endif; ?>

<!-- Modal Tambah/Edit Transaksi -->
<div class="modal fade" id="modalTransaksi" tabindex="-1" aria-labelledby="modalTransaksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="transaksi_action.php" id="formTransaksi">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransaksiLabel">
                        <i class="bi bi-receipt me-2"></i>Tambah Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="trx_id">
                    <input type="hidden" name="action" id="trx_action" value="create">

                    <div class="mb-3">
                        <label for="id_mobil" class="form-label">Pilih Mobil <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_mobil" id="id_mobil" required>
                            <option value="">-- Pilih Mobil --</option>
                            <?php
                            mysqli_data_seek($mobil_tersedia, 0);
                            while ($m = mysqli_fetch_assoc($mobil_tersedia)):
                            ?>
                            <option value="<?= $m['id'] ?>" data-harga="<?= $m['harga_sewa'] ?>">
                                <?= htmlspecialchars($m['nopol'] . ' - ' . $m['merk'] . ' ' . $m['model']) ?>
                                (Rp <?= number_format($m['harga_sewa'], 0, ',', '.') ?>/hari)
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_penyewa" class="form-label">Nama Penyewa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_penyewa" id="nama_penyewa"
                                   placeholder="Nama lengkap penyewa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_ktp" class="form-label">No KTP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_ktp" id="no_ktp"
                                   placeholder="16 digit nomor KTP" maxlength="16" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp"
                               placeholder="Contoh: 081234567890" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_sewa" class="form-label">Tanggal Sewa <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_sewa" id="tgl_sewa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tgl_kembali" class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_kembali" id="tgl_kembali" required>
                        </div>
                    </div>

                    <input type="hidden" name="total_biaya" id="total_biaya">
                    <div class="alert alert-info d-none" id="totalBiayaDisplay">
                        <i class="bi bi-calculator me-2"></i>Total: Rp 0
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetFormTransaksi() {
    document.getElementById('formTransaksi').reset();
    document.getElementById('trx_id').value = '';
    document.getElementById('trx_action').value = 'create';
    document.getElementById('modalTransaksiLabel').innerHTML = '<i class="bi bi-receipt me-2"></i>Tambah Transaksi';
    var display = document.getElementById('totalBiayaDisplay');
    if (display) display.classList.add('d-none');
}

function editTransaksi(data) {
    document.getElementById('trx_id').value = data.id;
    document.getElementById('trx_action').value = 'update';
    document.getElementById('nama_penyewa').value = data.nama_penyewa;
    document.getElementById('no_ktp').value = data.no_ktp;
    document.getElementById('no_telp').value = data.no_telp;
    document.getElementById('tgl_sewa').value = data.tgl_sewa;
    document.getElementById('tgl_kembali').value = data.tgl_kembali;
    document.getElementById('total_biaya').value = data.total_biaya;
    document.getElementById('modalTransaksiLabel').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Transaksi';

    // Set mobil dropdown - add current mobil option if not in the list
    var select = document.getElementById('id_mobil');
    var found = false;
    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].value == data.id_mobil) {
            select.selectedIndex = i;
            found = true;
            break;
        }
    }
    if (!found) {
        var opt = document.createElement('option');
        opt.value = data.id_mobil;
        opt.textContent = data.nopol + ' - ' + data.merk + ' ' + data.model;
        opt.setAttribute('data-harga', data.harga_sewa);
        opt.selected = true;
        select.appendChild(opt);
    }

    var display = document.getElementById('totalBiayaDisplay');
    if (display) {
        display.textContent = 'Rp ' + parseFloat(data.total_biaya).toLocaleString('id-ID');
        display.classList.remove('d-none');
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
