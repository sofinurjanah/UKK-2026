
<?php
session_start();

include "config/koneksi.php";

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = strtolower($_SESSION['role']);

/* JUMLAH DATA SISWA */
$query_siswa = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM t_siswa WHERE status_aktif = 1"
);
$data_siswa = mysqli_fetch_assoc($query_siswa);
$jumlah_siswa = $data_siswa['jumlah'];

/* JUMLAH DATA GURU */
$query_guru = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM t_guru WHERE status_aktif = 1"
);
$data_guru = mysqli_fetch_assoc($query_guru);
$jumlah_guru = $data_guru['jumlah'];

/* JUMLAH DATA KELAS */
$query_kelas = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM t_kelas"
);
$data_kelas = mysqli_fetch_assoc($query_kelas);
$jumlah_kelas = $data_kelas['jumlah'];

/* RINGKASAN PELANGGARAN */
$jumlah_pelanggaran = 0;
$jumlah_jenis_pelanggaran = 0;

$query_pelanggaran = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM t_pelanggaran_siswa"
);

if ($query_pelanggaran) {
    $data_pelanggaran = mysqli_fetch_assoc($query_pelanggaran);
    $jumlah_pelanggaran = $data_pelanggaran['jumlah'];
}

$query_jenis = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah
     FROM t_pelanggaran
     WHERE status_aktif = 1"
);

