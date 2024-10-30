<?php 
add_action( 'wp_ajax_leadoma_create_tag', "ajax_leadoma_create_tag");
function ajax_leadoma_create_tag(){
  $LEADOMA_API = new LEADOMA_API();
  $req_data = leadomaSanitizeArray($_REQUEST['data']);
  // {
  //   title: string,
  //   color_code: string,
  // }

  $title = $req_data["title"];
  $color_code = $req_data["color_code"];
  if(empty($title) || empty($color_code)){
    leadomaBadRequest();
  }

  $data = array(
    "title" => $title,
    "color_code" => $color_code,
  ); 

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL."/business/tag", $data);
  wp_send_json($res);
	wp_die();
}

add_action( 'wp_ajax_leadoma_edit_tag', "ajax_leadoma_edit_tag");
function ajax_leadoma_edit_tag(){
  $LEADOMA_API = new LEADOMA_API();
  $req_data = leadomaSanitizeArray($_REQUEST['data']);
  $slug = sanitize_text_field($_REQUEST['slug']);
  // {
  //   title: string,
  //   color_code: string,
  // }
  $title = $req_data["title"];
  $color_code = $req_data["color_code"];

  if(empty($title) || empty($color_code) || empty($slug)){
    leadomaBadRequest();
  }

  $data = array(
    "title" => $title,
    "color_code" => $color_code,
  ); 

  $res = $LEADOMA_API->patch(LEADOMA_BASE_URL."/business/tag/".$slug, $data);
  wp_send_json($res);
	wp_die();
}

add_action( 'wp_ajax_leadoma_delete_tag', "ajax_leadoma_delete_tag");
function ajax_leadoma_delete_tag(){
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $slug = sanitize_text_field($_REQUEST['slug']);

  if(empty($slug)){
    leadomaBadRequest();
  }

  $res = $LEADOMA_API->delete(LEADOMA_BASE_URL."/business/tag/".$slug, $data);
  wp_send_json($res);
	wp_die();
}

add_action( 'wp_ajax_leadoma_list_of_tags', "ajax_leadoma_list_of_tags");
function ajax_leadoma_list_of_tags(){
  $LEADOMA_API = new LEADOMA_API();
  $page = sanitize_text_field($_REQUEST["page"]);
  if(!$page){
    $page = 1;
  }
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL."/business/tag?page=".$page);
  wp_send_json($res);
	wp_die();
}

add_action( 'wp_ajax_leadoma_update_customer_tags', "ajax_leadoma_update_customer_tags");
function ajax_leadoma_update_customer_tags(){
  $LEADOMA_API = new LEADOMA_API();
  $req_data = leadomaSanitizeArray($_REQUEST['data']);
  $code = sanitize_text_field($_REQUEST['code']);

  // {
  //   tags: [{"slug": string}, ...]
  // }
  
  // it's ok if empty
  $data = $req_data ? $req_data : array("tags"=>[]);

  if(empty($code)){
    leadomaBadRequest();
  }

  $res = $LEADOMA_API->patch(LEADOMA_BASE_URL."/business/tag/customers/".$code, $data);
  wp_send_json($res);
	wp_die();
}


function ajax_leadoma_add_customers_tags($customers, $tags){
  $LEADOMA_API = new LEADOMA_API();

  if(empty($customers) || empty($tags)){
    leadomaBadRequest();
  }

  $payload = array(
    "customers"=>$customers,
    "tags"=>$tags,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL."/business/tag/customers/", $payload);
  wp_send_json($res);
}
