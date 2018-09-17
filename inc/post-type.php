<?php
// Register Custom Post Type
function property_post_type() {

	$labels = array(
		'name'                  => _x( 'Files', 'Post Type General Name', 'sadecweb' ),
		'singular_name'         => _x( 'file-fillter', 'Post Type Singular Name', 'sadecweb' ),
		'menu_name'             => __( 'Files', 'sadecweb' ),
		'name_admin_bar'        => __( 'Files', 'sadecweb' ),
		'archives'              => __( 'Item Archives', 'sadecweb' ),
		'attributes'            => __( 'Item Attributes', 'sadecweb' ),
		'parent_item_colon'     => __( 'Parent Item:', 'sadecweb' ),
		'all_items'             => __( 'All Items', 'sadecweb' ),
		'add_new_item'          => __( 'Add New Item', 'sadecweb' ),
		'add_new'               => __( 'Add New', 'sadecweb' ),
		'new_item'              => __( 'New Item', 'sadecweb' ),
		'edit_item'             => __( 'Edit Item', 'sadecweb' ),
		'update_item'           => __( 'Update Item', 'sadecweb' ),
		'view_item'             => __( 'View Item', 'sadecweb' ),
		'view_items'            => __( 'View Items', 'sadecweb' ),
		'search_items'          => __( 'Search Item', 'sadecweb' ),
		'not_found'             => __( 'Not found', 'sadecweb' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sadecweb' ),
		'featured_image'        => __( 'Featured Image', 'sadecweb' ),
		'set_featured_image'    => __( 'Set featured image', 'sadecweb' ),
		'remove_featured_image' => __( 'Remove featured image', 'sadecweb' ),
		'use_featured_image'    => __( 'Use as featured image', 'sadecweb' ),
		'insert_into_item'      => __( 'Insert into item', 'sadecweb' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sadecweb' ),
		'items_list'            => __( 'Items list', 'sadecweb' ),
		'items_list_navigation' => __( 'Items list navigation', 'sadecweb' ),
		'filter_items_list'     => __( 'Filter items list', 'sadecweb' ),
	);
	$args = array(
		'label'                 => __( 'Files', 'sadecweb' ),
		'description'           => __( 'files', 'sadecweb' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'taxonomies'            => array( 'wpff-tax' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 57,
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'product',
	);
	register_post_type( 'file-fillter', $args );

}
add_action( 'init', 'property_post_type', 0 );
add_filter('manage_posts_columns', 'posts_columns', 0);
add_action('manage_posts_custom_column', 'posts_custom_columns', 0, 2);
function posts_columns($defaults){
    $defaults['1_thumbs'] = __('Thumbs');
    return $defaults;
}
function posts_custom_columns($column_name, $id){ 
	if($column_name === '1_thumbs'){ 
		$meta_value = get_post_meta( $id, "_file_id", true );
		$src = wp_get_attachment_image_src( $meta_value, 'full' );
		//echo the_post_thumbnail( 'featured-thumbnail' );
		echo '<img src="'.$src[0].'" alt="" width = 70  />';
	} 
}
?>