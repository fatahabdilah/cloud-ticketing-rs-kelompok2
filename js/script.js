document.addEventListener('DOMContentLoaded', function () {

    // --- FAQ Accordion ---
    const faqItems = document.querySelectorAll('.faq__item');

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


    // --- Scrollspy for Navbar Links ---
    const sections = document.querySelectorAll('header[id], section[id]');
    const menuLinks = document.querySelectorAll('.navbar__menu-link');

    function highlightMenu() {
        let current = '';
        const navHeight = 80;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - navHeight) {
                current = section.getAttribute('id');
            }
        });

        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').substring(1) === current) {
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
            alert('Login berhasil! Mengarahkan ke halaman profil...');
            window.location.href = 'profile.html';
        });

        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();
            alert('Pendaftaran berhasil! Silakan login. (Pesan demo)');
        });
    }

    // Handler untuk Form Profil
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
    }

    // Handler untuk Form Antrian
    const queueForm = document.getElementById('queueForm');
    if (queueForm) {
        queueForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const service = document.getElementById('queue-service').value;
            const doctor = document.getElementById('queue-doctor').value; // FEEDBACK: Mengambil data dokter
            const date = document.getElementById('queue-date').value;

            const queueNumber = `${service.charAt(0)}-${Math.floor(100 + Math.random() * 900)}`;

            // FEEDBACK: Menambahkan nama dokter di pesan alert
            alert(`Pendaftaran antrian berhasil!\n\nNomor Antrian: ${queueNumber}\nLayanan: ${service}\nDokter: ${doctor}\nTanggal: ${date}\n\nTiket Anda akan muncul di halaman profil. (Pesan demo)`);
        });
    }

});