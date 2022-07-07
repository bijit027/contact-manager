<?php

namespace CM\Includes\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode
{
    /**
     * Initializes the class
     */
    function __construct()
    {
        add_shortcode('contact-code', [$this, 'render_shortcode']);
    }

    public function loadAssets()
    {
        wp_enqueue_style(
            'contact_frontends_css',
            CM_CONTACTS_BASE_DIR . 'assets/css/frontend.css',
        );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode($atts = [], $content = '')
    {

        $this->loadAssets();

        $atts = shortcode_atts(array(
            'id' => ''
        ), $atts );
        $id = $atts['id'];

        if (!empty( $atts['id'])) {
            $items = cm_get_contacts_by_id($id);
            return $this->renderAttributes($items);
        } else {
            $items = cm_get_all_contacts();
            return $this->renderAttributes($items);
        }
    }

    public function renderAttributes($items)
    {

        if(empty($items)){
            return '<div><h2 style="color:red; border: 1px solid black">Nothing To Show</h2></div>';
        }
        else{
        ob_start();
        include CM_CONTACTS_PATH . '/includes/Views/AttributeRender.php';
        $content = ob_get_clean();
        return $content;
        }
    }

}
