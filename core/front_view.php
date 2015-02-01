<?php
defined('ABSPATH') or die("No script kiddies please!");

class SBModalFrontView {

	public function __construct() {
		add_action( 'wp_footer', array($this, 'print_modals'), 20 );
	}

	public function print_modals() {
		$query_args = array(
			'post_type' => 'sb_modals',
			'posts_per_page' => 0,
			'nopaging' => true,
		);
		
		$the_query = new WP_Query( $query_args );
		
		if ( !$the_query->have_posts() ) {
			return;
		}
		
		$html_buff = '';
		$script_buff = '';
		
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$modal_id = get_the_ID();
			
			$template = get_post_meta($modal_id, 'sb_modals__template', true);
			$call_selector = get_post_meta($modal_id, 'sb_modals__call_selector', true);
			$call_selector = str_replace('"', '\\"', $call_selector);
			
			$width = get_post_meta($modal_id, 'sb_modals__width', true);
			$max_width = get_post_meta($modal_id, 'sb_modals__max_width', true);
			
			$class = get_post_meta($modal_id, 'sb_modals__class', true);
			$id = get_post_meta($modal_id, 'sb_modals__id', true);

			$modal_footer = get_post_meta($modal_id, 'sb_modals__footer', true);
			
			if ( empty($id) ) {
				$id = uniqid('sbmodal_');
			}
			
			$modal_title = get_the_title();
			$modal_content = apply_filters('the_content', get_the_content());
			
			$this->render( $template, array(
				'width' => $width,
				'max_width' => $max_width,
				'class' => $class,
				'id' => $id,
				'modal_title' => $modal_title,
				'modal_content' => $modal_content,
				'modal_footer' => $modal_footer,
			) );
			
			$script_buff .= $this->generate_javascript( $call_selector, $id );
		}
		
		wp_reset_query();
		wp_reset_postdata();
?>
<script type="text/javascript">
(function($) {
	"use strict";
	$(document).on('ready', function(){
<?php echo $script_buff; ?>
	});
})(jQuery);
</script>
<?php
	}
	
	private function render( $template, $args ) {
		extract( $args );
		
		$style = '';
		
		if ( !empty( $max_width ) ) {
			$max_width = intval( $max_width );
			
			if ( $max_width > 0 ) {
				$style = "max-width: {$max_width}px; ";
			}
		}
?>
		<div class="modal fade <?php echo $class; ?>" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog <?php echo $width; ?>" style="<?php echo $style; ?>">
				<div class="modal-content">
					<?php $this->renderTemplate( $template, $args ); ?>
				</div>
			</div>
		</div>
<?php
	}
	
	public function renderTemplate( $template, $args ) {
		$template_path = SBModalFront::app()->getTemplatePath() . $template . '.php';
		$client_template_path = SBModalFront::app()->getClientTemplatePath() . $template . '.php';
		
		extract($args);
		
		if ( is_file( $client_template_path ) ) {
			require $client_template_path;
		} else if ( is_file( $template_path ) ) {
			require $template_path;
		} else {
			throw new Exception( sprintf(__('Template "%s" is not exists!', 'sbmodal'), $template) );
		}
	}
	
	private function generate_javascript( $call_selector, $modal_id ) {
		ob_start();
?>
		$("<?php echo $call_selector; ?>").click(function(e){ e.preventDefault(); jQuery('#<?php echo $modal_id; ?>').modal('show'); });
<?php
		return ob_get_clean();
	}
}