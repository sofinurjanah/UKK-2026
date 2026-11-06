
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower(trim($_SESSION['role'] ?? ''));
$email = $_SESSION['email'] ?? '';
$guru_id = (int) ($_SESSION['guru_id'] ?? 0);

if ($role !== 'wali_kelas') {
    header("Location: dashboard.php");
    exit;
}

/* CARI ID GURU JIKA BELUM ADA DI SESSION */
if ($guru_id <= 0 && $email !== '') {
    $stmt_guru = mysqli_prepare(
        $koneksi,
        "SELECT id FROM t_guru WHERE email = ? LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt_guru, "s", $email);
    mysqli_stmt_execute($stmt_guru);

    $hasil_guru = mysqli_stmt_get_result($stmt_guru);
    $data_guru = mysqli_fetch_assoc($hasil_guru);

    mysqli_stmt_close($stmt_guru);

    if ($data_guru) {
        $guru_id = (int) $data_guru['id'];
    }
}

/* AMBIL PENUGASAN WALI KELAS AKTIF */
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

/* FILTER PENCARIAN SISWA */
$cari = trim($_GET['cari'] ?? '');

$data_rekap = false;
$total_siswa = 0;
$total_pelanggaran = 0;
$total_poin_kelas = 0;

if ($data_wali) {

    $kelas_id = (int) $data_wali['kelas_id'];
    $tahun_id = (int) $data_wali['tahun_ajaran_id'];

    /* REKAP POIN PER SISWA */
    $stmt_rekap = mysqli_prepare(
        $koneksi,
        "SELECT
            s.id AS siswa_id,
            s.nis,
            s.nama AS nama_siswa,
            COUNT(ps.id) AS jumlah_pelanggaran,
            COALESCE(SUM(ps.poin), 0) AS total_poin
         FROM t_kelas_siswa ks
         INNER JOIN t_siswa s
            ON ks.siswa_id = s.id
         LEFT JOIN t_pelanggaran_siswa ps
            ON ps.siswa_id = s.id
            AND ps.kelas_id = ks.kelas_id
            AND ps.tahun_ajaran_id = ks.tahun_ajaran_id
         WHERE ks.kelas_id = ?
           AND ks.tahun_ajaran_id = ?
           AND ks.status_aktif = 1
           AND s.status_aktif = 1
           AND (
                s.nama LIKE ?
                OR s.nis LIKE ?
           )
         GROUP BY
            s.id,
            s.nis,
            s.nama
         ORDER BY
            total_poin DESC,
            s.nama ASC"
    );

    $keyword = "%".$cari."%";

    mysqli_stmt_bind_param(
        $stmt_rekap,
        "iiss",
        $kelas_id,
        $tahun_id,
        $keyword,
        $keyword
    );

    mysqli_stmt_execute($stmt_rekap);

    $data_rekap = mysqli_stmt_get_result($stmt_rekap);

    /* RINGKASAN SELURUH SISWA KELAS */
    $stmt_ringkasan = mysqli_prepare(
        $koneksi,
        "SELECT
            COUNT(DISTINCT s.id) AS total_siswa,
            COUNT(ps.id) AS total_pelanggaran,
            COALESCE(SUM(ps.poin), 0) AS total_poin
         FROM t_kelas_siswa ks
         INNER JOIN t_siswa s
            ON ks.siswa_id = s.id
         LEFT JOIN t_pelanggaran_siswa ps
            ON ps.siswa_id = s.id
            AND ps.kelas_id = ks.kelas_id
            AND ps.tahun_ajaran_id = ks.tahun_ajaran_id
         WHERE ks.kelas_id = ?
           AND ks.tahun_ajaran_id = ?
           AND ks.status_aktif = 1
           AND s.status_aktif = 1"
    );

    mysqli_stmt_bind_param(
        $stmt_ringkasan,
        "ii",
        $kelas_id,
        $tahun_id
    );

    mysqli_stmt_execute($stmt_ringkasan);

    $hasil_ringkasan = mysqli_stmt_get_result($stmt_ringkasan);
    $ringkasan = mysqli_fetch_assoc($hasil_ringkasan);

    mysqli_stmt_close($stmt_ringkasan);

    if ($ringkasan) {
        $total_siswa = (int) $ringkasan['total_siswa'];
        $total_pelanggaran = (int) $ringkasan['total_pelanggaran'];
        $total_poin_kelas = (int) $ringkasan['total_poin'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekap Poin Siswa</title>

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
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa_wali.php" class="nav-link text-white">
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
                       class="nav-link active">
                        Rekap Poin Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan_kelas.php" class="nav-link text-white">
                        Laporan Pelanggaran Kelas
                    </a>
                </li>

                <hr class="text-secondary">

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

            <h3 class="fw-bold mb-4">
                Rekap Poin Siswa
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
                            <?= htmlspecialchars($data_wali['nama_kelas']); ?>
                        </h5>

                        <p class="text-secondary mb-0">
                            Tahun Ajaran:
                            <?= htmlspecialchars($data_wali['nama_tahun']); ?>
                        </p>

                    </div>
                </div>

                <!-- RINGKASAN -->
                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-secondary mb-2">
                                    Jumlah Siswa
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
                                    Total Poin Kelas
                                </p>
                                <h3 class="fw-bold text-primary mb-0">
                                    <?= $total_poin_kelas; ?>
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TABEL REKAP -->
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            Daftar Rekap Poin Siswa
                        </h5>
                    </div>

                    <div class="card-body">

                        <!-- PENCARIAN -->
                        <form method="GET" class="mb-3">

                            <div class="row g-2">

                                <div class="col-md-5">
                                    <input
                                        type="text"
                                        name="cari"
                                        class="form-control"
                                        placeholder="Cari nama atau NIS siswa..."
                                        value="<?= htmlspecialchars($cari); ?>">
                                </div>

                                <div class="col-auto">
                                    <button type="submit"
                                            class="btn btn-primary">
                                        Cari
                                    </button>

                                    <a href="rekap_poin_wali.php"
                                       class="btn btn-secondary">
                                        Reset
                                    </a>
                                </div>

                            </div>

                        </form>

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover align-middle">

                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Jumlah Pelanggaran</th>
                                        <th>Total Poin</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php
                                $no = 1;

                                if ($data_rekap &&
                                    mysqli_num_rows($data_rekap) > 0) {

                                    while ($row = mysqli_fetch_assoc($data_rekap)) {
                                ?>

                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars($row['nis']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_siswa']); ?>
                                        </td>

                                        <td class="text-center">
                                            <?= (int) $row['jumlah_pelanggaran']; ?>
                                        </td>

                                        <td class="text-center fw-bold">
                                            <?= (int) $row['total_poin']; ?>
                                        </td>
                                    </tr>

                                <?php
                                    }

                                } else {
                                ?>

                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Tidak ada data siswa yang ditemukan.
                                        </td>
                                    </tr>

                                <?php } ?>

                                </tbody>

                            </table>

                        </div>

                        <p class="text-secondary small mb-0">
                            Data poin dihitung otomatis dari seluruh
                            pelanggaran siswa pada kelas dan tahun ajaran aktif.
                        </p>

                    </div>
                </div>

            <?php } ?>

            <p class="text-center text-secondary small mt-4">
                ©Sofinurjanah
            </p>

        </main>

    </div>
</div>

</body>
</html>
