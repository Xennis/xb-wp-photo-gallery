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
       echo '<a class="nav-tab'.$class.'" href="'.$page.'&tab='.$anchor.'">'.$name.'</a>';
    }
    echo '</h2>';
}