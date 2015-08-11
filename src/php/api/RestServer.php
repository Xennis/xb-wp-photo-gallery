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
		$this->register_route(self::ROUTE_GALLERIES, NULL);
	}	
	
	public function register_route($route, $args) {
		$this->args[$route] = $args;
	}

	public function serve_request( $route = null ) {
		switch ($route) {
			case self::ROUTE_GALLERIES:
				
				$a = array();
				$a[] = 'test';
				$a[] = 'yo';
								http_response_code(403);

				$a = $this->setBody($a);

				

				break;

			default:
				break;
		}
		
	}
	
	private function setHeader($param, $value) {
		header($param.':'.$value);
	}
	
	private function setBody($value) {
		$this->setHeader(self::HEADER_CONTENT_TYPE, self::HEADER_CONTENT_TYPE_JSON);

		echo json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);	
	}
	
	private function setBodyErrorMessage($message) {
		setBody([
			'error' => $message
		]);
	}
		
	
}