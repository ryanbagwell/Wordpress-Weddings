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
        
        add_role('wedding_guest','Wedding Guest');
        
        add_filter('manage_wedding_guests_posts_columns',array($this,'add_list_view_columns'));
        
        add_filter('manage_wedding_guests_posts_custom_column',array($this,'add_list_view_column_values'));
        
        add_action('restrict_manage_posts',array($this,'add_guests_filter'));
        
        add_filter('request',array($this,'modify_request_for_filter'));
        
        add_action('admin_menu', array($this,'add_export_submenu_page'));
        
        //an array of party meta fields
        $this->party_fields = array(
            '_guest_party_address1',
            '_guest_party_address2',
            '_guest_party_city',
            '_guest_party_state',
            '_guest_party_zip',
            '_guest_party_email',           
        );
        
        $this->export_guests();
          
	}
	

	
    function create_post_type() {

        $tax_labels = array( 
            'singular_name' => 'Group',
            'all_items'=>'All Groups',
            'edit_item'=>'Edit Groups',
            'update_item'=>'Update Group',
            'add_new_item'=>'Add New Group',
            'search_items'=>'Search Group', 
            'popular_items'=>'Popular Group',
            'parent_item_colon' => 'Parent Group', 
        );

        $tax_args = array(
            'label'=>'Guest Groups', 
            'public'=>false, 
            'show_in_nav_menus'=>false,
            'show_ui' => true,
            'show_tagcloud'=>false,
            'hierarchical'=>true,
            'capabilities'=>array('manage_categories'),
            'labels' => $tax_labels,
        );


		register_taxonomy('wedding-groups','wedding_guests',$tax_args);


        $labels = array(
            'name' => 'Wedding Guests',
            'singular_name' => 'Wedding Guest',
            'add_new' => 'New Guest Party',
            'add_new_item' => 'Add a New Guest',
            'edit_item' => 'Edit Guest',
            'new_item' => 'New Guest',
            'all_items' => 'Guest Parties',
            'view_item' => 'View Guests',
            'search_items' => 'Search ',
            'not_found' => 'No guests found',
            'not_found_in_trash' => 'No guests found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'Guests'
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
        
        $sql = "SELECT user_id FROM $wpdb->prefix"."usermeta WHERE meta_key = '_wedding_party' AND meta_value = '$post->ID'";
        
        $guests = $wpdb->get_results($sql);

        require_once(dirname(__FILE__).'/inc/guests-meta-box.php');

        echo "<div class='field-wrapper'><a id='add-guest-link'>add a guest</a></div>";

    }

    function print_stylesheets() {
        global $post;
        
        if ($post->post_type == 'wedding_guests')
            wp_enqueue_style('weddings-admin',plugins_url('css',__FILE__).'/weddings-admin.css');
            wp_enqueue_script('weddings-admin',plugins_url('js/admin.js',__FILE__));
    }


    
    function save_guest_details($post_id) {
                
        foreach($this->party_fields as $field) {
            $result = update_post_meta($post_id,$field,$_POST[$field]);
        }
       
        if (get_post_meta($post_id,'_guest_party_token',true) == "")
            update_post_meta($post_id,'_guest_party_token',$this->get_random_string(6));
            

        $i = 1;
        while (array_key_exists("_new_guest_title-$i",$_POST)) {
                        
            if ($_POST["_new_guest_first_name-$i"] == '')
                break;
                    
            //first check to see if they already have an email in the system
            $id = email_exists($_POST['_new_guest_email-$i']);
                        
            //if not, create one
            if (!$id)
                $id = $this->create_user($i);                
                            
            update_user_meta($id,'_wedding_party',$post_id);
            update_user_meta($id,'first_name',$_POST["_new_guest_first_name-$i"]);
            update_user_meta($id,'last_name',$_POST["_new_guest_last_name-$i"]);
            update_user_meta($id,'user_title',$_POST["_new_guest_title-$i"]);

            $i++;
        }
                
    }

    function create_user($i) {
        
        $username = $this->get_username($_POST["_new_guest_first_name-$i"],$_POST["_new_guest_last_name-$i"]);
                        
        $password = $this->get_random_string(10);
        
        if ($_POST["_new_guest_email-$i"] == '') {
            $email = "$username@nothing.com";
        } else {
            $email = $_POST["_new_guest_email-$i"];
        }
            
        
        return wp_insert_user(array(
            'user_login' => $username, 
            'user_pass' => $password,
            'user_email' => $email,
            'role' => 'wedding_guest',
            )
        );
    
    }
    
    function get_username($first,$last = null) {
          
        if (!is_null($last)):
            $username = strtolower(substr($first,0,1) . $last);
        else:
            $username = strtolower($first);
        endif;  
        
        if (is_null(username_exists($username)))
            return $username;
                
        $i = 1; 
        while($i <= 100000) {
            if (is_null(username_exists($username.$i)))
                return $username.$i;
            $i++;
        }
            
    }
    
    
    function get_random_string($length = null) {
            
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
        $code = array_rand($code,$length);
    
        return implode($code);
    
    }
    
    function add_list_view_columns($columns) {
        
        unset($columns['date']);
        
        $new_columns = array(
            'title' => 'Name',
            'guests' => 'Guests',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'ZIP',
            'email' => 'Email',
        );
            
        return array_merge($columns,$new_columns);
            
    }


    function add_list_view_column_values($name) {
        global $post,$wpdb;
        
        $values = array(
            'address' => '_guest_party_address1',
            'city' => '_guest_party_city',
            'state' => '_guest_party_state',
            'zip' => '_guest_party_zip',
            'email'=>'_guest_party_email',
        );
        
        if (array_key_exists($name,$values))
            echo get_post_meta($post->ID,$values[$name],true);
        
        if ($name == 'guests') {
            
            $sql = "SELECT count(meta_key) as count FROM $wpdb->prefix"."usermeta WHERE meta_key = '_wedding_party' AND meta_value = '$post->ID'";

            $guests = $wpdb->get_results($sql);
            echo $guests[0]->count;
            
        }
            
        
    }
    
    

    //adds a filter dropdown list to the custom post type
	function add_guests_filter() {
		global $typenow;

		if ($typenow=='wedding_guests'){
             $args = array(
                 'show_option_all' => "Show All Groups",
                 'taxonomy' => 'wedding-groups',
                 'name' => 'wedding-groups',
                 'hierarchical'=>true,
                 'selected'=>$_GET['wedding-groups'],
                 'depth'=>10,
                 'show_count'=>true,
             );
			wp_dropdown_categories($args);
        }
	}
	
    //modifys the http request so it filters by wedding group name
    function modify_request_for_filter($request) {
        
        if (!is_admin())
            return $request;
        
        if (!isset($request['post_type']))
            return $request;
         
        if ($GLOBALS['PHP_SELF'] == '/wp-admin/edit.php' && $request['post_type'] == 'wedding_guests') {
              
            $term = get_term($request['wedding-groups'],'wedding-groups');
            $request['wedding-groups'] = $term->slug;
        
         }
     return $request;
    }


    function add_export_submenu_page() {
        
        add_submenu_page('edit.php?post_type=wedding_guests','Export Guest Parties','Export Guest Parties','manage_options', 'export-guests',array($this,'print_export_submenu_page'));        
    }

    
    function export_guests() {
        
        if ($_REQUEST['page'] != 'export-guests')
            return;
        
        $csv = '"Name","Address 1","Address 2","City","State","ZIP","Email"'."\n";
        
        //get all wedding parties
        $parties = get_posts(array('post_type'=>'wedding_guests'));
        
        //assign the post meta to each party
        foreach($parties as $party) {

            $details = array($party->post_title);

            foreach($this->party_fields as $field) {
                $party->$field = get_post_meta($party->ID,$field,true);
                $details[] = $party->$field;
            }
            
            $details = implode($details,'","');
            $csv .= "\"$details\"\n";
            
        }
        
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"guest-parties.csv\"");
        
        echo $csv;
        die();
        
    }

}

function start_wp_weddings() {
    $w = new WPWeddings();
}


add_action('init','start_wp_weddings');
