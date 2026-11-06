
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower(trim($_SESSION['role'] ?? ''));

if ($role !== 'wali_kelas') {
    header("Location: dashboard.php");
    exit;
}

/* IDENTITAS GURU */
$guru_id = (int) ($_SESSION['guru_id'] ?? 0);
$user_id = (int) ($_SESSION['id'] ?? 0);
$email = $_SESSION['email'] ?? '';

/* CARI ID GURU */
if ($guru_id <= 0) {

    if ($user_id > 0) {
        $stmt_guru = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_guru WHERE user_id = ? LIMIT 1"
        );

        mysqli_stmt_bind_param($stmt_guru, "i", $user_id);
        mysqli_stmt_execute($stmt_guru);

        $hasil_guru = mysqli_stmt_get_result($stmt_guru);
        $guru = mysqli_fetch_assoc($hasil_guru);

        mysqli_stmt_close($stmt_guru);

        if ($guru) {
            $guru_id = (int) $guru['id'];
        }
    }

    if ($guru_id <= 0 && $email !== '') {
        $stmt_guru = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_guru WHERE email = ? LIMIT 1"
        );

        mysqli_stmt_bind_param($stmt_guru, "s", $email);
        mysqli_stmt_execute($stmt_guru);

        $hasil_guru = mysqli_stmt_get_result($stmt_guru);
        $guru = mysqli_fetch_assoc($hasil_guru);

        mysqli_stmt_close($stmt_guru);

        if ($guru) {
            $guru_id = (int) $guru['id'];
        }
    }
}

/* AMBIL DATA WALI KELAS AKTIF */
$data_wali = null;

if ($guru_id > 0) {

    $stmt_wali = mysqli_prepare(
        $koneksi,
        "SELECT
            wk.kelas_id,
            wk.tahun_ajaran_id,
            k.nama AS nama_kelas,
            ta.nama AS nama_tahun
         FROM t_wali_kelas wk
         INNER JOIN t_kelas k
            ON wk.kelas_id = k.id
         INNER JOIN t_tahun_ajaran ta
            ON wk.tahun_ajaran_id = ta.id
         WHERE wk.guru_id = ?
           AND wk.status_aktif = 1
           AND ta.status_aktif = 1
         ORDER BY wk.id DESC
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt_wali, "i", $guru_id);
    mysqli_stmt_execute($stmt_wali);

    $hasil_wali = mysqli_stmt_get_result($stmt_wali);
    $data_wali = mysqli_fetch_assoc($hasil_wali);

    mysqli_stmt_close($stmt_wali);
}

/* FILTER TANGGAL */
$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

if (
    ($tanggal_awal !== '' &&
     !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_awal))
    ||
    ($tanggal_akhir !== '' &&
     !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_akhir))
    ||
    ($tanggal_awal !== '' &&
     $tanggal_akhir !== '' &&
     $tanggal_awal > $tanggal_akhir)
) {
    $tanggal_awal = '';
    $tanggal_akhir = '';
}

/* DATA LAPORAN */
$data_laporan = false;

$total_pelanggaran = 0;
$total_poin = 0;
$total_siswa = 0;

