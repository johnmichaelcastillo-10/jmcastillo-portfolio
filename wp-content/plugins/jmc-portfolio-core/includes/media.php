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
