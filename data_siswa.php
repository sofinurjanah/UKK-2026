<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

/* TAMBAH DATA SISWA */
if (isset($_POST['tambah']) && $role == "admin") {
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_siswa
        (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
        VALUES
        ('$nis', '$nisn', '$nama', '$jenis_kelamin',
        '$tanggal_lahir', '$alamat', '$status_aktif')");

    if ($query) {
        echo "Data siswa berhasil ditambahkan.<br>";
    } else {
        echo "Data siswa gagal ditambahkan.<br>";
    }
}

/* UBAH DATA SISWA */
if (isset($_POST['ubah']) && $role == "admin") {
    $id = $_POST['id'];
    $nis = $_POST['nis'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_siswa SET
        nis = '$nis',
        nisn = '$nisn',
        nama = '$nama',
        jenis_kelamin = '$jenis_kelamin',
        tanggal_lahir = '$tanggal_lahir',
        alamat = '$alamat',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        echo "Data siswa berhasil diubah.<br>";
    } else {
        echo "Data siswa gagal diubah.<br>";
    }
}

/* HAPUS DATA SISWA */
if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_siswa
        WHERE id = '$id'");

    if ($query) {
        echo "Data siswa berhasil dihapus.<br>";
    } else {
        echo "Data siswa gagal dihapus. Data mungkin masih digunakan.<br>";
    }
}

/* MENGAMBIL DATA SISWA UNTUK DIUBAH */
$data_edit = null;

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_siswa
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Siswa</title>
</head>
<body>

<h1>Kelola Siswa</h1>

<p>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</p>

<?php if ($role == "admin") { ?>

    <?php if ($data_edit != null) { ?>

        <h2>Ubah Data Siswa</h2>

        <form method="POST">

            <input type="hidden" name="id"
                value="<?php echo $data_edit['id']; ?>">

            <p>
                NIS:<br>
                <input type="text" name="nis"
                    value="<?php echo $data_edit['nis']; ?>" required>
            </p>

            <p>
                NISN:<br>
                <input type="text" name="nisn"
                    value="<?php echo $data_edit['nisn']; ?>" required>
            </p>

            <p>
                Nama:<br>
                <input type="text" name="nama"
                    value="<?php echo $data_edit['nama']; ?>" required>
            </p>

            <p>
                Jenis Kelamin:<br>
                <select name="jenis_kelamin" required>
                    <option value="L"
                        <?php if ($data_edit['jenis_kelamin'] == "L") echo "selected"; ?>>
                        Laki-laki
                    </option>

                    <option value="P"
                        <?php if ($data_edit['jenis_kelamin'] == "P") echo "selected"; ?>>
                        Perempuan
                    </option>
                </select>
            </p>

            <p>
                Tanggal Lahir:<br>
                <input type="date" name="tanggal_lahir"
                    value="<?php echo $data_edit['tanggal_lahir']; ?>"
                    required>
            </p>

            <p>
                Alamat:<br>
                <textarea name="alamat" required><?php
                    echo $data_edit['alamat'];
                ?></textarea>
            </p>

            <p>
                Status Aktif:<br>
                <select name="status_aktif" required>
                    <option value="1"
                        <?php if ($data_edit['status_aktif'] == 1) echo "selected"; ?>>
                        Aktif
                    </option>

                    <option value="0"
                        <?php if ($data_edit['status_aktif'] == 0) echo "selected"; ?>>
                        Tidak Aktif
                    </option>
                </select>
            </p>

            <button type="submit" name="ubah">
                Simpan Perubahan
            </button>

            <a href="data_siswa.php">Batal</a>

        </form>

    <?php } else { ?>

        <h2>Tambah Data Siswa</h2>

        <form method="POST">

            <p>
                NIS:<br>
                <input type="text" name="nis" required>
            </p>

            <p>
                NISN:<br>
                <input type="text" name="nisn" required>
            </p>

            <p>
                Nama:<br>
                <input type="text" name="nama" required>
            </p>

            <p>
                Jenis Kelamin:<br>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </p>

            <p>
                Tanggal Lahir:<br>
                <input type="date" name="tanggal_lahir" required>
            </p>

            <p>
                Alamat:<br>
                <textarea name="alamat" required></textarea>
            </p>

            <p>
                Status Aktif:<br>
                <select name="status_aktif" required>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </p>

            <button type="submit" name="tambah">
                Tambah Siswa
            </button>

        </form>

    <?php } ?>

<?php } ?>

<h2>Daftar Siswa</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>NISN</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>
            <th>Aksi</th>
        <?php } ?>
    </tr>

    <?php
    $query_siswa = mysqli_query($koneksi, "SELECT * FROM t_siswa");

    $no = 1;

    while ($siswa = mysqli_fetch_assoc($query_siswa)) {
    ?>

        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $siswa['nis']; ?></td>
            <td><?php echo $siswa['nisn']; ?></td>
            <td><?php echo $siswa['nama']; ?></td>

            <td>
                <?php
                if ($siswa['jenis_kelamin'] == "L") {
                    echo "Laki-laki";
                } else {
                    echo "Perempuan";
                }
                ?>
            </td>

            <td><?php echo $siswa['tanggal_lahir']; ?></td>
            <td><?php echo $siswa['alamat']; ?></td>

            <td>
                <?php
                if ($siswa['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }
                ?>
            </td>

            <?php if ($role == "admin") { ?>
                <td>
                    <a href="data_siswa.php?edit=<?php echo $siswa['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="data_siswa.php?hapus=<?php echo $siswa['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus data siswa ini?')">
                        Hapus
                    </a>
                </td>
            <?php } ?>

        </tr>

    <?php
        $no++;
    }
    ?>

</table>

</body>
</html>