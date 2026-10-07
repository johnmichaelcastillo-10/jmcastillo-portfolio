<?php
/**
 * Attaches a featured image to each project that doesn't have one yet, from
 * scripts/media/<project-slug>.webp, with the alt text from media.json.
 *
 *   docker compose run --rm cli wp eval-file /scripts/seed-images.php
 *
 * Safe to re-run: projects that already have a featured image are left alone, so an
 * image chosen in wp-admin is never replaced. All photos are CC0 or public domain, so no
 * credit caption is stored.
 */

if ( ! defined( 'WP_CLI' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$dir   = '/scripts/media';
$media = json_decode( (string) file_get_contents( "$dir/media.json" ), true );
if ( ! is_array( $media ) ) {
	WP_CLI::error( "Cannot read $dir/media.json" );
}

foreach ( $media as $item ) {
	$slug = basename( $item['file'], '.webp' );
	$post = get_page_by_path( $slug, OBJECT, 'project' );
	if ( ! $post ) {
		continue;
	}
	if ( has_post_thumbnail( $post ) ) {
		WP_CLI::log( "Skipped {$slug}: already has a featured image" );
		continue;
	}

	// media_handle_sideload() moves the file, so hand it a copy.
	$tmp = wp_tempnam( $item['file'] );
	copy( "$dir/{$item['file']}", $tmp );

	$id = media_handle_sideload(
		array(
			'name'     => $item['file'],
			'tmp_name' => $tmp,
		),
		$post->ID,
		$item['alt']
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "{$slug}: " . $id->get_error_message() );
		continue;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $item['alt'] );
	set_post_thumbnail( $post, $id );
	WP_CLI::log( "Attached {$item['file']} to {$slug}" );
}

WP_CLI::success( 'Project images are in place.' );
