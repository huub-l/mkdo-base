/*! track-focus v 1.0.0 | Author: Jeremy Fields [jeremy.fields@vget.com], 2015 | License: MIT */
// inspired by: http://irama.org/pkg/keyboard-focus-0.3/jquery.keyboard-focus.js

const trackFocus = function (body) {
	var usingMouse;

	var preFocus = function (event) {
		usingMouse = 'mousedown' === event.type;
	};

	var addFocus = function (event) {
		if (usingMouse) event.target.classList.add('focus--mouse');
	};

	var removeFocus = function (event) {
		event.target.classList.remove('focus--mouse');
	};

	var bindEvents = function () {
		body.addEventListener('keydown', preFocus);
		body.addEventListener('mousedown', preFocus);
		body.addEventListener('focusin', addFocus);
		body.addEventListener('focusout', removeFocus);
	};

	bindEvents();
};
export default trackFocus;
