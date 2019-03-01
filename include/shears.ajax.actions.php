<?php

if(!class_exists('SHEARS_Ajax_Actions')) {
	return;
}
class SHEARS_Ajax_Actions {
	public function __construct()
	{
		add_action('wp_ajax_both_free_paid_members', array($this, 'both_free_paid_members'));
		add_action('wp_ajax_nopriv_both_free_paid_members', array($this, 'both_free_paid_members'));
	}
	
	public function both_free_paid_members()
	{
		$free_paid_members = new WP_User_Query( 
			array( 
	      		'role' => 'shears_membership_user',
	      		'meta_key' => 'shears_membership_status',
	      		//'meta_value' => '0' 
	        ) 
      	);
     	$free_paid_members = (array) $free_paid_members->get_results();
     	$all_member_ids= array();
     	if(count($free_paid_members) > 0)
      	{
			
	        foreach ($free_paid_members as $single_member) 
	        {  
	          $all_member_ids[] = $single_member->ID;
	        }
		}
      	else
      	{ 
      		$all_member_ids[] = 0;
      	}     
		return $this->response_json($all_member_ids);
	}
	
	protected function response_json($data)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
		wp_die();
	}
}

new SHEARS_Ajax_Actions;