<?php
/**
 * Title: Experience
 * Slug: jmc-portfolio/experience
 * Categories: jmc-portfolio
 * Description: Work history as a timeline, with education below. Resume facts only.
 *
 * Dates are written out ("Mar 2025 to now") because WordPress turns " - " into an en dash.
 */

$jobs = array(
	array(
		'current' => true,
		'dates'   => 'Mar 2025 to now',
		'role'    => 'Junior Programmer',
		'org'     => 'Mets Cold Storage Services Inc.',
		'place'   => 'Makati',
		'points'  => array(
			'Maintain and extend the warehouse management system and client-facing customer portal.',
			'Built Excel data-import features and templates for loading distribution records.',
			'Moved concatenated SQL to parameterized queries to close SQL injection risks.',
			'Investigate and fix reported production issues.',
		),
		'stack'   => array( 'C#', 'ASP.NET Web Forms', 'SQL Server', 'DevExpress', 'jQuery' ),
	),
	array(
		'current' => false,
		'dates'   => 'Mar to May 2024',
		'role'    => 'Backend Web Developer, Trainee',
		'org'     => 'Leekie Enterprises Inc.',
		'place'   => 'API team',
		'points'  => array(
			'Backend API development for an e-wallet system, with Redis for caching.',
			'Wrote API feature tests and unit tests with PHPUnit.',
		),
		'stack'   => array( 'PHP 7', 'Lumen', 'MySQL', 'Redis', 'PHPUnit' ),
	),
	array(
		'current' => false,
		'dates'   => 'Feb to Sep 2023',
		'role'    => 'Backend Web Developer, Intern',
		'org'     => 'Lyceum of the Philippines Laguna',
		'place'   => 'MIS Department',
		'points'  => array(
			"Built the judging system used for events during the university's Foundation Day.",
			"Built APIs for the Registrar's Office record management and queuing systems.",
		),
		'stack'   => array( 'PHP 8', 'Laravel 9', 'MySQL' ),
	),
);
?>
<!-- wp:group {"tagName":"section","anchor":"experience","align":"wide","className":"section","layout":{"type":"default"}} -->
<section id="experience" class="wp-block-group alignwide section"><!-- wp:group {"className":"section-head","layout":{"type":"default"}} -->
<div class="wp-block-group section-head"><!-- wp:paragraph {"className":"section-label"} -->
<p class="section-label">Experience</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Where I've worked</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:html -->
<ol class="timeline">
	<?php foreach ( $jobs as $job ) : ?>
	<li class="timeline-item<?php echo $job['current'] ? ' is-current' : ''; ?>">
		<article class="card timeline-card">
			<header class="timeline-head">
				<div>
					<h3><?php echo esc_html( $job['role'] ); ?></h3>
					<p class="timeline-org"><?php echo esc_html( $job['org'] ); ?> <span aria-hidden="true">·</span> <?php echo esc_html( $job['place'] ); ?></p>
				</div>
				<p class="badge<?php echo $job['current'] ? ' badge-accent' : ''; ?>"><?php echo jmc_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?><?php echo esc_html( $job['dates'] ); ?></p>
			</header>
			<ul class="timeline-points">
				<?php foreach ( $job['points'] as $point ) : ?>
				<li><?php echo esc_html( $point ); ?></li>
				<?php endforeach; ?>
			</ul>
			<ul class="badge-list" aria-label="Stack">
				<?php foreach ( $job['stack'] as $tech ) : ?>
				<li class="badge"><?php echo esc_html( $tech ); ?></li>
				<?php endforeach; ?>
			</ul>
		</article>
	</li>
	<?php endforeach; ?>
</ol>

<div class="card education">
	<span class="icon-chip icon-chip-lg"><?php echo jmc_icon( 'graduation-cap' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
	<div>
		<p class="education-label">Education</p>
		<p class="education-title">Bachelor of Information Technology</p>
		<p class="education-meta">Lyceum of the Philippines Laguna <span aria-hidden="true">·</span> Completed 2023</p>
	</div>
</div>
<!-- /wp:html --></section>
<!-- /wp:group -->
