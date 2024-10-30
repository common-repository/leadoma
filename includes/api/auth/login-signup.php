<?php

function leadoma_login($LEADOMA_API, $data) {
  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/auth/login", $data, true);
  if ($res["status"] == 200 || $res["status"] == 201) {
    $accessToken = $res["body"]["access_token"];
    $accessToken = esc_attr(sanitize_text_field($accessToken));
    update_option("leadoma_access_token", "Bearer " . $accessToken);
  }
  return $res;
}

add_action('wp_ajax_leadoma_login', "ajax_leadoma_login");
function ajax_leadoma_login() {
  $LEADOMA_API = new LEADOMA_API();
  $req_data = leadomaSanitizeArray($_REQUEST['data']);

  // {
  //  username: <email>,
  //  password string
  // }

  $username = is_email(sanitize_email($req_data["username"]));
  $password = $req_data["password"];

  if ($password != $req_data["password"] || empty($password) || empty($username)) {
    leadomaBadRequest();
  }

  $data = array(
    "username" => $username,
    "password" => $password,
  );

  $res = leadoma_login($LEADOMA_API, $data);

  wp_send_json($res);
  wp_die();
}

function leadoma_get_user() {
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL . "/user", $data);
  return $res;
}
function leadoma_get_stats() {
  $LEADOMA_API = new LEADOMA_API();
  $data = array();
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL . "/business/stats", $data);
  return $res;
}
function leadoma_email_verification_request() {
  $LEADOMA_API = new LEADOMA_API();

  $redirectUrl = get_admin_url() . "?page=leadoma-verify";

  $data = array(
    "admin_url" => $redirectUrl,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/user/email/request/verification", $data);
  return $res;
}
add_action('wp_ajax_leadoma_email_verification_request', "ajax_leadoma_email_verification_request");
function ajax_leadoma_email_verification_request() {
  $res = leadoma_email_verification_request();
  wp_send_json($res);
  wp_die();
}

add_action('wp_ajax_leadoma_signup', "ajax_leadoma_signup");
function ajax_leadoma_signup() {
  $LEADOMA_API = new LEADOMA_API();
  delete_option("leadoma_access_token");
  $raw_data = leadomaSanitizeArray($_REQUEST['data']);

  // {
  //  full_name: string,
  //  email: <email>,
  //  password string,
  //  business_title: string
  // }

  $full_name = $raw_data["full_name"];
  $email = is_email(sanitize_email($raw_data["email"]));
  $password = $raw_data["password"];
  $business_title = get_site_url();

  if (empty($full_name) || empty($email) || empty($password) || empty($business_title)) {
    leadomaBadRequest();
  }

  $data = array(
    "full_name" => $full_name,
    "email" => $email,
    "password" => $password,
    "business_title" => $business_title,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/auth/signup", $data, $isLogin = false, $clearToken = true);
  if ($res["status"] == 200 || $res["status"] == 201) {
    $accessToken = esc_attr(sanitize_text_field($res["body"]["auth"]["access_token"]));
    $accessTokenType = esc_attr(sanitize_text_field($res["body"]["auth"]["token_type"]));
    update_option("leadoma_access_token", $accessTokenType . " " . $accessToken);
    // send verification email
    leadoma_email_verification_request();
  }
  wp_send_json($res);
  wp_die();
}

add_action('wp_ajax_leadoma_req_reset_password', "ajax_leadoma_req_reset_password");
function ajax_leadoma_req_reset_password() {
  $LEADOMA_API = new LEADOMA_API();
  $raw_data = leadomaSanitizeArray($_REQUEST['data']);

  // {
  // email: string,
  // }

  $email = is_email(sanitize_email($raw_data["email"]));
  $redirectUrl = get_admin_url() . "?page=leadoma-password-reset";

  if (empty($email)) {
    leadomaBadRequest();
  }

  $data = array(
    "email" => $email,
    "admin_url" => $redirectUrl,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/user/email/request/password-reset", $data);

  wp_send_json($res);
  wp_die();
}

function leadoma_email_verify($verification_code) {
  $LEADOMA_API = new LEADOMA_API();
  // {
  // verification_code: string,
  // }

  $verificationCode = sanitize_text_field($verification_code);

  if (empty($verificationCode)) {
    leadomaBadRequest();
  }

  $data = array(
    "verification_code" => $verificationCode,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/user/email/verify", $data);

  return $res;
}

add_action('wp_ajax_leadoma_password_change', "ajax_leadoma_password_change");
function ajax_leadoma_password_change() {
  $LEADOMA_API = new LEADOMA_API();
  $raw_data = leadomaSanitizeArray($_REQUEST['data']);

  // {
  //   "new_password": "string",
  //   "new_password": "string",
  // }

  $old_password = sanitize_text_field($raw_data["old_password"]);
  $new_password = sanitize_text_field($raw_data["new_password"]);

  if (empty($old_password) || empty($new_password)) {
    leadomaBadRequest();
  }

  $data = array(
    "new_password" => $new_password,
    "old_password" => $old_password,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/user/password/change", $data);

  wp_send_json($res);
  wp_die();
}

add_action('wp_ajax_leadoma_password_reset', "ajax_leadoma_password_reset");
function ajax_leadoma_password_reset() {
  $LEADOMA_API = new LEADOMA_API();
  $raw_data = leadomaSanitizeArray($_REQUEST['data']);

  // {
  //   "email": "user@example.com",
  //   "new_password": "string",
  //   "code": "string"
  // }

  $email = is_email(sanitize_email($raw_data["email"]));
  $new_password = sanitize_text_field($raw_data["new_password"]);
  $code = sanitize_text_field($raw_data["code"]);

  if (empty($email) || empty($new_password) || empty($code)) {
    leadomaBadRequest();
  }

  $data = array(
    "email" => $email,
    "new_password" => $new_password,
    "code" => $code,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/user/password/reset", $data);

  wp_send_json($res);
  wp_die();
}

add_action('wp_ajax_leadoma_test', "ajax_leadoma_test");
function ajax_leadoma_test() {
  $LEADOMA_API = new LEADOMA_API();
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL . "/auth/test");
  wp_send_json($res);
  wp_die();
}
add_action('wp_ajax_leadoma_ping', "ajax_leadoma_ping");
function ajax_leadoma_ping() {
  $LEADOMA_API = new LEADOMA_API();
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL . "/ping");
  wp_send_json($res);
  wp_die();
}
add_action('wp_ajax_leadoma_logout', "ajax_leadoma_logout");
function ajax_leadoma_logout() {
  delete_option("leadoma_access_token");
  wp_send_json(array(
    "status" => "200",
    "body" => "Logged out",
  ));
  wp_die();
}
add_action('wp_ajax_leadoma_cloud_notice', "ajax_leadoma_cloud_notice");
function ajax_leadoma_cloud_notice() {
  leadomaSetOption('cloud_notice', true);
  wp_send_json(array(
    "status" => "200",
    "body" => "Logged out",
  ));
  wp_die();
}