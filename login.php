<?php 
    session_start();
    // Jika user sudah login, arahkan ke halaman profil
    if (isset($_SESSION['user_id'])) {
        header('Location: profile.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk & Daftar - Cipta Hospital Indonesia</title>

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
            <div class="auth-tabs">
                <div class="auth-tab auth-tab--active" id="login-tab">MASUK</div>
                <div class="auth-tab" id="register-tab">DAFTAR</div>
            </div>

            <div class="auth-form-container">
                <form id="loginForm" class="auth-form">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" placeholder="Masukkan alamat email Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="login-password" placeholder="Masukkan password Anda" required>
                            <span class="toggle-password"></span>
                        </div>
                    </div>
                   <div class="form-group-inline">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember-me">
                        <label for="remember-me">Ingat Saya</label>
                    </div>
                    <a href="forgot_password.php">Lupa Password?</a> </div>
                    <button type="submit" class="auth-button">MASUK</button>
                </form>

                <form id="registerForm" class="auth-form hidden">
                    <div class="form-group">
                        <label for="register-name">Nama Lengkap</label>
                        <input type="text" id="register-name" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="register-password" placeholder="Buat password yang aman"
                                required>
                            <span class="toggle-password"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="register-phone">Nomor Telepon</label>
                        <input type="tel" id="register-phone" placeholder="Contoh: 08123456789" required>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" placeholder="Masukkan alamat email aktif" required>
                    </div>
                    <button type="submit" class="auth-button">DAFTAR AKUN</button>
                </form>
            </div>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>

</html>