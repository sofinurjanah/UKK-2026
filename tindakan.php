<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


// =====================================
// SIMPAN TINDAKAN
// =====================================

if (isset($_POST['simpan'])) {

    $id = $_POST['id'];
    $tindakan = $_POST['tindakan'];
    $status = $_POST['status'];

    $query = mysqli_query($koneksi, "
        UPDATE t_pelanggaran_siswa
        SET
            tindakan = '$tindakan',
            status = '$status'
        WHERE id = '$id'
    ");

    if ($query) {

        echo "<script>
                alert('Tindakan berhasil disimpan');
                window.location='tindakan.php';
              </script>";

    } else {

        echo "Gagal menyimpan tindakan: "
             . mysqli_error($koneksi);

    }
}


// =====================================
// DATA UNTUK EDIT TINDAKAN
// =====================================

$data_edit = null;

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "
        SELECT *
        FROM t_pelanggaran_siswa
        WHERE id = '$id'
    ");

    $data_edit = mysqli_fetch_assoc($query_edit);
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Tindakan Pelanggaran</title>

</head>

<body>


<h1>Tindakan Pelanggaran Siswa</h1>

<a href="dashboard.php">
    Kembali ke Dashboard
</a>

<hr>


<?php if ($data_edit != null) { ?>

    <h2>Berikan Tindakan</h2>

    <form method="POST">

        <input type="hidden"
               name="id"
               value="<?php echo $data_edit['id']; ?>">


        <p>

            <b>Nama Siswa:</b><br>

            <?php echo $data_edit['nama_siswa']; ?>

        </p>


        <p>

            <b>Kelas:</b><br>

            <?php echo $data_edit['nama_kelas']; ?>

        </p>


        <p>

            <b>Pelanggaran:</b><br>

            <?php echo $data_edit['nama_pelanggaran']; ?>

        </p>


        <p>

            <b>Poin:</b><br>

            <?php echo $data_edit['poin']; ?>

        </p>


        <p>

            <b>Keterangan:</b><br>

            <?php echo $data_edit['keterangan']; ?>

        </p>


        <p>

            <label>
                Tindakan
            </label>

            <br>

            <textarea name="tindakan"
                      rows="5"
                      cols="50"
                      placeholder="Masukkan tindakan yang diberikan"
                      required><?php echo $data_edit['tindakan']; ?></textarea>

        </p>


        <p>

            <label>
                Status
            </label>

            <br>

            <select name="status" required>

                <option value="Teguran"
                    <?php
                    if ($data_edit['status'] == "Teguran") {
                        echo "selected";
                    }
                    ?>>
                    Teguran
                </option>


                <option value="Pembinaan"
                    <?php
                    if ($data_edit['status'] == "Pembinaan") {
                        echo "selected";
                    }
                    ?>>
                    Pembinaan
                </option>


                <option value="Dipantau"
                    <?php
                    if ($data_edit['status'] == "Dipantau") {
                        echo "selected";
                    }
                    ?>>
                    Dipantau
                </option>


                <option value="Ditindaklanjuti"
                    <?php
                    if ($data_edit['status'] == "Ditindaklanjuti") {
                        echo "selected";
                    }
                    ?>>
                    Ditindaklanjuti
                </option>


                <option value="Selesai"
                    <?php
                    if ($data_edit['status'] == "Selesai") {
                        echo "selected";
                    }
                    ?>>
                    Selesai
                </option>

            </select>

        </p>


        <button type="submit" name="simpan">
            Simpan Tindakan
        </button>


        <a href="tindakan.php">
            Batal
        </a>

    </form>

<?php } ?>


<hr>


<h2>Daftar Pelanggaran</h2>


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

        <th>Keterangan</th>

        <th>Tindakan</th>

        <th>Status</th>

        <th>Aksi</th>

    </tr>


    <?php

    $query = mysqli_query($koneksi, "

        SELECT *
        FROM t_pelanggaran_siswa

        ORDER BY tanggal DESC

    ");

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
                <?php echo $row['keterangan']; ?>
            </td>

            <td>
                <?php echo $row['tindakan']; ?>
            </td>

            <td>
                <?php echo $row['status']; ?>
            </td>

            <td>

                <a href="tindakan.php?edit=<?php echo $row['id']; ?>">
                    Beri Tindakan
                </a>

            </td>

        </tr>

    <?php

        $no++;

    }

    ?>

</table>


</body>

</html>