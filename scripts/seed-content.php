<?php
/**
 * Site tagline and the "Message sent" page for a fresh install. Safe to re-run.
 *
 *   docker compose run --rm cli wp eval-file /scripts/seed-content.php
 *
 * No projects are seeded: systems built at the owner's jobs are confidential and must not
 * appear on the site. Personal projects are added by hand under Admin → Projects; the Work
 * section appears once one is published.
 */

if ( ! defined( 'WP_CLI' ) ) {
	exit;
}

update_option( 'blogdescription', 'Software developer working in C#, SQL Server and PHP' );

// On the static site, Web3Forms sends visitors here after they submit the contact form.
if ( ! get_page_by_path( 'message-sent' ) ) {
	wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => 'message-sent',
			'post_title'   => 'Message sent',
			'post_content' => "<!-- wp:paragraph -->\n<p>Thanks for reaching out. Your message is on its way, and I'll reply to the email address you gave.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"/\">Back to the home page</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
		)
	);
	WP_CLI::log( 'Created the Message sent page' );
}

WP_CLI::success( 'Site content is set.' );
