<?php
/**
 * Site tagline and portfolio projects, taken from the resume.
 *
 *   docker compose run --rm cli wp eval-file /scripts/seed-content.php
 *
 * Projects are matched by slug and updated in place, so re-running overwrites edits made
 * in wp-admin to these projects. setup.ps1 only runs it when there are no projects yet.
 */

if ( ! defined( 'WP_CLI' ) ) {
	exit;
}

// Content is authored here, not user input; keep block comment markup intact.
kses_remove_filters();

$p    = static fn( string $text ) => "<!-- wp:paragraph -->\n<p>" . esc_html( $text ) . "</p>\n<!-- /wp:paragraph -->";
$h    = static fn( string $text ) => "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . esc_html( $text ) . "</h2>\n<!-- /wp:heading -->";
$list = static function ( array $items ): string {
	$li = array_map(
		static fn( string $item ) => "<!-- wp:list-item -->\n<li>" . esc_html( $item ) . "</li>\n<!-- /wp:list-item -->",
		$items
	);
	return "<!-- wp:list -->\n<ul class=\"wp-block-list\">" . implode( "\n\n", $li ) . "</ul>\n<!-- /wp:list -->";
};

update_option( 'blogdescription', 'Software developer working in C#, SQL Server and PHP' );

// Newest first on the site; post_date only controls that order (dates aren't displayed).
$projects = array(
	array(
		'slug'    => 'wms-customer-portal',
		'title'   => 'Warehouse Management System & Customer Portal',
		'date'    => '2025-03-03',
		'excerpt' => 'Maintaining and extending a cold-storage warehouse management system and its client-facing customer portal.',
		'skills'  => array( 'C#', 'ASP.NET Web Forms', 'SQL Server', 'DevExpress', 'jQuery' ),
		'content' => array(
			$p( 'I maintain and enhance a warehouse management system (WMS) and the client-facing customer portal of a cold storage and logistics company.' ),
			$h( 'What I do' ),
			$list(
				array(
					'Develop and modify features from business and user requirements, across C# server-side code, SQL Server, and jQuery/HTML/CSS pages with DevExpress UI components.',
					'Write and modify the T-SQL queries and stored procedures behind application features.',
					'Investigate, debug and fix reported issues in the live system.',
				)
			),
			$p( 'Built with C#, ASP.NET Web Forms (.NET Framework), Microsoft SQL Server, DevExpress and jQuery. It is an internal system, so there is no public link.' ),
		),
	),
	array(
		'slug'    => 'excel-data-import',
		'title'   => 'Excel Data-Import Tool',
		'date'    => '2025-03-02',
		'excerpt' => 'Excel import features and templates for loading distribution records into the warehouse management system.',
		'skills'  => array( 'C#', 'ASP.NET Web Forms', 'SQL Server' ),
		'content' => array(
			$p( 'Built Excel data-import features, together with the import templates, for loading distribution records into the warehouse management system.' ),
		),
	),
	array(
		'slug'    => 'sql-injection-remediation',
		'title'   => 'SQL Injection Remediation',
		'date'    => '2025-03-01',
		'excerpt' => 'Hardening the warehouse management system by replacing concatenated SQL with parameterized queries.',
		'skills'  => array( 'C#', 'T-SQL', 'Security' ),
		'content' => array(
			$p( 'Improved application security by converting SQL that was built through string concatenation into parameterized queries, removing SQL injection risks from the warehouse management system.' ),
		),
	),
	array(
		'slug'    => 'e-wallet-api',
		'title'   => 'E-Wallet Backend API',
		'date'    => '2024-03-01',
		'excerpt' => "Backend API development for an e-wallet system with Leekie Enterprises' API team.",
		'skills'  => array( 'PHP', 'Lumen', 'MySQL', 'Redis', 'PHPUnit' ),
		'content' => array(
			$p( "As a backend trainee on Leekie Enterprises' API team, I contributed to the API of an e-wallet system." ),
			$list(
				array(
					'Backend API development with PHP 7, Laravel/Lumen 7 and MySQL.',
					'Redis for caching.',
					'API feature tests and unit tests with PHPUnit.',
					'TortoiseSVN for version control and Trello for task tracking.',
				)
			),
		),
	),
	array(
		'slug'    => 'judging-system',
		'title'   => 'Foundation Day Judging System',
		'date'    => '2023-02-02',
		'excerpt' => "Judging system used for events during Lyceum of the Philippines Laguna's Foundation Day.",
		'skills'  => array( 'PHP', 'Laravel', 'MySQL' ),
		'content' => array(
			$p( "Built during my internship with the MIS Department of Lyceum of the Philippines Laguna: a judging system used for events during the university's Foundation Day, with APIs in PHP 8, Laravel 9 and MySQL." ),
		),
	),
	array(
		'slug'    => 'registrar-systems',
		'title'   => 'Registrar Records & Ticketing System',
		'date'    => '2023-02-01',
		'excerpt' => "Record management and queuing/ticketing systems used by the university Registrar's Office.",
		'skills'  => array( 'PHP', 'Laravel', 'MySQL' ),
		'content' => array(
			$p( "Also during my MIS internship: APIs for a record management system and a queuing/ticketing system used by the Registrar's Office, built with PHP 8, Laravel 9 and MySQL." ),
		),
	),
);

foreach ( $projects as $project ) {
	$existing = get_page_by_path( $project['slug'], OBJECT, 'project' );
	$id       = wp_insert_post(
		array(
			'ID'           => $existing->ID ?? 0,
			'post_type'    => 'project',
			'post_status'  => 'publish',
			'post_name'    => $project['slug'],
			'post_title'   => $project['title'],
			'post_excerpt' => $project['excerpt'],
			'post_content' => implode( "\n\n", $project['content'] ),
			'post_date'    => $project['date'] . ' 09:00:00',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( "{$project['title']}: " . $id->get_error_message() );
	}
	wp_set_object_terms( $id, $project['skills'], 'project_skill' );
	WP_CLI::log( ( $existing ? 'Updated ' : 'Created ' ) . $project['title'] );
}

// Placeholder projects from the first version of setup.ps1.
foreach ( array( 'warehouse-dashboard', 'network-refresh', 'internal-tools-portal' ) as $slug ) {
	$old = get_page_by_path( $slug, OBJECT, 'project' );
	if ( $old ) {
		wp_delete_post( $old->ID, true );
		WP_CLI::log( "Removed placeholder {$slug}" );
	}
}

foreach ( get_terms( array( 'taxonomy' => 'project_skill', 'hide_empty' => false ) ) as $term ) {
	if ( 0 === (int) $term->count ) {
		wp_delete_term( $term->term_id, 'project_skill' );
	}
}

WP_CLI::success( 'Portfolio content is up to date.' );
