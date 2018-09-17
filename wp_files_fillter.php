<?php
/*
  Plugin Name: WP Filter Files
  Plugin URI: https://sadecweb.com/
  Description: 
  Version: 1.0
  Author: Sadecweb
  Author URI: https://www.sadecweb.com/
  Text Domain: sadecweb
  Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'SD_PLUGIN_PATH' ) ) {
	define( 'SD_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
}
if ( ! defined( 'SD_PLUGIN_URL' ) ) {
	define( 'SD_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

	function wpff_scripts(){
		wp_register_script('wf-script', plugin_dir_url( __FILE__ ) .'/template/js/script.js',array( 'jquery' ));
		$global_var = array( 
			"ajax_url" => admin_url( 'admin-ajax.php' ),
			"loading_img" => plugin_dir_url( __FILE__ ) . "/assets/img/ajax-loader.gif"
		);
		wp_localize_script('wf-script','global_var',$global_var);
		wp_enqueue_script( 'wf-script' );
	}
	add_action( 'short_code_wf', 'wpff_scripts' );

	require_once("taxonomy-images/taxonomy-images.php");
	global $img_taxes;
	$taxonomy_image = get_option("taxonomy_image_plugin");
	if($taxonomy_image){
		foreach($taxonomy_image as $key => $img_id){
			$img = wp_get_attachment_image_src( $img_id, 'thumbnail' ) ;
			$img_taxes[$key] = $img[0];
		}
	}

	require_once("radio-buttons-for-taxonomies/radio-buttons-for-taxonomies.php");
	require_once("inc/post-type.php");
	require_once("inc/shortcode.php");
	require_once("inc/taxonomy.php");
	require_once("inc/metaboxes.php");
	require_once("inc/ajax.php");

?>
