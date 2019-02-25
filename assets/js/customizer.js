// Map jQuery to $.
window.jQuery = window.$ = jQuery;

// Modules.
import { deBounce } from './modules/utils.js';

// Ready.
window.addEventListener(
	'DOMContentLoaded',
	function() {
		// Do something.
	}
);

// Load.
window.addEventListener(
	'load',
	function() {
		// Do something.
	}
);

// Resize
window.addEventListener(
	'resize',
	deBounce(() => {
		// Do something.
	}, 100)
);
