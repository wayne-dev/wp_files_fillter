<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


add_action( 'wp_ajax_wf_get_list_folder', 'wf_get_list_folder' );
add_action( 'wp_ajax_nopriv_wf_get_list_folder', 'wf_get_list_folder' );
function wf_get_list_folder() {
	global $img_taxes;
	$parent = 0;
	if(isset($_POST['node_parent']) && $_POST['node_parent'] != ''){
		$parent = $_POST['node_parent'];
	}
	$args_terms = array(
		'taxonomy' => 'wpff-tax',
		'hide_empty' => false,
		'parent' => $parent,
	);
	ob_start();?>
	<?php
	$parent_name =  __('Select','sadecweb');
	if($parent != 0){
		$_parent_term = get_term($parent,'wpff-tax');
		$parent_name = $_parent_term->name;
	}
	
	$terms = get_terms($args_terms);
	if(!empty($terms)){
	?>
		<label><select class="list-folder" data-id-parent="<?php echo $parent ?>" data-name-parent="<?php echo $parent_name ?>">
			<option value=""><?php _e('Choose option', 'sadecweb'); ?></option>	
			<?php foreach($terms as $term){ ?>
				<option value="<?php echo $term->term_id; ?>">	
					<?php echo $term->name; ?>
				</option>
			<?php } ?>
		</select>
		</label>
	<?php 
	}
	$page = array('content' => ob_get_contents());
	ob_clean();
	wp_send_json($page);
	wp_die();
}
add_action( 'wp_ajax_wf_get_list_files', 'wf_get_list_files' );
add_action( 'wp_ajax_nopriv_wf_get_list_files', 'wf_get_list_files' );
function wf_get_list_files() {
	$parent = 0;
	if(isset($_POST['node_parent']) && $_POST['node_parent'] != ''){
		$parent = $_POST['node_parent'];
	}
	$args_post = array(
		'post_type' => 'file-fillter',
	);
	if($parent == 0){
		$args_post['tax_query'] = array(
			array(
				'taxonomy' => 'wpff-tax',
				'operator' => 'NOT EXISTS' 
			)
		);
	} elseif ($parent != 0) {
		$args_post['tax_query'] = array(
			array(
				'taxonomy' => 'wpff-tax',
				'field' => 'term_id',
				'terms' => $parent,
				'include_children' => false
			)
		);
	}
	$posts = get_posts($args_post);
	if(!empty($posts)){
		?>
		<ul class="list-files">
		<?php foreach($posts as $post){
			?>
			<li>
				<div class="file" data-id="<?php echo $post->ID; ?>">
					<?php
						$file_id = get_post_meta( $post->ID,"_file_id", true );
						$src = wp_get_attachment_url( $file_id );
						$src_thumb = get_the_post_thumbnail_url($post->ID, 'full');
						if($src_thumb)
							echo '<img src="'.$src_thumb.'"/>';
						else
							echo '<img src="'.SD_PLUGIN_URL.'template/images/file.png'.'"/>';
						?>
						<span><?php echo get_the_title($post->ID); ?></span>
						<a href="<?php echo $src; ?>">Download</a>
				</div>
			</li>
		<?php
		} ?>
		</ul>
	<?php 
	} else {
		echo '<span class="empty-folder">Not Found Files</span>';
	}
	$page = array('content' => ob_get_contents());
	ob_clean();
	wp_send_json($page);
	wp_die();
}
?>