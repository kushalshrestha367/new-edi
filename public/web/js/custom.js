// ── Page Loader ──────────────────────────────────
window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('loader').classList.add('hidden');
    }, 600);
});

// nav
document.addEventListener('DOMContentLoaded', function () {
    const offcanvas = document.getElementById('offcanvasHeader');

    if (offcanvas) {
        const navLinks = offcanvas.querySelectorAll('.navbar-nav a');

        offcanvas.addEventListener('show.bs.offcanvas', function () {
            navLinks.forEach(link => {
                link.classList.remove('py-2', 'px-3', 'rounded-pill');

                link.classList.add('text-dark', 'fw-medium', 'px-2');

                if (link.classList.contains('dropdown-item')) {
                    link.classList.add('dropdown-item');
                }
            });
        });

        offcanvas.addEventListener('hidden.bs.offcanvas', function () {
            navLinks.forEach(link => {
                // If it is NOT a dropdown-item, reset its styling to default
                if (!link.classList.contains('dropdown-item')) {
                    link.classList.remove('text-dark', 'fw-medium', 'px-2');
                    link.classList.add('py-2', 'px-3', 'rounded-pill');
                }
            });
        });
    }
});

$(function () {

    // Header Scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 60) {
            $("header").addClass("fixed-header logo-shrink");
        } else {
            $("header").removeClass("fixed-header logo-shrink");
        }
    });

    $(document).ready(function () {
        const header = $("header");
        let lastScrollTop = 0;

        function handleScroll() {
            let scrollTop = $(window).scrollTop();

            // 1. Logic for shrinking/fixing header
            if (scrollTop >= 60) {
                header.addClass("fixed-header logo-shrink");
            } else {
                header.removeClass("fixed-header logo-shrink");
            }

            // 2. Logic for hiding/showing header on direction
            if (scrollTop > 60) {
                if (scrollTop > lastScrollTop) {
                    // Scrolling DOWN
                    header.addClass("hide-header");
                } else {
                    // Scrolling UP
                    header.removeClass("hide-header");
                }
            } else {
                // At the top
                header.removeClass("hide-header");
            }

            lastScrollTop = scrollTop;
        }

        // Run on scroll
        $(window).scroll(handleScroll);

        // Run on page load/refresh
        handleScroll();
    });

    const toggles = document.getElementsByClassName('searchToggle');

    for (let i = 0; i < toggles.length; i++) {
        toggles[i].addEventListener('click', function () {
            const form = document.getElementById('searchForm');
            form.classList.toggle('d-none');

            const input = form.querySelector('input');
            if (!form.classList.contains('d-none')) {
                input.focus();
            }
        });
    }

    // Tooltip
    const tooltipTriggerList = Array.from(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach((tooltipTriggerEl) => {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });


    // Count
    $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });


    // ScrollToTop
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    const btn = document.getElementById("scrollToTopBtn");
    btn.addEventListener("click", scrollToTop);

    window.onscroll = function () {
        const btn = document.getElementById("scrollToTopBtn");
        if (document.documentElement.scrollTop > 100 || document.body.scrollTop > 100) {
            btn.style.display = "flex";
        } else {
            btn.style.display = "none";
        }
    };


    // Aos
    AOS.init({
        once: true,
    });


    // Scroll
    const sections = document.querySelectorAll("section[id]");

    window.addEventListener("scroll", navHighlighter);

    function navHighlighter() {

        let scrollY = window.pageYOffset;

        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 100;
            sectionId = current.getAttribute("id");

            if (
                scrollY > sectionTop &&
                scrollY <= sectionTop + sectionHeight
            ) {
                document.querySelector(".navbar-collapse a[href*=" + sectionId + "]").classList.add("active");
            } else {
                document.querySelector(".navbar-collapse a[href*=" + sectionId + "]").classList.remove("active");
            }
        });
    }

    // ── Video Modal ───────────────────────────────────
    const videoModal = document.getElementById('videoModal');
    const ytPlayer = document.getElementById('ytPlayer');

    videoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const videoId = button.dataset.url;

        ytPlayer.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
    });

    videoModal.addEventListener('hidden.bs.modal', function () {
        ytPlayer.src = '';
    });
});

// message
const msgFrom = new Swiper('#msgFrom', {
    loop: true,
    autoplay: { delay: 6000, disableOnInteraction: false },
    speed: 700,
    slidesPerView: 1,
    spaceBetween: 28,
    pagination: {
        el: '#msgFrom .swiper-pagination', // ✅ matches your HTML
        clickable: true,
    },
    breakpoints: {
        768: { slidesPerView: 1 },
        1200: { slidesPerView: 1 },
    },
});
// Select the swiper container
const swiperEl = document.querySelector('#msgFrom');

// Pause on hover
swiperEl.addEventListener('mouseenter', () => {
    msgFrom.autoplay.stop();
});

// Resume on mouse leave
swiperEl.addEventListener('mouseleave', () => {
    msgFrom.autoplay.start();
});

// ── Testimonial Swiper ────────────────────────────
new Swiper('#testiSwiper', {
    loop: true,
    autoplay: { delay: 6000, disableOnInteraction: false },
    speed: 700,
    slidesPerView: 1,
    spaceBetween: 28,
    pagination: {
        el: '#testimonials .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        768: { slidesPerView: 1 },
        1200: { slidesPerView: 3 },
    },
});

