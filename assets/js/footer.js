// Map jQuery to $.
window.jQuery = window.$ = jQuery;

// Modules.
import {
	deBounce,
	isHighDensity,
	isRetina,
	compareRetina,
	compareBreakpoint,
} from './modules/utils.js';
import trackFocus from './modules/track-focus.js';
import skipLink from './modules/skip-link.js';
import trackFocus from './modules/track-focus.js';
import styleGuide from './modules/style-guide.js';
import initResponsiveBackgroundImages from './modules/rwd-bg-images.js';

// Ready.
window.addEventListener('DOMContentLoaded', function() {
	// Replace no-js with js on the root HTML element.
	document.documentElement.className =
		document.documentElement.className.replace(/\bno-js\b/g, '') + ' js ';
	trackFocus(document.body);
	skipLink();
	styleGuide();
	initResponsiveBackgroundImages($);
});

// Load.
window.addEventListener('load', function() {
	responsiveBackgroundImages('.js-bg-img');
});

// Resize
window.addEventListener(
	'resize',
	deBounce(() => {
		responsiveBackgroundImages('.js-bg-img');
	}, 100),
);