if ($data_wali) {

    $kelas_id = (int) $data_wali['kelas_id'];
    $tahun_id = (int) $data_wali['tahun_ajaran_id'];

    /* QUERY LAPORAN */
    $sql = "
        SELECT
            id,
            tanggal,
            siswa_id,
            nama_siswa,
            nama_pelanggaran,
            nama_guru,
            poin,
            tindakan,
            status,
            keterangan
        FROM t_pelanggaran_siswa
        WHERE kelas_id = ?
          AND tahun_ajaran_id = ?
    ";

    $tipe = "ii";
    $parameter = [$kelas_id, $tahun_id];

    if ($tanggal_awal !== '') {
        $sql .= " AND tanggal >= ?";
        $tipe .= "s";
        $parameter[] = $tanggal_awal;
    }

    if ($tanggal_akhir !== '') {
        $sql .= " AND tanggal <= ?";
        $tipe .= "s";
        $parameter[] = $tanggal_akhir;
    }

    $sql .= " ORDER BY tanggal DESC, id DESC";

    $stmt_laporan = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param(
        $stmt_laporan,
        $tipe,
        ...$parameter
    );

    mysqli_stmt_execute($stmt_laporan);

    $data_laporan = mysqli_stmt_get_result($stmt_laporan);

    /* HITUNG RINGKASAN */
    $sql_ringkasan = "
        SELECT
            COUNT(*) AS jumlah_pelanggaran,
            COALESCE(SUM(poin), 0) AS total_poin,
            COUNT(DISTINCT siswa_id) AS jumlah_siswa
        FROM t_pelanggaran_siswa
        WHERE kelas_id = ?
          AND tahun_ajaran_id = ?
    ";

    $tipe_ringkasan = "ii";
    $parameter_ringkasan = [$kelas_id, $tahun_id];

    if ($tanggal_awal !== '') {
        $sql_ringkasan .= " AND tanggal >= ?";
        $tipe_ringkasan .= "s";
        $parameter_ringkasan[] = $tanggal_awal;
    }

    if ($tanggal_akhir !== '') {
        $sql_ringkasan .= " AND tanggal <= ?";
        $tipe_ringkasan .= "s";
        $parameter_ringkasan[] = $tanggal_akhir;
    }

    $stmt_ringkasan = mysqli_prepare(
        $koneksi,
        $sql_ringkasan
    );

    mysqli_stmt_bind_param(
        $stmt_ringkasan,
        $tipe_ringkasan,
        ...$parameter_ringkasan
    );

    mysqli_stmt_execute($stmt_ringkasan);

    $hasil_ringkasan = mysqli_stmt_get_result(
        $stmt_ringkasan
    );

    $ringkasan = mysqli_fetch_assoc($hasil_ringkasan);

    $total_pelanggaran = (int) $ringkasan['jumlah_pelanggaran'];
    $total_poin = (int) $ringkasan['total_poin'];
    $total_siswa = (int) $ringkasan['jumlah_siswa'];

    mysqli_stmt_close($stmt_ringkasan);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran Kelas</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container-fluid">

    <div class="row min-vh-100">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 min-vh-100 p-3 sidebar">

            <div class="mb-4 px-2">

                <h3 class="text-white mb-1 sidebar-brand">
                    SIMPESMA
                </h3>

                <p class="text-white mb-0 sidebar-description"
                   style="font-size: 10px; line-height: 1.7; opacity: 0.8;">

                    Sistem Informasi Manajemen
                    Pelanggaran Siswa Muhammadiyah

                </p>

            </div>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa_wali.php"
                       class="nav-link text-white">
                        Data Siswa di Kelasnya
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="riwayat_pelanggaran_wali.php"
                       class="nav-link text-white">
                        Riwayat Pelanggaran Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="rekap_poin_wali.php"
                       class="nav-link text-white">
                        Rekap Poin Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan_kelas.php"
                       class="nav-link active">
                        Laporan Pelanggaran Kelas
                    </a>
                </li>

                <hr class="text-secondary">

                <li class="nav-item mb-2">
                    <a href="about_me.php"
                       class="nav-link text-white">
                        About Me
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout.php"
                       class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>

        </aside>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="fw-bold mb-4">
                Laporan Pelanggaran Kelas
            </h3>

            <?php if (!$data_wali) { ?>

                <div class="alert alert-warning">
                    Belum ditemukan penugasan wali kelas aktif
                    untuk akun ini pada tahun ajaran aktif.
                </div>

            <?php } else { ?>

                <!-- INFORMASI KELAS -->
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h5 class="mb-2">
                            Kelas:
                            <?= htmlspecialchars(
                                $data_wali['nama_kelas']
                            ); ?>
                        </h5>

                        <p class="text-secondary mb-0">
                            Tahun Ajaran:
                            <?= htmlspecialchars(
                                $data_wali['nama_tahun']
                            ); ?>
                        </p>

                    </div>

                </div>

                <!-- RINGKASAN -->
                <div class="row g-3 mb-4">

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm h-100">

                            <div class="card-body">

                                <p class="text-secondary mb-2">
                                    Total Pelanggaran
                                </p>

                                <h3 class="fw-bold text-primary mb-0">
                                    <?= $total_pelanggaran; ?>
                                </h3>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm h-100">

                            <div class="card-body">

                                <p class="text-secondary mb-2">
                                    Siswa Terlibat
                                </p>

                                <h3 class="fw-bold text-primary mb-0">
                                    <?= $total_siswa; ?>
                                </h3>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm h-100">

                            <div class="card-body">

                                <p class="text-secondary mb-2">
                                    Total Poin Pelanggaran
                                </p>

                                <h3 class="fw-bold text-primary mb-0">
                                    <?= $total_poin; ?>
                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- DAFTAR LAPORAN -->
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            Daftar Laporan Pelanggaran
                        </h5>

                    </div>

                    <div class="card-body">

                        <!-- FILTER TANGGAL -->
                        <form method="GET" class="mb-4">

                            <div class="row g-3 align-items-end">

                                <div class="col-md-3">

                                    <label class="form-label">
                                        Tanggal Awal
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_awal"
                                        class="form-control"
                                        value="<?= htmlspecialchars($tanggal_awal); ?>">

                                </div>

                                <div class="col-md-3">

                                    <label class="form-label">
                                        Tanggal Akhir
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_akhir"
                                        class="form-control"
                                        value="<?= htmlspecialchars($tanggal_akhir); ?>">

                                </div>

                                <div class="col-auto">

                                    <button type="submit"
                                            class="btn btn-primary">
                                        Tampilkan
                                    </button>

                                    <a href="laporan_kelas.php"
                                       class="btn btn-secondary">
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>

                        <!-- TOMBOL CETAK -->
                        <div class="d-flex justify-content-end mb-3">

                            <button
                                type="button"
                                onclick="window.print()"
                                class="btn btn-success">

                                Cetak Laporan

                            </button>

                        </div>

                        <!-- TABEL -->
                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover align-middle">

                                <thead class="table-primary">

                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Poin</th>
                                        <th>Guru</th>
                                        <th>Tindakan</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php
                                $no = 1;

                                if (
                                    $data_laporan &&
                                    mysqli_num_rows($data_laporan) > 0
                                ) {

                                    while (
                                        $row = mysqli_fetch_assoc($data_laporan)
                                    ) {
                                ?>

                                    <tr>

                                        <td>
                                            <?= $no++; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['tanggal']
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_siswa']
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_pelanggaran']
                                            ); ?>
                                        </td>

                                        <td class="text-center fw-bold">
                                            <?= (int) $row['poin']; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_guru']
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['tindakan'] ?: '-'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['status']
                                            ); ?>
                                        </td>

                                    </tr>

                                <?php
                                    }

                                } else {
                                ?>

                                    <tr>

                                        <td colspan="8"
                                            class="text-center">

                                            Belum ada data pelanggaran
                                            pada periode ini.

                                        </td>

                                    </tr>

                                <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            <?php } ?>

            <p class="text-center text-secondary small mt-4">
                ©Sofinurjanah
            </p>

        </main>

    </div>

</div>

<style>
@media print {
    aside,
    form,
    .btn,
    .card-header {
        display: none !important;
    }

    main {
        width: 100% !important;
        padding: 10px !important;
    }

    body {
        background: white !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}
</style>

</body>
</html>
