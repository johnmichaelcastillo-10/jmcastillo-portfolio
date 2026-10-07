<?php
/**
 * Projects post type, skill taxonomy and project link fields.
 */

defined( 'ABSPATH' ) || exit;

const JMC_PORTFOLIO_LINK_META = array(
	'project_url' => 'Live site URL',
	'repo_url'    => 'Source code URL',
);

function jmc_portfolio_register_content() {
	register_post_type(
		'project',
		array(
			'labels'        => array(
				'name'               => __( 'Projects', 'jmc-portfolio-core' ),
				'singular_name'      => __( 'Project', 'jmc-portfolio-core' ),
				'add_new_item'       => __( 'Add New Project', 'jmc-portfolio-core' ),
				'edit_item'          => __( 'Edit Project', 'jmc-portfolio-core' ),
				'new_item'           => __( 'New Project', 'jmc-portfolio-core' ),
				'view_item'          => __( 'View Project', 'jmc-portfolio-core' ),
				'search_items'       => __( 'Search Projects', 'jmc-portfolio-core' ),
				'not_found'          => __( 'No projects found.', 'jmc-portfolio-core' ),
				'not_found_in_trash' => __( 'No projects found in Trash.', 'jmc-portfolio-core' ),
				'all_items'          => __( 'All Projects', 'jmc-portfolio-core' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'has_archive'   => 'projects',
			'rewrite'       => array(
				'slug'       => 'projects',
				'with_front' => false,
			),
			'menu_position' => 5,
			'menu_icon'     => 'dashicons-portfolio',
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
		)
	);

	register_taxonomy(
		'project_skill',
		'project',
		array(
			'labels'            => array(
				'name'          => __( 'Skills', 'jmc-portfolio-core' ),
				'singular_name' => __( 'Skill', 'jmc-portfolio-core' ),
				'add_new_item'  => __( 'Add New Skill', 'jmc-portfolio-core' ),
				'search_items'  => __( 'Search Skills', 'jmc-portfolio-core' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'skills' ),
		)
	);

	foreach ( JMC_PORTFOLIO_LINK_META as $key => $label ) {
		register_post_meta(
			'project',
			$key,
			array(
				'type'              => 'string',
				'label'             => $label,
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => true,
				'sanitize_callback' => 'esc_url_raw',
				'auth_callback'     => static fn( $allowed, $meta_key, $post_id ) => current_user_can( 'edit_post', $post_id ),
			)
		);
	}
}
add_action( 'init', 'jmc_portfolio_register_content' );
