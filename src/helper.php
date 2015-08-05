<?php
function wp_helper_getPageTitleAddNew($title, $link, $linkText = 'Add new') {
	echo '<h2>'.$title.'<a href="'.$link.'" class="add-new-h2">'.$linkText.'</a></h2>';
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

/**
 * 
 * @category helper
 * 
 * @param string $page Page, i.e. value from the URL page attribute
 * @param array $tabs All tabs
 * @param string $current Current tab
 */
function spg_helper_admin_tabs($page, array $tabs, $current = NULL){
    echo '<h2 class="nav-tab-wrapper">';
    foreach($tabs as $anchor => $name){
		$class = ($anchor == $current) ? ' nav-tab-active' : '';
       echo '<a class="nav-tab'.$class.'" href="?page='.$page.'&tab='.$anchor.'">'.$name.'</a>';
    }
    echo '</h2>';
}