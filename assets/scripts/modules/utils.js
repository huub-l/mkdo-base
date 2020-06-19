export function deBounce(func, wait = 100) {
	let timeout;
	return function(...args) {
		clearTimeout(timeout);
		timeout = setTimeout(() => {
			func.apply(this, args);
		}, wait);
	};
}

export function isHighDensity() {
	return (
		(window.matchMedia &&
			(window.matchMedia(
				'only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)',
			).matches ||
				window.matchMedia(
					'only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)',
				).matches)) ||
		(window.devicePixelRatio && 1.3 < window.devicePixelRatio)
	);
}

export function isRetina() {
	return (
		((window.matchMedia &&
			(window.matchMedia(
				'only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx), only screen and (min-resolution: 75.6dpcm)',
			).matches ||
				window.matchMedia(
					'only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (min--moz-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)',
				).matches)) ||
			(window.devicePixelRatio && 2 <= window.devicePixelRatio)) &&
		/(iPad|iPhone|iPod)/g.test(navigator.userAgent)
	);
}

export function compareRetina(a, b) {
	if (a.retina < b.retina) return -1;
	if (a.retina > b.retinag) return 1;
	return 0;
}

export function compareBreakpoint(a, b) {
	if (a.breakpoint < b.breakpoint) return -1;
	if (a.breakpoint > b.breakpoint) return 1;
	return 0;
}

// Basic cookie utility functions
// https://www.w3schools.com/js/js_cookies.asp

export function setCookie(cname, cvalue, exdays) {
	let d = new Date();
	d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
	let expires = 'expires=' + d.toUTCString();
	document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
}

export function getCookie(cname) {
	let name = cname + '=';
	let ca = document.cookie.split(';');
	for (let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while (' ' == c.charAt(0)) {
			c = c.substring(1);
		}
		if (0 == c.indexOf(name)) {
			return c.substring(name.length, c.length);
		}
	}
	return '';
}

export function checkCookie(cname) {
	let cookie = getCookie(cname);
	if ('' != cookie) {
		return true;
	} else {
		return false;
	}
}
