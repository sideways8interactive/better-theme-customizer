<?php

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Calls the better_theme_customizer static methods.
 */
if ( ! function_exists( 'better_theme_customizer' ) ) {
	function better_theme_customizer() {
		$args = func_get_args();
		$function_called = array_splice( $args, 0, 1 )[0];

		if ( method_exists( 'S8\BetterThemeCustomizer\Helpers\Customizer_Helpers', $function_called )
		     && is_callable( array( 'S8\BetterThemeCustomizer\Helpers\Customizer_Helpers', $function_called ) )
		) {
			return call_user_func_array( array( 'S8\BetterThemeCustomizer\Helpers\Customizer_Helpers', $function_called ), $args );
		} else {
			$function_clean = htmlentities( $function_called );
			trigger_error( __( "Invalid call to {$function_clean} via the Better Theme Customizer",
				'better-theme-customizer' ), E_USER_NOTICE );
		}

	}
}
