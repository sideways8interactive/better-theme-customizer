<?php

/**
 * These are default theme options for the Better Theme Customizer Plugin.
 *
 * You can either use the btc-options.php in the PLUGIN_ROOT or use it directly in your theme.
 * Include theme options hierarchy goes as follows:
 * THEME_ROOT/includes/btc-options.php > THEME_ROOT/btc-options.php > PLUGIN_ROOT/btc-options.php
 *
 * TODO: write documentation in readme
 */
add_filter( 'btc_options_register', function ( $settings ) {
	$settings_array = array(
		'general_options'  => array(
			'_panel'         => array(
				'title' => __( 'General Options' ),
			),
			'header_options' => array(
				'_section'  => array(
					'title' => __( 'Header Options' ),
				),
				'site_logo' => array(
					'label' => __( 'Site Logo' ),
					'type'  => 'media-library',
				),
			),
			'footer_options' => array(
				'_section'              => array(
					'title' => __( 'Footer Options' ),
				),
				'footer_logo'           => array(
					'label' => __( 'Footer Logo' ),
					'type'  => 'media-library',
				),
				'footer_nav_title'      => array(
					'label'   => __( 'Menu Column Title' ),
					'type'    => 'text',
					'default' => 'Site Map',
				),
				'footer_column_1_title' => array(
					'label'   => __( 'Column 1 Title' ),
					'type'    => 'text',
					'default' => 'Column Title',
				),
				'footer_column_1_text'  => array(
					'label' => __( 'Column 1 Text' ),
					'type'  => 'textarea',
				),
				'footer_column_2_title' => array(
					'label'   => __( 'Column 2 Title' ),
					'type'    => 'text',
					'default' => 'Column Title',
				),
				'footer_column_2_text'  => array(
					'label' => __( 'Column 2 Text' ),
					'type'  => 'textarea',
				),
				'footer_column_3_title' => array(
					'label'   => __( 'Column 3 Title' ),
					'type'    => 'text',
					'default' => 'Column Title',
				),
				'footer_column_3_text'  => array(
					'label' => __( 'Column 3 Text' ),
					'type'  => 'textarea',
				),
				'footer_copyright'      => array(
					'label'       => __( 'Copyright' ),
					'type'        => 'textarea',
					'description' => __( 'The copyright that appears in the footer. Use "_YEAR_" any where in this box to have it auto-replaced with the current year. "_SITE_NAME_" will be auto-replaced with the site name.' ),
					'default'     => '&copy; _YEAR_ _SITE_NAME_',
				),
			),
			'social_media'   => array(
				'_section'              => array(
					'title' => __( 'Social Media' ),
				),
				'social_follow_text'    => array(
					'label'   => __( 'Social Media "Follow" Text' ),
					'default' => 'Follow us',
				),
				'btc_youtube_url'   => array(
					'label' => __( 'YouTube URL' ),
				),
				'btc_linkedin_url'  => array(
					'label' => __( 'LinkedIn URL' ),
				),
				'btc_facebook_url'  => array(
					'label' => __( 'Facebook URL' ),
				),
				'btc_twitter_url'   => array(
					'label' => __( 'Twitter URL' ),
				),
				'btc_instagram_url' => array(
					'label' => __( 'Instagram URL' ),
				),
				'btc_rss_url'       => array(
					'label' => __( 'RSS URL' ),
				),
			),
		),
		'homepage_options' => array(
			'_panel'     => array(
				'title' => __( 'Homepage Options' ),
			),
			'hp_samples' => array(
				'_section'           => array(
					'title' => __( 'Sample Options' ),
				),
				'hp_sample_text'          => array(
					'label'   => __( 'Sample Text' ),
					'default' => 'Sample Text',
				),
				'hp_sample_textarea'          => array(
					'label'   => __( 'Sample TextArea' ),
					'default' => 'Sample TextArea',
				),
				'hp_sample_image' => array(
					'label' => __( 'Sample Image' ),
					'type'  => 'media-library',
				),
				'hp_sample_posts' => array(
					'label' => __( 'Sample Dropdown Posts' ),
					'type'  => 'dropdown-posts',
				),
				'hp_sample_post_types' => array(
					'label' => __( 'Sample Dropdown Post Types' ),
					'type'  => 'dropdown-post-types',
				),

			),
		),
	);

	return array_merge( $settings, $settings_array );
}, 1 );
