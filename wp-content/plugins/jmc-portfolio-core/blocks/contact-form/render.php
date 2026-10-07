<?php
/**
 * Front-end and editor-preview markup for the Contact form block.
 */

defined( 'ABSPATH' ) || exit;
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo jmc_portfolio_contact_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped where built. ?>
</div>
