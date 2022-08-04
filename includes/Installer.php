<?php

namespace CM\Includes;

class Installer
{
    public function run()
    {
        $this->addVersion();
        $this->createContactsTable();
        $this->createOptionForSettings();
    }

    public function addVersion()
    {
        $isInstalled = get_option("cm_is_installed");
        if (!$isInstalled) {
            update_option("cm_is_installed", time());
        }
        update_option("cm_version", CM_VERSION);
    }

    public function createContactsTable()
    {
        global $wpdb;
        $charsetCollate = $wpdb->get_charset_collate();
        $tableName = $wpdb->prefix . "contacts";
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `name` varchar(200) DEFAULT NULL,
            `photo` varchar(200) DEFAULT NULL,
            `email` varchar(200) DEFAULT NULL,
            `mobile` varchar(200) DEFAULT NULL,
            `company` varchar(200) DEFAULT NULL,
            `title` varchar(200) DEFAULT NULL,
            
            PRIMARY KEY(`id`)
            ) $charsetCollate;";

        if (!function_exists("dbDelta")) {
            require_once ABSPATH . "wp-admin/includes/upgrade.php";
        }
        dbDelta($sql);
    }

    public function createOptionForSettings()
    {
        $defaults = [
            "id" => "1",
            "color" => "#4CAF50",
            "limit" => "5",
            "page" => "3",
            "column" => ["None"],
            "orderby" => "Id",
        ];
        // add a new option
        add_option("cm_settings_value", $defaults);
    }
}
