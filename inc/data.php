<?php
/**
 * Definisi isian profil, pengambil data, dan label.
 *
 * @package Hire_Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Semua isian profil, dikelompokkan per bagian Customizer.
 */
function hp_sections() {
	return array(
		'hp_identity' => array(
			'title'       => 'Identitas',
			'description' => 'Hal pertama yang dilihat perekrut. Tulis dalam bahasa Inggris untuk lowongan internasional.',
			'fields'      => array(
				'full_name'    => array( 'label' => 'Nama lengkap', 'type' => 'text', 'default' => 'Your Full Name' ),
				'headline'     => array( 'label' => 'Headline', 'type' => 'text', 'default' => 'WordPress developer building custom themes, plugins and Gutenberg blocks', 'help' => 'Satu kalimat spesifik. Hindari sekadar "Web Developer".' ),
				'pitch'        => array( 'label' => 'Ringkasan singkat (hero)', 'type' => 'textarea', 'default' => 'Two or three sentences on what you build and who it helps. Replace this text in Appearance > Customize.', 'help' => '2–3 kalimat: apa yang Anda kerjakan dan buktinya.' ),
				'photo'        => array( 'label' => 'Foto profil', 'type' => 'image', 'default' => '', 'help' => 'Foto wajah yang jelas, rasio persegi atau potret.' ),
				'availability' => array(
					'label'   => 'Status ketersediaan',
					'type'    => 'select',
					'default' => 'available',
					'choices' => array( 'available' => 'Tersedia', 'limited' => 'Terbatas', 'busy' => 'Sedang penuh' ),
				),
				'location'     => array( 'label' => 'Lokasi', 'type' => 'text', 'default' => 'Your City, Country' ),
				'timezone'     => array( 'label' => 'Zona waktu & overlap', 'type' => 'text', 'default' => 'Your time zone and working hours', 'help' => 'Sangat penting bagi perusahaan remote.' ),
				'years'        => array( 'label' => 'Lama pengalaman (tahun)', 'type' => 'number', 'default' => '' ),
				'rate'         => array( 'label' => 'Tipe kerja & tarif', 'type' => 'text', 'default' => 'Full-time, part-time or contract, from $25/hour', 'help' => 'Kosongkan jika tidak ingin ditampilkan.' ),
				'response'     => array( 'label' => 'Waktu balas', 'type' => 'text', 'default' => 'Replies within 24 hours' ),
				'stats'        => array( 'label' => 'Angka pencapaian', 'type' => 'textarea', 'default' => "00 | replace with a real number\n00 | only use figures you can prove", 'help' => 'Satu per baris:  Angka | keterangan. Maksimal 4. Pakai angka yang benar.' ),
			),
		),
		'hp_about'    => array(
			'title'  => 'Tentang & cara kerja',
			'fields' => array(
				'about'      => array( 'label' => 'Tentang saya', 'type' => 'textarea', 'default' => "Write a short, honest introduction: how you got started, what you build now and what you care about in your work.\n\nReplace this text in Appearance > Customize." ),
				'how'        => array( 'label' => 'Cara saya bekerja', 'type' => 'textarea', 'default' => "Clear written English and daily async updates\nGit, pull requests and code review on every project\nStaging site first, then production\nDocumentation handed over with every build", 'help' => 'Satu poin per baris. Ini yang menenangkan perekrut remote.' ),
			),
		),
		'hp_skills'   => array(
			'title'  => 'Keahlian & layanan',
			'fields' => array(
				'skills'   => array( 'label' => 'Keahlian per kelompok', 'type' => 'textarea', 'default' => "WordPress: Block themes & FSE, Classic themes, Custom plugins, Gutenberg blocks, ACF, WooCommerce, WP-CLI\nFront-end: JavaScript (ES6+), React, Tailwind CSS, Sass, Accessibility (WCAG 2.2)\nBack-end: PHP 8, REST API, MySQL, Custom post types, Security hardening\nWorkflow: Git & GitHub, Figma, Local & staging, Core Web Vitals", 'help' => 'Satu kelompok per baris:  Nama kelompok: keahlian, keahlian, keahlian' ),
				'services' => array( 'label' => 'Layanan', 'type' => 'textarea', 'default' => "Custom themes | Block or classic themes built from your Figma file, tuned for Core Web Vitals.\nCustom plugins | Object-oriented plugins with settings screens, custom post types and REST endpoints.\nGutenberg blocks | React blocks your editors can use without breaking the layout.\nWooCommerce | Checkout fields, payment and shipping integrations, store speed fixes.\nCare & speed | Audits, security hardening, updates and bug fixes on existing sites.", 'help' => 'Satu per baris:  Judul | Deskripsi' ),
			),
		),
		'hp_career'   => array(
			'title'       => 'Pengalaman & testimoni',
			'description' => 'Portofolio diisi di menu Portofolio di dashboard, lengkap dengan gambar.',
			'fields'      => array(
				'experience'   => array( 'label' => 'Pengalaman kerja', 'type' => 'textarea', 'default' => "Year – Present | Your role | Where you worked | One line on what you delivered.", 'help' => 'Satu per baris, terbaru di atas:  Periode | Posisi | Perusahaan | Pencapaian dengan angka' ),
				'testimonials' => array( 'label' => 'Testimoni klien', 'type' => 'textarea', 'default' => '', 'help' => 'Satu per baris:  Kutipan | Nama, jabatan, perusahaan. Hanya testimoni asli.' ),
			),
		),
		'hp_contact'  => array(
			'title'  => 'Kontak',
			'fields' => array(
				'email'    => array( 'label' => 'Email', 'type' => 'email', 'default' => '', 'help' => 'Pesan dari form kontak juga dikirim ke sini.' ),
				'whatsapp' => array( 'label' => 'WhatsApp (dengan kode negara)', 'type' => 'text', 'default' => '', 'help' => 'Contoh: 6281234567890' ),
				'linkedin' => array( 'label' => 'URL LinkedIn', 'type' => 'url', 'default' => '' ),
				'github'   => array( 'label' => 'URL GitHub', 'type' => 'url', 'default' => '' ),
				'upwork'   => array( 'label' => 'URL Upwork / profil lain', 'type' => 'url', 'default' => '' ),
				'cv'       => array( 'label' => 'File CV (PDF)', 'type' => 'upload', 'default' => '' ),
				'form'     => array( 'label' => 'Form kontak', 'type' => 'checkbox', 'default' => '1', 'text' => 'Tampilkan form kontak (pesan tersimpan di menu Pesan Masuk)' ),
			),
		),
		'hp_display'  => array(
			'title'  => 'Tampilan',
			'fields' => array(
				'lang'         => array(
					'label'   => 'Bahasa label',
					'type'    => 'select',
					'default' => 'en',
					'choices' => array( 'en' => 'English (disarankan)', 'id' => 'Bahasa Indonesia' ),
				),
				'accent'       => array( 'label' => 'Warna aksen', 'type' => 'color', 'default' => '#3858e9' ),
				'webfont'      => array( 'label' => 'Huruf', 'type' => 'checkbox', 'default' => '1', 'text' => 'Pakai huruf Schibsted Grotesk dari Google Fonts (matikan untuk huruf bawaan perangkat)' ),
				'dialog'       => array( 'label' => 'Dialog perkenalan', 'type' => 'checkbox', 'default' => '1', 'text' => 'Tampilkan tombol mengambang dan dialog perkenalan singkat' ),
				'dialog_auto'  => array( 'label' => 'Buka dialog otomatis', 'type' => 'checkbox', 'default' => '1', 'text' => 'Buka sekali secara otomatis (tidak muncul lagi 7 hari setelah ditutup)' ),
				'dialog_delay' => array( 'label' => 'Jeda dialog (detik)', 'type' => 'number', 'default' => '6' ),
				'footer_note'  => array( 'label' => 'Catatan footer', 'type' => 'text', 'default' => 'This site runs on a custom WordPress theme I designed and built.' ),
			),
		),
	);
}

