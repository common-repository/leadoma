<?php
// L:162 passing variables to js
function leadoma_admin_styles($hook){

  wp_register_style(
    "leadoma-admin",
    LEADOMA_DIR_URL . "admin/css/leadoma-admin-styles.css",
    [],
    filemtime(LEADOMA_DIR . "admin/css/leadoma-admin-styles.css")
  );  
  wp_register_style(
    "leadoma-disable-admin-notices",
    LEADOMA_DIR_URL . "admin/css/disable-admin-notices.css",
    [],
    filemtime(LEADOMA_DIR . "admin/css/disable-admin-notices.css")
  );  
  wp_register_style(
    "leadoma-bootstrap",
    LEADOMA_DIR_URL . "admin/css/bootstrap/bootstrap.min.css",
    [],
    filemtime(LEADOMA_DIR . "admin/css/bootstrap/bootstrap.min.css")
  );  
  wp_register_style(
    "leadoma-bootstrap-icons",
    LEADOMA_DIR_URL . "admin/css/bootstrap/icons/bootstrap-icons.css",
    ["leadoma-bootstrap"],
    filemtime(LEADOMA_DIR . "admin/css/bootstrap/icons/bootstrap-icons.css")
  );  
  wp_register_style(
    "leadoma-bootstrap-additional",
    LEADOMA_DIR_URL . "admin/css/bootstrap/bootstrap-additional.css",
    ["leadoma-bootstrap"],
    filemtime(LEADOMA_DIR . "admin/css/bootstrap/bootstrap-additional.css")
  );  
  wp_register_style(
    "leadoma-bootstrap-override",
    LEADOMA_DIR_URL . "admin/css/bootstrap/bootstrap-override.css",
    ["leadoma-bootstrap","leadoma-bootstrap-icons"],
    filemtime(LEADOMA_DIR . "admin/css/bootstrap/bootstrap-override.css")
  );  
  wp_register_style(
    "leadoma-auth",
    LEADOMA_DIR_URL . "admin/css/auth/auth.css",
    ["leadoma-bootstrap-override"],
    filemtime(LEADOMA_DIR . "admin/css/auth/auth.css")
  );  
  wp_register_style(
    "leadoma-table",
    LEADOMA_DIR_URL . "admin/css/table/table.css",
    ["leadoma-bootstrap-override"],
    filemtime(LEADOMA_DIR . "admin/css/table/table.css")
  );  
  wp_register_style(
    "leadoma-customer-profile",
    LEADOMA_DIR_URL . "admin/css/customers/customer-profile.css",
    ["leadoma-bootstrap-override"],
    filemtime(LEADOMA_DIR . "admin/css/customers/customer-profile.css")
  );  

  wp_enqueue_style('leadoma-bootstrap');
  wp_enqueue_style('leadoma-bootstrap-additional');
  wp_enqueue_style('leadoma-bootstrap-icons');
  wp_enqueue_style('leadoma-bootstrap-override');
  wp_enqueue_style('leadoma-admin');
}
add_action('admin_enqueue_scripts', 'leadoma_admin_styles');