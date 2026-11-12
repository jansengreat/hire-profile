<?php
/**
 * Isian profil di Appearance > Customize, dengan pratinjau langsung.
 *
 * @package Hire_Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_panel( 'hp_profile', array(
		'title'       => 'Profil Pelamar',
		'description' => 'Isi profil yang dilihat perekrut. Perubahan langsung terlihat di pratinjau sebelum disimpan.',
		'priority'    => 20,
	) );

	$priority = 10;
	foreach ( hp_sections() as $section_id => $section ) {
		$wp_customize->add_section( $section_id, array(
			'title'       => $section['title'],
			'description' => isset( $section['description'] ) ? $section['description'] : '',
			'panel'       => 'hp_profile',
			'priority'    => $priority,
		) );
		$priority += 10;

		foreach ( $section['fields'] as $key => $f ) {
			$setting = 'hp_' . $key;
			$wp_customize->add_setting( $setting, array(
				'default'           => $f['default'],
				'sanitize_callback' => function ( $value ) use ( $f ) {
					return hp_sanitize_field( $value, $f );
				},
			) );

			$args = array(
				'label'       => $f['label'],
				'section'     => $section_id,
				'description' => isset( $f['help'] ) ? $f['help'] : ( isset( $f['text'] ) ? '' : '' ),
			);

			switch ( $f['type'] ) {
				case 'image':
					$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, $args ) );
					break;
				case 'upload':
					$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $setting, $args ) );
					break;
				case 'color':
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, $args ) );
					break;
				case 'checkbox':
					$args['type']  = 'checkbox';
					$args['label'] = isset( $f['text'] ) ? $f['text'] : $f['label'];
					$wp_customize->add_control( $setting, $args );
					break;
				case 'select':
					$args['type']    = 'select';
					$args['choices'] = $f['choices'];
					$wp_customize->add_control( $setting, $args );
					break;
				case 'number':
					$args['type']        = 'number';
					$args['input_attrs'] = array( 'min' => 0, 'step' => 1 );
					$wp_customize->add_control( $setting, $args );
					break;
				default:
					$args['type'] = in_array( $f['type'], array( 'textarea', 'email', 'url' ), true ) ? $f['type'] : 'text';
					$wp_customize->add_control( $setting, $args );
			}
		}
	}
} );

/**
 * Bersihkan nilai sesuai jenis isian.
 */
function hp_sanitize_field( $value, $f ) {
	switch ( $f['type'] ) {
		case 'textarea':
			return sanitize_textarea_field( $value );
		case 'url':
		case 'image':
		case 'upload':
			return esc_url_raw( trim( (string) $value ) );
		case 'email':
			return sanitize_email( $value );
		case 'number':
			return (string) absint( $value );
		case 'checkbox':
			return $value ? '1' : '';
		case 'color':
			$c = sanitize_hex_color( $value );
			return $c ? $c : $f['default'];
		case 'select':
			return array_key_exists( $value, $f['choices'] ) ? $value : $f['default'];
		default:
			return sanitize_text_field( $value );
	}
}
