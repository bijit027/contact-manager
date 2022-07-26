<?php

namespace CM\Includes;

class Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'cm_admin_menu']);
    }

    public function cm_admin_menu()
    {
        $hook = add_menu_page(
            __('Contact Manager', 'contact-manager'),
            __('Contact Manager', 'contact-manager'),
            'manage_options',
            'contact-manager',
            [$this, 'admin_menu_page'],
            'dashicons-id-alt',
            10
        );
        //contact-manager-settings
        add_submenu_page( 'contact-manager', __( 'Contact', 'contact-manager' ), __( 'Contact', 'contact-manager' ),'manage_options','contact-manager', [ $this, 'admin_menu_page' ] );
       $custom =  add_submenu_page( 'contact-manager', __( 'Settings', 'contact-manager' ), __( 'Settings', 'contact-manager' ),'manage_options','contact-manager-settings', [ $this, 'admin_settings_page' ] );
        add_action('load-' . $hook, [$this, 'init_hooks']);
        add_action('load-' . $custom, [$this, 'custom_hooks']);
    }

    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function custom_hooks(){

        add_action('admin_enqueue_scripts', [$this, 'custom_enqueue_scripts']);
    }

    public function admin_menu_page()
    {
        echo '<div id="cm-admin-app"></div>';
    }

    public function admin_settings_page()
    {
        echo '<div id="cm-custom-app"></div>';
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('fontawsome');
        wp_enqueue_style('bootstrap');
        wp_enqueue_script('cm-admin-script');
        
    }
    public function custom_enqueue_scripts(){

        wp_enqueue_style('fontawsome');
        wp_enqueue_style('bootstrap');
        wp_enqueue_script('cm-custom-script');
    }
}