/**
 * Semua isian dalam satu daftar datar.
 */
function hp_fields() {
	static $flat = null;
	if ( null === $flat ) {
		$flat = array();
		foreach ( hp_sections() as $section ) {
			$flat = array_merge( $flat, $section['fields'] );
		}
	}
	return $flat;
}

/**
 * Ambil nilai isian (theme mod dengan awalan hp_).
 */
function hp_get( $key ) {
	$fields  = hp_fields();
	$default = isset( $fields[ $key ]['default'] ) ? $fields[ $key ]['default'] : '';
	return get_theme_mod( 'hp_' . $key, $default );
}

/**
 * Ubah isian "a | b | c" per baris menjadi array kolom.
 */
function hp_rows( $key, $cols, $sep = '|' ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) hp_get( $key ) ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( $sep, $line, $cols ) );
		$out[] = array_pad( $parts, $cols, '' );
	}
	return $out;
}

/**
 * Daftar satu item per baris.
 */
function hp_lines( $key ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) hp_get( $key ) ) ) ) );
}

/**
 * Kelompok keahlian: array( 'Kelompok' => array( 'a', 'b' ) ).
 */
function hp_skill_groups() {
	$groups = array();
	foreach ( hp_lines( 'skills' ) as $line ) {
		if ( false !== strpos( $line, ':' ) ) {
			list( $name, $list ) = array_map( 'trim', explode( ':', $line, 2 ) );
		} else {
			$name = '';
			$list = $line;
		}
		$items = array_values( array_filter( array_map( 'trim', explode( ',', $list ) ) ) );
		if ( $items ) {
			$groups[] = array( 'name' => $name, 'items' => $items );
		}
	}
	return $groups;
}

