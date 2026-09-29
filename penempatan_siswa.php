<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


/* =========================
   TAMBAH PENEMPATAN SISWA
========================= */

if (isset($_POST['tambah']) && $role == "admin") {

    $siswa_id = $_POST['siswa_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $kelas_id = $_POST['kelas_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "INSERT INTO t_kelas_siswa
        (siswa_id, tahun_ajaran_id, kelas_id, tanggal_mulai, tanggal_selesai, status_aktif)
        VALUES
        ('$siswa_id', '$tahun_ajaran_id', '$kelas_id',
         '$tanggal_mulai', '$tanggal_selesai', '$status_aktif')");

    if ($query) {
        echo "Penempatan siswa berhasil ditambahkan.<br>";
    } else {
        echo "Penempatan siswa gagal ditambahkan.<br>";
    }
}


/* =========================
   UBAH PENEMPATAN
========================= */

if (isset($_POST['ubah']) && $role == "admin") {

    $id = $_POST['id'];
    $siswa_id = $_POST['siswa_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $kelas_id = $_POST['kelas_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_kelas_siswa SET
        siswa_id = '$siswa_id',
        tahun_ajaran_id = '$tahun_ajaran_id',
        kelas_id = '$kelas_id',
        tanggal_mulai = '$tanggal_mulai',
        tanggal_selesai = '$tanggal_selesai',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        echo "Penempatan siswa berhasil diubah.<br>";
    } else {
        echo "Penempatan siswa gagal diubah.<br>";
    }
}


/* =========================
   HAPUS PENEMPATAN
========================= */

if (isset($_GET['hapus']) && $role == "admin") {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_kelas_siswa
        WHERE id = '$id'");

    if ($query) {
        echo "Penempatan siswa berhasil dihapus.<br>";
    } else {
        echo "Penempatan siswa gagal dihapus.<br>";
    }
}


/* =========================
   DATA UNTUK EDIT
========================= */

$data_edit = null;

if (isset($_GET['edit'])) {

    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT *
        FROM t_kelas_siswa
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Penempatan Siswa</title>
</head>

<body>

<h1>Penempatan Siswa</h1>

<a href="dashboard.php">Kembali ke Dashboard</a>


<?php if ($role == "admin") { ?>

    <?php if ($data_edit != null) { ?>

        <h2>Ubah Penempatan Siswa</h2>

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?php echo $data_edit['id']; ?>">


            <p>
                Siswa:<br>

                <select name="siswa_id" required>

                    <?php

                    $siswa = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_siswa
                         WHERE status_aktif = 1
                         ORDER BY nama ASC"
                    );

                    while ($row = mysqli_fetch_assoc($siswa)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>"
                            <?php
                            if ($data_edit['siswa_id'] == $row['id'])
                                echo "selected";
                            ?>>

                            <?php echo $row['nis']; ?>
                            -
                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Tahun Ajaran:<br>

                <select name="tahun_ajaran_id" required>

                    <?php

                    $tahun = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_tahun_ajaran
                         ORDER BY tanggal_mulai DESC"
                    );

                    while ($row = mysqli_fetch_assoc($tahun)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>"
                            <?php
                            if ($data_edit['tahun_ajaran_id'] == $row['id'])
                                echo "selected";
                            ?>>

                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Kelas:<br>

                <select name="kelas_id" required>

                    <?php

                    $kelas = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_kelas
                         WHERE status_aktif = 1
                         ORDER BY nama ASC"
                    );

                    while ($row = mysqli_fetch_assoc($kelas)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>"
                            <?php
                            if ($data_edit['kelas_id'] == $row['id'])
                                echo "selected";
                            ?>>

                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Tanggal Mulai:<br>

                <input type="date"
                       name="tanggal_mulai"
                       value="<?php echo $data_edit['tanggal_mulai']; ?>"
                       required>

            </p>


            <p>
                Tanggal Selesai:<br>

                <input type="date"
                       name="tanggal_selesai"
                       value="<?php echo $data_edit['tanggal_selesai']; ?>"
                       required>

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

            <a href="penempatan_siswa.php">
                Batal
            </a>

        </form>


    <?php } else { ?>


        <h2>Tambah Penempatan Siswa</h2>

        <form method="POST">


            <p>
                Siswa:<br>

                <select name="siswa_id" required>

                    <option value="">
                        -- Pilih Siswa --
                    </option>

                    <?php

                    $siswa = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_siswa
                         WHERE status_aktif = 1
                         ORDER BY nama ASC"
                    );

                    while ($row = mysqli_fetch_assoc($siswa)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>">

                            <?php echo $row['nis']; ?>
                            -
                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Tahun Ajaran:<br>

                <select name="tahun_ajaran_id" required>

                    <option value="">
                        -- Pilih Tahun Ajaran --
                    </option>

                    <?php

                    $tahun = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_tahun_ajaran
                         ORDER BY tanggal_mulai DESC"
                    );

                    while ($row = mysqli_fetch_assoc($tahun)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>">

                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

            </p>


            <p>
                Kelas:<br>

                <select name="kelas_id" required>

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    <?php

                    $kelas = mysqli_query(
                        $koneksi,
                        "SELECT * FROM t_kelas
                         WHERE status_aktif = 1
                         ORDER BY nama ASC"
                    );

                    while ($row = mysqli_fetch_assoc($kelas)) {

                    ?>

                        <option value="<?php echo $row['id']; ?>">

                            <?php echo $row['nama']; ?>

                        </option>

                    <?php } ?>

                </select>

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
                Simpan Penempatan
            </button>

        </form>

    <?php } ?>

<?php } ?>


<h2>Daftar Penempatan Siswa</h2>


<table border="1" cellpadding="5" cellspacing="0">

    <tr>

        <th>No</th>
        <th>NIS</th>
        <th>Nama Siswa</th>
        <th>Tahun Ajaran</th>
        <th>Kelas</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>
            <th>Aksi</th>
        <?php } ?>

    </tr>


    <?php

    $query = mysqli_query($koneksi, "

        SELECT
            t_kelas_siswa.*,
            t_siswa.nis,
            t_siswa.nama AS nama_siswa,
            t_kelas.nama AS nama_kelas,
            t_tahun_ajaran.nama AS nama_tahun

        FROM t_kelas_siswa

        INNER JOIN t_siswa
            ON t_kelas_siswa.siswa_id = t_siswa.id

        INNER JOIN t_kelas
            ON t_kelas_siswa.kelas_id = t_kelas.id

        INNER JOIN t_tahun_ajaran
            ON t_kelas_siswa.tahun_ajaran_id = t_tahun_ajaran.id

        ORDER BY t_siswa.nama ASC

    ");

    $no = 1;


    while ($row = mysqli_fetch_assoc($query)) {

    ?>

        <tr>

            <td>
                <?php echo $no; ?>
            </td>

            <td>
                <?php echo $row['nis']; ?>
            </td>

            <td>
                <?php echo $row['nama_siswa']; ?>
            </td>

            <td>
                <?php echo $row['nama_tahun']; ?>
            </td>

            <td>
                <?php echo $row['nama_kelas']; ?>
            </td>

            <td>
                <?php echo $row['tanggal_mulai']; ?>
            </td>

            <td>
                <?php echo $row['tanggal_selesai']; ?>
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

                    <a href="penempatan_siswa.php?edit=<?php echo $row['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="penempatan_siswa.php?hapus=<?php echo $row['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus penempatan siswa ini?')">
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