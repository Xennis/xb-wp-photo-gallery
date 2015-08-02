<?php
/**
 * Configuration of the database on plugin installation.
 * 
 * @package config
 */
abstract class SPG_Config_Db {
	
	const PREFIX = 'spg_';
	
	private static function createTable($tableName, $sql) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix.self::PREFIX.$tableName."` ($sql) $charset_collate;";	
		$wpdb->query($sql);
	}
	
	public static function __setup_database_tables() {
		self::createTable('gallery', "
			`id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(35) NOT NULL,
			`description` text NOT NULL,
			`slug` varchar(40) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `slug` (`slug`)		
		");	
	}
}