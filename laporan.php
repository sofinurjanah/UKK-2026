
<?php
session_start();

include "config/koneksi.php";

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = strtolower($_SESSION['role']);

/* =========================
   FILTER TANGGAL
   ========================= */

$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

if (
    ($tanggal_awal !== '' &&
     !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_awal))
    ||
    ($tanggal_akhir !== '' &&
     !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_akhir))
    ||
    ($tanggal_awal !== '' &&
     $tanggal_akhir !== '' &&
     $tanggal_awal > $tanggal_akhir)
) {
    $tanggal_awal = '';
    $tanggal_akhir = '';
}

/* =========================
   QUERY LAPORAN
   ========================= */

$sql = "
    SELECT
        tps.*,
        COALESCE(tp.poin, tps.poin) AS poin_jenis
    FROM t_pelanggaran_siswa tps
    LEFT JOIN t_pelanggaran tp
        ON tp.id = tps.pelanggaran_id
    WHERE 1=1
";

$tipe = "";
$parameter = [];

if ($tanggal_awal !== '') {
    $sql .= " AND tps.tanggal >= ?";
    $tipe .= "s";
    $parameter[] = $tanggal_awal;
}

if ($tanggal_akhir !== '') {
    $sql .= " AND tps.tanggal <= ?";
    $tipe .= "s";
    $parameter[] = $tanggal_akhir;
}

$sql .= " ORDER BY tps.tanggal DESC, tps.id DESC";

$stmt_laporan = mysqli_prepare($koneksi, $sql);

if (!empty($parameter)) {
    mysqli_stmt_bind_param(
        $stmt_laporan,
        $tipe,
        ...$parameter
    );
}

mysqli_stmt_execute($stmt_laporan);

$data_laporan = mysqli_stmt_get_result($stmt_laporan);

/* =========================
   RINGKASAN
   ========================= */

$sql_ringkasan = "
    SELECT
        COUNT(*) AS jumlah_pelanggaran,
        COALESCE(SUM(COALESCE(tp.poin, tps.poin)), 0) AS total_poin,
        COUNT(DISTINCT tps.siswa_id) AS jumlah_siswa
    FROM t_pelanggaran_siswa tps
    LEFT JOIN t_pelanggaran tp
        ON tp.id = tps.pelanggaran_id
    WHERE 1=1
";

$tipe_ringkasan = "";
$parameter_ringkasan = [];

/* FILTER TANGGAL AWAL */
if ($tanggal_awal !== '') {
    $sql_ringkasan .= " AND tps.tanggal >= ?";
    $tipe_ringkasan .= "s";
    $parameter_ringkasan[] = $tanggal_awal;
}

/* FILTER TANGGAL AKHIR */
if ($tanggal_akhir !== '') {
    $sql_ringkasan .= " AND tps.tanggal <= ?";
    $tipe_ringkasan .= "s";
    $parameter_ringkasan[] = $tanggal_akhir;
}

$stmt_ringkasan = mysqli_prepare(
    $koneksi,
    $sql_ringkasan
);

/* BIND PARAMETER */
if (!empty($parameter_ringkasan)) {
    mysqli_stmt_bind_param(
        $stmt_ringkasan,
        $tipe_ringkasan,
        ...$parameter_ringkasan
    );
}

mysqli_stmt_execute($stmt_ringkasan);

$hasil_ringkasan = mysqli_stmt_get_result($stmt_ringkasan);

$ringkasan = mysqli_fetch_assoc($hasil_ringkasan);

$total_pelanggaran = (int) $ringkasan['jumlah_pelanggaran'];
$total_poin = (int) $ringkasan['total_poin'];
$total_siswa = (int) $ringkasan['jumlah_siswa'];

/* =========================
   DATA UNTUK CETAK DAN EXPORT
   ========================= */

$data_cetak = [];

mysqli_data_seek($data_laporan, 0);

while ($row = mysqli_fetch_assoc($data_laporan)) {
    $data_cetak[] = $row;
}

mysqli_data_seek($data_laporan, 0);

