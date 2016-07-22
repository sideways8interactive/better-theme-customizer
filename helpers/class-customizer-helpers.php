<?php

namespace S8\BetterThemeCustomizer\Helpers;

/**
 * Class Customizer_Helpers
 * @package S8\BetterThemeCustomizer\Helpers
 */
class Customizer_Helpers {

	/**
	 * Print theme mod.
	 *
	 * @param       $mod
	 * @param array $args
	 */
	public static function the_mod( $mod, $args = array() ) {

		$mod = self::get_mod( $mod );

		$args = wp_parse_args( $args, array(
			'default'      => false,
			// The default supplied to get_theme_mod, false is default
			'before'       => '',
			// Is echoed out before the theme_mod value
			'after'        => '',
			// Is echoed out after the theme_mod value
			'esc_callback' => 'esc_html',
			// Used to escape the output, can pass any valid callback. False will force no callback.
		) );

		if ( false === $args['esc_callback'] ) {
			// No escaping of output!
		} elseif ( is_callable( $args['esc_callback'] ) ) {
			$mod = call_user_func( $args['esc_callback'], $mod );
		} else {
			$mod = esc_html( $mod );
		}

		if ( ! empty( $mod ) ) {
			echo $args['before'] . $mod . $args['after'];
		}
	}

	/**
	 * Return theme mod.
	 *
	 * @param string $mod
	 *
	 * @return string
	 */
	public static function get_mod( $mod ) {

		return get_theme_mod( $mod );
	}

	/**
	 * Return image type theme mod.
	 *
	 * @param string $mod
	 * @param string $image_size
	 * @param bool   $icon
	 *
	 * @return array|false
	 */
	public static function get_image_mod( $mod, $image_size, $icon ) {

		$image_id = get_theme_mod( $mod );

		return wp_get_attachment_image_src( $image_id, $image_size, $icon );

	}

	/**
	 * Return image type theme mod src.
	 *
	 * @param string $mod
	 * @param string $image_size
	 * @param bool   $icon
	 *
	 * @return string
	 */
	public static function get_image_mod_src( $mod, $image_size, $icon ) {

		$image_id = get_theme_mod( $mod );

		$image = wp_get_attachment_image_src( $image_id, $image_size, $icon );

		return $image[0];

	}

	/**
	 * Handles copyright parsing.
	 *
	 * @param $copyright_text
	 *
	 * @return mixed
	 */
	public static function handle_copyright( $copyright_text ) {
		$search = array(
			'_YEAR_',
			'_SITE_NAME_',
		);

		$replace = array(
			date( 'Y', current_time( 'timestamp' ) ),
			get_bloginfo( 'name' ),
		);

		$copyright_text = str_replace( $search, $replace, $copyright_text );

		return $copyright_text;
	}

	/**
	 * Returns the html markup for our social media icons
	 *
	 * @param array $args {
	 *      Args array
	 *
	 * @type string $before HTML to output before icons
	 * @type string $after HTML to output after icons
	 * @type bool   $use_square When true, will use the square version of icons if available
	 * }
	 *
	 * @return string
	 */
	public static function get_social_media_icons( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'before'      => '<div class="bto-social-icons">',
			'after'       => '</div>',
			'use_square'  => true,
			'size'        => '',
			'text_only'   => false,
			'break_after' => 0
		) );

		$break_count = 0;

		$icon_size = '';
		if ( $args['size'] ) {
			$icon_size = ' fa-' . $args['size'];
		}

		$icon_list = array(
			'bto_facebook_url'  => ( $args['use_square'] ) ? 'fa-facebook-square' . $icon_size : 'fa-facebook' . $icon_size,
			'bto_twitter_url'   => ( $args['use_square'] ) ? 'fa-twitter-square' . $icon_size : 'fa-twitter' . $icon_size,
			'bto_youtube_url'   => ( $args['use_square'] ) ? 'fa-youtube-square' . $icon_size : 'fa-youtube' . $icon_size,
			'bto_instagram_url' => 'fa-instagram' . $icon_size,
			'bto_linkedin_url'  => ( $args['use_square'] ) ? 'fa-linkedin-square' . $icon_size : 'fa-linkedin' . $icon_size,
			'bto_rss_url'       => ( $args['use_square'] ) ? 'fa-rss-square' . $icon_size : 'fa-rss' . $icon_size,
		);

		// Define text associated with social media
		$icon_text = array(
			'bto_facebook_url'  => 'Facebook',
			'bto_twitter_url'   => 'Twitter',
			'bto_youtube_url'   => 'YouTube',
			'bto_instagram_url' => 'Instagram',
			'bto_linkedin_url'  => 'LinkedIn',
			'bto_rss_url'       => 'RSS',
		);

		// remove social icons depending on $args['remove']
		if ( isset( $args['remove'] ) && is_array( $args['remove'] ) ) {
			foreach ( $args['remove'] as $ricon ) {
				unset( $icon_list[ $ricon ] );
			}
		}

		$html  = '';
		$links = array();

		if ( $args['text_only'] ) { // for text only, just print the text from the $icon_text array
			foreach ( $icon_text as $option => $text ) {
				$break_count ++;
				$url = get_theme_mod( $option );
				if ( ! empty( $url ) ) {
					$break_after = $break_count === $args['break_after'] ? '<br>' : '';
					$url         = esc_url( $url );
					$text        = filter_var( $text, FILTER_SANITIZE_STRING );
					$links[]     = "<a href='{$url}' target='_blank' class='bto-social-media-link'>$text</a>$break_after";
				}
			}
		} else {
			foreach ( $icon_list as $option => $css_class ) {
				$break_count ++;
				$url = get_theme_mod( $option );
				if ( ! empty( $url ) ) {
					$break_after = $break_count === $args['break_after'] ? '<br>' : '';
					$url         = esc_url( $url );
					$css_class   = esc_attr( $css_class );
					$links[]     = "<a href='{$url}' target='_blank' class='bto-social-media-link'><i class='fa {$css_class}'></i></a>$break_after";
				}
			}
		}

		if ( ! empty( $links ) ) {
			$html = $args['before'] . implode( ' ', $links ) . $args['after'];
		}

		return $html;
	}

	/**
	 * Outputs the theme social media icons
	 *
	 * @param array $args {
	 *      Args array
	 *
	 * @type string $before HTML to output before icons
	 * @type string $after HTML to output after icons
	 * @type bool   $use_square When true, will use the square version of icons if available
	 * }
	 */
	public static function the_social_media_icons( $args = array() ) {
		echo self::get_social_media_icons( $args );
	}

}
