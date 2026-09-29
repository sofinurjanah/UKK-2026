<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Pelanggaran Siswa</title>
</head>
<body>

    <h2>Login Sistem Informasi Pelanggaran Siswa</h2>

    <form action="proses_login.php" method="POST">
        <label>Email</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit" name="login">Login</button>
    </form>

</body>
</html>