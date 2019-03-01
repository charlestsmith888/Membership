<?php

/**
 * Plugin Name: Shears Membership 
 * Plugin URI: https://www.google.com.pk/
 * Description: This plugin for membership like free or paid
 * Version: 1.0.0
 * Author: Shears
 * Author URI: https://www.google.com.pk
 *
 * Text Domain: shears-membership 
 * Domain Path: /i18n/languages/
 *
 * @author Shears
 */

define('SHEARS_PLUGIN_DIR', plugin_dir_path(__FILE__));

//register_activation_hook(__FILE__, 'shears_custom_pages');
register_deactivation_hook( __FILE__, 'deactivate_related_data' );
function deactivate_related_data()
{
	$register_page_availability = get_page_title_for_slug('shears-registration');
	$login_page_availability = get_page_title_for_slug('shears-login');
	$dashboard_page_availability = get_page_title_for_slug('shears-dashboard');
	$single_page_availability = get_page_title_for_slug('shears-single');
	if($register_page_availability == true)
  	{
		$page_delete = get_page_by_path( 'shears-registration' );
		wp_delete_post( $page_delete->ID, true );
	}
	if($login_page_availability == true)
  	{
		$page_delete = get_page_by_path( 'shears-login' );
		wp_delete_post( $page_delete->ID, true );
	}
	if($dashboard_page_availability == true)
  	{
		$page_delete = get_page_by_path( 'shears-dashboard' );
		wp_delete_post( $page_delete->ID, true );
	}
	if($single_page_availability == true)
  	{
		$page_delete = get_page_by_path( 'shears-single' );
		wp_delete_post( $page_delete->ID, true );
	}
	// unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'shear_post' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}

require_once __DIR__ . '/include/shears.main.php';



