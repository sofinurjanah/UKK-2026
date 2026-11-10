<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower(trim($_SESSION['role'] ?? ''));

if ($role !== 'guru') {
    header("Location: dashboard.php");
    exit;
}

// =====================================
// IDENTITAS GURU YANG LOGIN
// =====================================

$guru_id = (int) ($_SESSION['guru_id'] ?? 0);
$user_id = (int) ($_SESSION['id_user'] ?? 0);

if ($guru_id <= 0 && $user_id > 0) {

    $stmt_guru = mysqli_prepare(
        $koneksi,
        "SELECT id
         FROM t_guru
         WHERE user_id = ?
         AND status_aktif = 1
         LIMIT 1"
    );

    if ($stmt_guru) {
        mysqli_stmt_bind_param($stmt_guru, "i", $user_id);
        mysqli_stmt_execute($stmt_guru);

        $hasil_guru = mysqli_stmt_get_result($stmt_guru);
        $data_guru = mysqli_fetch_assoc($hasil_guru);

        if ($data_guru) {
            $guru_id = (int) $data_guru['id'];
            $_SESSION['guru_id'] = $guru_id;
        }

        mysqli_stmt_close($stmt_guru);
    }
}

// =====================================
// FILTER PENCARIAN
// =====================================

$nama_siswa = trim($_GET['nama_siswa'] ?? '');
$tanggal_awal = trim($_GET['tanggal_awal'] ?? '');
$tanggal_akhir = trim($_GET['tanggal_akhir'] ?? '');

$nama_siswa_sql = mysqli_real_escape_string($koneksi, $nama_siswa);
$tanggal_awal_sql = mysqli_real_escape_string($koneksi, $tanggal_awal);
$tanggal_akhir_sql = mysqli_real_escape_string($koneksi, $tanggal_akhir);

// =====================================
// QUERY RIWAYAT PELANGGARAN
// =====================================

$query = false;

if ($guru_id > 0) {

    $where = "
        WHERE guru_id = $guru_id
        AND status = 'Selesai'
    ";

    if ($nama_siswa !== '') {
        $where .= "
            AND nama_siswa LIKE '%$nama_siswa_sql%'
        ";
    }

    if ($tanggal_awal !== '') {
        $where .= "
            AND tanggal >= '$tanggal_awal_sql'
        ";
    }

    if ($tanggal_akhir !== '') {
        $where .= "
            AND tanggal <= '$tanggal_akhir_sql'
        ";
    }

    $query = mysqli_query(
        $koneksi,
        "SELECT *
         FROM t_pelanggaran_siswa
         $where
         ORDER BY id DESC"
    );
}

$jumlah_data = ($query) ? mysqli_num_rows($query) : 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pelanggaran</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DATATABLES CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/3.1.4/css/dataTables.dataTables.min.css">

    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            background-color: #30318B;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 15px;
            color: white;
        }

        .sidebar h5 {
            font-weight: 700;
            margin-bottom: 35px;
            padding: 0 10px;
        }

        .sidebar a {
            display: block;
            color: #e4e4f5;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.17);
            color: white;
        }

        .sidebar .logout {
            color: #ffb3b3;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .table th {
            white-space: nowrap;
            font-size: 13px;
        }

        .table td {
            font-size: 13px;
            vertical-align: middle;
        }

        .filter-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- SIDEBAR -->
        <aside
            class="col-md-3 col-lg-2 min-vh-100 p-3"
            style="background-color: #30318B;"
        >

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
                        <a href="riwayat_pelanggaran.php" class="nav-link active">
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
    <div class="main-content">

        <!-- JUDUL -->
        <div class="mb-4">

            <h4 class="fw-bold mb-1">
                Riwayat Pelanggaran
            </h4>

            <p class="text-secondary mb-0">
                Daftar pelanggaran siswa yang telah diselesaikan dan dicatat oleh Anda.
            </p>

        </div>


        <!-- TOTAL DATA -->
        <div class="row mb-4">

            <div class="col-md-4">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-secondary small mb-2">
                            Total Riwayat Selesai
                        </div>

                        <h3 class="fw-bold mb-0">
                            <?= $jumlah_data; ?>
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <!-- FILTER -->
        <div class="filter-card shadow-sm">

            <form method="GET" action="">

                <div class="row g-3 align-items-end">

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Nama Siswa
                        </label>

                        <input
                            type="text"
                            name="nama_siswa"
                            class="form-control"
                            placeholder="Cari nama siswa..."
                            value="<?= htmlspecialchars($nama_siswa); ?>"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Tanggal Awal
                        </label>

                        <input
                            type="date"
                            name="tanggal_awal"
                            class="form-control"
                            value="<?= htmlspecialchars($tanggal_awal); ?>"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Tanggal Akhir
                        </label>

                        <input
                            type="date"
                            name="tanggal_akhir"
                            class="form-control"
                            value="<?= htmlspecialchars($tanggal_akhir); ?>"
                        >

                    </div>


                    <div class="col-md-2 d-flex gap-2">

                        <button type="submit" class="btn btn-primary w-100">
                            Cari
                        </button>

                        <a href="riwayat_pelanggaran.php" class="btn btn-light border">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>


        <!-- TABEL RIWAYAT -->
        <div class="card shadow-sm">

            <div class="card-body">

                <div class="mb-3">

                    <h5 class="fw-bold mb-0">
                        Data Riwayat Pelanggaran
                    </h5>

                </div>


                <?php if ($guru_id <= 0) { ?>

                    <div class="alert alert-warning">
                        Akun guru belum terhubung dengan data guru.
                        Periksa hubungan antara kolom
                        <strong>t_guru.user_id</strong> dan akun yang sedang login.
                    </div>

                <?php } ?>


                <div class="table-responsive">

                    <table id="example" class="table table-bordered table-striped table-hover w-100">

                        <thead class="table-light">

                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Pelanggaran</th>
                                <th>Poin</th>
                                <th>Guru</th>
                                <th>Keterangan</th>
                                <th>Tindakan</th>
                                <th>Status</th>
                            </tr>

                        </thead>


                        <tbody>

                            <?php
                            $no = 1;

                            if ($query && mysqli_num_rows($query) > 0) {

                                while ($data = mysqli_fetch_assoc($query)) {
                            ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= !empty($data['tanggal'])
                                            ? date('d-m-Y', strtotime($data['tanggal']))
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['nama_kelas'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['nama_pelanggaran'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['poin'] ?? '0'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['nama_guru'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['keterangan'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['tindakan'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            <?= htmlspecialchars($data['status'] ?? '-'); ?>
                                        </span>
                                    </td>

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

    </div>


    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/3.1.4/js/dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function () {

            $('#example').DataTable({

                pageLength: 10,

                ordering: true,

                searching: true,

                language: {

                    search: "Cari:",

                    lengthMenu: "Tampilkan _MENU_ data",

                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

                    infoEmpty: "Tidak ada data",

                    zeroRecords: "Data tidak ditemukan",

                    emptyTable: "Belum ada riwayat pelanggaran",

                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }

                }

            });

        });
    </script>

</body>
</html>
