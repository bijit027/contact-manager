<?php

namespace CM\Includes;

class AdminAjaxHandler
{
  public $prefix = 'cm';

  function __construct()
  {
      // add_action('wp_ajax_cm_insert_contact_table', [$this, 'cm_insert_contact_table']);
      // add_action('wp_ajax_cm_get_contact_lists', [$this, 'cm_get_contact_lists']);
      // add_action('wp_ajax_cm_get_single_data', [$this, 'cm_get_single_data']);
      // add_action('wp_ajax_cm_delete_contact', [$this, 'cm_delete_contact']);

      

    foreach ($this->get_actions() as $action => $handler) {
      add_action("wp_ajax_{$action}", $handler['function']);
    }
  }

  function get_actions()
  {
    return [
      'cm_insert_contact_table' => ['function' => [$this, 'cm_insert_contact_table']],
      'cm_get_contact_lists' => ['function' => [$this, 'cm_get_contact_lists']],
      'cm_get_single_data' => ['function' => [$this, 'cm_get_single_data']],
      'cm_delete_contact' => ['function' => [$this, 'cm_delete_contact']],
    ];
  }





  public function cm_insert_contact_table()
  {
        
     if (!wp_verify_nonce($_POST['wpsfb_nonce'], 'wpsfb_ajax_nonce')) {
        return wp_send_json_error('Busted! Please login!', 400);
      }
  
  
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

   
      
      if (isset($_POST['id'])) {
        $id = $_POST['id'];     
          Models::update_contact_table($id,$name,$photo, $email, $mobile, $company, $title);
      }else{
            Models::add_contact_table($name,$photo, $email, $mobile, $company, $title);
      }

    }

    public function cm_get_contact_lists(){
            Models::get_all_contacts();
    }

    public function cm_get_single_data(){
        $id  = $_GET['id'];
        Models::fetch_single_data($id);    
    }

    public function cm_delete_contact(){

    if (!wp_verify_nonce($_POST['wpsfb_nonce'], 'wpsfb_ajax_nonce')) {
        return wp_send_json_error('Busted! Please login!', 400);
      }
        $id  = $_POST['id'];
            Models::delete_contact($id);
    }

  
}
