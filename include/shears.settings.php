<?php
if(!session_id()) 
{
	session_start();
}
add_action( 'wp_enqueue_scripts', 'shears_enqueue_styles' );
function shears_enqueue_styles() 
{

	// shears plugin template css and js
	global $post;
	$post_slug  = $post->post_name;
	if( isset($post_slug) && ($post_slug == 'shears-registration' || $post_slug == 'shears-login' || $post_slug ==  'shears-dashboard' || $post_slug == 'shears-single'))
	{
		//css
		wp_enqueue_style( 'plugin-shears-styles', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/shears-styles.css');
		wp_enqueue_style( 'plugin-font-awesome', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/font-awesome.min.css');
		wp_enqueue_style( 'google-fonts-family', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900');
		if($post_slug == 'shears-dashboard' || $post_slug == 'shears-single')
		{
			wp_enqueue_style( 'plugin-datatables', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/jquery.dataTables.min.css');
	 		if ( ! wp_script_is( 'jquery', 'enqueued' )) 
		 	{
				wp_enqueue_script( 'plugin-script-jquery',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/jquery.min.js', array(), false, true );
		  	}
			wp_enqueue_script( 'plugin-script-datatables',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/jquery.dataTables.min.js', array(), false, true );
			wp_enqueue_script( 'plugin-script-frontend-dtables',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/frontend.datatable.script.js', array(), false, true );

		}
			
		wp_enqueue_script( 'plugin_script_frontend',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/frontend.script.js', array(), false, true );

		// wp_enqueue_script( 'plugin_script_moment',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/vendors/js/extensions/moment.min.js', array(), false, true );
		// wp_enqueue_script( 'plugin_script_fullcalendar_min',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/vendors/js/extensions/fullcalendar.min.js', array(), false, true );
		
		// wp_enqueue_script( 'plugin_script_fullcalendar',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/js/scripts/extensions/fullcalendar.js', array(), '3.0.0', true );
		// wp_enqueue_script( 'plugin_script_appmenu',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/js/core/app-menu.js', array(), false, true );
		// wp_enqueue_script( 'plugin_script_app',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/js/core/app.js', array(), '3.0.0', true );
		// wp_enqueue_script( 'plugin_script_customizer',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/js/scripts/customizer.js', array(), false, true );
		//  wp_enqueue_script( 'plugin_script_components_modal',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/app-assets/js/scripts/modal/components-modal.js', array(), false, true );
		/*
			<!-- END STACK JS--> 
			<!-- BEGIN PAGE LEVEL JS--> 
			<!-- END PAGE LEVEL JS-->
		**/

		// if($post_slug == 'shears-registration')
		// {
			wp_enqueue_style( 'plugin-jquery-ui', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/jquery-ui.css');
			wp_enqueue_script( 'plugin_script-jquery-ui',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/jquery-ui.js', array(), false, true );
		//}
	}
}

// For Admin  scripts
add_action( 'admin_enqueue_scripts', 'shears_admin_enqueue_scripts' );
function shears_admin_enqueue_scripts() {
 	if( isset($_GET['post_type']) && $_GET['post_type']=='shear_post' )
 	{
    	calling_scripts_admin();
	}
	if( isset($_GET['post']) )
 	{
    	$post_id = $_GET['post'];
    	$posttype_status =get_post_type( $post_id );
    	if($posttype_status != false && $posttype_status == "shear_post")
    	{
    		calling_scripts_admin();
    	}
    	
	}
}
function calling_scripts_admin()
{
		wp_enqueue_style( 'bootstrap_css', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/bootstrap.css');
    	wp_enqueue_style( 'bootstrap_datatable', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/dataTables.bootstrap.min.css');
    	wp_enqueue_style( 'bootstrap_responsive', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/responsive.bootstrap.min.css');
    	wp_enqueue_style( 'shears_plugin_css', plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/css/shears.css');

		wp_enqueue_script( 'bootstrap_script',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/bootstrap.min.js', array( 'jquery' ), '4.0.0', true );

		wp_enqueue_script( 'shear_jquery_dataTables',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/jquery.dataTables.min.js', array(), false, true );
		wp_enqueue_script( 'shear_dataTables_bootstrap',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/dataTables.bootstrap.min.js', array(), false, true );
		
		//wp_enqueue_script( 'shear_responsive_bootstrap',plugin_dir_url( SALSOFT_PLUGIN_DIR ).'shears_membership/assets/js/responsive.bootstrap.min.js', array(), false, true );

		wp_enqueue_script( 'shear_admin_script',plugin_dir_url( SHEARS_PLUGIN_DIR ).'shears_membership/assets/js/admin.script.js', array(), false, true );
		
		wp_localize_script( 'shear_admin_script', 'ajaxadmin', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

// checking text
function shears_test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
// checking email
function shears_checkEmail($email) {
   $find1 = strpos($email, '@');
   $find2 = strpos($email, '.');
   //return $find2; 
   return ($find1 !== false && $find2 !== false && $find2 > $find1 ? true : false);
}

// Making User Role 
add_role('shears_membership_user', __( 'Shears Membership User', 'shears membership user' ));

add_action('admin_footer', 'my_admin_footer_function');
function my_admin_footer_function() {
	//ob_start();
	//include 'templates/registration_form.php';
	include 'templates/shears_members_modal.php';
	include 'templates/shears_members_modal_update.php';
		
}

// checking page is available or not
function get_page_title_for_slug($page_slug) {
	$page = get_page_by_path( $page_slug , OBJECT ); 
	if ( isset($page) ) {
		return true;
 	}
	else
	{
		return false;
	}
}


// when user logout
function user_logout() {

    $_SESSION["session_userrole"];
    if($_SESSION["session_userrole"] == 'shears_membership_user')
    {
    	wp_redirect(home_url('/shears-login'));
    	exit();		
    }

}
add_action('wp_logout', 'user_logout');

