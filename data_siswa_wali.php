<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower(trim($_SESSION['role'] ?? ''));
$email = trim($_SESSION['email'] ?? '');

if (!in_array($role, ['wali_kelas', 'wali kelas'], true)) {
    header("Location: dashboard.php");
    exit;
}

$guru_id = 0;

// Ambil ID guru berdasarkan email akun yang login
if ($email != '') {

    $stmt_guru = mysqli_prepare(
        $koneksi,
        "SELECT id
         FROM t_guru
         WHERE LOWER(TRIM(email)) = LOWER(TRIM(?))
         AND status_aktif = 1
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt_guru, "s", $email);
    mysqli_stmt_execute($stmt_guru);

    $hasil_guru = mysqli_stmt_get_result($stmt_guru);
    $data_guru = mysqli_fetch_assoc($hasil_guru);

    if ($data_guru) {
        $guru_id = (int) $data_guru['id'];
    }
}

/* AMBIL SEMUA KELAS WALI KELAS PADA TAHUN AJARAN AKTIF */
$daftar_kelas = [];
$data_wali = null;
$data_siswa = false;

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
         ORDER BY wk.id ASC"
    );

    mysqli_stmt_bind_param($stmt_wali, "i", $guru_id);
    mysqli_stmt_execute($stmt_wali);

    $hasil_wali = mysqli_stmt_get_result($stmt_wali);

    while ($row_wali = mysqli_fetch_assoc($hasil_wali)) {
        $daftar_kelas[] = $row_wali;
    }
}

/* PILIH KELAS BERDASARKAN PILIHAN PENGGUNA */
if (!empty($daftar_kelas)) {

    $kelas_dipilih = (int) ($_GET['kelas_id'] ?? 0);

    // Default: pilih kelas pertama jika belum memilih
    $data_wali = $daftar_kelas[0];

    // Pastikan kelas yang dipilih memang milik wali kelas ini
    foreach ($daftar_kelas as $kelas) {
        if ((int) $kelas['kelas_id'] === $kelas_dipilih) {
            $data_wali = $kelas;
            break;
        }
    }

    /* AMBIL SISWA SESUAI KELAS YANG DIPILIH */
    $kelas_id = (int) $data_wali['kelas_id'];
    $tahun_id = (int) $data_wali['tahun_ajaran_id'];

    $stmt_siswa = mysqli_prepare(
        $koneksi,
        "SELECT
            s.nis,
            s.nama
         FROM t_kelas_siswa ks
         INNER JOIN t_siswa s
            ON ks.siswa_id = s.id
         WHERE ks.kelas_id = ?
           AND ks.tahun_ajaran_id = ?
           AND ks.status_aktif = 1
           AND s.status_aktif = 1
         ORDER BY s.nama ASC"
    );

    mysqli_stmt_bind_param(
        $stmt_siswa,
        "ii",
        $kelas_id,
        $tahun_id
    );

    mysqli_stmt_execute($stmt_siswa);
    $data_siswa = mysqli_stmt_get_result($stmt_siswa);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa Wali Kelas</title>

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
            <a href="data_siswa_wali.php" class="nav-link active">
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


        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="fw-bold mb-4">Data Siswa di Kelasnya</h3>

            <?php if (!$data_wali) { ?>

                <div class="alert alert-warning">
                    Belum ditemukan penugasan wali kelas aktif
                    untuk akun ini pada tahun ajaran aktif.
                </div>

            <?php } else { ?>

    <!-- PILIH KELAS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <label class="form-label fw-bold">
                Pilih Kelas
            </label>

            <form method="GET" action="data_siswa_wali.php">

                <select
                    name="kelas_id"
                    class="form-select"
                    onchange="this.form.submit()">

                    <?php foreach ($daftar_kelas as $kelas) { ?>

                        <option
                            value="<?= (int) $kelas['kelas_id']; ?>"
                            <?= (
                                (int) $kelas['kelas_id'] ===
                                (int) $data_wali['kelas_id']
                            ) ? 'selected' : ''; ?>>

                            <?= htmlspecialchars($kelas['nama_kelas']); ?>

                        </option>

                    <?php } ?>

                </select>

            </form>

        </div>
    </div>

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

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Daftar Siswa</h5>
                    </div>

                    <div class="card-body table-responsive">

                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;

                                if ($data_siswa && mysqli_num_rows($data_siswa) > 0) {
                                    while ($row = mysqli_fetch_assoc($data_siswa)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['nis']); ?></td>
                                        <td><?= htmlspecialchars($row['nama']); ?></td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Belum ada siswa aktif di kelas ini.
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

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