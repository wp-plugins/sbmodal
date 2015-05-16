<?php
defined('ABSPATH') or die("No script kiddies please!");

class SBModalOptions {
	private static $_defaults = null;

	public static function defaults() {
		if ( is_null( self::$_defaults ) ) {
			self::$_defaults = array(
				'sbmodal_bootstrapjs' => 1,
				'sbmodal_bootstrapcss' => 'modal',
			);
		}

		return self::$_defaults;
	}

	public static function get( $option_name ) {
		$defaults = self::defaults();

		if ( !isset( $defaults[$option_name] ) ) {
			throw new Exception("SBModalOptions: Undefined SBModal Option.");
		}

		$option_value = get_option( $option_name, $defaults[$option_name] );

		return $option_value;
	}
}