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
// DATA
// =====================================

$query = mysqli_query($koneksi, "

    SELECT *
    FROM t_pelanggaran_siswa

    $where

    ORDER BY tanggal DESC, nama_siswa ASC

");

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Cetak Laporan Pelanggaran</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h1 {
            text-align: center;
        }

        .filter {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 7px;
            text-align: left;
        }

        th {
            text-align: center;
        }

        .tombol {
            margin-bottom: 20px;
        }

        @media print {

            .tombol,
            .filter {
                display: none;
            }

            body {
                margin: 10px;
            }

        }

    </style>

</head>

<body>


<!-- =====================================
     TOMBOL
====================================== -->

<div class="tombol">

    <a href="dashboard.php">
        Kembali ke Dashboard
    </a>

    &nbsp;&nbsp;

    <button onclick="window.print()">
        Cetak Laporan
    </button>

</div>


<!-- =====================================
     JUDUL
====================================== -->

<h1>
    LAPORAN PELANGGARAN SISWA
</h1>


<p style="text-align:center;">
    Sistem Informasi Pelanggaran Siswa
</p>


<hr>


<!-- =====================================
     FILTER
====================================== -->

<div class="filter">

    <form method="GET">

        Tanggal Awal:

        <input type="date"
               name="tanggal_awal"
               value="<?php echo $tanggal_awal; ?>">


        &nbsp;


        Tanggal Akhir:

        <input type="date"
               name="tanggal_akhir"
               value="<?php echo $tanggal_akhir; ?>">


        &nbsp;


        Status:

        <select name="status">

            <option value="">
                Semua
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


        <button type="submit">
            Tampilkan
        </button>

    </form>

</div>


<!-- =====================================
     TABEL
====================================== -->

<table>

    <tr>

        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        <th>Pelanggaran</th>
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

            <td style="text-align:center;">
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

            <td style="text-align:center;">
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


<br><br>


<!-- =====================================
     TANDA TANGAN
====================================== -->

<table style="border:none;">

    <tr>

        <td style="border:none; width:70%;"></td>

        <td style="border:none; text-align:center;">

            Tasikmalaya,
            <?php echo date('d-m-Y'); ?>

            <br><br><br><br>

            ______________________

            <br>

            Admin

        </td>

    </tr>

</table>


</body>

</html>