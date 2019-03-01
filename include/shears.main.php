<?php

if(!class_exists('SHEARS_Main')) {
	return;
}
class SHEARS_Main {
	public function __construct()
	{
		/**
		 * include all required files
		 */
		require_once __DIR__.'/shears.shorcodes.php';
		require_once __DIR__.'/shears.settings.php';
		require_once __DIR__ . '/shears.ajax.actions.php';
		require_once __DIR__ . '/lib/cmb2/init.php';

		/**
		 * main hooks
		 */
		add_action('init', array($this, 'init'));
		add_action('cmb2_admin_init', array($this, 'init_meta_fields'));
	}
	
	public function init()
	{
		$this->init_shears_custom_pages();
		$this->init_post_types();

	}
	public function init_shears_custom_pages()
	{
		$user_id =  get_current_user_id();
	  	// Create post object
	  	$register_page_availability = get_page_title_for_slug('shears-registration');
	  	$login_page_availability = get_page_title_for_slug('shears-login');
	  	$dashboard_page_availability = get_page_title_for_slug('shears-dashboard');
	  	$single_page_availability = get_page_title_for_slug('shears-single');

	  	if($register_page_availability == false)
	  	{
	    	$register_post = array(
	      	'post_title'    => wp_strip_all_tags( 'Shears Registration' ),
	      	'post_name'     => 'shears-registration',
	      	'post_content'  => '[shears_registration_form]',
	      	'post_status'   => 'publish',
	      	'post_author'   => $user_id,
	      	'post_type'     => 'page',
	    	);
			// Insert the post into the database
    		wp_insert_post( $register_post );
		}
		if($login_page_availability == false)
	  	{
	    	$login_post = array(
	      	'post_title'    => wp_strip_all_tags( 'Shears Login' ),
	      	'post_name'     => 'shears-login',
	      	'post_content'  => '[shears_login_form]',
	      	'post_status'   => 'publish',
	      	'post_author'   => $user_id,
	      	'post_type'     => 'page',
	    	);
			// Insert the post into the database
    		wp_insert_post( $login_post );
		}
		if($dashboard_page_availability == false)
	  	{
	    	$dashboard_post = array(
	      	'post_title'    => wp_strip_all_tags( 'Shears Dashboard' ),
	      	'post_name'     => 'shears-dashboard',
	      	'post_content'  => '[shears_dashboard_form]',
	      	'post_status'   => 'publish',
	      	'post_author'   => $user_id,
	      	'post_type'     => 'page',
	    	);
			// Insert the post into the database
    		wp_insert_post( $dashboard_post );
		}
		
  	 	if($single_page_availability == false)
	  	{
	    	$register_post = array(
	      	'post_title'    => wp_strip_all_tags( 'Shears Single Post' ),
	      	'post_name'     => 'shears-single',
	      	'post_content'  => '[shears_single_post]',
	      	'post_status'   => 'publish',
	      	'post_author'   => $user_id,
	      	'post_type'     => 'page',
	    	);
			// Insert the post into the database
    		wp_insert_post( $register_post );
		}
	}
	
	public function init_post_types()
	{
		// Registering custom post type 'shears members posts'

		$shears_members_args = array(
			'labels' => array(
				'name' => __("Shear'ree Posts", 'shears-membership'),
				'menu_name' => __("Shear'ree Post", 'shears-membership'),
				'singular_name' => __("Shear'ree Post", 'shears-membership'),
			),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
		    'has_archive' => true,
		    'show_in_menu' => true,
		    //'supports' => array('title', 'editor', 'thumbnail')
		    'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail'),
		);
		register_post_type('shear_post', $shears_members_args);

	}
	public function init_meta_fields()
	{
		$cmb_shear_post = new_cmb2_box( array(
			'id'            => 'shear_post_metabox',
			'title'         => esc_html__( 'Shear Post - Custom  Fields' ),
			'object_types'  => array( 'shear_post' )
		) );
		$cmb_shear_post->add_field( array(
			'name'             => 'Select Post for members',
			'desc'             => 'Select a member',
			'id'               => 'shear_members_post',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'custom',
			'options'          => array(
				'0' => __( 'Free Members', 'cmb2' ),
				'1'   => __( 'Paid Members', 'cmb2' ),
				'2'   => __( 'Both (Free & Paid) Members', 'cmb2' ),
			),
		) );
		$cmb_shear_post->add_field( array(
			'id'   => 'shears_members_id',
			'type' => 'hidden',
			'default' => '0'
		) );
		$cmb_shear_post->add_field( array(
			'id'   => 'shears_options_status',
			'type' => 'hidden',
			'default' => 'free'
		) );


	}
}

new SHEARS_Main;

