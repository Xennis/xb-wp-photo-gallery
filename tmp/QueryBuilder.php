<?php

class WPLDK_Database_QueryBuilder {
	//put your code here
	
	protected $_table_name;
	protected $_limit;
	protected $_offset;
	protected $_order_by = array();

	public static function for_table($table_name) {
        return new self($table_name);
    }
	
	protected function __construct($table_name) {
		 $this->_table_name = $table_name;
	}
	private function _run() {
		
		$query = '';
		
		if ($this->_limit) {
			$query .= ' LIMIT ';
			if ($this->_offset) {
				$query .= $this->_offset.', ';
			}
			$query .= $this->_limit;
		}
		if (!empty($this->_order_by)) {
			$query .= ' ORDER BY '.implode(',', $this->_order_by);
		}
	}
	
	public function delete($id) {
		global $wpdb;
		$wpdb->delete($this->_table_name);
	}
	
	public function find_array() {
		
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
	
	
	public function limit($limit, $offset=null) {
		$this->_limit = $limit;
		$this->_offset = $offset;
		return $this;
	}
	
	public function order_by_asc($column_name) {
		$this->_order_by[] = $column_name . ' ASC';
		return $this;
	}	
	
	public function select($column, $alias=null) {
		$column = $this->_quote_identifier($column);
           return $this->_add_result_column($column, $alias);
	}
	
	public function select_many($fields) {
		
	}
	
	public function save() {
		
	}

	public function set($data) {
		
	}
	
	public function where_equal($column_name, $value=null) {
		
	}
	
	public function where_raw($clause, $parameters) {
		
	}
}
