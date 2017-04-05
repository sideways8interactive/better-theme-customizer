<?php

namespace S8\BetterThemeCustomizer\CustomizerControls;

/**
 * Class Dropdown_gForm_Control
 * @package S8\BetterThemeCustomizer\CustomizerControls
 */
class Dropdown_gForm_Control extends \WP_Customize_Control {
	public $type = 'dropdown-gform';

	public function render_content() {
		if ( class_exists( '\RGFormsModel' ) ) {
			$forms   = \RGFormsModel::get_forms();
			$choices = array( 0 => __( '&mdash; Select &mdash;' ) );
			foreach ( $forms as $form ) {
				$choices[ $form->id ] = $form->title;
			}

			if ( 1 < count( $choices ) ) {
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
}
