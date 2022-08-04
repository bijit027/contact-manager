<?php

function getContactsById($items)
{
    global $wpdb;

    $id = $items;
    $sql = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}contacts WHERE id=%s", $id));
    return $sql;
}

function getAllContacts()
{
    global $wpdb;

    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts");
    return $sql;
}

function getDataForPegination($pageFirstResult, $resultsPerPage, $orderby)
{
    $offset = $pageFirstResult;
    $page = $resultsPerPage;
    $orderbyValue = strtolower($orderby);

    global $wpdb;

    $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts ORDER BY  $orderbyValue  LIMIT $offset,$page");
    return $sql;
}
