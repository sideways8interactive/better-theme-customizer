<?php

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! function_exists( 'better_theme_mod' ) ) {
	function better_theme_mod( $mod, $args = array() ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_mod( $mod, $args );

	}
}

if ( ! function_exists( 'better_image_theme_mod' ) ) {
	function better_image_theme_mod( $mod, $image_size, $icon = false ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_image_mod( $mod, $image_size, $icon );

	}
}

if ( ! function_exists( 'better_image_theme_mod_src' ) ) {
	function better_image_src_theme_mod( $mod, $image_size, $icon = false ) {

		return S8\BetterThemeCustomizer\Helpers\Customizer_Helpers::get_image_mod_src( $mod, $image_size, $icon );

	}
}
