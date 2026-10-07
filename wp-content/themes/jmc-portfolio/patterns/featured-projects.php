<?php
/**
 * Title: Featured projects
 * Slug: jmc-portfolio/featured-projects
 * Categories: jmc-portfolio
 * Description: The six latest projects in a grid, with a link to the full list.
 */
?>
<!-- wp:group {"anchor":"work","align":"wide","className":"section","layout":{"type":"default"}} -->
<div id="work" class="wp-block-group alignwide section"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Selected work</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Projects</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":1,"query":{"perPage":6,"pages":0,"offset":0,"postType":"project","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"project-grid"} -->
<div class="wp-block-query project-grid"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"excerptLength":24} /-->

<!-- wp:post-terms {"term":"project_skill","separator":" ","className":"skill-tags"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Projects are on the way.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/projects/">All projects</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
