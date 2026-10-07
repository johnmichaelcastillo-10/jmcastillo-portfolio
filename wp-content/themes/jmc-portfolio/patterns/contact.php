<?php
/**
 * Title: Contact
 * Slug: jmc-portfolio/contact
 * Categories: jmc-portfolio
 * Description: One panel: ways to reach me on the left, the contact form on the right.
 */

$resume = (string) get_option( 'jmc_resume_url', '' );
?>
<!-- wp:group {"tagName":"section","anchor":"contact","align":"wide","className":"section","layout":{"type":"default"}} -->
<section id="contact" class="wp-block-group alignwide section"><!-- wp:group {"className":"contact-panel","layout":{"type":"default"}} -->
<div class="wp-block-group contact-panel"><!-- wp:group {"className":"contact-intro","layout":{"type":"default"}} -->
<div class="wp-block-group contact-intro"><!-- wp:paragraph {"className":"section-label"} -->
<p class="section-label">Contact</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Let's talk</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"lead"} -->
<p class="lead">Hiring, or have a system that needs work? Email me directly or send a message here.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<ul class="contact-methods">
	<li>
		<span class="icon-chip"><?php echo jmc_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
		<span><span class="contact-method-label">Email</span><a href="mailto:johnmichaelcastillo.it@gmail.com">johnmichaelcastillo.it@gmail.com</a></span>
	</li>
	<li>
		<span class="icon-chip"><?php echo jmc_icon( 'github' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
		<span><span class="contact-method-label">GitHub</span><a href="https://github.com/johnmichaelcastillo-10">johnmichaelcastillo-10</a></span>
	</li>
	<?php if ( '' !== $resume ) : ?>
	<li>
		<span class="icon-chip"><?php echo jmc_icon( 'file-text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
		<span><span class="contact-method-label">Résumé</span><a href="<?php echo esc_url( $resume ); ?>">Download PDF</a></span>
	</li>
	<?php endif; ?>
	<li>
		<span class="icon-chip"><?php echo jmc_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
		<span><span class="contact-method-label">Based in</span>Laguna, Philippines</span>
	</li>
</ul>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:jmc-portfolio/contact-form {"className":"contact-form-card"} /--></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
