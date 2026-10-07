<?php
/**
 * Site tagline for a fresh install.
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

WP_CLI::success( 'Site content is set.' );
