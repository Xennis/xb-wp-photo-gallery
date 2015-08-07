<?php
function wp_helper_getPageTitleAddNew($title, $link = NULL, $linkText = 'Add new') {
	if ($link) {
		$link = '<a href="'.$link.'" class="add-new-h2">'.$linkText.'</a>';
	}
	echo '<h2>'.$title.' '.$link.'</h2>';
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

function spg_helper_makeDir($dir) {
	if (!file_exists($dir)) {
		mkdir($dir, 0755, true);
	}
}