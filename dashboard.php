<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Sistem Pelanggaran Siswa</title>
</head>
<body>

    <h2>Dashboard Sistem Informasi Pelanggaran Siswa</h2>

    <p>Selamat datang, <?php echo $nama; ?>!</p>
    <p>Role: <?php echo $role; ?></p>

    <hr>

    <h3>Menu</h3>

    <?php
    if ($role == "admin") {
    ?>

        <ul>
            <li><a href="data_siswa.php">Kelola Siswa</a></li>
            <li><a href="data_guru.php">Kelola Guru</a></li>
            <li><a href="data_kelas.php">Kelola Kelas</a></li>
            <li><a href="data_tahun_ajaran.php">Kelola Tahun Ajaran</a></li>
            <li><a href="penempatan_siswa.php">Penempatan Siswa</a></li>
            <li><a href="wali_kelas.php">Kelola Wali Kelas</a></li>
            <li><a href="kategori_pelanggaran.php">Kelola Kategori Pelanggaran</a></li>
            <li><a href="jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="cetak_export.php">Cetak/Export</a></li>
        </ul>

    <?php
    } elseif ($role == "guru") {
    ?>

        <ul>
            <li><a href="catat_pelanggaran.php">Catat Pelanggaran</a></li>
            <li><a href="tindakan.php">Tindakan</a></li>
            <li><a href="riwayat_pelanggaran.php">Riwayat Pelanggaran</a></li>
            <li><a href="rekap_poin.php">Rekap Poin</a></li>
        </ul>

    <?php
    } else {
        echo "Role tidak dikenali.";
    }
    ?>

    <hr>

    <a href="logout.php">Logout</a>

</body>
</html>