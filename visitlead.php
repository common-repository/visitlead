<?php
/*
Plugin Name: VISITLEAD
Plugin URI: http://visitlead.com
Description: VISITLEAD PlugIn for Wordpress. Real-Time-Monitoring and Live Chat
Version: 1.0
Author: K. Muckenhuber <service@visitlead.com>
Author URI: http://visitlead.com
*/

class visitlead {
	static $is_enabled = false;
	static $is_valid = false;
	static $json;
	static $plugin_dir;
	static $example_cid = '12ec0bcb421124b1f323e5f1';

	function init(){
		add_option("visitlead_cid");
		load_plugin_textdomain('visitlead', false, dirname(plugin_basename(__FILE__))); 
		
		$input_cid = get_option("visitlead_cid");
		if ($input_cid)
			self::$is_enabled = true;
		else
			self::$is_enabled = false;
		
		if  ($input_cid && strlen($input_cid) == 24 && preg_match("/^[a-f0-9]+$/i", $input_cid))
			self::$is_valid = true;
		else 
			self::$is_valid = false;
		
		self::$plugin_dir = get_option('siteurl').'/'.PLUGINDIR.'/visitlead/';
		if(function_exists('current_user_can') && current_user_can('manage_options')){
			add_action('admin_menu', array(__CLASS__, 'add_settings_page'));
			add_filter('plugin_action_links', array(__CLASS__, 'register_actions'), 10, 2);
		}
		
		if(self::$is_enabled){
			add_action('wp_footer', array(__CLASS__, 'insert_code'));
		} else {
			add_action('admin_notices', array(__CLASS__, 'admin_notice'));
		}
	}

	function insert_code(){
		if(!self::$is_enabled) 
			return false;
		$input_cid = get_option("visitlead_cid");
		echo "<script async src='https://app.visitlead.com/va/vl.min.js' id='vl-script' data-cid='".$input_cid."'></script>";
	}

	function admin_notice(){
		if(!self::$is_enabled) 
			echo '<div class="error"><p><strong>'.sprintf(__('VISITLEAD integration is not configured. <a href="%s">Plugin Setup</a>' ), admin_url('options-general.php?page=visitlead')).'</strong></p></div>';
	}

	function add_settings_page(){
		add_action('admin_init', array(__CLASS__, 'register_settings'));
		add_submenu_page('options-general.php', 'Visitlead Setup', 'Setup', 'manage_options', 'visitlead', array(__CLASS__, 'settings_page'));
	}


	/* Others ... */

	function register_settings(){
		register_setting('visitlead', 'visitlead_cid');
		add_settings_section('visitlead', 'Visitlead', '', 'visitlead');
	}

	function register_actions($links, $file){
		$this_plugin = plugin_basename(__FILE__);
		if($file == $this_plugin && function_exists('admin_url')){
			$settings_link = '<a href="'.admin_url('options-general.php?page=visitlead').'">'.__('Settings', 'visitlead').'</a>';
			array_unshift($links, $settings_link);
		}
		return($links);
	}

	function settings_page(){
		
		if (self::$is_enabled) {
			$input_cid = get_option("visitlead_cid");
			if ($input_cid == self::$example_cid) {
				$example = '<p>... don´t use our example code ... </p>';
				self::$is_valid = false;
			}
			if(!self::$is_valid) {
				echo '<div id="setting-error-settings_error" class="error settings-error">';
				echo '<strong>Your entered CID seems not valid!</strong>';
				echo $example;
				echo '<ol><li>Check your input (must be 24 chars and look like: '.self::$example_cid.')</li><li>Get your cid from your <a href="https://VISITELAD.com/login" target="_blank">existing</a> VISITELAD account - OR - <a href="https://VISITELAD.com/register" target="_blank">create a new</a> VISITELAD account</li></ol>';
				echo '</div>';
			}
		}

		$plugin_dir = self::$plugin_dir;
		$in_visitlead = true;
		require_once "visitlead.admin.php";
	}
}

add_action('init', array('Visitlead', 'init'));