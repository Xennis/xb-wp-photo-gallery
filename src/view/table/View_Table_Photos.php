<?php
class View_Table_Photos extends CRUD_Table_Horizontal {

	private $galleryId;
	private $galleryPath;
	
	function __construct($galleryId, $gallerySlug) {
		$this->galleryId = $galleryId;
		$upload_dir = wp_upload_dir();
		$this->galleryPath = $upload_dir['baseurl'].DIRECTORY_SEPARATOR.SPG_NAME.DIRECTORY_SEPARATOR.$gallerySlug.DIRECTORY_SEPARATOR;

		parent::__construct(array(
			'singular'  => 'photo',
			'plural'    => 'photos',
			'ajax'      => false
		));
	}
	
	function get_columns() {
		return array(
			'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			'file' => 'File',
			'title' => 'Title',		   
			'description ' => 'Description'
		);
	}
	
	function get_sortable_columns() {
		return array(
			'file' => array('file'),
			'title' => array('title')
		);
	}
	
	function column_file($item) {
		return '<img src="'.$this->galleryPath.$item['file'].'" width="200px">';
	}
	
	function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete',
			'mode' => 'Move'
		);
		return $actions;
	}	
	
	function display() {
		parent::prepare_items('gallery = '.$this->galleryId);
		parent::display();
	}

}