$json_cetak = json_encode(
    $data_cetak,
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_QUOT |
    JSON_HEX_AMP
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

</head>

<body>

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
                           class="nav-link text-white">
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
                           class="nav-link active">
                            Laporan
                        </a>
                    </li>

                <?php } ?>

                <?php if ($role == 'guru') { ?>

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

        </aside>


        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="fw-bold mb-4">
                Laporan Pelanggaran
            </h3>


            <!-- RINGKASAN -->
            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">

                            <p class="text-secondary mb-2">
                                Total Pelanggaran
                            </p>

                            <h3 class="fw-bold text-primary mb-0">
                                <?= $total_pelanggaran; ?>
                            </h3>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">

                            <p class="text-secondary mb-2">
                                Siswa Terlibat
                            </p>

                            <h3 class="fw-bold text-primary mb-0">
                                <?= $total_siswa; ?>
                            </h3>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">

                            <p class="text-secondary mb-2">
                                Total Poin Pelanggaran
                            </p>

                            <h3 class="fw-bold text-primary mb-0">
                                <?= $total_poin; ?>
                            </h3>

                        </div>
                    </div>
                </div>

            </div>


            <!-- DAFTAR LAPORAN -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Daftar Laporan Pelanggaran
                    </h5>

                </div>

                <div class="card-body">


                    <!-- FILTER TANGGAL DAN PENCARIAN NAMA -->
                    <form method="GET" class="mb-4 filter-laporan">

                        <div class="row g-3 align-items-end">

                            <!-- TANGGAL AWAL -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    Tanggal Awal
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_awal"
                                    class="form-control"
                                    value="<?= htmlspecialchars($tanggal_awal); ?>">

                            </div>

                            <!-- TANGGAL AKHIR -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    Tanggal Akhir
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_akhir"
                                    class="form-control"
                                    value="<?= htmlspecialchars($tanggal_akhir); ?>">

                            </div>

                            <!-- CARI NAMA SISWA -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    Cari Nama Siswa
                                </label>

                                <input
                                    type="search"
                                    id="cariNamaLaporan"
                                    class="form-control"
                                    placeholder="Masukkan nama siswa...">

                            </div>

                            <!-- TOMBOL -->
                            <div class="col-md-3 d-flex gap-2">

                                <button type="submit" class="btn btn-primary">
                                    Tampilkan
                                </button>

                                <a href="laporan.php" class="btn btn-secondary">
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>


                    <!-- TOMBOL CETAK DAN EXPORT -->
                    <div class="d-flex justify-content-end gap-2 mb-3">

                        <button
                            type="button"
                            onclick="cetakLaporan()"
                            class="btn btn-success">

                            Cetak Laporan

                        </button>

                        <button
                            type="button"
                            onclick="exportExcel()"
                            class="btn btn-primary">

                            <i class="bi bi-file-earmark-excel"></i>
                            Export Excel

                        </button>

                    </div>


                    <!-- TABEL -->
                    <div class="table-responsive">

                        <table
                            id="tabelLaporan"
                            class="table table-bordered table-striped table-hover align-middle">

                            <thead class="table-primary">

                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Guru</th>
                                    <th>Status</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $no = 1;

                                if (mysqli_num_rows($data_laporan) > 0) {

                                    while ($row = mysqli_fetch_assoc($data_laporan)) {
                                ?>

                                    <tr>

                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars($row['tanggal']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_siswa']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_kelas']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_pelanggaran']); ?>
                                        </td>

                                        <td class="text-center fw-bold">
                                            <?= (int) $row['poin_jenis']; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_guru']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['status']); ?>
                                        </td>

                                    </tr>

                                <?php
                                    }

                                } else {
                                ?>

                                    <tr>
                                        <td colspan="8" class="text-center">
                                            Belum ada data pelanggaran pada periode ini.
                                        </td>
                                    </tr>

                                <?php } ?>

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


<script>

function cetakLaporan() {

    let data = <?= $json_cetak ?: '[]'; ?>;

    if (data.length === 0) {
        alert("Belum ada data untuk dicetak.");
        return;
    }

    let halaman = window.open("", "_blank", "width=900,height=800");

    if (!halaman) {
        alert("Izinkan pop-up pada browser untuk mencetak.");
        return;
    }

    let totalPoin = 0;
    let isiTabel = "";

    data.forEach(function(row, index) {

        let poin = parseInt(row.poin_jenis) || 0;
        totalPoin += poin;

        isiTabel += `
            <tr>
                <td>${index + 1}</td>
                <td>${row.tanggal ?? ''}</td>
                <td>${row.nama_siswa ?? ''}</td>
                <td>${row.nama_kelas ?? ''}</td>
                <td>${row.nama_pelanggaran ?? ''}</td>
                <td>${poin}</td>
                <td>${row.nama_guru ?? ''}</td>
                <td>${row.status ?? ''}</td>
            </tr>
        `;
    });

    halaman.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Laporan Pelanggaran Siswa</title>

            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 25px;
                    color: #26374a;
                }

                h2, p {
                    text-align: center;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    font-size: 11px;
                }

                th, td {
                    border: 1px solid #999;
                    padding: 8px 5px;
                    text-align: center;
                }

                th {
                    background: #eaf1f8;
                }

                .total {
                    text-align: right;
                    font-weight: bold;
                    margin-top: 15px;
                }

                @media print {
                    body {
                        margin: 10mm;
                    }
                }
            </style>
        </head>

        <body>

            <h2>LAPORAN PELANGGARAN SISWA</h2>
            <p>SISTEM INFORMASI MANAJEMEN PELANGGARAN SISWA MUHAMMADIYAH</p>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Pelanggaran</th>
                        <th>Poin</th>
                        <th>Guru</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    ${isiTabel}
                </tbody>
            </table>

            <p class="total">TOTAL POIN: ${totalPoin}</p>

            <script>
                window.onload = function() {
                    window.print();
                };
            <\/script>

        </body>
        </html>
    `);

    halaman.document.close();
}


function exportExcel() {

    let table = document.getElementById("tabelLaporan");

    if (!table || table.querySelectorAll("tbody tr").length === 0) {
        alert("Belum ada data untuk diexport.");
        return;
    }

    let workbook = XLSX.utils.table_to_book(table, {
        sheet: "Laporan Pelanggaran"
    });

    XLSX.writeFile(
        workbook,
        "Laporan_Pelanggaran.xlsx"
    );

}


/* =========================
   PENCARIAN NAMA SISWA
   ========================= */

document.addEventListener('DOMContentLoaded', function () {

    const inputCari = document.getElementById('cariNamaLaporan');
    const tabel = document.getElementById('tabelLaporan');

    if (!inputCari || !tabel) {
        return;
    }

    const tbody = tabel.querySelector('tbody');

    const semuaBaris = Array.from(
        tbody.querySelectorAll('tr')
    ).filter(function(row) {
        return row.cells.length === 8;
    });

    const barisTidakDitemukan = document.createElement('tr');

    barisTidakDitemukan.innerHTML = `
        <td colspan="8" class="text-center text-danger py-3">
            Nama siswa tidak ditemukan.
        </td>
    `;

    barisTidakDitemukan.style.display = 'none';

    tbody.appendChild(barisTidakDitemukan);

    inputCari.addEventListener('input', function () {

        const kataKunci = this.value.trim().toLowerCase();

        let jumlahCocok = 0;

        semuaBaris.forEach(function(row) {

            const namaSiswa = row.cells[2].textContent
                .trim()
                .toLowerCase();

            if (namaSiswa.includes(kataKunci)) {

                row.style.display = '';
                jumlahCocok++;

            } else {

                row.style.display = 'none';

            }

        });

        barisTidakDitemukan.style.display =
            kataKunci !== '' &&
            jumlahCocok === 0 &&
            semuaBaris.length > 0
                ? ''
                : 'none';

    });

});

</script>


<style>

.filter-laporan .form-control {
    height: 42px;
}

.filter-laporan .btn {
    height: 42px;
    white-space: nowrap;
}

@media print {

    aside,
    form,
    .btn,
    .card-header {
        display: none !important;
    }

    main {
        width: 100% !important;
        padding: 10px !important;
    }

    body {
        background: white !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

}

</style>

</body>
</html>
