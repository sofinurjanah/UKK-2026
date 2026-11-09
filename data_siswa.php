<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];
$pesan = "";
$tipe_pesan = "";

/* CEK DATA GANDA SISWA */
function siswaDuplikat($koneksi, $kolom, $nilai, $id = null) {
    $kolom_valid = ['nis', 'nisn', 'nama'];

    if (!in_array($kolom, $kolom_valid, true)) {
        throw new Exception("Kolom pemeriksaan tidak valid.");
    }

    if ($kolom === 'nama') {
        $kondisi = "LOWER(TRIM(nama)) = LOWER(TRIM(?))";
    } else {
        $kondisi = "TRIM($kolom) = TRIM(?)";
    }

    $sql = "SELECT id FROM t_siswa WHERE $kondisi";

    if ($id !== null) {
        $sql .= " AND id <> ?";
    }

    $sql .= " LIMIT 1";

    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) {
        throw new Exception("Pemeriksaan data siswa gagal.");
    }

    if ($id !== null) {
        mysqli_stmt_bind_param($stmt, "si", $nilai, $id);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $nilai);
    }

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        throw new Exception("Pemeriksaan data siswa gagal.");
    }

    mysqli_stmt_store_result($stmt);

    $ada = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $ada;
}

/* TAMBAH DATA SISWA */
if (isset($_POST['tambah']) && $role == "admin") {
    $nis = trim($_POST['nis'] ?? '');
    $nisn = trim($_POST['nisn'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $alamat = trim($_POST['alamat'] ?? '');
    $status_aktif = isset($_POST['status_aktif']) ? (int) $_POST['status_aktif'] : -1;

    try {
        if (
            $nis === '' || $nisn === '' || $nama === '' ||
            $jenis_kelamin === '' || $tanggal_lahir === '' ||
            $alamat === '' || !in_array($status_aktif, [0, 1], true)
        ) {
            $pesan = "Semua data siswa wajib diisi dengan benar.";
            $tipe_pesan = "danger";
        } elseif (siswaDuplikat($koneksi, 'nis', $nis)) {
            $pesan = "NIS sudah terdaftar. Gunakan NIS yang berbeda.";
            $tipe_pesan = "danger";
        } elseif (siswaDuplikat($koneksi, 'nisn', $nisn)) {
            $pesan = "NISN sudah terdaftar. Gunakan NISN yang berbeda.";
            $tipe_pesan = "danger";
        } elseif (siswaDuplikat($koneksi, 'nama', $nama)) {
            $pesan = "Nama siswa sudah terdaftar. Periksa kembali data yang dimasukkan.";
            $tipe_pesan = "danger";
        } else {
            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO t_siswa
                (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
                VALUES (?, ?, ?, ?, ?, ?, ?)"
            );

            if (!$stmt) {
                throw new Exception("Data siswa gagal disiapkan.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssi",
                $nis,
                $nisn,
                $nama,
                $jenis_kelamin,
                $tanggal_lahir,
                $alamat,
                $status_aktif
            );

            if (mysqli_stmt_execute($stmt)) {
                $pesan = "Data siswa berhasil ditambahkan.";
                $tipe_pesan = "success";
            } else {
                $pesan = "Data siswa gagal ditambahkan.";
                $tipe_pesan = "danger";
            }

            mysqli_stmt_close($stmt);
        }
    } catch (Throwable $e) {
        $pesan = "Data siswa gagal ditambahkan. Periksa kembali data yang dimasukkan.";
        $tipe_pesan = "danger";
    }
}


/* UBAH DATA SISWA */
if (isset($_POST['ubah']) && $role == "admin") {
    $id = (int) ($_POST['id'] ?? 0);
    $nis = trim($_POST['nis'] ?? '');
    $nisn = trim($_POST['nisn'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $alamat = trim($_POST['alamat'] ?? '');
    $status_aktif = isset($_POST['status_aktif']) ? (int) $_POST['status_aktif'] : -1;
    $kelas_id = (int) ($_POST['kelas_id'] ?? 0);

    try {
        if (
            $id <= 0 || $nis === '' || $nisn === '' || $nama === '' ||
            $jenis_kelamin === '' || $tanggal_lahir === '' ||
            $alamat === '' || $kelas_id <= 0 || !in_array($status_aktif, [0, 1], true)
        ) {
            $_SESSION['pesan'] = "Data siswa belum lengkap atau tidak valid.";
            $_SESSION['tipe_pesan'] = "danger";
        } elseif (siswaDuplikat($koneksi, 'nis', $nis, $id)) {
            $_SESSION['pesan'] = "NIS sudah digunakan oleh siswa lain.";
            $_SESSION['tipe_pesan'] = "danger";
        } elseif (siswaDuplikat($koneksi, 'nisn', $nisn, $id)) {
            $_SESSION['pesan'] = "NISN sudah digunakan oleh siswa lain.";
            $_SESSION['tipe_pesan'] = "danger";
        } elseif (siswaDuplikat($koneksi, 'nama', $nama, $id)) {
            $_SESSION['pesan'] = "Nama siswa sudah digunakan oleh siswa lain. Periksa kembali data yang dimasukkan.";
            $_SESSION['tipe_pesan'] = "danger";
        } else {
            $stmt = mysqli_prepare(
                $koneksi,
                "UPDATE t_siswa SET
                    nis = ?,
                    nisn = ?,
                    nama = ?,
                    jenis_kelamin = ?,
                    tanggal_lahir = ?,
                    alamat = ?,
                    status_aktif = ?
                 WHERE id = ?"
            );

            if (!$stmt) {
                throw new Exception("Perubahan data siswa gagal disiapkan.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssii",
                $nis,
                $nisn,
                $nama,
                $jenis_kelamin,
                $tanggal_lahir,
                $alamat,
                $status_aktif,
                $id
            );

            $query = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($query) {
                $stmt_kelas = mysqli_prepare(
                    $koneksi,
                    "UPDATE t_kelas_siswa
                     SET kelas_id = ?
                     WHERE siswa_id = ?
                     AND status_aktif = 1"
                );

                if (!$stmt_kelas) {
                    $_SESSION['pesan'] = "Data siswa berhasil diubah, tetapi kelas gagal diperbarui.";
                    $_SESSION['tipe_pesan'] = "danger";
                } else {
                    mysqli_stmt_bind_param($stmt_kelas, "ii", $kelas_id, $id);
                    $query_kelas = mysqli_stmt_execute($stmt_kelas);
                    mysqli_stmt_close($stmt_kelas);

                    if ($query_kelas) {
                        $_SESSION['pesan'] = "Data siswa berhasil diubah.";
                        $_SESSION['tipe_pesan'] = "success";
                    } else {
                        $_SESSION['pesan'] = "Data siswa berhasil diubah, tetapi kelas gagal diperbarui.";
                        $_SESSION['tipe_pesan'] = "danger";
                    }
                }
            } else {
                $_SESSION['pesan'] = "Data siswa gagal diubah.";
                $_SESSION['tipe_pesan'] = "danger";
            }
        }
    } catch (Throwable $e) {
        $_SESSION['pesan'] = "Data siswa gagal diubah. Periksa kembali data yang dimasukkan.";
        $_SESSION['tipe_pesan'] = "danger";
    }

    header("Location: data_siswa.php");
    exit;
}


/* HAPUS PERMANEN DATA SISWA */
if (isset($_GET['hapus']) && $role == "admin") {

    $id = (int) $_GET['hapus'];

    if ($id <= 0) {
        $pesan = "ID siswa tidak valid.";
        $tipe_pesan = "danger";
    } else {

        $stmt_cek = mysqli_prepare($koneksi, "
            SELECT
                (SELECT COUNT(*) FROM t_kelas_siswa
                 WHERE siswa_id = ?) AS jumlah_kelas,

                (SELECT COUNT(*) FROM t_pelanggaran_siswa
                 WHERE siswa_id = ?) AS jumlah_pelanggaran
        ");

        mysqli_stmt_bind_param($stmt_cek, "ii", $id, $id);
        mysqli_stmt_execute($stmt_cek);

        $hasil_cek = mysqli_stmt_get_result($stmt_cek);
        $data_cek = mysqli_fetch_assoc($hasil_cek);

        mysqli_stmt_close($stmt_cek);

        if (
            $data_cek['jumlah_kelas'] > 0 ||
            $data_cek['jumlah_pelanggaran'] > 0
        ) {
            $pesan = "Siswa tidak bisa dihapus permanen karena masih memiliki riwayat penempatan kelas atau pelanggaran.";
            $tipe_pesan = "danger";

        } else {

            $stmt_hapus = mysqli_prepare(
                $koneksi,
                "DELETE FROM t_siswa WHERE id = ?"
            );

            mysqli_stmt_bind_param($stmt_hapus, "i", $id);

            if (mysqli_stmt_execute($stmt_hapus)) {
                $pesan = "Data siswa berhasil dihapus permanen.";
                $tipe_pesan = "success";
            } else {
                $pesan = "Data siswa gagal dihapus.";
                $tipe_pesan = "danger";
            }

            mysqli_stmt_close($stmt_hapus);
        }
    }
}

/* MENGAMBIL DATA SISWA UNTUK DIUBAH */
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {
    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_siswa
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);

    $kelas_edit = mysqli_query($koneksi, "
    SELECT id, nama FROM t_kelas
    ORDER BY nama ASC
");

$query_kelas_siswa = mysqli_query($koneksi, "
    SELECT kelas_id
    FROM t_kelas_siswa
    WHERE siswa_id = '$id_edit'
    AND status_aktif = 1
    ORDER BY id DESC
    LIMIT 1
");

$data_kelas_edit = mysqli_fetch_assoc($query_kelas_siswa);
}

/* MENAMPILKAN TEKS DENGAN AMAN */
function e($teks) {
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa</title>

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
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 min-vh-100 p-3"
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

                <!-- DASHBOARD -->
                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') { ?>

                    <!-- MENU ADMIN -->
                    <li class="nav-item mb-2">
                        <a href="data_siswa.php"
                           class="nav-link active"
                           aria-current="page">
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
                        <a href="laporan.php"
                           class="nav-link text-white">
                            Laporan
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

                <hr class="text-secondary">

                <li class="nav-item mb-2">
                    <a href="about_me.php"
                       class="nav-link text-white">
                        About Me
                    </a>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item">
                    <a href="logout.php"
                       class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL HALAMAN -->
            <div class="d-flex justify-content-between
                        align-items-center mb-4">

                <h3 class="fw-bold mb-0">Data Siswa</h3>

                <?php if ($role == "admin") { ?>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        Tambah Siswa
                    </button>
                <?php } ?>

            </div>

            <!-- NOTIFIKASI -->
            <?php if ($pesan != "") { ?>
                <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show text-center mt-3 mb-3"
                     role="alert">

                    <?= e($pesan); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Tutup">
                    </button>
                </div>
            <?php } ?>

            <!-- MODAL UBAH DATA SISWA -->
<?php if ($role == "admin" && $data_edit != null) { ?>

<div class="modal fade" id="modalUbah" tabindex="-1"
     aria-labelledby="judulModalUbah" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form method="POST">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="judulModalUbah">
                        Ubah Data Siswa
                    </h5>

                    <a href="data_siswa.php"
                        class="btn-close"
                        aria-label="Tutup">
                    </a>
                </div>

                <div class="modal-body p-4">

                    <input type="hidden" name="id"
                           value="<?= e($data_edit['id']); ?>">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis"
                                   class="form-control"
                                   value="<?= e($data_edit['nis']); ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn"
                                   class="form-control"
                                   value="<?= e($data_edit['nisn']); ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" name="nama"
                                   class="form-control"
                                   value="<?= e($data_edit['nama']); ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Kelas</label>

                        <select name="kelas_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>

                            <?php while ($kelas = mysqli_fetch_assoc($kelas_edit)) { ?>
                                <option value="<?= e($kelas['id']); ?>"
                                    <?= ($data_kelas_edit && $data_kelas_edit['kelas_id'] == $kelas['id']) ? "selected" : ""; ?>>
                                    <?= e($kelas['nama']); ?>
                                </option>
                            <?php } ?>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>

                            <select name="jenis_kelamin"
                                    class="form-select" required>

                                <option value="L"
                                    <?= $data_edit['jenis_kelamin'] == "L" ? "selected" : ""; ?>>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    <?= $data_edit['jenis_kelamin'] == "P" ? "selected" : ""; ?>>
                                    Perempuan
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                   class="form-control"
                                   value="<?= e($data_edit['tanggal_lahir']); ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Aktif</label>

                            <select name="status_aktif"
                                    class="form-select" required>

                                <option value="1"
                                    <?= $data_edit['status_aktif'] == 1 ? "selected" : ""; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= $data_edit['status_aktif'] == 0 ? "selected" : ""; ?>>
                                    Tidak Aktif
                                </option>

                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>

                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3"
                                      required><?= e($data_edit['alamat']); ?></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <a href="data_siswa.php"
                       class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit" name="ubah"
                            class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalUbah = new bootstrap.Modal(
        document.getElementById('modalUbah')
    );

    modalUbah.show();
});
</script>

<?php } ?>

            <!-- TABEL DATA SISWA -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Siswa</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <!-- ID EXAMPLE UNTUK DATATABLES -->
                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>NISN</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>
            <th>Aksi</th>
        <?php } ?>
    </tr>
</thead>

                            <tbody>

                                <?php
                                $query_siswa = mysqli_query($koneksi, "
    SELECT
        s.*,
        k.nama AS nama_kelas
    FROM t_siswa s

    LEFT JOIN (
        SELECT ks1.*
        FROM t_kelas_siswa ks1
        INNER JOIN (
            SELECT siswa_id, MAX(id) AS id_terbaru
            FROM t_kelas_siswa
            WHERE status_aktif = 1
            GROUP BY siswa_id
        ) ks2 ON ks1.id = ks2.id_terbaru
    ) ks ON s.id = ks.siswa_id

    LEFT JOIN t_kelas k
        ON ks.kelas_id = k.id

    ORDER BY s.id ASC
");
                                $no = 1;

                                if (mysqli_num_rows($query_siswa) > 0) {

                                    while ($siswa = mysqli_fetch_assoc($query_siswa)) {
                                ?>

                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td><?= e($siswa['nis']); ?></td>

                                        <td><?= e($siswa['nisn']); ?></td>

                                        <td><?= e($siswa['nama']); ?></td>
                                        <td>
    <?= !empty($siswa['nama_kelas'])
        ? e($siswa['nama_kelas'])
        : '-'; ?>
</td>

                                        <td>
                                            <?php
                                            if ($siswa['jenis_kelamin'] == "L") {
                                                echo "Laki-laki";
                                            } else {
                                                echo "Perempuan";
                                            }
                                            ?>
                                        </td>

                                        <td><?= e($siswa['tanggal_lahir']); ?></td>

                                        <td><?= e($siswa['alamat']); ?></td>

                                        <td>
                                            <?php if ($siswa['status_aktif'] == 1) { ?>
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
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <a
                                                        href="data_siswa.php?edit=<?= e($siswa['id']); ?>"
                                                        class="btn btn-warning btn-sm">
                                                        Ubah
                                                    </a>

                                                    <a
                                                        href="data_siswa.php?hapus=<?= e($siswa['id']); ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data siswa ini?')">
                                                        Hapus
                                                    </a>

                                                </div>
                                            </td>
                                        <?php } ?>

                                    </tr>

                                <?php
                                    }

                                } else {
                                ?>

                                    <tr>
                                        <td colspan="<?= $role == 'admin' ? 10 : 9; ?>"
                                            class="text-center text-muted py-4">
                                            Belum ada data siswa.
                                        </td>
                                    </tr>

                                <?php } ?>

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

<!-- MODAL TAMBAH SISWA -->
<?php if ($role == "admin") { ?>

    <div class="modal fade"
         id="modalTambah"
         tabindex="-1"
         aria-labelledby="judulModalTambah"
         aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="judulModalTambah">
                            Tambah Data Siswa
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text"
                                    name="nis"
                                    class="form-control"
                                    maxlength="10"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text"
                                    name="nisn"
                                    class="form-control"
                                    maxlength="10"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="text"
                                       name="nama"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                        class="form-select"
                                        required>

                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date"
                                       name="tanggal_lahir"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Aktif</label>
                                <select name="status_aktif"
                                        class="form-select"
                                        required>

                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat"
                                          class="form-control"
                                          rows="3"
                                          required></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit"
                                name="tambah"
                                class="btn btn-primary">
                            Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php } ?>

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