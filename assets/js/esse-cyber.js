(function () {
    'use strict';

    function updateClock() {
        const clock = document.getElementById('cyber-clock');
        if (!clock) return;

        const now = new Date();
        const pad = value => String(value).padStart(2, '0');
        clock.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
    }

    updateClock();
    if (document.getElementById('cyber-clock')) {
        setInterval(updateClock, 1000);
    }

    const scrollProgress = document.getElementById('cyber-scroll-progress');
    function updateScrollProgress() {
        if (!scrollProgress) return;

        const max = document.documentElement.scrollHeight - window.innerHeight;
        const progress = max > 0 ? Math.min(window.scrollY / max, 1) : 0;
        scrollProgress.style.transform = 'scaleX(' + progress + ')';
    }

    updateScrollProgress();
    document.addEventListener('scroll', updateScrollProgress, { passive: true });
    window.addEventListener('resize', updateScrollProgress);

    const userToggle = document.getElementById('cyber-user-toggle');
    document.addEventListener('click', function (event) {
        if (event.target.closest('[data-cyber-back]')) {
            event.preventDefault();
            history.back();
            return;
        }

        if (!userToggle) return;

        const toggle = event.target.closest('[data-cyber-user-toggle]');
        if (toggle === userToggle) {
            event.stopPropagation();
            userToggle.classList.toggle('open');
            return;
        }

        if (event.target.closest('.cyber-user-menu')) {
            event.stopPropagation();
            return;
        }

        userToggle.classList.remove('open');
    });

    userToggle?.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            userToggle.classList.toggle('open');
        }
    });

    document.querySelector('#navbar-login-form[data-cyber-login-failed] input[name="password"]')?.focus();

    const menuBtn = document.getElementById('cyber-menu-btn');
    const nav = document.getElementById('cyber-nav');
    const navClose = document.getElementById('cyber-nav-close');
    const mobileNav = window.matchMedia('(max-width: 768px)');

    function openNav() {
        if (!nav || !menuBtn) return;

        nav.classList.add('open');
        menuBtn.setAttribute('aria-expanded', 'true');
        document.body.classList.add('nav-open');
        navClose?.focus();
    }

    function closeNav() {
        if (!nav || !menuBtn) return;

        nav.classList.remove('open');
        nav.querySelectorAll('.cyber-dropdown.open').forEach(function (dropdown) {
            dropdown.classList.remove('open');
            dropdown.querySelector('.cyber-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
        menuBtn.focus();
    }

    menuBtn?.addEventListener('click', openNav);
    navClose?.addEventListener('click', closeNav);
    nav?.addEventListener('click', function (event) {
        const dropdownToggle = event.target.closest('.cyber-dropdown-toggle');
        if (!dropdownToggle || !nav.contains(dropdownToggle) || !mobileNav.matches) return;

        event.preventDefault();
        const dropdown = dropdownToggle.closest('.cyber-dropdown');
        if (!dropdown) return;

        dropdown.classList.toggle('open');
        dropdownToggle.setAttribute('aria-expanded', dropdown.classList.contains('open') ? 'true' : 'false');
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && nav?.classList.contains('open')) {
            closeNav();
        }
    });

    const footerMenu = document.querySelector('.cyber-footer-menu');
    const footerGroups = document.querySelectorAll('.cyber-footer-group');
    const mobileFooter = window.matchMedia('(max-width: 768px)');

    function syncFooterAccordions() {
        footerGroups.forEach(function (group) {
            const heading = group.querySelector('.cyber-footer-heading');
            if (!heading) return;

            if (!mobileFooter.matches) {
                group.classList.remove('open');
                heading.disabled = true;
                heading.setAttribute('aria-expanded', 'true');
                return;
            }

            heading.disabled = false;
            heading.setAttribute('aria-expanded', group.classList.contains('open') ? 'true' : 'false');
        });
    }

    footerMenu?.addEventListener('click', function (event) {
        const heading = event.target.closest('.cyber-footer-heading');
        if (!heading || !footerMenu.contains(heading) || !mobileFooter.matches) return;

        event.preventDefault();
        const group = heading.closest('.cyber-footer-group');
        if (!group) return;

        group.classList.toggle('open');
        heading.setAttribute('aria-expanded', group.classList.contains('open') ? 'true' : 'false');
    });
    mobileFooter.addEventListener?.('change', syncFooterAccordions);
    syncFooterAccordions();
})();
