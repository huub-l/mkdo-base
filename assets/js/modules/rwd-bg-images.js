// This function needs to have the jQuery $ variable passed in.
// ------------------------------------------------------------
const initResponsiveBackgroundImages = function($) {
	// Change the CSS background-image of an
	// element or collection of elements at
	// different breakpoints based on image
	// sources stored in data attributes
	// on the element(s).
	//
	// This function is bound to the window
	// and be used in the global scope.
	// -------------------------------------
	window.responsiveBackgroundImages = function(selector) {
		// Abort if matchMedia API not supported.
		// ----------------------------------------
		if (!window.matchMedia) {
			return;
		}

		// Abort if we have no selector.
		// -------------------------------------
		if (!selector) {
			return;
		}

		const $bgImgEl = $(selector);

		// Iterate over all elements that have
		// the chosen selector.
		// -------------------------------------
		$bgImgEl.each(function(index, element) {
			// Setup our variables.
			// -------------------------------------
			const cssProp = 'background-image',
				$imgTarget = $(element),
				imgData = [],
				imgCurrentSrc = $(element)
					.css(cssProp)
					.replace('url(', '')
					.replace(')', '')
					.replace(/\"/gi, '');

			let imgDefaultSrc = '';

			// Get all of the element attributes.
			// -------------------------------------
			$.each(this.attributes, function(index, element) {
				// Get and store the default image.
				// -------------------------------------
				if (-1 !== this.name.indexOf('data-default-bg')) {
					imgDefaultSrc = this.value || '';
				}

				// Get and store the breakpoint and the
				// image src as an object in our array
				// of image data.
				// -------------------------------------
				if (-1 !== this.name.indexOf('data-bg-')) {
					// Regex to extract the breakpoint value
					// from the attribute name.
					// -------------------------------------
					const regex = /data-bg-(\d*)/i,
						match = this.name.match(regex);

					// Make sure we only add the the image
					// data if the URL is present and we
					// have a match.
					// -------------------------------------
					if (
						'' !== this.value &&
						'undefined' !== typeof this.value &&
						'undefined' !== typeof match[1]
					) {
						imgData.push({
							breakpoint: parseInt(match[1]),
							src: this.value,
							retina: -1 !== this.name.indexOf('2x') ? true : false,
						});
					}
				}
			});

			imgData.sort(compareRetina);
			imgData.sort(compareBreakpoint);

			// Iterate over our data object and
			// replace the background image with the
			// most appropriate version for the
			// current viewport size if required.
			// -------------------------------------
			for (let i = 0; i < imgData.length; i++) {
				// Setup our variables.
				// -------------------------------------
				let next = i + 1,
					// Ensure the first breakpoint value is always zero.
					bpMin = 0 === i ? 0 : imgData[i].breakpoint,
					// Ensure the last breakpoint value is always high.
					bpMax =
						i === imgData.length - 1 ? 9999 : imgData[next].breakpoint - 1;

				// Carry out a Modernzir media query
				// check for each breakpoint defined in
				// our array, and update the background
				// image CSS property for the element.
				// -------------------------------------
				if (
					window.matchMedia(
						'only screen and (min-width: ' +
							bpMin +
							'px) and ( max-width: ' +
							bpMax +
							'px)',
					).matches
				) {
					const pixelRatio = 2, // @TODO - Should be window.devicePixelRatio, this is a hack!
						retina = imgData[i].retina,
						src = imgData[i].src;

					// @TODO - Need to fix this? see pixelRatio above.
					// if ( pixelRatio < 2 && ( isHighDensity() || isRetina() ) ) {
					// 	pixelRatio = 2;
					// }

					// Only update the background image if
					// the image for this breakpoint is not
					// the same as the existing image.
					//
					// Furthermore, only update the image
					// based on the retina/non-retina
					// conditions.
					// -------------------------------------
					if (
						imgCurrentSrc !== src &&
						((false === retina && 2 > pixelRatio) ||
							(true === retina && 1 < pixelRatio))
					) {
						$imgTarget.css(cssProp, 'url("' + src + '")');
					}
				}
			}

			// Use the default image as a fallback
			// if this element still does not have a
			// background image set, for whatever
			// reason that may be.
			// -------------------------------------
			const bgImg = $imgTarget
				.css(cssProp)
				.replace('url(', '')
				.replace(')', '')
				.replace(/\"/gi, '');

			if ('none' === bgImg && '' !== imgDefaultSrc) {
				$imgTarget.css(cssProp, 'url("' + imgDefaultSrc + '")');
			}
		});
	};
};

export default initResponsiveBackgroundImages;
