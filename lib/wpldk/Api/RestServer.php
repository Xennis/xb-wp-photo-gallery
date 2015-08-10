<?php
if (isset($wpdlk_rest_server)) {
	die();
}

$wpdlk_rest_server = new WPLDK_Api_RestServer();

function wpldk_register_rest_route($namespace, $route, array $args) {
	global $wpdlk_rest_server;
	$wpdlk_rest_server->register_route($namespace, $namespace.'/'.$route, $args);
}

function wpldk_rest_api_init() {
	global $wpdlk_rest_server;	
	foreach ($wpdlk_rest_server->namespaces as $namespace) {
		add_rewrite_rule( '^'.$namespace.'(.*)?','index.php?wpldk_rest_route='.$namespace.'$matches[1]','top' );		
	}
	flush_rewrite_rules();

	global $wp;
	$wp->add_query_var('wpldk_rest_route');
}
add_action('init', 'wpldk_rest_api_init');

function wpldk_rest_api_loaded() {
	global $wp;
	if ( empty( $wp->query_vars['wpldk_rest_route'] ) ) {
		return;
	}
	
	global $wpdlk_rest_server;
	$wpdlk_rest_server->serve_request( $wp->query_vars['wpldk_rest_route'] );

	die();
}
add_action('parse_request', 'wpldk_rest_api_loaded');

class WPLDK_Api_RestServer {
	
	public $namespaces = array();
	private $args = array();
	
	public function register_route($namespace, $route, $args) {
		$this->args[$route] = $args;
		$this->namespaces[] = $namespace;
	}

	public function serve_request( $path = null ) {
		if (array_key_exists($path, $this->args)) {
			echo "It works!";
		};
	}	
	
}