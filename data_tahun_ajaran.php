
<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

$pesan = '';
$tipe_pesan = '';

/* TAMBAH DATA TAHUN AJARAN */
if (isset($_POST['tambah']) && $role == "admin") {

    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    if ($tanggal_mulai > $tanggal_selesai) {
        $pesan = "Tanggal mulai tidak boleh melebihi tanggal selesai.";
        $tipe_pesan = "danger";
    } else {
        $stmt = mysqli_prepare($koneksi, "
            INSERT INTO t_tahun_ajaran
            (nama, tanggal_mulai, tanggal_selesai, status_aktif)
            VALUES (?, ?, ?, 0)
        ");

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $nama,
            $tanggal_mulai,
            $tanggal_selesai
        );

        if (mysqli_stmt_execute($stmt)) {
            $pesan = "Data tahun ajaran berhasil ditambahkan.";
            $tipe_pesan = "success";
        } else {
            $pesan = "Data gagal ditambahkan: " . mysqli_error($koneksi);
            $tipe_pesan = "danger";
        }

        mysqli_stmt_close($stmt);
    }
}

/* UBAH DATA TAHUN AJARAN */
if (isset($_POST['ubah']) && $role == "admin") {

    $id = (int) $_POST['id'];
    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    if ($tanggal_mulai > $tanggal_selesai) {
        $pesan = "Tanggal mulai tidak boleh melebihi tanggal selesai.";
        $tipe_pesan = "danger";
    } else {
        $stmt = mysqli_prepare($koneksi, "
            UPDATE t_tahun_ajaran SET
                nama = ?,
                tanggal_mulai = ?,
                tanggal_selesai = ?,
                status_aktif = 0
            WHERE id = ?
        ");

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $nama,
            $tanggal_mulai,
            $tanggal_selesai,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            $pesan = "Data tahun ajaran berhasil diubah.";
            $tipe_pesan = "success";
        } else {
            $pesan = "Data gagal diubah: " . mysqli_error($koneksi);
            $tipe_pesan = "danger";
        }

        mysqli_stmt_close($stmt);
    }
}

/* HAPUS DATA TAHUN AJARAN */
if (isset($_GET['hapus']) && $role == "admin") {

    $id = (int) $_GET['hapus'];

    $stmt = mysqli_prepare(
        $koneksi,
        "DELETE FROM t_tahun_ajaran WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $pesan = "Data tahun ajaran berhasil dihapus.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Data gagal dihapus. Data mungkin masih digunakan.";
        $tipe_pesan = "danger";
    }

    mysqli_stmt_close($stmt);
}

