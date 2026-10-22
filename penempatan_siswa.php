
<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'] ?? '';
$pesan = '';

/* TAMBAH PENEMPATAN SISWA */
if (isset($_POST['tambah']) && $role == "admin") {
    $siswa_id = $_POST['siswa_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $kelas_id = $_POST['kelas_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query_tambah = mysqli_query($koneksi, "INSERT INTO t_kelas_siswa
        (siswa_id, tahun_ajaran_id, kelas_id, tanggal_mulai, tanggal_selesai, status_aktif)
        VALUES
        ('$siswa_id', '$tahun_ajaran_id', '$kelas_id',
         '$tanggal_mulai', '$tanggal_selesai', '$status_aktif')");

    $pesan = $query_tambah
        ? "Penempatan siswa berhasil ditambahkan."
        : "Penempatan siswa gagal ditambahkan.";
}

/* UBAH PENEMPATAN SISWA */
if (isset($_POST['ubah']) && $role == "admin") {
    $id = $_POST['id'];
    $siswa_id = $_POST['siswa_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $kelas_id = $_POST['kelas_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query_ubah = mysqli_query($koneksi, "UPDATE t_kelas_siswa SET
        siswa_id = '$siswa_id',
        tahun_ajaran_id = '$tahun_ajaran_id',
        kelas_id = '$kelas_id',
        tanggal_mulai = '$tanggal_mulai',
        tanggal_selesai = '$tanggal_selesai',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    $pesan = $query_ubah
        ? "Penempatan siswa berhasil diubah."
        : "Penempatan siswa gagal diubah.";
}

/* HAPUS PENEMPATAN SISWA */
if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

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

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

                <p class="text-white mb-0" style="font-size: 10px; line-height: 1.7; opacity: 0.8;">
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

                <h3 class="fw-bold mb-0">Penempatan Siswa</h3>

                <?php
                if (
                    $role == "admin" &&
                    $data_edit == null &&
                    !isset($_GET['tambah'])
                ) {
                ?>
                    <a
                        href="penempatan_siswa.php?tambah=1"
                        class="btn btn-primary"
                    >
                        Tambah Penempatan Siswa
                    </a>
                <?php } ?>
            </div>

            <!-- PESAN -->
            <?php if ($pesan !== '') { ?>
                <div
                    class="alert <?php echo (strpos($pesan, 'berhasil') !== false) ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show"
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

            <!-- FORM TAMBAH / UBAH -->
            <?php if ($role == "admin" && ($data_edit != null || isset($_GET['tambah']))) { ?>

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <?php
                            echo $data_edit != null
                                ? 'Ubah Penempatan Siswa'
                                : 'Tambah Penempatan Siswa';
                            ?>
                        </h5>
                    </div>

                    <div class="card-body">

                        <form
                            method="POST"
                            action="penempatan_siswa.php<?php echo $data_edit != null ? '?edit=' . (int)$data_edit['id'] : ''; ?>"
                        >

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
                                    <label class="form-label">Siswa</label>

                                    <select name="siswa_id" class="form-select" required>
                                        <option value="">-- Pilih Siswa --</option>

                                        <?php
                                        $siswa = mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM t_siswa WHERE status_aktif = 1 ORDER BY nama ASC"
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
                                    <label class="form-label">Tahun Ajaran</label>

                                    <select name="tahun_ajaran_id" class="form-select" required>
                                        <option value="">-- Pilih Tahun Ajaran --</option>

                                        <?php
                                        $tahun = mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM t_tahun_ajaran ORDER BY tanggal_mulai DESC"
                                        );

                                        if ($tahun) {
                                            while ($row_tahun = mysqli_fetch_assoc($tahun)) {
                                                $selected = (
                                                    $data_edit != null &&
                                                    $data_edit['tahun_ajaran_id'] == $row_tahun['id']
                                                ) ? 'selected' : '';

                                                echo '<option value="' .
                                                    (int)$row_tahun['id'] . '" ' .
                                                    $selected . '>' .
                                                    htmlspecialchars($row_tahun['nama']) .
                                                    '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- KELAS -->
                                <div class="col-md-6">
                                    <label class="form-label">Kelas</label>

                                    <select name="kelas_id" class="form-select" required>
                                        <option value="">-- Pilih Kelas --</option>

                                        <?php
                                        $kelas = mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM t_kelas WHERE status_aktif = 1 ORDER BY nama ASC"
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
                                    <label class="form-label">Status</label>

                                    <select name="status_aktif" class="form-select" required>
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
                                    <label class="form-label">Tanggal Mulai</label>

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
                                    <label class="form-label">Tanggal Selesai</label>

                                    <input
                                        type="date"
                                        name="tanggal_selesai"
                                        class="form-control"
                                        value="<?php echo $data_edit != null ? htmlspecialchars($data_edit['tanggal_selesai']) : ''; ?>"
                                        required
                                    >
                                </div>

                            </div>

                            <div class="mt-4 d-flex gap-2">

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

                                <a
                                    href="penempatan_siswa.php"
                                    class="btn btn-secondary"
                                >
                                    Batal
                                </a>

                            </div>

                        </form>
                    </div>
                </div>

            <?php } ?>

            <!-- TABEL DAFTAR PENEMPATAN -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Penempatan Siswa</h5>
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
                                    ORDER BY t_siswa.nama ASC
                                ");

                                $no = 1;

                                if ($query_data) {
                                    while ($row = mysqli_fetch_assoc($query_data)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no++; ?></td>

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
