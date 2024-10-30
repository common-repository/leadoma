<?php 

// add_action( 'wp_ajax_leadoma_create_customer', "ajax_leadoma_create_customer");
// function ajax_leadoma_create_customer(){
//   $LEADOMA_API = new LEADOMA_API();
//   $data = leadomaSanitizeArray($_REQUEST['data']);
//   $res = $LEADOMA_API->post(LEADOMA_BASE_URL."/business/customer", $data);
//   print_r(json_encode($res));
// 	wp_die();
// }

add_action( 'wp_ajax_leadoma_update_customer', "ajax_leadoma_update_customer");
function ajax_leadoma_update_customer(){
  $LEADOMA_API = new LEADOMA_API();
  $data = leadomaSanitizeArray($_REQUEST['data']);
  $code = sanitize_text_field($_REQUEST['code']);
  if(empty($code)){
    leadomaBadRequest();
  }
  $res = $LEADOMA_API->patch(LEADOMA_BASE_URL."/business/customer/".$code, $data);
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_update_customer_additional', "ajax_leadoma_update_customer_additional");
function ajax_leadoma_update_customer_additional(){
  $LEADOMA_API = new LEADOMA_API();
  $data = leadomaSanitizeArray($_REQUEST['data']);
  $code = sanitize_text_field($_REQUEST['code']);
  if(empty($code)){
    leadomaBadRequest();
  }
  //! api has typo
  $res = $LEADOMA_API->patch(LEADOMA_BASE_URL."/business/customer/".$code."/additonal-info", $data);
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_delete_customer', "ajax_leadoma_delete_customer");
function ajax_leadoma_delete_customer(){
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $code = sanitize_text_field($_REQUEST['code']);
  if(empty($code)){
    leadomaBadRequest();
  }
  $res = $LEADOMA_API->delete(LEADOMA_BASE_URL."/business/customer/".$code, $data);
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_get_customer', "ajax_leadoma_get_customer");
function ajax_leadoma_get_customer(){
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $code = sanitize_text_field($_REQUEST['code']);
  if(empty($code)){
    leadomaBadRequest();
  }
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL."/business/customer/".$code, $data);
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_get_customer_activities', "ajax_leadoma_get_customer_activities");
function ajax_leadoma_get_customer_activities(){
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $code = sanitize_text_field($_REQUEST['code']);
  if(empty($code)){
    leadomaBadRequest();
  }
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL."/business/customer/".$code."/activities", $data);
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_get_customer_notes', "ajax_leadoma_get_customer_notes");
function ajax_leadoma_get_customer_notes(){
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $code = sanitize_text_field($_REQUEST['code']);
  if(empty($code)){
    leadomaBadRequest();
  }
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL."/business/customer/".$code."/notes", $data);
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_add_customer_note', "ajax_leadoma_add_customer_note");
function ajax_leadoma_add_customer_note(){
  $LEADOMA_API = new LEADOMA_API();
  $text = sanitize_text_field($_REQUEST['text']);
  $code = sanitize_text_field($_REQUEST['code']);
  $res = $LEADOMA_API->post(LEADOMA_BASE_URL."/business/customer/".$code."/notes/?text=".$text, array());
  wp_send_json($res);
	wp_die();
}
add_action( 'wp_ajax_leadoma_list_of_customers', "ajax_leadoma_list_of_customers");
function ajax_leadoma_list_of_customers(){
  $LEADOMA_API = new LEADOMA_API();
  $page = sanitize_text_field($_REQUEST["page"]);
  if(!$page){
    $page = 1;
  }
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL."/business/customer?page=".$page);
  wp_send_json($res);
	wp_die();
}

add_action( 'wp_ajax_leadoma_sync_unsynced_customer', "ajax_leadoma_sync_unsynced_customer");
function ajax_leadoma_sync_unsynced_customer(){
  $LEADOMA_API = new LEADOMA_API();

  $username = getCurrentUserEmail();

  // abort if have syncing in progress
  $res = array('status'=>409, 'body'=>array());

  if(!leadomaIsSyncingInProcess()){
    //get unsynced users list
    $usersRes = leadomaGetUnsyncedUsers();
    $usersIds = $usersRes["ids"];
    $users = $usersRes["users"];
    
    $data = leadomaSanitizeArray($users);
    
    //send request
    $res = $LEADOMA_API->post(LEADOMA_BASE_URL."/business/customer/batch", $data);
    if($res["status"]==200 || $res["status"]==201){
      $req_slug = $res["body"]["slug"];
      leadomaUpdateSyncOption($req_slug, $usersIds, $username);
    }
  }
  wp_send_json($res);
	wp_die();
}

function leadomaHandlePageLoadSyncChecking(){
  $LEADOMA_API = new LEADOMA_API();
  $syncId = leadomaIsSyncingInProcess();
  if(!$syncId){
    return true;
  }else{
    // request to see if syncing completed
    $res = $LEADOMA_API->get(LEADOMA_BASE_URL."/business/customer/batch/".$syncId, array());
    if($res["status"]==200 || $res["status"]==201){
      // what if sync faild or something
      if($res["body"]["status"]=="imported"){
        $customerIds = $res["body"]["import_results"]["customers"];
        leadomaUpdateSyncedUsers($syncId, getCurrentUserEmail(), $customerIds);
        return true;
      }
    }
    return false;
  }
}