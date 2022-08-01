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
        add_shortcode("contact-code", [$this, "renderShortcode"]);
    }

    public function loadAssets()
    {
        wp_enqueue_style("contact_frontends_css", CM_CONTACTS_BASE_DIR . "assets/css/frontend.css");
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function renderShortcode($atts = [], $content = "")
    {
        $atts = shortcode_atts(
            [
                "id" => "",
            ],
            $atts
        );
        $id = $atts["id"];

        if (!empty($atts["id"])) {
            // $settings = get_option("cm_settings_value");
            $items = getContactsById($id);
            $separator = "withId";
            return $this->renderAttributes($items, $separator);
        } else {
            // $settings = get_option("cm_settings_value");
            $items = GetAllContacts();
            $separator = "withoutId";
            return $this->renderAttributes($items, $separator);
        }
    }

    public function renderAttributes($items, $separator)
    {
        $settings = get_option("cm_settings_value");
        extract($settings);
        $this->loadAssets();
        if (empty($items)) {
            ob_start();
            include CM_CONTACTS_PATH . "/includes/Views/Error.php";
            $error = ob_get_clean();
            return $error;
        } else {
            $contact_items = $items;

            // extract($settings);

            if ($separator != "withId") {
                //For pagination
                if (!isset($_GET["pageno"])) {
                    $page = 1;
                    $current_page = 1;
                } else {
                    $page = $_GET["pageno"];
                    $current_page = $_GET["pageno"];
                }
                $shortcode_id = "not exist";
                $results_per_page = $limit;
                $page_first_result = ($page - 1) * $results_per_page;
                $number_of_result = count($items);

                //determine the total number of pages available
                $number_of_page = ceil($number_of_result / $results_per_page);

                $contact_items = getPeginationData($page_first_result, $results_per_page, $orderby);

                $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $pageNumber = "?pageno=" . $_GET["pageno"];
                if (strpos($url, "?pageno") || !strpos($url, "?")) {
                    $position = strpos($url, $pageNumber);
                    if ($position === false) {
                        $finalurl = $url . "?";
                    } else {
                        $finalurl = substr($url, 0, $position) . "?";
                    }
                } else {
                    $pageNumber = "&pageno=" . $_GET["pageno"];
                    $position = strpos($url, $pageNumber);
                    if ($position === false) {
                        $finalurl = $url . "&";
                    } else {
                        $finalurl = substr($url, 0, $position) . "&";
                    }
                }
            }

            // For table header

            $tableHeader = [
                "id" => "Id",
                "name" => "Name",
                "email" => "Email",
                "mobile" => "Mobile",
                "company" => "Company",
                "title" => "Title",
            ];

            // (array) ($column = maybe_unserialize($settings[0]->column));
            if (empty($column)) {
                $column = ["1"];
            }

            $alterHeader = array_diff($tableHeader, (array) $column);
            $lowerCaseColumn = array_map("strtolower", (array) $column);

            // $contact_items = cm_get_pegination_data($page_first_result,$results_per_page,$orderby);

            foreach ($contact_items as $items) {
                foreach ($lowerCaseColumn as $col) {
                    unset($items->$col);
                }
            }

            //Load Shortcode View Page
            ob_start();
            include CM_CONTACTS_PATH . "/includes/Views/AttributeRender.php";
            $content = ob_get_clean();
            return $content;
        }
    }
}
