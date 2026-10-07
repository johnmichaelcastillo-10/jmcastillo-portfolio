// Header behaviour: the mobile menu and the "you are here" marker in the nav.
// Plain DOM, no dependencies, deferred. Everything degrades to ordinary links without it.
( function () {
	var root = document.documentElement;

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
