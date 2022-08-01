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
        $tableName = $wpdb->prefix . "contacts";
        $where = ["id" => $id];

        $updated = $wpdb->update(
            $tableName,
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

        $singleData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts WHERE id = {$post_id}");

        if (is_wp_error($singleData)) {
            return false;
        }
        wp_send_json_success($singleData, 200);
        die();
    }

    /**
     * Deleting Table's row
     */
    public function deleteContact($id)
    {
        global $wpdb;
        $tableName = $wpdb->prefix . "contacts";
        $wpdb->delete($tableName, ["id" => $id]);
        die();
    }

    public function customizedShortcodeValue($data, $column)
    {
        extract($data);
        $newColumn = $column;
        $optionData = [
            "color" => $color,
            "limit" => $limit,
            "page" => $page,
            "column" => $newColumn,
            "orderby" => $orderby,
        ];
        $request = get_option("cm_settings_value");

        if ($optionData !== $request) {
            $updated = update_option("cm_settings_value", $optionData);

            if (!$updated) {
                return wp_send_json_error(
                    [
                        "error" => __("Error while updating data", "contact-manager"),
                    ],
                    500
                );
            }
            return wp_send_json_success(
                [
                    "message" => __("Successfully change shortcode", "contact-manager"),
                ],
                200
            );
        } else {
            return wp_send_json_error(
                [
                    "error" => __("Nothing to change", "contact-manager"),
                ],
                500
            );
        }
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
