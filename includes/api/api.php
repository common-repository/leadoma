<?php 

class LEADOMA_API{
  public $headers = array(
    'Content-Type'=> 'application/json',
    "authorization" => "Bearer "
  );
  
  // none async APIs
  function get($url, $payload=array()){
    $this->headers["authorization"] = get_option("leadoma_access_token");
    $response = wp_remote_get( 
      esc_url_raw($url),
      array(
        'body'    => $payload,
        'headers' => $this->headers,
        'timeout' => 20
      )
    );

    if( is_wp_error( $response ) ) {
      $error_message = $response->get_error_message();
      $response_code = wp_remote_retrieve_response_code( $response );
      $response_code = $response_code ? $response_code : 500;
      $errors = array(
        'status' => $response_code,
        'body' => $error_message
      );
    }
    $response_code = wp_remote_retrieve_response_code( $response );
    $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
    return array('status'=>$response_code, 'body'=>$response_body);
  }

  function post($url, $payload=array(), $isLogin=false, $clearToken=false){
    $this->headers["authorization"] = get_option("leadoma_access_token");
    if($clearToken){
      unset($this->headers["authorization"]);
    }
    $requestArray = array(
      'body'    => wp_json_encode($payload),
      'headers' => $this->headers,
      'timeout' => 20
    );
    if($isLogin){
      $requestArray = array(
        'body'    => $payload,
        'headers' => array('Content-Type'=> 'application/x-www-form-urlencoded'),
        'timeout' => 20
      );
    }
    $response = wp_remote_post( 
      esc_url_raw($url),
      $requestArray
    );

    if( is_wp_error( $response ) ) {
      $error_message = $response->get_error_message();
      $response_code = wp_remote_retrieve_response_code( $response );
      $response_code = $response_code ? $response_code : 500;
      $errors = array(
        'status' => $response_code,
        'body' => $error_message,
      );
      return $errors;
    }

    $response_code = wp_remote_retrieve_response_code( $response );
    $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
    return array('status'=>$response_code, 'body'=>$response_body);
  }

  function delete($url, $payload=array()){
    $this->headers["authorization"] = get_option("leadoma_access_token");
    $requestArray = array(
      'method'  => "DELETE",
      'body'    => wp_json_encode($payload),
      'headers' => $this->headers,
      'timeout' => 20
    );

    $response = wp_remote_post( 
      esc_url_raw($url),
      $requestArray
    );

    if( is_wp_error( $response ) ) {
      $error_message = $response->get_error_message();
      $response_code = wp_remote_retrieve_response_code( $response );
      $response_code = $response_code ? $response_code : 500;
      $errors = array(
        'status' => $response_code,
        'body' => $error_message
      );
    }

    $response_code = wp_remote_retrieve_response_code( $response );
    $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
    return array('status'=>$response_code, 'body'=>$response_body);
  }

  function patch($url, $payload=array()){
    $this->headers["authorization"] = get_option("leadoma_access_token");
    $requestArray = array(
      'method'  => "PATCH",
      'body'    => wp_json_encode($payload),
      'headers' => $this->headers,
      'timeout' => 20
    );

    $response = wp_remote_post( 
      esc_url_raw($url),
      $requestArray
    );

    if( is_wp_error( $response ) ) {
      $error_message = $response->get_error_message();
      $response_code = wp_remote_retrieve_response_code( $response );
      $response_code = $response_code ? $response_code : 500;
      $errors = array(
        'status' => $response_code,
        'body' => $error_message
      );
      return $errors;
    }

    $response_code = wp_remote_retrieve_response_code( $response );
    $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
    return array('status'=>$response_code, 'body'=>$response_body);
  }

}

function leadomaBadRequest($body="Bad Request"){
  wp_send_json( 
    array(
      'status' => 400,
      'body' => $body,
    )
  );
  wp_die();
}

include(LEADOMA_DIR.'includes/api/auth/login-signup.php');
include(LEADOMA_DIR.'includes/api/auth/tags.php');
include(LEADOMA_DIR.'includes/api/auth/customers.php');
