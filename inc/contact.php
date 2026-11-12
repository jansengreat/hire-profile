<?php
/**
 * Form kontak: pesan disimpan di dashboard (menu Pesan Masuk) dan dikirim ke email.
 * Pesan tetap tersimpan walau email server terlambat atau masuk spam.
 *
 * @package Hire_Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_post_type( 'hp_message', array(
		'labels'          => array(
			'name'          => 'Pesan Masuk',
			'singular_name' => 'Pesan',
			'menu_name'     => 'Pesan Masuk',
			'edit_item'     => 'Pesan',
			'all_items'     => 'Semua Pesan',
			'not_found'     => 'Belum ada pesan dari calon pemberi kerja.',
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-email-alt',
		'menu_position'   => 4,
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

/* Kolom tambahan di daftar pesan. */
add_filter( 'manage_hp_message_posts_columns', function ( $cols ) {
	return array(
		'cb'         => $cols['cb'],
		'title'      => 'Dari',
		'hp_email'   => 'Email',
		'hp_company' => 'Perusahaan',
		'hp_type'    => 'Tipe kerja',
		'date'       => 'Tanggal',
	);
} );

add_action( 'manage_hp_message_posts_custom_column', function ( $col, $post_id ) {
	$v = get_post_meta( $post_id, $col, true );
	if ( 'hp_email' === $col && $v ) {
		printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $v ) );
		return;
	}
	echo esc_html( $v ? $v : '—' );
}, 10, 2 );

/* Detail pengirim saat pesan dibuka. */
add_action( 'add_meta_boxes_hp_message', function () {
	add_meta_box( 'hp_message_meta', 'Pengirim', function ( $post ) {
		$rows = array(
			'Email'      => get_post_meta( $post->ID, 'hp_email', true ),
			'Perusahaan' => get_post_meta( $post->ID, 'hp_company', true ),
			'Tipe kerja' => get_post_meta( $post->ID, 'hp_type', true ),
			'Anggaran'   => get_post_meta( $post->ID, 'hp_budget', true ),
		);
		echo '<table class="widefat striped"><tbody>';
		foreach ( $rows as $label => $v ) {
			echo '<tr><th style="width:140px">' . esc_html( $label ) . '</th><td>' . esc_html( $v ? $v : '—' ) . '</td></tr>';
		}
		echo '</tbody></table>';
		$email = get_post_meta( $post->ID, 'hp_email', true );
		if ( $email ) {
			printf( '<p><a class="button button-primary" href="mailto:%s?subject=%s">Balas lewat email</a></p>', esc_attr( $email ), rawurlencode( 'Re: ' . $post->post_title ) );
		}
	}, 'hp_message', 'side', 'high' );
} );

/* Jumlah pesan baru di menu admin. */
add_action( 'admin_menu', function () {
	global $menu;
	$count = (int) get_option( 'hp_unread', 0 );
	if ( $count < 1 || ! is_array( $menu ) ) {
		return;
	}
	foreach ( $menu as $i => $item ) {
		if ( isset( $item[2] ) && 'edit.php?post_type=hp_message' === $item[2] ) {
			$menu[ $i ][0] .= ' <span class="awaiting-mod"><span class="pending-count">' . $count . '</span></span>'; // phpcs:ignore
		}
	}
}, 99 );

add_action( 'load-edit.php', function () {
	if ( isset( $_GET['post_type'] ) && 'hp_message' === $_GET['post_type'] ) { // phpcs:ignore
		update_option( 'hp_unread', 0, false );
	}
} );

/* Proses kiriman form. */
function hp_handle_contact() {
	$back = home_url( '/' );

	if ( ! isset( $_POST['hp_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hp_nonce'] ), 'hp_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'hp_msg', 'invalid', $back ) . '#contact' );
		exit;
	}

	// Honeypot: manusia tidak melihat kolom ini, bot biasanya mengisinya.
	if ( ! empty( $_POST['hp_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'hp_msg', 'sent', $back ) . '#contact' );
		exit;
	}

	$ip_key = 'hp_rate_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'x' );
	$tries  = (int) get_transient( $ip_key );
	if ( $tries >= 3 ) {
		wp_safe_redirect( add_query_arg( 'hp_msg', 'rate', $back ) . '#contact' );
		exit;
	}

	$name    = isset( $_POST['hp_name'] ) ? sanitize_text_field( wp_unslash( $_POST['hp_name'] ) ) : '';
	$email   = isset( $_POST['hp_email'] ) ? sanitize_email( wp_unslash( $_POST['hp_email'] ) ) : '';
	$company = isset( $_POST['hp_company'] ) ? sanitize_text_field( wp_unslash( $_POST['hp_company'] ) ) : '';
	$type    = isset( $_POST['hp_type'] ) ? sanitize_text_field( wp_unslash( $_POST['hp_type'] ) ) : '';
	$budget  = isset( $_POST['hp_budget'] ) ? sanitize_text_field( wp_unslash( $_POST['hp_budget'] ) ) : '';
	$message = isset( $_POST['hp_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hp_message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === trim( $message ) ) {
		wp_safe_redirect( add_query_arg( 'hp_msg', 'invalid', $back ) . '#contact' );
		exit;
	}

	set_transient( $ip_key, $tries + 1, 10 * MINUTE_IN_SECONDS );

	$title   = $company ? $name . ' — ' . $company : $name;
	$post_id = wp_insert_post( array(
		'post_type'    => 'hp_message',
		'post_status'  => 'publish',
		'post_title'   => $title,
		'post_content' => $message,
	) );

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, 'hp_email', $email );
		update_post_meta( $post_id, 'hp_company', $company );
		update_post_meta( $post_id, 'hp_type', $type );
		update_post_meta( $post_id, 'hp_budget', $budget );
		update_option( 'hp_unread', (int) get_option( 'hp_unread', 0 ) + 1, false );
	}

	$to   = hp_get( 'email' ) ? hp_get( 'email' ) : get_option( 'admin_email' );
	$body = "Pesan baru dari profil Anda:\n\n"
		. "Nama: {$name}\nEmail: {$email}\nPerusahaan: {$company}\nTipe kerja: {$type}\nAnggaran: {$budget}\n\n"
		. $message . "\n\n—\nLihat semua pesan: " . admin_url( 'edit.php?post_type=hp_message' );
	wp_mail( $to, '[Profil] Pesan baru dari ' . $title, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_safe_redirect( add_query_arg( 'hp_msg', 'sent', $back ) . '#contact' );
	exit;
}
add_action( 'admin_post_nopriv_hp_contact', 'hp_handle_contact' );
add_action( 'admin_post_hp_contact', 'hp_handle_contact' );
