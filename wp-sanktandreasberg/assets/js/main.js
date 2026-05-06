/* wp-sanktandreasberg — main.js */
(function () {
	'use strict';

	/* ── Burger menu ───────────────────────────────────────── */
	var header = document.getElementById('header');
	var btn    = document.querySelector('.menu-btn');

	if (btn && header) {
		btn.addEventListener('click', function (e) {
			e.stopPropagation();
			var isOpen = header.classList.toggle('open');
			btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});

		document.addEventListener('click', function (e) {
			if (!header.contains(e.target)) {
				header.classList.remove('open');
				btn.setAttribute('aria-expanded', 'false');
			}
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				header.classList.remove('open');
				btn.setAttribute('aria-expanded', 'false');
				btn.focus();
			}
		});
	}

	/* ── Smooth-scroll for anchor links ────────────────────── */
	document.querySelectorAll('a[href^="#"]').forEach(function (a) {
		a.addEventListener('click', function (e) {
			var id     = this.getAttribute('href');
			var target = document.querySelector(id);
			if (target) {
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		});
	});

	/* ── Filter chips: mark active based on URL param ──────── */
	(function () {
		var chips = document.querySelectorAll('.filter-chip');
		if (!chips.length) return;
		var params = new URLSearchParams(window.location.search);
		chips.forEach(function (chip) {
			var href = chip.getAttribute('href') || '';
			if (href === window.location.pathname + window.location.search) {
				chip.classList.add('active');
			}
		});
	}());

	/* ── Sticky header shadow on scroll ────────────────────── */
	(function () {
		var hdr = document.querySelector('.header');
		if (!hdr) return;
		var scrolled = false;
		window.addEventListener('scroll', function () {
			var now = window.scrollY > 10;
			if (now !== scrolled) {
				hdr.style.boxShadow = now ? '0 4px 18px rgba(0,0,0,.10)' : '';
				scrolled = now;
			}
		}, { passive: true });
	}());
}());
