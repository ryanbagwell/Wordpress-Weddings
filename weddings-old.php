<?php

class WPWeddings {
	
	function init() {
		
		add_action('admin_menu',array('WPWeddings','admin_menus'));
		
		
	}


	function admin_menus() {
		
		wp_enqueue_style('wp-weddings-admin',plugins_url('wordpress-weddings/css/admin.css','__FILE__'));
		
		add_menu_page('WP Weddings', 'WP Weddings', 'manage_options', 'wp-weddings-options',array('WPWeddings','main_options'));
		
		add_submenu_page('wp-weddings-options', 'Add Guest Party', 'Add Guest Party', 'manage_options', 'wp-weddings-add-party',array('WPWeddings','add_party_menu'));
		
	}


	function main_options() {
		global $wpdb; 
				
		require_once('views/parties.php');
	}


	function add_party_menu() {

		$options = array(
			'title' => 'Add a new Party'			
		);
		
		WPWeddings::_get_view('add_party',$options);
		
	}
	
	function _get_view($view,$options = array()) {
		
		extract($options);
		
		require_once("views/$view".".php");
		
	}

	function install() {
		global $wpdb;
		
		
		$sql = "CREATE TABLE IF NOT EXISTS $wpdb->prefix"."weddings_parties (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			party_name VARCHAR(255),
			address_1 VARCHAR(255),
			address_2 VARCHAR(255),
			city VARCHAR(255),
			state VARCHAR(15),
			zip VARCHAR(255)			
		)";
		
		$wpdb->query($sql);
		
	}
	
	

}

add_action('init',array('WPWeddings','init'));

register_activation_hook( __FILE__,array('WPWeddings','install'));

?>