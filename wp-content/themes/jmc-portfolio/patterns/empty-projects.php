<?php
/**
 * Title: Empty state: projects
 * Slug: jmc-portfolio/empty-projects
 * Categories: jmc-portfolio
 * Inserter: no
 * Description: Shown by project queries that return nothing.
 */
?>
<!-- wp:html -->
<div class="empty-state">
	<span class="empty-state-icon"><?php echo jmc_icon( 'folder-open' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
	<p class="empty-state-title">No projects here yet</p>
	<p class="empty-state-text">Projects added under Admin → Projects show up here.</p>
	<a class="btn btn-secondary btn-sm" href="/">Back to home</a>
</div>
<!-- /wp:html -->
