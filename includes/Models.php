<?php

namespace CM\Includes;

class Models
{
    /**
     * Insert data into contact table
     */
    public function addContactData($data)
    {
        global $wpdb;

        extract($data);
        $defaults = [
            "name" => $name,
            "photo" => $photo,
            "email" => $email,
            "mobile" => $mobile,
            "company" => $company,
            "title" => $title,
        ];
        $table_name = $wpdb->prefix . "contacts";

        $inserted = $wpdb->insert($table_name, $defaults);

        if (!$inserted) {
            return wp_send_json_error(
                [
                    "error" => __("Error while add data", "contact-manager"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully posted data", "contact-manager"),
            ],
            200
        );
    }

    /**
     * Update contact table
     */
    public function updateContactData($id, $data)
    {
        global $wpdb;
        extract($data);
        $table_name = $wpdb->prefix . "contacts";
        $where = ["id" => $id];

        $updated = $wpdb->update(
            $table_name,
            [
                "name" => $name,
                "photo" => $photo,
                "email" => $email,
                "mobile" => $mobile,
                "company" => $company,
                "title" => $title,
            ],
            $where
        );
        if (!$updated) {
            return wp_send_json_error("Error while udpating data", 500);
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully update data", "textdomain"),
            ],
            200
        );
    }

    /**
     * Fetching data for contact table
     */
    public function getAllContacts()
    {
        global $wpdb;

        $request = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts");
        if (is_wp_error($request)) {
            return false;
        }
        wp_send_json_success($request, 200);
        die();
    }

    /**
     * Get Single Data
     */
    public function fetchSingleData($id)
    {
        global $wpdb;
        $post_id = $id;

        $single_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts WHERE id = {$post_id}");

        if (is_wp_error($single_data)) {
            return false;
        }
        wp_send_json_success($single_data, 200);
        die();
    }

    /**
     * Deleting Table's row
     */
    public function deleteContact($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "contacts";
        $wpdb->delete($table_name, ["id" => $id]);
        die();
    }

    public function customizedShortcodeValue($data, $column)
    {
        extract($data);
        // $newColumn = maybe_serialize($column);
        $newColumn = $column;
        $option_data = [
            "color" => $color,
            "limit" => $limit,
            "page" => $page,
            "column" => $newColumn,
            "orderby" => $orderby,
        ];

        $updated = update_option("cm_settings_value", $option_data);

        if (!$updated) {
            return wp_send_json_error(
                [
                    "error" => __("Nothing to change", "contact-maneger"),
                ],
                500
            );
        }
        return wp_send_json_success(
            [
                "message" => __("Successfully change shortcode", "contact-maneger"),
            ],
            200
        );
    }

    public function fetchDataFromShortcode()
    {
        global $wpdb;

        $request = get_option("cm_settings_value");

        if (is_wp_error($request)) {
            return false;
        }
        wp_send_json_success($request, 200);
        die();
    }
}
