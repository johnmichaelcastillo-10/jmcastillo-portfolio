<?php
/**
 * Title: Hero
 * Slug: jmc-portfolio/hero
 * Categories: jmc-portfolio
 * Description: Headline, summary, actions, and the warehouse photo with a stats card.
 *
 * The copy describes the owner as a developer in general; employers belong in Experience
 * only. The photo's steel-blue uprights and orange beams are where the primary and accent
 * colours come from. The stats are résumé facts only: change them when the résumé changes.
 */

$hero_src = get_theme_file_uri( 'assets/images/hero-warehouse-aisle.webp' );
?>
<!-- wp:group {"tagName":"section","anchor":"top","align":"wide","className":"hero","layout":{"type":"default"}} -->
<section id="top" class="wp-block-group alignwide hero"><!-- wp:html -->
<p class="badge badge-outline hero-badge"><?php echo jmc_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>Software developer in Laguna, Philippines</p>
<!-- /wp:html -->

<!-- wp:heading {"level":1,"className":"hero-title"} -->
<h1 class="wp-block-heading hero-title">I build web applications and the APIs behind them.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"lead hero-lead"} -->
<p class="lead hero-lead">I'm John Michael, a software developer working in C#, ASP.NET and SQL Server, and building backend APIs in PHP with Laravel.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"hero-actions"} -->
<div class="wp-block-buttons hero-actions"><!-- wp:button {"className":"is-style-fill btn-arrow"} -->
<div class="wp-block-button is-style-fill btn-arrow"><a class="wp-block-button__link wp-element-button" href="#work">View my work</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-secondary","metadata":{"bindings":{"url":{"source":"jmc-portfolio/resume"}}}} -->
<div class="wp-block-button is-style-secondary"><a class="wp-block-button__link wp-element-button">Résumé (PDF)</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-text btn-external"} -->
<div class="wp-block-button is-style-text btn-external"><a class="wp-block-button__link wp-element-button" href="https://github.com/johnmichaelcastillo-10">GitHub</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"className":"hero-media","layout":{"type":"default"}} -->
<div class="wp-block-group hero-media"><!-- wp:image {"aspectRatio":"21/9","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"hero-figure"} -->
<figure class="wp-block-image size-full hero-figure"><img src="<?php echo esc_url( $hero_src ); ?>" alt="A long aisle between tall pallet racks with orange beams in a distribution warehouse" style="aspect-ratio:21/9;object-fit:cover"/><figcaption class="wp-element-caption">Pallet racking in a distribution warehouse. Photo: <a href="https://www.flickr.com/photos/42408834@N06/4324416999">toolstop</a>, <a href="https://creativecommons.org/licenses/by/2.0/">CC BY 2.0</a>, cropped.</figcaption></figure>
<!-- /wp:image -->

<!-- wp:html -->
<dl class="stats-card">
	<div><dt>Experience</dt><dd>Nearly 2 years</dd></div>
	<div><dt>Roles</dt><dd>Intern to junior programmer</dd></div>
	<div><dt>Projects</dt><dd>6 web apps and APIs</dd></div>
</dl>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
