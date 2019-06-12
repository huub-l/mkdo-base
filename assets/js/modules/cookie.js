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
