
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

/* IDENTITAS GURU YANG LOGIN */
$guru_id = (int) ($_SESSION['guru_id'] ?? 0);
$user_id = (int) ($_SESSION['id_user'] ?? 0);

/* CARI ID GURU DARI AKUN LOGIN */
if ($guru_id <= 0 && $user_id > 0) {
    $stmt_guru = mysqli_prepare(
        $koneksi,
        "SELECT id FROM t_guru WHERE user_id = ? LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt_guru, "i", $user_id);
    mysqli_stmt_execute($stmt_guru);

    $hasil_guru = mysqli_stmt_get_result($stmt_guru);
    $data_guru = mysqli_fetch_assoc($hasil_guru);

    mysqli_stmt_close($stmt_guru);

    if ($data_guru) {
        $guru_id = (int) $data_guru['id'];
    }
}

/* AMBIL SEMUA PENUGASAN WALI KELAS AKTIF */
$daftar_kelas = [];
$data_wali = null;

if ($guru_id > 0) {
    $stmt_wali = mysqli_prepare(
        $koneksi,
        "SELECT DISTINCT
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
         ORDER BY wk.kelas_id ASC"
    );

    mysqli_stmt_bind_param($stmt_wali, "i", $guru_id);
    mysqli_stmt_execute($stmt_wali);

    $hasil_wali = mysqli_stmt_get_result($stmt_wali);

    while ($row_wali = mysqli_fetch_assoc($hasil_wali)) {
        $daftar_kelas[] = $row_wali;
    }

    mysqli_stmt_close($stmt_wali);
}

/* PILIH KELAS BERDASARKAN DROPDOWN */
$kelas_dipilih = (int) ($_GET['kelas_id'] ?? 0);

if (!empty($daftar_kelas)) {
    foreach ($daftar_kelas as $kelas) {
        if (
            (int) $kelas['kelas_id'] === $kelas_dipilih
        ) {
            $data_wali = $kelas;
            break;
        }
    }

    /* DEFAULT KE KELAS PERTAMA JIKA BELUM MEMILIH */
    if (!$data_wali) {
        $data_wali = $daftar_kelas[0];
    }
}

/* AMBIL RIWAYAT PELANGGARAN SESUAI KELAS WALI */
$data_riwayat = false;

if ($data_wali) {
    $kelas_id = (int) $data_wali['kelas_id'];
    $tahun_id = (int) $data_wali['tahun_ajaran_id'];

    $stmt_riwayat = mysqli_prepare(
        $koneksi,
        "SELECT
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
         WHERE kelas_id = ?
           AND tahun_ajaran_id = ?
         ORDER BY tanggal DESC, id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt_riwayat,
        "ii",
        $kelas_id,
        $tahun_id
    );

    mysqli_stmt_execute($stmt_riwayat);
    $data_riwayat = mysqli_stmt_get_result($stmt_riwayat);
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
        <aside class="col-md-3 col-lg-2 min-vh-100 p-3"
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
                       class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : 'text-white'; ?>">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="data_siswa_wali.php"
                       class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_siswa_wali.php' ? 'active' : 'text-white'; ?>">
                        Data Siswa di Kelasnya
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="riwayat_pelanggaran_wali.php"
                       class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'riwayat_pelanggaran_wali.php' ? 'active' : 'text-white'; ?>">
                        Riwayat Pelanggaran Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="rekap_poin_wali.php"
                       class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'rekap_poin_wali.php' ? 'active' : 'text-white'; ?>">
                        Rekap Poin Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="laporan_kelas.php"
                       class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'laporan_kelas.php' ? 'active' : 'text-white'; ?>">
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
                Riwayat Pelanggaran Siswa
            </h3>

            <?php if (!$data_wali) { ?>

                <div class="alert alert-warning">
                    Belum ditemukan penugasan wali kelas aktif
                    untuk akun ini pada tahun ajaran aktif.
                </div>

            <?php } else { ?>

                <!-- PILIH KELAS -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <form method="GET" action="riwayat_pelanggaran_wali.php">

                            <label for="kelas_id" class="form-label fw-bold">
                                Pilih Kelas
                            </label>

                            <select
                                name="kelas_id"
                                id="kelas_id"
                                class="form-select"
                                onchange="this.form.submit()">

                                <?php foreach ($daftar_kelas as $kelas) { ?>

                                    <option
                                        value="<?= (int) $kelas['kelas_id']; ?>"
                                        <?= (
                                            (int) $data_wali['kelas_id'] ===
                                            (int) $kelas['kelas_id']
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
                                        <th>NIS / Nama Siswa</th>
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
                                ?>

                                    <tr>

                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars($row['tanggal']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_siswa']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_pelanggaran']); ?>
                                        </td>

                                        <td>
                                            <?= (int) $row['poin']; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_guru']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['tindakan'] ?: '-'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?php
                                            $status = $row['status'];

                                            if ($status == 'Selesai') {
                                                $badge = 'success';
                                            } elseif ($status == 'Ditindaklanjuti') {
                                                $badge = 'warning';
                                            } else {
                                                $badge = 'secondary';
                                            }
                                            ?>

                                            <span class="badge bg-<?= $badge; ?>">
                                                <?= htmlspecialchars($status); ?>
                                            </span>
                                        </td>

                                    </tr>

                                <?php
                                    }

                                } else {
                                ?>

                                    <tr>
                                        <td colspan="8" class="text-center">
                                            Belum ada riwayat pelanggaran
                                            siswa di kelas ini.
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
