<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'] ?? '';
$pesan = '';

// MENGAMBIL TAHUN AJARAN YANG AKTIF
$query_tahun_aktif = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_tahun_ajaran
     WHERE status_aktif = 1
     ORDER BY tanggal_mulai DESC
     LIMIT 1"
);

$tahun_aktif = mysqli_fetch_assoc($query_tahun_aktif);

// MENGAMBIL NOTIFIKASI DARI SESSION
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    $tipe_pesan = $_SESSION['tipe_pesan'] ?? '';

    unset($_SESSION['pesan'], $_SESSION['tipe_pesan']);
}

/* TAMBAH PENEMPATAN SISWA */
if (isset($_POST['tambah']) && $role == "admin") {

    $siswa_id = (int)($_POST['siswa_id'] ?? 0);
    // TAHUN AJARAN OTOMATIS MENGAMBIL YANG AKTIF
    $tahun_ajaran_id = (int)($tahun_aktif['id'] ?? 0);
    $kelas_id = (int)($_POST['kelas_id'] ?? 0);
    $tanggal_mulai = trim($_POST['tanggal_mulai'] ?? '');
    $tanggal_selesai = trim($_POST['tanggal_selesai'] ?? '');
    $status_aktif = isset($_POST['status_aktif'])
        ? (int)$_POST['status_aktif'] : -1;

    if (
        $siswa_id <= 0 ||
        $tahun_ajaran_id <= 0 ||
        $kelas_id <= 0 ||
        $tanggal_mulai === '' ||
        $tanggal_selesai === '' ||
        !in_array($status_aktif, [0, 1], true)
    ) {
        $pesan = "Semua data penempatan wajib diisi dengan benar.";
    } else {
        try {
            $cek = mysqli_prepare(
                $koneksi,
                "SELECT id FROM t_kelas_siswa
                 WHERE siswa_id = ? AND tahun_ajaran_id = ?
                 LIMIT 1"
            );

            if (!$cek) {
                $pesan = "Penempatan siswa gagal diperiksa.";
            } else {
                mysqli_stmt_bind_param(
                    $cek,
                    "ii",
                    $siswa_id,
                    $tahun_ajaran_id
                );

                mysqli_stmt_execute($cek);
                mysqli_stmt_store_result($cek);

                if (mysqli_stmt_num_rows($cek) > 0) {
                    $pesan = "Siswa tersebut sudah memiliki penempatan pada tahun ajaran yang dipilih.";
                } else {
                    $stmt = mysqli_prepare(
                        $koneksi,
                        "INSERT INTO t_kelas_siswa
                        (siswa_id, tahun_ajaran_id, kelas_id,
                         tanggal_mulai, tanggal_selesai, status_aktif)
                        VALUES (?, ?, ?, ?, ?, ?)"
                    );

                    if ($stmt) {
                        mysqli_stmt_bind_param(
                            $stmt,
                            "iiissi",
                            $siswa_id,
                            $tahun_ajaran_id,
                            $kelas_id,
                            $tanggal_mulai,
                            $tanggal_selesai,
                            $status_aktif
                        );

                        $pesan = mysqli_stmt_execute($stmt)
                            ? "Penempatan siswa berhasil ditambahkan."
                            : "Penempatan siswa gagal ditambahkan.";

                        mysqli_stmt_close($stmt);
                    } else {
                        $pesan = "Penempatan siswa gagal disiapkan.";
                    }
                }

                mysqli_stmt_close($cek);
            }
        } catch (mysqli_sql_exception $e) {
            $pesan = "Penempatan siswa gagal ditambahkan. Data yang dipilih tidak valid.";
        }
    }
}


