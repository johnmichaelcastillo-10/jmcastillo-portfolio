// Header behaviour: the light/dark toggle, the mobile menu and the "you are here" marker in
// the nav. Plain DOM, no dependencies, deferred. Everything degrades to ordinary links
// without it.
( function () {
	var root = document.documentElement;

	// Light/dark toggle. With no choice saved the site follows the system; a choice is stored
	// as "jmc-theme" and applied as data-theme on <html> (before paint, by the inline script
	// in functions.php). Flipping back to what the system already shows forgets the choice.
	// The browser chrome colour (meta theme-color) follows the theme in use.
	var themeToggle = document.querySelector( '.theme-toggle' );
	var systemDark = window.matchMedia( '(prefers-color-scheme: dark)' );
	var themeColors = { light: '#fafafa', dark: '#09090b' };
	var themeMetas = Array.prototype.slice.call( document.querySelectorAll( 'meta[name="theme-color"]' ) );

	var currentTheme = function () {
		var chosen = root.getAttribute( 'data-theme' );
		if ( chosen === 'light' || chosen === 'dark' ) {
			return chosen;
		}
		return systemDark.matches ? 'dark' : 'light';
	};

	var applyTheme = function ( theme ) {
		if ( theme === 'light' || theme === 'dark' ) {
			root.setAttribute( 'data-theme', theme );
		} else {
			root.removeAttribute( 'data-theme' );
		}
		var dark = currentTheme() === 'dark';
		root.classList.toggle( 'dark-theme', dark );
		themeMetas.forEach( function ( meta ) {
			meta.setAttribute( 'content', themeColors[ dark ? 'dark' : 'light' ] );
		} );
		if ( themeToggle ) {
			themeToggle.setAttribute( 'aria-label', themeToggle.getAttribute( dark ? 'data-label-light' : 'data-label-dark' ) );
		}
	};

	if ( themeToggle ) {
		themeToggle.addEventListener( 'click', function () {
			var next = currentTheme() === 'dark' ? 'light' : 'dark';
			var followSystem = next === ( systemDark.matches ? 'dark' : 'light' );
			try {
				if ( followSystem ) {
					window.localStorage.removeItem( 'jmc-theme' );
				} else {
					window.localStorage.setItem( 'jmc-theme', next );
				}
			} catch ( e ) {
				// Not remembered; this page still switches.
			}
			applyTheme( followSystem ? null : next );
		} );
		systemDark.addEventListener( 'change', function () {
			applyTheme( root.getAttribute( 'data-theme' ) );
		} );
		window.addEventListener( 'storage', function ( event ) {
			if ( event.key === 'jmc-theme' ) {
				applyTheme( event.newValue );
			}
		} );
		applyTheme( root.getAttribute( 'data-theme' ) );
		themeToggle.hidden = false;
	}

	var toggle = document.querySelector( '.menu-toggle' );
	var menu = document.getElementById( 'site-menu' );

	if ( toggle && menu ) {
		var setOpen = function ( open ) {
			toggle.setAttribute( 'aria-expanded', String( open ) );
			root.classList.toggle( 'menu-open', open );
		};

		toggle.addEventListener( 'click', function () {
			setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
		} );

		// Following a link, pressing Escape or widening the window closes the menu.
		menu.addEventListener( 'click', function ( event ) {
			if ( event.target.closest( 'a' ) ) {
				setOpen( false );
			}
		} );
		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && root.classList.contains( 'menu-open' ) ) {
				setOpen( false );
				toggle.focus();
			}
		} );
		window.matchMedia( '(min-width: 801px)' ).addEventListener( 'change', function ( mq ) {
			if ( mq.matches ) {
				setOpen( false );
			}
		} );
	}

	// Mark the nav link for the section currently in view (home page only).
	var links = Array.prototype.slice.call( document.querySelectorAll( '.site-menu a[href^="/#"]' ) );
	var sections = links
		.map( function ( link ) {
			return document.getElementById( link.getAttribute( 'href' ).slice( 2 ) );
		} )
		.filter( Boolean );

	if ( sections.length && 'IntersectionObserver' in window ) {
		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					links.forEach( function ( link ) {
						var active = link.getAttribute( 'href' ) === '/#' + entry.target.id;
						if ( active ) {
							link.setAttribute( 'aria-current', 'true' );
						} else {
							link.removeAttribute( 'aria-current' );
						}
					} );
				} );
			},
			// A section counts as "current" while it crosses the band 40% down the viewport.
			{ rootMargin: '-40% 0px -55% 0px' }
		);
		sections.forEach( function ( section ) {
			observer.observe( section );
		} );
	}
} )();
