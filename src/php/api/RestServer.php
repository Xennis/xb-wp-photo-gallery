<?php

class SPG_Api_RestServer {
	
	// HTTP status codes
	const HTTP_STATUS_200_OK = 200;
	const HTTP_STATUS_201_CREATED = 201;
	const HTTP_STATUS_202_ACCEPTED = 202;
	const HTTP_STATUS_204_NO_CONTENT = 204;	
	const HTTP_STATUS_400_BAD_REQUEST = 400;
	const HTTP_STATUS_403_FORBIDDEN = 403;
	const HTTP_STATUS_404_NOT_FOUND = 404;
	// Response header parameter names
	const HEADER_CONTENT_TYPE = 'Content-Type';
	const HEADER_X_TOTAL_COUNT = 'X-Total-Count';
	// Response header parameter values
	const HEADER_CONTENT_TYPE_JSON = 'application/json';	
	
	const API_NAMESPACE = 'smart-gallery/api/';
	
	const ROUTE_GALLERIES = 'galleries';
	
	private $args = array();
	

	public function __construct() {
		$this->register_route(self::ROUTE_GALLERIES, array(
			'method' => 'GET'
		));
	}	
	
	public function register_route($route, $args) {
		$this->args[$route] = $args;
	}

	public function serve_request( $route = null ) {
		
		$request = new SPG_Api_Request($route);
		$response = new SPG_Api_Response();
		if ($request->getRoute() == self::ROUTE_GALLERIES) {
			require_once SPG_DIR.'/src/php/api/model/Galleries.php';
			$model = new SPG_Api_Model_Galleries();
			
			switch ($request->getMethod()) {
				case 'GET':
					$response->setBody($model->getList($request->getParam('path')));
					break;
				case 'POST':
					$response->setStatus($model->postItem($request->getBody()));
					break;
			}
		}
		else if($this->_startsWith($request->getRoute(), self::ROUTE_GALLERIES)) {
			require_once SPG_DIR.'/src/php/api/model/Galleries.php';
			$model = new SPG_Api_Model_Galleries();
			$id = $request->getRoute(1);
			if (is_numeric($id)) {
				
				switch ($request->getMethod()) {
					case 'GET':
						$response->setBody($model->getItem($id));
						break;
					case 'POST':
						$response->setStatus($model->postItem($request->getBody(), $id));
						break;
					case 'DELETE':
						$response->setStatus($model->deleteItem($id));
						break;
				}
				
			}
		}
		
		$response->execute();
	}
	
	private function _startsWith($string, $value) {
		return 0 === strpos($string, $value);
	}
	
	private function _getJsonError() {
		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				echo ' - No errors';
			break;
			case JSON_ERROR_DEPTH:
				echo ' - Maximum stack depth exceeded';
			break;
			case JSON_ERROR_STATE_MISMATCH:
				echo ' - Underflow or the modes mismatch';
			break;
			case JSON_ERROR_CTRL_CHAR:
				echo ' - Unexpected control character found';
			break;
			case JSON_ERROR_SYNTAX:
				echo ' - Syntax error, malformed JSON';
			break;
			case JSON_ERROR_UTF8:
				echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
			break;
			default:
				echo ' - Unknown error';
			break;
		}
	}
}