<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SPG_Api_Response {
	
	private $body;
	
	public function setStatus($code) {
		http_response_code($code);
	}
	
	
	public function setHeader($param, $value) {
		header($param.':'.$value);
	}
	
	public function setBody($value) {
		$this->setHeader(SPG_Api_RestServer::HEADER_CONTENT_TYPE, SPG_Api_RestServer::HEADER_CONTENT_TYPE_JSON);

		$this->body = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);	
	}
	
	public function setBodyErrorMessage($message) {
		setBody([
			'error' => $message
		]);
	}
	
	public function execute() {
		echo $this->body;
	}
}