<?php
/* 
 * Plugin Name: Leadoma
 * Plugin URL: https://leadoma.com
 * Description: Customer Relationship Management 
 * Version: 2.3.0
 * Author: Ayten
 * Plugin URL: https://ayten.studio
 * Text Domain: leadoma
 * Domain Path: /languages
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html

 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see <http://www.gnu.org/licenses/>

*/
if(! defined( 'WPINC' )){
  die;
}

define('DEFAULT_VALUES', array(
	"customer" => array(
		"country" => "BgJ6UkfM",
		"city" => "SZU5izES",
		"phone_number" => "",
		"country" => "",
		"language" => "en",
		"company" => "",
		"website" => "",
		"tags" => [
			"default" => array(
				"title" => "LEADOMA",
				"color_code" => "black"
			)
		]
	)
));

//constants
define('LEADOMA_DEV_MODE', false);
define('LEADOMA_DIR', plugin_dir_path(__FILE__));
define('LEADOMA_DIR_URL', plugin_dir_url(__FILE__));
define('LEADOMA_BASE_URL', "https://api.leadoma.com");

// api
include(LEADOMA_DIR.'includes/utilities.php');
include(LEADOMA_DIR.'includes/api/api.php');
include(LEADOMA_DIR.'includes/new-utilities.php');

//assets
include(LEADOMA_DIR.'includes/assets/leadoma-styles.php');
include(LEADOMA_DIR.'includes/assets/leadoma-scripts.php');

//pages
include(LEADOMA_DIR.'includes/pages/leadoma-pages.php');

// settings
include(LEADOMA_DIR.'includes/leadoma-settings.php');

// wp_enqueue_style('leadoma-admin');



$EVENTS = array(
	'woocommerce_add_to_cart' => array(
		'method' => 'post',
		'slug' => 'wfTYwMET',//!!!!!
		'url'=> LEADOMA_BASE_URL."/business/activity"
	),
	'woocommerce_remove_from_cart' => array(
		'method' => 'post',
		'slug' => 'NLzxFGoD',//!!!!!
		'url'=> LEADOMA_BASE_URL."/business/activity"
	),
	'woocommerce_applied_coupon' => array(
		'method' => 'post',
		'slug' => 'rQCSqqow',//!!!!!
		'url'=> LEADOMA_BASE_URL."/business/activity"
	),
	'woocommerce_coupon_error' => array(
		'method' => 'post',
		'slug' => 'RmsOcd0Q',//!!!!!
		'url'=> LEADOMA_BASE_URL."/business/activity"
	),
	'woocommerce_order_status_completed' => array(
		'method' => 'post',
		'slug' => 'YsiPmZVm',//!!!!!
		'url'=> LEADOMA_BASE_URL."/business/activity"
	),
	'woocommerce_checkout_order_processed' => array(
		'method' => 'post',
		'slug' => 'AYb9zU1W',//!!!!! its for stats too
		'url'=> LEADOMA_BASE_URL."/business/activity"
	),

	'user_update_profile' => array(
		'method' => 'post',
		'url'=> 'https://httpbin.org/anything2'
	),

	// todo: change it to regular create user
	'user_register' => array(
		'method' => 'post',
		'url'=> LEADOMA_BASE_URL."/business/customer"
	),

	"woocommerce_checkout_order_processed_tag"=>array(
		'method' => 'post',
		'url'=> LEADOMA_BASE_URL."/business/tag/customers/"
	),

	"woocommerce_cart_emptied"=>array(
		'method' => 'post',
		'url'=> LEADOMA_BASE_URL."/business/tag/customers/"
	),

);

// todo somehow add the pages and stuff inside the class
class Leadoma {
	protected $CurrentUser;
	protected $EVENTS;
	protected $DEFAULT_VALUES;
	protected $process_single;

	public function __construct($EVENTS, $DEFAULT_VALUES) {
		$this->EVENTS = $EVENTS;
		$this->DEFAULT_VALUES = $DEFAULT_VALUES;
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		// hooks
		add_action( 'woocommerce_add_to_cart', array($this, 'leadoma_woocommerce_add_to_cart_callback'), 10, 6);
		add_action( 'woocommerce_remove_cart_item', array($this, 'leadoma_woocommerce_remove_from_cart_callback'), 10, 2);
		// add_action( 'woocommerce_cart_emptied', array($this, 'leadoma_woocommerce_cart_emptied_callback'), 10, 1 );
		add_action( 'woocommerce_applied_coupon', array($this, 'leadoma_woocommerce_applied_coupon_callback'), 10, 1);
		add_action( 'woocommerce_coupon_error', array($this, 'leadoma_woocommerce_coupon_error_callback'), 10, 2);
		add_action( 'woocommerce_order_status_completed', array($this, 'leadoma_woocommerce_order_status_completed_callback'), 10, 1 );
		add_action( 'woocommerce_checkout_order_processed', array($this, 'leadoma_woocommerce_checkout_order_processed_callback'), 10, 1 );

		add_action( 'user_register', array($this, 'leadoma_user_register_callback'), 10, 2);
		
		add_action( 'profile_update', array($this, 'leadoma_user_profile_update_callback'), 10, 3);
	}

