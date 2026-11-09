<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];
$pesan = '';
$tipe_pesan = '';

if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    $tipe_pesan = $_SESSION['tipe_pesan'] ?? '';
    unset($_SESSION['pesan'], $_SESSION['tipe_pesan']);
}

// TAMBAH KATEGORI
if (isset($_POST['tambah']) && $role == "admin") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query(
        $koneksi,
        "INSERT INTO t_pelanggaran_kategori (nama, deskripsi, status_aktif)
         VALUES ('$nama', '$deskripsi', '$status_aktif')"
    );

    if ($query) {
        $pesan = "Kategori pelanggaran berhasil ditambahkan.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Kategori pelanggaran gagal ditambahkan.";
        $tipe_pesan = "danger";
    }
}

// UBAH KATEGORI
if (isset($_POST['ubah']) && $role == "admin") {
    $id = (int) ($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $status_aktif = (int) ($_POST['status_aktif'] ?? -1);

    $stmt_cek = mysqli_prepare($koneksi, "
        SELECT nama, deskripsi, status_aktif
        FROM t_pelanggaran_kategori
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt_cek, "i", $id);
    mysqli_stmt_execute($stmt_cek);

    $hasil_cek = mysqli_stmt_get_result($stmt_cek);
    $data_lama = mysqli_fetch_assoc($hasil_cek);

    mysqli_stmt_close($stmt_cek);

    // Jika tidak ada perubahan, langsung kembali tanpa notifikasi
    if (
        $data_lama &&
        $data_lama['nama'] == $nama &&
        (string)($data_lama['deskripsi'] ?? '') === $deskripsi &&
        (int)$data_lama['status_aktif'] === $status_aktif
    ) {
        header("Location: kategori_pelanggaran.php");
        exit;
    }

    $query = mysqli_query(
        $koneksi,
        "UPDATE t_pelanggaran_kategori SET
            nama = '$nama',
            deskripsi = '$deskripsi',
            status_aktif = '$status_aktif'
         WHERE id = '$id'"
    );

    $_SESSION['pesan'] = $query
        ? "Kategori pelanggaran berhasil diubah."
        : "Kategori pelanggaran gagal diubah.";

    $_SESSION['tipe_pesan'] = $query ? "success" : "danger";

    header("Location: kategori_pelanggaran.php");
    exit;
}

// HAPUS KATEGORI
if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

    $query = mysqli_query(
        $koneksi,
        "DELETE FROM t_pelanggaran_kategori WHERE id = '$id'"
    );

    if ($query) {
        $pesan = "Kategori pelanggaran berhasil dihapus.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Kategori pelanggaran gagal dihapus. Kategori mungkin masih digunakan.";
        $tipe_pesan = "danger";
    }
}

// AMBIL DATA UNTUK DIEDIT
$data_edit = null;

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query(
        $koneksi,
        "SELECT * FROM t_pelanggaran_kategori WHERE id = '$id_edit'"
    );

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Kategori Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/3.1.4/css/dataTables.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

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
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <?php if ($role == "admin") { ?>

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
                        <a href="kategori_pelanggaran.php"
                           class="nav-link active"
                           aria-current="page">
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

                <?php } elseif ($role == "guru") { ?>

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

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL HALAMAN DAN TOMBOL FORM -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3 class="fw-bold mb-0">
                    Kelola Kategori Pelanggaran
                </h3>

                <?php if ($role == "admin") { ?>

                    <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalKategori">
                        Tambah Kategori
                    </button>

                <?php } ?>

            </div>

            <!-- NOTIFIKASI -->
            <?php if ($pesan !== '') { ?>

                <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show mb-3"
                     role="alert">

                    <?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>

                </div>

            <?php } ?>

            <!-- MODAL TAMBAH / UBAH KATEGORI -->
            <?php if ($role == "admin") { ?>

                <div class="modal fade"
                     id="modalKategori"
                     tabindex="-1"
                     aria-hidden="true">

                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">

                            <form method="POST">

                                <div class="modal-header">

                                    <h5 class="modal-title fw-bold">

                                        <?php
                                        echo ($data_edit != null)
                                            ? "Ubah Kategori Pelanggaran"
                                            : "Tambah Kategori Pelanggaran";
                                        ?>

                                    </h5>

                                    <a href="kategori_pelanggaran.php"
                                       class="btn-close"
                                       aria-label="Tutup">
                                    </a>

                                </div>

                                <div class="modal-body p-4">

                                    <?php if ($data_edit != null) { ?>

                                        <input type="hidden"
                                               name="id"
                                               value="<?php echo htmlspecialchars($data_edit['id'], ENT_QUOTES, 'UTF-8'); ?>">

                                    <?php } ?>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Nama Kategori
                                            </label>

                                            <input type="text"
                                                   name="nama"
                                                   class="form-control"
                                                   placeholder="Contoh: Ringan"
                                                   value="<?php echo ($data_edit != null) ? htmlspecialchars($data_edit['nama'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                                   required>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Status
                                            </label>

                                            <select name="status_aktif"
                                                    class="form-select"
                                                    required>

                                                <option value="1"
                                                    <?php if ($data_edit != null && $data_edit['status_aktif'] == 1) echo 'selected'; ?>>
                                                    Aktif
                                                </option>

                                                <option value="0"
                                                    <?php if ($data_edit != null && $data_edit['status_aktif'] == 0) echo 'selected'; ?>>
                                                    Tidak Aktif
                                                </option>

                                            </select>

                                        </div>

                                        <div class="col-12 mb-3">

                                            <label class="form-label">
                                                Deskripsi
                                            </label>

                                            <textarea name="deskripsi"
                                                      class="form-control"
                                                      rows="4"
                                                      placeholder="Masukkan deskripsi kategori"><?php echo ($data_edit != null) ? htmlspecialchars($data_edit['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8') : ''; ?></textarea>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <a href="kategori_pelanggaran.php"
                                       class="btn btn-secondary">
                                        Batal
                                    </a>

                                    <button type="submit"
                                            name="<?php echo ($data_edit != null) ? 'ubah' : 'tambah'; ?>"
                                            class="btn btn-primary">

                                        <?php
                                        echo ($data_edit != null)
                                            ? 'Simpan Perubahan'
                                            : 'Simpan Kategori';
                                        ?>

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <?php if ($data_edit != null) { ?>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {

                            var modalKategori = new bootstrap.Modal(
                                document.getElementById('modalKategori')
                            );

                            modalKategori.show();

                        });
                    </script>

                <?php } ?>

            <?php } ?>

            <!-- DAFTAR KATEGORI -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Daftar Kategori Pelanggaran
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">

                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>

                                    <?php if ($role == "admin") { ?>
                                        <th>Aksi</th>
                                    <?php } ?>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $query = mysqli_query(
                                    $koneksi,
                                    "SELECT * FROM t_pelanggaran_kategori ORDER BY nama ASC"
                                );

                                $no = 1;

                                while ($row = mysqli_fetch_assoc($query)) {

                                ?>

                                    <tr>

                                        <td>
                                            <?php echo $no; ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
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

                                                <a href="kategori_pelanggaran.php?edit=<?php echo urlencode($row['id']); ?>"
                                                   class="btn btn-warning btn-sm">
                                                    Ubah
                                                </a>

                                                <a href="kategori_pelanggaran.php?hapus=<?php echo urlencode($row['id']); ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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

            <p class="text-center text-secondary small mt-4">
                ©Sofinurjanah
            </p>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/3.1.4/js/dataTables.min.js"></script>

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
        emptyTable: 'Belum ada data kategori',
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