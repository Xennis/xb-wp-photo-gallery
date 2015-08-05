<?php
/**
 * Admin menu hook: Add pages to menu.
 */
function spg_admin_menu() {
	
    add_menu_page('Smart Gallery', 'Smart Gallery', 'edit_others_pages', 'spg-galleries', null, 'dashicons-camera', null);
	add_submenu_page('spg-galleries', __('Galleries', SPG_NAME), __('Galleries', SPG_NAME), 'edit_others_pages', 'spg-galleries', 'spg_page_galleries');
	add_submenu_page(null, null, null, 'edit_others_pages', 'spg-gallery', 'spg_page_gallery');
	
}
add_action('admin_menu', 'spg_admin_menu');

/**
 * Page galleries
 */
function spg_page_galleries() {	
	require_once(SPG_DIR . '/lib/wp-crud/form/Field.php');
	require_once(SPG_DIR . '/lib/wp-crud/table/Horizontal.php');
	require_once(SPG_DIR . '/src/view/page/Galleries.php');
	$view = new View_Page_Galleries();
	$view->display();	
}

/*
 * Page gallery
 */
function spg_page_gallery() {
	require_once(SPG_DIR . '/lib/wp-crud/form/Field.php');	
	require_once(SPG_DIR . '/src/view/page/Gallery.php');
	$view = new View_Page_Gallery();
	$view->display();
}