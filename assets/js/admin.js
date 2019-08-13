// Hello? What's all this jQuery? We'll have no libraries here!
// Are you vanilla? This is a vanilla file, for vanilla people! There's nothing for jQuery folk here!

// Modules.
import { deBounce } from './modules/utils.js';
import { mediaGridObserver, attachmentPreviewObserver } from './modules/media-library.js';

// Ready.
window.addEventListener('DOMContentLoaded', function() {
	// Do something.

	// Courtesty of https://gist.github.com/benfrain/9422862
	mediaGridObserver.observe(document.body, {
		childList: true,
		subtree: true
	});

	attachmentPreviewObserver.observe(document.body, {
		childList: true,
		subtree: true
	});
});

// Load.
window.addEventListener('load', function() {
	// Do something.
});

// Resize
window.addEventListener(
	'resize',
	deBounce(() => {
		// Do something.
	}, 100),
);
