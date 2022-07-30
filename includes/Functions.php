<?php

function cm_get_contacts_by_id($items)
{
  global $wpdb;

  $id = $items;
  $sql = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}contacts WHERE id=%s", $id)
  );
  return $sql;
}

function cm_get_all_contacts()
{
  global $wpdb;

  $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contacts");
  return $sql;
}

function cm_get_shortcode_settings_value()
{
  global $wpdb;
  $sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}settings");
  return $sql;
}

function cm_get_pegination_data($page_first_result, $results_per_page, $orderby)
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
