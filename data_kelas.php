<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

/* TAMBAH DATA KELAS */
if (isset($_POST['tambah']) && $role == "admin") {

    $nama = $_POST['nama'];
    $tingkat = $_POST['tingkat'];
    $jurusan = $_POST['jurusan'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_kelas
        (nama, tingkat, jurusan, status_aktif)
        VALUES
        ('$nama', '$tingkat', '$jurusan', '$status_aktif')");

    if ($query) {
        echo "Data kelas berhasil ditambahkan.<br>";
    } else {
        echo "Data kelas gagal ditambahkan.<br>";
    }
}


/* UBAH DATA KELAS */
if (isset($_POST['ubah']) && $role == "admin") {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tingkat = $_POST['tingkat'];
    $jurusan = $_POST['jurusan'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_kelas SET
        nama = '$nama',
        tingkat = '$tingkat',
        jurusan = '$jurusan',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        echo "Data kelas berhasil diubah.<br>";
    } else {
        echo "Data kelas gagal diubah.<br>";
    }
}


/* HAPUS DATA KELAS */
if (isset($_GET['hapus']) && $role == "admin") {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_kelas
        WHERE id = '$id'");

    if ($query) {
        echo "Data kelas berhasil dihapus.<br>";
    } else {
        echo "Data kelas gagal dihapus. Data mungkin masih digunakan.<br>";
    }
}


/* MENGAMBIL DATA KELAS UNTUK DIUBAH */
$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_kelas
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kelas</title>
</head>
<body>

<h1>Kelola Kelas</h1>

<p>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</p>


<?php if ($role == "admin") { ?>

    <?php if ($data_edit != null) { ?>

        <h2>Ubah Data Kelas</h2>

        <form method="POST">

            <input type="hidden" name="id"
                value="<?php echo $data_edit['id']; ?>">

            <p>
                Nama Kelas:<br>
                <input type="text" name="nama"
                    value="<?php echo $data_edit['nama']; ?>" required>
            </p>

            <p>
                Tingkat:<br>
                <select name="tingkat" required>

                    <option value="X"
                        <?php if ($data_edit['tingkat'] == "X") echo "selected"; ?>>
                        X
                    </option>

                    <option value="XI"
                        <?php if ($data_edit['tingkat'] == "XI") echo "selected"; ?>>
                        XI
                    </option>

                    <option value="XII"
                        <?php if ($data_edit['tingkat'] == "XII") echo "selected"; ?>>
                        XII
                    </option>

                </select>
            </p>

            <p>
                Jurusan:<br>
                <input type="text" name="jurusan"
                    value="<?php echo $data_edit['jurusan']; ?>" required>
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

            <a href="data_kelas.php">Batal</a>

        </form>

    <?php } else { ?>

        <h2>Tambah Data Kelas</h2>

        <form method="POST">

            <p>
                Nama Kelas:<br>
                <input type="text" name="nama" required>
            </p>

            <p>
                Tingkat:<br>
                <select name="tingkat" required>

                    <option value="">-- Pilih Tingkat --</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>

                </select>
            </p>

            <p>
                Jurusan:<br>
                <input type="text" name="jurusan" required>
            </p>

            <p>
                Status Aktif:<br>
                <select name="status_aktif" required>

                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>

                </select>
            </p>

            <button type="submit" name="tambah">
                Tambah Kelas
            </button>

        </form>

    <?php } ?>

<?php } ?>


<h2>Daftar Kelas</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Nama Kelas</th>
        <th>Tingkat</th>
        <th>Jurusan</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>
            <th>Aksi</th>
        <?php } ?>

    </tr>

    <?php

    $query_kelas = mysqli_query($koneksi, "SELECT * FROM t_kelas");

    $no = 1;

    while ($kelas = mysqli_fetch_assoc($query_kelas)) {

    ?>

        <tr>

            <td><?php echo $no; ?></td>

            <td><?php echo $kelas['nama']; ?></td>

            <td><?php echo $kelas['tingkat']; ?></td>

            <td><?php echo $kelas['jurusan']; ?></td>

            <td>
                <?php

                if ($kelas['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }

                ?>
            </td>


            <?php if ($role == "admin") { ?>

                <td>

                    <a href="data_kelas.php?edit=<?php echo $kelas['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="data_kelas.php?hapus=<?php echo $kelas['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus data kelas ini?')">
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