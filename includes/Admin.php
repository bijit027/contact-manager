<?php

namespace CM\Includes;

class Admin
{
    public function __construct()
    {
        add_action("admin_menu", [$this, "addMenu"]);
    }

    public function addMenu()
    {
        $hook = add_menu_page(
            __("Contact Manager", "contact-manager"),
            __("Contact Manager", "contact-manager"),
            "manage_options",
            "contact-manager",
            [$this, "adminMenuPage"],
            "dashicons-id-alt",
            10
        );
        //contact-manager-settings
        add_submenu_page(
            "contact-manager",
            __("Contact", "contact-manager"),
            __("Contact", "contact-manager"),
            "manage_options",
            "contact-manager",
            [$this, "adminMenuPage"]
        );

        $custom = add_submenu_page(
            "contact-manager",
            __("Settings", "contact-manager"),
            __("Settings", "contact-manager"),
            "manage_options",
            "contact-manager#/settings",
            [$this, "adminMenuPage"]
        );

        add_action("load-" . $hook, [$this, "initHooks"]);
        add_action("load-" . $custom, [$this, "initHooks"]);
    }

    public function initHooks()
    {
        add_action("admin_enqueue_scripts", [$this, "enqueueAssets"]);
    }

    public function adminMenuPage()
    {
        echo '<div id="cm-admin-app"></div>';
    }

    public function enqueueAssets()
    {
        wp_enqueue_style("fontawsome");
        wp_enqueue_style("bootstrap");
        wp_enqueue_script("cm-admin-script");
    }
}
