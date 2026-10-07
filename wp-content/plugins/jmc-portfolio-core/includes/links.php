<?php
/**
 * Link buttons driven by Block Bindings: project links (post meta) and the resume
 * (a site option). A bound button whose link is empty renders as nothing.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_init',
	static function () {
		register_setting(
			'general',
			'jmc_resume_url',
			array(
				'type'              => 'string',
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		add_settings_field(
			'jmc_resume_url',
			__( 'Resume (PDF) URL', 'jmc-portfolio-core' ),
			static function () {
				printf(
					'<input type="url" class="regular-text code" id="jmc_resume_url" name="jmc_resume_url" value="%s" /><p class="description">%s</p>',
					esc_attr( get_option( 'jmc_resume_url', '' ) ),
					esc_html__( 'Upload the PDF under Media, then paste its URL here. The "Download resume" button stays hidden while this is empty.', 'jmc-portfolio-core' )
				);
			},
			'general',
			'default',
			array( 'label_for' => 'jmc_resume_url' )
		);
	}
);

add_action(
	'init',
	static function () {
		register_block_bindings_source(
			'jmc-portfolio/resume',
			array(
				'label'              => __( 'Resume URL', 'jmc-portfolio-core' ),
				'get_value_callback' => static fn() => get_option( 'jmc_resume_url', '' ),
			)
		);
	}
);

/**
 * The URL a button's binding points at, or null when the binding isn't one of ours.
 */
function jmc_portfolio_bound_url( array $binding, WP_Block $instance ): ?string {
	$source = $binding['source'] ?? '';

	if ( 'jmc-portfolio/resume' === $source ) {
		return (string) get_option( 'jmc_resume_url', '' );
	}

	$key = $binding['args']['key'] ?? '';
	if ( 'core/post-meta' === $source && isset( JMC_PORTFOLIO_LINK_META[ $key ] ) ) {
		$post_id = $instance->context['postId'] ?? get_the_ID();
		return (string) get_post_meta( $post_id, $key, true );
	}

	return null;
}

add_filter(
	'render_block_core/button',
	static function ( $content, $block, $instance ) {
		$binding = $block['attrs']['metadata']['bindings']['url'] ?? null;
		if ( ! is_array( $binding ) ) {
			return $content;
		}

		$url = jmc_portfolio_bound_url( $binding, $instance );
		return ( null !== $url && '' === trim( $url ) ) ? '' : $content;
	},
	10,
	3
);
