<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Cipta Hospital Indonesia</title>
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
                <h2>Lupa Password</h2>
                <p style="color: #eee; font-size: 0.9em; padding-top: 5px;">Masukkan email Anda untuk menerima link reset password.</p>
            </div>
            <div class="auth-form-container">
                <form id="forgotPasswordForm" class="auth-form">
                    <div class="form-group">
                        <label for="reset-email">Email</label>
                        <input type="email" id="reset-email" placeholder="Masukkan alamat email terdaftar" required>
                    </div>
                    <button type="submit" class="auth-button">Kirim Link Reset</button>
                    <div id="form-message" style="margin-top: 15px; text-align: center; font-weight: 600;"></div>
                </form>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('reset-email').value;
            const messageDiv = document.getElementById('form-message');
            const submitButton = this.querySelector('button');

            messageDiv.textContent = 'Mengirim...';
            messageDiv.style.color = 'black';
            submitButton.disabled = true;

            try {
                const response = await fetch('api/auth/forgot_password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan pada server');
                }
                
                messageDiv.innerHTML = '';
                const pMessage = document.createElement('p');
                pMessage.textContent = data.message;
                messageDiv.appendChild(pMessage);

                if (data.reset_link) {
                    const aLink = document.createElement('a');
                    aLink.href = data.reset_link;
                    aLink.textContent = data.reset_link;
                    aLink.target = '_blank';
                    aLink.style.display = 'block';
                    aLink.style.marginTop = '10px';
                    aLink.style.wordBreak = 'break-all';
                    aLink.style.color = '#054FA9';
                    messageDiv.appendChild(aLink);
                }
                
                messageDiv.style.color = 'green';
            } catch (error) {
                messageDiv.textContent = error.message;
                messageDiv.style.color = 'red';
            } finally {
                submitButton.disabled = false;
            }
        });
    </script>
</body>
</html>