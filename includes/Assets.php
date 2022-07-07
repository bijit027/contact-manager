<?php

namespace CM\Includes;

class Assets
{
  function __construct()
  {
    if (is_admin()) {
      add_action('admin_enqueue_scripts', [$this, 'register']);
    } else {
      add_action('wp_enqueue_scripts', [$this, 'register']);
    }
  }

  public function register()
  {
    $this->register_scripts($this->get_scripts());
    wp_localize_script('cm', 'ajax_url', array(
      'ajaxurl' => admin_url('admin-ajax.php')
    ));
    $this->register_styles($this->get_styles());
  }

  private function register_scripts($scripts)
  {
    foreach ($scripts as $handle => $script) {
      $deps      = isset($script['deps']) ? $script['deps'] : false;
      $in_footer = isset($script['in_footer']) ? $script['in_footer'] : false;
      $version   = isset($script['version']) ? $script['version'] : CM_VERSION;
      wp_register_script($handle, $script['src'], $deps, $version, $in_footer);
    }
  }

  public function register_styles($styles)
  {
    foreach ($styles as $handle => $style) {
      $deps = isset($style['deps']) ? $style['deps'] : false;

      wp_register_style($handle, $style['src'], $deps, CM_VERSION);
    }
  }

  public function get_scripts()
  {
    return [
      'cm-admin-script' => [
        'src'       => CM_ASSETS . '/admin/admin.js',
        'deps'      => null,
        'version'   => filemtime(CM_PLUGIN_PATH . 'assets/admin/admin.js'),
        //'deps' => ['jquery'],
        'in_footer' => true
      ],
    ];
  }

  public function get_styles()
  {
    return [
      'fontawsome' => [
        'src' => CM_ASSETS . "/fontawesome/css/all.min.css",
      ],
      'bootstrap' => [
        'src' => CM_ASSETS . "/bootstrap/css/bootstrap.min.css",
      ]
    ];
  }
}
