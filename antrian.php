<?php 
    session_start();
    // Jika user belum login, tendang ke halaman login
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Antrian - Cipta Hospital Indonesia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar">
    <div class="navbar__container">
        <a href="index.php" class="navbar__brand">
            <img src="asset/Cipta Hospital Indonesi-Blue & Black.svg" alt="Logo Cipta Hospital Indonesia">
        </a>

        <input type="checkbox" id="burger-menu" class="navbar__burger-checkbox" hidden>
        <label class="navbar__burger-label" for="burger-menu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </label>

        <ul class="navbar__menu">
            <li><a href="index.php#beranda" class="navbar__menu-link">Beranda</a></li>
            <li><a href="index.php#tentang" class="navbar__menu-link">Tentang Kami</a></li>
            <li><a href="index.php#faq" class="navbar__menu-link">FAQ</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="navbar__menu-button--mobile">
                    <a href="antrian.php" class="navbar__menu-button-link">AMBIL ANTRIAN</a>
                </li>
                <li class="navbar__menu-button--mobile">
                    <a href="profile.php" class="navbar__button--profile" title="Profil Pengguna">
                        <img src="asset/User.svg" alt="Profil">
                    </a>
                </li>
            <?php else: ?>
                <li class="navbar__menu-button--mobile">
                    <a href="login.php" class="navbar__menu-button-link">MASUK / DAFTAR</a>
                </li>
            <?php endif; ?>
        </ul>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div id="nav-auth-desktop" class="navbar__auth-buttons">
                <a href="antrian.php" class="navbar__button--desktop">AMBIL ANTRIAN</a>
                <a href="profile.php" class="navbar__button--profile" title="Profil Pengguna">
                    <img src="asset/User.svg" alt="Profil">
                </a>
            </div>
        <?php else: ?>
            <a id="nav-guest-desktop" href="login.php" class="navbar__button--desktop">MASUK / DAFTAR</a>
        <?php endif; ?>
    </div>
</nav>

    <main class="page-background--form">
        <div class="auth-container">
            <div class="form-header">
                <h2>Ambil Nomor Antrian</h2>
            </div>

            <div class="auth-form-container">
                <form id="queueForm" class="auth-form">
                    <div class="form-group">
                        <label for="queue-service">Pilih Poli / Layanan</label>
                        <select id="queue-service" required>
                            <option value="" disabled selected>-- Memuat layanan... --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="queue-doctor">Pilih Dokter</label>
                        <select id="queue-doctor" required disabled>
                            <option value="" disabled selected>-- Pilih layanan terlebih dahulu --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="queue-date">Pilih Tanggal Kunjungan</label>
                        <input type="date" id="queue-date" required>
                    </div>

                    <div class="form-group">
                        <label for="queue-time">Pilih Jam Kunjungan</label>
                        <select id="queue-time" required>
                            <option value="" disabled selected>-- Pilih jam --</option>
                            <?php
                                // Daftar jam praktek yang sudah ditentukan
                                // Anda bisa mengubah daftar ini sesuai kebutuhan
                                $jam_praktek = [
                                    '09:00', '09:30', '10:00', '10:30', // Sesi Pagi
                                    '13:00', '13:30', '14:00', '14:30'  // Sesi Siang/Sore
                                ];

                                foreach ($jam_praktek as $jam) {
                                    echo "<option value='{$jam}:00'>Pukul {$jam}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="auth-button">Ambil Nomor Antrian</button>
                </form>
            </div>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>

</html>