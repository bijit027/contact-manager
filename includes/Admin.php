<?php

namespace CM\Includes;

class Admin
{
  function __construct()
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
      'dashicons-text',
      10
    );

    add_action('load-' . $hook, [$this, 'init_hooks']);
  }

  public function init_hooks()
  {
    add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
  }

  public function admin_menu_page()
  {
    echo '<div id="cm-admin-app"></div>';
  }

  public function enqueue_scripts()
  {
    wp_enqueue_style('fontawsome');
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('cm-admin-script');
  }
}
