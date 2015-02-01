<?php
defined('ABSPATH') or die("No script kiddies please!");

class SBModal {
	private static $_instance = null;
	private $_post_types = null;
	
	private function __construct() {}
	private function __clone() {}
	
	public static function app() {

		if ( is_null(self::$_instance) ) {
			self::$_instance = new static();
		}

		return self::$_instance;
	}
	
	public function init() {}
	
	public function post_types() {
		if ( is_null( $this->_post_types ) ) {
			$this->_post_types = new SBModalPostTypes();
		}
		
		return $this->_post_types;
	}
	
	public function getTemplatePath() {
		return SBMODAL_PATH . 'templates/';
	}
	
	public function getClientTemplatePath() {
		$path_default = '/sbmodal/templates/';
		
		$path = apply_filters('sbmodal_client_templates_path', $path_default);
		
		return get_template_directory() . $path;
	}
}

class SBModalAdmin extends SBModal {
	public function init() {
		$this->post_types()->register();
	}
}

class SBModalFront extends SBModal {
	private $_view;
	
	public function init() {
		$this->post_types()->register();
		$this->_assets();
		$this->_view();
	}
	
	private function _assets() {
		$this->_assets = new SBModalAssets();
	}
	
	private function _view() {
		$this->_view = new SBModalFrontView();
	}
}