/* UBAH PENEMPATAN SISWA */
if (isset($_POST['ubah']) && $role == "admin") {

    $id = (int)($_POST['id'] ?? 0);
    $siswa_id = (int)($_POST['siswa_id'] ?? 0);
    $tahun_ajaran_id = (int)($_POST['tahun_ajaran_id'] ?? 0);
    $kelas_id = (int)($_POST['kelas_id'] ?? 0);
    $tanggal_mulai = trim($_POST['tanggal_mulai'] ?? '');
    $tanggal_selesai = trim($_POST['tanggal_selesai'] ?? '');
    $status_aktif = isset($_POST['status_aktif'])
        ? (int)$_POST['status_aktif'] : -1;

    if (
        $id <= 0 ||
        $siswa_id <= 0 ||
        $tahun_ajaran_id <= 0 ||
        $kelas_id <= 0 ||
        $tanggal_mulai === '' ||
        $tanggal_selesai === '' ||
        !in_array($status_aktif, [0, 1], true)
    ) {
        $pesan = "Data penempatan yang diubah belum lengkap atau tidak valid.";
    } else {
        try {

            // MENGAMBIL DATA LAMA
            $stmt_lama = mysqli_prepare(
                $koneksi,
                "SELECT siswa_id, tahun_ajaran_id, kelas_id,
                        tanggal_mulai, tanggal_selesai, status_aktif
                 FROM t_kelas_siswa
                 WHERE id = ?"
            );

            if (!$stmt_lama) {
                $pesan = "Data penempatan gagal diperiksa.";
            } else {

                mysqli_stmt_bind_param($stmt_lama, "i", $id);
                mysqli_stmt_execute($stmt_lama);

                $hasil_lama = mysqli_stmt_get_result($stmt_lama);
                $data_lama = mysqli_fetch_assoc($hasil_lama);

                mysqli_stmt_close($stmt_lama);

                // MEMERIKSA APAKAH ADA PERUBAHAN
                if (
                    $data_lama &&
                    (int)$data_lama['siswa_id'] === $siswa_id &&
                    (int)$data_lama['tahun_ajaran_id'] === $tahun_ajaran_id &&
                    (int)$data_lama['kelas_id'] === $kelas_id &&
                    $data_lama['tanggal_mulai'] === $tanggal_mulai &&
                    $data_lama['tanggal_selesai'] === $tanggal_selesai &&
                    (int)$data_lama['status_aktif'] === $status_aktif
                ) {

                    // TIDAK ADA PERUBAHAN
                    // KEMBALI TANPA NOTIFIKASI
                    header("Location: penempatan_siswa.php");
                    exit;

                } else {

                    // CEK PENEMPATAN GANDA
                    $cek = mysqli_prepare(
                        $koneksi,
                        "SELECT id FROM t_kelas_siswa
                         WHERE siswa_id = ?
                         AND tahun_ajaran_id = ?
                         AND id <> ?
                         LIMIT 1"
                    );

                    if (!$cek) {
                        $pesan = "Perubahan penempatan gagal diperiksa.";
                    } else {

                        mysqli_stmt_bind_param(
                            $cek,
                            "iii",
                            $siswa_id,
                            $tahun_ajaran_id,
                            $id
                        );

                        mysqli_stmt_execute($cek);
                        mysqli_stmt_store_result($cek);

                        if (mysqli_stmt_num_rows($cek) > 0) {

                            $pesan = "Siswa tersebut sudah memiliki penempatan pada tahun ajaran yang dipilih.";

                        } else {

                            // UPDATE DATA
                            $stmt = mysqli_prepare(
                                $koneksi,
                                "UPDATE t_kelas_siswa SET
                                    siswa_id = ?,
                                    tahun_ajaran_id = ?,
                                    kelas_id = ?,
                                    tanggal_mulai = ?,
                                    tanggal_selesai = ?,
                                    status_aktif = ?
                                 WHERE id = ?"
                            );

                            if ($stmt) {

                                mysqli_stmt_bind_param(
                                    $stmt,
                                    "iiissii",
                                    $siswa_id,
                                    $tahun_ajaran_id,
                                    $kelas_id,
                                    $tanggal_mulai,
                                    $tanggal_selesai,
                                    $status_aktif,
                                    $id
                                );

                                if (mysqli_stmt_execute($stmt)) {

                                    $_SESSION['pesan'] = "Penempatan siswa berhasil diubah.";
                                    $_SESSION['tipe_pesan'] = "success";

                                    mysqli_stmt_close($stmt);
                                    mysqli_stmt_close($cek);

                                    // KEMBALI KE TABEL
                                    header("Location: penempatan_siswa.php");
                                    exit;

                                } else {

                                    $pesan = "Penempatan siswa gagal diubah.";
                                }

                                mysqli_stmt_close($stmt);

                            } else {
                                $pesan = "Perubahan penempatan gagal disiapkan.";
                            }
                        }

                        mysqli_stmt_close($cek);
                    }
                }
            }

        } catch (mysqli_sql_exception $e) {
            $pesan = "Penempatan siswa gagal diubah. Data yang dipilih tidak valid.";
        }
    }
}


