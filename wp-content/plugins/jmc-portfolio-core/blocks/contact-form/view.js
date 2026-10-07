// Shows "Sending…" once the browser starts submitting, so a slow host doesn't invite a
// second click. The button stays enabled until then, per the form guidelines.
document.querySelectorAll( '.jmc-contact-form' ).forEach( function ( form ) {
	var button = form.querySelector( 'button[type="submit"]' );
	if ( ! button ) {
		return;
	}
	var label = button.textContent;

	form.addEventListener( 'submit', function () {
		button.disabled = true;
		button.textContent = form.dataset.sendingLabel || 'Sending…';
	} );

	// Coming back via the Back button restores the page from cache with the button disabled.
	window.addEventListener( 'pageshow', function () {
		button.disabled = false;
		button.textContent = label;
	} );
} );
