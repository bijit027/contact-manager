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

        $atts = shortcode_atts(array(
            'id' => ''
        ), $atts );
        $id = $atts['id'];

        if (!empty( $atts['id'])) {

            $settings = cm_custom_shortcode();
            $items = cm_get_contacts_by_id($id);
            return $this->renderAttributes($items,$settings);
        } else {
            $settings = cm_custom_shortcode();
            foreach($settings as $setting){
                $limit = $setting->limit;
                $orderby = $setting->orderby;
                }
            $items = cm_get_all_contacts($limit,$orderby);
            return $this->renderAttributes($items,$settings);
        }
    }

    public function renderAttributes($items,$settings)
    {
        $color  = 'red';
        if(empty($items)){
            return '<div><h2 style="color:'.$color.'border: 1px solid black">Nothing To Show</h2></div>';
        }
        else{
            $this->loadAssets();
            ob_start();
            include CM_CONTACTS_PATH . '/includes/Views/AttributeRender.php';
            $content = ob_get_clean();
            return $content;
        }
    }

}
