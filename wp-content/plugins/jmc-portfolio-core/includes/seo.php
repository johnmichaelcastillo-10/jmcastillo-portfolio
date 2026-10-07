<?php
/**
 * Meta description plus Open Graph / Twitter tags, so links shared on LinkedIn,
 * Messenger or Slack show a proper preview. Steps aside when an SEO plugin is active.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'jmc_portfolio_meta_tags', 1 );

// The users sitemap would publish author archives, and with them the admin username.
add_filter(
	'wp_sitemaps_add_provider',
	static fn( $provider, $name ) => 'users' === $name ? false : $provider,
	10,
	2
);

// The thank-you page after a contact form submission has no business in search results.
add_action(
	'wp_head',
	static function () {
		if ( is_page( 'message-sent' ) ) {
			echo '<meta name="robots" content="noindex" />' . "\n";
		}
	},
	1
);

add_filter(
	'wp_sitemaps_posts_query_args',
	static function ( $args, $post_type ) {
		if ( 'page' === $post_type ) {
			$page = get_page_by_path( 'message-sent' );
			if ( $page ) {
				$args['post__not_in'] = array_merge( $args['post__not_in'] ?? array(), array( $page->ID ) );
			}
		}
		return $args;
	},
	10,
	2
);

function jmc_portfolio_meta_tags(): void {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}

	$site  = get_bloginfo( 'name' );
	$image = get_site_icon_url( 512 );
	$type  = 'website';

	if ( is_front_page() ) {
		$title = $site;
		$desc  = get_bloginfo( 'description' );
		$url   = home_url( '/' );
		// WordPress only prints a canonical link on single posts and pages.
		printf( "<link rel=\"canonical\" href=\"%s\" />\n", esc_url( $url ) );
	} elseif ( is_singular() ) {
		$post  = get_queried_object();
		$title = single_post_title( '', false );
		$desc  = get_the_excerpt( $post );
		$url   = get_permalink( $post );
		$image = get_the_post_thumbnail_url( $post, 'large' ) ?: $image;
		$type  = 'article';
	} elseif ( is_post_type_archive( 'project' ) ) {
		$title = __( 'Projects', 'jmc-portfolio-core' );
		/* translators: %s: site owner's name */
		$desc = sprintf( __( 'Projects by %s.', 'jmc-portfolio-core' ), $site );
		$url  = get_post_type_archive_link( 'project' );
	} elseif ( is_tax( 'project_skill' ) ) {
		$term  = get_queried_object();
		$title = $term->name;
		/* translators: 1: skill name, 2: site owner's name */
		$desc = term_description( $term ) ?: sprintf( __( '%1$s projects by %2$s.', 'jmc-portfolio-core' ), $term->name, $site );
		$url  = get_term_link( $term );
	} else {
		return;
	}

	$desc = trim( wp_strip_all_tags( html_entity_decode( (string) $desc, ENT_QUOTES, 'UTF-8' ) ) );

	$tags = array(
		array( 'name', 'description', $desc ),
		array( 'property', 'og:site_name', $site ),
		array( 'property', 'og:type', $type ),
		array( 'property', 'og:title', $title ),
		array( 'property', 'og:description', $desc ),
		array( 'property', 'og:url', $url ),
		array( 'property', 'og:image', $image ),
		array( 'name', 'twitter:card', $image ? 'summary_large_image' : 'summary' ),
	);

	foreach ( $tags as [ $attr, $key, $value ] ) {
		// get_permalink() and get_term_link() can return false or a WP_Error.
		if ( is_string( $value ) && '' !== $value ) {
			printf( "<meta %s=\"%s\" content=\"%s\" />\n", $attr, esc_attr( $key ), esc_attr( $value ) );
		}
	}
}
