<?php

namespace CM\Includes;

class AdminAjaxHandler extends Models
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
            'cm_insert_contact_table'   => ['function' => [$this, 'cm_insert_contact_table']],
            'cm_get_contact_lists'      => ['function' => [$this, 'cm_get_contact_lists']],
            'cm_get_single_data'        => ['function' => [$this, 'cm_get_single_data']],
            'cm_delete_contact'         => ['function' => [$this, 'cm_delete_contact']],  
            'cm_insert_shortcode_table' => ['function' => [$this, 'cm_insert_shortcode_table']],
            'cm_get_shortcode_value'    => ['function' => [$this, 'cm_get_shortcode_value']],        
        ];
    }

    public function cm_insert_contact_table()
    {
        if (!wp_verify_nonce($_POST['wpsfb_nonce'], 'wpsfb_ajax_nonce')) {
            return wp_send_json_error('Busted! Please login!', 400);
        }

        $field_keys = [
            'name',
            'photo',
            'email',
            'mobile',
            'company',
            'title',

        ];
        
        $data = [];
        $errors = [];
        foreach($field_keys as $field_key){
            if (!empty($_POST[$field_key])) {
                $data[$field_key] = sanitize_text_field($_POST[$field_key]);
                   
            }else {
                $errors[$field_key] = 'Please enter '.$field_key;     
            }           
        }
        if (!empty($errors)){
            return wp_send_json_error($errors, 400);      
        }

        if (isset($_POST['id'])) {
            $id = $_POST['id'];     
            parent::update_contact_table($id,$data);
        }else{
            parent::add_contact_table($data);
        }

    }

    public function cm_get_contact_lists(){
        parent::get_all_contacts();
    }

    public function cm_get_single_data(){
        $id  = $_GET['id'];
        parent::fetch_single_data($id);    
    }

    public function cm_delete_contact(){
        if (!wp_verify_nonce($_POST['wpsfb_nonce'], 'wpsfb_ajax_nonce')) {
            return wp_send_json_error('Busted! Please login!', 400);
        }
            $id  = $_POST['id'];
            parent::delete_contact($id);
    }
    public function cm_insert_shortcode_table(){

        // $field_keys = [
        //     'id',
        //     'color',
        //     'limit',
        //     'page',
        //     'column',
        //     'orderby',

        // ];
        // $data = [];
        // $errors = [];
        // foreach($field_keys as $field_key){
        //     if (!empty($_POST[$field_key])) {
        //         $data[$field_key] = sanitize_text_field($_POST[$field_key]);
                   
        //     }else {
        //         $errors[$field_key] = 'Please enter '.$field_key;     
        //     }           
        // }
        // if (!empty($errors)){
        //     return wp_send_json_error($errors, 400);      
        // }

        // var_dump($data->column);

        $data =  array(
            'id'        => $_POST['id'],
            'color'     => $_POST['color'],
            'limit'     => $_POST['limit'],
            'page'      => $_POST['page'],
            'column'    => $_POST['column'],
            'orderby'   => $_POST['orderby'],
        );
        extract($data);
        // var_dump($column);
        // parent::custom_shortcode($id,$color,$limit,$page,$column,$orderby);
        parent::custom_shortcode($data);

    }  
    public function cm_get_shortcode_value(){
        parent::get_shortcode_value();
    }
}