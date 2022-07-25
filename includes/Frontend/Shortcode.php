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
            return $this->renderAttributesWithId($items,$settings);
        } else {
            $settings = cm_custom_shortcode();
            $items = cm_get_all_contacts();
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

            foreach($settings as $setting){
                $limit = $setting->limit;
                $orderby = $setting->orderby;
                }
            if (!isset ($_GET['pageno'])) {  
                $page = 1; 
                $current_page = 1; 
            } else {  
                $page = $_GET['pageno'];  
                $current_page = $_GET['pageno'];
            }
            
            $results_per_page = $limit;  
            $page_first_result = ($page-1) * $results_per_page;  
            $number_of_result = count($items); 
            
            //determine the total number of pages available  
            $number_of_page = ceil ($number_of_result / $results_per_page);
          
          
            $contact_items = cm_get_pegination_data($page_first_result,$results_per_page,$orderby);

            ob_start();
            include CM_CONTACTS_PATH . '/includes/Views/AttributeRender.php';
            $content = ob_get_clean();
            return $content;
        }
    }

    public function renderAttributesWithId( $items,$settings)
    {
        $this->loadAssets();
  
        $contact_items = $items;
        ob_start();
        include_once CM_CONTACTS_PATH . '/includes/Views/AttributeRender.php';
        $content = ob_get_clean();
        return $content;
    }

}
