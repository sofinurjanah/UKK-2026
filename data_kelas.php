
<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower($_SESSION['role']);
$pesan = '';
$tipe_pesan = '';

/* TAMBAH DATA KELAS */
if (isset($_POST['tambah']) && $role == "admin") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $status_aktif = (int) $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_kelas
        (nama, tingkat, jurusan, status_aktif)
        VALUES
        ('$nama', '$tingkat', '$jurusan', '$status_aktif')");

    $pesan = $query
        ? "Data kelas berhasil ditambahkan."
        : "Data kelas gagal ditambahkan.";
    $tipe_pesan = $query ? "success" : "danger";
}

/* UBAH DATA KELAS */
if (isset($_POST['ubah']) && $role == "admin") {
    $id = (int) $_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $status_aktif = (int) $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_kelas SET
        nama = '$nama',
        tingkat = '$tingkat',
        jurusan = '$jurusan',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    $pesan = $query
        ? "Data kelas berhasil diubah."
        : "Data kelas gagal diubah.";
    $tipe_pesan = $query ? "success" : "danger";
}

/* HAPUS DATA KELAS */
if (isset($_GET['hapus']) && $role == "admin") {
    $id = (int) $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_kelas
        WHERE id = '$id'");

    $pesan = $query
        ? "Data kelas berhasil dihapus."
        : "Data kelas gagal dihapus. Data mungkin masih digunakan.";
    $tipe_pesan = $query ? "success" : "danger";
}

/* MENGAMBIL DATA KELAS UNTUK DIUBAH */
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {
    $id_edit = (int) $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_kelas
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas</title>

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
                        <a href="data_kelas.php" class="nav-link active" aria-current="page">Kelas</a>
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
                        <a href="jenis_pelanggaran.php" class="nav-link text-white">Jenis Pelanggaran</a>
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
                        <a href="riwayat_pelanggaran.php" class="nav-link text-white">Riwayat Pelanggaran</a>
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
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL DAN TOMBOL TAMBAH -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Data Kelas</h3>

                <?php if ($role == "admin" && $data_edit == null) { ?>
                    <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                        Tambah Kelas
                    </button>
                <?php } ?>
            </div>

            <!-- NOTIFIKASI -->
            <?php if ($pesan !== '') { ?>
                <div class="alert alert-<?= $tipe_pesan; ?> alert-dismissible fade show mb-3"
                     role="alert">
                    <?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>

                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <!-- FORM UBAH KELAS -->
            <?php if ($role == "admin" && $data_edit != null) { ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Ubah Data Kelas</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id"
                                   value="<?= $data_edit['id']; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kelas</label>
                                    <input type="text" name="nama"
                                           class="form-control"
                                           value="<?= htmlspecialchars($data_edit['nama'], ENT_QUOTES, 'UTF-8'); ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tingkat</label>
                                    <select name="tingkat" class="form-select" required>
                                        <option value="X" <?= $data_edit['tingkat'] == "X" ? "selected" : ""; ?>>X</option>
                                        <option value="XI" <?= $data_edit['tingkat'] == "XI" ? "selected" : ""; ?>>XI</option>
                                        <option value="XII" <?= $data_edit['tingkat'] == "XII" ? "selected" : ""; ?>>XII</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <input type="text" name="jurusan"
                                           class="form-control"
                                           value="<?= htmlspecialchars($data_edit['jurusan'], ENT_QUOTES, 'UTF-8'); ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Aktif</label>
                                    <select name="status_aktif" class="form-select" required>
                                        <option value="1" <?= $data_edit['status_aktif'] == 1 ? "selected" : ""; ?>>Aktif</option>
                                        <option value="0" <?= $data_edit['status_aktif'] == 0 ? "selected" : ""; ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" name="ubah" class="btn btn-success">
                                Simpan Perubahan
                            </button>

                            <a href="data_kelas.php" class="btn btn-danger">Batal</a>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <!-- TABEL DAFTAR KELAS -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Kelas</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>

                                    <?php if ($role == "admin") { ?>
                                        <th>Aksi</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query_kelas = mysqli_query(
                                    $koneksi,
                                    "SELECT * FROM t_kelas ORDER BY id ASC"
                                );
                                $no = 1;

                                while ($kelas = mysqli_fetch_assoc($query_kelas)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td><?= htmlspecialchars($kelas['nama'], ENT_QUOTES, 'UTF-8'); ?></td>

                                        <td><?= htmlspecialchars($kelas['tingkat'], ENT_QUOTES, 'UTF-8'); ?></td>

                                        <td><?= htmlspecialchars($kelas['jurusan'], ENT_QUOTES, 'UTF-8'); ?></td>

                                        <td>
                                            <?php if ($kelas['status_aktif'] == 1) { ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            <?php } ?>
                                        </td>

                                        <?php if ($role == "admin") { ?>
                                            <td class="text-nowrap">
                                                <a href="data_kelas.php?edit=<?= $kelas['id']; ?>"
                                                   class="btn btn-warning btn-sm">Ubah</a>

                                                <a href="data_kelas.php?hapus=<?= $kelas['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menghapus data kelas ini?')">
                                                    Hapus
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <p class="text-center text-secondary small mt-4">©Sofinurjanah</p>
        </main>
    </div>
</div>

<!-- MODAL TAMBAH KELAS -->
<?php if ($role == "admin") { ?>
<div class="modal fade" id="modalTambah" tabindex="-1"
     aria-labelledby="judulModalTambah" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="judulModalTambah">Tambah Data Kelas</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tingkat</label>
                        <select name="tingkat" class="form-select" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Aktif</label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" name="tambah" class="btn btn-primary">
                            Tambah
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
