<?php

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! function_exists( 'get_better_theme_mod' ) ) {
	function get_better_theme_mod( $mod ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_mod( $mod );

	}
}

if ( ! function_exists( 'the_better_theme_mod' ) ) {
	function the_better_theme_mod( $mod, $args = array() ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::the_mod( $mod, $args );

	}
}

if ( ! function_exists( 'better_theme_mod_copyright' ) ) {
	function better_theme_mod_copyright( $mod ) {

		echo S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::handle_copyright( $mod );

	}
}

if ( ! function_exists( 'the_better_theme_mod_social_icons' ) ) {
	function the_better_theme_mod_social_icons( $args = array() ) {

		echo S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::the_social_media_icons( $args );

	}
}

if ( ! function_exists( 'get_better_theme_mod_social_icons' ) ) {
	function get_better_theme_mod_social_icons( $mod, $args = array() ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_social_media_icons( $mod, $args );

	}
}

if ( ! function_exists( 'better_image_theme_mod' ) ) {
	function better_image_theme_mod( $mod, $image_size, $icon = false ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_image_mod( $mod, $image_size, $icon );

	}
}

if ( ! function_exists( 'better_image_theme_mod_src' ) ) {
	function better_image_theme_mod_src( $mod, $image_size, $icon = false ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_image_mod_src( $mod, $image_size, $icon );

	}
}
