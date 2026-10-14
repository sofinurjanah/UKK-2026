
<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];
$pesan = '';
$tipe_pesan = '';

if (isset($_POST['tambah']) && $role == "admin") {

    $pelanggaran_kategori_id = $_POST['pelanggaran_kategori_id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $poin = $_POST['poin'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_pelanggaran
    (pelanggaran_kategori_id, kode, nama, poin, deskripsi, status_aktif)
    VALUES
    ('$pelanggaran_kategori_id', '$kode', '$nama', '$poin', '$deskripsi', '$status_aktif')");

    if ($query) {
        $pesan = "Jenis pelanggaran berhasil ditambahkan.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Jenis pelanggaran gagal ditambahkan.";
        $tipe_pesan = "danger";
    }
}

if (isset($_POST['ubah']) && $role == "admin") {

    $id = $_POST['id'];
    $pelanggaran_kategori_id = $_POST['pelanggaran_kategori_id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $poin = $_POST['poin'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_pelanggaran SET pelanggaran_kategori_id = '$pelanggaran_kategori_id',
    kode = '$kode',
    nama = '$nama',
    poin = '$poin',
    deskripsi = '$deskripsi',
    status_aktif = '$status_aktif'
    WHERE id = '$id'");

    if ($query) {
        $pesan = "Jenis pelanggaran berhasil diubah.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Jenis pelanggaran gagal diubah.";
        $tipe_pesan = "danger";
    }
}

if (isset($_GET['hapus']) && $role == "admin") {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_pelanggaran
        WHERE id = '$id'");

    if ($query) {
        $pesan = "Jenis pelanggaran berhasil dihapus.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Jenis pelanggaran gagal dihapus. Data mungkin masih digunakan.";
        $tipe_pesan = "danger";
    }
}

$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT *
        FROM t_pelanggaran
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jenis Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 p-3 min-vh-100"
               style="background-color: #30318B;">

            <h4 class="text-white mb-4">Sistem Pelanggaran</h4>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
                </li>

                <?php if ($role == "admin") { ?>

                    <li class="nav-item mb-2">
                        <a href="data_siswa.php" class="nav-link text-white">Data Siswa</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_guru.php" class="nav-link text-white">Data Guru</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_kelas.php" class="nav-link text-white">Kelas</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_tahun_ajaran.php" class="nav-link text-white">Tahun Ajaran</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="penempatan_siswa.php" class="nav-link text-white">Penempatan Siswa</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="wali_kelas.php" class="nav-link text-white">Wali Kelas</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="kategori_pelanggaran.php" class="nav-link text-white">Kategori Pelanggaran</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="jenis_pelanggaran.php"
                           class="nav-link active"
                           aria-current="page">Jenis Pelanggaran</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="laporan.php" class="nav-link text-white">Laporan</a>
                    </li>

                <?php } elseif ($role == "guru") { ?>

                    <li class="nav-item mb-2">
                        <a href="catat_pelanggaran.php" class="nav-link text-white">Catat Pelanggaran</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="tindakan.php" class="nav-link text-white">Tindakan</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="riwayat_pelanggaran.php" class="nav-link text-white">Riwayat</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="rekap_poin.php" class="nav-link text-white">Rekap Poin</a>
                    </li>

                <?php } ?>

                <hr class="text-secondary">

                <li class="nav-item mb-2">
                    <a href="about_me.php" class="nav-link text-white">About Me</a>
                </li>

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>

            </ul>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
<!-- JUDUL HALAMAN -->
<div class="d-flex justify-content-between
            align-items-center mb-4">

    <h3 class="fw-bold mb-0">Kelola Jenis Pelanggaran</h3>
</div>
            <!-- NOTIFIKASI -->
            <?php if ($pesan !== '') { ?>

                <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show"
                     role="alert">

                    <?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Tutup"></button>
                </div>

            <?php } ?>

            <!-- FORM TAMBAH DAN UBAH -->
            <?php if ($role == "admin") { ?>

                <?php if ($data_edit != null) { ?>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Ubah Jenis Pelanggaran</h5>
                        </div>

                        <div class="card-body">
                            <form method="POST">

                                <input type="hidden" name="id"
                                       value="<?php echo $data_edit['id']; ?>">

                                <div class="mb-3">
                                    <label class="form-label">Kategori Pelanggaran</label>

                                    <select name="pelanggaran_kategori_id"
                                            class="form-select" required>

                                        <?php
                                        $kategori = mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM t_pelanggaran_kategori
                                             WHERE status_aktif = 1
                                             ORDER BY nama ASC"
                                        );

                                        while ($row = mysqli_fetch_assoc($kategori)) {
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"
                                                <?php
                                                if ($data_edit['pelanggaran_kategori_id'] == $row['id'])
                                                    echo "selected";
                                                ?>>
                                                <?php echo $row['nama']; ?>
                                            </option>

                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Pelanggaran</label>
                                    <input type="text" name="kode"
                                           class="form-control"
                                           value="<?php echo $data_edit['kode']; ?>"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Pelanggaran</label>
                                    <input type="text" name="nama"
                                           class="form-control"
                                           value="<?php echo $data_edit['nama']; ?>"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Poin</label>
                                    <input type="number" name="poin"
                                           class="form-control"
                                           value="<?php echo $data_edit['poin']; ?>"
                                           min="0" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi"
                                              class="form-control"
                                              rows="4"><?php echo $data_edit['deskripsi']; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status_aktif"
                                            class="form-select" required>

                                        <option value="1"
                                            <?php
                                            if ($data_edit['status_aktif'] == 1)
                                                echo "selected";
                                            ?>>Aktif</option>

                                        <option value="0"
                                            <?php
                                            if ($data_edit['status_aktif'] == 0)
                                                echo "selected";
                                            ?>>Tidak Aktif</option>

                                    </select>
                                </div>

                                <button type="submit" name="ubah"
                                        class="btn btn-primary me-2">
                                    Simpan Perubahan
                                </button>

                                <a href="jenis_pelanggaran.php"
                                   class="btn btn-secondary">Batal</a>

                            </form>
                        </div>
                    </div>

                <?php } else { ?>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Tambah Jenis Pelanggaran</h5>
                        </div>

                        <div class="card-body">
                            <form method="POST">

                                <div class="mb-3">
                                    <label class="form-label">Kategori Pelanggaran</label>

                                    <select name="pelanggaran_kategori_id"
                                            class="form-select" required>

                                        <option value="">-- Pilih Kategori --</option>

                                        <?php
                                        $kategori = mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM t_pelanggaran_kategori
                                             WHERE status_aktif = 1
                                             ORDER BY nama ASC"
                                        );

                                        while ($row = mysqli_fetch_assoc($kategori)) {
                                        ?>

                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['nama']; ?>
                                            </option>

                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Pelanggaran</label>
                                    <input type="text" name="kode"
                                           class="form-control"
                                           placeholder="Contoh: PLG001"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Pelanggaran</label>
                                    <input type="text" name="nama"
                                           class="form-control"
                                           placeholder="Contoh: Terlambat"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Poin</label>
                                    <input type="number" name="poin"
                                           class="form-control"
                                           min="0"
                                           placeholder="Contoh: 5"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi"
                                              class="form-control"
                                              rows="4"
                                              placeholder="Masukkan deskripsi pelanggaran"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status_aktif"
                                            class="form-select" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>

                                <button type="submit" name="tambah"
                                        class="btn btn-primary">
                                    Tambah Jenis Pelanggaran
                                </button>

                            </form>
                        </div>
                    </div>

                <?php } ?>

            <?php } ?>

            <!-- DAFTAR JENIS PELANGGARAN -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Jenis Pelanggaran</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped align-middle mb-0">

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Kode</th>
                                    <th>Nama Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>

                                    <?php if ($role == "admin") { ?>
                                        <th>Aksi</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = mysqli_query($koneksi, "
                                    SELECT
                                        t_pelanggaran.*,
                                        t_pelanggaran_kategori.nama AS nama_kategori
                                    FROM t_pelanggaran
                                    INNER JOIN t_pelanggaran_kategori
                                        ON t_pelanggaran.pelanggaran_kategori_id
                                        = t_pelanggaran_kategori.id
                                    ORDER BY t_pelanggaran.kode ASC
                                ");

                                $no = 1;

                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row['nama_kategori']; ?></td>
                                        <td><?php echo $row['kode']; ?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['poin']; ?></td>
                                        <td><?php echo $row['deskripsi']; ?></td>

                                        <td>
                                            <?php
                                            if ($row['status_aktif'] == 1) {
                                                echo '<span class="badge text-bg-success">Aktif</span>';
                                            } else {
                                                echo '<span class="badge text-bg-secondary">Tidak Aktif</span>';
                                            }
                                            ?>
                                        </td>

                                        <?php if ($role == "admin") { ?>
                                            <td class="text-nowrap">
                                                <a class="btn btn-warning btn-sm"
                                                   href="jenis_pelanggaran.php?edit=<?php echo $row['id']; ?>">
                                                    Ubah
                                                </a>

                                                <a class="btn btn-danger btn-sm"
                                                   href="jenis_pelanggaran.php?hapus=<?php echo $row['id']; ?>"
                                                   onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">
                                                    Hapus
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>

                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
