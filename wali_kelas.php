
<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'] ?? '';
$pesan = '';
$tipe_pesan = '';

/* PESAN SESSION */
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    $tipe_pesan = $_SESSION['tipe_pesan'] ?? 'success';

    unset($_SESSION['pesan']);
    unset($_SESSION['tipe_pesan']);
}

/* TAHUN AJARAN AKTIF */
$query_tahun_aktif = mysqli_query($koneksi, "
    SELECT id, nama
    FROM t_tahun_ajaran
    WHERE status_aktif = 1
    LIMIT 1
");

$tahun_aktif = mysqli_fetch_assoc($query_tahun_aktif);


/* =========================
   TAMBAH WALI KELAS
========================= */

if (isset($_POST['tambah']) && $role == "admin" && $tahun_aktif) {

    $tahun_ajaran_id = (int) $tahun_aktif['id'];
    $kelas_id = $_POST['kelas_id'];
    $guru_id = $_POST['guru_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "
        INSERT INTO t_wali_kelas
        (
            tahun_ajaran_id,
            kelas_id,
            guru_id,
            tanggal_mulai,
            tanggal_selesai,
            status_aktif
        )
        VALUES
        (
            '$tahun_ajaran_id',
            '$kelas_id',
            '$guru_id',
            '$tanggal_mulai',
            '$tanggal_selesai',
            '$status_aktif'
        )
    ");

    if ($query) {
        $_SESSION['pesan'] = "Data wali kelas berhasil ditambahkan.";
        $_SESSION['tipe_pesan'] = "success";

        header("Location: wali_kelas.php");
        exit;
    } else {
        $pesan = "Data wali kelas gagal ditambahkan.";
        $tipe_pesan = "danger";
    }
}


/* =========================
   UBAH WALI KELAS
========================= */

if (isset($_POST['ubah']) && $role == "admin" && $tahun_aktif) {

    $id = (int) $_POST['id'];
    $tahun_ajaran_id = (int) $tahun_aktif['id'];
    $kelas_id = (int) $_POST['kelas_id'];
    $guru_id = (int) $_POST['guru_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = (int) $_POST['status_aktif'];

    /* AMBIL DATA LAMA */
    $query_lama = mysqli_query($koneksi, "
        SELECT *
        FROM t_wali_kelas
        WHERE id = '$id'
    ");

    $data_lama = mysqli_fetch_assoc($query_lama);

    if ($data_lama) {

        /* CEK APAKAH ADA PERUBAHAN */
        $ada_perubahan =
            $data_lama['tahun_ajaran_id'] != $tahun_ajaran_id ||
            $data_lama['kelas_id'] != $kelas_id ||
            $data_lama['guru_id'] != $guru_id ||
            $data_lama['tanggal_mulai'] != $tanggal_mulai ||
            $data_lama['tanggal_selesai'] != $tanggal_selesai ||
            $data_lama['status_aktif'] != $status_aktif;

        /* JIKA TIDAK ADA PERUBAHAN */
        if (!$ada_perubahan) {

            header("Location: wali_kelas.php");
            exit;

        }

        /* JIKA ADA PERUBAHAN */
        $query = mysqli_query($koneksi, "
            UPDATE t_wali_kelas SET
                tahun_ajaran_id = '$tahun_ajaran_id',
                kelas_id = '$kelas_id',
                guru_id = '$guru_id',
                tanggal_mulai = '$tanggal_mulai',
                tanggal_selesai = '$tanggal_selesai',
                status_aktif = '$status_aktif'
            WHERE id = '$id'
        ");

        if ($query) {

            $_SESSION['pesan'] = "Data wali kelas berhasil diubah.";
            $_SESSION['tipe_pesan'] = "success";

            header("Location: wali_kelas.php");
            exit;

        } else {

            $pesan = "Data wali kelas gagal diubah.";
            $tipe_pesan = "danger";

        }

    } else {

        $pesan = "Data wali kelas tidak ditemukan.";
        $tipe_pesan = "danger";

    }
}


/* =========================
   HAPUS WALI KELAS
========================= */

if (isset($_GET['hapus']) && $role == "admin") {

    $id = (int) $_GET['hapus'];

    $query = mysqli_query($koneksi, "
        DELETE FROM t_wali_kelas
        WHERE id = '$id'
    ");

    if ($query) {

        $_SESSION['pesan'] = "Data wali kelas berhasil dihapus.";
        $_SESSION['tipe_pesan'] = "success";

    } else {

        $_SESSION['pesan'] = "Data wali kelas gagal dihapus.";
        $_SESSION['tipe_pesan'] = "danger";

    }

    header("Location: wali_kelas.php");
    exit;
}


/* =========================
   DATA UNTUK EDIT
========================= */

$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = (int) $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "
        SELECT *
        FROM t_wali_kelas
        WHERE id = '$id_edit'
    ");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Wali Kelas</title>

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
                        <a href="penempatan_siswa.php" class="nav-link text-white">
                            Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="wali_kelas.php"
                           class="nav-link active"
                           aria-current="page">
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

                <h3 class="fw-bold mb-0">Kelola Wali Kelas</h3>

                <?php
                if ($role == 'admin') {
                ?>
                    <a href="wali_kelas.php?tambah=1"
                       class="btn btn-primary">
                        Tambah Wali Kelas
                    </a>
                <?php } ?>

            </div>

            <!-- PESAN -->
        <?php if ($pesan !== '') { ?>

            <div class="alert alert-<?php echo htmlspecialchars($tipe_pesan); ?> alert-dismissible fade show"
                role="alert">

                <?php echo htmlspecialchars($pesan); ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Tutup">
                </button>

            </div>

        <?php } ?>

            <!-- MODAL TAMBAH / UBAH WALI KELAS -->
<?php
if ($role == 'admin' &&
    ($data_edit != null || isset($_GET['tambah']))) {
?>

<div class="modal fade" id="modalWaliKelas"
     tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form method="POST"
                  action="wali_kelas.php<?php
                  echo $data_edit != null
                      ? '?edit=' . (int)$data_edit['id']
                      : '';
                  ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <?php
                        echo $data_edit != null
                            ? 'Ubah Data Wali Kelas'
                            : 'Tambah Wali Kelas';
                        ?>
                    </h5>

                    <a href="wali_kelas.php"
   class="btn-close"
   aria-label="Tutup">
</a>
                </div>

                <div class="modal-body p-4">

                    <?php if ($data_edit != null) { ?>
                        <input type="hidden"
                               name="id"
                               value="<?php echo (int)$data_edit['id']; ?>">
                    <?php } ?>

                    <div class="row g-3">

                        <div class="col-md-6 mb-3">
    <label class="form-label">Tahun Ajaran</label>

    <?php if ($tahun_aktif) { ?>

        <input type="text"
               class="form-control"
               value="<?= htmlspecialchars($tahun_aktif['nama']); ?>"
               readonly>

        <input type="hidden"
               name="tahun_ajaran_id"
               value="<?= (int)$tahun_aktif['id']; ?>">

    <?php } else { ?>

        <input type="text"
               class="form-control"
               value="Belum ada tahun ajaran aktif"
               readonly>

    <?php } ?>
</div>

                            <!-- KELAS -->
                            <div class="col-md-6">
                                <label class="form-label">Kelas</label>

                                <select name="kelas_id"
                                        class="form-select"
                                        required>

                                    <option value="">-- Pilih Kelas --</option>

                                    <?php
                                    $kelas = mysqli_query(
                                        $koneksi,
                                        "SELECT * FROM t_kelas
                                         WHERE status_aktif = 1
                                         ORDER BY nama ASC"
                                    );

                                    if ($kelas) {
                                        while ($row = mysqli_fetch_assoc($kelas)) {
                                            $selected = (
                                                $data_edit != null &&
                                                $data_edit['kelas_id'] == $row['id']
                                            ) ? 'selected' : '';

                                            echo '<option value="' .
                                                (int)$row['id'] . '" ' .
                                                $selected . '>' .
                                                htmlspecialchars($row['nama']) .
                                                '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <!-- GURU -->
                            <div class="col-md-6">
                                <label class="form-label">Guru</label>

                                <select name="guru_id"
                                        class="form-select"
                                        required>

                                    <option value="">-- Pilih Guru --</option>

                                    <?php
                                    $guru = mysqli_query(
                                        $koneksi,
                                        "SELECT * FROM t_guru
                                         WHERE status_aktif = 1
                                         ORDER BY nama ASC"
                                    );

                                    if ($guru) {
                                        while ($row = mysqli_fetch_assoc($guru)) {
                                            $selected = (
                                                $data_edit != null &&
                                                $data_edit['guru_id'] == $row['id']
                                            ) ? 'selected' : '';

                                            echo '<option value="' .
                                                (int)$row['id'] . '" ' .
                                                $selected . '>' .
                                                htmlspecialchars(
                                                    $row['nip'] . ' - ' . $row['nama']
                                                ) .
                                                '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <!-- STATUS -->
                            <div class="col-md-6">
                                <label class="form-label">Status</label>

                                <select name="status_aktif"
                                        class="form-select"
                                        required>

                                    <option value="1" <?php
                                        echo (
                                            $data_edit != null &&
                                            $data_edit['status_aktif'] == 1
                                        ) ? 'selected' : '';
                                    ?>>
                                        Aktif
                                    </option>

                                    <option value="0" <?php
                                        echo (
                                            $data_edit != null &&
                                            $data_edit['status_aktif'] == 0
                                        ) ? 'selected' : '';
                                    ?>>
                                        Tidak Aktif
                                    </option>

                                </select>
                            </div>

                            <!-- TANGGAL MULAI -->
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai</label>

                                <input type="date"
                                       name="tanggal_mulai"
                                       class="form-control"
                                       value="<?php
                                       echo $data_edit != null
                                           ? htmlspecialchars($data_edit['tanggal_mulai'])
                                           : '';
                                       ?>"
                                       required>
                            </div>

                            <!-- TANGGAL SELESAI -->
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai</label>

                                <input type="date"
                                       name="tanggal_selesai"
                                       class="form-control"
                                       value="<?php
                                       echo $data_edit != null
                                           ? htmlspecialchars($data_edit['tanggal_selesai'])
                                           : '';
                                       ?>"
                                       required>
                            </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <a href="wali_kelas.php"
                       class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit"
                            name="<?php echo $data_edit != null ? 'ubah' : 'tambah'; ?>"
                            class="btn btn-primary">

                        <?php
                        echo $data_edit != null
                            ? 'Simpan Perubahan'
                            : 'Simpan Wali Kelas';
                        ?>

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(
        document.getElementById('modalWaliKelas')
    ).show();
});
</script>

<?php } ?>

            <!-- TABEL DATA WALI KELAS -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Daftar Wali Kelas</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <!-- ID EXAMPLE UNTUK DATATABLES -->
                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>

                                    <?php if ($role == 'admin') { ?>
                                        <th>Aksi</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $query_daftar = mysqli_query(
                                    $koneksi,
                                    "SELECT
                                        t_wali_kelas.*,
                                        t_tahun_ajaran.nama AS nama_tahun,
                                        t_kelas.nama AS nama_kelas,
                                        t_guru.nip,
                                        t_guru.nama AS nama_guru
                                    FROM t_wali_kelas
                                    INNER JOIN t_tahun_ajaran
                                        ON t_wali_kelas.tahun_ajaran_id =
                                           t_tahun_ajaran.id
                                    INNER JOIN t_kelas
                                        ON t_wali_kelas.kelas_id = t_kelas.id
                                    INNER JOIN t_guru
                                        ON t_wali_kelas.guru_id = t_guru.id
                                    ORDER BY t_wali_kelas.id DESC"
                                );

                                $no = 1;

                                if ($query_daftar) {

                                    while ($row = mysqli_fetch_assoc($query_daftar)) {
                                ?>

                                <tr>
                                    <td><?php echo $no++; ?></td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_tahun']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_kelas']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars(
                                            $row['nip'] . ' - ' . $row['nama_guru']
                                        ); ?>
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

                                    <?php if ($role == 'admin') { ?>

                                        <td class="text-nowrap">

                                            <a href="wali_kelas.php?edit=<?php
                                                echo (int)$row['id'];
                                            ?>"
                                               class="btn btn-warning btn-sm">
                                                Ubah
                                            </a>

                                            <a href="wali_kelas.php?hapus=<?php
                                                echo (int)$row['id'];
                                            ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus data wali kelas ini?')">
                                                Hapus
                                            </a>

                                        </td>

                                    <?php } ?>

                                </tr>

                                <?php
                                    }

                                } else {

                                    echo '<tr><td colspan="' .
                                        ($role == 'admin' ? '8' : '7') .
                                        '" class="text-center text-danger">
                                        Data gagal dimuat. Periksa struktur tabel database.
                                        </td></tr>';
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
