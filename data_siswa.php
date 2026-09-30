<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];
$pesan = "";

/* TAMBAH DATA SISWA */
if (isset($_POST['tambah']) && $role == "admin") {
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_siswa
        (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
        VALUES
        ('$nis', '$nisn', '$nama', '$jenis_kelamin',
        '$tanggal_lahir', '$alamat', '$status_aktif')");

    if ($query) {
        $pesan = "Data siswa berhasil ditambahkan.";
    } else {
        $pesan = "Data siswa gagal ditambahkan.";
    }
}

/* UBAH DATA SISWA */
if (isset($_POST['ubah']) && $role == "admin") {
    $id = $_POST['id'];
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_siswa SET
        nis = '$nis',
        nisn = '$nisn',
        nama = '$nama',
        jenis_kelamin = '$jenis_kelamin',
        tanggal_lahir = '$tanggal_lahir',
        alamat = '$alamat',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        $pesan = "Data siswa berhasil diubah.";
    } else {
        $pesan = "Data siswa gagal diubah.";
    }
}

/* HAPUS DATA SISWA */
if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_siswa
        WHERE id = '$id'");

    if ($query) {
        $pesan = "Data siswa berhasil dihapus.";
    } else {
        $pesan = "Data siswa gagal dihapus. Data mungkin masih digunakan.";
    }
}

/* MENGAMBIL DATA SISWA UNTUK DIUBAH */
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {
    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_siswa
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

/* FUNGSI UNTUK MENAMPILKAN TEKS DENGAN AMAN */
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
</head>

<body class="bg-light">

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

        <hr class="text-secondary">

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

                <?php if ($role == "admin" && $data_edit == null) { ?>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        Tambah Siswa
                    </button>
                <?php } ?>

            </div>

            <!-- PESAN -->
            <?php if ($pesan != "") { ?>
                <div class="alert alert-info alert-dismissible fade show"
                     role="alert">

                    <?= e($pesan); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            <?php } ?>

            <!-- FORM UBAH DATA -->
            <?php if ($role == "admin" && $data_edit != null) { ?>

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Ubah Data Siswa</h5>
                    </div>

                    <div class="card-body">

                        <form method="POST">

                            <input type="hidden"
                                   name="id"
                                   value="<?= e($data_edit['id']); ?>">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIS</label>

                                    <input
                                        type="text"
                                        name="nis"
                                        class="form-control"
                                        value="<?= e($data_edit['nis']); ?>"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NISN</label>

                                    <input
                                        type="text"
                                        name="nisn"
                                        class="form-control"
                                        value="<?= e($data_edit['nisn']); ?>"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Siswa</label>

                                    <input
                                        type="text"
                                        name="nama"
                                        class="form-control"
                                        value="<?= e($data_edit['nama']); ?>"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Jenis Kelamin
                                    </label>

                                    <select
                                        name="jenis_kelamin"
                                        class="form-select"
                                        required>

                                        <option value="L"
                                            <?= $data_edit['jenis_kelamin'] == "L"
                                                ? "selected" : ""; ?>>
                                            Laki-laki
                                        </option>

                                        <option value="P"
                                            <?= $data_edit['jenis_kelamin'] == "P"
                                                ? "selected" : ""; ?>>
                                            Perempuan
                                        </option>

                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tanggal Lahir
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_lahir"
                                        class="form-control"
                                        value="<?= e($data_edit['tanggal_lahir']); ?>"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Status Aktif
                                    </label>

                                    <select
                                        name="status_aktif"
                                        class="form-select"
                                        required>

                                        <option value="1"
                                            <?= $data_edit['status_aktif'] == 1
                                                ? "selected" : ""; ?>>
                                            Aktif
                                        </option>

                                        <option value="0"
                                            <?= $data_edit['status_aktif'] == 0
                                                ? "selected" : ""; ?>>
                                            Tidak Aktif
                                        </option>

                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Alamat</label>

                                    <textarea
                                        name="alamat"
                                        class="form-control"
                                        rows="3"
                                        required><?= e($data_edit['alamat']); ?></textarea>
                                </div>

                            </div>

                            <button
                                type="submit"
                                name="ubah"
                                class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                            <a href="data_siswa.php"
                               class="btn btn-secondary">
                                Batal
                            </a>

                        </form>

                    </div>
                </div>

            <?php } ?>

            <!-- TABEL DATA SISWA -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Siswa</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered
                                      table-striped table-hover
                                      align-middle mb-0">

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
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
                                $query_siswa = mysqli_query(
                                    $koneksi,
                                    "SELECT * FROM t_siswa ORDER BY id DESC"
                                );

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
                                            <?php
                                            if ($siswa['jenis_kelamin'] == "L") {
                                                echo "Laki-laki";
                                            } else {
                                                echo "Perempuan";
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?= e($siswa['tanggal_lahir']); ?>
                                        </td>

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
                                        <td
                                            colspan="<?= $role == 'admin' ? 9 : 8; ?>"
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

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS</label>

                                <input
                                    type="text"
                                    name="nis"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NISN</label>

                                <input
                                    type="text"
                                    name="nisn"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Siswa</label>

                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Jenis Kelamin
                                </label>

                                <select
                                    name="jenis_kelamin"
                                    class="form-select"
                                    required>

                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Tanggal Lahir
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_lahir"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Status Aktif
                                </label>

                                <select
                                    name="status_aktif"
                                    class="form-select"
                                    required>

                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>

                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat</label>

                                <textarea
                                    name="alamat"
                                    class="form-control"
                                    rows="3"
                                    required></textarea>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button
                            type="submit"
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
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>