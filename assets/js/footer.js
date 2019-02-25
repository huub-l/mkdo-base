// Map jQuery to $.
window.jQuery = window.$ = jQuery;

// Modules.
import { deBounce, isHighDensity, isRetina, compareRetina, compareBreakpoint } from './modules/utils.js';
import skipLink from './modules/skip-link.js';
import styleGuide from './modules/style-guide.js';
import initResponsiveBackgroundImages from './modules/rwd-bg-images.js';

// Ready.
window.addEventListener(
	'DOMContentLoaded',
	function() {
		skipLink();
		styleGuide();
		initResponsiveBackgroundImages($);
	}
);

// Load.
window.addEventListener(
	'load',
	function() {
		responsiveBackgroundImages('.js-bg-img');
	}
);

// Resize
window.addEventListener(
	'resize',
	deBounce(() => {
		responsiveBackgroundImages('.js-bg-img');
	}, 100)
);
