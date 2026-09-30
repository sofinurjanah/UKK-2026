<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pelanggaran Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet">
</head>

<body style="background-color: #30318B;">

<div class="min-vh-100 d-flex flex-column">

    <div class="flex-grow-1 d-flex justify-content-center align-items-center">

        <div class="card p-2 rounded-4 shadow" style="width: 25rem;">

            <div class="card-body">

                <h2 class="card-title text-center mb-4">
                    Sistem Informasi Pelanggaran Siswa
                </h2>

                <form action="proses_login.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" name="login" class="btn btn-outline-primary">
                            Login
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <footer class="py-3 text-center text-white">
        <p class="mb-0">
            ©sofinurjanah
        </p>
    </footer>

</div>

</body>
</html>