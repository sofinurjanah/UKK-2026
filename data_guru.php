
<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower($_SESSION['role'] ?? '');
$pesan = "";
$tipe_pesan = "";

/* TAMBAH GURU */
if (isset($_POST['tambah']) && $role == "admin") {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $status_aktif = (int) $_POST['status_aktif'];
    $user_id = (int) $_POST['user_id'];

    $query = mysqli_query($koneksi, "INSERT INTO t_guru
        (nip, nama, email, status_aktif, user_id)
        VALUES ('$nip', '$nama', '$email', '$status_aktif', '$user_id')");

    if ($query) {
        $pesan = "Data guru berhasil ditambahkan.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Data guru gagal ditambahkan.";
        $tipe_pesan = "danger";
    }
}

/* UBAH GURU */
if (isset($_POST['ubah']) && $role == "admin") {
    $id = (int) $_POST['id'];
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $status_aktif = (int) $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_guru SET
        nip = '$nip',
        nama = '$nama',
        email = '$email',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        $pesan = "Data guru berhasil diubah.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Data guru gagal diubah.";
        $tipe_pesan = "danger";
    }
}

/* NONAKTIFKAN GURU */
if (isset($_GET['hapus']) && $role == "admin") {
    $id = (int) $_GET['hapus'];

    $query = mysqli_query($koneksi, "UPDATE t_guru
        SET status_aktif = 0
        WHERE id = '$id'");

    if ($query) {
        $pesan = "Data guru berhasil dinonaktifkan.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Data guru gagal dinonaktifkan.";
        $tipe_pesan = "danger";
    }
}

/* DATA GURU UNTUK DIEDIT */
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {
    $id_edit = (int) $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT *
        FROM t_guru
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
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

    <title>Data Guru</title>

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

            <h4 class="text-white mb-4">
                Sistem Pelanggaran
            </h4>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php"
                       class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') { ?>

                    <li class="nav-item mb-2">
                        <a href="data_siswa.php"
                           class="nav-link text-white">
                            Data Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_guru.php"
                           class="nav-link active"
                           aria-current="page">
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

                <h3 class="fw-bold mb-0">Data Guru</h3>

                <?php if ($role == "admin" && $data_edit == null) { ?>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        Tambah Guru
                    </button>
                <?php } ?>

            </div>

            <!-- NOTIFIKASI -->
            <?php if ($pesan != "") { ?>
                <div class="alert alert-<?= e($tipe_pesan); ?> alert-dismissible fade show text-center mt-3 mb-3"
                     role="alert">

                    <?= e($pesan); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Tutup">
                    </button>
                </div>
            <?php } ?>

            <!-- FORM UBAH GURU -->
            <?php if ($role == "admin" && $data_edit != null) { ?>

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Ubah Data Guru</h5>
                    </div>

                    <div class="card-body">

                        <form method="POST">

                            <input type="hidden"
                                   name="id"
                                   value="<?= e($data_edit['id']); ?>">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text"
                                           name="nip"
                                           class="form-control"
                                           value="<?= e($data_edit['nip']); ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text"
                                           name="nama"
                                           class="form-control"
                                           value="<?= e($data_edit['nama']); ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="<?= e($data_edit['email']); ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Aktif</label>
                                    <select name="status_aktif"
                                            class="form-select"
                                            required>

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

                            </div>

                            <button type="submit"
                                    name="ubah"
                                    class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                            <a href="data_guru.php"
                               class="btn btn-secondary">
                                Batal
                            </a>

                        </form>
                    </div>
                </div>

            <?php } ?>

            <!-- TABEL DATA GURU -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Guru</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Guru</th>
                                    <th>Email</th>
                                    <th>Status</th>

                                    <?php if ($role == "admin") { ?>
                                        <th>Aksi</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $query_guru = mysqli_query(
                                    $koneksi,
                                    "SELECT * FROM t_guru
                                     WHERE status_aktif = 1
                                     ORDER BY id ASC"
                                );

                                $no = 1;

                                while ($guru = mysqli_fetch_assoc($query_guru)) {
                                ?>

                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td><?= e($guru['nip']); ?></td>

                                        <td><?= e($guru['nama']); ?></td>

                                        <td><?= e($guru['email']); ?></td>

                                        <td>
                                            <span class="badge text-bg-success">
                                                Aktif
                                            </span>
                                        </td>

                                        <?php if ($role == "admin") { ?>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <a
                                                        href="data_guru.php?edit=<?= e($guru['id']); ?>"
                                                        class="btn btn-warning btn-sm">
                                                        Ubah
                                                    </a>

                                                    <a
                                                        href="data_guru.php?hapus=<?= e($guru['id']); ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menonaktifkan data guru ini?')">
                                                        Hapus
                                                    </a>

                                                </div>
                                            </td>
                                        <?php } ?>

                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- COPYRIGHT -->
            <p class="text-center text-secondary small mt-4">
                ©Sofinurjanah
            </p>

        </main>
    </div>
</div>

<!-- MODAL TAMBAH GURU -->
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
                            Tambah Data Guru
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
                                <label class="form-label">NIP</label>
                                <input type="text"
                                       name="nip"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Guru</label>
                                <input type="text"
                                       name="nama"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Akun Pengguna</label>

                                <select name="user_id"
                                        class="form-select"
                                        required>

                                    <option value="">-- Pilih Akun Guru --</option>

                                    <?php
                                    $query_user = mysqli_query(
                                        $koneksi,
                                        "SELECT * FROM t_user
                                         WHERE role = 'guru'
                                         ORDER BY id ASC"
                                    );

                                    while ($user = mysqli_fetch_assoc($query_user)) {
                                    ?>
                                        <option value="<?= e($user['id']); ?>">
                                            <?= e($user['name']); ?> -
                                            <?= e($user['email']); ?>
                                        </option>
                                    <?php } ?>

                                </select>
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

<!-- PENGATURAN DATATABLES -->
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
            emptyTable: 'Belum ada data guru',
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
