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
    <title>Profil Pengguna - Cipta Hospital Indonesia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="profile-page">

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
                <h2>Profil Saya</h2>
            </div>

            <div class="profile-layout-desktop">

                <div class="auth-form-container">
                    <form id="profileForm" class="auth-form">
                        <div class="form-group">
                            <label for="profile-name">Nama Lengkap</label>
                            <input type="text" id="profile-name" value="Memuat..." required>
                        </div>
                        <div class="form-group">
                            <label for="profile-phone">Nomor Telepon</label>
                            <input type="tel" id="profile-phone" value="Memuat..." required>
                        </div>
                        <div class="form-group">
                            <label for="profile-email">Email</label>
                            <input type="email" id="profile-email" value="Memuat..." required>
                        </div>

                        <hr class="form-divider">

                        <div id="changePasswordBtnContainer">
                            <button type="button" id="showPasswordFieldsBtn"
                                class="auth-button auth-button--secondary">Ubah Password</button>
                        </div>

                        <div id="passwordChangeSection" class="hidden">
                            <div class="form-group">
                                <label for="profile-new-password">Password Baru</label>
                                <div class="password-wrapper">
                                    <input type="password" id="profile-new-password"
                                        placeholder="Isi password baru yang aman">
                                    <span class="toggle-password"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="profile-confirm-password">Konfirmasi Password Baru</label>
                                <div class="password-wrapper">
                                    <input type="password" id="profile-confirm-password"
                                        placeholder="Ketik ulang password baru Anda">
                                    <span class="toggle-password"></span>
                                </div>
                            </div>
                            <button type="button" id="cancelPasswordChangeBtn"
                                class="auth-button-link auth-button-link--danger">Batal</button>
                        </div>
                        <button type="submit" class="auth-button">Simpan Perubahan</button>
                        <button type="button" id="logoutButton" class="auth-button auth-button--danger">Keluar</button>
                    </form>
                </div>

                <div class="ticket-section">
                    <h3 class="ticket-section-title">Tiket Antrian Anda</h3>
                    <div id="ticket-list" class="ticket-container">
                        <div class="no-tickets">Memuat tiket...</div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <script src="js/script.js"></script>
</body>

</html>