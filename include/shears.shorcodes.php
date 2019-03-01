<?php
ob_start();
add_shortcode('shears_registration_form','shears_registration_form');
add_shortcode('shears_login_form','shears_login_form');
add_shortcode('shears_dashboard_form','shears_dashboard_form');
add_shortcode('shears_single_post','shears_single_post');

function shears_registration_form()
{
	ob_start();
	include 'templates/registration_form.php';
	//include 'templates/practice_form.php';
	//include 'templates/shears_admin_modal.php';
	
	$output = ob_get_clean();
	return $output;
}
function shears_login_form()
{	
	ob_start();
	include 'templates/login_form.php';
	//include 'templates/practice_form.php';
	//include 'templates/shears_admin_modal.php';
	
	$output = ob_get_clean();
	return $output;

}
function shears_dashboard_form()
{	
	ob_start();
	include 'templates/shears_dashboard.php';
	//include 'templates/practice_form.php';
	//include 'templates/shears_admin_modal.php';
	
	$output = ob_get_clean();
	return $output;

}
function shears_single_post()
{	
	ob_start();
	include 'templates/shears_single_post.php';
	//include 'templates/practice_form.php';
	//include 'templates/shears_admin_modal.php';
	
	$output = ob_get_clean();
	return $output;

}