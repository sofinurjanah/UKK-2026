
<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = strtolower($_SESSION['role']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 min-vh-100 p-3"
            style="background-color: #30318B;">

            <h4 class="text-white mb-4">
                Sistem Pelanggaran
            </h4>

            <ul class="nav nav-pills flex-column">

                <!-- DASHBOARD -->
                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link active">
                        Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') { ?>

                    <!-- MENU ADMIN -->

                    <li class="nav-item mb-2">
                        <a href="data_siswa.php"
                           class="nav-link text-white">
                            Data Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_guru.php"
                           class="nav-link text-white">
                            Data Guru
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_kelas.php"
                           class="nav-link text-white">
                            Kelas
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_tahun_ajaran.php"
                           class="nav-link text-white">
                            Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="penempatan_siswa.php"
                           class="nav-link text-white">
                            Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="wali_kelas.php"
                           class="nav-link text-white">
                            Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="kategori_pelanggaran.php"
                           class="nav-link text-white">
                            Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="jenis_pelanggaran.php"
                           class="nav-link text-white">
                            Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="cetak_export.php"
                           class="nav-link text-white">
                            Cetak / Export
                        </a>
                    </li>

                <?php } elseif ($role == 'guru') { ?>

                    <!-- MENU GURU -->

                    <li class="nav-item mb-2">
                        <a href="catat_pelanggaran.php"
                           class="nav-link text-white">
                            Catat Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="tindakan.php"
                           class="nav-link text-white">
                            Tindakan
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="riwayat_pelanggaran.php"
                           class="nav-link text-white">
                            Riwayat
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="rekap_poin.php"
                           class="nav-link text-white">
                            Rekap Poin
                        </a>
                    </li>

                <?php } ?>

                <!-- ABOUT ME -->
<li class="nav-item mb-3 mt-3">
    <a href="about_me.php"
       class="nav-link text-white rounded-3 p-3">

        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-white text-primary
                        d-flex align-items-center justify-content-center me-3"
                 style="width: 40px; height: 40px;">
                <span class="fw-bold">A</span>
            </div>

            <span class="fw-semibold">About Me</span>

            <span class="ms-auto fs-5">›</span>
        </div>

    </a>
</li>

                <!-- LOGOUT -->
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>
        </div>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>
                Dashboard <?= ucfirst($role); ?>
            </h2>

            <p>
                Selamat datang,
                <b><?= htmlspecialchars($nama); ?></b>
            </p>

            <div class="row">

                <?php if ($role == 'admin') { ?>

                    <!-- KARTU ADMIN -->

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Data Siswa
                                </h5>

                                <p class="card-text">
                                    Kelola data siswa.
                                </p>

                                <a href="data_siswa.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Data Guru
                                </h5>

                                <p class="card-text">
                                    Kelola data guru.
                                </p>

                                <a href="data_guru.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Data Kelas
                                </h5>

                                <p class="card-text">
                                    Kelola data kelas.
                                </p>

                                <a href="data_kelas.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                <?php } elseif ($role == 'guru') { ?>

                    <!-- KARTU GURU -->

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Catat Pelanggaran
                                </h5>

                                <p class="card-text">
                                    Catat pelanggaran yang
                                    dilakukan siswa.
                                </p>

                                <a href="catat_pelanggaran.php"
                                   class="btn btn-primary">
                                    Catat Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Tindakan
                                </h5>

                                <p class="card-text">
                                    Lihat dan kelola tindakan
                                    pelanggaran siswa.
                                </p>

                                <a href="tindakan.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Riwayat
                                </h5>

                                <p class="card-text">
                                    Lihat riwayat pelanggaran
                                    siswa.
                                </p>

                                <a href="riwayat_pelanggaran.php"
                                   class="btn btn-primary">
                                    Lihat Riwayat
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Rekap Poin
                                </h5>

                                <p class="card-text">
                                    Lihat rekap poin pelanggaran
                                    siswa.
                                </p>

                                <a href="rekap_poin.php"
                                   class="btn btn-primary">
                                    Lihat Rekap
                                </a>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

        </main>

    </div>
</div>

</body>
</html>