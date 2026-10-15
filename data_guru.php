
<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = strtolower($_SESSION['role']);

// TAMBAH GURU
if (isset($_POST['tambah']) && $role == "admin") {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $status_aktif = $_POST['status_aktif'];
    $user_id = $_POST['user_id'];

    $query = mysqli_query($koneksi, "INSERT INTO t_guru
        (nip, nama, email, status_aktif, user_id)
        VALUES
        ('$nip', '$nama', '$email', '$status_aktif', '$user_id')");

    if ($query) {
        header("Location: data_guru.php?pesan=tambah");
        exit;
    } else {
        header("Location: data_guru.php?pesan=gagal");
        exit;
    }
}

// UBAH GURU
if (isset($_POST['ubah']) && $role == "admin") {
    $id = $_POST['id'];
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_guru SET
        nip = '$nip',
        nama = '$nama',
        email = '$email',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        header("Location: data_guru.php?pesan=ubah");
        exit;
    } else {
        header("Location: data_guru.php?pesan=gagal");
        exit;
    }
}

// HAPUS GURU DENGAN MENONAKTIFKAN DATANYA
if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "UPDATE t_guru
        SET status_aktif = 0
        WHERE id = '$id'");

    if ($query) {
        header("Location: data_guru.php?pesan=hapus");
        exit;
    } else {
        header("Location: data_guru.php?pesan=gagal");
        exit;
    }
}

// AMBIL DATA GURU UNTUK DIEDIT
$data_edit = null;

if (isset($_GET['edit']) && $role == "admin") {
    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_guru
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Guru</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
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
                           class="nav-link text-white"
                           aria-current="page">
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
        <div class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold mb-0">Data Guru</h3>

                <?php if ($role == "admin" && $data_edit == null) { ?>
                    <a href="data_guru.php?tambah=1" class="btn btn-primary">
                        Tambah Guru
                    </a>
                <?php } ?>
            </div>

            <!-- NOTIFIKASI -->
            <?php if (isset($_GET['pesan'])) { ?>

                <?php if ($_GET['pesan'] == 'hapus') { ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Data guru berhasil dinonaktifkan.
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
                    </div>

                <?php } elseif ($_GET['pesan'] == 'tambah') { ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Data guru berhasil ditambahkan.
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
                    </div>

                <?php } elseif ($_GET['pesan'] == 'ubah') { ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Data guru berhasil diubah.
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
                    </div>

                <?php } elseif ($_GET['pesan'] == 'gagal') { ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        Proses gagal. Periksa kembali data dan database kamu.
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
                    </div>
                <?php } ?>

            <?php } ?>

            <!-- FORM TAMBAH / UBAH -->
            <?php if ($role == "admin" && ($data_edit != null || isset($_GET['tambah']))) { ?>

                <div class="card shadow-sm border-0 rounded-3 mb-4"
                     id="formGuru">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <?php
                            echo ($data_edit != null)
                                ? "Ubah Data Guru"
                                : "Tambah Data Guru";
                            ?>
                        </h5>
                    </div>

                    <div class="card-body">

                        <form method="POST">

                            <?php if ($data_edit != null) { ?>
                                <input type="hidden" name="id"
                                       value="<?php echo $data_edit['id']; ?>">
                            <?php } ?>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" name="nip"
                                           class="form-control"
                                           value="<?php echo $data_edit['nip'] ?? ''; ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text" name="nama"
                                           class="form-control"
                                           value="<?php echo $data_edit['nama'] ?? ''; ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                           class="form-control"
                                           value="<?php echo $data_edit['email'] ?? ''; ?>"
                                           required>
                                </div>

                                <?php if ($data_edit == null) { ?>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Akun Pengguna</label>

                                        <select name="user_id" class="form-select" required>
                                            <option value="">-- Pilih Akun Guru --</option>

                                            <?php
                                            $query_user = mysqli_query($koneksi,
                                                "SELECT * FROM t_user WHERE role = 'guru'");

                                            while ($user = mysqli_fetch_assoc($query_user)) {
                                            ?>
                                                <option value="<?php echo $user['id']; ?>">
                                                    <?php echo $user['name']; ?>
                                                    - <?php echo $user['email']; ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                <?php } ?>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Aktif</label>

                                    <select name="status_aktif" class="form-select" required>
                                        <option value="1"
                                            <?php
                                            if (($data_edit['status_aktif'] ?? 1) == 1) {
                                                echo "selected";
                                            }
                                            ?>>
                                            Aktif
                                        </option>

                                        <option value="0"
                                            <?php
                                            if (($data_edit['status_aktif'] ?? 1) == 0) {
                                                echo "selected";
                                            }
                                            ?>>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <?php if ($data_edit != null) { ?>

                                <button type="submit" name="ubah"
                                        class="btn btn-primary">
                                    Simpan Perubahan
                                </button>

                                <a href="data_guru.php" class="btn btn-secondary">
                                    Batal
                                </a>

                            <?php } else { ?>

                                <button type="submit" name="tambah"
                                        class="btn btn-primary">
                                    Tambah Guru
                                </button>

                            <?php } ?>

                        </form>

                    </div>
                </div>

            <?php } ?>

            <!-- TABEL DAFTAR GURU -->
            <div class="card shadow-sm border-0 rounded-3">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Guru</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
                               class="table table-bordered table-striped
                                      table-hover align-middle mb-0">

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
                                $no = 1;

                                $query_guru = mysqli_query($koneksi,
                                    "SELECT * FROM t_guru
                                     WHERE status_aktif = 1
                                     ORDER BY id ASC");

                                while ($guru = mysqli_fetch_assoc($query_guru)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no++; ?></td>

                                        <td><?php echo htmlspecialchars($guru['nip']); ?></td>

                                        <td><?php echo htmlspecialchars($guru['nama']); ?></td>

                                        <td><?php echo htmlspecialchars($guru['email']); ?></td>

                                        <td>
                                            <span class="badge bg-success">
                                                Aktif
                                            </span>
                                        </td>

                                        <?php if ($role == "admin") { ?>

                                            <td>
                                                <a href="data_guru.php?edit=<?php echo $guru['id']; ?>"
                                                   class="btn btn-warning btn-sm">
                                                    Ubah
                                                </a>

                                                <a href="data_guru.php?hapus=<?php echo $guru['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menonaktifkan data guru ini?')">
                                                    Hapus
                                                </a>
                                            </td>

                                        <?php } ?>
                                    </tr>

                                <?php } ?>

                                <?php if (mysqli_num_rows($query_guru) == 0) { ?>
                                    <tr>
                                        <td colspan="<?php echo ($role == 'admin') ? 6 : 5; ?>"
                                            class="text-center text-muted py-4">
                                            Belum ada data guru aktif.
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <p class="text-center text-muted mt-4">
                &copy; 2026 Sistem Informasi Pelanggaran Siswa
            </p>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script>
    if (typeof DataTable !== 'undefined') {
        new DataTable('#example', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            language: {
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data guru aktif.',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });
    } else {
        console.error('DataTables gagal dimuat. Periksa koneksi atau CDN.');
    }
</script>

</body>
</html>
