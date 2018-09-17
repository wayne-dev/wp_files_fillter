<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 
function wf_function_show_template($attr){
    do_action('short_code_wf');
    return load_template(SD_PLUGIN_PATH . 'template/manage-files.php') ;
}
add_shortcode('wp_show_file', 'wf_function_show_template');
?>