<?php
/**
 * Admin menu hook: Add pages to menu.
 */
function spg_admin_menu() {
	
    add_menu_page('Smart Gallery', 'Smart Gallery', 'edit_others_pages', 'spg-galleries', null, 'dashicons-camera', null);
	add_submenu_page('spg-galleries', __('Galleries', SPG_NAME), __('Galleries', SPG_NAME), 'edit_others_pages', 'spg-galleries', 'spg_page_galleries');
	add_submenu_page('spg-galleries', __('Add Photos', SPG_NAME), __('Add Photos', SPG_NAME), 'edit_others_pages', 'spg-upload', 'spg_page_upload');
	
}
add_action('admin_menu', 'spg_admin_menu');

/**
 * Page galleries
 */
function spg_page_galleries() {
	require_once(SPG_DIR . '/src/list/table/common.php');
	require_once(SPG_DIR . '/src/list/table/gallery.php');
	$listTable = new Gallery_List_Table();
	$listTable->prepare_items();
?>
<div class="wrap">
	<?php wp_helper_getPageTitleAddNew('Galleries'); ?>
	<?php $listTable->display(); ?>
</div>
<?php
}

/**
 * Page galleries
 */
function spg_page_upload() {
	$title = __('Upload new media', SPG_NAME);
	
	$upload_dir = wp_upload_dir();
	$upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
	$resultUpload = spg_helper_uploadFiles($upload_path);

?>
<div class="wrap">
	<h2><?php echo esc_html( $title ); ?></h2>
	<form method="POST" enctype="multipart/form-data" action="admin.php?page=spg-upload" class="dropzone">
		<div class="fallback">
			<input name="file" type="file" multiple /> 
		</div>
	</form>
	<p class="max-upload-size"><?php printf( __( 'Maximum upload file size: %s.' ), esc_html( size_format( wp_max_upload_size() ) ) ); ?></p>
	
</div>
<?php
}