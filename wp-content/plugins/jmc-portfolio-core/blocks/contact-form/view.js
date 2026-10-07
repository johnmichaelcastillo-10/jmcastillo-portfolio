// Loading state for the contact form: once the browser starts submitting, the button shows
// a spinner and "Sending…" so a slow host doesn't invite a second click. It stays enabled
// until then, per the form guidelines.
document.querySelectorAll( '.jmc-contact-form' ).forEach( function ( form ) {
	var button = form.querySelector( 'button[type="submit"]' );
	if ( ! button ) {
		return;
	}
	var label = button.querySelector( '.btn-label' ) || button;
	var idle = label.textContent;

	form.addEventListener( 'submit', function () {
		button.disabled = true;
		button.classList.add( 'is-loading' );
		label.textContent = form.dataset.sendingLabel || 'Sending…';
	} );

	// Coming back via the Back button restores the page from cache in its loading state.
	window.addEventListener( 'pageshow', function () {
		button.disabled = false;
		button.classList.remove( 'is-loading' );
		label.textContent = idle;
	} );
} );
