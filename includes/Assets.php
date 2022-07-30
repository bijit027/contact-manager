<?php

namespace CM\Includes;

class Assets
{
    public function __construct()
    {
        if (is_admin()) {
            add_action("admin_enqueue_scripts", [$this, "register"]);
        } else {
            add_action("wp_enqueue_scripts", [$this, "register"]);
        }
    }

    public function register()
    {
        $this->registerScripts($this->getScripts());
        wp_localize_script("cm-admin-script", "ajax_url", [
            "ajaxurl" => admin_url("admin-ajax.php"),
            "wpsfb_nonce" => wp_create_nonce("wpsfb_ajax_nonce"),
        ]);
        wp_localize_script("cm-custom-script", "ajax_url", [
            "ajaxurl" => admin_url("admin-ajax.php"),
            "wpsfb_nonce" => wp_create_nonce("wpsfb_ajax_nonce"),
        ]);
        $this->registerStyles($this->getStyles());
    }

    private function registerScripts($scripts)
    {
        foreach ($scripts as $handle => $script) {
            $deps = isset($script["deps"]) ? $script["deps"] : false;
            $in_footer = isset($script["in_footer"])
                ? $script["in_footer"]
                : false;
            $version = isset($script["version"])
                ? $script["version"]
                : CM_VERSION;
            wp_register_script(
                $handle,
                $script["src"],
                $deps,
                $version,
                $in_footer
            );
        }
    }

    public function registerStyles($styles)
    {
        foreach ($styles as $handle => $style) {
            $deps = isset($style["deps"]) ? $style["deps"] : false;
            wp_register_style($handle, $style["src"], $deps, CM_VERSION);
        }
    }

    public function getScripts()
    {
        return [
            "cm-admin-script" => [
                "src" => CM_ASSETS . "/admin/admin.js",
                "deps" => ["jquery"],
                "version" => filemtime(
                    CM_PLUGIN_PATH . "assets/admin/admin.js"
                ),
                "in_footer" => true,
            ],
            "cm-custom-script" => [
                "src" => CM_ASSETS . "/admin/custom.js",
                "deps" => ["jquery"],
                "version" => filemtime(
                    CM_PLUGIN_PATH . "assets/admin/custom.js"
                ),
                "in_footer" => true,
            ],
        ];
    }

    public function getStyles()
    {
        return [
            "fontawsome" => [
                "src" => CM_ASSETS . "/fontawesome/css/all.min.css",
            ],
            "bootstrap" => [
                "src" => CM_ASSETS . "/bootstrap/css/bootstrap.min.css",
            ],
        ];
    }
}
