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
    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts");
    return $sql;
}