if ($query_jenis) {
    $data_jenis = mysqli_fetch_assoc($query_jenis);
    $jumlah_jenis_pelanggaran = $data_jenis['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard SIMPESMA</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- CSS yang sudah ada -->
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: #f5f9ff;
        }
        .sidebar-description {
            font-size: 10px;
            line-height: 1.7;
            opacity: 0.8;
        }

        /* JUDUL DASHBOARD */
        .dashboard-title {
            font-size: 24px;
            font-weight: 700;
            color: #183b66;
        }

        .welcome-text {
            color: #718096;
            font-size: 14px;
        }

        /* KOTAK SAMBUTAN */
        .welcome-card {
            background-color: #ffffff;
            border: 1px solid #e1eaf7;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 22px;
        }

        .welcome-card h5 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .welcome-card p {
            color: #718096;
            font-size: 12px;
            margin-bottom: 0;
            line-height: 1.7;
        }

        /* KARTU STATISTIK */
        .stat-card {
            background: #ffffff;
            border: 1px solid #e1eaf7;
            border-radius: 14px;
            box-shadow: 0 2px 5px rgba(20, 50, 90, 0.06);
            height: 100%;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .card-body {
            padding: 20px;
        }

        .stat-card h6 {
            font-size: 15px;
            font-weight: 600;
            color: #24364b;
        }

        .stat-number {
            color: #0754b8;
            font-size: 27px;
            font-weight: 700;
            margin: 8px 0;
        }

        .stat-description {
            font-size: 12px;
            color: #718096;
            margin-bottom: 15px;
        }

        .btn-dashboard {
            background-color: #0754b8;
            color: #ffffff;
            border: none;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 500;
            padding: 8px 14px;
        }

        .btn-dashboard:hover {
            background-color: #073b78;
            color: #ffffff;
        }

        /* RINGKASAN PELANGGARAN */
        .summary-card {
            background-color: #ffffff;
            border: 1px solid #e1eaf7;
            border-radius: 14px;
            box-shadow: 0 2px 5px rgba(20, 50, 90, 0.05);
        }

        .summary-card .card-body {
            padding: 20px;
        }

        .summary-title {
            color: #24364b;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .summary-label {
            color: #718096;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .summary-number {
            color: #0754b8;
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .summary-note {
            color: #8493a7;
            font-size: 11px;
            margin-top: 15px;
            margin-bottom: 0;
        }

        /* COPYRIGHT */
        .dashboard-footer {
            font-size: 11px;
            margin-top: auto;
            padding-top: 25px;
            padding-bottom: 10px;
        }

        @media (max-width: 767px) {
            .sidebar {
                min-height: auto !important;
            }

            .dashboard-title {
                font-size: 21px;
            }
        }
    </style>
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

                <p class="text-white mb-0 sidebar-description">
                    Sistem Informasi Manajemen
                    Pelanggaran Siswa Muhammadiyah
                </p>
            </div>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link active">
                        Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') { ?>

                    <!-- MENU ADMIN -->
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

                    <!-- MENU GURU -->
                    <li class="nav-item mb-2">
                        <a href="catat_pelanggaran.php" class="nav-link text-white">
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
        <main class="col-md-9 col-lg-10 p-4 d-flex flex-column">

            <!-- JUDUL DASHBOARD -->
            <div class="mb-3">
                <h2 class="dashboard-title mb-2">
                    Dashboard <?= ucfirst(htmlspecialchars($role)); ?>
                </h2>

                <p class="welcome-text mb-0">
                    Selamat datang,
                    <b><?= htmlspecialchars($nama); ?></b>
                </p>
            </div>

            <!-- SAMBUTAN -->
            <div class="welcome-card">
                <h5>Selamat datang di SIMPESMA!</h5>

                <p>
                    Sistem Informasi Manajemen Pelanggaran Siswa Muhammadiyah.
                    Silakan gunakan menu di sebelah kiri untuk mengelola data sekolah.
                </p>
            </div>

            <!-- KARTU STATISTIK -->
            <div class="row g-3 mb-4">

                <?php if ($role == 'admin') { ?>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Data Siswa</h6>

                                <h3 class="stat-number">
                                    <?= $jumlah_siswa; ?>
                                </h3>

                                <p class="stat-description">
                                    Jumlah seluruh siswa.
                                </p>

                                <a href="data_siswa.php" class="btn btn-dashboard">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Data Guru</h6>

                                <h3 class="stat-number">
                                    <?= $jumlah_guru; ?>
                                </h3>

                                <p class="stat-description">
                                    Jumlah seluruh guru.
                                </p>

                                <a href="data_guru.php" class="btn btn-dashboard">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Data Kelas</h6>

                                <h3 class="stat-number">
                                    <?= $jumlah_kelas; ?>
                                </h3>

                                <p class="stat-description">
                                    Kelola data kelas.
                                </p>

                                <a href="data_kelas.php" class="btn btn-dashboard">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                <?php } elseif ($role == 'guru') { ?>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Catat Pelanggaran</h6>

                                <p class="stat-description mt-3">
                                    Catat pelanggaran yang dilakukan siswa.
                                </p>

                                <a href="catat_pelanggaran.php" class="btn btn-dashboard">
                                    Catat Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Tindakan</h6>

                                <p class="stat-description mt-3">
                                    Lihat dan kelola tindakan pelanggaran siswa.
                                </p>

                                <a href="tindakan.php" class="btn btn-dashboard">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Riwayat</h6>

                                <p class="stat-description mt-3">
                                    Lihat riwayat pelanggaran siswa.
                                </p>

                                <a href="riwayat_pelanggaran.php" class="btn btn-dashboard">
                                    Lihat Riwayat
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>Rekap Poin</h6>

                                <p class="stat-description mt-3">
                                    Lihat rekap poin pelanggaran siswa.
                                </p>

                                <a href="rekap_poin.php" class="btn btn-dashboard">
                                    Lihat Rekap
                                </a>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

            <!-- RINGKASAN PELANGGARAN -->
            <div class="card summary-card">
                <div class="card-body">

                    <h5 class="summary-title">
                        Ringkasan Pelanggaran
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <p class="summary-label">
                                Total pelanggaran tercatat
                            </p>

                            <h4 class="summary-number">
                                <?= $jumlah_pelanggaran; ?>
                            </h4>
                        </div>

                        <div class="col-md-6">
                            <p class="summary-label">
                                Jenis pelanggaran aktif
                            </p>

                            <h4 class="summary-number">
                                <?= $jumlah_jenis_pelanggaran; ?>
                            </h4>
                        </div>

                    </div>

                    <p class="summary-note">
                        Data ringkasan diambil dari database SIMPESMA.
                    </p>

                </div>
            </div>

            <!-- COPYRIGHT -->
            <p class="text-center text-secondary dashboard-footer">
                ©Sofinurjanah
            </p>

        </main>

    </div>
</div>

</body>
</html>
