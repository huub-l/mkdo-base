// Event for opening and closing the menu
export function menuToggle() {
	const toggle = document.querySelector('.site-header__menu-toggle');

	if (toggle) {
		toggle.addEventListener('click', function() {
			document.body.classList.remove('site-header-search-open');
			document.body.classList.toggle('site-header-menu-open');
		});
	}
}
