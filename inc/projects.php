<?php
/**
 * Portofolio: jenis konten "Proyek" dengan gambar, link live, repo, dan hasil.
 *
 * @package Hire_Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hp_register_projects() {
	register_post_type( 'hp_project', array(
		'labels'        => array(
			'name'               => 'Portofolio',
			'singular_name'      => 'Proyek',
			'menu_name'          => 'Portofolio',
			'add_new'            => 'Tambah Proyek',
			'add_new_item'       => 'Tambah Proyek',
			'edit_item'          => 'Edit Proyek',
			'new_item'           => 'Proyek Baru',
			'view_item'          => 'Lihat Proyek',
			'all_items'          => 'Semua Proyek',
			'search_items'       => 'Cari Proyek',
			'not_found'          => 'Belum ada proyek.',
			'featured_image'     => 'Screenshot proyek',
			'set_featured_image' => 'Pasang screenshot proyek',
		),
		'public'        => true,
		'has_archive'   => false,
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'rewrite'       => array( 'slug' => 'project' ),
	) );
}
add_action( 'init', 'hp_register_projects' );

add_action( 'after_switch_theme', function () {
	hp_register_projects();
	flush_rewrite_rules();
} );

function hp_project_meta_fields() {
	return array(
		'hp_live'   => array( 'Link situs live / demo', 'url', 'https://' ),
		'hp_repo'   => array( 'Link kode (GitHub)', 'url', 'https://github.com/…' ),
		'hp_result' => array( 'Hasil dengan angka', 'text', 'PageSpeed 98, load time turun 40%, penjualan naik 2x' ),
		'hp_tech'   => array( 'Teknologi (pisahkan koma)', 'text', 'Block theme, React, WooCommerce' ),
		'hp_role'   => array( 'Peran / klien', 'text', 'Solo developer for an agency in Sydney' ),
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'hp_project_meta', 'Detail proyek', 'hp_project_meta_box', 'hp_project', 'normal', 'high' );
} );

function hp_project_meta_box( $post ) {
	wp_nonce_field( 'hp_project_meta', 'hp_project_nonce' );
	echo '<p>Judul = nama proyek. Ringkasan (Excerpt) = 1–2 kalimat masalah dan solusi. Gambar unggulan = screenshot. Isi editor opsional untuk studi kasus lengkap.</p>';
	echo '<table class="form-table" role="presentation">';
	foreach ( hp_project_meta_fields() as $key => $f ) {
		printf(
			'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><input type="%3$s" id="%1$s" name="%1$s" value="%4$s" placeholder="%5$s" class="large-text"></td></tr>',
			esc_attr( $key ),
			esc_html( $f[0] ),
			esc_attr( $f[1] ),
			esc_attr( get_post_meta( $post->ID, $key, true ) ),
			esc_attr( $f[2] )
		);
	}
	echo '</table>';
}

add_action( 'save_post_hp_project', function ( $post_id ) {
	if ( ! isset( $_POST['hp_project_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hp_project_nonce'] ), 'hp_project_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( hp_project_meta_fields() as $key => $f ) {
		$raw   = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ''; // phpcs:ignore
		$value = 'url' === $f[1] ? esc_url_raw( trim( $raw ) ) : sanitize_text_field( $raw );
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
} );

/**
 * Proyek untuk ditampilkan, urut menurut "Order" lalu tanggal.
 */
function hp_projects() {
	return get_posts( array(
		'post_type'      => 'hp_project',
		'posts_per_page' => 12,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		'no_found_rows'  => true,
	) );
}

function hp_project_tech( $post_id ) {
	return array_values( array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post_id, 'hp_tech', true ) ) ) ) );
}
