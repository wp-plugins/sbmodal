<?php
defined('ABSPATH') or die("No script kiddies please!");

class SBModalAssets {
	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'register_frontend_assets'));
	}
	
	public function getAssetsUrl() {
		return SBMODAL_URL . 'assets/';
	}
	
	public function register_frontend_assets() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap', $this->getAssetsUrl() . 'js/bootstrap.min.js', array('jquery'), '3.3.2', true);
		
		wp_enqueue_style('bootstrap',  $this->getAssetsUrl() . 'css/bootstrap.min.css', null, '3.3.2');
		wp_enqueue_style('sbmodal_front',  $this->getAssetsUrl() . 'css/front.css');
	}
}