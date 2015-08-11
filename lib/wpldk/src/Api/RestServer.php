<?php
if (isset($wpdlk_rest_server)) {
	die();
}

$wpdlk_rest_server = new WPLDK_Api_RestServer();

/**
 * Register a new route
 * 
 * @global WPLDK_Api_RestServer $wpdlk_rest_server
 * @param string $namespace Namespace, i.e. 'my-plugin/api'
 * @param string $route Route, i.e. 'author'
 * @param array $args
 */
function wpldk_register_rest_route($namespace, $route, array $args) {
	global $wpdlk_rest_server;
	$wpdlk_rest_server->register_route($namespace, $namespace.'/'.$route, $args);
}

/**
 * On init
 * 
 * @global WPLDK_Api_RestServer $wpdlk_rest_server
 * @global type $wp
 */
function wpldk_rest_api_init() {
	global $wp;
	$wp->add_query_var('wpldk_rest_route');

	global $wpdlk_rest_server;	
	foreach ($wpdlk_rest_server->namespaces as $namespace) {
		add_rewrite_rule( '^'.$namespace.'(.*)?','index.php?wpldk_rest_route='.$namespace.'$matches[1]','top' );		
	}
	flush_rewrite_rules();
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
		$this->namespaces[] = $namespace;
		$this->args[$route] = $args;
	}

	public function serve_request( $route = null ) {
		if (array_key_exists($route, $this->args)) {
			
			var_dump($_GET);
			echo "<br>";
			$args = $this->args[$route];
			
			if ($args['callback']) {
				call_user_func($args['callback']);
			}	
		}
	}	
	
}