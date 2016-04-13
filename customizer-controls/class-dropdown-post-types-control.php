<?php

namespace S8\BetterThemeCustomizer\CustomizerControls;

/**
 * Class Dropdown_Post_Types_Control
 * @package S8\BetterThemeCustomizer\CustomizerControls
 */
class Dropdown_Post_Types_Control extends \WP_Customize_Control {

	public $type = 'dropdown-post-types';

	public function render_content() {

		$post_types = get_post_types( array(
			'public' => true,
		), 'objects' );
		if ( ! empty( $post_types ) ) {
			$choices = array( '' => __( '&mdash; Select &mdash;' ) );
			foreach ( $post_types as $post_type ) {
				$choices[ $post_type->name ] = isset( $post_type->labels->name ) ? $post_type->labels->name : $post_type->name;
			}
			?><label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
			if ( ! empty( $this->description ) ) {
				echo "<span class='description customize-control-description'>{$this->description}</span>";
			}
			?>
			<select <?php $this->link(); ?>>
				<?php
				foreach ( $choices as $value => $label ) {
					$selected = '';
					if ( $value == $this->value() ) {
						$selected = ' selected="selected"';
					}
					$value = esc_attr( $value );
					$label = esc_html( $label );
					echo "<option value='{$value}'{$selected}>{$label}</option>";
				}
				?>
			</select>
			</label><?php
		}
	}
}
