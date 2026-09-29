<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


/* =========================
   TAMBAH KATEGORI
========================= */

if (isset($_POST['tambah']) && $role == "admin") {

    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_kategori_pelanggaran
        (nama, deskripsi, status_aktif)
        VALUES
        ('$nama', '$deskripsi', '$status_aktif')");

    if ($query) {
        echo "Kategori pelanggaran berhasil ditambahkan.<br>";
    } else {
        echo "Kategori pelanggaran gagal ditambahkan.<br>";
    }
}


/* =========================
   UBAH KATEGORI
========================= */

if (isset($_POST['ubah']) && $role == "admin") {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_kategori_pelanggaran SET
        nama = '$nama',
        deskripsi = '$deskripsi',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        echo "Kategori pelanggaran berhasil diubah.<br>";
    } else {
        echo "Kategori pelanggaran gagal diubah.<br>";
    }
}


/* =========================
   HAPUS KATEGORI
========================= */

if (isset($_GET['hapus']) && $role == "admin") {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_kategori_pelanggaran
        WHERE id = '$id'");

    if ($query) {
        echo "Kategori pelanggaran berhasil dihapus.<br>";
    } else {
        echo "Kategori pelanggaran gagal dihapus. Kategori mungkin masih digunakan.<br>";
    }
}


/* =========================
   DATA UNTUK EDIT
========================= */

$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT *
        FROM t_kategori_pelanggaran
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Kelola Kategori Pelanggaran</title>

</head>

<body>

<h1>Kelola Kategori Pelanggaran</h1>

<a href="dashboard.php">
    Kembali ke Dashboard
</a>


<?php if ($role == "admin") { ?>


    <?php if ($data_edit != null) { ?>

        <!-- =========================
             FORM UBAH
        ========================== -->

        <h2>Ubah Kategori Pelanggaran</h2>

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?php echo $data_edit['id']; ?>">


            <p>
                Nama Kategori:<br>

                <input type="text"
                       name="nama"
                       value="<?php echo $data_edit['nama']; ?>"
                       required>

            </p>


            <p>
                Deskripsi:<br>

                <textarea name="deskripsi"
                          rows="4"
                          cols="40"><?php echo $data_edit['deskripsi']; ?></textarea>

            </p>


            <p>
                Status:<br>

                <select name="status_aktif" required>

                    <option value="1"
                        <?php
                        if ($data_edit['status_aktif'] == 1)
                            echo "selected";
                        ?>>
                        Aktif
                    </option>

                    <option value="0"
                        <?php
                        if ($data_edit['status_aktif'] == 0)
                            echo "selected";
                        ?>>
                        Tidak Aktif
                    </option>

                </select>

            </p>


            <button type="submit" name="ubah">
                Simpan Perubahan
            </button>

            <a href="kategori_pelanggaran.php">
                Batal
            </a>

        </form>


    <?php } else { ?>


        <!-- =========================
             FORM TAMBAH
        ========================== -->

        <h2>Tambah Kategori Pelanggaran</h2>

        <form method="POST">

            <p>
                Nama Kategori:<br>

                <input type="text"
                       name="nama"
                       placeholder="Contoh: Ringan"
                       required>

            </p>


            <p>
                Deskripsi:<br>

                <textarea name="deskripsi"
                          rows="4"
                          cols="40"
                          placeholder="Masukkan deskripsi kategori"></textarea>

            </p>


            <p>
                Status:<br>

                <select name="status_aktif" required>

                    <option value="1">
                        Aktif
                    </option>

                    <option value="0">
                        Tidak Aktif
                    </option>

                </select>

            </p>


            <button type="submit" name="tambah">
                Tambah Kategori
            </button>

        </form>

    <?php } ?>

<?php } ?>


<!-- =========================
     DAFTAR KATEGORI
========================== -->

<h2>Daftar Kategori Pelanggaran</h2>


<table border="1" cellpadding="5" cellspacing="0">

    <tr>

        <th>No</th>
        <th>Nama Kategori</th>
        <th>Deskripsi</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>

            <th>Aksi</th>

        <?php } ?>

    </tr>


    <?php

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM t_pelanggaran_kategori
         ORDER BY nama ASC"
    );

    $no = 1;


    while ($row = mysqli_fetch_assoc($query)) {

    ?>

        <tr>

            <td>
                <?php echo $no; ?>
            </td>

            <td>
                <?php echo $row['nama']; ?>
            </td>

            <td>
                <?php echo $row['deskripsi']; ?>
            </td>

            <td>

                <?php

                if ($row['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }

                ?>

            </td>


            <?php if ($role == "admin") { ?>

                <td>

                    <a href="kategori_pelanggaran.php?edit=<?php echo $row['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="kategori_pelanggaran.php?hapus=<?php echo $row['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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