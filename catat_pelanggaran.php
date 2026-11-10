<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower(trim($_SESSION['role'] ?? ''));

$pesan = '';
$tipe_pesan = '';
$buka_modal = false;

// =====================================
// IDENTITAS GURU YANG SEDANG LOGIN
// =====================================

$guru_id = 0;
$nama_guru = '';

$user_id = (int) ($_SESSION['id_user'] ?? 0);

// Cari data guru berdasarkan akun yang login
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

        $data_guru_login = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt_guru)
        );

        mysqli_stmt_close($stmt_guru);

        if ($data_guru_login) {
            $guru_id = (int) $data_guru_login['id'];
            $nama_guru = $data_guru_login['nama'];

            // Simpan ID guru ke session
            $_SESSION['guru_id'] = $guru_id;
        }
    }
}

// Jika guru_id sudah tersedia di session, gunakan sebagai alternatif
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
            mysqli_stmt_bind_param($stmt_guru, "i", $session_guru_id);
            mysqli_stmt_execute($stmt_guru);

            $data_guru_login = mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt_guru)
            );

            mysqli_stmt_close($stmt_guru);

            if ($data_guru_login) {
                $guru_id = (int) $data_guru_login['id'];
                $nama_guru = $data_guru_login['nama'];
            }
        }
    }
}

// =====================================
// PROSES SIMPAN PELANGGARAN
// =====================================

