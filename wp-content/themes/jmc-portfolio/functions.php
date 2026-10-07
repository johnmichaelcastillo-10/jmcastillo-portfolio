<?php
/**
 * JMC Portfolio theme setup.
 *
 * Layout and design tokens live in theme.json; templates in /templates and /parts;
 * front-page sections in /patterns.
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
	}
);