	public function init() {
		require_once plugin_dir_path( __FILE__ ) . 'async-requests/class-leadoma-request.php';
		$this->process_single = new WP_Leadoma_Request();
	}


	//* Callbacks
	// ! do not put print in callback, it might break the response
	
	public function leadoma_user_register_callback($user_id, $userdata){
		$username = $userdata['user_login'];
		$email = $userdata['user_email'];

		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['user_register']['method'],
				"url"=>$this->EVENTS['user_register']['url'],
				"callbackTitle" => "user_register",
				"callbackInfo" => array(
					"id"=> $user_id,
				),
				"payload" => array(
					// array of customers data
					// 'customers_data' => [ array(
							"full_name" =>		$username,
							"email" =>				$email,
							"phone_number" => $this->DEFAULT_VALUES['customer']['phone_number'],
							"country" => 			$this->DEFAULT_VALUES['customer']['country'],
							"city" => 				$this->DEFAULT_VALUES['customer']['city'],
							"language" => 		$this->DEFAULT_VALUES['customer']['language'],
							"company" => 			$this->DEFAULT_VALUES['customer']['company'],
							"website" => 			$this->DEFAULT_VALUES['customer']['website'],
							"tags" => 				array(
								$this->DEFAULT_VALUES['customer']['tags']["default"],
								["title"=>"New Customer", "color_code"=>"black"]
								// leadomaGetTagSlug("New Customer")?["title"=>"New Customer", "color_code"=>"black"]:null,
							)
						// )
					// ]
				)
			)

		)->dispatch();
	}
	
	public function leadoma_user_profile_update_callback($user_id, $old_user_data, $userdata){
		
		//! becarefull it will run on user create too :/
		// todo: update firstname and lastname and email*


		if (is_user_logged_in()) { 
			// Updating profile info when logged in 
			$this->process_single->data( 
				array(
					"method"=>$this->EVENTS['user_update_profile']['method'],
					"url"=>$this->EVENTS['user_update_profile']['url'],
					"payload" => array('user_id'=>$user_id, 'old_user_data'=>$old_user_data, 'userdata'=>$userdata)
				)
			)->dispatch();
		}else if (empty($old_user_data->user_activation_key)) { 
			// Registering
		}

	}

	public function leadoma_woocommerce_add_to_cart_callback($cart_id, $product_id, $request_quantity, $variation_id, $variation, $cart_item_data){
		if ( !is_user_logged_in() ){ return; }
		$productName = wc_get_product( $product_id )->get_name();;
    $userEmail = wp_get_current_user()->user_email;
		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_add_to_cart']['method'],
				"url"=>$this->EVENTS['woocommerce_add_to_cart']['url'],
				"payload" => array(
					"email"=>$userEmail,
					"action_slug"=>$this->EVENTS['woocommerce_add_to_cart']['slug'],
					"extra_data"=>array(
						"activity_data"=>array(
							"description"=>"Added ".$request_quantity." '".$productName."' to cart",
						)
					)
				)
			)
		)->dispatch();
	}

	public function leadoma_woocommerce_checkout_order_processed_callback($order_id){
		if ( !is_user_logged_in() ){ return; }
		$order = wc_get_order( $order_id );
		$total = $order->get_formatted_order_total();

		$user_id = get_post_meta( $order_id, '_customer_user', true );
		$customer = new WC_Customer( $user_id );

    $userEmail = $customer->get_email();

		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_checkout_order_processed']['method'],
				"url"=>$this->EVENTS['woocommerce_checkout_order_processed']['url'],
				"payload" => array(
					"email"=>$userEmail,
					"action_slug"=>$this->EVENTS['woocommerce_checkout_order_processed']['slug'],
					"extra_data"=>array(
						"activity_data"=>array(
							"description"=>"Customer placed order #".$order_id." with a total of ".$total,
						)
					)
				)
			)
		)->dispatch();


		$meta = get_user_meta( $user_id );
		$customerLeadomaId = $meta['leadoma_slug_'.getCurrentUserEmail()][0]; // used in userRegisterCallback too
		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_checkout_order_processed_tag']['method'],
				"url"=>$this->EVENTS['woocommerce_checkout_order_processed_tag']['url'],
				"payload" => array(
					"customers"=>[$customerLeadomaId],
					"tags"=> [leadomaGetTagSlug("New Order")],
				)
			)
		)->dispatch();
	}

	public function leadoma_woocommerce_order_status_completed_callback($order_id){
		if ( !is_user_logged_in() ){ return; }
		$order = wc_get_order( $order_id );
		$total = $order->get_formatted_order_total();

		$user_id = get_post_meta( $order_id, '_customer_user', true );
		$customer = new WC_Customer( $user_id );

    $userEmail = $customer->get_email();

		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_order_status_completed']['method'],
				"url"=>$this->EVENTS['woocommerce_order_status_completed']['url'],
				"payload" => array(
					"email"=>$userEmail,
					"action_slug"=>$this->EVENTS['woocommerce_order_status_completed']['slug'],
					"extra_data"=>array(
						"activity_data"=>array(
							"description"=>"Order #".$order_id." completed with a total of ".$total,
						)
					)
				)
			)
		)->dispatch();
	}

	public function leadoma_woocommerce_remove_from_cart_callback($cart_item_key, $cart){
		if ( !is_user_logged_in() ){ return; }
		$product_id = $cart->cart_contents[ $cart_item_key ]['product_id'];
		$productName = wc_get_product( $product_id )->get_name();
    $userEmail = wp_get_current_user()->user_email;
		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_remove_from_cart']['method'],
				"url"=>$this->EVENTS['woocommerce_remove_from_cart']['url'],
				"payload" => array(
					"email"=>$userEmail,
					"action_slug"=>$this->EVENTS['woocommerce_remove_from_cart']['slug'],
					"extra_data"=>array(
						"activity_data"=>array(
							"description"=>"Removed '".$productName."' from cart",
						)
					)
				)
			)
		)->dispatch();
	}

	// public function leadoma_woocommerce_cart_emptied_callback($clear_persistent_cart ){
	// 	if ( !is_user_logged_in() ){ return; }

  //   $user_id = get_current_user_id();
	// 	$meta = get_user_meta( $user_id );
	// 	$customerLeadomaId = $meta['leadoma_slug_'.getCurrentUserEmail()][0]; // used in userRegisterCallback too
		
	// 	$this->process_single->data( 
	// 		array(
	// 			"method"=>$this->EVENTS['woocommerce_cart_emptied']['method'],
	// 			"url"=>$this->EVENTS['woocommerce_cart_emptied']['url'],
	// 			"payload" => array(
	// 				"customers"=>[$customerLeadomaId],
	// 				"tags"=> [leadomaGetTagSlug("Card emptied")],
	// 			)
	// 		)
	// 	)->dispatch();
	// }

	public function leadoma_woocommerce_applied_coupon_callback($coupon_code){
		if ( !is_user_logged_in() ){ return; }
		$userEmail = wp_get_current_user()->user_email;
		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_applied_coupon']['method'],
				"url"=>$this->EVENTS['woocommerce_applied_coupon']['url'],
				"payload" => array(
					"email"=>$userEmail,
					"action_slug"=>$this->EVENTS['woocommerce_applied_coupon']['slug'], 
					"extra_data"=>array(
						"activity_data"=>array(
							"description"=>"Coupon '".$coupon_code."' successfully applied",
						)
					)
				)
			)
		)->dispatch();
	}

	public function leadoma_woocommerce_coupon_error_callback($coupon_error, $error_code){
		if ( !is_user_logged_in() ){ return; }
		$userEmail = wp_get_current_user()->user_email;
		$this->process_single->data( 
			array(
				"method"=>$this->EVENTS['woocommerce_coupon_error']['method'],
				"url"=>$this->EVENTS['woocommerce_coupon_error']['url'],
				"payload" => array(
					"action_slug"=>$this->EVENTS['woocommerce_coupon_error']['slug'], 
					"email"=>$userEmail, 
					"extra_data"=>array(
						"activity_data"=>array(
							"description"=>$coupon_error
						)
					)
				)
			)
		)->dispatch();
	}

}

new Leadoma($EVENTS, DEFAULT_VALUES);