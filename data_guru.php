<?php
include "config/koneksi.php";
include "includes/cek_session.php";

$role = $_SESSION['role'];

if (isset($_POST['tambah']) && $role == "admin") {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $status_aktif = $_POST['status_aktif'];
    $user_id = $_POST['user_id'];

    $query = mysqli_query($koneksi, "INSERT INTO t_guru
        (nip, nama, email, status_aktif, user_id)
        VALUES
        ('$nip', '$nama', '$email', '$status_aktif', '$user_id')");

    if ($query) {
        echo "Data guru berhasil ditambahkan.<br>";
    } else {
        echo "Data guru gagal ditambahkan.<br>";
    }
}

if (isset($_POST['ubah']) && $role == "admin") {
    $id = $_POST['id'];
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $status_aktif = $_POST['status_aktif'];

    $query = mysqli_query($koneksi, "UPDATE t_guru SET
        nip = '$nip',
        nama = '$nama',
        email = '$email',
        status_aktif = '$status_aktif'
        WHERE id = '$id'");

    if ($query) {
        echo "Data guru berhasil diubah.<br>";
    } else {
        echo "Data guru gagal diubah.<br>";
    }
}

if (isset($_GET['hapus']) && $role == "admin") {
    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi, "DELETE FROM t_guru
        WHERE id = '$id'");

    if ($query) {
        echo "Data guru berhasil dihapus.<br>";
    } else {
        echo "Data guru gagal dihapus. Data mungkin masih digunakan.<br>";
    }
}

$data_edit = null;

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];

    $query_edit = mysqli_query($koneksi, "SELECT * FROM t_guru
        WHERE id = '$id_edit'");

    $data_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Guru</title>
</head>
<body>

<h1>Kelola Guru</h1>

<a href="dashboard.php">Kembali ke Dashboard</a>

<?php if ($role == "admin") { ?>

    <?php if ($data_edit != null) { ?>

        <h2>Ubah Data Guru</h2>

        <form method="POST">

            <input type="hidden" name="id"
                value="<?php echo $data_edit['id']; ?>">

            <p>
                NIP:<br>
                <input type="text" name="nip"
                    value="<?php echo $data_edit['nip']; ?>" required>
            </p>

            <p>
                Nama:<br>
                <input type="text" name="nama"
                    value="<?php echo $data_edit['nama']; ?>" required>
            </p>

            <p>
                Email:<br>
                <input type="email" name="email"
                    value="<?php echo $data_edit['email']; ?>" required>
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

            <a href="data_guru.php">Batal</a>

        </form>

    <?php } else { ?>

        <h2>Tambah Data Guru</h2>

        <form method="POST">

            <p>
                NIP:<br>
                <input type="text" name="nip" required>
            </p>

            <p>
                Nama:<br>
                <input type="text" name="nama" required>
            </p>

            <p>
                Email:<br>
                <input type="email" name="email" required>
            </p>

            <p>
                Akun Pengguna:<br>
                <select name="user_id" required>
                    <option value="">-- Pilih Akun Guru --</option>

                    <?php
                    $query_user = mysqli_query($koneksi,
                        "SELECT * FROM t_user WHERE role = 'guru'");

                    while ($user = mysqli_fetch_assoc($query_user)) {
                    ?>

                        <option value="<?php echo $user['id']; ?>">
                            <?php echo $user['name']; ?>
                            -
                            <?php echo $user['email']; ?>
                        </option>

                    <?php } ?>

                </select>
            </p>

            <p>
                Status Aktif:<br>
                <select name="status_aktif" required>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </p>

            <button type="submit" name="tambah">
                Tambah Guru
            </button>

        </form>

    <?php } ?>

<?php } ?>

<h2>Daftar Guru</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>
        <th>NIP</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Status</th>

        <?php if ($role == "admin") { ?>
            <th>Aksi</th>
        <?php } ?>
    </tr>

    <?php
    $query_guru = mysqli_query($koneksi, "SELECT * FROM t_guru");

    $no = 1;

    while ($guru = mysqli_fetch_assoc($query_guru)) {
    ?>

        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $guru['nip']; ?></td>
            <td><?php echo $guru['nama']; ?></td>
            <td><?php echo $guru['email']; ?></td>

            <td>
                <?php
                if ($guru['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }
                ?>
            </td>

            <?php if ($role == "admin") { ?>

                <td>
                    <a href="data_guru.php?edit=<?php echo $guru['id']; ?>">
                        Ubah
                    </a>

                    |

                    <a href="data_guru.php?hapus=<?php echo $guru['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus data guru ini?')">
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