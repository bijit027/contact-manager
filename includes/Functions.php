<?php

function getContactsById($items)
{
    global $wpdb;

    $id = $items;
    $sql = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}contacts WHERE id=%s", $id)
    );
    return $sql;
}

function GetAllContacts()
{
    global $wpdb;

    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts");
    return $sql;
}

function getPeginationData($page_first_result, $results_per_page, $orderby)
{
    $offset = $page_first_result;
    $page = $results_per_page;
    $orderby_value = strtolower($orderby);

    global $wpdb;
    $sql = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}contacts ORDER BY  $orderby_value  LIMIT $offset,$page"
    );
    return $sql;
}
