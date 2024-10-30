<?php
// setting link on plugins page
function leadoma_add_settings_link( $links ){
  $settings_link = '<a href="admin.php?page=leadoma">' . __('Settings') . '</a>';
  array_push( $links, $settings_link);
  return $links;
}
$filter_name = "plugin_action_links_" . plugin_basename( __FILE__ );
add_filter($filter_name, 'leadoma_add_settings_link');
