<?php
/**
 * Header situs.
 *
 * @package Hire_Profile
 */
$hp_name = hp_get( 'full_name' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="hp-skip" href="#main"><?php echo esc_html( hp_t( 'skip' ) ); ?></a>

<header class="hp-header">
	<div class="hp-wrap hp-header__inner">
		<a class="hp-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="hp-brand__mark" aria-hidden="true"><?php echo esc_html( hp_initials( $hp_name ) ); ?></span>
			<span class="hp-brand__name"><?php echo esc_html( $hp_name ); ?></span>
		</a>
		<nav class="hp-nav" aria-label="Profile sections">
			<ul>
				<li><a href="<?php echo esc_url( hp_anchor( 'about' ) ); ?>"><?php echo esc_html( hp_t( 'nav_about' ) ); ?></a></li>
				<li><a href="<?php echo esc_url( hp_anchor( 'skills' ) ); ?>"><?php echo esc_html( hp_t( 'nav_skills' ) ); ?></a></li>
				<li><a href="<?php echo esc_url( hp_anchor( 'work' ) ); ?>"><?php echo esc_html( hp_t( 'nav_work' ) ); ?></a></li>
				<li><a href="<?php echo esc_url( hp_anchor( 'experience' ) ); ?>"><?php echo esc_html( hp_t( 'nav_experience' ) ); ?></a></li>
			</ul>
		</nav>
		<a class="hp-btn hp-btn--primary hp-btn--sm" href="<?php echo esc_url( hp_primary_href() ); ?>"><?php echo esc_html( hp_t( 'hire' ) ); ?></a>
	</div>
</header>
