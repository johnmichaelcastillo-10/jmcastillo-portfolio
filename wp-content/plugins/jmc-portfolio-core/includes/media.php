<?php
/**
 * Photo credits under featured images.
 *
 * The project photos are CC BY, which requires credit next to the image. The Post Featured
 * Image block doesn't print captions, so the attachment's caption is appended here.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'render_block_core/post-featured-image',
	static function ( $content, $block, $instance ) {
		if ( '' === trim( $content ) || str_contains( $content, '<figcaption' ) ) {
			return $content;
		}

		// Card thumbnails stay clean; their credits are on the project page and the
		// Photo credits page ([jmc_photo_credits]).
		if ( str_contains( (string) ( $block['attrs']['className'] ?? '' ), 'card-media' ) ) {
			return $content;
		}

		$post_id = $instance->context['postId'] ?? get_the_ID();
		$caption = wp_get_attachment_caption( (int) get_post_thumbnail_id( $post_id ) );
		if ( ! $caption ) {
			return $content;
		}

		$figcaption = '<figcaption class="wp-element-caption photo-credit">' . wp_kses( $caption, array( 'a' => array( 'href' => true ) ) ) . '</figcaption>';
		return preg_replace( '#</figure>\s*$#', $figcaption . '</figure>', $content, 1 ) ?? $content;
	},
	10,
	3
);

/**
 * [jmc_photo_credits]: every image credit on the site in one list, for the Photo credits
 * page. Reads attachment captions, plus the theme's hero photo.
 */
add_shortcode(
	'jmc_photo_credits',
	static function (): string {
		$items = array(
			sprintf(
				'<li><strong>Home page</strong>: Pallet racking in a distribution warehouse. Photo: <a href="%s">toolstop</a>, <a href="%s">CC BY 2.0</a>, cropped.</li>',
				esc_url( 'https://www.flickr.com/photos/42408834@N06/4324416999' ),
				esc_url( 'https://creativecommons.org/licenses/by/2.0/' )
			),
		);

		$projects = get_posts(
			array(
				'post_type'      => 'project',
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);
		foreach ( $projects as $project ) {
			$caption = wp_get_attachment_caption( (int) get_post_thumbnail_id( $project ) );
			if ( $caption ) {
				$items[] = sprintf(
					'<li><a href="%1$s"><strong>%2$s</strong></a>: %3$s</li>',
					esc_url( get_permalink( $project ) ),
					esc_html( get_the_title( $project ) ),
					wp_kses( $caption, array( 'a' => array( 'href' => true ) ) )
				);
			}
		}

		return '<ul class="credit-list">' . implode( '', $items ) . '</ul>';
	}
);
