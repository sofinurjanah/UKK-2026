
<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM t_user WHERE email = '" . mysqli_real_escape_string($koneksi, $email) . "'"
    );

    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $role = strtolower(trim($user['role']));
        // CEK STATUS AKTIF GURU
    if ($role == "guru") {

        $user_id = (int) $user['id'];

        $cek_guru = mysqli_query(
            $koneksi,
            "SELECT id, status_aktif
            FROM t_guru
            WHERE user_id = '$user_id'
            LIMIT 1"
        );

        $guru = mysqli_fetch_assoc($cek_guru);

        if (!$guru || (int) $guru['status_aktif'] !== 1) {
            echo "<script>
                alert('Akun guru tidak aktif. Silakan hubungi admin.');
                window.location='login.php';
            </script>";
            exit;
        }

    $_SESSION['guru_id'] = $guru['id'];
}

        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        if ($role == "admin" || $role == "guru") {

            $_SESSION['role'] = $role;

            header("Location: dashboard.php");
            exit;

        } elseif ($role == "wali kelas" || $role == "wali_kelas") {

            // Cari data guru berdasarkan email
            $stmt = mysqli_prepare(
                $koneksi,
                "SELECT id FROM t_guru
                 WHERE email = ? AND status_aktif = 1
                 LIMIT 1"
            );

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result_guru = mysqli_stmt_get_result($stmt);
            $guru = mysqli_fetch_assoc($result_guru);

            if (!$guru) {
                echo "Data guru wali kelas tidak ditemukan atau tidak aktif.";
                exit;
            }

            $_SESSION['role'] = "wali_kelas";
            $_SESSION['guru_id'] = $guru['id'];

            header("Location: dashboard.php");
            exit;

        } else {

            echo "Role pengguna tidak dikenali.";

        }

    } else {
        echo "Email atau password salah.";
    }

} else {
    header("Location: login.php");
    exit;
}
?>
