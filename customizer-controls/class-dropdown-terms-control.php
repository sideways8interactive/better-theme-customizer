<?php

namespace S8\BetterThemeCustomizer\CustomizerControls;

/**
 * Class Dropdown_Terms_Control
 * @package S8\BetterThemeCustomizer\CustomizerControls
 */
class Dropdown_Terms_Control extends \WP_Customize_Control {
	public $type = 'dropdown-terms';
	public $taxonomy = 'category';

	public function render_content() {
		$taxonomy = ( ! empty( $this->taxonomy ) ? $this->taxonomy : 'category' );
		if ( ! empty( $taxonomy ) && taxonomy_exists( $taxonomy ) ) {
			$choices = array( 0 => __( '&mdash; Select &mdash;' ) );
			$terms   = get_terms( $taxonomy, array( 'hide_empty' => false ) );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$choices[ $term->term_id ] = $term->name;
				}
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
