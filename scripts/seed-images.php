<?php
/**
 * Attaches a featured image to each project that doesn't have one yet, from
 * scripts/media/<project-slug>.webp, with the photo credit as the caption.
 *
 *   docker compose run --rm cli wp eval-file /scripts/seed-images.php
 *
 * Safe to re-run: projects that already have a featured image are left alone, so an
 * image chosen in wp-admin is never replaced.
 */

if ( ! defined( 'WP_CLI' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$dir     = '/scripts/media';
$credits = json_decode( (string) file_get_contents( "$dir/credits.json" ), true );
if ( ! is_array( $credits ) ) {
	WP_CLI::error( "Cannot read $dir/credits.json" );
}

foreach ( $credits as $credit ) {
	$slug = basename( $credit['file'], '.webp' );
	$post = get_page_by_path( $slug, OBJECT, 'project' );
	if ( ! $post ) {
		continue; // Not a project image (e.g. the hero, which ships with the theme).
	}
	if ( has_post_thumbnail( $post ) ) {
		WP_CLI::log( "Skipped {$slug}: already has a featured image" );
		continue;
	}

	// media_handle_sideload() moves the file, so hand it a copy.
	$tmp = wp_tempnam( $credit['file'] );
	copy( "$dir/{$credit['file']}", $tmp );

	// CC BY needs creator, licence and a link; the caption carries all three.
	$caption = sprintf(
		'Photo: <a href="%1$s">%2$s</a>, <a href="%3$s">%4$s</a>, %5$s.',
		esc_url( $credit['source_url'] ),
		esc_html( $credit['creator'] ),
		esc_url( $credit['license_url'] ),
		esc_html( $credit['license'] ),
		esc_html( $credit['modified'] )
	);

	$id = media_handle_sideload(
		array(
			'name'     => $credit['file'],
			'tmp_name' => $tmp,
		),
		$post->ID,
		$credit['alt'],
		array( 'post_excerpt' => $caption )
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "{$slug}: " . $id->get_error_message() );
		continue;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $credit['alt'] );
	set_post_thumbnail( $post, $id );
	WP_CLI::log( "Attached {$credit['file']} to {$slug}" );
}

WP_CLI::success( 'Project images are in place.' );
