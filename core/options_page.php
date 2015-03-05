<?php
defined('ABSPATH') or die("No script kiddies please!");

class SBModalOptionsPage {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_mysettings' ) );
	}

	public function admin_menu() {
		add_options_page( 'SBModal Options', 'SBModal', 'manage_options', 'sbmodal.php', array( $this, 'settings_page' ) );
	}

	public function register_mysettings() {
		register_setting( 'sbmodal-settings-group', 'sbmodal_bootstrapjs' );
		register_setting( 'sbmodal-settings-group', 'sbmodal_bootstrapcss' );
	}

	public function settings_page() {
		$sbmodal_bootstrapjs = SBModalOptions::get('sbmodal_bootstrapjs');
		$sbmodal_bootstrapcss = SBModalOptions::get('sbmodal_bootstrapcss');
?>
<div class="wrap">
	<h2>SBModal Settings</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'sbmodal-settings-group' ); ?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					Enqueue bootstrap.js
				</th>
				<td>
					<select name="sbmodal_bootstrapjs" id="sbmodal_bootstrapjs">
						<option value="1" <?php if($sbmodal_bootstrapjs):?>selected="selected"<?php endif;?> ><?php _e('Yes', 'sbmodal'); ?></option>
						<option value="0" <?php if(!$sbmodal_bootstrapjs):?>selected="selected"<?php endif;?> ><?php _e('No', 'sbmodal'); ?></option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					Enqueue Bootstrap CSS Style
				</th>
				<td>
					<select name="sbmodal_bootstrapcss" id="sbmodal_bootstrapcss">
						<option value="full" <?php if( strcmp($sbmodal_bootstrapcss, 'full')===0):?>selected="selected"<?php endif;?> ><?php _e('Full Bootstrap.css', 'sbmodal'); ?></option>
						<option value="modal" <?php if( strcmp($sbmodal_bootstrapcss, 'modal')===0):?>selected="selected"<?php endif;?> ><?php _e('Styles ONLY for Modal', 'sbmodal'); ?></option>
						<option value="none" <?php if( strcmp($sbmodal_bootstrapcss, 'none')===0):?>selected="selected"<?php endif;?> ><?php _e('Do NOT Load CSS', 'sbmodal'); ?></option>
					</select>
				</td>
			</tr>
		</table>
		
		<input type="hidden" name="action" value="update" />

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'sbmodal'); ?>" />
		</p>
	</form>
</div>
<?php
	}

}