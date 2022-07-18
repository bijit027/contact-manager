<?php

namespace CM\Includes;

class AdminAjaxHandler
{

    function __construct()
    {
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
            $error = ['name' => 'Please enter name'];
            return wp_send_json_error($error, 400);
        }
        if (!empty($_POST['photo'])) {
            $photo = sanitize_text_field($_POST['photo']);
        } else {
            $error = ['photo' => 'Please enter image url'];
            return wp_send_json_error($error, 400);
        }  
        if (!empty($_POST['email'])) {
            $email = sanitize_text_field($_POST['email']);
        } else {
            $error = ['email' => 'Please enter email address'];
            return wp_send_json_error($error, 400);
        }
        if (!empty($_POST['mobile'])) {
            $mobile = sanitize_text_field($_POST['mobile']);
        } else {
            $error = ['mobile' => 'Please enter phone number'];
            return wp_send_json_error($error, 400);
        }
        if (!empty($_POST['company'])) {
            $company = sanitize_text_field($_POST['company']);
        } else {
            $error = ['company' => 'Please enter company name'];
            return wp_send_json_error($error, 400);
        }
        if (!empty($_POST['title'])) {
            $title = sanitize_text_field($_POST['title']);
        } else {
            $error = ['title' => 'Please enter title'];
            return wp_send_json_error($error, 400);
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
