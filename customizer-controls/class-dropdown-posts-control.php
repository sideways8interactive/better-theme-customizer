<?php

namespace S8\BetterThemeCustomizer\CustomizerControls;

/**
 * Class Dropdown_Posts_Control
 * @package S8\BetterThemeCustomizer\CustomizerControls
 */
class Dropdown_Posts_Control extends \WP_Customize_Control {

	public $type = 'dropdown-posts';
	public $post_type = 'post';

	public function render_content() {

		$post_type = ( ! empty( $this->post_type ) ? $this->post_type : 'post' );
		if ( ! empty( $post_type ) && post_type_exists( $post_type ) ) {
			$choices       = array( 0 => __( '&mdash; Select &mdash;' ) );
			$post_id_query = new \WP_Query( array(
				'post_type'      => $post_type,
				'posts_per_page' => - 1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
			) );
			if ( $post_id_query->have_posts() ) {
				$post_ids = $post_id_query->posts;
				foreach ( $post_ids as $id ) {
					$choices[ $id ] = get_the_title( $id );
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
