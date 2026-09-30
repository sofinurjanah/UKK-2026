<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


// =====================================
// FILTER NAMA SISWA
// =====================================

$nama_siswa = isset($_GET['nama_siswa'])
    ? $_GET['nama_siswa']
    : "";


// =====================================
// WHERE
// =====================================

$where = "";

if ($nama_siswa != "") {

    $where = "WHERE nama_siswa LIKE '%$nama_siswa%'";

}


// =====================================
// REKAP POIN
// =====================================

$query = mysqli_query($koneksi, "

    SELECT
        nama_siswa,
        nama_kelas,
        COUNT(*) AS jumlah_pelanggaran,
        SUM(poin) AS total_poin

    FROM t_pelanggaran_siswa

    $where

    GROUP BY
        nama_siswa,
        nama_kelas

    ORDER BY total_poin DESC,
             nama_siswa ASC

");

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Rekap Poin Pelanggaran</title>

</head>

<body>


<h1>Rekap Poin Pelanggaran Siswa</h1>


<a href="dashboard.php">
    Kembali ke Dashboard
</a>

<hr>


<!-- =====================================
     PENCARIAN
====================================== -->

<h2>Cari Siswa</h2>


<form method="GET">

    <input type="text"
           name="nama_siswa"
           value="<?php echo $nama_siswa; ?>"
           placeholder="Masukkan nama siswa">


    <button type="submit">
        Cari
    </button>


    <a href="rekap_poin.php">
        Reset
    </a>

</form>


<hr>


<!-- =====================================
     TABEL REKAP
====================================== -->

<h2>Daftar Rekap Poin</h2>


<table border="1"
       cellpadding="8"
       cellspacing="0">

    <tr>

        <th>No</th>

        <th>Nama Siswa</th>

        <th>Kelas</th>

        <th>Jumlah Pelanggaran</th>

        <th>Total Poin</th>

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
                <?php echo $row['nama_siswa']; ?>
            </td>


            <td>
                <?php echo $row['nama_kelas']; ?>
            </td>


            <td style="text-align:center;">
                <?php echo $row['jumlah_pelanggaran']; ?>
            </td>


            <td style="text-align:center;">
                <?php echo $row['total_poin']; ?>
            </td>

        </tr>


    <?php

        $no++;

    }

    ?>


</table>


</body>

</html>