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
   DATA SISWA UNTUK PILIHAN
   ========================= */

$data_siswa = mysqli_query(
    $koneksi,
    "SELECT DISTINCT siswa_id, nama_siswa
     FROM t_pelanggaran_siswa
     ORDER BY nama_siswa ASC"
);


/* =========================
   PILIHAN SISWA
   ========================= */

$siswa_id = isset($_GET['siswa_id']) ? $_GET['siswa_id'] : '';

$data_laporan = null;

if ($siswa_id != '') {

    $data_laporan = mysqli_query(
        $koneksi,
        "SELECT *
         FROM t_pelanggaran_siswa
         WHERE siswa_id = '$siswa_id'
         ORDER BY tanggal DESC"
    );
}


/* =========================
   DATA UNTUK CETAK
   ========================= */

$data_cetak = [];

if ($siswa_id != '') {

    $query_cetak = mysqli_query(
        $koneksi,
        "SELECT *
         FROM t_pelanggaran_siswa
         WHERE siswa_id = '$siswa_id'
         ORDER BY tanggal ASC"
    );

    while ($row_cetak = mysqli_fetch_assoc($query_cetak)) {
        $data_cetak[] = $row_cetak;
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Laporan Pelanggaran</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

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

        <!-- LOGOUT -->
        <li class="nav-item">
            <a href="logout.php"
               class="nav-link text-danger">
                Logout
            </a>
        </li>
            </ul>

        </div>


        <!-- KONTEN -->

        <main class="col-md-9 col-lg-10 p-4">

            <h2>Laporan Pelanggaran</h2>

            <p>
                Pilih siswa untuk melihat laporan pelanggarannya.
            </p>


            <!-- PILIH SISWA -->

            <form method="GET">

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">
                            Pilih Siswa
                        </label>

                        <select
                            name="siswa_id"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Siswa --
                            </option>


                            <?php while ($siswa = mysqli_fetch_assoc($data_siswa)) { ?>

                                <option
                                    value="<?= $siswa['siswa_id']; ?>"
                                    <?= ($siswa_id == $siswa['siswa_id']) ? 'selected' : ''; ?>>

                                    <?= htmlspecialchars($siswa['nama_siswa']); ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            &nbsp;
                        </label>

                        <br>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Tampilkan Laporan

                        </button>

                    </div>

                </div>

            </form>


            <br>


            <?php if ($data_laporan != null) { ?>

                <?php

                $data_pertama = mysqli_fetch_assoc($data_laporan);

                if ($data_pertama) {

                ?>

                    <!-- INFORMASI SISWA -->

                    <div class="card">

                        <div class="card-body">

                            <h4>
                                <?= htmlspecialchars($data_pertama['nama_siswa']); ?>
                            </h4>

                            <p class="mb-1">

                                Kelas :
                                <b>
                                    <?= htmlspecialchars($data_pertama['nama_kelas']); ?>
                                </b>

                            </p>

                            <p class="mb-0">

                                Total Poin :

                                <b>

                                    <?php

                                    $total_poin = $data_pertama['poin'];

                                    ?>

                                    <?= $total_poin; ?>

                                </b>

                            </p>

                        </div>

                    </div>


                    <br>


                    <!-- RIWAYAT PELANGGARAN -->

                    <h5>
                        Riwayat Pelanggaran
                    </h5>


                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Pelanggaran</th>

                                <th>Tanggal</th>

                                <th>Poin</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            $no = 1;

                            $total_poin = $data_pertama['poin'];

                            ?>

                            <tr>

                                <td>
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data_pertama['nama_pelanggaran']); ?>
                                </td>

                                <td>
                                    <?= $data_pertama['tanggal']; ?>
                                </td>

                                <td>
                                    <?= $data_pertama['poin']; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data_pertama['status']); ?>
                                </td>

                            </tr>


                            <?php while ($row = mysqli_fetch_assoc($data_laporan)) { ?>

                                <?php
                                $total_poin += $row['poin'];
                                ?>

                                <tr>

                                    <td>
                                        <?= $no++; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_pelanggaran']); ?>
                                    </td>

                                    <td>
                                        <?= $row['tanggal']; ?>
                                    </td>

                                    <td>
                                        <?= $row['poin']; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['status']); ?>
                                    </td>

                                </tr>

                            <?php } ?>


                            <tr>

                                <td colspan="3">

                                    <b>
                                        TOTAL POIN
                                    </b>

                                </td>

                                <td colspan="2">

                                    <b>
                                        <?= $total_poin; ?>
                                    </b>

                                </td>

                            </tr>

                        </tbody>

                    </table>


                    <br>


                    <!-- TOMBOL -->

                    <button
                        onclick="cetakLaporan()"
                        class="btn btn-primary">

                        Cetak

                    </button>


                    <button
                        onclick="exportCSV()"
                        class="btn btn-success">

                        Export

                    </button>


                <?php } ?>

            <?php } ?>

        </main>

    </div>

</div>


<script>

