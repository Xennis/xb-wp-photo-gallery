<?php
/**
 * Configuration of the database on plugin installation.
 * 
 * @package config
 */
abstract class SPG_Config_Db {
	
	public static function __setup_database_tables() {
		require_once(WPLDK_DIR . '/Database/Model.php');
		
		(new WPLDK_Database_Model('gallery'))->createTable("
			`id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(35) NOT NULL,
			`description` text NOT NULL,
			`slug` varchar(40) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `slug` (`slug`)		
		");
		
		(new WPLDK_Database_Model('photos'))->createTable("
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`file` varchar(50) NOT NULL,
			`description` text NOT NULL,
			`gallery` tinyint(2) NOT NULL,
			`sequence` int(3) NOT NULL,
			PRIMARY KEY (`id`)
		");		
	}
}