<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Cipta Hospital Indonesia</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.php" class="navbar__brand">
                <img src="asset/Cipta Hospital Indonesi-Blue & Black.svg" alt="Logo Cipta Hospital Indonesia">
            </a>
            <a href="login.php" class="navbar__menu-button-link">KEMBALI KE LOGIN</a>
        </div>
    </nav>
    <main class="page-background--form">
        <div class="auth-container">
            <div class="form-header">
                <h2>Buat Password Baru</h2>
            </div>
            <div class="auth-form-container">
                <form id="resetPasswordForm" class="auth-form">
                    <input type="hidden" id="reset-token" name="token">
                    <div class="form-group">
                        <label for="new-password">Password Baru</label>
                        <input type="password" id="new-password" placeholder="Masukkan password baru" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password Baru</label>
                        <input type="password" id="confirm-password" placeholder="Ketik ulang password baru" required>
                    </div>
                    <button type="submit" class="auth-button">Simpan Password Baru</button>
                    <div id="form-message" style="margin-top: 15px; text-align: center; font-weight: 600;"></div>
                </form>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = new URLSearchParams(window.location.search).get('token');
            if (token) {
                document.getElementById('reset-token').value = token;
            } else {
                document.getElementById('form-message').textContent = 'Token tidak valid atau tidak ditemukan.';
                document.querySelector('button').disabled = true;
            }
        });

        document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const token = document.getElementById('reset-token').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const messageDiv = document.getElementById('form-message');
            const submitButton = this.querySelector('button');

            if (newPassword !== confirmPassword) {
                messageDiv.textContent = 'Password dan konfirmasi password tidak cocok.';
                messageDiv.style.color = 'red';
                return;
            }
            
            messageDiv.textContent = 'Memproses...';
            messageDiv.style.color = 'black';
            submitButton.disabled = true;

            try {
                const response = await fetch('api/auth/handle_reset_password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token, newPassword, confirmPassword })
                });
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
                messageDiv.textContent = data.message + ' Anda akan diarahkan ke halaman login.';
                messageDiv.style.color = 'green';
                setTimeout(() => { window.location.href = 'login.php' }, 3000);
            } catch (error) {
                messageDiv.textContent = error.message;
                messageDiv.style.color = 'red';
                submitButton.disabled = false;
            }
        });
    </script>
</body>
</html>