<?php
/**
 * Title: Selected work
 * Slug: jmc-portfolio/featured-projects
 * Categories: jmc-portfolio
 * Description: The newest project as a featured panel, the next five as a list.
 */
?>
<!-- wp:group {"anchor":"work","align":"wide","className":"section","layout":{"type":"default"}} -->
<div id="work" class="wp-block-group alignwide section"><!-- wp:heading -->
<h2 class="wp-block-heading">Selected work</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":0,"offset":0,"postType":"project","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"project-featured"} -->
<div class="wp-block-query project-featured"><!-- wp:post-template -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9"} /-->

<!-- wp:group {"className":"project-featured__body","layout":{"type":"default"}} -->
<div class="wp-block-group project-featured__body"><!-- wp:group {"className":"project-featured__text","layout":{"type":"default"}} -->
<div class="wp-block-group project-featured__text"><!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"excerptLength":40} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"project-featured__meta","layout":{"type":"default"}} -->
<div class="wp-block-group project-featured__meta"><!-- wp:paragraph {"className":"meta-label"} -->
<p class="meta-label">Stack</p>
<!-- /wp:paragraph -->

<!-- wp:post-terms {"term":"project_skill","separator":", ","className":"stack"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:query {"queryId":2,"query":{"perPage":5,"pages":0,"offset":1,"postType":"project","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"project-list"} -->
<div class="wp-block-query project-list"><!-- wp:post-template -->
<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"excerptLength":24} /-->

<!-- wp:post-terms {"term":"project_skill","separator":", ","className":"stack"} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:paragraph {"className":"section-link"} -->
<p class="section-link"><a href="/projects/">All projects</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
