<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

$pesan = '';
$tipe_pesan = '';
$buka_modal = false;

if (isset($_POST['simpan'])) {

    $buka_modal = true;

    try {

        $siswa_id = (int) ($_POST['siswa_id'] ?? 0);
        $pelanggaran_id = (int) ($_POST['pelanggaran_id'] ?? 0);
        $guru_id = (int) ($_POST['guru_id'] ?? 0);
        $tanggal = trim($_POST['tanggal'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');
        $tindakan = trim($_POST['tindakan'] ?? '');
        $status = trim($_POST['status'] ?? '');

        if (
            $siswa_id <= 0 ||
            $pelanggaran_id <= 0 ||
            $guru_id <= 0 ||
            $tanggal == '' ||
            $status == ''
        ) {
            throw new Exception("Semua data wajib diisi dengan benar.");
        }

        // DATA SISWA
        $stmt = mysqli_prepare($koneksi, "
            SELECT s.nama AS nama_siswa,
                   k.id AS kelas_id,
                   k.nama AS nama_kelas,
                   ks.tahun_ajaran_id
            FROM t_siswa s
            INNER JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
            INNER JOIN t_kelas k ON ks.kelas_id = k.id
            WHERE s.id = ?
              AND s.status_aktif = 1
              AND ks.status_aktif = 1
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "i", $siswa_id);
        mysqli_stmt_execute($stmt);

        $data_siswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if (!$data_siswa) {
            throw new Exception("Data siswa tidak ditemukan atau belum memiliki penempatan aktif.");
        }

        // DATA PELANGGARAN
        $stmt = mysqli_prepare($koneksi, "
            SELECT nama, poin, pelanggaran_kategori_id
            FROM t_pelanggaran
            WHERE id = ?
              AND status_aktif = 1
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "i", $pelanggaran_id);
        mysqli_stmt_execute($stmt);

        $data_pelanggaran = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if (!$data_pelanggaran) {
            throw new Exception("Jenis pelanggaran tidak ditemukan atau tidak aktif.");
        }

        // DATA GURU BERDASARKAN PILIHAN FORM
        $stmt = mysqli_prepare($koneksi, "
            SELECT id, nama
            FROM t_guru
            WHERE id = ?
              AND status_aktif = 1
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "i", $guru_id);
        mysqli_stmt_execute($stmt);

        $data_guru = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if (!$data_guru) {
            throw new Exception("Data guru tidak ditemukan atau sudah tidak aktif.");
        }

        // AMBIL DATA LENGKAP
        $tahun_ajaran_id = (int) $data_siswa['tahun_ajaran_id'];
        $nama_siswa = $data_siswa['nama_siswa'];
        $kelas_id = (int) $data_siswa['kelas_id'];
        $nama_kelas = $data_siswa['nama_kelas'];

        $nama_pelanggaran = $data_pelanggaran['nama'];
        $pelanggaran_kategori_id = (int) $data_pelanggaran['pelanggaran_kategori_id'];
        $poin = (int) $data_pelanggaran['poin'];

        $guru_id = (int) $data_guru['id'];
        $nama_guru = $data_guru['nama'];

        // SIMPAN KE DATABASE
        $stmt = mysqli_prepare($koneksi, "
            INSERT INTO t_pelanggaran_siswa (
                tahun_ajaran_id,
                siswa_id,
                nama_siswa,
                kelas_id,
                nama_kelas,
                pelanggaran_id,
                nama_pelanggaran,
                pelanggaran_kategori_id,
                guru_id,
                nama_guru,
                tanggal,
                keterangan,
                poin,
                tindakan,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        mysqli_stmt_bind_param(
            $stmt,
            "iisisisiisssiss",
            $tahun_ajaran_id,
            $siswa_id,
            $nama_siswa,
            $kelas_id,
            $nama_kelas,
            $pelanggaran_id,
            $nama_pelanggaran,
            $pelanggaran_kategori_id,
            $guru_id,
            $nama_guru,
            $tanggal,
            $keterangan,
            $poin,
            $tindakan,
            $status
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['pesan_sukses'] = "Pelanggaran berhasil dicatat.";

        header("Location: catat_pelanggaran.php");
        exit;

    } catch (Throwable $e) {

        $pesan = "Gagal menyimpan pelanggaran: " . $e->getMessage();
        $tipe_pesan = "danger";

    }
}

// NOTIFIKASI BERHASIL
if (isset($_SESSION['pesan_sukses'])) {

    $pesan = $_SESSION['pesan_sukses'];
    $tipe_pesan = "success";

    unset($_SESSION['pesan_sukses']);
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Pelanggaran</title>

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
        <aside class="col-md-3 col-lg-2 min-vh-100 p-3"
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
                        <a href="catat_pelanggaran.php" class="nav-link active">
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

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

                <div>
                    <h2 class="fw-bold mb-1">
                        Catat Pelanggaran Siswa
                    </h2>
                </div>

                <!-- NOTIFIKASI -->
                <?php if ($pesan != '') { ?>
                    <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show">
                        <?php echo htmlspecialchars($pesan); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php } ?>

                <!-- TOMBOL BUKA FORM -->
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPelanggaran">
                    Tambah Pelanggaran
                </button>

            </div>

            <!-- MODAL TAMBAH PELANGGARAN -->
            <div class="modal fade" id="modalPelanggaran" tabindex="-1" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">
                                Form Tambah Pelanggaran
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>
                        </div>

                        <form method="POST">

                            <div class="modal-body p-4">

                                <!-- GURU PENCATAT -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Guru Pencatat
                                    </label>

                                    <select name="guru_id" class="form-select" required>
                                        <option value="">-- Pilih Guru Pencatat --</option>

                                        <?php
                                        $query_guru = mysqli_query($koneksi, "
                                            SELECT id, nama
                                            FROM t_guru
                                            WHERE status_aktif = 1
                                            ORDER BY nama ASC
                                        ");

                                        while ($row = mysqli_fetch_assoc($query_guru)) {
                                        ?>
                                            <option value="<?php echo (int) $row['id']; ?>">
                                                <?php echo htmlspecialchars($row['nama']); ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <!-- SISWA -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Siswa
                                    </label>

                                    <select name="siswa_id" class="form-select" required>
                                        <option value="">-- Pilih Siswa --</option>

                                        <?php
                                        $query_siswa = mysqli_query($koneksi, "
                                            SELECT
                                                t_siswa.id,
                                                t_siswa.nis,
                                                t_siswa.nama,
                                                t_kelas.nama AS nama_kelas
                                            FROM t_siswa
                                            LEFT JOIN t_kelas_siswa
                                                ON t_siswa.id = t_kelas_siswa.siswa_id
                                            LEFT JOIN t_kelas
                                                ON t_kelas_siswa.kelas_id = t_kelas.id
                                            WHERE t_siswa.status_aktif = 1
                                              AND t_kelas_siswa.status_aktif = 1
                                            ORDER BY t_siswa.nama ASC
                                        ");

                                        while ($row = mysqli_fetch_assoc($query_siswa)) {
                                        ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php
                                                echo htmlspecialchars(
                                                    $row['nis'] . " - " . $row['nama']
                                                );

                                                if ($row['nama_kelas'] != "") {
                                                    echo " (" . htmlspecialchars($row['nama_kelas']) . ")";
                                                }
                                                ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <!-- JENIS PELANGGARAN -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Jenis Pelanggaran
                                    </label>

                                    <select name="pelanggaran_id" class="form-select" required>
                                        <option value="">-- Pilih Pelanggaran --</option>

                                        <?php
                                        $query_pelanggaran = mysqli_query($koneksi, "
                                            SELECT
                                                t_pelanggaran.id,
                                                t_pelanggaran.kode,
                                                t_pelanggaran.nama,
                                                t_pelanggaran.poin,
                                                t_pelanggaran_kategori.nama AS nama_kategori
                                            FROM t_pelanggaran
                                            INNER JOIN t_pelanggaran_kategori
                                                ON t_pelanggaran.pelanggaran_kategori_id =
                                                   t_pelanggaran_kategori.id
                                            WHERE t_pelanggaran.status_aktif = 1
                                            ORDER BY t_pelanggaran.nama ASC
                                        ");

                                        if (!$query_pelanggaran) {
                                            die("Query pelanggaran gagal: " .
                                                htmlspecialchars(mysqli_error($koneksi)));
                                        }

                                        while ($row = mysqli_fetch_assoc($query_pelanggaran)) {
                                        ?>
                                            <option value="<?= (int) $row['id']; ?>">
                                                <?= htmlspecialchars(
                                                    $row['kode'] . " - " .
                                                    $row['nama'] . " - " .
                                                    $row['poin'] . " poin"
                                                ); ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <!-- TANGGAL -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Tanggal Pelanggaran
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal"
                                        class="form-control"
                                        required>
                                </div>

                                <!-- STATUS -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Pembinaan">Pembinaan</option>
                                        <option value="Ditindaklanjuti">Ditindaklanjuti</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
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
                                    name="simpan"
                                    class="btn btn-primary">
                                    Simpan
                                </button>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- DATA PELANGGARAN TERBARU -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Data Pelanggaran Terbaru</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example"
                               class="table table-bordered table-striped table-hover align-middle mb-0">

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Guru</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $query_data = mysqli_query($koneksi, "
                                    SELECT *
                                    FROM t_pelanggaran_siswa
                                    ORDER BY id DESC
                                ");

                                $no = 1;

                                if ($query_data && mysqli_num_rows($query_data) > 0) {

                                    while ($row = mysqli_fetch_assoc($query_data)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_pelanggaran']); ?></td>
                                        <td><?php echo htmlspecialchars($row['poin']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
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
        <!-- AKHIR KONTEN UTAMA -->

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

<?php if ($buka_modal) { ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(
            document.getElementById('modalPelanggaran')
        );

        modal.show();
    });
</script>
<?php } ?>

</body>
</html>