<?php
defined('ABSPATH') or die("No script kiddies please!");

class SBModalPostTypes {
	
	private $_templates = null;
	private $_nonce_action = 'sb_testimonials_meta_box';
	private $_nonce_name = 'sb_testimonials_meta_box_nonce';

	public function register() {
		add_action('init', array($this, '_modal'));
	}
	
	private function _register_option_values() {
		$this->_templates = array(
			'simple' => __('Simple', 'sbmodal'),
			'middle' => __('Middle', 'sbmodal'),
			'full' => __('Full', 'sbmodal'),
		);
		
		$templates = apply_filters('sbmodal_templates', $this->_templates);
		
		if ( !empty( $templates ) ) {
			$this->_templates = $templates;
		}

		$this->_widths = array(
			'modal-lg' => __('Large', 'sbmodal'),
			'modal-md' => __('Middle', 'sbmodal'),
			'modal-sm' => __('Small', 'sbmodal'),
		);
		
		$widths = apply_filters('sbmodal_width_classes', $this->_widths);
		
		if ( !empty( $widths ) ) {
			$this->_widths = $widths;
		}
	}
	
	public function _modal() {
		$this->_register_option_values();
		
		global $wp_rewrite;
		$labels = array(
			'name' => _x('Modals', 'post type general name', 'sbuilder'),
			'singular_name' => _x('Modal', 'post type singular name', 'sbuilder'),
			'menu_name' => _x('Modals', 'admin menu', 'sbuilder'),
			'name_admin_bar' => _x('Modal', 'add new on admin bar', 'sbuilder'),
			'add_new' => _x('Add New', 'book', 'sbuilder'),
			'add_new_item' => __('Add New Modal', 'sbuilder'),
			'new_item' => __('New Modal', 'sbuilder'),
			'edit_item' => __('Edit Modal', 'sbuilder'),
			'view_item' => __('View Modal', 'sbuilder'),
			'all_items' => __('All Modal', 'sbuilder'),
			'search_items' => __('Search Modals', 'sbuilder'),
			'parent_item_colon' => __('Parent Modals:', 'sbuilder'),
			'not_found' => __('No Modals found.', 'sbuilder'),
			'not_found_in_trash' => __('No Modals found in Trash.', 'sbuilder')
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'sb_modals'
			),
			'capability_type' => 'page',
			'hierarchical' => false,
			'supports' => array('title', 'editor', 'page-attributes',),
		);
		register_post_type('sb_modals', $args);
		
		add_action( 'add_meta_boxes', array($this, 'sb_modals_add_meta_box') );
		add_action( 'save_post', array($this, 'sb_modals_save_meta_box_data') );

		# 
		add_action( 'manage_sb_modals_posts_custom_column', array( $this, 'action_posts_columns' ), 10, 2 );

