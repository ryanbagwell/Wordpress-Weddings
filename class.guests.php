<?php

class WeddingGuest extends WP_User {
	
	public $attending_wedding = null;
	public $attending_dinner = null;
	public $has_responded = null;
	
	function WeddingGuest($id = null) {
		
		parent::__construct($id);
	
		$this->attending_wedding = (bool) get_user_meta($this->ID,'_attending_wedding',true);
		$this->attending_dinner = (bool) get_user_meta($this->ID,'_attending_dinner',true);
		$this->has_responded = (bool) ($this->_attending_wedding == '1' || $this->_attending_wedding == '0' || $this->_attending_dinner == '1' || $this->_attending_dinner == '0');

	}
	
}

class GuestParty extends WP_User_Query {

	public $num_guests = 0;
	public $attending_wedding = 0;
	public $attending_dinner = 0;
	public $num_responded = 0;
	
	
	function GuestParty($party_id) {
		
		parent::__construct(array(
	            'fields'=>'all_with_meta',
	        	'meta_key' => '_wedding_party',
	        	'meta_value' => $party_id,
	    	));

		$this->num_guests = count($this->results);

		foreach($this->results as $user) {
			$user = new WeddingGuest($user->ID);
			
		
			if ($user->_attending_wedding == '1')
				$this->attending_wedding++;
			
			if ($user->_attending_dinner == '1')
				$this->attending_dinner++;
			
			if ($user->has_responded)
				$this->num_responded++;
	
		};
		
		$this->guests = $this->results;

		$do_not_unset = array(
			'num_guests',
			'num_responded',
			'attending_wedding',
			'attending_dinner',
			'guests',
		);
		
		foreach($this as $key => $val) {
			if (!in_array($key,$do_not_unset))
				unset($this->$key);
		}
		
	}
	
	
}


class GuestParties extends WP_Query {
	
	public $total_guests = 0;
	public $attending_weddding = 0;
	public $attending_dinner = 0;
		
	function GuestParties() {
		parent::__construct(array(
			'post_type'=>'wedding_guests',
			'nopaging'=>true,
		));
		
		foreach($this->posts as $post) {
			
			$post->guests = new GuestParty($post->ID);

			$this->total_guests += $post->guests->num_guests;
			$this->attending_wedding += $post->guests->attending_wedding;
			$this->attending_dinner += $post->guests->attending_dinner;
		
		}
		
		$this->parties = $this->posts;
		
		$do_not_unset = array(
			'total_guests',
			'parties',
			'attending_wedding',
			'attending_dinner',
		);
		
		foreach($this as $key => $val) {
			if (!in_array($key,$do_not_unset))
				unset($this->$key);
		}
		
		
	
	}
	
	function get($party_id = null) {
	
		foreach($this->parties as $party) {
			// echo "<pre>";
			// var_dump($party->guests);
			// echo "</pre>";
			// die();

			if ($party->ID == $party_id) {
				

				
				return $party;
				
			}
		}
		
		return false;
		
	}

	
}