/**
 * Semua keahlian tanpa kelompok (untuk schema dan dialog).
 */
function hp_all_skills() {
	$all = array();
	foreach ( hp_skill_groups() as $g ) {
		$all = array_merge( $all, $g['items'] );
	}
	return $all;
}

/**
 * Label antarmuka dalam bahasa Inggris atau Indonesia.
 */
function hp_t( $key ) {
	static $labels = null;
	if ( null === $labels ) {
		$labels = array(
			'en' => array(
				'available'      => 'Available for new work',
				'limited'        => 'Limited availability',
				'busy'           => 'Fully booked right now',
				'nav_about'      => 'About',
				'nav_skills'     => 'Skills',
				'nav_work'       => 'Work',
				'nav_experience' => 'Experience',
				'nav_contact'    => 'Contact',
				'hire'           => 'Hire me',
				'start'          => 'Start a conversation',
				'cv'             => 'Download CV',
				'location'       => 'Based in',
				'timezone'       => 'Working hours',
				'experience_lbl' => 'Experience',
				'years'          => '%s+ years',
				'engagement'     => 'Engagement',
				'response'       => 'Response',
				'about'          => 'About me',
				'how'            => 'How I work',
				'skills'         => 'Skills and tools',
				'services'       => 'What I can build for you',
				'work'           => 'Selected work',
				'work_empty'     => 'Only you can see this. Add your first project under Portofolio in the dashboard, with a screenshot and a live link.',
				'live'           => 'Visit live site',
				'code'           => 'View code',
				'details'        => 'Read case study',
				'experience'     => 'Experience',
				'testimonials'   => 'What clients say',
				'contact'        => 'Tell me about the role',
				'contact_txt'    => 'Share what you are building, the type of engagement and your timeline. I read every message myself.',
				'direct'         => 'Or reach me directly',
				'f_name'         => 'Your name',
				'f_email'        => 'Work email',
				'f_company'      => 'Company',
				'f_type'         => 'Type of work',
				'f_budget'       => 'Budget or rate',
				'f_message'      => 'About the role or project',
				'f_send'         => 'Send message',
				'f_optional'     => 'optional',
				'types'          => array( 'Full-time', 'Part-time', 'Contract', 'One-off project' ),
				'sent'           => 'Message sent. I will reply to your email within 24 hours.',
				'err_invalid'    => 'Message not sent. Add your name, a valid email and a message, then send again.',
				'err_rate'       => 'Message not sent. Too many messages from this connection; try again in 10 minutes or email me directly.',
				'hi'             => "Hi, I'm %s",
				'close'          => 'Close',
				'see_profile'    => 'See full profile',
				'mail_subject'   => 'Remote role for %s',
				'wa_text'        => 'Hi %s, I saw your profile and would like to talk about a role.',
				'back'           => 'Back to profile',
				'not_found'      => 'This page does not exist. The profile is on the home page.',
				'skip'           => 'Skip to content',
				'tech'           => 'Built with',
			),
			'id' => array(
				'available'      => 'Siap menerima pekerjaan',
				'limited'        => 'Ketersediaan terbatas',
				'busy'           => 'Sedang penuh',
				'nav_about'      => 'Tentang',
				'nav_skills'     => 'Keahlian',
				'nav_work'       => 'Portofolio',
				'nav_experience' => 'Pengalaman',
				'nav_contact'    => 'Kontak',
				'hire'           => 'Rekrut saya',
				'start'          => 'Mulai percakapan',
				'cv'             => 'Unduh CV',
				'location'       => 'Lokasi',
				'timezone'       => 'Jam kerja',
				'experience_lbl' => 'Pengalaman',
				'years'          => '%s+ tahun',
				'engagement'     => 'Tipe kerja',
				'response'       => 'Respons',
				'about'          => 'Tentang saya',
				'how'            => 'Cara saya bekerja',
				'skills'         => 'Keahlian dan alat',
				'services'       => 'Yang bisa saya kerjakan',
				'work'           => 'Portofolio pilihan',
				'work_empty'     => 'Hanya Anda yang melihat ini. Tambahkan proyek pertama di menu Portofolio di dashboard, lengkap dengan screenshot dan link live.',
				'live'           => 'Buka situs',
				'code'           => 'Lihat kode',
				'details'        => 'Baca studi kasus',
				'experience'     => 'Pengalaman',
				'testimonials'   => 'Kata klien',
				'contact'        => 'Ceritakan lowongan Anda',
				'contact_txt'    => 'Jelaskan apa yang sedang dibangun, tipe kerja, dan jadwalnya. Saya membaca setiap pesan sendiri.',
				'direct'         => 'Atau hubungi langsung',
				'f_name'         => 'Nama Anda',
				'f_email'        => 'Email kantor',
				'f_company'      => 'Perusahaan',
				'f_type'         => 'Tipe kerja',
				'f_budget'       => 'Anggaran atau tarif',
				'f_message'      => 'Tentang lowongan atau proyek',
				'f_send'         => 'Kirim pesan',
				'f_optional'     => 'opsional',
				'types'          => array( 'Full-time', 'Part-time', 'Kontrak', 'Proyek lepas' ),
				'sent'           => 'Pesan terkirim. Saya akan membalas ke email Anda dalam 24 jam.',
				'err_invalid'    => 'Pesan belum terkirim. Isi nama, email yang valid, dan pesan, lalu kirim lagi.',
				'err_rate'       => 'Pesan belum terkirim. Terlalu banyak pesan dari koneksi ini; coba lagi 10 menit lagi atau kirim email langsung.',
				'hi'             => 'Halo, saya %s',
				'close'          => 'Tutup',
				'see_profile'    => 'Lihat profil lengkap',
				'mail_subject'   => 'Lowongan remote untuk %s',
				'wa_text'        => 'Halo %s, saya melihat profil Anda dan ingin membahas sebuah posisi.',
				'back'           => 'Kembali ke profil',
				'not_found'      => 'Halaman ini tidak ada. Profil ada di halaman depan.',
				'skip'           => 'Langsung ke isi',
				'tech'           => 'Teknologi',
			),
		);
	}
	$lang = 'id' === hp_get( 'lang' ) ? 'id' : 'en';
	return isset( $labels[ $lang ][ $key ] ) ? $labels[ $lang ][ $key ] : $key;
}

