document.addEventListener('DOMContentLoaded', function () {

    // --- FAQ Accordion ---
    const faqItems = document.querySelectorAll('.faq__item');

    faqItems.forEach(item => {
        const button = item.querySelector('.faq__question');
        const answer = item.querySelector('.faq__answer');

        button.addEventListener('click', () => {
            const isActive = item.classList.contains('faq__item--active');

            // Selalu tutup semua item terlebih dahulu
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('faq__item--active');
                otherItem.querySelector('.faq__answer').style.maxHeight = '0px';
                otherItem.querySelector('.faq__question').setAttribute('aria-expanded', 'false');
            });

            // FEEDBACK [FIX]: Logika disederhanakan.
            // Jika item yang diklik tidak aktif, buka item tersebut.
            if (!isActive) {
                item.classList.add('faq__item--active');
                // Dengan padding yang sudah diatur di CSS, scrollHeight akan memberikan nilai yang benar.
                answer.style.maxHeight = answer.scrollHeight + 'px';
                button.setAttribute('aria-expanded', 'true');
            }
            // Jika item sudah aktif (diklik lagi), loop di atas sudah menanganinya (menutupnya).
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


    // --- Logika untuk Tab di Halaman Login ---
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginTab && registerTab && loginForm && registerForm) {
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
            alert('Login berhasil! (Ini adalah pesan demo)');
        });

        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();
            alert('Pendaftaran berhasil! Silakan cek email Anda. (Ini adalah pesan demo)');
        });
    }
});