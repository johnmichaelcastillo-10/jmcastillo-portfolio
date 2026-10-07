<?php
/**
 * Plugin Name:       JMC Portfolio Core
 * Description:       Projects, skills, contact form, résumé link and social meta tags for the portfolio site.
 * Version:           0.2.0
 * Requires at least: 6.6
 * Requires PHP:      8.1
 * Author:            John Michael Castillo
 * Text Domain:       jmc-portfolio-core
 *
 * Content lives in this plugin rather than the theme so projects and messages survive a theme change.
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/content.php';
require_once __DIR__ . '/includes/links.php';
require_once __DIR__ . '/includes/contact.php';
require_once __DIR__ . '/includes/seo.php';

register_activation_hook(
	__FILE__,
	static function () {
		jmc_portfolio_register_content();
		flush_rewrite_rules();
	}
);

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
