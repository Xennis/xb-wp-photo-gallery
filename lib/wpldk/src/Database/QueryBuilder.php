<?php

class WPLDK_Database_QueryBuilder {
	//put your code here
	
	protected $_table_name;

	public $_limit;

	public static function for_table($table_name) {
        return new self($table_name);
    }
	
	protected function __construct($table_name) {
		 $this->_table_name = $table_name;
	}
	
	public function limit($limit) {
		$this->_limit = $limit;
		return $this;
	}
	
	public function find_one($id=null) {
		if (!is_null($id)) {
			$this->where_id_id($id);
		}
		
		$this->limit(1);
		
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM $wpdb->links WHERE link_id = 10");
/*        $rows = $this->_run();
        if (empty($rows)) {
            return false;
        }
        return $this->_create_instance_from_row($rows[0]);*/
	}
}
