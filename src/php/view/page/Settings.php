<?php

class View_Page_Settings {

	private $tab = 'general';
	private $page;
	
	public function __construct() {
		if ( isset ( $_GET['tab'] ) ) {
			$$this->tab = $_GET['tab'];
		}
		$this->page = '?page='.$_GET['page'];


	}
	
	public function display() {
		$tabs = array(
			'general' => __('General', ACM_NAME)
		);
		?>
	<div class="wrap">
		<?php wp_helper_getPageTitleAddNew(__('Settings')); ?>
		<?php echo spg_helper_admin_tabs($this->page, $tabs, $this->tab); ?>
		<?php
		switch ($this->tab) {
			default:
				$this->tabGeneral();
				break;
		}
		?>
	</div>	
	<?php		
	}
	
	private function tabGeneral() {
		$view = (new WPLDK_View_Settings_DatabaseTable('galleries', $this->id))
			->setFields(array(
				(new WPLDK_Form_Field('spg_thumbnail_size', 'Thumbnail size', 'number'))
					->setTextBehindField('pixel'),
			) )
		->display($this->page);
	}
}
