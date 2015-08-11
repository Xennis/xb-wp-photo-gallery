<?php

class WPLDK_View_Settings_DatabaseTable extends WPLDK_View_Settings_Common {
	
	private $id;
	private $data = array();

	public function __construct($model, $id = NULL) {
		$this->id = $id;
		if ($this->id) {
			$this->data = (new WPLDK_Database_Model($model))->get($this->id, WPLDK_Database_Model::OUTPUT_TYPE_ARRAY_A);
		}

		return $this;
	}
	
	protected function _outputTable() {
		if ($this->id) echo '<input type="hidden" name="data_id" value="'.$this->id.'">';
		parent::_outputTable();
	}

	protected function getData($field) {
		return $this->data[$field];
	}


}