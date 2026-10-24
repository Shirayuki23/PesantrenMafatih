// Pesantren Mafatih — script inti untuk semua halaman
(function () {
    "use strict";

    // ----- Tema gelap (persisten via localStorage) -----
    var darkBtn = document.getElementById("darkBtn");
    function applyTheme(dark) {
        document.body.classList.toggle("dark-mode", dark);
        if (darkBtn) darkBtn.textContent = dark ? "☀" : "☾";
    }
    applyTheme(localStorage.getItem("mf-theme") === "dark");
    if (darkBtn) {
        darkBtn.addEventListener("click", function () {
            var dark = !document.body.classList.contains("dark-mode");
            localStorage.setItem("mf-theme", dark ? "dark" : "light");
            applyTheme(dark);
        });
    }

    // ----- Menu mobile -----
    var menuToggle = document.getElementById("menuToggle");
    var mobileMenu = document.getElementById("mobileMenu");
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener("click", function () {
            mobileMenu.classList.toggle("show");
        });
    }
    document.querySelectorAll(".mobile-dropdown > button").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var sub = btn.nextElementSibling;
            if (sub) sub.classList.toggle("show");
        });
    });

    // ----- Overlay pencarian -----
    var searchBtn = document.getElementById("searchBtn");
    var searchOverlay = document.getElementById("searchOverlay");
    var searchClose = document.getElementById("searchClose");
    function openSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.add("show");
        var input = searchOverlay.querySelector("input");
        if (input) setTimeout(function () { input.focus(); }, 50);
    }
    function closeSearch() {
        if (searchOverlay) searchOverlay.classList.remove("show");
    }
    if (searchBtn) searchBtn.addEventListener("click", openSearch);
    if (searchClose) searchClose.addEventListener("click", closeSearch);
    if (searchOverlay) {
        searchOverlay.addEventListener("click", function (ev) {
            if (ev.target === searchOverlay) closeSearch();
        });
    }
    document.addEventListener("keydown", function (ev) {
        if (ev.key === "Escape") { closeSearch(); closeLightbox(); }
        if (ev.key === "/" && document.activeElement.tagName !== "INPUT" &&
            document.activeElement.tagName !== "TEXTAREA") {
            ev.preventDefault();
            openSearch();
        }
    });

    // ----- Tahun footer -----
    var year = document.getElementById("year");
    if (year) year.textContent = new Date().getFullYear();

    // ----- Toast flash -----
    var toast = document.getElementById("flashToast");
    if (toast) {
        setTimeout(function () { toast.classList.add("hide"); }, 3500);
    }

    // ----- Tombol kembali ke atas -----
    var toTop = document.getElementById("toTop");
    if (toTop) {
        window.addEventListener("scroll", function () {
            toTop.classList.toggle("show", window.scrollY > 500);
        }, { passive: true });
        toTop.addEventListener("click", function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }

    // ----- Reveal saat scroll -----
    var revealEls = document.querySelectorAll(".reveal");
    if ("IntersectionObserver" in window && revealEls.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    en.target.classList.add("in");
                    io.unobserve(en.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(function (el) { io.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add("in"); });
    }

    // ----- Angka statistik beranimasi -----
    var counters = document.querySelectorAll("[data-count]");
    if ("IntersectionObserver" in window && counters.length) {
        var cio = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                var el = en.target;
                var target = parseInt(el.getAttribute("data-count"), 10) || 0;
                var suffix = el.getAttribute("data-suffix") || "";
                var t0 = null;
                function step(ts) {
                    if (!t0) t0 = ts;
                    var p = Math.min((ts - t0) / 1200, 1);
                    el.textContent = Math.round(target * (0.2 + 0.8 * p * p)) + suffix;
                    if (p < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
                cio.unobserve(el);
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { cio.observe(el); });
    }

    // ----- Filter chip (galeri & lainnya, sisi klien) -----
    document.querySelectorAll("[data-filter-group]").forEach(function (group) {
        var chips = group.querySelectorAll(".chip");
        var items = document.querySelectorAll(group.getAttribute("data-filter-group"));
        chips.forEach(function (chip) {
            chip.addEventListener("click", function () {
                chips.forEach(function (c) { c.classList.remove("active"); });
                chip.classList.add("active");
                var cat = chip.getAttribute("data-cat") || "";
                items.forEach(function (item) {
                    var show = !cat || item.getAttribute("data-cat") === cat;
                    item.classList.toggle("hidden", !show);
                });
            });
        });
    });

    // ----- Lightbox galeri -----
    var lightbox = document.getElementById("lightbox");
    var lightboxBody = document.getElementById("lightboxBody");
    var lightboxCaption = document.getElementById("lightboxCaption");
    var lightboxClose = document.getElementById("lightboxClose");
    function closeLightbox() {
        if (lightbox) lightbox.classList.remove("show");
    }
    document.querySelectorAll(".gallery-item").forEach(function (item) {
        item.addEventListener("click", function () {
            if (!lightbox || !lightboxBody) return;
            var title = item.getAttribute("data-title") || "";
            var cat = item.getAttribute("data-cat") || "";
            var img = item.querySelector("img");
            var grad = item.querySelector(".gi-grad");
            lightboxBody.innerHTML = "";
            if (img) {
                var big = document.createElement("img");
                big.src = img.src;
                big.alt = img.alt || title;
                lightboxBody.appendChild(big);
            } else if (grad) {
                var box = grad.cloneNode(true);
                box.classList.add("big");
                lightboxBody.appendChild(box);
            }
            if (lightboxCaption) {
                lightboxCaption.textContent = (cat ? cat + " — " : "") + title;
            }
            lightbox.classList.add("show");
        });
    });
    if (lightboxClose) lightboxClose.addEventListener("click", closeLightbox);
    if (lightbox) {
        lightbox.addEventListener("click", function (ev) {
            if (ev.target === lightbox) closeLightbox();
        });
    }

    // ----- Akordeon FAQ -----
    document.querySelectorAll(".faq-q").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var item = btn.closest(".faq-item");
            if (!item) return;
            var wasOpen = item.classList.contains("open");
            document.querySelectorAll(".faq-item.open").forEach(function (o) {
                o.classList.remove("open");
            });
            if (!wasOpen) item.classList.add("open");
        });
    });

    // ----- Slider testimoni -----
    var slider = document.querySelector("[data-slider]");
    if (slider) {
        var slides = slider.querySelectorAll(".slide");
        var dotsWrap = slider.querySelector(".slider-dots");
        var idx = 0, timer = null;
        slides.forEach(function (_, i) {
            var d = document.createElement("button");
            d.className = "dot" + (i === 0 ? " active" : "");
            d.setAttribute("aria-label", "Slide " + (i + 1));
            d.addEventListener("click", function () { go(i); rest(); });
            if (dotsWrap) dotsWrap.appendChild(d);
        });
        function go(n) {
            idx = (n + slides.length) % slides.length;
            slides.forEach(function (s, i) { s.classList.toggle("active", i === idx); });
            if (dotsWrap) {
                dotsWrap.querySelectorAll(".dot").forEach(function (d, i) {
                    d.classList.toggle("active", i === idx);
                });
            }
        }
        function rest() {
            clearInterval(timer);
            timer = setInterval(function () { go(idx + 1); }, 5500);
        }
        if (slides.length) { go(0); rest(); }
    }

    // ----- Galeri carousel slider (autoplay, arrows, dots, swipe) -----
    document.querySelectorAll("[data-carousel]").forEach(function (root) {
        var track = root.querySelector(".gc-track");
        var slides = root.querySelectorAll(".gc-slide");
        var prev = root.querySelector(".gc-prev");
        var next = root.querySelector(".gc-next");
        var dotsWrap = root.querySelector(".gc-dots");
        if (!track || slides.length < 2) return;
        var idx = 0, timer = null, DUR = 5000;

        slides.forEach(function (_, i) {
            var d = document.createElement("button");
            d.className = "gc-dot" + (i === 0 ? " active" : "");
            d.type = "button";
            d.setAttribute("aria-label", "Slide " + (i + 1));
            d.addEventListener("click", function () { go(i); restart(); });
            if (dotsWrap) dotsWrap.appendChild(d);
        });
        var dots = dotsWrap ? dotsWrap.querySelectorAll(".gc-dot") : [];

        function go(n) {
            idx = (n + slides.length) % slides.length;
            track.style.transform = "translateX(-" + idx * 100 + "%)";
            dots.forEach(function (d, i) { d.classList.toggle("active", i === idx); });
        }
        function stop() { clearInterval(timer); }
        function restart() { stop(); timer = setInterval(function () { go(idx + 1); }, DUR); }

        if (prev) prev.addEventListener("click", function () { go(idx - 1); restart(); });
        if (next) next.addEventListener("click", function () { go(idx + 1); restart(); });
        root.addEventListener("mouseenter", stop);
        root.addEventListener("mouseleave", restart);

        var x0 = null;
        root.addEventListener("touchstart", function (e) { x0 = e.touches[0].clientX; stop(); }, { passive: true });
        root.addEventListener("touchend", function (e) {
            if (x0 === null) return;
            var dx = e.changedTouches[0].clientX - x0;
            if (Math.abs(dx) > 40) go(idx + (dx < 0 ? 1 : -1));
            x0 = null;
            restart();
        }, { passive: true });

        restart();
    });
})();