		# 
		add_filter( 'manage_sb_modals_posts_columns', array( $this, 'filter_posts_columns' ) );
	}
	
	function sb_modals_add_meta_box() {
		$screens = array( 'sb_modals' );

		foreach ( $screens as $screen ) {
			add_meta_box(
				'sb_modals_options',
				__( 'Options', 'sbuilder' ),
				array( $this, 'sb_modals_options_meta_box_callback' ),
				$screen,
				'side'
			);

			add_meta_box(
				'sb_modals_footer',
				__( 'Modal Footer', 'sbuilder' ),
				array( $this, 'sb_modals_footer_meta_box_callback' ),
				$screen
			);

			add_meta_box(
				'sb_modal_helper',
				__( 'How to use', 'sbuilder' ),
				array( $this, 'sb_modals_helper_meta_box_callback' ),
				$screen,
				'normal',
				'core'
			);
		}
	}

	/**
	 * Options MetaBox Callback
	 */
	public function sb_modals_options_meta_box_callback() {
		global $post;
		wp_nonce_field( $this->_nonce_action, $this->_nonce_name );

		$template = get_post_meta( $post->ID, 'sb_modals__template', true );
		$call_selector = get_post_meta( $post->ID, 'sb_modals__call_selector', true );
		$width = get_post_meta( $post->ID, 'sb_modals__width', true );
		$max_width = get_post_meta( $post->ID, 'sb_modals__max_width', true );
		$class = get_post_meta( $post->ID, 'sb_modals__class', true );
		$id = get_post_meta( $post->ID, 'sb_modals__id', true );
?>
		<p>
			<label for="sb_modals__id"><?php echo __('HTML ID', 'sbmodal'); ?></label>
			<input type="text" name="sb_modals__id" id="sb_modals__id" value="<?php echo esc_attr($id); ?>" placeholder="<?php echo 'OpenModal' . $post->ID; ?>" size="30" />
		</p>

		<p>
			<label for="sb_modals__class"><?php echo __('HTML Class', 'sbmodal'); ?></label>
			<input type="text" name="sb_modals__class" id="sb_modals__class" value="<?php echo esc_attr($class); ?>" placeholder="my-modal-classname" size="30" />
		</p>

		<p>
			<label for="sb_modals__template"><?php echo __('Template', 'sbmodal'); ?></label>
			<select name="sb_modals__template" id="sb_modals__template">
			<?php foreach( $this->_templates as $value => $label):
					$_checked = ( strcmp($value, $template)===0 ) ? 'selected="selected"' : '' ;
			?>
				<option value="<?php echo $value; ?>" <?php echo $_checked; ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="sb_modals__width"><?php echo __('Width', 'sbmodal'); ?></label>
			<select name="sb_modals__width" id="sb_modals__width">
			<?php foreach( $this->_widths as $value => $label):
					$_checked = ( strcmp($value, $width)===0 ) ? 'selected="selected"' : '' ;
			?>
				<option value="<?php echo $value; ?>" <?php echo $_checked; ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="sb_modals__max_width"><?php echo __('Max Width', 'sbmodal'); ?></label>
			<input type="text" name="sb_modals__max_width" id="sb_modals__max_width" value="<?php echo esc_attr($max_width); ?>" placeholder="300" size="5" /><em>px</em>
		</p>

		<p>
			<label for="sb_modals__call_selector"><?php echo __('Custom jQuery Selector', 'sbmodal'); ?></label>
			<input type="text" name="sb_modals__call_selector" id="sb_modals__call_selector" value="<?php echo esc_attr($call_selector); ?>" placeholder="[href='#myModal']" size="30" />
		</p>
<?php
	}

	/**
	 * Modal Footer Metabox Callback
	 */
	function sb_modals_footer_meta_box_callback() {
		global $post;
		wp_nonce_field( $this->_nonce_action, $this->_nonce_name );

		$sb_modals__footer = get_post_meta( $post->ID, 'sb_modals__footer', true );

		wp_editor( $sb_modals__footer, 'sb_modals__footer', array(
			'wpautop'       => true,
			'media_buttons' => false,
			'textarea_name' => 'sb_modals__footer',
			'textarea_rows' => 10,
			'teeny'         => true,
			'tinymce'       => false,
		) );
?>
<p>
	<em>Footer displayed only for template "Full". If you using default options.</em>
</p>
<p>
	<label for="">Close button example:</label>
	<pre><?php echo htmlentities( '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' ); ?></pre>
</p>
<p>
	<label for="">Primary Button example:</label>
	<pre><?php echo htmlentities( '<button type="button" class="btn btn-primary">Save changes</button>' ); ?></pre>
</p>
<?php
	}

	function sb_modals_helper_meta_box_callback() {
		global $post;

		if ( empty( $post->ID ) ) {
			return;
		}

		$modal_html_id = get_post_meta( $post->ID, 'sb_modals__id', true );
		$modal_title = get_the_title( $post->ID );

		if ( empty( $modal_title ) ) {
			$modal_title = __( 'Modal', 'sbmodal' );
		}

		if ( empty( $modal_html_id ) ) {
			$modal_html_id = 'OpenModal' . $post->ID;
		}
		$input_value = "#{$modal_html_id}";
		$example_input_value = "<a href=\"#{$modal_html_id}\">Click to open {$modal_title}</a>";
?>
<?php echo wpautop( esc_html( __( "Copy this code and paste it into link anchor", 'sbmodal' ) ) ); ?>
<input type="text" onfocus="this.select();" readonly="readonly" class="wp-ui-text-highlight code" value="<?php echo esc_attr( $input_value ); ?>" size="40" />
<?php echo wpautop( esc_html( __( "For example:", 'sbmodal' ) ) ); ?>
<input type="text" onfocus="this.select();" readonly="readonly" class="wp-ui-text-highlight code" value="<?php echo esc_attr( $example_input_value ); ?>" size="40" style="width: 100%" />
<?php
	}

	function sb_modals_save_meta_box_data( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		# Check if our nonce is set.
		if ( ! isset( $_POST[ $this->_nonce_name ] ) ) {
			return;
		}
		
		# Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST[ $this->_nonce_name ], $this->_nonce_action ) ) {
			return;
		}

		# Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		# Lets save the data (without validation :o( )
		$fields = array(
			'sb_modals__template',
			'sb_modals__call_selector',
			'sb_modals__width',
			'sb_modals__max_width',
			'sb_modals__class',
		);

		foreach ( $fields as $field ) {
			// Make sure that it is set.
			if ( isset($_POST[$field]) ) {
				// Sanitize user input.
				$val = sanitize_text_field( $_POST[$field] );

				// Update the meta field in the database.
				update_post_meta( $post_id, $field, $val );
			}
		}

		if ( isset($_POST['sb_modals__id']) ) {
			$val = sanitize_text_field( $_POST['sb_modals__id'] );

			if ( empty( $val ) ) {
				$val = 'OpenModal' . $post_id;
			}

			update_post_meta( $post_id, 'sb_modals__id', $val );
		}

		if ( isset($_POST['sb_modals__footer'])) {
			update_post_meta( $post_id, 'sb_modals__footer', $_POST['sb_modals__footer'] );
		}
	}

	public function action_posts_columns( $column, $post_id ) {
		if ( strcmp( $column, 'modal_helper' ) === 0 ) {
			$id = get_post_meta( $post_id, 'sb_modals__id', true );

			if ( empty( $id ) ) {
				$id = 'OpenModal' . $post_id;
				update_post_meta( $post_id, 'sb_modals__id', $id );
			}
			
			$input_value = "#{$id}";
			echo '<input type="text" onfocus="this.select();" readonly="readonly" class="wp-ui-text-highlight code" value="' . esc_attr( $input_value ) . '" size="40" />';
		}
	}

	public function filter_posts_columns( $columns ) {
		unset( $columns['date'] );

		return array_merge(
					$columns,
					array(
						'modal_helper' => __( 'Inset into Link Anchor', 'sbmodal' ),
                    	'date' =>__( 'Date' ),
					)
				);

		return $columns;
	}

}
