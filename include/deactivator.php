<?php if (!defined('ABSPATH')) exit;
global $wpdb;
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// Основная таблица
$table = $wpdb->prefix . 'messenger_button';
$sql = "DROP TABLE IF EXISTS " . $table;
$wpdb->query($sql);

// таблица с параметрами
$table = $wpdb->prefix . 'messenger_button_params';
$sql = "DROP TABLE IF EXISTS   $table";
$wpdb->query($sql);


