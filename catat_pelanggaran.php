<?php

include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];


// =====================================
// SIMPAN PELANGGARAN
// =====================================

if (isset($_POST['simpan'])) {

    $siswa_id = $_POST['siswa_id'];
    $pelanggaran_id = $_POST['pelanggaran_id'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $tindakan = $_POST['tindakan'];
    $status = $_POST['status'];

    // Ambil data siswa
    $query_siswa = mysqli_query($koneksi, "
        SELECT
            t_siswa.nama AS nama_siswa,
            t_kelas.nama AS nama_kelas
        FROM t_siswa
        LEFT JOIN t_kelas_siswa
            ON t_siswa.id = t_kelas_siswa.siswa_id
        LEFT JOIN t_kelas
            ON t_kelas_siswa.kelas_id = t_kelas.id
        WHERE t_siswa.id = '$siswa_id'
        AND t_kelas_siswa.status_aktif = 1
        LIMIT 1
    ");

    $data_siswa = mysqli_fetch_assoc($query_siswa);


    // Ambil data pelanggaran
    $query_pelanggaran = mysqli_query($koneksi, "
        SELECT
            nama,
            poin
        FROM t_pelanggaran
        WHERE id = '$pelanggaran_id'
    ");

    $data_pelanggaran = mysqli_fetch_assoc($query_pelanggaran);


    if ($data_siswa && $data_pelanggaran) {

        $nama_siswa = $data_siswa['nama_siswa'];
        $nama_kelas = $data_siswa['nama_kelas'];

        $nama_pelanggaran = $data_pelanggaran['nama'];
        $poin = $data_pelanggaran['poin'];


        // Ambil nama guru yang sedang login
        $guru_id = $_SESSION['guru_id'];

        $query_guru = mysqli_query($koneksi, "
            SELECT nama
            FROM t_guru
            WHERE id = '$guru_id'
        ");

        $data_guru = mysqli_fetch_assoc($query_guru);

        $nama_guru = $data_guru['nama'];


        // Simpan
        $query = mysqli_query($koneksi, "
            INSERT INTO t_pelanggaran_siswa
            (
                siswa_id,
                pelanggaran_id,
                guru_id,
                tanggal,
                nama_siswa,
                nama_kelas,
                nama_pelanggaran,
                poin,
                nama_guru,
                keterangan,
                tindakan,
                status
            )
            VALUES
            (
                '$siswa_id',
                '$pelanggaran_id',
                '$guru_id',
                '$tanggal',
                '$nama_siswa',
                '$nama_kelas',
                '$nama_pelanggaran',
                '$poin',
                '$nama_guru',
                '$keterangan',
                '$tindakan',
                '$status'
            )
        ");


        if ($query) {

            echo "<script>
                    alert('Pelanggaran berhasil dicatat');
                    window.location='catat_pelanggaran.php';
                  </script>";

        } else {

            echo "Gagal menyimpan pelanggaran: "
                 . mysqli_error($koneksi);

        }

    } else {

        echo "<script>
                alert('Data siswa atau pelanggaran tidak ditemukan');
              </script>";

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Catat Pelanggaran</title>

</head>

<body>


<h1>Catat Pelanggaran Siswa</h1>

<a href="dashboard.php">
    Kembali ke Dashboard
</a>

<hr>


<form method="POST">


    <!-- =========================
         SISWA
    ========================== -->

    <p>

        <label>
            Nama Siswa
        </label>

        <br>

        <select name="siswa_id" required>

            <option value="">
                -- Pilih Siswa --
            </option>

            <?php

            $query_siswa = mysqli_query($koneksi, "
                SELECT
                    t_siswa.id,
                    t_siswa.nis,
                    t_siswa.nama,
                    t_kelas.nama AS nama_kelas

                FROM t_siswa

                LEFT JOIN t_kelas_siswa
                    ON t_siswa.id = t_kelas_siswa.siswa_id

                LEFT JOIN t_kelas
                    ON t_kelas_siswa.kelas_id = t_kelas.id

                WHERE t_siswa.status_aktif = 1
                AND t_kelas_siswa.status_aktif = 1

                ORDER BY t_siswa.nama ASC
            ");

            while ($row = mysqli_fetch_assoc($query_siswa)) {

            ?>

                <option value="<?php echo $row['id']; ?>">

                    <?php echo $row['nis']; ?>
                    -
                    <?php echo $row['nama']; ?>

                    <?php
                    if ($row['nama_kelas'] != "") {
                        echo " (" . $row['nama_kelas'] . ")";
                    }
                    ?>

                </option>

            <?php } ?>

        </select>

    </p>


    <!-- =========================
         PELANGGARAN
    ========================== -->

    <p>

        <label>
            Jenis Pelanggaran
        </label>

        <br>

        <select name="pelanggaran_id" required>

            <option value="">
                -- Pilih Pelanggaran --
            </option>

            <?php

            $query_pelanggaran = mysqli_query($koneksi, "

                SELECT
                    t_pelanggaran.id,
                    t_pelanggaran.kode,
                    t_pelanggaran.nama,
                    t_pelanggaran.poin,
                    t_pelanggaran_kategori.nama AS nama_kategori

                FROM t_pelanggaran

                INNER JOIN t_pelanggaran_kategori
                    ON t_pelanggaran.pelanggaran_kategori_id
                    = t_pelanggaran_kategori.id

                WHERE t_pelanggaran.status_aktif = 1

                ORDER BY t_pelanggaran.nama ASC

            ");

            while ($row = mysqli_fetch_assoc($query_pelanggaran)) {

            ?>

                <option value="<?php echo $row['id']; ?>">

                    <?php echo $row['kode']; ?>
                    -
                    <?php echo $row['nama']; ?>
                    -
                    <?php echo $row['poin']; ?> poin

                </option>

            <?php } ?>

        </select>

    </p>


    <!-- =========================
         TANGGAL
    ========================== -->

    <p>

        <label>
            Tanggal
        </label>

        <br>

        <input type="date"
               name="tanggal"
               value="<?php echo date('Y-m-d'); ?>"
               required>

    </p>


    <!-- =========================
         KETERANGAN
    ========================== -->

    <p>

        <label>
            Keterangan
        </label>

        <br>

        <textarea name="keterangan"
                  rows="4"
                  cols="50"
                  placeholder="Masukkan keterangan pelanggaran"></textarea>

    </p>


    <!-- =========================
         TINDAKAN
    ========================== -->

    <p>

        <label>
            Tindakan
        </label>

        <br>

        <textarea name="tindakan"
                  rows="4"
                  cols="50"
                  placeholder="Masukkan tindakan yang diberikan"></textarea>

    </p>


    <!-- =========================
         STATUS
    ========================== -->

    <p>

        <label>
            Status
        </label>

        <br>

        <select name="status" required>

            <option value="Teguran">
                Teguran
            </option>

            <option value="Pembinaan">
                Pembinaan
            </option>

            <option value="Dipantau">
                Dipantau
            </option>

            <option value="Ditindaklanjuti">
                Ditindaklanjuti
            </option>

            <option value="Selesai">
                Selesai
            </option>

        </select>

    </p>


    <button type="submit" name="simpan">
        Simpan Pelanggaran
    </button>


</form>


<hr>


<h2>Data Pelanggaran Terbaru</h2>


<table border="1"
       cellpadding="5"
       cellspacing="0">

    <tr>

        <th>No</th>
        <th>Tanggal</th>
        <th>Siswa</th>
        <th>Kelas</th>
        <th>Pelanggaran</th>
        <th>Poin</th>
        <th>Guru</th>
        <th>Status</th>

    </tr>


    <?php

    $query_data = mysqli_query($koneksi, "

        SELECT *
        FROM t_pelanggaran_siswa

        ORDER BY tanggal DESC

        LIMIT 20

    ");

    $no = 1;


    while ($row = mysqli_fetch_assoc($query_data)) {

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