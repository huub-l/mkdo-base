// Hello? What's all this jQuery? We'll have no libraries here!
// Are you vanilla? This is a vanilla file, for vanilla people! There's nothing for jQuery folk here!

// JS
import userAgentClasses from './modules/user-agent-classes.js';

// Run
userAgentClasses();

// Modules.
import { deBounce } from './modules/utils.js';
import trackFocus from './modules/track-focus.js';
import skipLink from './modules/skip-link.js';
import styleGuide from './modules/style-guide.js';
import { menuToggle } from './modules/toggles.js';

// Ready.
window.addEventListener('DOMContentLoaded', function () {
	// Replace no-js with js on the root HTML element.
	document.documentElement.className =
		document.documentElement.className.replace(/\bno-js\b/g, '') + ' js ';
	trackFocus(document.body);
	skipLink();
	styleGuide();
	menuToggle();
});

// Load.
window.addEventListener('load', function () {});

// Resize
window.addEventListener(
	'resize',
	deBounce(() => {}, 100),
);
