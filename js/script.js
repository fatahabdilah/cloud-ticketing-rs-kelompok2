document.addEventListener('DOMContentLoaded', function () {

    // --- FAQ Accordion ---
    const faqItems = document.querySelectorAll('.faq__item');

    faqItems.forEach(item => {
        const button = item.querySelector('.faq__question');
        const answer = item.querySelector('.faq__answer');
        const icon = item.querySelector('.faq__icon');

        button.addEventListener('click', () => {
            const isActive = item.classList.contains('faq__item--active');

            // Close all other items
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('faq__item--active');
                otherItem.querySelector('.faq__answer').style.maxHeight = '0px';
                otherItem.querySelector('.faq__icon').textContent = '+';
                otherItem.querySelector('.faq__question').setAttribute('aria-expanded', 'false');
            });

            // Open the clicked item if it wasn't active
            if (!isActive) {
                item.classList.add('faq__item--active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.textContent = '−';
                button.setAttribute('aria-expanded', 'true');
            }
        });
    });


    // --- Scrollspy for Navbar Links ---
    const sections = document.querySelectorAll('header[id], section[id]');
    const menuLinks = document.querySelectorAll('.navbar__menu-link');

    function highlightMenu() {
        let current = '';
        const navHeight = 80; // height of the navbar

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - navHeight) {
                current = section.getAttribute('id');
            }
        });

        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', highlightMenu);
    window.addEventListener('load', highlightMenu);

});