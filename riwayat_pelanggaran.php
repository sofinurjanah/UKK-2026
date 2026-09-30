<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


// =====================================
// FILTER
// =====================================

$nama_siswa = isset($_GET['nama_siswa'])
    ? $_GET['nama_siswa']
    : "";

$tanggal_awal = isset($_GET['tanggal_awal'])
    ? $_GET['tanggal_awal']
    : "";

$tanggal_akhir = isset($_GET['tanggal_akhir'])
    ? $_GET['tanggal_akhir']
    : "";


// =====================================
// WHERE
// =====================================

$where = "WHERE 1=1";


if ($nama_siswa != "") {

    $where .= " AND nama_siswa LIKE '%$nama_siswa%'";

}


if ($tanggal_awal != "") {

    $where .= " AND tanggal >= '$tanggal_awal'";

}


if ($tanggal_akhir != "") {

    $where .= " AND tanggal <= '$tanggal_akhir'";

}


// =====================================
// DATA RIWAYAT
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

    <title>Riwayat Pelanggaran</title>

</head>

<body>


<h1>Riwayat Pelanggaran Siswa</h1>


<a href="dashboard.php">
    Kembali ke Dashboard
</a>

<hr>


<!-- =====================================
     FILTER
====================================== -->

<h2>Cari Riwayat</h2>


<form method="GET">


    <p>

        <label>
            Nama Siswa
        </label>

        <br>

        <input type="text"
               name="nama_siswa"
               value="<?php echo $nama_siswa; ?>"
               placeholder="Masukkan nama siswa">

    </p>


    <p>

        <label>
            Tanggal Awal
        </label>

        <br>

        <input type="date"
               name="tanggal_awal"
               value="<?php echo $tanggal_awal; ?>">

    </p>


    <p>

        <label>
            Tanggal Akhir
        </label>

        <br>

        <input type="date"
               name="tanggal_akhir"
               value="<?php echo $tanggal_akhir; ?>">

    </p>


    <button type="submit">
        Cari
    </button>


    <a href="riwayat_pelanggaran.php">
        Reset
    </a>


</form>


<hr>


<!-- =====================================
     TABEL RIWAYAT
====================================== -->

<h2>Daftar Riwayat Pelanggaran</h2>


<table border="1"
       cellpadding="5"
       cellspacing="0">

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


</body>

</html>