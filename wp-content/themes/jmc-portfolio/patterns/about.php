<?php
/**
 * Title: About
 * Slug: jmc-portfolio/about
 * Categories: jmc-portfolio
 * Description: Short bio beside a toolkit card of grouped skills.
 */

$groups = array(
	array( 'code', 'Languages', array( 'C#', 'T-SQL', 'PHP', 'JavaScript', 'HTML', 'CSS' ) ),
	array( 'layers', 'Frameworks', array( 'ASP.NET Web Forms', 'Laravel', 'Lumen', 'jQuery', 'DevExpress', 'Bootstrap' ) ),
	array( 'database', 'Data', array( 'SQL Server', 'MySQL', 'Redis' ) ),
	array( 'wrench', 'Tools and practice', array( 'Git', 'GitHub', 'PHPUnit', 'REST APIs', 'TortoiseSVN', 'Trello' ) ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"about","align":"wide","className":"section section-alt","layout":{"type":"default"}} -->
<section id="about" class="wp-block-group alignwide section section-alt"><!-- wp:group {"className":"about-grid","layout":{"type":"default"}} -->
<div class="wp-block-group about-grid"><!-- wp:group {"className":"about-text","layout":{"type":"default"}} -->
<div class="wp-block-group about-text"><!-- wp:paragraph {"className":"section-label"} -->
<p class="section-label">About</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Business software, from the database up</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"lead"} -->
<p class="lead">I have nearly two years of professional experience building and maintaining business web applications, mostly in C#, ASP.NET Web Forms and Microsoft SQL Server.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>I work across every layer of a business web application: server-side C#, the T-SQL queries and stored procedures behind it, and the jQuery front end. I've built data-import tools, moved concatenated SQL to parameterized queries, and fixed bugs in production. On the PHP side I've built backend APIs with Laravel and Lumen, using Redis for caching.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>I work in a team on Git and GitHub, and I've written unit and API tests with PHPUnit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="card toolkit">
	<p class="toolkit-title">Toolkit</p>
	<?php foreach ( $groups as [ $icon, $label, $items ] ) : ?>
	<div class="toolkit-group">
		<p class="toolkit-label"><span class="icon-chip"><?php echo jmc_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span><?php echo esc_html( $label ); ?></p>
		<ul class="badge-list" aria-label="<?php echo esc_attr( $label ); ?>">
			<?php foreach ( $items as $item ) : ?>
			<li class="badge"><?php echo esc_html( $item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endforeach; ?>
</div>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
