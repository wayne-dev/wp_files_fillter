<?php
class fileattachmentMetabox {
	private $screen = array(
		'file-fillter',
	);
	private $meta_fields = array(
		array(
			'label' => 'File Attachment',
			'id' => '_file_id',
			'type' => 'media',
		),
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'media_fields' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'fileattachment',
				__( 'Attachment', 'sadecweb' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'high'
			);
		}
	}
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'fileattachment_data', 'fileattachment_nonce' );
		$this->field_generator( $post );
	}
	public function media_fields() {
		?><script>
			jQuery(function($){
			  // Set all variables to be used in scope
			  var imgIdInput,id,imgContainer,frame,
				  metaBox = $('#fileattachment.postbox'), // Your meta box id here
				  addImgLink = metaBox.find('.upload-custom-img'),
				  delImgLink = metaBox.find( '.delete-custom-img');
			  
			  // ADD IMAGE LINK
			  addImgLink.on( 'click', function( event ){
				
				event.preventDefault();
				id = $(this).attr('id').replace('_button', '');
				imgContainer = metaBox.find( '.custom-img-container-' + id);
				imgIdInput = metaBox.find( '.custom-img-id-' + id );
				
				// If the media frame already exists, reopen it.
				if ( frame ) {
				  frame.open();
				  return;
				}
				
				// Create a new media frame
				frame = wp.media({
				  title: 'Select or Upload Media Of Your Chosen Persuasion',
				  button: {
					text: 'Use this media'
				  },
				  library: { type: 'application' }, 
				  multiple: false  // Set to true to allow multiple files to be selected
				});

				
				// When an image is selected in the media frame...
				frame.on( 'select', function() {
				  
				  // Get media attachment details from the frame state
				  var attachment = frame.state().get('selection').first().toJSON();

				  // Send the attachment URL to our custom image input field.
				  imgContainer.append( '<img src="'+attachment.url+'" alt="" width = 70/>' );

				  // Send the attachment id to our hidden input
				  imgIdInput.val( attachment.id );

				  // Hide the add image link
				  addImgLink.addClass( 'hidden' );

				  // Unhide the remove image link
				  delImgLink.removeClass( 'hidden' );
				});

				// Finally, open the modal on click
				frame.open();
			  });
			  
			  
			  // DELETE IMAGE LINK
			  delImgLink.on( 'click', function( event ){
				id = $(this).attr('id').replace('_delete', '');
				imgContainer = metaBox.find( '.custom-img-container-' + id);
				imgIdInput = metaBox.find( '.custom-img-id-' + id );
				  
				event.preventDefault();

				// Clear out the preview image
				imgContainer.html( '' );

				// Un-hide the add image link
				addImgLink.removeClass( 'hidden' );

				// Hide the delete image link
				delImgLink.addClass( 'hidden' );

				// Delete the image id from the hidden input
				imgIdInput.val( '' );

			  });

			});
		</script><?php
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				case 'media':
					$upload_link = wp_get_attachment_image_src( $meta_value, 'full', true );
					ob_start();
					?>
					<!-- Your image container, which can be manipulated with js -->
					<div class="custom-img-container-<?php echo $meta_field['id'];?>">
						<img src="<?php echo $upload_link[0] ?>" alt="" width = 70  />
						<p><?php echo basename ( get_attached_file( $meta_value ) ) ?></p>
					</div>

					<!-- Your add & remove image links -->
					<p class="hide-if-no-js">
						<a id = '<?php echo $meta_field['id'];?>_button' class="upload-custom-img <?php if ( $meta_value  ) { echo 'hidden'; } ?>" 
						href="<?php echo $upload_link ?>">
							<?php _e('Attachment file') ?>
						</a>
						<a id = '<?php echo $meta_field['id'];?>_delete'class="delete-custom-img <?php if ( ! $meta_value  ) { echo 'hidden'; } ?>" 
						href="#">
							<?php _e('Remove file') ?>
						</a>
					</p>
					<input class="custom-img-id-<?php echo $meta_field['id'];?>" name="<?php echo $meta_field['id'];?>" type="hidden" value="<?php echo esc_attr( $meta_value ); ?>" />
					<?php
					$input = ob_get_contents();
					ob_end_clean();
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}
	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['fileattachment_nonce'] ) )
			return $post_id;
		$nonce = $_POST['fileattachment_nonce'];
		if ( !wp_verify_nonce( $nonce, 'fileattachment_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}
if (class_exists('fileattachmentMetabox')) {
	new fileattachmentMetabox;
};
?>