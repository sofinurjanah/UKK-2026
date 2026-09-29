<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


/* TAMBAH DATA TAHUN AJARAN */
if (isset($_POST['tambah']) && $role == "admin") {

    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_tahun_ajaran
        (nama, tanggal_mulai, tanggal_selesai, status_aktif)
        VALUES
        ('$nama', '$tanggal_mulai', '$tanggal_selesai', '$status_aktif')");

    if ($query) {
        echo "Data tahun ajaran berhasil ditambahkan.<br>";
    } else {
        echo "Data tahun ajaran gagal ditambahkan.<br>";
    }
}


/* UBAH DATA TAHUN AJARAN */
if (isset($_POST['ubah']) && $role == "admin") {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_tahun_ajaran SET
        nama = '$nama',
        tanggal_mulai = '$tanggal_mulai',
        tanggal_selesai = '$tanggal_selesai',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        echo "Data tahun ajaran berhasil diubah.<br>";
    } else {
        echo "Data tahun ajaran gagal diubah.<br>";
    }
}


/* HAPUS DATA TAHUN AJARAN */
if (isset($_GET['hapus']) && $role == "admin") {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_tahun_ajaran
        WHERE id = '$id'");

    if ($query) {
        echo "Data tahun ajaran berhasil dihapus.<br>";
    } else {
        echo "Data tahun ajaran gagal dihapus. Data mungkin masih digunakan.<br>";
    }
}


/* MENGAMBIL DATA TAHUN AJARAN UNTUK DIUBAH */
$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Tahun Ajaran</title>
</head>
<body>

<h1>Kelola Tahun Ajaran</h1>

<p>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</p>


<?php if ($role == "admin") { ?>

    <?php if ($data_edit != null) { ?>

        <h2>Ubah Tahun Ajaran</h2>

        <form method="POST">

            <input type="hidden" name="id"
                value="<?php echo $data_edit['id']; ?>">

            <p>
                Nama Tahun Ajaran:<br>
                <input type="text" name="nama"
                    value="<?php echo $data_edit['nama']; ?>"
                    placeholder="Contoh: 2026/2027"
                    required>
            </p>

            <p>
                Tanggal Mulai:<br>
                <input type="date" name="tanggal_mulai"
                    value="<?php echo $data_edit['tanggal_mulai']; ?>"
                    required>
            </p>

            <p>
                Tanggal Selesai:<br>
                <input type="date" name="tanggal_selesai"
                    value="<?php echo $data_edit['tanggal_selesai']; ?>"
                    required>
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

            <a href="data_tahun_ajaran.php">Batal</a>

        </form>

    <?php } else { ?>

        <h2>Tambah Tahun Ajaran</h2>

        <form method="POST">

            <p>
                Nama Tahun Ajaran:<br>
                <input type="text"
                       name="nama"
                       placeholder="Contoh: 2026/2027"
                       required>
            </p>

            <p>
                Tanggal Mulai:<br>
                <input type="date"
                       name="tanggal_mulai"
                       required>
            </p>

            <p>
                Tanggal Selesai:<br>
                <input type="date"
                       name="tanggal_selesai"
                       required>
            </p>

            <p>
                Status Aktif:<br>
                <select name="status_aktif" required>

                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>

                </select>
            </p>

            <button type="submit" name="tambah">
                Tambah Tahun Ajaran
            </button>

        </form>

    <?php } ?>

<?php } ?>


<h2>Daftar Tahun Ajaran</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Nama Tahun Ajaran</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>
            <th>Aksi</th>
        <?php } ?>

    </tr>

    <?php

    $query_tahun = mysqli_query($koneksi,
        "SELECT * FROM t_tahun_ajaran
         ORDER BY tanggal_mulai DESC");

    $no = 1;

    while ($tahun = mysqli_fetch_assoc($query_tahun)) {

    ?>

        <tr>

            <td><?php echo $no; ?></td>

            <td><?php echo $tahun['nama']; ?></td>

            <td><?php echo $tahun['tanggal_mulai']; ?></td>

            <td><?php echo $tahun['tanggal_selesai']; ?></td>

            <td>
                <?php

                if ($tahun['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }

                ?>
            </td>


            <?php if ($role == "admin") { ?>

                <td>

                    <a href="data_tahun_ajaran.php?edit=<?php echo $tahun['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="data_tahun_ajaran.php?hapus=<?php echo $tahun['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
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