/**
 * Tautan kontak yang sudah diisi.
 */
function hp_links() {
	$name  = hp_get( 'full_name' );
	$links = array();
	if ( $email = hp_get( 'email' ) ) {
		$links['email'] = array( 'Email', 'mailto:' . $email . '?subject=' . rawurlencode( sprintf( hp_t( 'mail_subject' ), $name ) ), $email );
	}
	if ( $wa = preg_replace( '/\D/', '', (string) hp_get( 'whatsapp' ) ) ) {
		$links['whatsapp'] = array( 'WhatsApp', 'https://wa.me/' . $wa . '?text=' . rawurlencode( sprintf( hp_t( 'wa_text' ), $name ) ), '+' . $wa );
	}
	foreach ( array( 'linkedin' => 'LinkedIn', 'github' => 'GitHub', 'upwork' => 'Upwork' ) as $k => $label ) {
		if ( $v = hp_get( $k ) ) {
			$host = wp_parse_url( $v, PHP_URL_HOST );
			if ( 'upwork' === $k && $host && false === strpos( $host, 'upwork' ) ) {
				$label = preg_replace( '/^www\./', '', $host );
			}
			$path            = trim( (string) wp_parse_url( $v, PHP_URL_PATH ), '/' );
			$links[ $k ] = array( $label, $v, $path ? $path : $host );
		}
	}
	return $links;
}

