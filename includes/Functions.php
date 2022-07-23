<?php

function cm_get_contacts_by_id($items)
{
    global $wpdb;

    $id  = $items;
    $sql = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}contacts WHERE id=%s",
            $id
      )
    );
    return $sql;
}

function cm_get_all_contacts()
{
    global $wpdb;
    $column = $orderby;
    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts");
    return $sql;
}


function cm_custom_shortcode(){

    global $wpdb;
    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}settings");
    return $sql;
}


function cm_get_pegination_data($page_first_result,$results_per_page,$orderby){

    $offset = $page_first_result;
    $page = $results_per_page;
    $column = $orderby;

    global $wpdb;
    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts ORDER BY $column  LIMIT $offset,$page");
    return $sql;
}
