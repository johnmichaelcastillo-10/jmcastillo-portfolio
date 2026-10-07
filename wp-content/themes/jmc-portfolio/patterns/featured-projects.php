<?php
/**
 * Title: Work
 * Slug: jmc-portfolio/featured-projects
 * Categories: jmc-portfolio
 * Description: Projects as a list with the year beside each, label in the margin.
 */
?>
<!-- wp:group {"anchor":"work","align":"wide","className":"section-row","layout":{"type":"default"}} -->
<div id="work" class="wp-block-group alignwide section-row"><!-- wp:heading -->
<h2 class="wp-block-heading">Work</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"row-content","layout":{"type":"default"}} -->
<div class="wp-block-group row-content"><!-- wp:query {"queryId":1,"query":{"perPage":6,"pages":0,"offset":0,"postType":"project","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"project-list"} -->
<div class="wp-block-query project-list"><!-- wp:post-template -->
<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-date {"format":"Y"} /-->

<!-- wp:post-excerpt {"excerptLength":24} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:paragraph {"className":"section-link"} -->
<p class="section-link"><a href="/projects/">All projects</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