if (isset($_POST['simpan'])) {

    $buka_modal = true;

    try {

        $siswa_id = (int) ($_POST['siswa_id'] ?? 0);
        $pelanggaran_id = (int) ($_POST['pelanggaran_id'] ?? 0);
        $pelanggaran_custom = trim($_POST['pelanggaran_custom'] ?? '');
        $poin_custom = (int) ($_POST['poin_custom'] ?? 0);

        $tanggal = trim($_POST['tanggal'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');
        $tindakan = trim($_POST['tindakan'] ?? '');
        $status = trim($_POST['status'] ?? '');

        // GURU DIAMBIL DARI SESSION, BUKAN DARI FORM
        if ($guru_id <= 0 || $nama_guru == '') {
            throw new Exception(
                "Data guru yang sedang login tidak ditemukan. Hubungi admin untuk menghubungkan akun dengan data guru."
            );
        }

        if (
            $siswa_id <= 0 ||
            ($pelanggaran_id <= 0 && $pelanggaran_custom == '') ||
            $tanggal == '' ||
            $status == ''
        ) {
            throw new Exception("Semua data wajib diisi dengan benar.");
        }

        if ($pelanggaran_id <= 0 && $poin_custom < 0) {
            throw new Exception("Poin tidak boleh kurang dari 0.");
        }

        // =====================================
        // DATA SISWA
        // =====================================

        $stmt = mysqli_prepare($koneksi, "
            SELECT s.nama AS nama_siswa,
                   k.id AS kelas_id,
                   k.nama AS nama_kelas,
                   ks.tahun_ajaran_id
            FROM t_siswa s
            INNER JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
            INNER JOIN t_kelas k ON ks.kelas_id = k.id
            WHERE s.id = ?
              AND s.status_aktif = 1
              AND ks.status_aktif = 1
            LIMIT 1
        ");

        if (!$stmt) {
            throw new Exception("Gagal memproses data siswa.");
        }

        mysqli_stmt_bind_param($stmt, "i", $siswa_id);
        mysqli_stmt_execute($stmt);

        $data_siswa = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt)
        );

        mysqli_stmt_close($stmt);

        if (!$data_siswa) {
            throw new Exception(
                "Data siswa tidak ditemukan atau belum memiliki penempatan aktif."
            );
        }

        // =====================================
        // DATA PELANGGARAN
        // =====================================

        if ($pelanggaran_id > 0) {

            // PELANGGARAN DARI DAFTAR
            $stmt = mysqli_prepare($koneksi, "
                SELECT nama, poin, pelanggaran_kategori_id
                FROM t_pelanggaran
                WHERE id = ?
                  AND status_aktif = 1
                LIMIT 1
            ");

            if (!$stmt) {
                throw new Exception("Gagal memproses data pelanggaran.");
            }

            mysqli_stmt_bind_param($stmt, "i", $pelanggaran_id);
            mysqli_stmt_execute($stmt);

            $data_pelanggaran = mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt)
            );

            mysqli_stmt_close($stmt);

            if (!$data_pelanggaran) {
                throw new Exception(
                    "Jenis pelanggaran tidak ditemukan atau tidak aktif."
                );
            }

            $nama_pelanggaran = $data_pelanggaran['nama'];
            $pelanggaran_kategori_id =
                (int) $data_pelanggaran['pelanggaran_kategori_id'];

            $poin = (int) $data_pelanggaran['poin'];

        } else {

            // PELANGGARAN CUSTOM
            $nama_pelanggaran = $pelanggaran_custom;

            // ID REFERENSI AGAR FOREIGN KEY TERPENUHI
            $pelanggaran_id = 1;
            $pelanggaran_kategori_id = 1;

            // POIN CUSTOM
            $poin = $poin_custom;
        }

        // =====================================
        // DATA LENGKAP
        // =====================================

        $tahun_ajaran_id = (int) $data_siswa['tahun_ajaran_id'];
        $nama_siswa = $data_siswa['nama_siswa'];
        $kelas_id = (int) $data_siswa['kelas_id'];
        $nama_kelas = $data_siswa['nama_kelas'];

        // Nama guru otomatis dari akun yang login
        // Tidak mengambil guru_id dari POST
        $guru_id = (int) $guru_id;
        $nama_guru = $nama_guru;

        // =====================================
        // SIMPAN KE DATABASE
        // =====================================

        $stmt = mysqli_prepare($koneksi, "
            INSERT INTO t_pelanggaran_siswa (
                tahun_ajaran_id,
                siswa_id,
                nama_siswa,
                kelas_id,
                nama_kelas,
                pelanggaran_id,
                nama_pelanggaran,
                pelanggaran_kategori_id,
                guru_id,
                nama_guru,
                tanggal,
                keterangan,
                poin,
                tindakan,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Gagal menyiapkan penyimpanan pelanggaran.");
        }

        mysqli_stmt_bind_param(
            $stmt,
            "iisisisiisssiss",
            $tahun_ajaran_id,
            $siswa_id,
            $nama_siswa,
            $kelas_id,
            $nama_kelas,
            $pelanggaran_id,
            $nama_pelanggaran,
            $pelanggaran_kategori_id,
            $guru_id,
            $nama_guru,
            $tanggal,
            $keterangan,
            $poin,
            $tindakan,
            $status
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(
                "Gagal menyimpan pelanggaran: " . mysqli_stmt_error($stmt)
            );
        }

        mysqli_stmt_close($stmt);

        $_SESSION['pesan_sukses'] = "Pelanggaran berhasil dicatat.";

        header("Location: catat_pelanggaran.php");
        exit;

    } catch (Throwable $e) {

        $pesan = "Gagal menyimpan pelanggaran: " . $e->getMessage();
        $tipe_pesan = "danger";
    }
}

// =====================================
// NOTIFIKASI BERHASIL
// =====================================

if (isset($_SESSION['pesan_sukses'])) {

    $pesan = $_SESSION['pesan_sukses'];
    $tipe_pesan = "success";

    unset($_SESSION['pesan_sukses']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Pelanggaran</title>

    <!-- BOOTSTRAP CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- DATATABLES CSS -->
    <link
        href="https://cdn.datatables.net/3.1.4/css/dataTables.dataTables.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet"
    >

    <style>
        #cari_siswa {
            height: 38px;
            border-radius: 8px;
            font-size: 13px;
            border: 1px solid #d7e3f5;
        }

        #cari_siswa:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        #hasil_siswa {
            margin-top: 4px;
            border-radius: 8px;
            background: white;
        }

        #hasil_siswa .list-group-item {
            font-size: 13px;
            padding: 10px 12px;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }

        #hasil_siswa .list-group-item:hover {
            background-color: #edf4ff;
            color: #0754b8;
        }

        /* DROPDOWN JENIS PELANGGARAN */
        #tombolPelanggaran {
            height: 38px;
            border-radius: 8px;
            font-size: 13px;
            background-color: white;
        }

        #menuPelanggaran {
            border-radius: 8px;
            border: 1px solid #d7e3f5;
        }

        #cari_pelanggaran {
            font-size: 13px;
            border-radius: 6px;
        }

        .item-pelanggaran {
            font-size: 13px;
            padding: 9px 10px;
            white-space: normal;
        }

        /* NOTIFIKASI */
        .notifikasi-pelanggaran {
            max-width: 100%;
            margin-bottom: 24px;
        }

        .notifikasi-pelanggaran .btn-close {
            padding: 1rem;
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 min-vh-100 p-3"
               style="background-color: #30318B;">

            <div class="mb-4 px-2">
                <h3 class="text-white mb-1 fw-bold">
                    SIMPESMA
                </h3>

                <p class="text-white mb-0" style="font-size: 10px; line-height: 1.7; opacity: 0.8;">
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

                <?php if ($role == 'admin') { ?>

                    <li class="nav-item mb-2">
                        <a href="data_siswa.php" class="nav-link text-white">
                            Data Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_guru.php" class="nav-link text-white">
                            Data Guru
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_kelas.php" class="nav-link text-white">
                            Kelas
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_tahun_ajaran.php" class="nav-link text-white">
                            Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="penempatan_siswa.php" class="nav-link text-white">
                            Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="wali_kelas.php" class="nav-link text-white">
                            Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="kategori_pelanggaran.php" class="nav-link text-white">
                            Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="jenis_pelanggaran.php" class="nav-link text-white">
                            Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="laporan.php" class="nav-link text-white">
                            Laporan
                        </a>
                    </li>

                <?php } elseif ($role == 'guru') { ?>

                    <li class="nav-item mb-2">
                        <a href="catat_pelanggaran.php" class="nav-link active">
                            Catat Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="tindakan.php" class="nav-link text-white">
                            Tindakan
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="riwayat_pelanggaran.php" class="nav-link text-white">
                            Riwayat
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="rekap_poin.php" class="nav-link text-white">
                            Rekap Poin
                        </a>
                    </li>

                <?php } ?>

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

            <!-- JUDUL DAN TOMBOL -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">

                <div>
                    <h2 class="fw-bold mb-1">
                        Catat Pelanggaran Siswa
                    </h2>
                </div>

                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPelanggaran">
                    Tambah Pelanggaran
                </button>

            </div>

            <!-- NOTIFIKASI -->
            <?php if ($pesan != '') { ?>

                <div
                    class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show notifikasi-pelanggaran"
                    role="alert">

                    <?php echo htmlspecialchars($pesan); ?>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                    </button>

                </div>

            <?php } ?>

            <!-- MODAL TAMBAH PELANGGARAN -->
            <div class="modal fade" id="modalPelanggaran" tabindex="-1" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">
                                Form Tambah Pelanggaran
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>
                        </div>

                        <form method="POST">

                            <div class="modal-body p-4">

                                <!-- GURU PENCATAT OTOMATIS -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Guru Pencatat
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= htmlspecialchars($nama_guru ?: 'Data guru tidak ditemukan'); ?>"
                                        readonly>

                                    <small class="text-secondary">
                                        Nama guru terisi otomatis sesuai akun yang sedang login.
                                    </small>
                                </div>

                                <!-- SISWA -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Siswa
                                    </label>

                                    <div class="position-relative">

                                        <input
                                            type="text"
                                            id="cari_siswa"
                                            class="form-control"
                                            placeholder="Cari nama atau NIS siswa..."
                                            autocomplete="off"
                                            required>

                                        <select name="siswa_id" id="siswa_id" class="d-none">
                                            <option value="">-- Pilih Siswa --</option>

                                            <?php
                                            $query_siswa = mysqli_query($koneksi, "
                                                SELECT
                                                    t_siswa.id,
                                                    t_siswa.nis,
                                                    t_siswa.nama,
                                                    t_kelas.nama AS nama_kelas
                                                FROM t_siswa
                                                LEFT JOIN t_kelas_siswa
                                                    ON t_siswa.id = t_kelas_siswa.siswa_id
                                                LEFT JOIN t_kelas
                                                    ON t_kelas_siswa.kelas_id = t_kelas.id
                                                WHERE t_siswa.status_aktif = 1
                                                  AND t_kelas_siswa.status_aktif = 1
                                                ORDER BY t_siswa.nama ASC
                                            ");

                                            while ($row = mysqli_fetch_assoc($query_siswa)) {

                                                $label = $row['nis'] . " - " . $row['nama'];

                                                if ($row['nama_kelas'] != "") {
                                                    $label .= " (" . $row['nama_kelas'] . ")";
                                                }
                                            ?>

                                                <option value="<?= (int) $row['id']; ?>">
                                                    <?= htmlspecialchars($label); ?>
                                                </option>

                                            <?php } ?>
                                        </select>

                                        <div
                                            id="hasil_siswa"
                                            class="list-group position-absolute w-100 shadow-sm"
                                            style="z-index: 1056; display: none; max-height: 180px; overflow-y: auto;">
                                        </div>

                                    </div>
                                </div>

                                <!-- JENIS PELANGGARAN -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Jenis Pelanggaran
                                    </label>

                                    <div class="dropdown w-100" id="dropdownPelanggaran">

                                        <button
                                            type="button"
                                            class="form-select text-start"
                                            id="tombolPelanggaran"
                                            data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside"
                                            aria-expanded="false">

                                            <span id="teksPelanggaran">
                                                -- Pilih atau Ketik Pelanggaran --
                                            </span>

                                        </button>

                                        <div class="dropdown-menu w-100 p-2 shadow" id="menuPelanggaran">

                                            <input
                                                type="text"
                                                id="cari_pelanggaran"
                                                class="form-control mb-2"
                                                placeholder="Cari kode atau nama pelanggaran..."
                                                autocomplete="off">

                                            <div
                                                id="hasil_pelanggaran"
                                                style="max-height: 180px; overflow-y: auto;">

                                                <?php
                                                $query_pelanggaran = mysqli_query($koneksi, "
                                                    SELECT id, kode, nama, poin
                                                    FROM t_pelanggaran
                                                    WHERE status_aktif = 1
                                                    ORDER BY nama ASC
                                                ");

                                                if (!$query_pelanggaran) {
                                                    die("Query pelanggaran gagal: " .
                                                        htmlspecialchars(mysqli_error($koneksi)));
                                                }

                                                while ($row = mysqli_fetch_assoc($query_pelanggaran)) {

                                                    $label = $row['kode'] . " - " .
                                                             $row['nama'] . " - " .
                                                             $row['poin'] . " poin";
                                                ?>

                                                    <button
                                                        type="button"
                                                        class="dropdown-item item-pelanggaran"
                                                        data-id="<?= (int) $row['id']; ?>"
                                                        data-nama="<?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>">

                                                        <?= htmlspecialchars($label); ?>

                                                    </button>

                                                <?php } ?>

                                            </div>

                                            <hr class="my-2">

                                            <button
                                                type="button"
                                                class="btn btn-outline-primary btn-sm w-100"
                                                id="tombolCustom">
                                                + Ketik Pelanggaran Sendiri
                                            </button>

                                        </div>

                                        <input
                                            type="hidden"
                                            name="pelanggaran_id"
                                            id="pelanggaran_id">

                                        <input
                                            type="hidden"
                                            name="pelanggaran_custom"
                                            id="pelanggaran_custom">

                                        <input
                                            type="hidden"
                                            name="poin_custom"
                                            id="poin_custom"
                                            value="0">

                                    </div>
                                </div>

                                <!-- TANGGAL PELANGGARAN -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Tanggal Pelanggaran
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal"
                                        class="form-control"
                                        value="<?= date('Y-m-d'); ?>"
                                        readonly
                                        required>
                                </div>

                                <!-- STATUS -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Pembinaan">Pembinaan</option>
                                        <option value="Ditindaklanjuti">Ditindaklanjuti</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    name="simpan"
                                    class="btn btn-primary"
                                    <?= ($guru_id <= 0 || $nama_guru == '') ? 'disabled' : ''; ?>>
                                    Simpan
                                </button>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- DATA PELANGGARAN TERBARU -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Data Pelanggaran Terbaru</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Guru</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $query_data = mysqli_query($koneksi, "
                                    SELECT *
                                    FROM t_pelanggaran_siswa
                                    ORDER BY id DESC
                                ");

                                $no = 1;

                                if ($query_data && mysqli_num_rows($query_data) > 0) {

                                    while ($row = mysqli_fetch_assoc($query_data)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_pelanggaran']); ?></td>
                                        <td><?php echo htmlspecialchars($row['poin']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    </tr>

                                <?php
                                    }
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

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- BOOTSTRAP JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- SELECT2 JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DATATABLES JAVASCRIPT -->
<script src="https://cdn.datatables.net/3.1.4/js/dataTables.min.js"></script>

<script>

// =========================
// PENCARIAN SISWA
// =========================

const inputSiswa = document.getElementById('cari_siswa');
const selectSiswa = document.getElementById('siswa_id');
const hasilSiswa = document.getElementById('hasil_siswa');

inputSiswa.addEventListener('input', function () {

    const keyword = this.value.toLowerCase().trim();

    hasilSiswa.innerHTML = '';
    selectSiswa.value = '';

    if (keyword === '') {
        hasilSiswa.style.display = 'none';
        return;
    }

    let ditemukan = 0;

    Array.from(selectSiswa.options).forEach(function (option) {

        if (option.value === '') return;

        if (option.text.toLowerCase().includes(keyword)) {

            const item = document.createElement('button');

            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = option.text;

            item.addEventListener('click', function () {

                selectSiswa.value = option.value;
                inputSiswa.value = option.text;

                hasilSiswa.style.display = 'none';
            });

            hasilSiswa.appendChild(item);
            ditemukan++;
        }
    });

    if (ditemukan === 0) {

        const kosong = document.createElement('div');

        kosong.className = 'list-group-item text-secondary';
        kosong.textContent = 'Nama siswa tidak ditemukan';

        hasilSiswa.appendChild(kosong);
    }

    hasilSiswa.style.display = 'block';
});

// TUTUP HASIL PENCARIAN SISWA JIKA KLIK DI LUAR
document.addEventListener('click', function (e) {

    if (!inputSiswa.contains(e.target) &&
        !hasilSiswa.contains(e.target)) {

        hasilSiswa.style.display = 'none';
    }
});


// =========================
// DROPDOWN PENCARIAN PELANGGARAN
// =========================

const dropdownPelanggaranEl = document.getElementById('dropdownPelanggaran');
const tombolPelanggaran = document.getElementById('tombolPelanggaran');
const cariPelanggaran = document.getElementById('cari_pelanggaran');
const hasilPelanggaran = document.getElementById('hasil_pelanggaran');

const selectPelanggaran = document.getElementById('pelanggaran_id');
const customPelanggaran = document.getElementById('pelanggaran_custom');
const teksPelanggaran = document.getElementById('teksPelanggaran');
const poinCustom = document.getElementById('poin_custom');

const dropdownPelanggaran = new bootstrap.Dropdown(tombolPelanggaran);

// FOKUS PENCARIAN SAAT DROPDOWN DIBUKA
dropdownPelanggaranEl.addEventListener('shown.bs.dropdown', function () {
    cariPelanggaran.focus();
});

// PENCARIAN JENIS PELANGGARAN
cariPelanggaran.addEventListener('input', function () {

    const keyword = this.value.toLowerCase().trim();
    const items = hasilPelanggaran.querySelectorAll('.item-pelanggaran');

    let ditemukan = 0;

    items.forEach(function (item) {

        const cocok = item.textContent.toLowerCase().includes(keyword);

        item.style.display = cocok ? '' : 'none';

        if (cocok) ditemukan++;
    });

    const pesanKosong = document.getElementById('pelanggaranKosong');

    if (pesanKosong) {
        pesanKosong.remove();
    }

    if (ditemukan === 0) {

        const kosong = document.createElement('div');

        kosong.id = 'pelanggaranKosong';
        kosong.className = 'text-secondary small p-2';
        kosong.textContent = 'Jenis pelanggaran tidak ditemukan';

        hasilPelanggaran.appendChild(kosong);
    }
});

// PILIH PELANGGARAN DARI DAFTAR
hasilPelanggaran.querySelectorAll('.item-pelanggaran').forEach(function (item) {

    item.addEventListener('click', function () {

        selectPelanggaran.value = this.dataset.id;
        customPelanggaran.value = '';
        poinCustom.value = '0';

        teksPelanggaran.textContent = this.dataset.nama;

        dropdownPelanggaran.hide();
    });

});

// PILIH PELANGGARAN CUSTOM
document.getElementById('tombolCustom').addEventListener('click', function () {

    // INPUT NAMA PELANGGARAN
    const namaCustom = prompt('Ketik nama jenis pelanggaran:');

    if (namaCustom === null || namaCustom.trim() === '') {
        return;
    }

    // INPUT POIN PELANGGARAN
    const inputPoin = prompt('Masukkan jumlah poin pelanggaran:');

    if (inputPoin === null || inputPoin.trim() === '') {
        return;
    }

    const angkaPoin = Number(inputPoin);

    // VALIDASI POIN
    if (
        !Number.isInteger(angkaPoin) ||
        angkaPoin < 0
    ) {
        alert('Poin harus berupa angka bulat dan tidak boleh kurang dari 0.');
        return;
    }

    // SIMPAN DATA CUSTOM
    selectPelanggaran.value = '';
    customPelanggaran.value = namaCustom.trim();
    poinCustom.value = angkaPoin;

    // TAMPILKAN NAMA DAN POIN
    teksPelanggaran.textContent =
        namaCustom.trim() + ' - ' + angkaPoin + ' poin';

    dropdownPelanggaran.hide();
});

// RESET PENCARIAN SAAT DROPDOWN DITUTUP
dropdownPelanggaranEl.addEventListener('hidden.bs.dropdown', function () {

    cariPelanggaran.value = '';

    hasilPelanggaran.querySelectorAll('.item-pelanggaran').forEach(function (item) {
        item.style.display = '';
    });

    const pesanKosong = document.getElementById('pelanggaranKosong');

    if (pesanKosong) {
        pesanKosong.remove();
    }
});


// =========================
// VALIDASI FORM
// =========================

document.querySelector('#modalPelanggaran form')
    .addEventListener('submit', function (e) {

        if (selectSiswa.value === '') {

            e.preventDefault();

            inputSiswa.focus();
            hasilSiswa.style.display = 'block';

            alert('Silakan cari dan pilih nama siswa terlebih dahulu.');

            return;
        }

        if (
            selectPelanggaran.value === '' &&
            customPelanggaran.value.trim() === ''
        ) {

            e.preventDefault();

            dropdownPelanggaran.show();

            alert('Silakan pilih atau ketik jenis pelanggaran terlebih dahulu.');

            return;
        }

        if (
            selectPelanggaran.value === '' &&
            (
                poinCustom.value === '' ||
                !Number.isInteger(Number(poinCustom.value)) ||
                Number(poinCustom.value) < 0
            )
        ) {

            e.preventDefault();

            alert('Silakan masukkan poin pelanggaran custom dengan benar.');

            return;
        }

    });


// =========================
// DATATABLES
// =========================

new DataTable('#example', {
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    order: [],
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
        emptyTable: 'Belum ada data siswa',
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

<?php if ($buka_modal) { ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        var modal = new bootstrap.Modal(
            document.getElementById('modalPelanggaran')
        );

        modal.show();
    });
</script>
<?php } ?>

</body>
</html>