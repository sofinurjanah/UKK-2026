<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM t_user WHERE email = '$email'");

    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == "admin" || $user['role'] == "guru") {
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