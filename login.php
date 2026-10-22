<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPESMA | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="simpesma-login">

<div class="min-vh-100 d-flex flex-column">

    <div class="flex-grow-1 d-flex justify-content-center align-items-center p-3">

        <div class="card simpesma-login-card">

            <div class="card-body p-4 p-md-5">

                <div class="simpesma-logo mb-3">
                    <span>SM</span>
                </div>

                <p class="simpesma-label text-center mb-2">
                    SISTEM INFORMASI SEKOLAH
                </p>

                <h1 class="simpesma-title text-center mb-2">
                    SIMPESMA
                </h1>

                <p class="simpesma-full-name text-center mb-3">
                    Sistem Informasi Manajemen
                    Pelanggaran Siswa Muhammadiyah
                </p>

                <div class="simpesma-divider mb-3"></div>

                <p class="simpesma-description text-center mb-4">
                    Aplikasi Berbasis Web untuk Pengelolaan
                    Data Pelanggaran Siswa SMK Muhammadiyah
                </p>

                <form action="proses_login.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Masukkan email"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        name="login"
                        class="btn btn-primary w-100 simpesma-login-button"
                    >
                        Login ke SIMPESMA
                    </button>

                </form>

            </div>
        </div>

    </div>

    <footer class="simpesma-footer text-center py-3">
        <p class="mb-1">
            SIMPESMA &middot; SMK Muhammadiyah
        </p>
        <small>&copy; Sofinurjanah</small>
    </footer>

</div>

</body>
</html>
