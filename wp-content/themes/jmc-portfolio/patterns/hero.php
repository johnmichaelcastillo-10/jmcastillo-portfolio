<?php
/**
 * Title: Intro
 * Slug: jmc-portfolio/hero
 * Categories: jmc-portfolio
 * Description: A written introduction with inline links, then a warehouse aisle photo.
 *
 * The h1 is only the first sentence so heading navigation announces something short; the
 * second sentence continues at the same size in the muted colour. The photo is the site's
 * one big image: a pallet-rack aisle, the world the software I work on runs in. Its orange
 * beams are where the accent colour comes from.
 */

$hero_src = get_theme_file_uri( 'assets/images/hero-warehouse-aisle.webp' );
?>
<!-- wp:group {"anchor":"top","align":"wide","className":"hero","layout":{"type":"default"}} -->
<div id="top" class="wp-block-group alignwide hero"><!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">I'm John Michael, a software developer in Laguna, Philippines.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"hero-sub"} -->
<p class="hero-sub">I build and maintain warehouse software in C# and SQL Server, and backend APIs in PHP.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"hero-links"} -->
<div class="wp-block-buttons hero-links"><!-- wp:button {"className":"is-style-text","metadata":{"bindings":{"url":{"source":"jmc-portfolio/resume"}}}} -->
<div class="wp-block-button is-style-text"><a class="wp-block-button__link wp-element-button">Résumé (PDF)</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-text"} -->
<div class="wp-block-button is-style-text"><a class="wp-block-button__link wp-element-button" href="https://github.com/johnmichaelcastillo-10">GitHub</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-text"} -->
<div class="wp-block-button is-style-text"><a class="wp-block-button__link wp-element-button" href="mailto:johnmichaelcastillo.it@gmail.com">Email</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:image {"aspectRatio":"21/9","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"hero-figure"} -->
<figure class="wp-block-image size-full hero-figure"><img src="<?php echo esc_url( $hero_src ); ?>" alt="A long aisle between tall pallet racks with orange beams in a distribution warehouse" style="aspect-ratio:21/9;object-fit:cover"/><figcaption class="wp-element-caption">Pallet racking in a distribution warehouse. Photo: <a href="https://www.flickr.com/photos/42408834@N06/4324416999">toolstop</a>, <a href="https://creativecommons.org/licenses/by/2.0/">CC BY 2.0</a>, cropped.</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->
