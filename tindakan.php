
<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

// =====================================
// SIMPAN TINDAKAN
// =====================================

if (isset($_POST['simpan'])) {

    $id = $_POST['id'];
    $tindakan = $_POST['tindakan'];
    $status = $_POST['status'];

    $query = mysqli_query($koneksi, "
        UPDATE t_pelanggaran_siswa
        SET
            tindakan = '$tindakan',
            status = '$status'
        WHERE id = '$id'
    ");

    if ($query) {

        echo "<script>
                alert('Tindakan berhasil disimpan');
                window.location='tindakan.php';
              </script>";

    } else {

        echo "Gagal menyimpan tindakan: "
             . mysqli_error($koneksi);

    }
}

// =====================================
// DATA UNTUK EDIT TINDAKAN
// =====================================

$data_edit = null;

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "
        SELECT *
        FROM t_pelanggaran_siswa
        WHERE id = '$id'
    ");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tindakan Pelanggaran</title>

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
        <aside
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
                        <a href="tindakan.php" class="nav-link active">
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

            <!-- JUDUL HALAMAN -->
            <div class="mb-4">
                <h2 class="fw-bold mb-1">
                    Tindakan Pelanggaran Siswa
                </h2>
            </div>

            <?php if ($data_edit != null) { ?>

                <!-- FORM EDIT TINDAKAN -->
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            Berikan Tindakan
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        <form method="POST">

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo $data_edit['id']; ?>"
                            >

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Siswa
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?php echo $data_edit['nama_siswa']; ?>"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Kelas
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?php echo $data_edit['nama_kelas']; ?>"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Pelanggaran
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?php echo $data_edit['nama_pelanggaran']; ?>"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Poin
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?php echo $data_edit['poin']; ?>"
                                        readonly
                                    >
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Keterangan
                                    </label>

                                    <textarea
                                        class="form-control"
                                        rows="3"
                                        readonly
                                    ><?php echo $data_edit['keterangan']; ?></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Tindakan
                                    </label>

                                    <textarea
                                        name="tindakan"
                                        class="form-control"
                                        rows="5"
                                        placeholder="Masukkan tindakan yang diberikan"
                                        required
                                    ><?php echo $data_edit['tindakan']; ?></textarea>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select
                                        name="status"
                                        class="form-select"
                                        required
                                    >

                                        <option
                                            value="Teguran"
                                            <?php
                                            if ($data_edit['status'] == "Teguran") {
                                                echo "selected";
                                            }
                                            ?>
                                        >
                                            Teguran
                                        </option>

                                        <option
                                            value="Pembinaan"
                                            <?php
                                            if ($data_edit['status'] == "Pembinaan") {
                                                echo "selected";
                                            }
                                            ?>
                                        >
                                            Pembinaan
                                        </option>

                                        <option
                                            value="Dipantau"
                                            <?php
                                            if ($data_edit['status'] == "Dipantau") {
                                                echo "selected";
                                            }
                                            ?>
                                        >
                                            Dipantau
                                        </option>

                                        <option
                                            value="Ditindaklanjuti"
                                            <?php
                                            if ($data_edit['status'] == "Ditindaklanjuti") {
                                                echo "selected";
                                            }
                                            ?>
                                        >
                                            Ditindaklanjuti
                                        </option>

                                        <option
                                            value="Selesai"
                                            <?php
                                            if ($data_edit['status'] == "Selesai") {
                                                echo "selected";
                                            }
                                            ?>
                                        >
                                            Selesai
                                        </option>

                                    </select>
                                </div>

                            </div>

                            <button
                                type="submit"
                                name="simpan"
                                class="btn btn-primary"
                            >
                                Simpan Tindakan
                            </button>

                            <a
                                href="tindakan.php"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>

                        </form>

                    </div>
                </div>

            <?php } ?>

            <!-- TABEL DAFTAR PELANGGARAN -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        Daftar Pelanggaran
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                        id="example"
                        class="table table-bordered table-hover align-middle"
                        >

                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Keterangan</th>
                                    <th>Tindakan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php

                                $query = mysqli_query($koneksi, "
                                    SELECT *
                                    FROM t_pelanggaran_siswa
                                    ORDER BY tanggal DESC
                                ");

                                $no = 1;

                                while ($row = mysqli_fetch_assoc($query)) {

                                ?>

                                    <tr>

                                        <td>
                                            <?php echo $no; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['tanggal']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['nama_siswa']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['nama_kelas']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['nama_pelanggaran']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['poin']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['keterangan']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['tindakan']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['status']; ?>
                                        </td>

                                        <td>
                                            <a
                                                href="tindakan.php?edit=<?php echo $row['id']; ?>"
                                                class="btn btn-sm btn-primary"
                                            >
                                                Beri Tindakan
                                            </a>
                                        </td>

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
