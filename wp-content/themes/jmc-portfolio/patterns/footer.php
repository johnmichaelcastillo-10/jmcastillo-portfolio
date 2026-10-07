<?php
/**
 * Title: Footer
 * Slug: jmc-portfolio/footer
 * Categories: jmc-portfolio
 * Block Types: core/template-part/footer
 * Inserter: no
 */
?>
<!-- wp:html -->
<div class="site-footer">
	<div class="footer-top">
		<div class="footer-brand">
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="brand-mark" aria-hidden="true">JM</span>
				<span class="brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			</a>
			<p>Software developer building and maintaining business systems in C#, SQL Server and PHP.</p>
		</div>
		<nav class="footer-nav" aria-label="Footer">
			<div>
				<p class="footer-heading">Site</p>
				<ul>
					<li><a href="/#work">Work</a></li>
					<li><a href="/#about">About</a></li>
					<li><a href="/#experience">Experience</a></li>
					<li><a href="/#contact">Contact</a></li>
				</ul>
			</div>
			<div>
				<p class="footer-heading">Elsewhere</p>
				<ul>
					<li><a href="https://github.com/johnmichaelcastillo-10">GitHub</a></li>
					<li><a href="mailto:johnmichaelcastillo.it@gmail.com">Email</a></li>
					<li><a href="/projects/">All projects</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="footer-bottom">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
		<p><a href="#top">Back to top</a></p>
	</div>
</div>
<!-- /wp:html -->
