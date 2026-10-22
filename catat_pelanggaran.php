<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

// SIMPAN PELANGGARAN
if (isset($_POST['simpan'])) {

    // Ambil dan validasi input form
    $siswa_id = (int) ($_POST['siswa_id'] ?? 0);
    $pelanggaran_id = (int) ($_POST['pelanggaran_id'] ?? 0);
    $tanggal = trim($_POST['tanggal'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');
    $tindakan = trim($_POST['tindakan'] ?? '');
    $status = trim($_POST['status'] ?? '');

    // Ambil data siswa beserta kelas dan tahun ajaran aktifnya
    $stmt_siswa = mysqli_prepare($koneksi, "
        SELECT
            s.nama AS nama_siswa,
            k.id AS kelas_id,
            k.nama AS nama_kelas,
            ks.tahun_ajaran_id
        FROM t_siswa AS s
        INNER JOIN t_kelas_siswa AS ks ON s.id = ks.siswa_id
        INNER JOIN t_kelas AS k ON ks.kelas_id = k.id
        WHERE s.id = ?
          AND s.status_aktif = 1
          AND ks.status_aktif = 1
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmt_siswa, "i", $siswa_id);
    mysqli_stmt_execute($stmt_siswa);
    $result_siswa = mysqli_stmt_get_result($stmt_siswa);
    $data_siswa = mysqli_fetch_assoc($result_siswa);
    mysqli_stmt_close($stmt_siswa);

    // Ambil data pelanggaran beserta kategori
    $stmt_pelanggaran = mysqli_prepare($koneksi, "
        SELECT nama, poin, pelanggaran_kategori_id
        FROM t_pelanggaran
        WHERE id = ? AND status_aktif = 1
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmt_pelanggaran, "i", $pelanggaran_id);
    mysqli_stmt_execute($stmt_pelanggaran);
    $result_pelanggaran = mysqli_stmt_get_result($stmt_pelanggaran);
    $data_pelanggaran = mysqli_fetch_assoc($result_pelanggaran);
    mysqli_stmt_close($stmt_pelanggaran);

    if (!$data_siswa || !$data_pelanggaran) {
        echo "<script>alert('Data siswa atau pelanggaran tidak ditemukan / tidak aktif.');</script>";
    } elseif ($tanggal === '' || $status === '') {
        echo "<script>alert('Tanggal dan status wajib diisi.');</script>";
    } else {

        $tahun_ajaran_id = (int) $data_siswa['tahun_ajaran_id'];
        $nama_siswa = $data_siswa['nama_siswa'];
        $kelas_id = (int) $data_siswa['kelas_id'];
        $nama_kelas = $data_siswa['nama_kelas'];
        $nama_pelanggaran = $data_pelanggaran['nama'];
        $pelanggaran_kategori_id = (int) $data_pelanggaran['pelanggaran_kategori_id'];
        $poin = (int) $data_pelanggaran['poin'];

        // Ambil data guru berdasarkan akun yang sedang login
        $user_id = (int) ($_SESSION['id_user'] ?? 0);
        $stmt_guru = mysqli_prepare($koneksi, "
            SELECT id, nama
            FROM t_guru
            WHERE user_id = ?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmt_guru, "i", $user_id);
        mysqli_stmt_execute($stmt_guru);
        $result_guru = mysqli_stmt_get_result($stmt_guru);
        $data_guru = mysqli_fetch_assoc($result_guru);
        mysqli_stmt_close($stmt_guru);

        if (!$data_guru) {
            echo "<script>alert('Data guru untuk akun yang login tidak ditemukan.');</script>";
        } else {
            $guru_id = (int) $data_guru['id'];
            $nama_guru = $data_guru['nama'];

            // Simpan semua kolom wajib, termasuk foreign key tahun ajaran,
            // kelas, dan kategori pelanggaran.
            $stmt_insert = mysqli_prepare($koneksi, "
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
                $stmt_insert,
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

            if (mysqli_stmt_execute($stmt_insert)) {
                mysqli_stmt_close($stmt_insert);
                echo "<script>
                    alert('Pelanggaran berhasil dicatat');
                    window.location='catat_pelanggaran.php';
                </script>";
                exit;
            } else {
                $pesan_error = mysqli_stmt_error($stmt_insert);
                mysqli_stmt_close($stmt_insert);
                echo "Gagal menyimpan pelanggaran: " . htmlspecialchars($pesan_error);
            }
        }
    }
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

   <!-- TOMBOL BUKA FORM -->
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="collapse"
                    data-bs-target="#formPelanggaran"
                    aria-expanded="false"
                    aria-controls="formPelanggaran">
                    + Tambah Pelanggaran
                </button>
            </div>

            <!-- FORM TAMBAH PELANGGARAN -->
            <div class="collapse mb-4" id="formPelanggaran">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            Form Tambah Pelanggaran
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        <form method="POST">

                            <!-- SISWA -->
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>

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
    <label class="form-label">Jenis Pelanggaran</label>

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


<!-- TANGGAL PELANGGARAN -->
<div class="mb-3">
    <label class="form-label">Tanggal Pelanggaran</label>
    <input
        type="date"
        name="tanggal"
        class="form-control"
        required
    >
</div>

<!-- STATUS PELANGGARAN -->
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="">-- Pilih Status --</option>
        <option value="Pembinaan">Pembinaan</option>
        <option value="Ditindaklanjuti">Ditindaklanjuti</option>
        <option value="Selesai">Selesai</option>
    </select>
</div>


                            <button type="submit" name="simpan" class="btn btn-primary">
                                Simpan Pelanggaran
                            </button>

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-toggle="collapse"
                                data-bs-target="#formPelanggaran">
                                Batal
                            </button>

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
                                    ORDER BY tanggal DESC
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

                                } ?>
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

</body>
</html>
