<?php

namespace CM\Includes;


class Models
{

  function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'cm_admin_scripts']);
    add_action('wp_ajax_cm_insert_contact_table', [$this, 'cm_insert_contact_table']);
    add_action('wp_ajax_cm_get_contacts', [$this, 'cm_get_contacts']);
    add_action('wp_ajax_cm_get_contact_lists', [$this, 'cm_get_contact_lists']);
    add_action('wp_ajax_cm_get_single_data', [$this, 'cm_get_single_data']);
    add_action('wp_ajax_cm_delete_contact', [$this, 'cm_delete_contact']);
  }

  public function cm_admin_scripts()
  {
    wp_localize_script('cm', 'ajax_url', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'wpsfb_nonce' => wp_create_nonce('wpsfb_ajax_nonce')
    ));
  }

  public function cm_insert_contact_table()
  {
    if (!wp_verify_nonce($_POST['wpsfb_nonce'], 'wpsfb_ajax_nonce')) {
      return wp_send_json_error('Busted! Please login!', 400);
    }

    global $wpdb;

    if (!empty($_POST['name'])) {
      $name = sanitize_text_field($_POST['name']);
    } else {
      return wp_send_json_error("please enter name", 400);
    }

    if (!empty($_POST['photo'])) {
      $photo = sanitize_text_field($_POST['photo']);
    } else {
      return wp_send_json_error("please enter img url", 400);
    }

    if (!empty($_POST['email'])) {
      $email = sanitize_text_field($_POST['email']);
    } else {
      return wp_send_json_error("please enter email", 400);
    }
    if (!empty($_POST['mobile'])) {
      $mobile = sanitize_text_field($_POST['mobile']);
    } else {
      return wp_send_json_error("please enter mobile", 400);
    }
    if (!empty($_POST['company'])) {
      $company = sanitize_text_field($_POST['company']);
    } else {
      return wp_send_json_error("please enter company", 400);
    }
    if (!empty($_POST['title'])) {
      $title = sanitize_text_field($_POST['title']);
    } else {
      return wp_send_json_error("please enter title", 400);
    }



    $defaults = [

      'name'    => $name,
      'photo'   => $photo,
      'email'   => $email,
      'mobile'  => $mobile,
      'company' => $company,
      'title'   => $title,

    ];

    if (isset($_POST['id'])) {

      $id = $_POST['id'];
      $table_name   = $wpdb->prefix .  'contacts';
      $where        = ['id' => $id];

      $updated      =  $wpdb->update(
        $table_name,
        array(
          'name'        => $name,
          'photo'       => $photo,
          'email'       => $email,
          'mobile'      => $mobile,
          'company'     => $company,
          'title'       => $title,
        ),
        $where
      );

      return wp_send_json_success([
        'message' => __("Successfully update data", "contact-manager")
      ], 200);
      die();
    }

    else {
      $table_name = $wpdb->prefix . 'contacts';

      $inserted = $wpdb->insert(
        $table_name,
        $defaults
      );

      if (!$inserted) {
        return wp_send_json_error("Error while posting data", 500);
      }
      return wp_send_json_success([
        'message' => __("Successfully posted data", "contact-manager")
      ], 200);
    }
  }


  /**
   * Fetching data for contact table
   */
  public function cm_get_contact_lists()
  {
    global $wpdb;

    $request = $wpdb->get_results(
      "SELECT * FROM {$wpdb->prefix}contacts"
    );
    if (is_wp_error($request)) {
      return false;
    }
    wp_send_json_success($request, 200);

    die();
  }

  // Get Single Data
  public function cm_get_single_data()
  {
    global $wpdb;
    $post_id = (isset($_GET['id']) ? $_GET['id'] : '');

    $single_data = $wpdb->get_results(
      "SELECT * FROM {$wpdb->prefix}contacts WHERE id = {$post_id}"
    );

    if (is_wp_error($single_data)) {
      return false;
    }
    wp_send_json_success($single_data, 200);
    die();
  }



  /**
   * Deleting Table's row
   */
  public function cm_delete_contact()
  {

    if (!wp_verify_nonce($_POST['wpsfb_nonce'], 'wpsfb_ajax_nonce')) {
      return wp_send_json_error('Busted! Please login!', 400);
    }

    global $wpdb;

    $table_name = $wpdb->prefix . 'contacts';
    $id         = isset($_POST['id']) ? $_POST['id'] : '';

    $wpdb->delete($table_name, array('id' => $id));
    die();
  }
}
