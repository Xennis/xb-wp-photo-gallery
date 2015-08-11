<?php
require_once(SPG_DIR.'/src/php/api/RestServer.php');
$spgRestServer = new SPG_Api_RestServer();

function spg_add_api_route() {
	global $wp;
	$wp->add_query_var('spg_rest_route');

	add_rewrite_rule('^'.SPG_Api_RestServer::API_NAMESPACE.'(.*)?','index.php?spg_rest_route=$matches[1]','top' );		
	flush_rewrite_rules();
}
add_action('init', 'spg_add_api_route');

function spg_rest_api_loaded() {
	global $wp;
	if ( empty( $wp->query_vars['spg_rest_route'] ) ) {
		return;
	}
	
	global $spgRestServer;
	$spgRestServer->serve_request( $wp->query_vars['spg_rest_route'] );

	die();
}
add_action('parse_request', 'spg_rest_api_loaded');