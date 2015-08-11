<?php

class WPLDK_Database_Model {
	
	const PREFIX = 'spg_';
	const OUTPUT_TYPE_OBJECT = 'OBJECT';
	const OUTPUT_TYPE_ARRAY_A = 'ARRAY_A';

	private $table;
	
	/**
	 * 
	 * @param string $table
	 * @return CURD_Model
	 */
	public function __construct($table) {
		global $wpdb;
		$this->table = $wpdb->prefix.self::PREFIX.$table;

		return $this;
	}

	public function get($id, $output_type = self::OUTPUT_TYPE_OBJECT) {
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM `".$this->table."` WHERE id = ".$id, $output_type);
	}
	
	public function getMultiple($whereCondition = NULL, $orderBy = NULL) {
		global $wpdb;
		
		$body = '';
		if ($whereCondition) {
			$body .= ' WHERE '.$whereCondition;
		}
		if ($orderBy) {
			$body .= ' ORDER BY `'.$orderBy.'`';
		}
		
		return $wpdb->get_results("SELECT * FROM `".$this->table.'` '.$body);
	}
	
	/**
	 * 
	 * @global type $wpdb
	 * @param array $data
	 * @return boolean|int
	 */
	public function insert(array $data) {
		global $wpdb;
		$result = $wpdb->insert($this->table, $data);
		if ($result) {
			return $wpdb->insert_id;
		}
		return FALSE;
	}	
	
	/**
	 * 
	 * @global type $wpdb
	 * @param array $data
	 * @param int $id
	 * @return boolean
	 */
	public function update(array $data, $id) {
		global $wpdb;
		return $wpdb->update($this->table, $data, array(
			'id' => $id
		));
	}
	
	/**
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function updateMultiple($data) {
		$error_IDs = [];
		foreach ($data as $id => $item) {
			$result = $this->update($item, $id);
			if ($result === FALSE) { // Returns 0, if zero rows got updated. That's not an error.
				$error_IDs[] = $id;
			}
		}
		
		if (empty($error_IDs)) {
			return true;
		} else {
			return $error_IDs;
		}
	}
	
	public function delete($id) {
		global $wpdb;
		return $wpdb->delete($this->table, array(
			'id' => $id
		) );
	}
	
	public function createTable($sql) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".$this->table."` ($sql) $charset_collate;";	
		$wpdb->query($sql);
	}
	
}
