<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Data Mobil';
$current_page = 'mobil';

// ---- DELETE ----
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Cek apakah mobil sedang disewa
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM transaksi WHERE id_mobil = ? AND status = 'aktif'");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $check = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($check['total'] > 0) {
        $_SESSION['flash_message'] = 'Mobil tidak dapat dihapus karena sedang disewa.';
        $_SESSION['flash_type'] = 'danger';
    } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM mobil WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = 'Data mobil berhasil dihapus.';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Gagal menghapus data mobil.';
            $_SESSION['flash_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    }
    header('Location: mobil.php');
    exit;
}

// ---- SEARCH ----
$search = htmlspecialchars(trim($_GET['search'] ?? ''));
$where = '';
$params = [];
$types = '';

if ($search !== '') {
    $where = "WHERE merk LIKE ? OR model LIKE ? OR nopol LIKE ? OR warna LIKE ?";
    $like = "%$search%";
    $params = [$like, $like, $like, $like];
    $types = "ssss";
}

// ---- PAGINATION ----
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = ITEMS_PER_PAGE;
$offset = ($page - 1) * $limit;

// Count total
$count_sql = "SELECT COUNT(*) as total FROM mobil $where";
$count_stmt = mysqli_prepare($conn, $count_sql);
if ($types) {
    mysqli_stmt_bind_param($count_stmt, $types, ...$params);
}
mysqli_stmt_execute($count_stmt);
$total_data = mysqli_fetch_assoc(mysqli_stmt_get_result($count_stmt))['total'];
mysqli_stmt_close($count_stmt);
$total_pages = ceil($total_data / $limit);

// Fetch data
$sql = "SELECT * FROM mobil $where ORDER BY created_at DESC LIMIT ? OFFSET ?";
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

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <h2 class="mb-0"><i class="bi bi-car-front me-2"></i>Data Mobil</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMobil" onclick="resetForm()">
        <i class="bi bi-plus-circle me-1"></i>Tambah Mobil
    </button>
</div>

<!-- Search Bar -->
<div class="card mb-3">
    <div class="card-body py-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form method="GET" action="" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control search-bar" id="searchInput"
                           placeholder="Cari merk, model, nopol..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if ($search): ?>
                    <a href="mobil.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <span class="text-muted" id="rowCounter"><?= $total_data ?> data ditemukan</span>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Mobil -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nopol</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th>Harga/Hari</th>
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
                        <td><strong><?= htmlspecialchars($row['nopol']) ?></strong></td>
                        <td><?= htmlspecialchars($row['merk']) ?></td>
                        <td><?= htmlspecialchars($row['model']) ?></td>
                        <td><?= htmlspecialchars($row['tahun']) ?></td>
                        <td><?= htmlspecialchars($row['warna']) ?></td>
                        <td>Rp <?= number_format($row['harga_sewa'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge badge-<?= $row['status'] ?>">
                                <?= ucfirst(htmlspecialchars($row['status'])) ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-action"
                                    data-bs-toggle="modal" data-bs-target="#modalMobil"
                                    onclick="editMobil(<?= htmlspecialchars(json_encode($row)) ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="mobil.php?delete=<?= $row['id'] ?>"
                               class="btn btn-danger btn-action btn-delete"
                               data-name="<?= htmlspecialchars($row['merk'] . ' ' . $row['model']) ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($total_data == 0): ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada data mobil<?= $search ? ' untuk pencarian "' . htmlspecialchars($search) . '"' : '' ?>.
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

<!-- Modal Tambah/Edit Mobil (Bootstrap Modal component) -->
<div class="modal fade" id="modalMobil" tabindex="-1" aria-labelledby="modalMobilLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="mobil_action.php" id="formMobil">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMobilLabel">
                        <i class="bi bi-car-front me-2"></i>Tambah Mobil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="mobil_id">
                    <input type="hidden" name="action" id="mobil_action" value="create">

                    <div class="mb-3">
                        <label for="nopol" class="form-label">Nomor Polisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nopol" id="nopol"
                               placeholder="Contoh: AB 1234 CD" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="merk" id="merk"
                                   placeholder="Contoh: Toyota" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="model" id="model_input"
                                   placeholder="Contoh: Avanza" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun" id="tahun"
                                   min="2000" max="2030" placeholder="2024" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="warna" class="form-label">Warna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="warna" id="warna"
                                   placeholder="Contoh: Putih" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="harga_sewa" class="form-label">Harga/Hari <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="harga_sewa" id="harga_sewa"
                                   min="1" placeholder="350000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="tersedia">Tersedia</option>
                            <option value="disewa">Disewa</option>
                        </select>
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
function resetForm() {
    document.getElementById('formMobil').reset();
    document.getElementById('mobil_id').value = '';
    document.getElementById('mobil_action').value = 'create';
    document.getElementById('modalMobilLabel').innerHTML = '<i class="bi bi-car-front me-2"></i>Tambah Mobil';
}

function editMobil(data) {
    document.getElementById('mobil_id').value = data.id;
    document.getElementById('mobil_action').value = 'update';
    document.getElementById('nopol').value = data.nopol;
    document.getElementById('merk').value = data.merk;
    document.getElementById('model_input').value = data.model;
    document.getElementById('tahun').value = data.tahun;
    document.getElementById('warna').value = data.warna;
    document.getElementById('harga_sewa').value = data.harga_sewa;
    document.getElementById('status').value = data.status;
    document.getElementById('modalMobilLabel').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Mobil';
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
