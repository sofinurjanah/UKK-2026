<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config/koneksi.php";

echo "<h3>PROSES PEMBUATAN AKUN WALI KELAS</h3>";

$password_awal = "password";
$password_hash = password_hash($password_awal, PASSWORD_DEFAULT);

$sql = "
    SELECT DISTINCT g.id, g.nama, g.email
    FROM t_guru g
    JOIN t_wali_kelas wk ON wk.guru_id = g.id
    JOIN t_tahun_ajaran ta ON ta.id = wk.tahun_ajaran_id
    LEFT JOIN t_user u
        ON LOWER(TRIM(u.email)) = LOWER(TRIM(g.email))
    WHERE wk.status_aktif = 1
      AND ta.status_aktif = 1
      AND g.status_aktif = 1
      AND u.id IS NULL
";

$result = mysqli_query($koneksi, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

echo "Guru yang belum memiliki akun: "
    . mysqli_num_rows($result) . "<hr>";

$berhasil = 0;
$gagal = 0;

while ($guru = mysqli_fetch_assoc($result)) {

    $nama = $guru['nama'];
    $email = $guru['email'];

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO t_user (name, email, password, role)
         VALUES (?, ?, ?, 'wali kelas')"
    );

    if (!$stmt) {
        echo "Gagal menyiapkan query: "
            . mysqli_error($koneksi) . "<br>";
        $gagal++;
        continue;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $nama,
        $email,
        $password_hash
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "BERHASIL: " . htmlspecialchars($nama) . "<br>";
        $berhasil++;
    } else {
        echo "GAGAL: " . htmlspecialchars($nama)
            . " - " . mysqli_stmt_error($stmt) . "<br>";
        $gagal++;
    }

    mysqli_stmt_close($stmt);
}

echo "<hr>";
echo "Berhasil: " . $berhasil . "<br>";
echo "Gagal: " . $gagal . "<br>";
echo "Password awal: password";
?>