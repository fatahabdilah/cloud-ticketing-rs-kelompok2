document.addEventListener('DOMContentLoaded', function () {

    const loggedInKey = 'isUserLoggedIn';

    // --- Cek Status Login & Proteksi Halaman ---
    function checkLoginStatus() {
        return sessionStorage.getItem(loggedInKey) === 'true';
    }

    function protectPage() {
        const protectedPages = ['/antrian.html', '/profile.html'];
        const currentPage = window.location.pathname;

        if (protectedPages.some(page => currentPage.endsWith(page)) && !checkLoginStatus()) {
            alert('Anda harus login untuk mengakses halaman ini.');
            window.location.href = 'login.html';
        }
    }

    // --- Update Tampilan UI Berdasarkan Status Login ---
    function updateUI() {
        const isLoggedIn = checkLoginStatus();

        // Elemen Navigasi Guest
        const navGuestDesktop = document.getElementById('nav-guest-desktop');
        const navGuestMobile = document.getElementById('nav-guest-mobile');

        // Elemen Navigasi Authenticated
        const navAuthDesktop = document.getElementById('nav-auth-desktop');
        const navAntrianMobile = document.getElementById('nav-antrian-mobile');
        const navProfileMobile = document.getElementById('nav-profile-mobile');

        // Link di Footer
        const footerAuthLink = document.getElementById('footer-auth-link');

        if (isLoggedIn) {
            // Sembunyikan tombol 'Masuk/Daftar'
            if (navGuestDesktop) navGuestDesktop.classList.add('hidden');
            if (navGuestMobile) navGuestMobile.classList.add('hidden');

            // Tampilkan tombol 'Daftar Antrian' & 'Profil'
            if (navAuthDesktop) navAuthDesktop.classList.remove('hidden');
            if (navAntrianMobile) navAntrianMobile.classList.remove('hidden');
            if (navProfileMobile) navProfileMobile.classList.remove('hidden');

            // Ubah link di footer menjadi 'Profil'
            if (footerAuthLink) {
                footerAuthLink.innerHTML = '<a href="profile.html">Profil</a>';
            }

        } else {
            // Tampilkan tombol 'Masuk/Daftar'
            if (navGuestDesktop) navGuestDesktop.classList.remove('hidden');
            if (navGuestMobile) navGuestMobile.classList.remove('hidden');

            // Sembunyikan tombol 'Daftar Antrian' & 'Profil'
            if (navAuthDesktop) navAuthDesktop.classList.add('hidden');
            if (navAntrianMobile) navAntrianMobile.classList.add('hidden');
            if (navProfileMobile) navProfileMobile.classList.add('hidden');

            // Pastikan link di footer adalah 'Masuk/Daftar'
            if (footerAuthLink) {
                footerAuthLink.innerHTML = '<a href="login.html">Masuk/Daftar</a>';
            }
        }
    }


    // --- FAQ Accordion ---
    const faqItems = document.querySelectorAll('.faq__item');
    if (faqItems.length > 0) {
        faqItems.forEach(item => {
            const button = item.querySelector('.faq__question');
            const answer = item.querySelector('.faq__answer');

            button.addEventListener('click', () => {
                const isActive = item.classList.contains('faq__item--active');

                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('faq__item--active');
                    otherItem.querySelector('.faq__answer').style.maxHeight = '0px';
                    otherItem.querySelector('.faq__question').setAttribute('aria-expanded', 'false');
                });

                if (!isActive) {
                    item.classList.add('faq__item--active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    button.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }


    // --- Scrollspy untuk Navbar Links ---
    const sections = document.querySelectorAll('header[id], section[id]');
    const menuLinks = document.querySelectorAll('.navbar__menu-link');

    function highlightMenu() {
        let current = '';
        const navHeight = 80;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (window.pageYOffset >= sectionTop - navHeight) {
                current = section.getAttribute('id');
            }
        });

        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').substring(1) === `#${current}`) {
                link.classList.add('active');
            }
        });
    }

    if (menuLinks.length > 0 && sections.length > 0) {
        window.addEventListener('scroll', highlightMenu);
        window.addEventListener('load', highlightMenu);
    }


    // --- Form Handlers ---
    // Handler untuk Tab di Halaman Login
    const loginTab = document.getElementById('login-tab');
    if (loginTab) {
        const registerTab = document.getElementById('register-tab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginTab.addEventListener('click', () => {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('auth-tab--active');
            registerTab.classList.remove('auth-tab--active');
        });

        registerTab.addEventListener('click', () => {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            loginTab.classList.remove('auth-tab--active');
            registerTab.classList.add('auth-tab--active');
        });

        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();
            // Simulasi login berhasil
            sessionStorage.setItem(loggedInKey, 'true');
            alert('Login berhasil! Mengarahkan ke halaman profil...');
            window.location.href = 'profile.html';
        });

        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();
            alert('Pendaftaran berhasil! Silakan login. (Pesan demo)');
            // Arahkan ke tab login setelah daftar
            loginTab.click();
        });
    }

    // Handler untuk Form Profil & Tombol Logout
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const newPassword = document.getElementById('profile-new-password').value;
            const confirmPassword = document.getElementById('profile-confirm-password').value;

            if (newPassword && (newPassword !== confirmPassword)) {
                alert('Konfirmasi password baru tidak cocok!');
                return;
            }
            alert('Profil berhasil diperbarui! (Pesan demo)');
        });

        const logoutButton = document.getElementById('logoutButton');
        if (logoutButton) {
            logoutButton.addEventListener('click', () => {
                sessionStorage.removeItem(loggedInKey);
                alert('Anda telah logout.');
                window.location.href = 'index.html';
            });
        }
    }

    // Handler untuk Form Antrian
    const queueForm = document.getElementById('queueForm');
    if (queueForm) {
        queueForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const service = document.getElementById('queue-service').value;
            const doctor = document.getElementById('queue-doctor').value;
            const date = document.getElementById('queue-date').value;

            const queueNumber = `${service.charAt(0)}-${Math.floor(100 + Math.random() * 900)}`;

            alert(`Pendaftaran antrian berhasil!\n\nNomor Antrian: ${queueNumber}\nLayanan: ${service}\nDokter: ${doctor}\nTanggal: ${date}\n\nTiket Anda akan muncul di halaman profil. (Pesan demo)`);
            // Idealnya, tiket ini disimpan dan ditampilkan di halaman profil.
            // Untuk demo ini, kita hanya redirect ke profil.
            window.location.href = 'profile.html';
        });
    }

    // --- Inisialisasi ---
    // Jalankan fungsi-fungsi utama saat halaman dimuat
    protectPage();
    updateUI();
});