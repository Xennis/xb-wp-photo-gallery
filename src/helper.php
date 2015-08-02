<?php
function wp_helper_getPageTitleAddNew($title) {
	echo '<h2>'.__('Galleries', SPG_NAME).'<a href="" class="add-new-h2">'.__('Add New', SPG_NAME).'</a></h2>';
}

/**
 * Helper function, which returns the absolute URL of the given resource in the
 * Bower folder.
 * 
 * @category Helper
 * 
 * @param string $path Path relative to the Bower folder
 * @return string Absolute path of the resource
 */
function spg_helper_getBowerResource($path) {
	return plugins_url('../js/bower_components'.$path, __FILE__);
}

/**
 * 
 * @param string $upload_path
 * @return boolean True, if upload was successful
 */
function spg_helper_uploadFiles($upload_path) {
	if (!empty($_FILES)) { 	
		 $tempFile = $_FILES['file']['tmp_name'];//this is temporary server location

		 // Adding timestamp with image's name so that files with same name can be uploaded easily.
		 //$mainFile = $uploadPath.time().'-'. $_FILES['file']['name'];
		 $targetFile = $upload_path . $_FILES['file']['name'];

		 return move_uploaded_file($tempFile, $targetFile);
	}
	return FALSE;
}