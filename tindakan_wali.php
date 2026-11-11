
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower(trim($_SESSION['role'] ?? ''));

// =====================================
// AKSES KHUSUS WALI KELAS
// =====================================

if ($role !== 'wali_kelas') {
    header("Location: dashboard.php");
    exit;
}

$pesan = '';
$tipe_pesan = '';

$guru_id = 0;
$nama_guru = '';

// =====================================
// IDENTITAS GURU YANG LOGIN
// =====================================

$user_id = (int) ($_SESSION['id_user'] ?? 0);

if ($user_id > 0) {

    $stmt_guru = mysqli_prepare($koneksi, "
        SELECT id, nama
        FROM t_guru
        WHERE user_id = ?
          AND status_aktif = 1
        LIMIT 1
    ");

    if ($stmt_guru) {

        mysqli_stmt_bind_param($stmt_guru, "i", $user_id);
        mysqli_stmt_execute($stmt_guru);

        $data_guru = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt_guru)
        );

        mysqli_stmt_close($stmt_guru);

        if ($data_guru) {
            $guru_id = (int) $data_guru['id'];
            $nama_guru = $data_guru['nama'];
            $_SESSION['guru_id'] = $guru_id;
        }
    }
}

// Cadangan jika guru_id sudah tersimpan di session
if ($guru_id <= 0) {

    $session_guru_id = (int) ($_SESSION['guru_id'] ?? 0);

    if ($session_guru_id > 0) {

        $stmt_guru = mysqli_prepare($koneksi, "
            SELECT id, nama
            FROM t_guru
            WHERE id = ?
              AND status_aktif = 1
            LIMIT 1
        ");

        if ($stmt_guru) {

            mysqli_stmt_bind_param(
                $stmt_guru,
                "i",
                $session_guru_id
            );

            mysqli_stmt_execute($stmt_guru);

            $data_guru = mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt_guru)
            );

            mysqli_stmt_close($stmt_guru);

            if ($data_guru) {
                $guru_id = (int) $data_guru['id'];
                $nama_guru = $data_guru['nama'];
            }
        }
    }
}

// =====================================
// SIMPAN TINDAKAN
// =====================================

