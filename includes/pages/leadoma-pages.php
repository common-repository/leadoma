<?php

function leadoma_settings_page(){
  $IS_LOGEDIN = get_option("leadoma_access_token") ? true : false;
  add_menu_page(
    __('Leadoma', 'leadoma'), //Plugin Name
    __('Leadoma', 'leadoma'), //Plugin Menu
    'manage_options',
    'leadoma', //page name
    'leadoma_settings_page_markup', //callback function
    plugin_dir_url( __FILE__ ). 'icon.png', // icon
    100
  );

  if(!$IS_LOGEDIN){
    add_submenu_page(
      'leadoma', //parent page name
      __('Login', 'leadoma'),
      __('Login', 'leadoma'),
      'manage_options',
      'leadoma-login', // slug
      'leadoma_settings_login', //callback function
      100
    );
  }else{
    add_submenu_page(
      'leadoma', //parent page name
      __('Customers', 'leadoma'),
      __('Customers', 'leadoma'),
      'manage_options',
      'leadoma-customers', // slug
      'leadoma_settings_customers', //callback function
      100
    );
  
    add_submenu_page(
      null, //parent page name
      __("Customer's Profile", 'leadoma'),
      __("Customer's Profile", 'leadoma'),
      'manage_options',
      'leadoma-customer-profile', // slug
      'leadoma_settings_customer_profile', //callback function
      100
    );
    add_submenu_page(
      null, //parent page name
      __("Customer's Activities", 'leadoma'),
      __("Customer's Activities", 'leadoma'),
      'manage_options',
      'leadoma-customer-activities', // slug
      'leadoma_settings_customer_activities', //callback function
      100
    );
    add_submenu_page(
      null, //parent page name
      __("Verify Email", 'leadoma'),
      __("Verify Email", 'leadoma'),
      'manage_options',
      'leadoma-verify', // slug
      'leadoma_settings_verify', //callback function
      100
    );
  
    add_submenu_page(
      'leadoma', //parent page name
      __('Tags', 'leadoma'),
      __('Tags', 'leadoma'),
      'manage_options',
      'leadoma-tags', // slug
      'leadoma_settings_tags', //callback function
      100
    );
  }


}
add_action( 'admin_menu', 'leadoma_settings_page');

function leadoma_settings_page_markup(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>

  <?php include(LEADOMA_DIR.'includes/pages/admin/dashboard.php') ?>

  <?php
  wp_enqueue_style('leadoma-disable-admin-notices');

}

function leadoma_settings_login(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>
  <?php 
    include(LEADOMA_DIR.'includes/pages/auth/auth.php') 
  ?>

  <?php
}
function leadoma_settings_customers(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>
  <?php include(LEADOMA_DIR.'includes/pages/customers/customers.php') ?>

  <?php
}
function leadoma_settings_customer_profile(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>
  <?php include(LEADOMA_DIR.'includes/pages/customers/customer-profile.php') ?>

  <?php
}

function leadoma_settings_customer_activities(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>
  <?php include(LEADOMA_DIR.'includes/pages/customers/customer-activities.php') ?>

  <?php
}

function leadoma_settings_verify(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>
  <?php include(LEADOMA_DIR.'includes/pages/admin/verify-email.php') ?>

  <?php
}

function leadoma_settings_tags(){
  
  if( !current_user_can('manage_options') ){
    return;
  }
  ?>
  <?php include(LEADOMA_DIR.'includes/pages/tags/tags.php') ?>

  <?php
}