function hp_initials( $name ) {
	$out = '';
	foreach ( array_slice( preg_split( '/\s+/', trim( $name ) ), 0, 2 ) as $w ) {
		$out .= function_exists( 'mb_substr' ) ? mb_substr( $w, 0, 1 ) : substr( $w, 0, 1 );
	}
	return function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $out ) : strtoupper( $out );
}

function hp_photo( $class, $size = 480 ) {
	$photo = hp_get( 'photo' );
	$name  = hp_get( 'full_name' );
	if ( $photo ) {
		return sprintf( '<img class="%1$s" src="%2$s" alt="%3$s" width="%4$d" height="%4$d" decoding="async">', esc_attr( $class ), esc_url( $photo ), esc_attr( $name ), (int) $size );
	}
	return sprintf( '<div class="%s hp-photo--initials" aria-hidden="true"><span>%s</span></div>', esc_attr( $class ), esc_html( hp_initials( $name ) ) );
}

function hp_status() {
	$s = hp_get( 'availability' );
	$s = in_array( $s, array( 'available', 'limited', 'busy' ), true ) ? $s : 'available';
	return sprintf( '<p class="hp-status hp-status--%1$s"><span class="hp-status__dot" aria-hidden="true"></span>%2$s</p>', esc_attr( $s ), esc_html( hp_t( $s ) ) );
}

/**
 * Tujuan tombol utama: form kontak bila aktif, jika tidak email.
 */
function hp_primary_href() {
	if ( hp_get( 'form' ) ) {
		return is_front_page() ? '#contact' : home_url( '/#contact' );
	}
	$l = hp_links();
	return isset( $l['email'] ) ? $l['email'][1] : ( is_front_page() ? '#contact' : home_url( '/#contact' ) );
}

/**
 * Tautan bagian (anchor) yang bekerja juga dari halaman lain.
 */
function hp_anchor( $id ) {
	return is_front_page() ? '#' . $id : home_url( '/#' . $id );
}