if (isset($_POST['simpan'])) {

    $id = (int) ($_POST['id'] ?? 0);

    $tindakan = trim($_POST['tindakan'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    $status_valid = [
        'Teguran',
        'Pembinaan',
        'Dipantau',
        'Ditindaklanjuti',
        'Selesai'
    ];

    if ($guru_id <= 0) {

        $_SESSION['pesan_tindakan'] =
            'Data guru yang login tidak ditemukan.';

        $_SESSION['tipe_pesan_tindakan'] = 'danger';

    } elseif (
        $id <= 0 ||
        $tindakan === '' ||
        !in_array($status, $status_valid, true)
    ) {

        $_SESSION['pesan_tindakan'] =
            'Data tindakan belum lengkap atau tidak valid.';

        $_SESSION['tipe_pesan_tindakan'] = 'danger';

    } else {

        // Pastikan pelanggaran dicatat oleh guru yang login
        $stmt_cek = mysqli_prepare($koneksi, "
            SELECT id
            FROM t_pelanggaran_siswa
            WHERE id = ?
              AND guru_id = ?
              AND COALESCE(status, '') <> 'Selesai'
            LIMIT 1
        ");

        if ($stmt_cek) {

            mysqli_stmt_bind_param(
                $stmt_cek,
                "ii",
                $id,
                $guru_id
            );

            mysqli_stmt_execute($stmt_cek);

            $data_cek = mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt_cek)
            );

            mysqli_stmt_close($stmt_cek);

            if (!$data_cek) {

                $_SESSION['pesan_tindakan'] =
                    'Data pelanggaran tidak ditemukan atau bukan catatanmu.';

                $_SESSION['tipe_pesan_tindakan'] = 'danger';

            } else {

                $stmt_update = mysqli_prepare($koneksi, "
                    UPDATE t_pelanggaran_siswa
                    SET
                        keterangan = ?,
                        tindakan = ?,
                        status = ?
                    WHERE id = ?
                      AND guru_id = ?
                      AND COALESCE(status, '') <> 'Selesai'
                ");

                if ($stmt_update) {

                    mysqli_stmt_bind_param(
                        $stmt_update,
                        "sssii",
                        $keterangan,
                        $tindakan,
                        $status,
                        $id,
                        $guru_id
                    );

                    if (mysqli_stmt_execute($stmt_update)) {

                        $_SESSION['pesan_tindakan'] =
                            'Tindakan berhasil disimpan.';

                        $_SESSION['tipe_pesan_tindakan'] = 'success';

                    } else {

                        $_SESSION['pesan_tindakan'] =
                            'Gagal menyimpan tindakan: ' .
                            mysqli_stmt_error($stmt_update);

                        $_SESSION['tipe_pesan_tindakan'] = 'danger';
                    }

                    mysqli_stmt_close($stmt_update);

                } else {

                    $_SESSION['pesan_tindakan'] =
                        'Gagal memproses penyimpanan tindakan.';

                    $_SESSION['tipe_pesan_tindakan'] = 'danger';
                }
            }

        } else {

            $_SESSION['pesan_tindakan'] =
                'Gagal memeriksa data pelanggaran.';

            $_SESSION['tipe_pesan_tindakan'] = 'danger';
        }
    }

    header("Location: tindakan_wali.php");
    exit;
}

// =====================================
// NOTIFIKASI
// =====================================

if (isset($_SESSION['pesan_tindakan'])) {

    $pesan = $_SESSION['pesan_tindakan'];

    $tipe_pesan =
        $_SESSION['tipe_pesan_tindakan'] ?? 'success';

    unset($_SESSION['pesan_tindakan']);
    unset($_SESSION['tipe_pesan_tindakan']);
}

// =====================================
// DATA UNTUK EDIT TINDAKAN
// =====================================

$data_edit = null;

if (isset($_GET['edit']) && $guru_id > 0) {

    $id_edit = (int) $_GET['edit'];

    $stmt_edit = mysqli_prepare($koneksi, "
        SELECT *
        FROM t_pelanggaran_siswa
        WHERE id = ?
          AND guru_id = ?
          AND COALESCE(status, '') <> 'Selesai'
        LIMIT 1
    ");

    if ($stmt_edit) {

        mysqli_stmt_bind_param(
            $stmt_edit,
            "ii",
            $id_edit,
            $guru_id
        );

        mysqli_stmt_execute($stmt_edit);

        $data_edit = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt_edit)
        );

        mysqli_stmt_close($stmt_edit);
    }

    if (!$data_edit) {

        $pesan = 'Data pelanggaran tidak ditemukan atau sudah selesai.';
        $tipe_pesan = 'warning';
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tindakan Wali Kelas</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.datatables.net/3.1.4/css/dataTables.dataTables.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body class="bg-light">

<div class="container-fluid">

    <div class="row min-vh-100">

        <!-- SIDEBAR WALI KELAS -->

        <aside
            class="col-md-3 col-lg-2 min-vh-100 p-3"
            style="background-color: #30318B;">

            <div class="mb-4 px-2">

                <h3 class="text-white mb-1 fw-bold">
                    SIMPESMA
                </h3>

                <p class="text-white mb-0"
                   style="font-size: 10px; line-height: 1.7; opacity: 0.8;">

                    Sistem Informasi Manajemen
                    Pelanggaran Siswa Muhammadiyah

                </p>

            </div>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="catat_pelanggaran.php" class="nav-link text-white">
                        Catat Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tindakan_wali.php" class="nav-link active">
                        Tindakan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa_wali.php" class="nav-link text-white">
                        Data Siswa di Kelasnya
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="riwayat_pelanggaran_wali.php" class="nav-link text-white">
                        Riwayat Pelanggaran Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="rekap_poin_wali.php" class="nav-link text-white">
                        Rekap Poin Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan_kelas.php" class="nav-link text-white">
                        Laporan Pelanggaran Kelas
                    </a>
                </li>

                <hr class="text-white-50">

                <li class="nav-item mb-2">
                    <a href="about_me.php" class="nav-link text-white">
                        About Me
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

        </aside>

        <!-- KONTEN UTAMA -->

        <main class="col-md-9 col-lg-10 p-4">

            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Tindakan Pelanggaran Siswa
                </h2>

                <small class="text-secondary">
                    Guru yang login:
                    <?= htmlspecialchars(
                        $nama_guru ?: 'Data guru tidak ditemukan',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </small>

            </div>

            <!-- NOTIFIKASI -->

            <?php if ($pesan != '') { ?>

                <div
                    class="alert alert-<?= htmlspecialchars($tipe_pesan); ?> alert-dismissible fade show d-flex align-items-center justify-content-between"
                    role="alert">

                    <span>
                        <?= htmlspecialchars($pesan); ?>
                    </span>

                    <button
                        type="button"
                        class="btn-close ms-3 flex-shrink-0"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                    </button>

                </div>

            <?php } ?>

            <!-- MODAL EDIT TINDAKAN -->

            <?php if ($data_edit != null) { ?>

                <div
                    class="modal fade"
                    id="modalTindakan"
                    tabindex="-1"
                    aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered modal-lg">

                        <div class="modal-content border-0 shadow">

                            <div class="modal-header">

                                <h5 class="modal-title fw-bold">
                                    Berikan Tindakan
                                </h5>

                            </div>

                            <form method="POST">

                                <div class="modal-body p-4">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= (int) $data_edit['id']; ?>">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Nama Siswa
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                value="<?= htmlspecialchars($data_edit['nama_siswa'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                readonly>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Kelas
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                value="<?= htmlspecialchars($data_edit['nama_kelas'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                readonly>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Pelanggaran
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                value="<?= htmlspecialchars($data_edit['nama_pelanggaran'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                readonly>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Poin
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                value="<?= htmlspecialchars($data_edit['poin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                readonly>

                                        </div>

                                        <div class="col-12 mb-3">

                                            <label class="form-label fw-semibold">
                                                Keterangan
                                            </label>

                                            <textarea
                                                name="keterangan"
                                                class="form-control"
                                                rows="3"
                                                placeholder="Masukkan keterangan pelanggaran"><?= htmlspecialchars($data_edit['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                                        </div>

                                        <div class="col-12 mb-3">

                                            <label class="form-label fw-semibold">
                                                Tindakan
                                            </label>

                                            <textarea
                                                name="tindakan"
                                                class="form-control"
                                                rows="4"
                                                placeholder="Masukkan tindakan yang diberikan"
                                                required><?= htmlspecialchars($data_edit['tindakan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Status
                                            </label>

                                            <select
                                                name="status"
                                                class="form-select"
                                                required>

                                                <?php
                                                $daftar_status = [
                                                    'Teguran',
                                                    'Pembinaan',
                                                    'Dipantau',
                                                    'Ditindaklanjuti',
                                                    'Selesai'
                                                ];

                                                foreach ($daftar_status as $status_item) {
                                                ?>

                                                    <option
                                                        value="<?= htmlspecialchars($status_item); ?>"
                                                        <?= (($data_edit['status'] ?? '') == $status_item) ? 'selected' : ''; ?>>

                                                        <?= htmlspecialchars($status_item); ?>

                                                    </option>

                                                <?php } ?>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <a
                                        href="tindakan_wali.php"
                                        class="btn btn-secondary">

                                        Batal

                                    </a>

                                    <button
                                        type="submit"
                                        name="simpan"
                                        class="btn btn-primary">

                                        Simpan

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            <?php } ?>

            <!-- TABEL DAFTAR PELANGGARAN -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Daftar Pelanggaran
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            id="example"
                            class="table table-bordered table-hover align-middle">

                            <thead class="table-primary">

                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Keterangan</th>
                                    <th>Tindakan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $query_data = false;

                                if ($guru_id > 0) {

                                    $stmt_data = mysqli_prepare($koneksi, "
                                        SELECT *
                                        FROM t_pelanggaran_siswa
                                        WHERE guru_id = ?
                                          AND COALESCE(status, '') <> 'Selesai'
                                        ORDER BY tanggal DESC, id DESC
                                    ");

                                    if ($stmt_data) {

                                        mysqli_stmt_bind_param(
                                            $stmt_data,
                                            "i",
                                            $guru_id
                                        );

                                        mysqli_stmt_execute($stmt_data);

                                        $query_data = mysqli_stmt_get_result(
                                            $stmt_data
                                        );
                                    }
                                }

                                $no = 1;

                                if (
                                    $query_data &&
                                    mysqli_num_rows($query_data) > 0
                                ) {

                                    while ($row = mysqli_fetch_assoc($query_data)) {

                                ?>

                                        <tr>

                                            <td>
                                                <?= $no++; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['tanggal'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['nama_siswa'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['nama_kelas'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['nama_pelanggaran'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['poin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['tindakan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>

                                            <td>

                                                <a
                                                    href="tindakan_wali.php?edit=<?= (int) $row['id']; ?>"
                                                    class="btn btn-sm btn-primary">

                                                    Beri Tindakan

                                                </a>

                                            </td>

                                        </tr>

                                <?php
                                    }
                                }

                                if (isset($stmt_data) && $stmt_data) {
                                    mysqli_stmt_close($stmt_data);
                                }
                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <p class="text-center text-secondary small mt-4">
                ©Sofinurjanah
            </p>

        </main>

    </div>

</div>

<!-- BOOTSTRAP JAVASCRIPT -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- DATATABLES JAVASCRIPT -->

<script src="https://cdn.datatables.net/3.1.4/js/dataTables.min.js"></script>

<script>

// =====================================
// MODAL EDIT OTOMATIS
// =====================================

document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalTindakan');

    if (modalElement) {

        const modal = new bootstrap.Modal(modalElement);

        modal.show();

    }

});

// =====================================
// DATATABLES
// =====================================

new DataTable('#example', {

    pageLength: 10,

    lengthMenu: [5, 10, 25, 50],

    order: [],

    autoWidth: false,

    layout: {
        topStart: 'info',
        topEnd: 'search',
        bottomStart: 'paging',
        bottomEnd: 'pageLength'
    },

    language: {

        search: 'Cari:',

        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',

        infoEmpty: 'Tidak ada data',

        infoFiltered: '(difilter dari _MAX_ seluruh data)',

        zeroRecords: 'Data tidak ditemukan',

        emptyTable: 'Belum ada data pelanggaran.',

        lengthMenu: 'Tampilkan _MENU_ data',

        paginate: {
            first: 'Pertama',
            last: 'Terakhir',
            next: '›',
            previous: '‹'
        }

    }

});

</script>

</body>
</html>
