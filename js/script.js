document.addEventListener('DOMContentLoaded', function () {

    // --- FUNGSI GLOBAL ---
    async function apiRequest(url, options = {}) {
        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }
            // Cek jika response punya body sebelum parsing JSON
            const text = await response.text();
            return text ? JSON.parse(text) : {};
        } catch (error) {
            console.error('API Request Error:', error);
            alert(`Terjadi kesalahan: ${error.message}`);
            throw error;
        }
    }


    // --- FUNGSI UNTUK SETIAP HALAMAN ---

    function handleAuthForms() {
        const loginTab = document.getElementById('login-tab');
        const registerTab = document.getElementById('register-tab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        if (!loginTab) return;

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

        loginForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            try {
                const data = await apiRequest('api/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                alert(data.message);
                window.location.href = 'profile.php';
            } catch (error) { }
        });

        registerForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const name = document.getElementById('register-name').value;
            const password = document.getElementById('register-password').value;
            const phone = document.getElementById('register-phone').value;
            const email = document.getElementById('register-email').value;

            try {
                const data = await apiRequest('api/auth/register.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, password, phone, email })
                });
                alert(data.message);
                loginTab.click();
                registerForm.reset();
            } catch (error) { }
        });
    }

    async function handleQueueForm() {
        const queueForm = document.getElementById('queueForm');
        if (!queueForm) return;

        const serviceSelect = document.getElementById('queue-service');
        const doctorSelect = document.getElementById('queue-doctor');
        const dateInput = document.getElementById('queue-date');
        const timeInput = document.getElementById('queue-time');

        dateInput.min = new Date().toISOString().split("T")[0];

        try {
            const services = await apiRequest('api/data/get_services.php');
            serviceSelect.innerHTML = '<option value="" disabled selected>-- Pilih jenis layanan --</option>';
            services.forEach(service => {
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.nama_layanan;
                serviceSelect.appendChild(option);
            });
        } catch (error) {
            serviceSelect.innerHTML = '<option value="" disabled selected>Gagal memuat layanan</option>';
        }

        serviceSelect.addEventListener('change', async () => {
            const serviceId = serviceSelect.value;
            doctorSelect.innerHTML = '<option value="" disabled selected>-- Memuat dokter... --</option>';
            doctorSelect.disabled = true;

            if (!serviceId) return;

            try {
                const doctors = await apiRequest(`api/data/get_doctors.php?id_layanan=${serviceId}`);
                doctorSelect.innerHTML = '<option value="" disabled selected>-- Pilih dokter yang tersedia --</option>';
                if (doctors.length > 0) {
                    doctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.textContent = `${doctor.nama_dokter} (${doctor.spesialisasi})`;
                        doctorSelect.appendChild(option);
                    });
                    doctorSelect.disabled = false;
                } else {
                    doctorSelect.innerHTML = '<option value="" disabled selected>-- Tidak ada dokter tersedia --</option>';
                }
            } catch (error) {
                doctorSelect.innerHTML = '<option value="" disabled selected>Gagal memuat dokter</option>';
            }
        });

        queueForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const service = serviceSelect.value;
            const doctor = doctorSelect.value;
            const date = dateInput.value;
            const time = timeInput.value;

            if (!service || !doctor || !date || !time) {
                alert('Harap lengkapi semua field, termasuk tanggal dan jam!');
                return;
            }

            try {
                const data = await apiRequest('api/user/create_ticket.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ service, doctor, date, time })
                });
                alert(`Pendaftaran antrian berhasil.\n\nNomor Antrian Anda: ${data.queueNumber}\nTiket telah ditambahkan ke halaman profil Anda.`);
                window.location.href = 'profile.php';
            } catch (error) { }
        });
    }

    async function handleProfilePage() {
        const profileForm = document.getElementById('profileForm');
        if (!profileForm) return;

        // Event listener untuk pembatalan tiket
        const ticketListContainer = document.getElementById('ticket-list');
        if (ticketListContainer) {
            ticketListContainer.addEventListener('click', async function (event) {
                if (event.target.classList.contains('ticket-cancel-btn')) {
                    const ticketId = event.target.dataset.ticketId;
                    const isConfirmed = confirm(`Apakah Anda yakin ingin membatalkan tiket dengan nomor antrian ${ticketId}?`);

                    if (isConfirmed) {
                        try {
                            const result = await apiRequest('api/user/cancel_ticket.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ nomor_antrian: ticketId })
                            });
                            alert(result.message);
                            renderTickets(); // Muat ulang daftar tiket untuk menampilkan status baru
                        } catch (error) {
                            // Pesan error sudah ditampilkan oleh apiRequest
                        }
                    }
                }
            });
        }


        try {
            const profile = await apiRequest('api/user/get_profile.php');
            document.getElementById('profile-name').value = profile.nama_lengkap;
            document.getElementById('profile-phone').value = profile.no_telepon;
            document.getElementById('profile-email').value = profile.email;
        } catch (error) {
            alert('Gagal memuat data profil. Silakan coba lagi.');
        }

        profileForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const name = document.getElementById('profile-name').value;
            const phone = document.getElementById('profile-phone').value;
            const email = document.getElementById('profile-email').value;
            const newPassword = document.getElementById('profile-new-password').value;
            const confirmPassword = document.getElementById('profile-confirm-password').value;

            if (newPassword && (newPassword !== confirmPassword)) {
                alert('Konfirmasi password baru tidak cocok. Silakan coba lagi.');
                return;
            }

            try {
                const data = await apiRequest('api/user/update_profile.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, phone, email, newPassword })
                });
                alert(data.message);
                if (newPassword) {
                    document.getElementById('profile-new-password').value = '';
                    document.getElementById('profile-confirm-password').value = '';
                    document.getElementById('cancelPasswordChangeBtn').click();
                }
            } catch (error) { }
        });

        const logoutButton = document.getElementById('logoutButton');
        if (logoutButton) {
            logoutButton.addEventListener('click', async () => {
                try {
                    const data = await apiRequest('api/auth/logout.php');
                    alert(data.message);
                    window.location.href = 'index.php';
                } catch (error) { }
            });
        }
    }

    async function renderTickets() {
        const ticketListContainer = document.getElementById('ticket-list');
        if (!ticketListContainer) return;

        ticketListContainer.innerHTML = '<div class="no-tickets">Memuat tiket...</div>';

        try {
            const tickets = await apiRequest('api/user/get_tickets.php');

            if (tickets.length === 0) {
                ticketListContainer.innerHTML = '<div class="no-tickets">Anda belum memiliki tiket antrian.</div>';
                return;
            }

            ticketListContainer.innerHTML = '';
            tickets.forEach(ticket => {
                const statusClass = `status--${ticket.status.toLowerCase()}`;

                // === PENAMBAHAN KODE: TOMBOL BATALKAN ===
                // Tampilkan tombol "Batalkan" hanya jika status tiket adalah 'Menunggu'
                const cancelButtonHTML = ticket.status === 'Menunggu'
                    ? `<div class="ticket-footer">
                           <button class="ticket-cancel-btn" data-ticket-id="${ticket.nomor_antrian}">Batalkan Tiket</button>
                       </div>`
                    : '';

                const ticketCardHTML = `
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <span class="ticket-queue-number">${ticket.nomor_antrian}</span>
                            <span class="ticket-status ${statusClass}">${ticket.status}</span>
                        </div>
                        <div class="ticket-body">
                            <p class="ticket-schedule">
                                ${new Date(ticket.tanggal_kunjungan + 'T00:00:00').toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                                <br>
                                Pukul ${ticket.jam_kunjungan}
                            </p>
                            <p><strong>Layanan:</strong> ${ticket.nama_layanan}</p>
                            <p><strong>Dokter:</strong> ${ticket.nama_dokter} (${ticket.spesialisasi})</p>
                        </div>
                        ${cancelButtonHTML}
                    </div>
                `;
                ticketListContainer.innerHTML += ticketCardHTML;
            });

        } catch (error) {
            ticketListContainer.innerHTML = '<div class="no-tickets">Gagal memuat tiket antrian. Silakan coba refresh halaman.</div>';
        }
    }


    // --- FUNGSI UTILITAS UI ---

    function setupFaq() {
        const faqItems = document.querySelectorAll('.faq__item');
        if (faqItems.length === 0) return;

        faqItems.forEach(item => {
            const button = item.querySelector('.faq__question');
            button.addEventListener('click', () => {
                const answer = item.querySelector('.faq__answer');
                const isActive = item.classList.toggle('faq__item--active');

                if (isActive) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                } else {
                    answer.style.maxHeight = '0px';
                }
            });
        });
    }

    function setupPasswordToggle() {
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const passwordInput = icon.previousElementSibling;
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.add('visible');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('visible');
                }
            });
        });
    }

    function setupProfilePasswordToggle() {
        const showBtn = document.getElementById('showPasswordFieldsBtn');
        const btnContainer = document.getElementById('changePasswordBtnContainer');
        const passwordSection = document.getElementById('passwordChangeSection');
        const cancelBtn = document.getElementById('cancelPasswordChangeBtn');

        if (showBtn && btnContainer && passwordSection && cancelBtn) {
            showBtn.addEventListener('click', () => {
                passwordSection.classList.remove('hidden');
                btnContainer.classList.add('hidden');
            });

            cancelBtn.addEventListener('click', () => {
                passwordSection.classList.add('hidden');
                btnContainer.classList.remove('hidden');
                document.getElementById('profile-new-password').value = '';
                document.getElementById('profile-confirm-password').value = '';
            });
        }
    }

    function setupScrollspy() {
        const sections = document.querySelectorAll('section[id], header[id]');
        const navLinks = document.querySelectorAll('.navbar__menu a.navbar__menu-link');

        if (sections.length === 0 || navLinks.length === 0) {
            return;
        }

        const onScroll = () => {
            const scrollY = window.pageYOffset;
            let currentSectionId = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.offsetHeight;

                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                const linkId = link.getAttribute('href').split('#')[1];
                if (linkId === currentSectionId) {
                    link.classList.add('active');
                }
            });
        };

        window.addEventListener('scroll', onScroll);
        window.addEventListener('load', onScroll);
    }


    // --- INISIALISASI ---
    setupFaq();
    setupPasswordToggle();
    setupProfilePasswordToggle();
    setupScrollspy();

    handleAuthForms();
    handleQueueForm();
    handleProfilePage();
    renderTickets();
});