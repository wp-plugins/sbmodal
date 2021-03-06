<?php
defined('ABSPATH') or die("No script kiddies please!");

require_once (SBMODAL_PATH . 'core/sbmodal.php');
require_once (SBMODAL_PATH . 'core/options.php');
require_once (SBMODAL_PATH . 'core/post_type.php');
require_once (SBMODAL_PATH . 'core/assets.php');

if ( is_admin() ) {
	require_once (SBMODAL_PATH . 'core/options_page.php');

	SBModalAdmin::app()->init();
} else {
	require_once (SBMODAL_PATH . 'core/front_view.php');
	
	SBModalFront::app()->init();
}