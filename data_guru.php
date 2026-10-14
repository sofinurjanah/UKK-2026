
<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

/* TAMBAH DATA GURU */
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
        echo "Data guru gagal ditambahkan.<br>";
    }
}

/* UBAH DATA GURU */
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
        echo "Data guru gagal diubah.<br>";
    }
}

/* HAPUS DATA GURU */
if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_guru
        WHERE id = '$id'");

    if ($query) {
        header("Location: data_guru.php?pesan=hapus");
        exit;
    } else {
        echo "Data guru gagal dihapus. Data mungkin masih digunakan.<br>";
    }
}

/* MENGAMBIL DATA GURU UNTUK DIUBAH */
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Guru</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
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
                        <a href="data_guru.php" class="nav-link active">
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
        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL DAN TOMBOL TAMBAH -->
            <div class="d-flex justify-content-between
                        align-items-center mb-4">

                <h3 class="fw-bold mb-0">Data Guru</h3>

                <?php if ($role == "admin" && $data_edit == null) { ?>
                    <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                        Tambah Guru
                    </button>
                <?php } ?>

            </div>

            <!-- PESAN -->
            <?php if (isset($_GET['pesan'])) { ?>

                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">

                    <?php
                    if ($_GET['pesan'] == 'tambah') {
                        echo "Data guru berhasil ditambahkan.";
                    } elseif ($_GET['pesan'] == 'ubah') {
                        echo "Data guru berhasil diubah.";
                    } elseif ($_GET['pesan'] == 'hapus') {
                        echo "Data guru berhasil dihapus.";
                    }
                    ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
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
                                   value="<?php echo $data_edit['id']; ?>">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text"
                                           name="nip"
                                           class="form-control"
                                           value="<?php echo $data_edit['nip']; ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text"
                                           name="nama"
                                           class="form-control"
                                           value="<?php echo $data_edit['nama']; ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="<?php echo $data_edit['email']; ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Aktif</label>
                                    <select name="status_aktif"
                                            class="form-select"
                                            required>

                                        <option value="1"
                                            <?php if ($data_edit['status_aktif'] == 1) echo "selected"; ?>>
                                            Aktif
                                        </option>

                                        <option value="0"
                                            <?php if ($data_edit['status_aktif'] == 0) echo "selected"; ?>>
                                            Tidak Aktif
                                        </option>

                                    </select>
                                </div>

                            </div>

                            <button type="submit"
                                    name="ubah"
                                    class="btn btn-success">
                                Simpan Perubahan
                            </button>

                            <a href="data_guru.php" class="btn btn-danger">
                                Batal
                            </a>

                        </form>

                    </div>
                </div>

            <?php } ?>

            <!-- TABEL DAFTAR GURU -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Guru</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped table-hover align-middle">

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
                                $query_guru = mysqli_query($koneksi, "SELECT * FROM t_guru");
                                $no = 1;

                                while ($guru = mysqli_fetch_assoc($query_guru)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $guru['nip']; ?></td>
                                        <td><?php echo $guru['nama']; ?></td>
                                        <td><?php echo $guru['email']; ?></td>

                                        <td>
                                            <?php if ($guru['status_aktif'] == 1) { ?>
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
                                            <td>
                                                <a href="data_guru.php?edit=<?php echo $guru['id']; ?>"
                                                   class="btn btn-warning btn-sm">
                                                    Ubah
                                                </a>

                                                <a href="data_guru.php?hapus=<?php echo $guru['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menghapus data guru ini?')">
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

                                    <option value="">
                                        -- Pilih Akun Guru --
                                    </option>

                                    <?php
                                    $query_user = mysqli_query(
                                        $koneksi,
                                        "SELECT * FROM t_user WHERE role = 'guru'"
                                    );

                                    while ($user = mysqli_fetch_assoc($query_user)) {
                                    ?>

                                        <option value="<?php echo $user['id']; ?>">
                                            <?php echo $user['name']; ?>
                                            -
                                            <?php echo $user['email']; ?>
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
                                class="btn btn-danger"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit"
                                name="tambah"
                                class="btn btn-success">
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

</body>
</html>
