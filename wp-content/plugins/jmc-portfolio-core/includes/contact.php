<?php
/**
 * Contact form: the [jmc_contact_form] shortcode.
 *
 * Every message is saved as a private post (Admin → Messages) before any email is
 * attempted, so nothing is lost on a host that can't send mail — including the local
 * Docker setup, which has no mail server.
 *
 * Spam defence is a honeypot field, a minimum fill time and a per-IP hourly limit. There
 * is deliberately no nonce: nonces expire, and a cached page would then reject real
 * visitors. Rejected bots are told "sent" so they learn nothing.
 */

defined( 'ABSPATH' ) || exit;

const JMC_CONTACT_ACTION       = 'jmc_contact';
const JMC_CONTACT_MIN_SECONDS  = 3;
const JMC_CONTACT_HOURLY_LIMIT = 5;

add_action(
	'init',
	static function () {
		register_post_type(
			'jmc_message',
			array(
				'labels'          => array(
					'name'          => __( 'Messages', 'jmc-portfolio-core' ),
					'singular_name' => __( 'Message', 'jmc-portfolio-core' ),
					'edit_item'     => __( 'Message', 'jmc-portfolio-core' ),
					'all_items'     => __( 'All Messages', 'jmc-portfolio-core' ),
					'search_items'  => __( 'Search Messages', 'jmc-portfolio-core' ),
					'not_found'     => __( 'No messages yet.', 'jmc-portfolio-core' ),
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_rest'    => false,
				'menu_position'   => 26,
				'menu_icon'       => 'dashicons-email-alt',
				'supports'        => array( 'title', 'editor' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
			)
		);
	}
);

// The block is what the theme uses. The shortcode stays for pasting into posts, but it
// won't run inside a pattern placed in a template: WordPress expands shortcodes there
// before it expands patterns.
add_action(
	'init',
	static function () {
		register_block_type( dirname( __DIR__ ) . '/blocks/contact-form' );
	}
);

add_shortcode( 'jmc_contact_form', 'jmc_portfolio_contact_form' );

function jmc_portfolio_contact_form(): string {
	// Only a fixed set of keys is ever printed, so reading the query arg is safe.
	$status  = sanitize_key( $_GET['contact'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$notices = array(
		'sent'    => array( false, __( 'Thanks! Your message has been sent.', 'jmc-portfolio-core' ) ),
		'invalid' => array( true, __( 'Please enter your name, a valid email address and a message of at least 10 characters.', 'jmc-portfolio-core' ) ),
		'limited' => array( true, __( 'Too many messages from your connection. Please try again later, or email me directly.', 'jmc-portfolio-core' ) ),
		'error'   => array( true, __( 'Something went wrong. Please try again, or email me directly.', 'jmc-portfolio-core' ) ),
	);

	ob_start();

	$is_error = false;
	if ( isset( $notices[ $status ] ) ) {
		[ $is_error, $text ] = $notices[ $status ];
		printf(
			'<p id="jmc-contact-status" class="jmc-contact-notice%1$s" role="%2$s">%3$s</p>',
			$is_error ? ' is-error' : '',
			$is_error ? 'alert' : 'status',
			esc_html( $text )
		);
	}
	// Ties the error message to the fields so screen readers announce it on focus.
	$described = $is_error ? ' aria-describedby="jmc-contact-status" aria-invalid="true"' : '';
	?>
	<form class="jmc-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-sending-label="<?php esc_attr_e( 'Sending…', 'jmc-portfolio-core' ); ?>">
		<input type="hidden" name="action" value="<?php echo esc_attr( JMC_CONTACT_ACTION ); ?>" />
		<input type="hidden" name="jmc_ts" value="<?php echo esc_attr( (string) time() ); ?>" />
		<div class="jmc-field">
			<label for="jmc-name"><?php esc_html_e( 'Name', 'jmc-portfolio-core' ); ?></label>
			<input id="jmc-name" type="text" name="jmc_name" required maxlength="100" autocomplete="name"<?php echo $described; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed string. ?> />
		</div>
		<div class="jmc-field">
			<label for="jmc-email"><?php esc_html_e( 'Email', 'jmc-portfolio-core' ); ?></label>
			<input id="jmc-email" type="email" name="jmc_email" required maxlength="200" autocomplete="email" inputmode="email" spellcheck="false" autocapitalize="off"<?php echo $described; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed string. ?> />
		</div>
		<div class="jmc-field">
			<label for="jmc-message"><?php esc_html_e( 'Message', 'jmc-portfolio-core' ); ?></label>
			<textarea id="jmc-message" name="jmc_message" required minlength="10" maxlength="5000" aria-describedby="jmc-message-help<?php echo $is_error ? ' jmc-contact-status' : ''; ?>"></textarea>
			<p id="jmc-message-help" class="jmc-help"><?php esc_html_e( 'At least 10 characters.', 'jmc-portfolio-core' ); ?></p>
		</div>
		<div class="jmc-hp" aria-hidden="true">
			<label>Leave this empty <input type="text" name="jmc_website" tabindex="-1" autocomplete="off" /></label>
		</div>
		<button type="submit" class="wp-element-button"><?php esc_html_e( 'Send Message', 'jmc-portfolio-core' ); ?></button>
	</form>
	<?php
	return (string) ob_get_clean();
}

add_action( 'admin_post_nopriv_' . JMC_CONTACT_ACTION, 'jmc_portfolio_handle_contact' );
add_action( 'admin_post_' . JMC_CONTACT_ACTION, 'jmc_portfolio_handle_contact' );

function jmc_portfolio_handle_contact(): void {
	// phpcs:disable WordPress.Security.NonceVerification.Missing -- see file header.
	$back     = remove_query_arg( 'contact', wp_get_referer() ?: home_url( '/' ) );
	$redirect = static function ( string $status ) use ( $back ): never {
		wp_safe_redirect( add_query_arg( 'contact', $status, $back ) . '#contact' );
		exit;
	};

	$started = (int) ( $_POST['jmc_ts'] ?? 0 );
	if ( ! empty( $_POST['jmc_website'] ) || time() - $started < JMC_CONTACT_MIN_SECONDS ) {
		$redirect( 'sent' );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['jmc_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['jmc_email'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['jmc_message'] ?? '' ) );
	// phpcs:enable

	if ( '' === $name || mb_strlen( $name ) > 100 || ! is_email( $email )
		|| mb_strlen( $message ) < 10 || mb_strlen( $message ) > 5000 ) {
		$redirect( 'invalid' );
	}

	$limit_key = 'jmc_contact_' . md5( ( $_SERVER['REMOTE_ADDR'] ?? '' ) . wp_salt( 'nonce' ) );
	$sent      = (int) get_transient( $limit_key );
	if ( $sent >= JMC_CONTACT_HOURLY_LIMIT ) {
		$redirect( 'limited' );
	}
	set_transient( $limit_key, $sent + 1, HOUR_IN_SECONDS );

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'jmc_message',
			'post_status'  => 'private',
			// Not "Name <email>": kses strips the angle-bracketed part as a tag.
			'post_title'   => sprintf( '%s — %s', $name, $email ),
			'post_content' => $message,
			'meta_input'   => array(
				'_jmc_name'  => $name,
				'_jmc_email' => $email,
			),
		),
		true
	);
	if ( is_wp_error( $post_id ) ) {
		$redirect( 'error' );
	}

	// Best effort: the message is already saved, so a mail failure isn't the visitor's problem.
	wp_mail(
		get_option( 'admin_email' ),
		sprintf(
			/* translators: 1: site name, 2: sender name */
			__( '[%1$s] New message from %2$s', 'jmc-portfolio-core' ),
			wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
			$name
		),
		$message . "\n\n— " . $name . ' <' . $email . ">\n" . admin_url( 'post.php?action=edit&post=' . $post_id ),
		array( 'Reply-To: ' . $email )
	);

	$redirect( 'sent' );
}
