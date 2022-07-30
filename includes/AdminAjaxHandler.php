<?php

namespace CM\Includes;

class AdminAjaxHandler extends Models
{
  function __construct()
  {
    foreach ($this->get_actions() as $action => $handler) {
      add_action("wp_ajax_{$action}", $handler["function"]);
    }
  }

  function get_actions()
  {
    return [
      "cm_insert_into_contact_table" => [
        "function" => [$this, "insert_into_contact_table"],
      ],
      "cm_get_contact_lists" => ["function" => [$this, "get_contact_lists"]],
      "cm_get_single_data" => ["function" => [$this, "get_single_data"]],
      "cm_delete_contact" => ["function" => [$this, "delete_contact_data"]],
      "cm_insert_into_shortcode_table" => [
        "function" => [$this, "insert_into_shortcode_table"],
      ],
      "cm_get_shortcode_value" => [
        "function" => [$this, "get_shortcode_value"],
      ],
    ];
  }

  public function insert_into_contact_table()
  {
    if (!wp_verify_nonce($_POST["wpsfb_nonce"], "wpsfb_ajax_nonce")) {
      return wp_send_json_error("Busted! Please login!", 400);
    }

    $value = ["name", "photo", "email", "mobile", "company", "title"];

    $field_keys = $this->handle_empty_field($value);

    $data = $this->senitize_input_value($field_keys);

    if (isset($_POST["id"])) {
      $id = $_POST["id"];
      parent::update_contact_data($id, $data);
    } else {
      parent::add_contact_data($data);
    }
  }

  public function get_contact_lists()
  {
    parent::get_all_contacts();
  }

  public function get_single_data()
  {
    $id = $_GET["id"];
    parent::fetch_single_data($id);
  }

  public function delete_contact_data()
  {
    if (!wp_verify_nonce($_POST["wpsfb_nonce"], "wpsfb_ajax_nonce")) {
      return wp_send_json_error("Busted! Please login!", 400);
    }
    $id = $_POST["id"];
    parent::delete_contact($id);
  }
  public function insert_into_shortcode_table()
  {
    $value = ["id", "color", "limit", "page", "orderby"];

    $column = $_POST["column"];

    $field_keys = $this->handle_empty_field($value);

    $data = $this->senitize_input_value($field_keys);

    parent::customized_shortcode_value($data, $column);
  }
  public function get_shortcode_value()
  {
    parent::get_shortcode_value();
  }

  public function senitize_input_value($field_keys)
  {
    $inputValue = $field_keys;

    $data = [];

    foreach ($inputValue as $field_key) {
      $data[$field_key] = sanitize_text_field($_POST[$field_key]);
    }
    return $data;
  }
  public function handle_empty_field($value)
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
