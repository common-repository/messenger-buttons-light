<?php if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$table = $wpdb->prefix . 'messenger_button';
$sql = "CREATE TABLE " . $table." (
	id int(11) NOT NULL AUTO_INCREMENT,
	title VARCHAR(200) DEFAULT NULL,  
	code VARCHAR(200) DEFAULT NULL,  
	href VARCHAR(200) DEFAULT NULL,  
	onclick TEXT DEFAULT NULL,
	active int(11) DEFAULT NULL,
	UNIQUE KEY id (id)
	) DEFAULT CHARSET=utf8;";
dbDelta($sql);


$table = $wpdb->prefix . 'messenger_button_params';
$sql = "CREATE TABLE " . $table." (
	id int(11) NOT NULL AUTO_INCREMENT,
	params TEXT DEFAULT NULL,
	UNIQUE KEY id (id)
	) DEFAULT CHARSET=utf8;";
dbDelta($sql);