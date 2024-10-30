<?php

// this is the wp-background-processing (https://github.com/deliciousbrains/wp-background-processing/blob/master/classes/wp-async-request.php) that used in WooCommerce too
// and we are checking if it's declared before.
// I didn't changed it. 
if ( ! class_exists( 'WP_Async_Request' ) ) {

	/**
	 * Abstract WP_Async_Request class.
	 *
	 * @abstract
	 */
	abstract class WP_Async_Request {

		/**
		 * Prefix
		 *
		 * (default value: 'wp')
		 *
		 * @var string
		 * @access protected
		 */
		protected $prefix = 'wp';

		/**
		 * Action
		 *
		 * (default value: 'async_request')
		 *
		 * @var string
		 * @access protected
		 */
		protected $action = 'async_request';

		/**
		 * Identifier
		 *
		 * @var mixed
		 * @access protected
		 */
		protected $identifier;

		/**
		 * Data
		 *
		 * (default value: array())
		 *
		 * @var array
		 * @access protected
		 */
		protected $data = array();

		/**
		 * Initiate new async request
		 */
		public function __construct() {
			$this->identifier = $this->prefix . '_' . $this->action;

			add_action( 'wp_ajax_' . $this->identifier, array( $this, 'maybe_handle' ) );
			add_action( 'wp_ajax_nopriv_' . $this->identifier, array( $this, 'maybe_handle' ) );
		}

		/**
		 * Set data used during the request
		 *
		 * @param array $data Data.
		 *
		 * @return $this
		 */
		public function data( $data ) {
			$this->data = $data;

			return $this;
		}

		/**
		 * Dispatch the async request
		 *
		 * @return array|WP_Error
		 */
		public function dispatch() {
			$url  = add_query_arg( $this->get_query_args(), $this->get_query_url() );
			$args = $this->get_post_args();

			return wp_remote_post( esc_url_raw( $url ), $args );
		}

		/**
		 * Get query args
		 *
		 * @return array
		 */
		protected function get_query_args() {
			if ( property_exists( $this, 'query_args' ) ) {
				return $this->query_args;
			}

			return array(
				'action' => $this->identifier,
				'nonce'  => wp_create_nonce( $this->identifier ),
			);
		}

		/**
		 * Get query URL
		 *
		 * @return string
		 */
		protected function get_query_url() {
			if ( property_exists( $this, 'query_url' ) ) {
				return $this->query_url;
			}

			return admin_url( 'admin-ajax.php' );
		}

		/**
		 * Get post args
		 *
		 * @return array
		 */
		protected function get_post_args() {
			if ( property_exists( $this, 'post_args' ) ) {
				return $this->post_args;
			}

			return array(
				'timeout'   => 0.01,
				'blocking'  => false,
				'body'      => $this->data,
				'cookies'   => leadomaSanitizeArray($_COOKIE),
				'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
			);
		}

		/**
		 * Maybe handle
		 *
		 * Check for correct nonce and pass to handler.
		 */
		public function maybe_handle() {
			// Don't lock up other requests while processing
			session_write_close();

			check_ajax_referer( $this->identifier, 'nonce' );

			$this->handle();

			wp_die();
		}

		/**
		 * Handle
		 *
		 * Override this method to perform any actions required
		 * during the async request.
		 */
		abstract protected function handle();

	}
}


function userRegisterCallback($res, $info){
	if($res["status"]==200){
		update_user_meta( $info["id"], 'is_in_leadoma_'.getCurrentUserEmail(), true );
		update_user_meta( $info["id"], 'leadoma_id_'.getCurrentUserEmail(), $res["body"]["customer"]["code"] );
		update_user_meta( $info["id"], 'leadoma_slug_'.getCurrentUserEmail(), $res["body"]["customer"]["slug"] );
	}
}

class WP_Leadoma_Request extends WP_Async_Request {
	public $action = "leadoma";
	public $LEADOMA_API;
	public $identifier;

	public function __construct( ) {
		$this->LEADOMA_API = new LEADOMA_API();
		$this->identifier = $this->prefix . '_' . $this->action;
		add_action( 'wp_ajax_' . $this->identifier, array( $this, 'maybe_handle' ) );
		add_action( 'wp_ajax_nopriv_' . $this->identifier, array( $this, 'maybe_handle' ) );
	}

	public function handle() {
		$url = sanitize_text_field($_POST['url']);
		$payload = leadomaSanitizeArray($_POST['payload']);
		$method = sanitize_text_field($_POST['method']);
		$callBackTitle = sanitize_text_field($_POST['callbackTitle']);
		$callBackInfo = leadomaSanitizeArray($_POST['callbackInfo']);

		$res=null;
		
		if($method=="get"){
			$res = $this->LEADOMA_API->get($url, $payload);
		} else if($method=="post"){
			$res = $this->LEADOMA_API->post($url, $payload);
		} else if($method=="delete"){
			$res = $this->LEADOMA_API->delete($url, $payload);
		} else if($method=="put"){
			$res = $this->LEADOMA_API->put($url, $payload);
		}

		
		if($callBackTitle){
			switch ($callBackTitle) {
				case 'user_register':
					userRegisterCallback($res, $callBackInfo);
					break;
				
				default:
					# code...
					break;
			}
		}
	}
}