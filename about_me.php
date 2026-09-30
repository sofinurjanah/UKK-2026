<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? 'Pengguna';
$role = ucfirst(strtolower($_SESSION['role'] ?? 'Pengguna'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me | Sistem Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 min-vh-100 p-3 text-white"
               style="background-color: #30318B;">

            <h5 class="fw-bold mb-4">Sistem Pelanggaran</h5>

            <ul class="nav nav-pills flex-column gap-2">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data_siswa.php" class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>

                <!-- ABOUT ME -->
                <li class="nav-item mt-3">
                    <a href="about_me.php"
                       class="nav-link active rounded-3 p-3"
                       style="background-color: rgba(255,255,255,0.18);
                              border: 1px solid rgba(255,255,255,0.25);">

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white text-primary
                                        d-flex align-items-center justify-content-center me-3"
                                 style="width: 40px; height: 40px;">
                                <span class="fs-5">♡</span>
                            </div>

                            <div>
                                <div class="fw-semibold">About Me</div>
                                <small class="text-white-50">
                                    Kenali lebih dekat
                                </small>
                            </div>

                            <span class="ms-auto">›</span>
                        </div>
                    </a>
                </li>

                <hr class="text-white-50">

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-white">
                        Logout
                    </a>
                </li>

            </ul>
        </aside>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4 p-md-5">

            <div class="mb-4">
                <span class="badge rounded-pill px-3 py-2"
                      style="background-color: #e9e9ff; color: #30318B;">
                    ✦ ABOUT ME
                </span>

                <h2 class="fw-bold mt-3">Tentang Saya</h2>
                <p class="text-secondary">
                    Sedikit cerita tentang saya dan proyek yang sedang dikembangkan.
                </p>
            </div>

            <!-- KARTU PROFIL -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div style="height: 10px; background-color: #30318B;"></div>

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <div class="rounded-circle mx-auto d-flex
                                    align-items-center justify-content-center
                                    text-white shadow-sm"
                             style="width: 110px; height: 110px;
                                    background-color: #30318B;">

                            <span class="display-5 fw-semibold">
                                <?= strtoupper(substr($nama, 0, 1)); ?>
                            </span>
                        </div>

                        <h3 class="fw-bold mt-3 mb-1">
                            <?= htmlspecialchars($nama); ?>
                        </h3>

                        <p class="text-secondary mb-0">
                            <?= htmlspecialchars($role); ?>
                        </p>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3">Halo, selamat datang! 👋</h5>

                    <p class="text-secondary" style="line-height: 1.8;">
                        Saya merupakan pengembang aplikasi Sistem Informasi
                        Pelanggaran Siswa. Aplikasi ini dibuat untuk membantu
                        proses pengelolaan data siswa dan pencatatan pelanggaran
                        agar lebih terstruktur dan mudah digunakan.
                    </p>

                    <p class="text-secondary" style="line-height: 1.8;">
                        Melalui proyek ini, saya ingin mengembangkan kemampuan
                        dalam membuat aplikasi berbasis web, mulai dari
                        perancangan tampilan hingga pengelolaan data.
                    </p>

                    <!-- INFORMASI PROYEK -->
                    <div class="rounded-4 p-4 mt-4"
                         style="background-color: #f5f5ff;">

                        <h6 class="fw-bold mb-3" style="color: #30318B;">
                            <span class="me-2">✧</span>
                            Informasi Proyek
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="text-secondary small">
                                    Nama Aplikasi
                                </div>
                                <div class="fw-semibold">
                                    Sistem Informasi Pelanggaran Siswa
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-secondary small">
                                    Jenis Aplikasi
                                </div>
                                <div class="fw-semibold">
                                    Website
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-secondary small">
                                    Fokus Sistem
                                </div>
                                <div class="fw-semibold">
                                    Pengelolaan Data Pelanggaran
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-secondary small">
                                    Tujuan
                                </div>
                                <div class="fw-semibold">
                                    Mempermudah pengelolaan data
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="dashboard.php"
                           class="btn text-white rounded-pill px-4"
                           style="background-color: #30318B;">
                            ← Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>

            <p class="text-center text-secondary small mt-4">
                © <?= date('Y'); ?> Sistem Informasi Pelanggaran Siswa
            </p>

        </main>
    </div>
</div>

</body>
</html>