<?php
/**
 * Description of Edit
 *
 * @author Fabian
 */
class WPLDK_Helper_AdminNotice {
	
	private $optionName;
	
	const CSS_CLASS_UPDATED = 'updated';
	const CSS_CLASS_ERROR = 'error';
	
	function __construct($optionName) {
		$this->optionName = $optionName;
	}

	public function hook($class = self::CSS_CLASS_UPDATED) {
		if ($notices = get_option($this->optionName)) {
			foreach ($notices as $notice) {
				echo '<div class="'.$class.'"><p>'.$notice.'</p></div>';
			}
			delete_option($this->optionName);
		}
	}
	
	private function add($notice, $type) {
		$notices= get_option($this->optionName, array());
		$notices[]= $notice;
		update_option($this->optionName, $notices);
		$this->hook($type);		
	}
	
	public function addUpdate($notice = 'Saved') {
		$this->add($notice, self::CSS_CLASS_UPDATED);
	}
	
	public function addError($notice = 'Saving failed') {
		$this->add($notice, self::CSS_CLASS_ERROR);
	}
}