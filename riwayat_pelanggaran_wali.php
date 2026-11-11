
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

// =====================================
// IDENTITAS GURU YANG LOGIN
// =====================================

$user_id = (int) ($_SESSION['id_user'] ?? 0);
$guru_id_session = (int) ($_SESSION['guru_id'] ?? 0);

$guru_id = 0;
$nama_guru = '';

if ($user_id > 0) {

    $stmt_guru = mysqli_prepare($koneksi, "
        SELECT id, nama
        FROM t_guru
        WHERE user_id = ?
        LIMIT 1
    ");

    if ($stmt_guru) {

        mysqli_stmt_bind_param($stmt_guru, "i", $user_id);
        mysqli_stmt_execute($stmt_guru);

        $hasil_guru = mysqli_stmt_get_result($stmt_guru);
        $data_guru = mysqli_fetch_assoc($hasil_guru);

        mysqli_stmt_close($stmt_guru);

        if ($data_guru) {
            $guru_id = (int) $data_guru['id'];
            $nama_guru = $data_guru['nama'];
            $_SESSION['guru_id'] = $guru_id;
        }
    }
}

// Cadangan jika guru_id tidak ditemukan
if ($guru_id <= 0 && $guru_id_session > 0) {

    $stmt_guru = mysqli_prepare($koneksi, "
        SELECT id, nama
        FROM t_guru
        WHERE id = ?
        LIMIT 1
    ");

    if ($stmt_guru) {

        mysqli_stmt_bind_param(
            $stmt_guru,
            "i",
            $guru_id_session
        );

        mysqli_stmt_execute($stmt_guru);

        $hasil_guru = mysqli_stmt_get_result($stmt_guru);
        $data_guru = mysqli_fetch_assoc($hasil_guru);

        mysqli_stmt_close($stmt_guru);

        if ($data_guru) {
            $guru_id = (int) $data_guru['id'];
            $nama_guru = $data_guru['nama'];
        }
    }
}

// =====================================
// AMBIL RIWAYAT PELANGGARAN
// BERDASARKAN GURU YANG LOGIN
// =====================================

$data_riwayat = false;

if ($guru_id > 0) {

    $stmt_riwayat = mysqli_prepare($koneksi, "
        SELECT
            tanggal,
            nama_siswa,
            nama_kelas,
            nama_pelanggaran,
            poin,
            nama_guru,
            keterangan,
            tindakan,
            status
        FROM t_pelanggaran_siswa
        WHERE guru_id = ?
        ORDER BY tanggal DESC, id DESC
    ");

    if ($stmt_riwayat) {

        mysqli_stmt_bind_param(
            $stmt_riwayat,
            "i",
            $guru_id
        );

        mysqli_stmt_execute($stmt_riwayat);

        $data_riwayat = mysqli_stmt_get_result($stmt_riwayat);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pelanggaran Siswa</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container-fluid">

    <div class="row min-vh-100">

        <!-- SIDEBAR -->

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
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="catat_pelanggaran.php"
                       class="nav-link text-white">
                        Catat Pelanggaran
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tindakan_wali.php"
                       class="nav-link text-white">
                        Tindakan
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
                       class="nav-link active">
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
                       class="nav-link text-white">
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

            <h3 class="fw-bold mb-2">
                Riwayat Pelanggaran Siswa
            </h3>

            <p class="text-secondary mb-4">
                Guru:
                <?= htmlspecialchars(
                    $nama_guru ?: 'Data guru tidak ditemukan',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
            </p>

            <?php if ($guru_id <= 0) { ?>

                <div class="alert alert-warning">
                    Data guru yang login tidak ditemukan.
                </div>

            <?php } else { ?>

                <!-- TABEL RIWAYAT -->

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            Daftar Riwayat Pelanggaran
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover align-middle">

                                <thead class="table-primary">

                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Pelanggaran</th>
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
                                    $data_riwayat &&
                                    mysqli_num_rows($data_riwayat) > 0
                                ) {

                                    while ($row = mysqli_fetch_assoc($data_riwayat)) {

                                        $status = $row['status'] ?? '';

                                        if (strtolower(trim($status)) == 'selesai') {
                                            $badge = 'success';
                                        } elseif (
                                            strtolower(trim($status)) == 'ditindaklanjuti'
                                        ) {
                                            $badge = 'warning';
                                        } elseif (
                                            strtolower(trim($status)) == 'pembinaan'
                                        ) {
                                            $badge = 'info';
                                        } else {
                                            $badge = 'secondary';
                                        }

                                ?>

                                    <tr>

                                        <td>
                                            <?= $no++; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['tanggal'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_siswa'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_kelas'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_pelanggaran'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= (int) ($row['poin'] ?? 0); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_guru'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['tindakan'] ?: '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>

                                            <span class="badge bg-<?= $badge; ?>">
                                                <?= htmlspecialchars(
                                                    $status ?: 'Belum ada status',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </span>

                                        </td>

                                    </tr>

                                <?php
                                    }

                                } else {
                                ?>

                                    <tr>

                                        <td colspan="9" class="text-center">
                                            Belum ada riwayat pelanggaran yang dicatat oleh Anda.
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

</body>
</html>

<?php 

    session_start();

    if ( !isset($_SESSION['id'])) {
        header("Location: login.php");
    }

    

?>