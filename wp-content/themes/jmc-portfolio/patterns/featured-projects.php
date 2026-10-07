<?php
/**
 * Title: Work
 * Slug: jmc-portfolio/featured-projects
 * Categories: jmc-portfolio
 * Description: The six latest projects as photo cards; the newest one is shown large.
 *
 * Renders nothing until a project is published. Only personal projects go here: systems
 * built at work are confidential and must not be shown.
 */

if ( ! jmc_has_projects() ) {
	return;
}
?>
<!-- wp:group {"tagName":"section","anchor":"work","align":"wide","className":"section","layout":{"type":"default"}} -->
<section id="work" class="wp-block-group alignwide section"><!-- wp:group {"className":"section-head section-head-split","layout":{"type":"default"}} -->
<div class="wp-block-group section-head section-head-split"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"section-label"} -->
<p class="section-label">Work</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Selected projects</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"lead"} -->
<p class="lead">Web applications, backend APIs and internal tools I've built and maintained.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":6,"pages":0,"offset":0,"postType":"project","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"project-cards is-bento"} -->
<div class="wp-block-query project-cards is-bento"><!-- wp:post-template -->
<!-- wp:post-featured-image {"aspectRatio":"16/10","className":"card-media"} /-->

<!-- wp:group {"className":"card-body","layout":{"type":"default"}} -->
<div class="wp-block-group card-body"><!-- wp:post-date {"format":"Y","className":"card-year"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"className":"card-title"} /-->

<!-- wp:post-excerpt {"excerptLength":22,"className":"card-text"} /-->

<!-- wp:post-terms {"term":"project_skill","separator":"","className":"badge-list"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:pattern {"slug":"jmc-portfolio/empty-projects"} /-->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:paragraph {"className":"section-more"} -->
<p class="section-more"><a href="/projects/">See all projects</a></p>
<!-- /wp:paragraph --></section>
<!-- /wp:group -->
