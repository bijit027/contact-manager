<?php

namespace CM\Includes;

class Installer
{

    public function run()
    {
        $this->add_version();
        $this->create_contacts_table();
        $this->create_settings_table();
        $this->settings_value();
      
    }

    public function add_version()
    {
        $is_installed = get_option('cm_is_installed');
        if (!$is_installed) {
            update_option('cm_is_installed', time());
        }
            update_option('cm_version', CM_VERSION);
    }

    public function create_contacts_table()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'contacts';
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `name` varchar(200) DEFAULT NULL,
            `photo` varchar(200) DEFAULT NULL,
            `email` varchar(200) DEFAULT NULL,
            `mobile` varchar(200) DEFAULT NULL,
            `company` varchar(200) DEFAULT NULL,
            `title` varchar(200) DEFAULT NULL,
            
            PRIMARY KEY(`id`)
            ) $charset_collate;";

        if (!function_exists('dbDelta')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }
            dbDelta($sql);
    }

    public function create_settings_table(){

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'settings';
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `color` varchar(200) DEFAULT NULL,
            `limit` varchar(200) DEFAULT NULL,
            `page` varchar(200) DEFAULT NULL,
            `column` varchar(200) DEFAULT NULL,
            `orderby` varchar(200) DEFAULT NULL,
            
            PRIMARY KEY(`id`)
            ) $charset_collate;";

        

        if (!function_exists('dbDelta')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }

            dbDelta($sql);
            

    }
    public function settings_value(){
        global $wpdb;
        $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}settings");
        if(empty( $sql)){
        $defaults = [

            'id'        => '1',
            'color'     => '#4CAF50',
            'limit'     => '5',
            'page'      => '3',
            'column'    => 'YToxOntpOjA7czo0OiJOb25lIjt9',
            'orderby'   => 'id'

        ];
        $table_name = $wpdb->prefix . 'settings';

        $inserted = $wpdb->insert(
            $table_name,
            $defaults
        );
    }


    }

    
    
}
