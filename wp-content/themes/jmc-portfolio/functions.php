<?php
/**
 * JMC Portfolio theme setup.
 *
 * Design rules live in DESIGN.md at the repo root; tokens in theme.json; templates in
 * /templates and /parts; front-page sections in /patterns.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	static function () {
		add_editor_style( 'style.css' );
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_enqueue_style( 'jmc-portfolio', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	}
);

add_action(
	'init',
	static function () {
		register_block_pattern_category( 'jmc-portfolio', array( 'label' => __( 'Portfolio', 'jmc-portfolio' ) ) );

		// A button that reads as a plain link: the hero's secondary action sits beside one
		// primary button instead of competing with it.
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

add_action(
	'wp_head',
	static function () {
		// Browser chrome matches the canvas in both colour schemes.
		echo '<meta name="theme-color" content="#f9f8f6" media="(prefers-color-scheme: light)" />' . "\n";
		echo '<meta name="theme-color" content="#121110" media="(prefers-color-scheme: dark)" />' . "\n";

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
