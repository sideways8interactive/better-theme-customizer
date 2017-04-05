<?php

namespace S8\BetterThemeCustomizer\CustomizerControls;

/**
 * Class Dropdown_Taxonomies_Control
 * @package S8\BetterThemeCustomizer\CustomizerControls
 */
class Dropdown_Taxonomies_Control extends \WP_Customize_Control {
	public $type = 'dropdown-taxonomies';

	public function render_content() {
		$taxonomies = get_taxonomies( array(
			'public' => true,
		), 'objects' );
		if ( ! empty( $taxonomies ) ) {
			$choices = array( '' => __( '&mdash; Select &mdash;' ) );
			foreach ( $taxonomies as $taxonomy ) {
				$choices[ $taxonomy->name ] = ( isset( $taxonomy->labels['name'] ) ? $taxonomy->labels['name'] : $taxonomy->name );
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