function cetakLaporan() {

    let data = <?= json_encode($data_cetak ?? []); ?>;

    if (data.length === 0) {
        alert("Pilih siswa terlebih dahulu.");
        return;
    }

    let siswa = data[0];

    let halaman = window.open(
        "",
        "_blank",
        "width=700,height=800"
    );

    let totalPoin = 0;

    data.forEach(function(row) {
        totalPoin += parseInt(row.poin) || 0;
    });

    let isiTabel = "";

    data.forEach(function(row, index) {

        isiTabel += `

            <tr>

                <td align="center">
                    ${index + 1}
                </td>

                <td align="center">
                    ${row.tanggal}
                </td>

                <td>
                    ${row.nama_pelanggaran}
                </td>

                <td align="center">
                    ${row.poin}
                </td>

                <td align="center">
                    ${row.status}
                </td>

            </tr>

        `;
    });


    halaman.document.write(`

        <!DOCTYPE html>

        <html>

        <head>

            <title>Kartu Pelanggaran Siswa</title>

        </head>


        <body>

            <table
                width="92%"
                align="center"
                cellpadding="0"
                cellspacing="0">

                <!-- JUDUL -->

                <tr>

                    <td align="center">

                        <font face="Arial" size="4">

                            <b>
                                KARTU PELANGGARAN SISWA
                            </b>

                        </font>

                        <br>

                        <font face="Arial" size="2">

                            SISTEM PELANGGARAN SISWA

                        </font>

                        <br>

                        <font face="Arial" size="2">

                            TAHUN PELAJARAN 2026-2027

                        </font>

                        <br><br><br>

                    </td>

                </tr>


                <!-- DATA SISWA -->

                <tr>

                    <td>

                        <table
                            width="100%"
                            cellpadding="3"
                            cellspacing="0">

                            <tr>

                                <td width="18%">
                                    <font face="Arial" size="2">
                                        <b>NAMA</b>
                                    </font>
                                </td>

                                <td width="5%">
                                    <font face="Arial" size="2">
                                        :
                                    </font>
                                </td>

                                <td>
                                    <font face="Arial" size="2">
                                        ${siswa.nama_siswa}
                                    </font>
                                </td>

                            </tr>


                            <tr>

                                <td>
                                    <font face="Arial" size="2">
                                        <b>KELAS</b>
                                    </font>
                                </td>

                                <td>
                                    <font face="Arial" size="2">
                                        :
                                    </font>
                                </td>

                                <td>
                                    <font face="Arial" size="2">
                                        ${siswa.nama_kelas}
                                    </font>
                                </td>

                            </tr>


                            <tr>

                                <td>
                                    <font face="Arial" size="2">
                                        <b>GURU</b>
                                    </font>
                                </td>

                                <td>
                                    <font face="Arial" size="2">
                                        :
                                    </font>
                                </td>

                                <td>
                                    <font face="Arial" size="2">
                                        ${siswa.nama_guru}
                                    </font>
                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>


                <!-- TABEL PELANGGARAN -->

                <tr>

                    <td>

                        <br><br>

                        <table
                            width="100%"
                            border="1"
                            cellpadding="6"
                            cellspacing="0">

                            <tr>

                                <th width="7%">
                                    <font face="Arial" size="2">
                                        No
                                    </font>
                                </th>

                                <th width="21%">
                                    <font face="Arial" size="2">
                                        TANGGAL
                                    </font>
                                </th>

                                <th width="43%">
                                    <font face="Arial" size="2">
                                        JENIS PELANGGARAN
                                    </font>
                                </th>

                                <th width="10%">
                                    <font face="Arial" size="2">
                                        POIN
                                    </font>
                                </th>

                                <th width="19%">
                                    <font face="Arial" size="2">
                                        STATUS
                                    </font>
                                </th>

                            </tr>

                            ${isiTabel}

                        </table>

                    </td>

                </tr>


                <!-- TOTAL POIN -->

                <tr>

                    <td align="right">

                        <br>

                        <font face="Arial" size="2">

                            <b>
                                TOTAL POIN : ${totalPoin}
                            </b>

                        </font>

                    </td>

                </tr>


                <!-- TANDA TANGAN -->

                <tr>

                    <td>

                        <br><br><br><br><br>

                        <table
                            width="100%"
                            cellpadding="3"
                            cellspacing="0">

                            <tr>

                                <td align="center">

                                    <font face="Arial" size="2">

                                        <b>
                                            Orang Tua / Wali Murid
                                        </b>

                                    </font>

                                </td>


                                <td align="center">

                                    <font face="Arial" size="2">

                                        <b>
                                            Wali Kelas
                                        </b>

                                    </font>

                                </td>

                            </tr>


                            <tr>

                                <td align="center">

                                    <br><br><br><br>

                                    <font face="Arial" size="2">

                                        (................................)

                                    </font>

                                </td>


                                <td align="center">

                                    <br><br><br><br>

                                    <font face="Arial" size="2">

                                        (................................)

                                    </font>

                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>

            </table>


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


function exportCSV() {

    let table =
        document.querySelector("table");

    if (!table) {

        alert(
            "Pilih siswa terlebih dahulu."
        );

        return;

    }


    let rows =
        table.querySelectorAll("tr");


    let csv = [];


    rows.forEach(function(row) {

        let cols =
            row.querySelectorAll("th, td");

        let data = [];


        cols.forEach(function(col) {

            data.push(
                '"' +
                col.innerText.replace(/"/g, '""') +
                '"'
            );

        });


        csv.push(
            data.join(",")
        );

    });


    let file =
        new Blob(
            [csv.join("\n")],
            {
                type: "text/csv"
            }
        );


    let link =
        document.createElement("a");


    link.href =
        URL.createObjectURL(file);


    link.download =
        "laporan_pelanggaran.csv";


    link.click();

}

</script>

</body>

</html>