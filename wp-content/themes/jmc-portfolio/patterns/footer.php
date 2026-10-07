<?php
/**
 * Title: Footer
 * Slug: jmc-portfolio/footer
 * Categories: jmc-portfolio
 * Block Types: core/template-part/footer
 * Inserter: no
 */
?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"align":"wide","className":"section-tight","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide section-tight"><!-- wp:paragraph -->
<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-normal-icon-size","className":"is-style-logos-only"} -->
<ul class="wp-block-social-links has-normal-icon-size is-style-logos-only"><!-- wp:social-link {"url":"https://github.com/johnmichaelcastillo-10","service":"github"} /-->

<!-- wp:social-link {"service":"linkedin"} /-->

<!-- wp:social-link {"url":"mailto:johnmichaelcastillo.it@gmail.com","service":"mail"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
