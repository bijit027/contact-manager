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
            $items = getContactsById($id);
            $separator = "withId";
            return $this->renderAttributes($items, $separator);
        } else {
            $items = getAllContacts();
            $separator = "withoutId";
            return $this->renderAttributes($items, $separator);
        }
    }

    public function renderAttributes($items, $separator)
    {
        $settings = get_option("cm_settings_value");

        $color = $settings["color"];
        $limit = $settings["limit"];
        $page = $settings["page"];
        $orderby = $settings["orderby"];
        $column = $settings["column"];

        $this->loadAssets();
        if (empty($items)) {
            ob_start();
            include CM_CONTACTS_PATH . "/includes/Views/Error.php";
            $error = ob_get_clean();
            return $error;
        } else {
            $contactItems = $items;

            if ($separator != "withId") {
                //For pagination
                if (!isset($_GET["pageno"])) {
                    $page = 1;
                    $currentPage = 1;
                } else {
                    $page = $_GET["pageno"];
                    $currentPage = $_GET["pageno"];
                }

                $resultsPerPage = $limit;
                $pageFirstResult = ($page - 1) * $resultsPerPage;
                $countResult = count($items);

                //determine the total number of pages available
                $numberOfPage = ceil($countResult / $resultsPerPage);

                $contactItems = getDataForPegination($pageFirstResult, $resultsPerPage, $orderby);

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

            if (empty($column)) {
                $column = ["1"];
            }

            $alterHeader = array_diff($tableHeader, (array) $column);
            $lowerCaseColumn = array_map("strtolower", (array) $column);

            foreach ($contactItems as $items) {
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
