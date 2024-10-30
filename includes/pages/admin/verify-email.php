<?php 

if(isset($_GET["code"])){
  $code = sanitize_text_field($_GET["code"]);
  $res = leadoma_email_verify($code);
  $detail = "";
  if(is_array($res["body"])){
    if(array_key_exists("detail",$res["body"])){
      $detail = $res["body"]["detail"];
    }
  }
  
  $redirectUrl = get_admin_url()."admin.php?page=leadoma&status=".$res["status"]."&detail=".$detail;
  if (headers_sent()) {
    die("<h5 class='mt-3'>Redirect failed. Please click on this link: <a href='".esc_html($redirectUrl)."'>redirect</a></h5>");
  } else{
    wp_redirect($redirectUrl);
  }
  
}else{
  $redirectUrl = get_admin_url()."admin.php?page=leadoma&status=400";
  if (headers_sent()) {
    die("<h5 class='mt-3'>Redirect failed. Please click on this link: <a href='".esc_html($redirectUrl)."'>redirect</a></h5>");
  } else{
    wp_redirect($redirectUrl);
  }
}