<?php
function leadoma_admin_scripts(){
  wp_register_script(
    "leadoma-admin",
    LEADOMA_DIR_URL . "admin/js/leadoma.js",
    ['jquery', "leadoma-constants"],
    filemtime(LEADOMA_DIR . "admin/js/leadoma.js")
  );  
  wp_register_script(
    "leadoma-tables",
    LEADOMA_DIR_URL . "admin/js/tables.js",
    ['jquery', "leadoma-constants"],
    filemtime(LEADOMA_DIR . "admin/js/tables.js")
  );  
  wp_register_script(
    "leadoma-bootstrap-bundle",
    LEADOMA_DIR_URL . "admin/js/bootstrap/bootstrap.bundle.min.js",
    ['jquery'],
    filemtime(LEADOMA_DIR . "admin/js/bootstrap/bootstrap.bundle.min.js")
  );
  wp_register_script(
    "leadoma-additional-bootstrap",
    LEADOMA_DIR_URL . "admin/js/bootstrap/additional-bootstrap.js",
    ['jquery', "leadoma-bootstrap-bundle"],
    filemtime(LEADOMA_DIR . "admin/js/bootstrap/additional-bootstrap.js")
  );
  wp_register_script(
    "leadoma-auth",
    LEADOMA_DIR_URL . "admin/js/auth/login-signup.js",
    ['jquery', "leadoma-bootstrap-bundle"],
    filemtime(LEADOMA_DIR . "admin/js/auth/login-signup.js")
  );
  wp_register_script(
    "leadoma-tags-api",
    LEADOMA_DIR_URL . "admin/js/tags/api.js",
    ['jquery', "leadoma-bootstrap-bundle"],
    filemtime(LEADOMA_DIR . "admin/js/tags/api.js")
  );
  wp_register_script(
    "leadoma-tags",
    LEADOMA_DIR_URL . "admin/js/tags/tags.js",
    ['jquery', "leadoma-bootstrap-bundle", "leadoma-tags-api", "leadoma-tables"],
    filemtime(LEADOMA_DIR . "admin/js/tags/tags.js")
  );
  wp_register_script(
    "leadoma-customers-api",
    LEADOMA_DIR_URL . "admin/js/customers/api.js",
    ['jquery', "leadoma-bootstrap-bundle"],
    filemtime(LEADOMA_DIR . "admin/js/customers/api.js")
  );
  wp_register_script(
    "leadoma-customers",
    LEADOMA_DIR_URL . "admin/js/customers/customers.js",
    ['jquery', "leadoma-bootstrap-bundle", "leadoma-customers-api", "leadoma-tables"],
    filemtime(LEADOMA_DIR . "admin/js/customers/customers.js")
  );
  wp_register_script(
    "leadoma-customer-profile",
    LEADOMA_DIR_URL . "admin/js/customers/customer-profile.js",
    ['jquery', "leadoma-bootstrap-bundle", "leadoma-customers-api", "leadoma-tags-api"],
    filemtime(LEADOMA_DIR . "admin/js/customers/customer-profile.js")
  );
  wp_register_script(
    "leadoma-customer-activities",
    LEADOMA_DIR_URL . "admin/js/customers/customer-activities.js",
    ['jquery', "leadoma-bootstrap-bundle", "leadoma-customers-api", "leadoma-tags-api"],
    filemtime(LEADOMA_DIR . "admin/js/customers/customer-activities.js")
  );
  wp_register_script(
    "leadoma-constants",
    LEADOMA_DIR_URL . "admin/js/constants.js",
    ['jquery'],
    filemtime(LEADOMA_DIR . "admin/js/constants.js")
  );

  $constLEADOMA_DIR_URL = "const LEADOMA_DIR_URL = '".  LEADOMA_DIR_URL."';";
  wp_add_inline_script( 'leadoma-constants', $constLEADOMA_DIR_URL, 'before' );
  wp_enqueue_script('jquery');
  wp_enqueue_script('leadoma-constants');
  wp_enqueue_script('leadoma-bootstrap-bundle');
  wp_enqueue_script('leadoma-additional-bootstrap');
  wp_enqueue_script('leadoma-admin');

}
add_action('admin_enqueue_scripts', 'leadoma_admin_scripts', 100);