<?php
/**
 * Title: Footer
 * Slug: jmc-portfolio/footer
 * Categories: jmc-portfolio
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * Text links rather than the Social Icons block: that block ships ~12 KB of CSS for
 * every brand it supports, to draw two icons.
 */
?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"align":"wide","className":"site-footer-bar","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide site-footer-bar"><!-- wp:paragraph -->
<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"footer-links"} -->
<p class="footer-links"><a href="https://github.com/johnmichaelcastillo-10">GitHub</a> <a href="mailto:johnmichaelcastillo.it@gmail.com">Email</a> <a href="#top">Back to top</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
