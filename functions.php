<?php
/**
 * Hire Profile — fungsi tema.
 *
 * @package Hire_Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HP_VERSION', '1.0.0' );

require get_template_directory() . '/inc/data.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/projects.php';
require get_template_directory() . '/inc/contact.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_image_size( 'hp-project', 1200, 750, true );
} );

/* Aset depan. */
add_action( 'wp_enqueue_scripts', function () {
	if ( hp_get( 'webfont' ) ) {
		wp_enqueue_style( 'hp-font', 'https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:ital,wght@0,400..900;1,400..900&display=swap', array(), null );
	}
	wp_enqueue_style( 'hp-style', get_stylesheet_uri(), array(), HP_VERSION );

	$accent = sanitize_hex_color( hp_get( 'accent' ) );
	if ( $accent ) {
		wp_add_inline_style( 'hp-style', ':root{--accent:' . $accent . ';}' );
	}

	wp_enqueue_script( 'hp-theme', get_template_directory_uri() . '/assets/theme.js', array(), HP_VERSION, true );
	wp_add_inline_script( 'hp-theme', 'window.HP=' . wp_json_encode( array(
		'autoOpen' => (bool) hp_get( 'dialog' ) && (bool) hp_get( 'dialog_auto' ) && ! is_customize_preview(),
		'delay'    => max( 0, (int) hp_get( 'dialog_delay' ) ),
	) ) . ';', 'before' );
} );

add_filter( 'wp_resource_hints', function ( $urls, $type ) {
	if ( 'preconnect' === $type && hp_get( 'webfont' ) ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

/* Judul tab browser di halaman depan: Nama — Headline. */
add_filter( 'document_title_parts', function ( $parts ) {
	if ( is_front_page() ) {
		return array( 'title' => hp_get( 'full_name' ), 'tagline' => hp_get( 'headline' ) );
	}
	return $parts;
} );

/* SEO: deskripsi, Open Graph, dan data terstruktur Person. */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$name  = hp_get( 'full_name' );
	$desc  = wp_trim_words( hp_get( 'pitch' ), 30, '…' );
	$photo = hp_get( 'photo' );

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $name . ' — ' . hp_get( 'headline' ) ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( home_url( '/' ) ) );
	echo '<meta property="og:type" content="profile">' . "\n";
	echo '<meta name="twitter:card" content="summary">' . "\n";
	if ( $photo ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $photo ) );
	}
	printf( '<meta name="theme-color" content="%s">' . "\n", esc_attr( sanitize_hex_color( hp_get( 'accent' ) ) ) );

	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Person',
		'name'        => $name,
		'jobTitle'    => hp_get( 'headline' ),
		'description' => hp_get( 'pitch' ),
		'url'         => home_url( '/' ),
		'knowsAbout'  => hp_all_skills(),
	);
	if ( hp_get( 'location' ) ) {
		$data['homeLocation'] = array( '@type' => 'Place', 'name' => hp_get( 'location' ) );
	}
	if ( $photo ) {
		$data['image'] = $photo;
	}
	$same = array_values( array_filter( array( hp_get( 'linkedin' ), hp_get( 'github' ), hp_get( 'upwork' ) ) ) );
	if ( $same ) {
		$data['sameAs'] = $same;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 1 );

/* Pengingat di dashboard. */
add_action( 'admin_notices', function () {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	if ( function_exists( 'rhp_render_profile' ) ) {
		echo '<div class="notice notice-warning"><p><strong>Hire Profile:</strong> plugin <em>Remote Hire Profile</em> masih aktif. Tema ini sudah berisi profil dan dialog yang sama, jadi nonaktifkan plugin itu di <a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">Plugins</a> agar tidak tampil dobel.</p></div>';
	}
	if ( 'Your Full Name' === hp_get( 'full_name' ) ) {
		echo '<div class="notice notice-info"><p><strong>Hire Profile:</strong> isi profil Anda di <a href="' . esc_url( admin_url( 'customize.php?autofocus[panel]=hp_profile' ) ) . '">Appearance › Customize › Profil Pelamar</a>, lalu tambahkan proyek di menu <a href="' . esc_url( admin_url( 'edit.php?post_type=hp_project' ) ) . '">Portofolio</a>.</p></div>';
	}
} );

/* Tautan cepat ke Customizer di bar admin. */
add_action( 'admin_bar_menu', function ( $bar ) {
	if ( current_user_can( 'edit_theme_options' ) ) {
		$bar->add_node( array(
			'id'    => 'hp-edit-profile',
			'title' => 'Edit profil',
			'href'  => admin_url( 'customize.php?autofocus[panel]=hp_profile' ),
		) );
	}
}, 80 );
