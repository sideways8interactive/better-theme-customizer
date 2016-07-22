<?php

namespace S8\BetterThemeCustomizer\CustomizerControls;

/**
 * Class Media_Library_Control
 * @package S8\AdvancedThemeCustomizer\CustomizerControls
 */
class Media_Library_Control extends \WP_Customize_Control {

	public $type = 'media-library';
	public $default = 0;

	public function enqueue() {

		wp_enqueue_media();
		$is_min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		// This ensures that the WP media library loads all that it needs on the customize page
		add_action( 'customize_controls_print_footer_scripts', 'wp_print_media_templates' );
		wp_enqueue_script( 's8-theme-customizer',
			plugins_url() . "/better-theme-customizer/customizer-controls/customizer-media-library{$is_min}.js",
			array( 'jquery' ), false, true );
	}

	public function render_content() {

		$disabled = 'disabled="disabled"';
		$image    = false;
		$image_id = $this->value();
		if ( ! empty( $image_id ) ) {
			$image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
			if ( $image ) {
				$image = $image[0];
			}
		}
		?>
		<p>
			<label><span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span></label>
			<?php
			if ( ! empty( $this->description ) ) {
				echo "<span class='description customize-control-description'>{$this->description}</span>";
			}
			?>
			<button type="button" class="button button-secondary s8_customizer_uploader"
			        id="<?php echo esc_attr( $this->id ); ?>"
			        data-title="<?php esc_attr_e( 'Select an image' ); ?>"
			        data-button="<?php esc_attr_e( 'Use image' ); ?>"
			        data-upload-type="image"
			        value="<?php esc_attr_e( 'Select Image' ); ?>"><?php _e( 'Select Image' ); ?></button>
			<button type="button"
			        class="button button-secondary s8_customizer_uploader_remove <?php echo esc_attr( $this->id ); ?>"
			        data-id="<?php echo esc_attr( $this->id ); ?>" <?php if ( ! $image ) {
				echo $disabled;
			} ?>
			        value="<?php esc_attr_e( 'Remove Image' ); ?>"><?php esc_attr_e( 'Remove Image' ); ?></button>
			<input type="hidden" <?php $this->link(); ?>
			       value="<?php echo ( ! empty( $image_id ) ) ? esc_attr( $image_id ) : 0; ?>"
			       class="s8_customizer_uploader_output_id <?php echo esc_attr( $this->id ); ?>"/>
		</p>
		<img class="s8_customizer_uploader_output <?php echo esc_attr( $this->id ); ?>"
		     style="opacity: <?php echo ( $image ) ? 1 : 0; ?>; max-width: 100%; height: auto;"
		     src="<?php if ( $image ) {
			     echo $image;
		     } ?>" alt=""/>
		<?php
	}
}
