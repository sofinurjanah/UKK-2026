
<?php

session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

$nama = 'Sofi Nurjanah';
$role = strtolower($_SESSION['role'] ?? 'pengguna');

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Me | Sistem Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR: DIPERTAHANKAN -->
        <div class="col-md-3 col-lg-2 min-vh-100 p-3"
             style="background-color: #30318B;">

            <h4 class="text-white mb-4">
                Sistem Pelanggaran
            </h4>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') { ?>

                    <li class="nav-item mb-2">
                        <a href="data_siswa.php" class="nav-link text-white">
                            Data Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_guru.php" class="nav-link text-white">
                            Data Guru
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_kelas.php" class="nav-link text-white">
                            Kelas
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="data_tahun_ajaran.php" class="nav-link text-white">
                            Tahun Ajaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="penempatan_siswa.php" class="nav-link text-white">
                            Penempatan Siswa
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="wali_kelas.php" class="nav-link text-white">
                            Wali Kelas
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="kategori_pelanggaran.php" class="nav-link text-white">
                            Kategori Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="jenis_pelanggaran.php" class="nav-link text-white">
                            Jenis Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="laporan.php" class="nav-link text-white">
                            Laporan
                        </a>
                    </li>

                <?php } ?>

                <?php if ($role == 'guru') { ?>

                    <li class="nav-item mb-2">
                        <a href="catat_pelanggaran.php" class="nav-link text-white">
                            Catat Pelanggaran
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="tindakan.php" class="nav-link text-white">
                            Tindakan
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="riwayat_pelanggaran.php" class="nav-link text-white">
                            Riwayat
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="rekap_poin.php" class="nav-link text-white">
                            Rekap Poin
                        </a>
                    </li>

                <?php } ?>

                <hr class="text-secondary">

                <li class="nav-item mb-2">
                    <a href="about_me.php" class="nav-link active">
                        About Me
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>
        </div>

        <!-- KONTEN ABOUT ME -->
        <main class="col-md-9 col-lg-10 about-page">

            <div class="about-layout">

                
<!-- KARTU PROFIL KIRI -->
<section class="profile-card">

    <div class="profile-photo-wrap">
        <span class="profile-hello">Hello!</span>

        <img src="foto_profil.png"
             alt="Foto Profil <?= htmlspecialchars($nama); ?>"
             class="profile-photo">
    </div>

    <h2 class="profile-name">
        <?= htmlspecialchars($nama); ?>
    </h2>

    <span class="profile-role">
        <?= htmlspecialchars(ucfirst($role)); ?>
    </span>

    <div class="profile-details">
        <p>
            <strong>Nama:</strong>
            <?= htmlspecialchars($nama); ?>
        </p>

        <p>
            <strong>Role:</strong>
            <?= htmlspecialchars(ucfirst($role)); ?>
        </p>
    </div>

    <div class="profile-skills">
        <h3 class="profile-skills-title">
            TECHNICAL SKILLS
        </h3>

        <div class="profile-skill-list">
            <span class="profile-skill">HTML</span>
            <span class="profile-skill">CSS</span>
            <span class="profile-skill">PHP</span>
            <span class="profile-skill">SQL</span>
        </div>
    </div>

</section>


                <!-- INFORMASI KANAN -->
                <section class="about-information">

                    <!-- ABOUT ME -->
                    <div class="about-section">

                        <h3 class="about-heading">
                            ABOUT ME
                        </h3>

                        <div class="about-description">
                            Halo! Saya <?= htmlspecialchars($nama); ?>,
                            pengembang aplikasi Sistem Informasi
                            Pelanggaran Siswa. Aplikasi ini dibuat untuk
                            membantu proses pengelolaan data siswa dan
                            pencatatan pelanggaran agar lebih terstruktur
                            dan mudah digunakan.

                            <br><br>

                            Melalui proyek ini, saya ingin mengembangkan
                            kemampuan dalam membuat aplikasi berbasis web,
                            mulai dari perancangan tampilan hingga
                            pengelolaan data.
                        </div>

                    </div>

                    <!-- INFORMASI PROYEK -->
                    <div class="about-section">

                        <h3 class="about-heading">
                            INFORMASI PROYEK
                        </h3>

                        <div class="about-timeline">

                            <div class="about-timeline-item">

                                <div class="about-timeline-label">
                                    APLIKASI
                                </div>

                                <div>
                                    <h4 class="about-timeline-title">
                                        Sistem Informasi Pelanggaran Siswa
                                    </h4>

                                    <p class="about-timeline-text">
                                        Website untuk membantu pengelolaan
                                        data siswa dan pencatatan
                                        pelanggaran.
                                    </p>
                                </div>

                            </div>

                            <div class="about-timeline-item">

                                <div class="about-timeline-label">
                                    JENIS
                                </div>

                                <div>
                                    <h4 class="about-timeline-title">
                                        Website
                                    </h4>

                                    <p class="about-timeline-text">
                                        Aplikasi berbasis web yang
                                        menggunakan database untuk
                                        menyimpan dan mengelola data.
                                    </p>
                                </div>

                            </div>

                            <div class="about-timeline-item">

                                <div class="about-timeline-label">
                                    FOKUS
                                </div>

                                <div>
                                    <h4 class="about-timeline-title">
                                        Pengelolaan Data Pelanggaran
                                    </h4>

                                    <p class="about-timeline-text">
                                        Membantu proses pengelolaan data
                                        dan pencatatan pelanggaran siswa
                                        secara terstruktur.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- TUJUAN PROYEK -->
                    <div class="about-section">

                        <h3 class="about-heading">
                            TUJUAN PROYEK
                        </h3>

                        <div class="about-project-card">

                            <div class="row g-3">

                                <div class="col-sm-6">
                                    <div class="about-project-item">

                                        <div class="about-project-label">
                                            Pengembangan
                                        </div>

                                        <div class="about-project-value">
                                            Aplikasi Berbasis Web
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="about-project-item">

                                        <div class="about-project-label">
                                            Tujuan
                                        </div>

                                        <div class="about-project-value">
                                            Mempermudah Pengelolaan Data
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

            <p class="about-copyright">
                ©Sofinurjanah
            </p>

        </main>

    </div>
</div>

</body>
</html>
