<?php
/**
 * Safa functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Safa
 * @since Safa 1.0.4
 */

declare( strict_types = 1 );

if ( ! function_exists( 'Safa_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Safa 1.0.4
	 *
	 * @return void
	 */
	function Safa_support() {

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Make theme available for translation.
		load_theme_textdomain( 'safa' );
	}

endif;

add_action( 'after_setup_theme', 'Safa_support' );

if ( ! function_exists( 'Safa_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Safa 1.0.4
	 *
	 * @return void
	 */
	function Safa_styles() {

		// Register theme stylesheet.
		wp_register_style(
			'Safa-style',
			get_stylesheet_directory_uri() . '/style.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'Safa-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'Safa_styles' );