/* MENENTUKAN SATU TAHUN AJARAN AKTIF */
mysqli_query($koneksi, "
    UPDATE t_tahun_ajaran
    SET status_aktif = 0
");

$query_aktif = mysqli_query($koneksi, "
    SELECT id
    FROM t_tahun_ajaran
    WHERE tanggal_mulai <= CURDATE()
    AND tanggal_selesai >= CURDATE()
    ORDER BY tanggal_mulai DESC, id DESC
    LIMIT 1
");

if ($query_aktif && mysqli_num_rows($query_aktif) > 0) {

    $baris_aktif = mysqli_fetch_assoc($query_aktif);
    $id_aktif = (int) $baris_aktif['id'];

    mysqli_query($koneksi, "
        UPDATE t_tahun_ajaran
        SET status_aktif = 1
        WHERE id = $id_aktif
    ");
}

/* MENGAMBIL DATA UNTUK EDIT */
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {

    $id_edit = (int) $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "
        SELECT * FROM t_tahun_ajaran
        WHERE id = $id_edit
    ");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Tahun Ajaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

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
                        <a href="data_tahun_ajaran.php"
                           class="nav-link active"
                           aria-current="page">
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
                            Riwayat Pelanggaran
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
        <main class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3 class="fw-bold mb-0">
                    Tahun Ajaran
                </h3>

                <?php if ($role == "admin" && $data_edit == null) { ?>

                    <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                        Tambah Tahun Ajaran
                    </button>

                <?php } ?>

            </div>

            <!-- NOTIFIKASI -->
            <?php if ($pesan !== '') { ?>

                <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show">

                    <?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            <?php } ?>

            <!-- MODAL EDIT -->
            <?php if ($role == "admin" && $data_edit != null) { ?>

                <div class="modal fade" id="modalUbahTahun"
                     tabindex="-1">

                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">

                            <form method="POST">

                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">
                                        Ubah Tahun Ajaran
                                    </h5>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>
                                </div>

                                <div class="modal-body p-4">

                                    <input type="hidden"
                                           name="id"
                                           value="<?= (int)$data_edit['id']; ?>">

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Nama Tahun Ajaran
                                        </label>

                                        <input type="text"
                                               name="nama"
                                               class="form-control"
                                               value="<?= htmlspecialchars($data_edit['nama'], ENT_QUOTES, 'UTF-8'); ?>"
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Tanggal Mulai
                                        </label>

                                        <input type="date"
                                               name="tanggal_mulai"
                                               class="form-control"
                                               value="<?= htmlspecialchars($data_edit['tanggal_mulai'], ENT_QUOTES, 'UTF-8'); ?>"
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Tanggal Selesai
                                        </label>

                                        <input type="date"
                                               name="tanggal_selesai"
                                               class="form-control"
                                               value="<?= htmlspecialchars($data_edit['tanggal_selesai'], ENT_QUOTES, 'UTF-8'); ?>"
                                               required>
                                    </div>

                                    <div class="alert alert-info mb-0">
                                        Status aktif ditentukan otomatis
                                        berdasarkan tanggal hari ini.
                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <a href="data_tahun_ajaran.php"
                                       class="btn btn-secondary">
                                        Batal
                                    </a>

                                    <button type="submit"
                                            name="ubah"
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
                        new bootstrap.Modal(
                            document.getElementById('modalUbahTahun')
                        ).show();
                    });
                </script>

            <?php } ?>

            <!-- DAFTAR TAHUN AJARAN -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        Daftar Tahun Ajaran
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
       class="table table-bordered table-striped table-hover align-middle mb-0">

    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Nama Tahun Ajaran</th>
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

                                $query_tahun = mysqli_query($koneksi, "
                                    SELECT * FROM t_tahun_ajaran
                                    ORDER BY tanggal_mulai DESC
                                ");

                                $no = 1;

                                while ($tahun = mysqli_fetch_assoc($query_tahun)) {

                                ?>

                                    <tr>

                                        <td><?= $no; ?></td>

                                        <td>
                                            <?= htmlspecialchars($tahun['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($tahun['tanggal_mulai']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($tahun['tanggal_selesai']); ?>
                                        </td>

                                        <td>

                                            <?php if ($tahun['status_aktif'] == 1) { ?>

                                                <span class="badge bg-success">
                                                    Aktif
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-secondary">
                                                    Tidak Aktif
                                                </span>

                                            <?php } ?>

                                        </td>

                                        <?php if ($role == "admin") { ?>

                                            <td class="text-nowrap">

                                                <a href="data_tahun_ajaran.php?edit=<?= (int)$tahun['id']; ?>"
                                                   class="btn btn-warning btn-sm">
                                                    Ubah
                                                </a>

                                                <a href="data_tahun_ajaran.php?hapus=<?= (int)$tahun['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
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

<!-- MODAL TAMBAH -->
<?php if ($role == "admin") { ?>

    <div class="modal fade" id="modalTambah"
         tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form method="POST">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Tahun Ajaran
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Tahun Ajaran
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Contoh: 2026/2027"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Tanggal Mulai
                            </label>

                            <input type="date"
                                   name="tanggal_mulai"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Tanggal Selesai
                            </label>

                            <input type="date"
                                   name="tanggal_selesai"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="alert alert-info mb-0">

                            Status aktif ditentukan otomatis
                            berdasarkan tanggal hari ini.
                            Hanya satu tahun ajaran yang dapat aktif.

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
            emptyTable: 'Belum ada data tahun ajaran',
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
