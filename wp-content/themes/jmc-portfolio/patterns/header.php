<?php
/**
 * Title: Header
 * Slug: jmc-portfolio/header
 * Categories: jmc-portfolio
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * Plain markup in a Custom HTML block rather than the Navigation block (which inlines
 * ~20 KB of CSS and loads the Interactivity API). assets/js/site.js wires the menu button
 * and marks the section in view. The menu only collapses behind the button when <html>
 * has the `js` class (added inline in <head>), so without JS the links stay visible.
 */
?>
<!-- wp:html -->
<div class="site-header">
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="brand-mark" aria-hidden="true">JM</span>
		<span class="brand-name">John Michael Castillo</span>
	</a>
	<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-menu">
		<?php echo jmc_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
		<?php echo jmc_icon( 'x' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
		<span class="screen-reader-text">Menu</span>
	</button>
	<nav id="site-menu" class="site-menu" aria-label="Main">
		<ul>
			<li><a href="/#work">Work</a></li>
			<li><a href="/#about">About</a></li>
			<li><a href="/#experience">Experience</a></li>
		</ul>
		<a class="btn btn-sm" href="/#contact">Contact</a>
	</nav>
</div>
<!-- /wp:html -->
