<?php
/*
Plugin Name: SBModal
Plugin URI: http://sbmodal.seven-bytes.com/
Description: Ease usage of Bootstrap Modals in WordPress
Version: 1.3.3
Author: Seven Bytes
Author URI: http://sbmodal.seven-bytes.com/
License: MIT
License URI: http://opensource.org/licenses/MIT
*/
defined('ABSPATH') or die("No script kiddies please!");

define('SBMODAL_PATH', plugin_dir_path(__FILE__));
define('SBMODAL_URL', plugin_dir_url(__FILE__));

require_once(SBMODAL_PATH . 'director.php');