/* HAPUS PENEMPATAN SISWA */
if (isset($_GET['hapus']) && $role == "admin") {

    $id = (int)$_GET['hapus'];

    $query_hapus = mysqli_query(
        $koneksi,
        "DELETE FROM t_kelas_siswa WHERE id = '$id'"
    );

    $pesan = $query_hapus
        ? "Penempatan siswa berhasil dihapus."
        : "Penempatan siswa gagal dihapus.";
}


/* AMBIL DATA UNTUK EDIT */
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {

    $id_edit = (int)$_GET['edit'];

    $query_edit = mysqli_query(
        $koneksi,
        "SELECT * FROM t_kelas_siswa WHERE id = '$id_edit'"
    );

    if ($query_edit) {
        $data_edit = mysqli_fetch_assoc($query_edit);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Penempatan Siswa</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- DataTables CSS -->
    <link
        href="https://cdn.datatables.net/3.1.4/css/dataTables.dataTables.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style.css">

</head>

<body class="bg-light">

<div class="container-fluid">

    <div class="row min-vh-100">

        <!-- SIDEBAR -->
        <div
            class="col-md-3 col-lg-2 min-vh-100 p-3"
            style="background-color: #30318B;"
        >

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
                        <a
                            href="penempatan_siswa.php"
                            class="nav-link active"
                            aria-current="page"
                        >
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

        </div>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4" style="min-width: 0;">

            <div class="d-flex justify-content-between
                        align-items-center mb-4">

                <h3 class="fw-bold mb-0">
                    Penempatan Siswa
                </h3>

                <?php if ($role == "admin") { ?>

                    <a
                        href="penempatan_siswa.php?tambah=1"
                        class="btn btn-primary"
                    >
                        Tambah Penempatan Siswa
                    </a>

                <?php } ?>

            </div>


            <!-- NOTIFIKASI -->
            <?php if ($pesan !== '') { ?>

                <div
                    class="alert <?php
                        echo (strpos($pesan, 'berhasil') !== false)
                            ? 'alert-success'
                            : 'alert-danger';
                    ?> alert-dismissible fade show"
                    role="alert"
                >

                    <?php echo htmlspecialchars($pesan); ?>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Tutup"
                    ></button>

                </div>

            <?php } ?>


            <!-- MODAL TAMBAH / UBAH PENEMPATAN -->
            <?php if ($role == "admin" && ($data_edit != null || isset($_GET['tambah']))) { ?>

                <div class="modal fade"
                     id="modalPenempatan"
                     tabindex="-1"
                     aria-hidden="true">

                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">

                            <form
                                method="POST"
                                action="penempatan_siswa.php<?php echo $data_edit != null ? '?edit=' . (int)$data_edit['id'] : ''; ?>"
                            >

                                <div class="modal-header">

                                    <h5 class="modal-title fw-bold">

                                        <?php
                                        echo $data_edit != null
                                            ? 'Ubah Penempatan Siswa'
                                            : 'Tambah Penempatan Siswa';
                                        ?>

                                    </h5>

                                    <a href="penempatan_siswa.php"
                                       class="btn-close"
                                       aria-label="Tutup">
                                    </a>

                                </div>


                                <div class="modal-body p-4">

                                    <?php if ($data_edit != null) { ?>

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo (int)$data_edit['id']; ?>"
                                        >

                                    <?php } ?>


                                    <div class="row g-3">

                                        <!-- SISWA -->
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Siswa
                                            </label>

                                            <select name="siswa_id"
                                                    class="form-select"
                                                    required>

                                                <option value="">
                                                    -- Pilih Siswa --
                                                </option>

                                                <?php

                                                $siswa = mysqli_query(
                                                    $koneksi,
                                                    "SELECT * FROM t_siswa
                                                     WHERE status_aktif = 1
                                                     ORDER BY nama ASC"
                                                );

                                                if ($siswa) {

                                                    while ($row_siswa = mysqli_fetch_assoc($siswa)) {

                                                        $selected = (
                                                            $data_edit != null &&
                                                            $data_edit['siswa_id'] == $row_siswa['id']
                                                        ) ? 'selected' : '';

                                                        echo '<option value="' .
                                                            (int)$row_siswa['id'] . '" ' .
                                                            $selected . '>' .
                                                            htmlspecialchars(
                                                                $row_siswa['nis'] . ' - ' . $row_siswa['nama']
                                                            ) .
                                                            '</option>';
                                                    }
                                                }

                                                ?>

                                            </select>

                                        </div>


                                       <!-- TAHUN AJARAN -->
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Tahun Ajaran
                                            </label>

                                            <?php if ($data_edit != null) { ?>

                                                <!-- TAHUN AJARAN SAAT UBAH DATA -->
                                                <select name="tahun_ajaran_id"
                                                        class="form-select"
                                                        required>

                                                    <?php
                                                    $tahun = mysqli_query(
                                                        $koneksi,
                                                        "SELECT * FROM t_tahun_ajaran
                                                        ORDER BY tanggal_mulai DESC"
                                                    );

                                                    while ($row_tahun = mysqli_fetch_assoc($tahun)) {

                                                        $selected = (
                                                            $data_edit['tahun_ajaran_id'] == $row_tahun['id']
                                                        ) ? 'selected' : '';

                                                        echo '<option value="' .
                                                            (int)$row_tahun['id'] . '" ' .
                                                            $selected . '>' .
                                                            htmlspecialchars($row_tahun['nama']) .
                                                            '</option>';
                                                    }
                                                    ?>

                                                </select>

                                            <?php } else { ?>

                                                <!-- TAHUN AJARAN OTOMATIS SAAT TAMBAH DATA -->
                                                <input type="text"
                                                    class="form-control"
                                                    value="<?= htmlspecialchars($tahun_aktif['nama'] ?? 'Belum ada tahun ajaran aktif'); ?>"
                                                    readonly>

                                            <?php } ?>

                                        </div>


                                        <!-- KELAS -->
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Kelas
                                            </label>

                                            <select name="kelas_id"
                                                    class="form-select"
                                                    required>

                                                <option value="">
                                                    -- Pilih Kelas --
                                                </option>

                                                <?php

                                                $kelas = mysqli_query(
                                                    $koneksi,
                                                    "SELECT * FROM t_kelas
                                                     WHERE status_aktif = 1
                                                     ORDER BY nama ASC"
                                                );

                                                if ($kelas) {

                                                    while ($row_kelas = mysqli_fetch_assoc($kelas)) {

                                                        $selected = (
                                                            $data_edit != null &&
                                                            $data_edit['kelas_id'] == $row_kelas['id']
                                                        ) ? 'selected' : '';

                                                        echo '<option value="' .
                                                            (int)$row_kelas['id'] . '" ' .
                                                            $selected . '>' .
                                                            htmlspecialchars($row_kelas['nama']) .
                                                            '</option>';
                                                    }
                                                }

                                                ?>

                                            </select>

                                        </div>


                                        <!-- STATUS -->
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Status
                                            </label>

                                            <select name="status_aktif"
                                                    class="form-select"
                                                    required>

                                                <option
                                                    value="1"
                                                    <?php echo ($data_edit != null && $data_edit['status_aktif'] == 1) ? 'selected' : ''; ?>
                                                >
                                                    Aktif
                                                </option>

                                                <option
                                                    value="0"
                                                    <?php echo ($data_edit != null && $data_edit['status_aktif'] == 0) ? 'selected' : ''; ?>
                                                >
                                                    Tidak Aktif
                                                </option>

                                            </select>

                                        </div>


                                        <!-- TANGGAL MULAI -->
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Tanggal Mulai
                                            </label>

                                            <input
                                                type="date"
                                                name="tanggal_mulai"
                                                class="form-control"
                                                value="<?php echo $data_edit != null ? htmlspecialchars($data_edit['tanggal_mulai']) : ''; ?>"
                                                required
                                            >

                                        </div>


                                        <!-- TANGGAL SELESAI -->
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Tanggal Selesai
                                            </label>

                                            <input
                                                type="date"
                                                name="tanggal_selesai"
                                                class="form-control"
                                                value="<?php echo $data_edit != null ? htmlspecialchars($data_edit['tanggal_selesai']) : ''; ?>"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                <div class="modal-footer">

                                    <a href="penempatan_siswa.php"
                                       class="btn btn-secondary">
                                        Batal
                                    </a>

                                    <button
                                        type="submit"
                                        name="<?php echo $data_edit != null ? 'ubah' : 'tambah'; ?>"
                                        class="btn btn-primary"
                                    >

                                        <?php
                                        echo $data_edit != null
                                            ? 'Simpan Perubahan'
                                            : 'Simpan Penempatan';
                                        ?>

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        new bootstrap.Modal(
                            document.getElementById('modalPenempatan')
                        ).show();

                    });
                </script>

            <?php } ?>


            <!-- TABEL DAFTAR PENEMPATAN -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Daftar Penempatan Siswa
                    </h5>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">

                                <tr>

                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>

                                    <?php if ($role == "admin") { ?>
                                        <th>Aksi</th>
                                    <?php } ?>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $query_data = mysqli_query($koneksi, "
                                    SELECT
                                        t_kelas_siswa.*,
                                        t_siswa.nis,
                                        t_siswa.nama AS nama_siswa,
                                        t_kelas.nama AS nama_kelas,
                                        t_tahun_ajaran.nama AS nama_tahun
                                    FROM t_kelas_siswa
                                    INNER JOIN t_siswa
                                        ON t_kelas_siswa.siswa_id = t_siswa.id
                                    INNER JOIN t_kelas
                                        ON t_kelas_siswa.kelas_id = t_kelas.id
                                    INNER JOIN t_tahun_ajaran
                                        ON t_kelas_siswa.tahun_ajaran_id = t_tahun_ajaran.id
                                    ORDER BY t_kelas_siswa.id DESC
                                ");

                                $no = 1;

                                if ($query_data) {

                                    while ($row = mysqli_fetch_assoc($query_data)) {

                                ?>

                                    <tr>

                                        <td>
                                            <?php echo $no++; ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['nis']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['nama_siswa']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['nama_tahun']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['nama_kelas']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['tanggal_mulai']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['tanggal_selesai']); ?>
                                        </td>

                                        <td>

                                            <?php if ($row['status_aktif'] == 1) { ?>

                                                <span class="badge text-bg-success">
                                                    Aktif
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge text-bg-secondary">
                                                    Tidak Aktif
                                                </span>

                                            <?php } ?>

                                        </td>


                                        <?php if ($role == "admin") { ?>

                                            <td class="text-nowrap">

                                                <a
                                                    href="penempatan_siswa.php?edit=<?php echo (int)$row['id']; ?>"
                                                    class="btn btn-warning btn-sm"
                                                >
                                                    Ubah
                                                </a>

                                                <a
                                                    href="penempatan_siswa.php?hapus=<?php echo (int)$row['id']; ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus penempatan siswa ini?')"
                                                >
                                                    Hapus
                                                </a>

                                            </td>

                                        <?php } ?>

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


<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/3.1.4/js/dataTables.min.js"></script>

<!-- Pengaturan DataTables -->
<script>

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

</body>
</html>