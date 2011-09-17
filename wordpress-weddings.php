<?php
/*
Plugin Name: Wordpress Weddings
Plugin URI: http://www.ryanbagwell.com
Description: A guest list, RSVP-system and related tools to help you manage your wedding.
Version: 0.1
Author: Ryan Bagwell (ryan@ryanbagwell.com)
Author URI: http://www.ryanbagwell.com
License: GPL2
*/


class WPWeddings {
	
	public $token_length = 6;
	
	
	function WPWeddings() {
        $this->create_post_type(); 
        
        add_action('admin_print_styles',array('WPWeddings','print_stylesheets'));
        
        add_action('save_post',array($this,'save_guest_details'));
          
	}
	
	
	
	
    function create_post_type() {

        $tax_args = array(
            'label'=>'Clients', 
            'public'=>true, 
            'show_in_nav_menus'=>false,
            'show_ui' => true,
            'show_tagcloud'=>false,
            'hierarchical'=>true,
            'capabilities'=>'manage_categories',
            'labels' => array( 
                'singular_name' => 'Client',
                'all_items'=>'All Clients',
                'edit_item'=>'Edit Client',
                'update_item'=>'Update Client',
                'add_new_item'=>'Add New Client',
                'search_items'=>'Search Clients', 
                'popular_items'=>'Popular Clients',
                'parent_item_colon' => 'Pareent', 
            ),
            'rewrite' => array(
                'slug'=>'clients',
                'with_front'=>false,
            ),
        );


		#register_taxonomy('client-galleries','client_reels',$tax_args);


        $labels = array(
            'name' => 'Wedding Guests',
            'singular_name' => 'Wedding Guest',
            'add_new' => 'Add New Guest',
            'add_new_item' => 'Add a New Guest',
            'edit_item' => 'Edit Guest',
            'new_item' => 'New Guest',
            'all_items' => 'All Guests',
            'view_item' => 'View Guests',
            'search_items' => 'Search ',
            'not_found' => 'No guests found',
            'not_found_in_trash' => 'No guests found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'Wedding Guests'
        );
                  
          $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'show_in_menu' => true, 
            'query_var' => false,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => true, 
            'hierarchical' => false,
            'menu_position' => null,
            'register_meta_box_cb' => array($this,'include_meta_box'),
            'supports' => array('title'),
            'show_in_nav_menus' => false,
          ); 
          
          register_post_type('wedding_guests',$args);        

    }
 
    function include_meta_box() {
              
        add_meta_box('mailing-address','Mailing Address',array('WPWeddings','print_address_meta_box'),'wedding_guests','normal');              

 add_meta_box('guests',"Guests",array('WPWeddings','print_guests_meta_box'),'wedding_guests','normal'); 
        
    }
    
    function print_address_meta_box() {
        global $post;
        require_once(dirname(__FILE__).'/inc/address-meta-box.php');
    }


    function print_guests_meta_box() {
        global $post, $wpdb;
        
        $sql = "SELECT user_id FROM $wpdb->prefix"."usermeta WHERE meta_key = '_wedding_party_menber' AND meta_value = '$post->ID'";
        
        $guests = $wpdb->get_results($sql);
        
        if (count($guests) == 0)
            echo "<div class='field-wrapper'>No guests found.</div>";
            
        require_once(dirname(__FILE__).'/inc/guests-meta-box.php');

        echo "<div class='field-wrapper'><a id='add-guest-link'>(add a guest)</a></div>";

    }

    function print_stylesheets() {
        global $post;
        
        if ($post->post_type == 'wedding_guests')
            wp_enqueue_style('weddings-admin',plugins_url('css',__FILE__).'/weddings-admin.css');
            wp_enqueue_script('weddings-admin',plugins_url('js/admin.js',__FILE__));
    }


    
    function save_guest_details($post_id) {
                
        $fields = array(
            '_guest_party_address1',
            '_guest_party_address2',
            '_guest_party_city',
            '_guest_party_state',
            '_guest_party_zip',
            '_guest_party_email',           
        );
        
        foreach($fields as $field) {
            $result = update_post_meta($post_id,$field,$_POST[$field]);
        }
       
        if (get_post_meta($post_id,'_guest_party_token',true) == "")
            update_post_meta($post_id,'_guest_party_token',$this->generate_token());
        
    }
    
    function generate_token() {
        
        /*
        A - Z: 65 - 90
        0 - 9: 48 - 57
        */
        
        //build an array of characters that we want to use
        $characters = array();
        
        $i = 65;
        while ($i <= 90) {
            $characters[] = chr($i);
            $i++;
        }
        
        $i = 48;
        while ($i <= 57) {
            $characters[] = chr($i);
            $i++;
        }        
        
        $code = array_flip($characters);
        $code = array_rand($code,$this->token_length);
    
        return implode($code);
    
    }

}

function start_wp_weddings() {
    $w = new WPWeddings();
}


add_action('init','start_wp_weddings');
