<?php

namespace CM\Includes;

class AdminAjaxHandler extends Models
{
    function __construct()
    {
        foreach ($this->getActions() as $action => $handler) {
            add_action("wp_ajax_{$action}", $handler["function"]);
        }
    }

    function getActions()
    {
        return [
            "cm_insert_into_contact_table" => [
                "function" => [$this, "insertIntoContactTable"],
            ],
            "cm_get_contact_lists" => [
                "function" => [$this, "getContactLists"],
            ],
            "cm_get_single_data" => ["function" => [$this, "getSingleData"]],
            "cm_delete_contact" => ["function" => [$this, "deleteContactData"]],
            "cm_insert_into_shortcode_settings" => [
                "function" => [$this, "insertIntoShortcodeSettings"],
            ],
            "cm_get_shortcode_value" => [
                "function" => [$this, "getShortcodeValue"],
            ],
        ];
    }

    public function insertIntoContactTable()
    {
        if (!wp_verify_nonce($_POST["wpsfb_nonce"], "wpsfb_ajax_nonce")) {
            return wp_send_json_error("Busted! Please login!", 400);
        }

        $value = ["name", "photo", "email", "mobile", "company", "title"];
        $field_keys = $this->handleEmptyField($value);
        $data = $this->senitizeInputValue($field_keys);

        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            parent::updateContactData($id, $data);
        } else {
            parent::addContactData($data);
        }
    }

    public function getContactLists()
    {
        parent::getAllContacts();
    }

    public function getSingleData()
    {
        $id = $_GET["id"];
        parent::fetchSingleData($id);
    }

    public function deleteContactData()
    {
        if (!wp_verify_nonce($_POST["wpsfb_nonce"], "wpsfb_ajax_nonce")) {
            return wp_send_json_error("Busted! Please login!", 400);
        }
        $id = $_POST["id"];
        parent::deleteContact($id);
    }

    public function insertIntoShortcodeSettings()
    {
        $value = ["id", "color", "limit", "page", "orderby"];
        $column = $_POST["column"];
        $field_keys = $this->handleEmptyField($value);
        $data = $this->senitizeInputValue($field_keys);
        parent::updateShortcodeSettings($data, $column);
    }

    public function getShortcodeValue()
    {
        parent::fetchDataFromShortcodeSettings();
    }

    public function senitizeInputValue($field_keys)
    {
        $inputValue = $field_keys;

        $data = [];

        foreach ($inputValue as $field_key) {
            $data[$field_key] = sanitize_text_field($_POST[$field_key]);
        }
        return $data;
    }

    public function handleEmptyField($value)
    {
        $inputValue = $value;
        $errors = [];
        foreach ($inputValue as $field_key) {
            if (empty($_POST[$field_key])) {
                $errors[$field_key] = "Please enter " . $field_key;
            }
        }
        if (!empty($errors)) {
            return wp_send_json_error($errors, 400);
        }

        return $inputValue;
    }
}
