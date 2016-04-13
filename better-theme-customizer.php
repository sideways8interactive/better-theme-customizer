<?php
/**
 * Plugin Name: Better Theme Customizer
 * Description: A plugin that extends default customizer functionality.
 * Author: Sideways8 Interactive, LLC
 * Author URI: http://sideways8.com/
 * Version: 1.0.0
 */
namespace S8\BetterThemeCustomizer;

use S8\BetterThemeCustomizer\CustomizerControls\Media_Library_Control;
use S8\BetterThemeCustomizer\CustomizerControls\Dropdown_Posts_Control;
use S8\BetterThemeCustomizer\CustomizerControls\Dropdown_Post_Types_Control;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class BetterThemeCustomizer
 * @package S8\BetterThemeCustomizer
 */
class Better_Theme_Customizer {

	const SITE_OPTION = 's8_site_option';

	/**
	 * This prefix is used on panels and sections, options are NEVER prefixed!
	 *
	 * @var string
	 */
	protected $prefix = 's8_';

	/**
	 * This is the unprocessed options array.
	 *
	 * @var array
	 */
	protected $raw_options = array();

	/**
	 * Stores top level sections and panels.
	 *
	 * @var array
	 */
	protected $top_panels_sections = array();

	/**
	 * Stores sub-level sections
	 *
	 * @var array
	 */
	protected $sub_sections = array();

	/**
	 * Stores options (combination of settings and controls)
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * Allowed options for panels.
	 *
	 * @var array
	 */
	protected $allowed_panel_options = array(
		'id'              => 'id',
		'title'           => 'title',
		'priority'        => 'priority',
		'capability'      => 'capability',
		'description'     => 'description',
		'theme_supports'  => 'theme_supports',
		'active_callback' => 'active_callback',
	);

	/**
	 * Allowed options for sections.
	 *
	 * @var array
	 */
	protected $allowed_section_options = array(
		'id'              => 'id',
		'title'           => 'title',
		'priority'        => 'priority',
		'capability'      => 'capability',
		'description'     => 'description',
		'theme_supports'  => 'theme_supports',
		'active_callback' => 'active_callback',
		'panel'           => 'panel',
	);

	/**
	 * Allowed options for settings.
	 *
	 * @var array
	 */
	protected $allowed_setting_options = array(
		'type'                 => 'storage_type',
		'default'              => 'default',
		'transport'            => 'transport',
		'capability'           => 'capability',
		'theme_supports'       => 'theme_supports',
		'sanitize_callback'    => 'sanitize_callback',
		'sanitize_js_callback' => 'sanitize_js_callback',
	);

	/**
	 * Allowed options for controls.
	 *
	 * @var array
	 */
	protected $allowed_control_options = array(
		'type'        => 'type',
		'label'       => 'label',
		'choices'     => 'choices',
		'section'     => 'section',
		'settings'    => 'settings',
		'priority'    => 'priority',
		'description' => 'description',
	);

	/**
	 * BetterThemeCustomizer constructor.
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ) );

		if ( is_multisite() ) {
			add_action( 'customize_update_' . self::SITE_OPTION, array( $this, 'save_multi_site_setting' ), 10, 2 );
		}
	}

	/**
	 * Finds the template where options are stored.
	 */
	public function init() {

		include_once( __DIR__ . '/s8-options.php' );
		include_once( __DIR__ . '/helpers/class-customizer-helpers.php' );
		include_once( __DIR__ . '/helper-functions.php' );
	}

	/**
	 * Fires on the customize_register action, registers all our options
	 *
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public function customize_register( $wp_customize ) {

		require_once( 'customizer-controls/class-media-library-control.php' );
		require_once( 'customizer-controls/class-dropdown-posts-control.php' );
		require_once( 'customizer-controls/class-dropdown-post-types-control.php' );
		// Get and setup options
		$this->raw_options = apply_filters( 's8_options_register', array() );
		$this->process_raw_options( $this->raw_options );

		// Register our options
		$this->register_top_level( $wp_customize );
		$this->register_sub_sections( $wp_customize );
		$this->register_settings_controls( $wp_customize );
	}

	/**
	 * Saves a multi-site theme option as a site option.
	 *
	 * @param mixed $value
	 * @param mixed $wp_customize_setting
	 *
	 * @return bool
	 */
	public function save_multi_site_setting( $value, $wp_customize_setting ) {

		return update_site_option( $wp_customize_setting->id, $value );
	}

	/**
	 * Process our options
	 */
	protected function process_raw_options( $raw_options ) {

		if ( ! empty( $raw_options ) && is_array( $raw_options ) ) {
			foreach ( $raw_options as $item_id => $settings ) {
				if ( isset( $settings['_panel'] ) || isset( $settings['_section'] ) ) {
					if ( isset( $settings['_panel'] ) ) {
						$panel_settings             = $this->extract_args_to_array( $settings['_panel'],
							$this->allowed_panel_options );
						$panel_settings['is_panel'] = true;

						$this->top_panels_sections[ $this->prefix . $item_id ] = $panel_settings;
						unset( $settings['_panel'] );
						$this->process_raw_panel( $settings, $this->prefix . $item_id );
					} else {
						$section_settings             = $this->extract_args_to_array( $settings['_section'],
							$this->allowed_section_options );
						$section_settings['is_panel'] = false;

						$this->_top_panels_sections[ $this->prefix . $item_id ] = $section_settings;
						unset( $settings['_section'] );
						$this->process_raw_section( $settings, $this->prefix . $item_id );
					}
				} else {
					$this->process_raw_section( $settings, false );
				}
			}
		}
	}

