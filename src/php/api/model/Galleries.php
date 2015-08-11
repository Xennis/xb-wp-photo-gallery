<?php

class SPG_Api_Model_Galleries {
	
	private $model;
	
	public function __construct() {
		$this->model = new WPLDK_Database_Model('g');
	}
	
	public function getList($path=null) {
		if (isset($path)) {
			$whereCondition = "`file` LIKE '${path}/%' AND `file` NOT LIKE '${path}/%/%'";
		} else {
			$whereCondition = "`file` NOT LIKE '%/%'";
		}
		return $this->model->getMultiple($whereCondition, 'title');
	}
	
	public function getItem($id) {
		return $this->model->get($id);
	}
	
	public function postItem(array $data, $id=null) {
		if ($id) {
			$result = $this->model->update($data, $id);
		} else {
			$result = $this->model->insert($data);			
		}
		if ($result === false) {
			return SPG_Api_RestServer::HTTP_STATUS_400_BAD_REQUEST;
		} else {
			return SPG_Api_RestServer::HTTP_STATUS_201_CREATED;
		}
	}
	
	public function deleteItem($id) {
		$result = $this->model->delete($id);
		if ($result === false) {
			return SPG_Api_RestServer::HTTP_STATUS_400_BAD_REQUEST;
		} else {
			return SPG_Api_RestServer::HTTP_STATUS_202_ACCEPTED;
		}
	}
}