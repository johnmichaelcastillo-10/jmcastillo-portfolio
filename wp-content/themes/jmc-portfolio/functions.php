<?php
/**
 * JMC Portfolio theme setup.
 *
 * Design rules live in DESIGN.md at the repo root; tokens in theme.json and the :root block
 * of style.css; templates in /templates and /parts; sections in /patterns.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inline SVG icon from assets/icons (Lucide, ISC; GitHub mark from Simple Icons, CC0).
 * Inline rather than an <img> so icons take currentColor; decorative unless $label is set.
 */
function jmc_icon( string $name, string $label = '' ): string {
	static $cache = array();

	if ( ! isset( $cache[ $name ] ) ) {
		$file = get_theme_file_path( "assets/icons/{$name}.svg" );
		$svg  = is_readable( $file ) ? (string) file_get_contents( $file ) : '';
		$svg  = preg_replace( '/<!--.*?-->|<title>.*?<\/title>/s', '', $svg );
		// Strip sizing and class from the root <svg> only: inner shapes (e.g. a <rect>) need
		// their own width/height.
		$svg = preg_replace_callback(
			'/<svg\b[^>]*>/',
			static fn( $m ) => preg_replace( '/\s(class|width|height|role)="[^"]*"/', '', $m[0] ),
			$svg,
			1
		);
		// Simple Icons are filled shapes; Lucide icons are strokes and set their own fill="none".
		if ( ! str_contains( $svg, 'fill=' ) ) {
			$svg = str_replace( '<svg', '<svg fill="currentColor"', $svg );
		}
		$cache[ $name ] = trim( preg_replace( '/\s+/', ' ', $svg ) );
	}

	if ( '' === $cache[ $name ] ) {
		return '';
	}

	$a11y = '' === $label
		? 'aria-hidden="true" focusable="false"'
		: 'role="img" aria-label="' . esc_attr( $label ) . '"';

	return str_replace( '<svg', '<svg class="icon icon-' . esc_attr( $name ) . '" ' . $a11y, $cache[ $name ] );
}

add_action(
	'after_setup_theme',
	static function () {
		add_editor_style( 'style.css' );
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		$version = wp_get_theme()->get( 'Version' );
		wp_enqueue_style( 'jmc-portfolio', get_stylesheet_uri(), array(), $version );
		// Mobile menu and current-section highlighting. Deferred; the page works without it.
		wp_enqueue_script(
			'jmc-portfolio-site',
			get_theme_file_uri( 'assets/js/site.js' ),
			array(),
			$version,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
);

add_action(
	'init',
	static function () {
		register_block_pattern_category( 'jmc-portfolio', array( 'label' => __( 'Portfolio', 'jmc-portfolio' ) ) );

		register_block_style(
			'core/button',
			array(
				'name'  => 'secondary',
				'label' => __( 'Secondary', 'jmc-portfolio' ),
			)
		);
		register_block_style(
			'core/button',
			array(
				'name'  => 'text',
				'label' => __( 'Text link', 'jmc-portfolio' ),
			)
		);
	}
);

// The site uses no emoji; WordPress's emoji polyfill would cost a script and an inline
// detection snippet on every page.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

// "Name · Tagline" instead of WordPress's en dash.
add_filter( 'document_title_separator', static fn() => '·' );

// Runs before first paint so CSS can collapse the mobile menu only when JS is available
// (without it the header simply shows its links).
add_action(
	'wp_head',
	static function () {
		echo "<script>document.documentElement.classList.add('js')</script>\n";
	},
	0
);

add_action(
	'wp_head',
	static function () {
		echo '<meta name="theme-color" content="#fafafa" media="(prefers-color-scheme: light)" />' . "\n";
		echo '<meta name="theme-color" content="#09090b" media="(prefers-color-scheme: dark)" />' . "\n";

		// The body face is needed for first paint; preloading avoids a late font swap.
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin />' . "\n",
			esc_url( get_theme_file_uri( 'assets/fonts/schibsted-grotesk.woff2' ) )
		);

		// Monogram favicon until a Site Icon is set in Settings → General.
		if ( ! has_site_icon() ) {
			printf(
				'<link rel="icon" href="%s" type="image/svg+xml" />' . "\n",
				esc_url( get_theme_file_uri( 'assets/favicon.svg' ) )
			);
		}
	},
	2
);
