<?php

namespace S8\BetterThemeCustomizer\Helpers;

/**
 * Class Customizer_Helpers
 * @package S8\BetterThemeCustomizer\Helpers
 */
class Customizer_Helpers {

	public static $default_args = [
		'before'  => '',
		'after'   => '',
		'default' => ''
	];

	public static function get_mod( $mod, $args = array() ) {

		$args = wp_parse_args( $args, self::$default_args );

		return $args['before'] . get_theme_mod( $mod ) . $args['after'];
	}

	public static function get_image_mod( $mod, $image_size, $icon ) {

		$image_id = get_theme_mod( $mod );

		return wp_get_attachment_image_src( $image_id, $image_size, $icon );

	}

	public static function get_image_mod_src( $mod, $image_size, $icon ) {

		$image_id = get_theme_mod( $mod );

		$image = wp_get_attachment_image_src( $image_id, $image_size, $icon );

		return $image[0];

	}

}
