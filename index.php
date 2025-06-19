<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cipta Hospital Indonesia berkomitmen menyediakan layanan kesehatan terbaik. Dapatkan antrian online, konsultasi, dan informasi layanan unggulan kami.">
    <title>Cipta Hospital Indonesia - Melayani dari Hati</title>

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

    <header id="beranda" class="hero"></header>

    <main>
        <section class="brand-showcase">
            <div class="brand-showcase__container">
                <h1 class="brand-showcase__logo">
                    <a href="#beranda">
                        <img src="asset/CiptaHostpitalIndonesia-White.svg" alt="Cipta Hospital Indonesia">
                    </a>
                </h1>
                <p class="brand-showcase__tagline">Melayani dari Hati, Membangkitkan Harapan</p>
            </div>
        </section>

        <section id="tentang" class="about-us">
            <div class="about-us__container">
                <article class="about-us__text">
                    <h2>Tentang Kami</h2>
                    <p>Cipta Hospital Indonesia adalah pilar kesehatan masyarakat yang berdedikasi untuk menyediakan
                        layanan medis dengan standar kualitas tertinggi. Berbekal pengalaman dan inovasi berkelanjutan,
                        kami berkomitmen pada keselamatan dan kenyamanan pasien, serta menghadirkan teknologi medis
                        terdepan untuk Anda dan keluarga.</p>
                </article>
                <figure class="about-us__image">
                    <img src="asset/istockphoto-1312706413-612x612.jpg" alt="Gedung rumah sakit yang modern dan bersih">
                </figure>
            </div>
        </section>

        <section class="services">
            <div class="services__container">
                <h2>Layanan Unggulan Cipta Hospital Indonesia</h2>
                <p>Temukan beragam layanan kesehatan terpadu kami yang didukung oleh tim medis profesional dan teknologi
                    modern untuk penanganan yang akurat dan efektif.</p>
                <ul class="services__list">
                    <li class="services__item">
                        <div class="services__item-header">
                            <div class="services__item-icon"><img src="asset/Medical Heart.png" alt="Ikon Jantung">
                            </div>
                            <p class="services__item-title">Pusat Jantung Terpadu</p>
                        </div>
                        <p class="services__item-description">Penanganan komprehensif untuk kesehatan jantung, dari
                            deteksi dini, kateterisasi, hingga bedah jantung.</p>
                    </li>
                    <li class="services__item">
                        <div class="services__item-header">
                            <div class="services__item-icon"><img src="asset/Maternity.png" alt="Ikon Ibu dan Anak">
                            </div>
                            <p class="services__item-title">Klinik Ibu dan Anak</p>
                        </div>
                        <p class="services__item-description">Layanan lengkap untuk kesehatan ibu hamil, persalinan,
                            serta tumbuh kembang anak bersama dokter spesialis.</p>
                    </li>
                    <li class="services__item">
                        <div class="services__item-header">
                            <div class="services__item-icon"><img src="asset/Surgery.png" alt="Ikon Bedah"></div>
                            <p class="services__item-title">Pusat Ortopedi & Bedah</p>
                        </div>
                        <p class="services__item-description">Solusi modern untuk cedera tulang, sendi, dan tulang
                            belakang serta layanan bedah umum oleh tim ahli.</p>
                    </li>
                    <li class="services__item">
                        <div class="services__item-header">
                            <div class="services__item-icon"><img src="asset/Blood Vessel.png"
                                    alt="Ikon Pembuluh Darah"></div>
                            <p class="services__item-title">Klinik Penyakit Dalam & Saraf</p>
                        </div>
                        <p class="services__item-description">Pemeriksaan dan pengobatan berbagai penyakit kronis, akut,
                            serta gangguan neurologis (saraf).</p>
                    </li>
                </ul>
            </div>
        </section>

        <section class="cta">
            <div class="cta__container">
                <article class="cta__card">
                    <a href="antrian.php" class="cta__button">Ambil Antrian Sekarang <img src="asset/Ticket.png"
                            alt=""></a>
                    <p>Dapatkan nomor antrian untuk layanan rawat jalan dan laboratorium dengan mudah secara online.
                        Nikmati kemudahan akses layanan tanpa harus antre lama di lokasi.</p>
                </article>
                <article class="cta__card">
                    <a href="https://wa.me/6285719692787" class="cta__button">Konsultasi via WhatsApp <img
                            src="asset/WhatsApp.png" alt=""></a>
                    <p>Berkonsultasi dengan dokter terbaik kami kini lebih praktis. Cukup dari rumah, Anda tetap
                        mendapatkan layanan profesional dan terpercaya.</p>
                </article>
            </div>
        </section>

        <section class="partners">
            <div class="partners__container">
                <p class="partners__title">Mitra Kami</p>
                <div class="partners__logos">
                    <img src="asset/unpam.png" alt="Logo Universitas Pamulang">
                    <img src="asset/sasmitajaya.png" alt="Logo Yayasan Sasmita Jaya">
                    <img src="asset/tirta.png" alt="Logo Tirta">
                </div>
            </div>
        </section>

        <section id="faq" class="faq">
            <div class="faq__container">
                <h2>FAQ</h2>
                <p>(Frequently Asked Questions)</p>
                <div class="faq__list">
                    <div class="faq__item">
                        <button class="faq__question" aria-expanded="false" aria-controls="faq-answer-1">
                            <p>Bagaimana cara mengambil nomor antrian rumah sakit secara online?</p>
                            <i class="faq__icon">+</i>
                        </button>
                        <div id="faq-answer-1" class="faq__answer">
                            <p>Setelah masuk, pilih menu "Ambil Antrian", pilih jenis layanan (seperti Klinik Ibu dan
                                Anak atau Pusat Jantung), pilih dokter dan tanggal, lalu klik “Ambil Nomor Antrian”.
                                Tiket antrian Anda akan langsung tersedia di halaman profil.</p>
                        </div>
                    </div>
                    <div class="faq__item">
                        <button class="faq__question" aria-expanded="false" aria-controls="faq-answer-2">
                            <p>Apakah bisa konsultasi dengan dokter tanpa harus datang ke rumah sakit?</p>
                            <i class="faq__icon">+</i>
                        </button>
                        <div id="faq-answer-2" class="faq__answer">
                            <p>Tentu. Kami menyediakan layanan konsultasi online via WhatsApp untuk kemudahan Anda.
                                Silakan klik tombol "Konsultasi via WhatsApp" di atas untuk terhubung dengan tim kami.
                            </p>
                        </div>
                    </div>
                    <div class="faq__item">
                        <button class="faq__question" aria-expanded="false" aria-controls="faq-answer-3">
                            <p>Bagaimana jika saya terlambat datang dari jadwal antrian online?</p>
                            <i class="faq__icon">+</i>
                        </button>
                        <div id="faq-answer-3" class="faq__answer">
                            <p>Kami memberikan toleransi keterlambatan hingga 15 menit dari jadwal Anda. Jika melebihi
                                waktu tersebut, nomor antrian Anda mungkin akan hangus dan perlu mengambil antrian baru.
                                Mohon hadir tepat waktu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer__container">
            <div class="footer__main-content">
                <div class="footer__about">
                    <img src="asset/CiptaHostpitalIndonesia-Black.svg" alt="Logo Cipta Hospital Indonesia Hitam Putih"
                        class="footer__logo">
                    <p>Cipta Hospital Indonesia berdedikasi untuk menjadi mitra kesehatan terpercaya bagi Anda dan
                        keluarga. Kami melayani dengan integritas, profesionalisme, dan kasih.</p>
                </div>
                <div class="footer__contact">
                    <h3>Kontak & Sosial Media</h3>
                    <ul>
                        <li><img src="asset/WhatsApp.svg" alt="Ikon WhatsApp"><a href="https://wa.me/6285719692787">+62
                                857 1969 2787</a></li>
                        <li><img src="asset/Instagram.svg" alt="Ikon Instagram"><a href="#">@ciptahospital.id</a></li>
                        <li><img src="asset/Location.svg" alt="Ikon Lokasi"><a href="#">Jl. Surya Kencana No. 1,
                                Pamulang, Tangerang Selatan</a></li>
                    </ul>
                </div>
                <nav class="footer__quick-links">
                    <h3>Akses Cepat</h3>
                    <ul>
                        <li><a href="index.php#beranda">Beranda</a></li>
                        <li><a href="index.php#tentang">Tentang Kami</a></li>
                        <li><a href="index.php#faq">FAQ</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                           <li><a href="profile.php">Profil Saya</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Masuk / Daftar</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="footer__copyright">
                <p>© 2025 Cipta Hospital Indonesia. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>