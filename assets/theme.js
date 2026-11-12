(function () {
	'use strict';

	var cfg = window.HP || {};
	var dialog = document.getElementById('hp-dialog');
	var KEY = 'hp_dialog_closed_at';
	var WEEK = 7 * 24 * 60 * 60 * 1000;

	function remember() {
		try { localStorage.setItem(KEY, String(Date.now())); } catch (e) {}
	}
	function closedRecently() {
		try { return Date.now() - parseInt(localStorage.getItem(KEY) || '0', 10) < WEEK; } catch (e) { return false; }
	}
	function open() {
		if (!dialog || dialog.open) return;
		if (typeof dialog.showModal === 'function') dialog.showModal();
		else dialog.setAttribute('open', '');
	}
	function close() {
		if (!dialog) return;
		if (typeof dialog.close === 'function' && dialog.open) dialog.close();
		else dialog.removeAttribute('open');
		remember();
	}

	document.addEventListener('click', function (e) {
		var t = e.target;
		if (!t || !t.closest) return;
		if (t.closest('[data-hp-open]')) { e.preventDefault(); open(); }
		else if (t.closest('[data-hp-close]')) { e.preventDefault(); close(); }
		else if (t.closest('[data-hp-dismiss]')) { close(); }
	});

	if (dialog) {
		dialog.addEventListener('click', function (e) { if (e.target === dialog) close(); });
		dialog.addEventListener('cancel', remember);
		var fromForm = /[?&]hp_msg=/.test(location.search);
		if (cfg.autoOpen && !closedRecently() && !fromForm) {
			setTimeout(open, Math.max(0, cfg.delay || 0) * 1000);
		}
	}

	// Garis bawah header muncul setelah halaman digulir.
	var header = document.querySelector('.hp-header');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	// Tandai menu bagian yang sedang dibaca.
	var links = document.querySelectorAll('.hp-nav a[href^="#"]');
	if (links.length && 'IntersectionObserver' in window) {
		var map = {};
		Array.prototype.forEach.call(links, function (a) { map[a.getAttribute('href').slice(1)] = a; });
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				var a = map[en.target.id];
				if (a && en.isIntersecting) {
					Array.prototype.forEach.call(links, function (l) { l.removeAttribute('aria-current'); });
					a.setAttribute('aria-current', 'true');
				}
			});
		}, { rootMargin: '-45% 0px -50% 0px' });
		Object.keys(map).forEach(function (id) {
			var el = document.getElementById(id);
			if (el) io.observe(el);
		});
	}
})();
