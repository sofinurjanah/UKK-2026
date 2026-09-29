<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


// =====================================
// FILTER
// =====================================

$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : "";
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : "";
$status = isset($_GET['status']) ? $_GET['status'] : "";


// =====================================
// WHERE
// =====================================

$where = "WHERE 1=1";


if ($tanggal_awal != "") {
    $where .= " AND tanggal >= '$tanggal_awal'";
}

if ($tanggal_akhir != "") {
    $where .= " AND tanggal <= '$tanggal_akhir'";
}

if ($status != "") {
    $where .= " AND status = '$status'";
}


// =====================================
// DATA LAPORAN
// =====================================

$query = mysqli_query($koneksi, "

    SELECT *
    FROM t_pelanggaran_siswa

    $where

    ORDER BY tanggal DESC, nama_siswa ASC

");


// =====================================
// TOTAL PELANGGARAN
// =====================================

$query_total = mysqli_query($koneksi, "

    SELECT
        COUNT(*) AS total_pelanggaran,
        COALESCE(SUM(poin), 0) AS total_poin

    FROM t_pelanggaran_siswa

    $where

");

$total = mysqli_fetch_assoc($query_total);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Pelanggaran Siswa</title>

</head>

<body>

<h1>Laporan Pelanggaran Siswa</h1>

<a href="dashboard.php">
    Kembali ke Dashboard
</a>

<hr>


<!-- =====================================
     FILTER LAPORAN
====================================== -->

<h2>Filter Laporan</h2>

<form method="GET">

    <p>

        Tanggal Awal:<br>

        <input type="date"
               name="tanggal_awal"
               value="<?php echo $tanggal_awal; ?>">

    </p>


    <p>

        Tanggal Akhir:<br>

        <input type="date"
               name="tanggal_akhir"
               value="<?php echo $tanggal_akhir; ?>">

    </p>


    <p>

        Status:<br>

        <select name="status">

            <option value="">
                -- Semua Status --
            </option>

            <option value="Teguran"
                <?php
                if ($status == "Teguran") {
                    echo "selected";
                }
                ?>>
                Teguran
            </option>

            <option value="Pembinaan"
                <?php
                if ($status == "Pembinaan") {
                    echo "selected";
                }
                ?>>
                Pembinaan
            </option>

            <option value="Selesai"
                <?php
                if ($status == "Selesai") {
                    echo "selected";
                }
                ?>>
                Selesai
            </option>

            <option value="Dipantau"
                <?php
                if ($status == "Dipantau") {
                    echo "selected";
                }
                ?>>
                Dipantau
            </option>

            <option value="Ditindaklanjuti"
                <?php
                if ($status == "Ditindaklanjuti") {
                    echo "selected";
                }
                ?>>
                Ditindaklanjuti
            </option>

        </select>

    </p>


    <button type="submit">
        Tampilkan Laporan
    </button>


    <a href="laporan.php">
        Reset
    </a>

</form>


<hr>


<!-- =====================================
     RINGKASAN
====================================== -->

<h2>Ringkasan</h2>

<table border="1" cellpadding="10">

    <tr>

        <th>
            Total Pelanggaran
        </th>

        <th>
            Total Poin
        </th>

    </tr>


    <tr>

        <td>
            <?php echo $total['total_pelanggaran']; ?>
        </td>

        <td>
            <?php echo $total['total_poin']; ?>
        </td>

    </tr>

</table>


<br>


<!-- =====================================
     TABEL LAPORAN
====================================== -->

<h2>Data Laporan</h2>


<table border="1"
       cellpadding="5"
       cellspacing="0">

    <tr>

        <th>No</th>

        <th>Tanggal</th>

        <th>Nama Siswa</th>

        <th>Kelas</th>

        <th>Nama Pelanggaran</th>

        <th>Kategori</th>

        <th>Poin</th>

        <th>Guru</th>

        <th>Keterangan</th>

        <th>Tindakan</th>

        <th>Status</th>

    </tr>


    <?php

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
                <?php echo $row['pelanggaran_kategori_id']; ?>
            </td>

            <td>
                <?php echo $row['poin']; ?>
            </td>

            <td>
                <?php echo $row['nama_guru']; ?>
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

        </tr>

    <?php

        $no++;

    }

    ?>

</table>


<br>

<a href="cetak_export.php">
    Cetak / Export Laporan
</a>


</body>

</html>