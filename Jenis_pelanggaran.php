<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

if (isset($_POST['tambah']) && $role == "admin") {

    $pelanggaran_kategori_id = $_POST['pelanggaran_kategori_id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $poin = $_POST['poin'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_pelanggaran
    (pelanggaran_kategori_id, kode, nama, poin, deskripsi, status_aktif)
    VALUES
    ('$pelanggaran_kategori_id', '$kode', '$nama', '$poin', '$deskripsi', '$status_aktif')");

    if ($query) {
        echo "Jenis pelanggaran berhasil ditambahkan.<br>";
    } else {
        echo "jenis pelanggaran gagal ditambahkan.<br>";
    }
}

if (isset($_POST['ubah']) && $role == "admin") {

    $id = $_POST['id'];
    $pelanggaran_kategori_id = $_POST['pelanggaran_kategori_id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $poin = $_POST['poin'];
    $deskripsi = $_POST['deskripsi'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_pelanggaran SET pelanggaran_kategori_id = '$pelanggaran_kategori_id',
    kode = '$kode',
    nama = '$nama',
    poin = '$poin',
    deskripsi = '$deskripsi',
    status_aktif = '$status_aktif'
    WHERE id = '$id'");

     if ($query) {
        echo "Jenis pelanggaran berhasil diubah.<br>";
    } else {
        echo "Jenis pelanggaran gagal diubah.<br>";
    }
}

if (isset($_GET['hapus']) && $role == "admin") {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_pelanggaran
        WHERE id = '$id'");

    if ($query) {
        echo "Jenis pelanggaran berhasil dihapus.<br>";
    } else {
        echo "Jenis pelanggaran gagal dihapus. Data mungkin masih digunakan.<br>";
    }
}

$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT *
        FROM t_pelanggaran
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Kelola Jenis Pelanggaran</title>

</head>

<body>

<h1>Kelola Jenis Pelanggaran</h1>

<a href="dashboard.php">
    Kembali ke Dashboard
</a>


<?php if ($role == "admin") { ?>


    <?php if ($data_edit != null) { ?>

    <h2>Ubah Jenis Pelanggaran</h2>

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?php echo $data_edit['id']; ?>">


            <p>
                Kategori Pelanggaran:<br>

                <select name="pelanggaran_kategori_id" required>

                    <?php

                    $kategori = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_pelanggaran_kategori
                         WHERE status_aktif = 1
                         ORDER BY nama ASC"
                    );

                    while ($row = mysqli_fetch_assoc($kategori)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>"
                            <?php
                            if ($data_edit['pelanggaran_kategori_id'] == $row['id'])
                                echo "selected";
                            ?>>

                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Kode Pelanggaran:<br>

                <input type="text"
                       name="kode"
                       value="<?php echo $data_edit['kode']; ?>"
                       required>

            </p>


            <p>
                Nama Pelanggaran:<br>

                <input type="text"
                       name="nama"
                       value="<?php echo $data_edit['nama']; ?>"
                       required>

            </p>


            <p>
                Poin:<br>

                <input type="number"
                       name="poin"
                       value="<?php echo $data_edit['poin']; ?>"
                       min="0"
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

            <a href="jenis_pelanggaran.php">
                Batal
            </a>

        </form>


    <?php } else { ?>

    <h2>Tambah Jenis Pelanggaran</h2>

        <form method="POST">


            <p>
                Kategori Pelanggaran:<br>

                <select name="pelanggaran_kategori_id" required>

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    <?php

                    $kategori = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_pelanggaran_kategori
                         WHERE status_aktif = 1
                         ORDER BY nama ASC"
                    );

                    while ($row = mysqli_fetch_assoc($kategori)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>">

                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Kode Pelanggaran:<br>

                <input type="text"
                       name="kode"
                       placeholder="Contoh: PLG001"
                       required>

            </p>


            <p>
                Nama Pelanggaran:<br>

                <input type="text"
                       name="nama"
                       placeholder="Contoh: Terlambat"
                       required>

            </p>


            <p>
                Poin:<br>

                <input type="number"
                       name="poin"
                       min="0"
                       placeholder="Contoh: 5"
                       required>

            </p>


            <p>
                Deskripsi:<br>

                <textarea name="deskripsi"
                          rows="4"
                          cols="40"
                          placeholder="Masukkan deskripsi pelanggaran"></textarea>

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
                Tambah Jenis Pelanggaran
            </button>

        </form>

    <?php } ?>

<?php } ?>

<h2>Daftar Jenis Pelanggaran</h2>


<table border="1" cellpadding="5" cellspacing="0">

    <tr>

        <th>No</th>
        <th>Kategori</th>
        <th>Kode</th>
        <th>Nama Pelanggaran</th>
        <th>Poin</th>
        <th>Deskripsi</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>

            <th>Aksi</th>

        <?php } ?>

    </tr>


    <?php

    $query = mysqli_query($koneksi, "

        SELECT
            t_pelanggaran.*,
            t_pelanggaran_kategori.nama AS nama_kategori

        FROM t_pelanggaran

        INNER JOIN t_pelanggaran_kategori
            ON t_pelanggaran.pelanggaran_kategori_id
            = t_pelanggaran_kategori.id

        ORDER BY t_pelanggaran.kode ASC

    ");

    $no = 1;


    while ($row = mysqli_fetch_assoc($query)) {

    ?>

        <tr>

            <td>
                <?php echo $no; ?>
            </td>

            <td>
                <?php echo $row['nama_kategori']; ?>
            </td>

            <td>
                <?php echo $row['kode']; ?>
            </td>

            <td>
                <?php echo $row['nama']; ?>
            </td>

            <td>
                <?php echo $row['poin']; ?>
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

                    <a href="jenis_pelanggaran.php?edit=<?php echo $row['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="jenis_pelanggaran.php?hapus=<?php echo $row['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">
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