	/**
	 * @param array  $options
	 * @param string $panel_id
	 */
	protected function process_raw_panel( $options, $panel_id ) {

		foreach ( $options as $item_id => $settings ) {
			if ( isset( $settings['_section'] ) ) {
				$section_settings = $this->extract_args_to_array( $settings['_section'],
					$this->allowed_section_options );
				if ( ! isset( $section_settings['panel'] ) ) {
					$section_settings['panel'] = $panel_id;
				}
				$this->sub_sections[ $this->prefix . $item_id ] = $section_settings;
				unset( $settings['_section'] );
				$this->process_raw_section( $settings, $this->prefix . $item_id );
			} else {
				$this->process_raw_section( $settings, false );
			}
		}
	}

	/**
	 * @param array       $options
	 * @param string|bool $section_id
	 */
	protected function process_raw_section( $options, $section_id ) {

		foreach ( $options as $item_id => $settings ) {
			if ( false === $section_id ) {
				$settings['priority'] = false;
			} else {
				$settings['section'] = $section_id;
			}
			$this->options[ $item_id ] = $settings;
		}
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	protected function register_top_level( $wp_customize ) {

		$priority = 0;
		foreach ( $this->top_panels_sections as $id => $settings ) {
			if ( ! isset( $settings['priority'] ) ) {
				$priority ++;
				$settings['priority'] = $priority;
			}
			if ( $settings['is_panel'] ) {
				$wp_customize->add_panel( $id, $settings );
			} else {
				$wp_customize->add_section( $id, $settings );
			}
		}
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	protected function register_sub_sections( $wp_customize ) {

		$priority = 0;
		foreach ( $this->sub_sections as $id => $settings ) {
			if ( ! isset( $settings['priority'] ) ) {
				$priority ++;
				$settings['priority'] = $priority;
			}
			$wp_customize->add_section( $id, $settings );
		}
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	protected function register_settings_controls( $wp_customize ) {

		foreach ( $this->options as $setting_id => $args ) {
			$setting_args = $this->extract_args_to_array( $args, $this->allowed_setting_options );

			// Setup code to allow retrieving site option on multi-site (if used)
			if ( isset( $setting_args['type'] ) && self::SITE_OPTION == $setting_args['type'] ) {
				if ( is_multisite() ) {
					add_filter( "customize_value_{$setting_id}", function ( $default ) use ( $setting_id ) {

						return get_site_option( $setting_id, $default );
					} );
				} else {
					// Not multi-site! Use alternate saving method!
					$setting_args['type'] = 'option';
				}
			}

			$wp_customize->add_setting( $setting_id, $setting_args );

			$control_args = $this->extract_args_to_array( $args, $this->allowed_control_options );

			if ( ! isset( $control_args['type'] ) ) {
				$control_args['type'] = 'text';
			}

			switch ( $control_args['type'] ) {
				case 'image':
				case 'media-library':
					$wp_customize->add_control( new Media_Library_Control( $wp_customize, $setting_id,
						$control_args ) );
					break;
				case 'dropdown-post-types':
					$wp_customize->add_control( new Dropdown_Post_Types_Control( $wp_customize, $setting_id,
						$control_args ) );
					break;
				case 'dropdown-posts':
					$control_args = array_merge(
						$control_args,
						$this->extract_args_to_array( $args, array(
							'post_type' => 'post_type',
						) ) );
					$wp_customize->add_control( new Dropdown_Posts_Control( $wp_customize, $setting_id,
						$control_args ) );
					break;

				/* WP Included classes below this line */
				case 'color-picker':
					$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $setting_id,
						$control_args ) );
					break;
				case 'image-control':
					$control_args = array_merge(
						$control_args,
						$this->extract_args_to_array( $args, array(
							'mime_type' => 'mime_type',
						) ) );
					$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, $setting_id,
						$control_args ) );
					break;
				case 'upload-control':
					$control_args = array_merge(
						$control_args,
						$this->extract_args_to_array( $args, array(
							'mime_type' => 'mime_type',
						) ) );
					$wp_customize->add_control( new \WP_Customize_Upload_Control( $wp_customize, $setting_id,
						$control_args ) );
					break;
				default:
					$wp_customize->add_control( $setting_id, $control_args );
			}
		}
	}

	/**
	 * Extracts the args listed in $extract from the data in the $args array
	 *
	 * @param array $args
	 * @param array $extract
	 *
	 * @return array
	 */
	protected function extract_args_to_array( $args, $extract ) {

		$extracted_args = array();
		if ( ! empty( $extract ) && ! empty( $args ) ) {
			foreach ( (array) $extract as $key => $args_key ) {
				if ( isset( $args[ $args_key ] ) ) {
					$extracted_args[ $key ] = $args[ $args_key ];
				}
			}
		}

		return $extracted_args;
	}
}

new Better_Theme_Customizer();