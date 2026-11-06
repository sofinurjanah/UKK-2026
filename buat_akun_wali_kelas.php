
<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    mysqli_begin_transaction($koneksi);

    // Ambil semua guru yang terdaftar sebagai wali kelas
    $query = mysqli_query($koneksi, "
        SELECT DISTINCT g.id, g.nama, g.email
        FROM t_wali_kelas wk
        INNER JOIN t_guru g ON g.id = wk.guru_id
        WHERE g.email IS NOT NULL
          AND g.email != ''
    ");

    $jumlah_baru = 0;
    $jumlah_lama = 0;

    while ($guru = mysqli_fetch_assoc($query)) {
        $guru_id = (int) $guru['id'];
        $nama = $guru['nama'];
        $email = trim($guru['email']);

        // Periksa apakah akun dengan email tersebut sudah ada
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id FROM t_user WHERE email = ? LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user) {
            // Akun sudah ada, gunakan akun tersebut
            $user_id = (int) $user['id'];
            $jumlah_lama++;

            $stmt = mysqli_prepare(
                $koneksi,
                "UPDATE t_user SET name = ?, role = 'wali kelas'
                 WHERE id = ?"
            );
            mysqli_stmt_bind_param($stmt, "si", $nama, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        } else {
            // Buat akun baru
            $password = password_hash("password", PASSWORD_DEFAULT);
            $role = "wali kelas";

            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO t_user (name, email, password, role)
                 VALUES (?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $nama,
                $email,
                $password,
                $role
            );
            mysqli_stmt_execute($stmt);

            $user_id = mysqli_insert_id($koneksi);
            mysqli_stmt_close($stmt);

            $jumlah_baru++;
        }

        // Hubungkan akun dengan data guru
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE t_guru SET user_id = ? WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $guru_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_commit($koneksi);

    echo "Berhasil membuat akun wali kelas.<br>";
    echo "Akun baru: " . $jumlah_baru . "<br>";
    echo "Akun yang sudah tersedia: " . $jumlah_lama . "<br>";
    echo "Password akun baru: password";

} catch (Throwable $e) {
    mysqli_rollback($koneksi);
    echo "Gagal: " . htmlspecialchars($e->getMessage());
}
?>
