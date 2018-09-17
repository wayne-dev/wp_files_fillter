<?php
function filecat_taxonomy() {

	$labels = array(
		'name'                       => _x( 'WP Fillter Files Categories', 'Taxonomy General Name', 'sadecweb' ),
		'singular_name'              => _x( 'WP Fillter Files Categories', 'Taxonomy Singular Name', 'sadecweb' ),
		'menu_name'                  => __( 'WP Fillter Files Categories', 'sadecweb' ),
		'all_items'                  => __( 'All Files', 'sadecweb' ),
		'parent_item'                => __( 'Parent File', 'sadecweb' ),
		'parent_item_colon'          => __( 'Parent File Categorie', 'sadecweb' ),
		'new_item_name'              => __( 'New File Categorie Name', 'sadecweb' ),
		'add_new_item'               => __( 'Add New File Categorie', 'sadecweb' ),
		'edit_item'                  => __( 'Edit File Categorie', 'sadecweb' ),
		'update_item'                => __( 'Update File Categorie', 'sadecweb' ),
		'view_item'                  => __( 'View File Categorie', 'sadecweb' ),
		'separate_items_with_commas' => __( 'Separate File Categories with commas', 'sadecweb' ),
		'add_or_remove_items'        => __( 'Add or remove File Categories', 'sadecweb' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sadecweb' ),
		'popular_items'              => __( 'Popular File Categories', 'sadecweb' ),
		'search_items'               => __( 'Search File Categories', 'sadecweb' ),
		'not_found'                  => __( 'Not Found', 'sadecweb' ),
		'no_terms'                   => __( 'No File Categories', 'sadecweb' ),
		'items_list'                 => __( 'File Categories list', 'sadecweb' ),
		'items_list_navigation'      => __( 'File Categories list navigation', 'sadecweb' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'wpff-tax', array( 'file-fillter' ), $args );

}
add_action( 'init', 'filecat_taxonomy', 0 );
function pippin_add_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('wpff-tax');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'file-fillter' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'pippin_add_taxonomy_filters' );
add_filter( 'wp_terms_checklist_args', function ( $args, $post_id ) {
		//if ( get_post_type( $post_id ) == 'post' && $args['taxonomy'] == 'category' ) {
		$args['checked_ontop'] = false;
		//}
		return $args;
	}, 1, 2 );
?>