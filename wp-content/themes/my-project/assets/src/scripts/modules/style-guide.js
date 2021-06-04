const styleGuide = function () {
	if (document.querySelector('.static-main')) {
		// View changing JS
		const staticNav = Array.from(
			document.querySelectorAll('#static-header__nav>li>a'),
		);
		const staticPages = Array.from(
			document.querySelectorAll('section.static-page'),
		);
		const currentView = localStorage.getItem('currentView') || 'info';

		// Check for view in storage
		if ('' !== currentView) {
			const target = document.querySelector(
				`section.static-page.${currentView}`,
			);
			target.classList.add('display');
			setTimeout(() => {
				target.classList.toggle('active');
			}, 300);
		}

		// Channge view
		function toggleOpen(e) {
			e.preventDefault();

			const targetName = this.id;
			const target = document.querySelector(
				`section.static-page.${targetName}`,
			);

			staticNav.forEach((link) => link.classList.remove('active'));
			this.classList.add('active');

			staticPages.forEach((page) => page.classList.remove('active'));

			setTimeout(function () {
				staticPages.forEach((page) => page.classList.remove('display'));
				target.classList.add('display');
			}, 150);

			setTimeout(() => {
				target.classList.toggle('active');
			}, 300);

			localStorage.setItem('currentView', targetName);
			return currentView;
		}

		staticNav.forEach((link) => link.addEventListener('click', toggleOpen));

		// Tabbed Display
		const tabbedFlag = Array.from(
			document.querySelectorAll('.staticflag-tabbed'),
		);

		tabbedFlag.forEach(function (tabbed) {
			// Get the list of elements
			const elms = Array.from(tabbed.children);

			// Output tab links for each elm
			let int = 0;
			elms.forEach(function (elm) {
				let modifier = 'Default';

				if (elm.className.match(/--([^\s]+)/g)) {
					modifier = elm.className.match(/--([^\s]+)/g)[0].substring(2);
				}
				const link = document.createElement('a');
				link.classList.add('staticflag-tabbed__link');
				link.dataset.target = int;
				link.innerHTML = `${modifier}`;
				tabbed.appendChild(link);
				int++;
			});

			// Generate tab markup
			elms.forEach(function (elm) {
				const tab = document.createElement('div');
				tab.classList.add('staticflag-tabbed__tab');
				tab.style.display = 'none';
				tab.appendChild(elm);
				tabbed.appendChild(tab);
			});

			const tabs = Array.from(
				tabbed.querySelectorAll('.staticflag-tabbed__tab'),
			);
			const links = Array.from(
				tabbed.querySelectorAll('.staticflag-tabbed__link'),
			);

			links[0].classList.add('staticflag-tabbed__link--active');
			tabs[0].style.display = 'block';

			links.forEach(function (link) {
				link.addEventListener('click', function () {
					links.forEach((link) =>
						link.classList.remove('staticflag-tabbed__link--active'),
					);
					tabs.forEach((tab) => (tab.style.display = 'none'));
					links[this.dataset.target].classList.add(
						'staticflag-tabbed__link--active',
					);
					tabs[this.dataset.target].style.display = 'block';
				});
			});
		});
	}
};
export default styleGuide;
