<?php

namespace CM\Includes;


class Models
{

  function __construct()
  {
    // add_action('wp_ajax_cm_insert_contact_table', [$this, 'cm_insert_contact_table']);
    // add_action('wp_ajax_cm_get_contacts', [$this, 'cm_get_contacts']);
    // add_action('wp_ajax_cm_get_contact_lists', [$this, 'cm_get_contact_lists']);
    //add_action('wp_ajax_cm_get_single_data', [$this, 'cm_get_single_data']);
    // add_action('wp_ajax_cm_delete_contact', [$this, 'cm_delete_contact']);
  }


  public static function add_contact_table($name,$photo, $email, $mobile, $company, $title)
  {


    global $wpdb;

    $defaults = [

      'name'    => $name,
      'photo'   => $photo,
      'email'   => $email,
      'mobile'  => $mobile,
      'company' => $company,
      'title'   => $title,

    ];
  
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

  public static function update_contact_table($id,$name,$photo, $email, $mobile, $company, $title){
    global $wpdb;
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
    if ( !$updated ) {
      return wp_send_json_error( "Error while udpating data", 500 );
    }
    return wp_send_json_success( [
      'message' => __( "Successfully update data", "textdomain" )
    ], 200 );

  }


  /**
   * Fetching data for contact table
   */
  public static function get_all_contacts()
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
  public static function fetch_single_data($id)
  {
    global $wpdb;
    $post_id = $id;

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
  public static function delete_contact($id)
  {


    global $wpdb;
    
    $table_name = $wpdb->prefix . 'contacts';

    $wpdb->delete($table_name, array('id' => $id));
    die();
  }
}
