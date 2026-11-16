
<?php
session_start();
include "config/koneksi.php";

// FUNGSI NOTIFIKASI LOGIN
function kembaliDenganAlert($icon, $title, $pesan)
{
    $_SESSION['login_alert'] = [
        'icon' => $icon,
        'title' => $title,
        'text' => $pesan
    ];

    header("Location: login.php");
    exit;
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // CEK EMAIL PADA DATABASE
    $email_aman = mysqli_real_escape_string($koneksi, $email);

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM t_user WHERE email = '$email_aman'"
    );

    $user = mysqli_fetch_assoc($query);

    // CEK EMAIL DAN PASSWORD
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

                kembaliDenganAlert(
                    'warning',
                    'Akun Tidak Aktif!',
                    'Akun guru tidak aktif. Silakan hubungi admin.'
                );

            }

            $_SESSION['guru_id'] = $guru['id'];
        }

        // SIMPAN SESSION PENGGUNA
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        // ROLE ADMIN DAN GURU
        if ($role == "admin" || $role == "guru") {

            $_SESSION['role'] = $role;

            header("Location: dashboard.php");
            exit;

        }

        // ROLE WALI KELAS
        elseif ($role == "wali kelas" || $role == "wali_kelas") {

            // CARI DATA GURU BERDASARKAN EMAIL
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

                kembaliDenganAlert(
                    'warning',
                    'Data Tidak Ditemukan!',
                    'Data guru wali kelas tidak ditemukan atau tidak aktif.'
                );

            }

            $_SESSION['role'] = "wali_kelas";
            $_SESSION['guru_id'] = $guru['id'];

            header("Location: dashboard.php");
            exit;

        }

        // ROLE TIDAK DIKENALI
        else {

            kembaliDenganAlert(
                'error',
                'Login Gagal!',
                'Role pengguna tidak dikenali.'
            );

        }

    }

    // EMAIL ATAU PASSWORD SALAH
    else {

        kembaliDenganAlert(
            'error',
            'Login Gagal!',
            'Email atau password yang Anda masukkan salah!'
        );

    }

} else {

    header("Location: login.php");
    exit;

}
?>
