<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('local_listing_pro'))
    if (!class_exists('local_listing_pro')) {
        class local_listing_pro
        {
            
            
            
            
            function __construct()
            {
                
                
                $this->llsp_session_start();
                $this->llsp_plugin();
               
              
            }
            
  
            
  
                       
            function llsp9870_parse_request(&$wp) {
                
                
                if (array_key_exists('llsp9870_api', $wp->query_vars)) {
                    $this->llsp9870_end_request();
                    exit();
                }
                return;
                
            }
            
            
            function llsp9870_end_request(){
                
                global $wpdb;
                $event_json   =  json_decode(stripslashes(sanitize_text_field($_POST['event_json'])));
                $event_id     = $event_json->id;
                $event_object = $event_json->data->object;
                $event_type   = $event_json->type;
                
                if (!empty($event_id)) {
                    
                    try {
                        $customer        = property_exists($event_object, 'customer') ? $event_object->customer : '';
                        $cust_info       = array(
                            'customer' => $customer
                        );
                        $customer_detail = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_process_request('get_customer', $cust_info);
                        ;
                        $customer_email                    = $customer_detail['email'];
                        $customer_name                     = $customer_detail['sources']['data'][0]['name'];
                        $amount                            = property_exists($event_object, 'amount') ? $event_object->amount : '';
                        $bal_transection                   = property_exists($event_object, 'balance_transaction') ? $event_object->balance_transaction : '';
                        $subscriber['customer_name']       = $customer_name;
                        $subscriber['customer_email']      = $customer_email;
                        $subscriber['amount']              = $amount;
                        $subscriber['balance_transaction'] = $bal_transection;
                        
                        $post_id = '';
                        $key     = '_llsp_stripe_customer_id';
                        $value   = $customer;
                        $meta    = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $key . "' AND meta_value='" . $value . "'");
                        if (is_array($meta) && !empty($meta) && isset($meta[0])) {
                            $meta = $meta[0];
                        }
                        if (is_object($meta)) {
                            $post_id = $meta->post_id;
                        }
                        
                        $user_id = $wpdb->get_var("SELECT user_id FROM `" . $wpdb->usermeta . "` WHERE meta_key='_llsp_usr_business_id' AND meta_value='" . $post_id . "'");
                        
                        if ($event_type == 'charge.succeeded') { {
                                
                                update_post_meta($post_id, '_llsp_balance_transection', sanitize_text_field(stripslashes($bal_transection)));
                                
                            }
                        }
                        
                        if ($event_type == "charge.failed" || $event_type == 'invoice.payment_failed') {
                            
                            $this->cancel_billing($user_id);
                            $subscriber['subject']   = "Payment Failed";
                            $subscriber['plan_name'] = $plan_name;
                            local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_send_mail('payment_failed', $subscriber);
                            
                        }
                        
                        if ($event_type == "customer.subscription.updated" || $event_json->type == "customer.subscription.created") {
                            
                            $plan_name                       = $event_object->plan->name;
                            $currency                        = $event_object->plan->currency;
                            $amount                          = $event_object->plan->amount;
                            $current_period_end              = $event_object->current_period_end;
                            $current_period_start            = $event_object->current_period_start;
                            $subscriber['subject']           = "Subscription Created";
                            $billing_start_date              = date('Y-m-d H:i:s', $current_period_start);
                            $billing_end_date                = date('Y-m-d H:i:s', $current_period_end);
                            $subscriber['next_billing_date'] = $billing_end_date;
                            $subscriber['amount']            = $amount;
                            $subscriber['currency']          = $currency;
                            $subscriber['plan_name']         = $plan_name;
                            update_post_meta($post_id, '_llsp_business_billing_start_date', sanitize_text_field($billing_start_date));
                            update_post_meta($post_id, '_llsp_business_billing_end_date', sanitize_text_field($billing_end_date));
                            local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_send_mail('subscription', $subscriber);
                            
                            
                        }
                        
                        if ($event_type == 'invoice.payment_succeeded') {
                            
                            $plan_name                        = $event_object->plan->name;
                            $subscriber['amount']             = $event_object->lines->data[0]->amount;
                            $subscriber['subject']            = "Payment completed for next subscription period";
                            $billing_start_date               = $event_object->lines->data[0]->period->start;
                            $billing_end_date                 = $event_object->lines->data[0]->period->end;
                            $subscriber['plan_name']          = $plan_name;
                            $subscriber['billing_start_date'] = date('Y-m-d H:i:s', $billing_start_date);
                            $subscriber['next_billing_date']  = date('Y-m-d H:i:s', $billing_end_date);
                            update_post_meta($post_id, '_llsp_business_billing_start_date',sanitize_text_field( $billing_start_date));
                            update_post_meta($post_id, '_llsp_business_billing_end_date',sanitize_text_field( $billing_end_date));
                           
                            
                            
                            
                        }
                        
                        if ($event_type == 'customer.subscription.deleted') {
                            
                            
                            $subscriber['subject']   = "Subscription Canceled";
                            $subscriber['amount']    = $event_object->plan->amount;
                            $subscriber['plan_name'] = $event_object->plan->name;
                            $subscriber['ended_at']  = $event_object->ended_at;
                            local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_send_mail('delete_subscription', $subscriber);
                            
                            
                        }
                        
                        
                    }
                    
                    catch (Exception $e) {
                        
                        echo $e->getMessage();
                        exit;
                        
                        
                    }
                    
                }
                
                
            }
            
            
			public function llsp9870_query_vars($query_vars)
            {
                
                $query_vars[] = 'llsp9870_api';
                return $query_vars;
                
            }
            
            public function llsp_textdomain()
            {
                
                load_plugin_textdomain('lss-text-domain', false, local_listing_pro_path . '/languages');
                
            }
            
         
      
            public function llsp_plugin()
            {
            
                add_filter('query_vars', array(
                    $this,
                    'llsp9870_query_vars'
                ));
                add_action('parse_request', array(
                    $this,
                    'llsp9870_parse_request'
                ));
                $this->llsp9870_plugin_start();
                
                
                
            }
            public function llsp9870_plugin_start()
            {
                
                add_action('admin_menu', array(
                    $this,
                    'llsp_business_urls'
                ));
                add_action('plugins_loaded', array(
                    $this,
                    'llsp_textdomain'
                ));
                add_action('llsp_upgrade_part', array(
                    $this,
                    'llsp_upgrade_section'
                ));
                add_action('admin_init', array(
                    $this,
                    'llsp_initial'
                ));
                remove_action('admin_init', 'wp_auth_check_load');
              
               add_action( 'init', array($this,'llsp_plugin_calls') );
               
               include_once('Stripe/init.php');
               include_once('class_local_listing_pro_apifuns.php');
                
                
            }   
            
           
            
                  
            public function upload_business_image()
            {
                
                $login_user_id       = get_current_user_id();
                $user_business_id    = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $business_id         = !empty($user_business_id) ? $user_business_id[0] : '';
                $data['business_id'] = $business_id;
                $business_info       = get_post_meta($business_id);
                $client_id           = isset($business_info['_llsp_business_client_id']) ? $business_info['_llsp_business_client_id'][0] : '';
                if (isset($_FILES['logo'])) {
                    
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->upload_image($_FILES['logo'], 'logo', $user_business_id[0], $client_id, 0);
                    
                }
                $data['business_info'] = $business_info;
				$this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_visibility_report', $data);
                $this->llsp_business_template('local_listing_pro_footer',$data['business_info']);
                
                
            }
            
        
            public function llsp_initial()
            {
              
			
                if (!function_exists('curl_version')) {
                    $plugins   = get_option('active_plugins');
                    $local_listing_pro = plugin_basename(local_listing_pro_path . 'local_listing_pro.php');
                    $update    = false;
                    foreach ($plugins as $i => $plugin) {
                        if ($plugin === $local_listing_pro) {
                            $plugins[$i] = false;
                            $update      = true;
                        }
                    }
                    
                    if ($update) {
                        update_option('active_plugins', array_filter($plugins));
                    }
                    
                    
                    wp_die(__('Curl is not enabled', 'local_listing_pro'), 'Plugin dependency check', array(
                        'back_link' => true
                    ));
                    
                    exit;
                    
                }
                
            }
            public static function activate_llsp()
            {
          
                if (!function_exists('curl_version') && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
                    $plugins   = get_option('active_plugins');
                    $local_listing_pro = plugin_basename(local_listing_pro_path . 'local_listing_pro.php');
                    $update    = false;
                    foreach ($plugins as $i => $plugin) {
                        if ($plugin === $local_listing_pro) {
                            $plugins[$i] = false;
                            $update      = true;
                        }
                    }
                    
                    if ($update) {
                        update_option('active_plugins', array_filter($plugins));
                    }
                    
                    
                    wp_die(__('Curl is not enabled', 'local_listing_pro'), 'Plugin dependency check', array(
                        'back_link' => true
                    ));
                    
                    exit;
                    
                }

			          
                
            }
            
        
				
            public static function deactivate_llsp()
            {
                
                
                wp_clear_scheduled_hook('my_hourly_event');
            }
            
            public function llsp_search_business()
            {
                
                local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_search_business();
                
            }
            
            public function llsp_upgrade_section()
            {
                
                $login_user_id   = get_current_user_id();
                $user_payment    = get_user_meta($login_user_id, '_llsp_user_payment');
                $payment         = !empty($user_payment) ? $user_payment[0] : '';
                $business_id     = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $business_id     = !empty($business_id) ? $business_id[0] : '';
                $business_status = get_post_meta($business_id, '_llsp_business_client_status');
                $business_status = !empty($business_status) ? $business_status[0] : '';                            
                if ($payment && $business_status == "active") {
               
                } else if (!$payment && ($business_status == "paused" || $business_status == "inactive")) {
                    
                    echo '<a  class="btn btn-default orange_btn2 pull-right upgrade_btn" href="?page=upgrade_business">Upgrade to Premium</a>';
                }
                
                
            }
            
            public function cancel_billing($login_user_id = '')
            {
               
                if ($login_user_id == '') {
                    $login_user_id = get_current_user_id();
                }
                
                $user_business_id         = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $business_client_id       = get_post_meta($user_business_id[0], '_llsp_business_client_id');
                $user_payment             = get_user_meta($login_user_id, '_llsp_user_payment');
                $business_upgraded_field  = get_post_meta($user_business_id[0], '_llsp_business_upgraded');
                $business_customer_id     = get_post_meta($user_business_id[0], '_llsp_stripe_customer_id');
                $business_subscription_id = get_post_meta($user_business_id[0], '_llsp_stripe_subscription_id');
              
                
                try {
                    
                   
                   
                    $sub_info = array(
                        'sub_id' => $business_subscription_id[0],
                        'client_id' => $business_client_id[0],
                   
                    );
                    
                    $res1 = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_process_request('cancel_subscription', $sub_info);
                  
                    if ($res1['result'] == 'invalid') {
                        echo $res1['message'];
                        exit;
                    }
                    
                    $canceled_data = array(
                        'ended_at' => $res1['ended_at'],
                        'canceled_at' => $res1['canceled_at'],
                        'deactive_status' => $res1['deactive']
                    );
                    
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->delete_upgarded_order($user_business_id[0], $login_user_id, $business_client_id[0], $canceled_data);
                    
                    
                }
                catch (Exception $e) {
                    
                    echo $e->getMessage();
                    
                }
                
                
            }
            
            public function llsp_submit_business()
            {
                
                local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_submit_business();
					
            }
            public function llsp_get_state()
            {
                
                local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_state_list();
                
            }
            public function llsp_update_business()
            {
                
                local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_update_business();
                
            }
            public function llsp_create_ticket()
            {
                local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_create_ticket();
            }
            public function llsp_add_existing_business()
            {
                
                $states               = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_state_list($template_call = false);
                $countries            = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_country_list($template_call = false);
                $time_options         = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->get_time_options();
                $data['states']       = $states;
                $data['countries']    = $countries;
                $data['time_options'] = $time_options;
                $this->llsp_business_template('local_listing_pro_form', $data);
                exit();
                
                
            }
            public function process_upgrade_business()
            {
                
                
                $card_info =  array_map( 'sanitize_text_field', $_POST['stripe_params'][0]);   
                
                $card_holder_email  = sanitize_text_field($_POST['email']);
                $data               = array();
                $login_user_id      = get_current_user_id();
                $user_details       = get_user_meta($login_user_id);
                $user_business_id   = !empty($user_details['_llsp_usr_business_id']) ? $user_details['_llsp_usr_business_id'][0] : '';
                $business_info      = get_post_meta($user_business_id);
                $business_client_id = isset($business_info['_llsp_business_client_id']) ? $business_info['_llsp_business_client_id'][0] : '';
                
                $business_status        = isset($business_info['_llsp_business_client_status']) ? $business_info['_llsp_business_client_status'][0] : '';
                $business_order_id      = isset($business_info['_llsp_buisness_order_id']) ? $business_info['_llsp_buisness_order_id'][0] : '';
                $customer_id            = isset($business_info['_llsp_stripe_customer_id']) ? $business_info['_llsp_stripe_customer_id'][0] : '';
                $card_info['client_id'] = $business_client_id;
             
                $subscription_id        = '';
                $billing_start_date     = '';
                $billing_end_date       = '';
                $billing_plan_id        = '';
                $billing_status         = '';
                $subscription_created   = '';
                $saved_order            = '';
                
                try {
					
                    if ($business_status == "inactive" && $customer_id == '') {
                        
                        
                        $customer = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_process_request('upgrade_subscription', $card_info);
                        
                        
                        if ($customer['result'] == 'invalid') {
                            
                            
                            echo $customer['message'];
                            exit;
                            
                        }
                        $customer_id        = $customer['id'];
                        $subscriptions_data = $customer['subscriptions']['data'];
                        
                        foreach ($subscriptions_data as $key => $subscription_list) {
                            
                            $subscription_id      = $subscription_list['id'];
                            $billing_start_date   = $subscription_list['current_period_start'];
                            $billing_end_date     = $subscription_list['current_period_end'];
                            $billing_plan_id      = $subscription_list['plan']['id'];
                            $billing_status       = $subscription_list['status'];
                            $subscription_created = $subscription_list['created'];
                        }
                        
                        $saved_order = $customer['saved_order'];
                        
                        
                    } else if ($business_status == "paused") {
                        
                        $card_info['customer_id'] = $customer_id;
                        
                        $sub1 = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_process_request('update_subscription', $card_info);
                        if ($sub1['result'] == 'invalid') {
                            echo $sub1['message'];
                            exit;
                            
                        }
                        
                        $subscription_created = $sub1['created'];
                        $billing_end_date     = $sub1['current_period_end'];
                        $billing_start_date   = $sub1['current_period_start'];
                        $subscription_id      = $sub1['id'];
                        $billing_plan_id      = $sub1['plan']['id'];
                        $billing_status       = $sub1['status'];
                        $saved_order          = $sub1['saved_order'];
                        
                        
                    }
                    
                    $extra_data = array(
                        "customer_id" => $customer_id,
                        "subscription_id" => $subscription_id,
                        'card_holder_email' => $card_holder_email,
                        'billing_start_date' => date('Y-m-d H:i:s', $billing_start_date),
                        'billing_end_date' => date('Y-m-d H:i:s', $billing_end_date),
                        'billing_plan_id' => $billing_plan_id,
                        'billing_status' => $billing_status,
                        'subscription_created' => date('Y-m-d H:i:s', $subscription_created),
                        'business_status' => $business_status,
                        'order_id' => $business_order_id,
                        'saved_order' => $saved_order
                    );
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_create_upgraded_order($login_user_id, $user_business_id, $business_client_id, $card_info, $extra_data);
                    $data['result']             = true;
                    $dash_data['business_info'] = $business_info;
                    $data['content']            = $this->llsp_business_template_file('local_listing_pro_business_dashboard', $dash_data);
                    echo 'valid';
                    exit;
                    
                }
                
                catch (Exception $e) {
                    
                    $data['result']  = false;
                    $data['content'] = $e->getMessage();
                    echo $data['content'];
                    exit;
                    
                    
                    
                }
                
            }
            
            function llsp_business_urls()
            {
                
                $login_user_id    = get_current_user_id();
                $user_business_id = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $path             = local_listing_pro_url . 'images/llsp_icon.png';
                $type             = pathinfo($path, PATHINFO_EXTENSION);
                $icon_data        = file_get_contents($path);
                $icon             = 'data:image/' . $type . ';base64,' . base64_encode($icon_data);
                if (empty($user_business_id[0])) {
                    
                    $local_listing_pro_search_page = add_menu_page("Local Listing Pro", "Local Listing Pro", 'manage_options', 'local_listing_pro', array(
                        $this,
                        'site_search'
                    ), $icon);
                    add_action('admin_print_styles-' . $local_listing_pro_search_page, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_search_page, array(
                        $this,
                        'add_custom_script'
                    ));
                    
                    
                } else {
                    
                    $local_listing_pro_search_page        = add_menu_page("Local Listing Pro", "Local Listing Pro", 'manage_options', 'business_visibility_report', array(
                        $this,
                        'business_visibility_report'
                    ), $icon);
                    $local_listing_pro_detail_page    = add_submenu_page(NULL, "Business Details", 'Business Details', 'manage_options', 'business_details', array(
                        $this,
                        'business_details'
                    ), 2);
                    $local_listing_pro_business_hours         = add_submenu_page(NULL, "Business Hours", 'Business Hours', 'manage_options', 'business_hours', array(
                        $this,
                        'business_hours'
                    ), 3);
                    $local_listing_pro_detail_business_photos = add_submenu_page(NULL, "Business Photos", 'Business Photos', 'manage_options', 'business_photos', array(
                        $this,
                        'business_photos'
                    ), 4);
                    $local_listing_pro_business_visibility    = add_submenu_page(NULL, "Visibility Report", 'Visibility Report', 'manage_options', 'business_visibility_report', array(
                        $this,
                        'business_visibility_report'
                    ), 5);
                    $local_listing_pro_business_citations     = add_submenu_page(NULL, "citations", 'citations', 'manage_options', 'business_citations', array(
                        $this,
                        'business_citations'
                    ), 6);
                    $login_user_id                    = get_current_user_id();
                    $business_id                      = !empty($business_id) ? $business_id[0] : '';
                    $business_status                  = get_post_meta($business_id, '_llsp_business_client_status');
                    $user_payment                     = get_user_meta($login_user_id, '_llsp_user_payment');
                    $payment                          = !empty($user_payment) ? $user_payment[0] : '';
                    $local_listing_pro_upgrade_business       = add_submenu_page(NULL, "upgrade", 'upgrade', 'manage_options', 'upgrade_business', array(
                        $this,
                        'upgrade_business'
                    ), 7);
                    add_action('admin_print_styles-' . $local_listing_pro_upgrade_business, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_upgrade_business, array(
                        $this,
                        'add_custom_script'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_detail_page, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_business_hours, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_detail_business_photos, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_business_visibility, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_business_visibility, array(
                        $this,
                        'add_custom_script'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_business_citations, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_business_citations, array(
                        $this,
                        'add_custom_script'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_business_hours, array(
                        $this,
                        'add_custom_script'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_detail_business_photos, array(
                        $this,
                        'add_custom_script'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_detail_page, array(
                        $this,
                        'add_custom_script'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_business_citations, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_business_citations, array(
                        $this,
                        'llsp_call_citation_chart'
                    ));
                    add_action('admin_print_styles-' . $local_listing_pro_search_page, array(
                        $this,
                        'add_custom_css'
                    ));
                    add_action('admin_print_scripts-' . $local_listing_pro_search_page, array(
                        $this,
                        'add_custom_script'
                    ));
                    
                }
                
            }
            function add_custom_css()
            {
                
                wp_enqueue_style('local_listing_pro_search_page_font_css', local_listing_pro_url . 'css/font-awesome.css', array(), '1.0.0', 'all');
                wp_enqueue_style('local_listing_pro_search_page_font_css1', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800', array(), '1.0.0', 'all');
                wp_enqueue_style('local_listing_pro_search_page_font_css2', 'http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic', array(), '1.0.0', 'all');
                wp_enqueue_style('local_listing_pro_search_page_bootstrap_css', local_listing_pro_url . 'css/bootstrap.css', array(), '1.0.0', 'all');
                wp_enqueue_style('local_listing_pro_search_page_responsive_css', local_listing_pro_url . 'css/responsive.css', array(), '1.0.0', 'all');
                wp_enqueue_style('local_listing_pro_search_page_css', local_listing_pro_url . 'css/style.css', array(), '1.0.0', 'all');
                wp_enqueue_style('local_listing_pro_search_page_build_css', local_listing_pro_url . 'css/build.css', array(), '1.0.0', 'all');
                
                
            }
            function add_custom_script()
            {
                
                wp_enqueue_script('local_listing_pro_bootsrapscript', local_listing_pro_url . 'js/bootstrap.min.js', array(), '1.0.0', true);
                wp_enqueue_script('local_listing_pro_form_validation', local_listing_pro_url . 'js/jquery.form-validator.min.js', array(), '1.0.0', true);
                wp_enqueue_script('llsp_site_stripe_js', 'https://js.stripe.com/v2/', array(), '1.0.0', true);
                wp_enqueue_script('llsp_ajax_script_first', local_listing_pro_url . 'js/jquery.maskedinput-1.3.min.js', array(), '1.0.0', true);
         
                wp_enqueue_script('llsp_ajax_script', local_listing_pro_url . 'js/local_listing_pro_script.js', array(), '1.0.0', true);
                wp_localize_script('llsp_ajax_script', 'llsp_ajax_custom', array(
                    'ajax_call' => admin_url('admin-ajax.php'),
                    'image_url' => local_listing_pro_url,
                ));
                 
                
            }
            
            function llsp_call_citation_chart()
            {
                
                wp_enqueue_script('local_listing_pro_amchart', local_listing_pro_url . 'js/amcharts.js', array(), '1.0.0', 'all');
                wp_enqueue_script('local_listing_pro_amchart_serial', local_listing_pro_url . 'js/serial.js', array(), '1.0.0', 'all');
                wp_enqueue_script('local_listing_pro_mockchart', local_listing_pro_url . 'js/mockchart.js', array(), '1.0.0', 'all');
                
            }
            function business_dashboard()
            {
                
                $login_user_id         = get_current_user_id();
                $user_business_id      = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $business_info         = get_post_meta($user_business_id[0]);
                $data['business_info'] = $business_info;
                $order_id              = isset($business_info['_llsp_buisness_order_id']) ? $business_info['_llsp_buisness_order_id'][0] : '';
                $upgraded_order_id     = isset($business_info['_llsp_buisness_upgraded_order_id']) ? $business_info['_llsp_buisness_upgraded_order_id'][0] : '';
                if (!empty($order_id)) {
                    
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->update_order_detail($user_business_id[0], $order_id);
                     
                }
                if (!empty($upgraded_order_id)) {
					
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->update_upgraded_order_detail($user_business_id[0], $upgraded_order_id);
                      
                }	
         
                $business_info = get_post_meta($user_business_id[0]);
                $this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_business_dashboard', $data);
                $this->llsp_business_template('local_listing_pro_footer', $data['business_info']);
                
            }
            
            public function llsp_plugin_calls()
            {
				add_action("wp_ajax_search_business", array($this,'llsp_search_business'));
				add_action("wp_ajax_nopriv_search_business",  array($this,'llsp_search_business'));
				add_action("wp_ajax_submit_business", array($this,'llsp_submit_business'));
				add_action("wp_ajax_nopriv_submit_business",  array($this,'llsp_submit_business'));
				add_action("wp_ajax_add_existing_business", array($this,'llsp_add_existing_business'));
				add_action("wp_ajax_nopriv_add_existing_business", array($this,'llsp_add_existing_business'));
				add_action("wp_ajax_update_business", array($this,'llsp_update_business'));
				add_action("wp_ajax_update_business", array($this,'llsp_update_business'));
				add_action("wp_ajax_get_citation", array($this,'llsp_get_citation'));
				add_action("wp_ajax_nopriv_get_citation", array($this,'llsp_get_citation'));
				add_action("wp_ajax_upload_business_image", array($this,'upload_business_image'));
				add_action("wp_ajax_nopriv_upload_business_image", array($this,'upload_business_image'));
				add_action("wp_ajax_process_upgrade_business", array($this,'process_upgrade_business'));
				add_action("wp_ajax_nopriv_process_upgrade_business", array($this,'process_upgrade_business'));
				add_action("wp_ajax_cancel_billing", array($this,'cancel_billing'));
				add_action("wp_ajax_nopriv_cancel_billing", array($this,'cancel_billing'));
				add_action("wp_ajax_nopriv_get_state", array($this,'llsp_get_state'));
				add_action("wp_ajax_get_state", array($this,'llsp_get_state'));
				add_action("wp_ajax_create_ticket", array($this,'llsp_create_ticket'));
				add_action("wp_ajax_nopriv_create_ticket", array($this,'llsp_create_ticket'));
				
		 }
            
            function llsp_update_order()
            {
                $login_user_id    = get_current_user_id();
                $user_business_id = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $business_info    = get_post_meta($user_business_id[0]);
                
                
            }
          function business_citations()
            {
                
                $login_user_id         = get_current_user_id();
                $user_business_id      = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $data['business_id']   = $user_business_id[0];
                $business_info         = get_post_meta($user_business_id[0]);
                $data['business_info'] = $business_info;	
     	         
                $data['citations']     = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_client_citations($business_info['_llsp_business_client_id'][0]);
				$this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_citations', $data);
                $this->llsp_business_template('local_listing_pro_footer', $data['business_info']);
                
                
                
            }
            
            function llsp_get_citation()
            {
                
                $login_user_id         = get_current_user_id();
                $user_business_id      = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $data['business_id']   = $user_business_id[0];
                $business_info         = get_post_meta($user_business_id[0]);
                $data['business_info'] = $business_info;
                $citations             = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_client_citations($business_info['_llsp_business_client_id'][0]);
                 $citations_list        = array();
                if ($citations['data']['total'] != 0) {
                    
                    $citations_list = array_filter(($citations['data']['data']), function ($key)  {
					return $key['competitor_id']==0;
					});
                }
                $sum=0;
             
                foreach ($citations_list as $result) {
                    $ym    = date('Y-m', strtotime($result['date_added']));
                    $count = isset($cita[$ym]['count']) ? $cita[$ym]['count'] : 0;
                    $rel   = isset($cita[$ym]['relevancy']) ? $cita[$ym]['relevancy'] : 0;
                      $temp_rel_row = json_decode($result['data']);
                    if ($count != 0) {
                        
                        if (isset($result['data']) && !empty($temp_rel_row[0])) {
							  $rel=   $rel +$temp_rel_row[0]->relevancy;
                            }
                    }
                    
                 
                    $cita[$ym] = array(
                        'count' => $count + 1,
                        'relevancy' =>  $rel
                    );
                }
                $current_month = date('Y-m');
                $cita_options  = array();
              
                       
                if (isset($cita)) {
                    
                    foreach ($cita as $cita_key => $cita_value) {
				
                        $cita_options[] = array(
                            'column-1' => $cita_value['count'],
                            'column-2' => round($cita_value['relevancy']/$cita_value['count']),
                            'date' => 	$cita_key
                        );
                        
                    }
                } else {
					
                    $cita_options[] = array(
                        'column-1' => 0,
                        'column-2' => 0,
                        'date' => $current_month
                    );
                    
                }
                
                usort($cita_options,array($this,'llsp_sort'));
               	 
				echo json_encode($cita_options);
						  
				if(isset($data['business_info']['_llsp_report_date']))
				{
					
					$business_detail = array("client_id"=>$data['business_info']['_llsp_business_client_id'][0],'report_status'=>$data['business_info']['_llsp_report_date'][0]);
				
				
				}
				else
				{
					
					$business_detail = array("client_id"=>$data['business_info']['_llsp_business_client_id'][0],'report_status'=> strtotime($cita_options[ count($cita_options)-1]['date']));
				}
				
				$result=local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_process_request('get_report_status',  $business_detail);
				
				
					
				if($result['success'])
				{
					
					update_post_meta($data['business_id'],'_llsp_report_date',time());
					
				}
				
               	 
				
                exit();
                
            }
            
            function llsp_sort($a, $b) {
				return strtotime($a['date']) - strtotime($b['date']);
			}
            
            function business_visibility_report()
            {
                $login_user_id       = get_current_user_id();
                $user_business_id    = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $business_info       = get_post_meta($user_business_id[0]);
                $data['business_id'] = $user_business_id[0];
                $business_client_id  = isset($meta['_llsp_business_client_id'][0]) ? $meta['_llsp_business_client_id'][0] : '';
				$order_id            = isset($business_info['_llsp_buisness_order_id']) ? $business_info['_llsp_buisness_order_id'][0] : '';
				$upgraded_order_id   = isset($business_info['_llsp_buisness_upgraded_order_id']) ? $business_info['_llsp_buisness_upgraded_order_id'][0] : '';
            
               
                  if (!empty($order_id)) {
                    
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->update_order_detail($user_business_id[0], $order_id);
                     
                }
                if (!empty( $upgraded_order_id)) {
		
                    local_listing_pro_apifuns::get_local_listing_pro_apifuns()->update_upgraded_order_detail($user_business_id[0], $upgraded_order_id);
                      
                }	
         
                $data['business_info'] = $business_info;              
                $this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_visibility_report', $data);
                $this->llsp_business_template('local_listing_pro_footer',  $data['business_info']);
                
                
            }
            
            function business_details()
            {
				$login_user_id         = get_current_user_id();
                $user_business_id      = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $user_payment    = get_user_meta($login_user_id, '_llsp_user_payment');
                $payment         = !empty($user_payment) ? $user_payment[0] : '';
                $business_id     = !empty($user_business_id) ?  $user_business_id[0] : '';
				$business_status = get_post_meta(  $business_id  , '_llsp_business_client_status');
                $business_status = !empty($business_status) ? $business_status[0] : '';                        
                $meta       = get_post_meta($user_business_id[0]);
                $states     = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_state_list($template_call = false);
                $countries   = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_country_list($template_call = false);
                $data['business_info'] = $meta;
                $data['states']        = $states;
                $data['countries']     = $countries;
                $data['business_id']   = $user_business_id[0];
                $data['payment']   = $payment ;
                $data['status']   = $business_status; 
				$this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_business_details', $data);
                $this->llsp_business_template('local_listing_pro_footer', $data['business_info']);
                
                
            }
            function upgrade_business()
            {
                
                $data             = array();
                $login_user_id    = get_current_user_id();
                $user_business_id = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $user_info        = get_user_meta($login_user_id);
                
                $business_info         = get_post_meta($user_business_id[0]);
                $states                = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_state_list($template_call = false);
                $countries             = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_get_country_list($template_call = false);
                $client_status         = get_post_meta($user_business_id, '_llsp_business_client_status');
                $data['business_info'] = $business_info;
                $data['states']        = $states;
                $data['countries']     = $countries;
                $data['business_id']   = !empty($user_business_id) ? $user_business_id[0] : '';
                $data['user_info']     = $user_info;
                $subscription_id       = isset($business_info['_llsp_stripe_subscription_id']) ? $business_info['_llsp_stripe_subscription_id'][0] : '';
                $customer_id           = isset($business_info['_llsp_stripe_customer_id']) ? $business_info['_llsp_stripe_customer_id'][0] : '';
                
                $payment         = !empty($user_info['_llsp_user_payment']) ? $user_info['_llsp_user_payment'][0] : '';
                $business_status = !empty($business_info['_llsp_business_client_status']) ? $business_info['_llsp_business_client_status'][0] : '';
                
                if ((!$payment && ($business_status == "paused" || $business_status == "inactive"))) {
                    $template = 'local_listing_pro_upgrade_business';
                } else {
                    $cust_info     = array(
                        "customer_id" => $customer_id
                    );
                    $invoice_lists = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->llsp_process_request('payment_lists', $cust_info);
                    
                    $invoice = array();
                    
                    foreach ($invoice_lists['data'] as $key1 => $invoice_row) {
                        
                        if ($invoice_row['subscription'] == $subscription_id) {
                            $customer = $invoice_row['customer'];
                            foreach ($invoice_row['lines']['data'] as $key2 => $data2) {
                                $start_date     = date('Y-m-d H:i:s', $data2['period']['start']);
                                $end_date       = date('Y-m-d H:i:s', $data2['period']['end']);
                                $amount         = $data2['amount'];
                                $invoice[$key1] = array(
                                    'customer' => $customer,
                                    'start_date' => $start_date,
                                    'end_date' => $end_date,
                                    'amount' => $amount
                                );
                            }
                        }
                    }
                    
                    $data['invoice'] = $invoice;
                    $template        = 'local_listing_pro_susbcription_page';
                }
                
                
                $this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template($template, $data);
                $this->llsp_business_template('local_listing_pro_footer',$data['business_info']);
                
                
            }
            function business_photos()
            {
                
                $login_user_id         = get_current_user_id();
                $user_business_id      = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $data['business_info'] = get_post_meta($user_business_id[0]);
                $data['business_id']   = $user_business_id;
                $this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_business_photos', $data);
                $this->llsp_business_template('local_listing_pro_footer',$data['business_info']);
                
            }
            function business_hours()
            {
                
                $login_user_id        = get_current_user_id();
                $user_business_id     = get_user_meta($login_user_id, '_llsp_usr_business_id');
                $data['business_info']         = get_post_meta($user_business_id[0]);
                $data['business_id']  = $user_business_id;
                $data['time_options'] = local_listing_pro_apifuns::get_local_listing_pro_apifuns()->get_time_options();
                $this->llsp_business_template('local_listing_pro_header');
                $this->llsp_business_template('local_listing_pro_business_hours', $data);
                $this->llsp_business_template('local_listing_pro_footer',   $data['business_info']);
                
            }
            public function search_demo()
            {
                
                $this->llsp_business_template('local_listing_pro_form');
            }
            public function site_search()
            {
                
                $this->llsp_business_template('local_listing_pro_search');
            }
            public function site_submit()
            {
                
                $this->llsp_business_template('local_listing_pro_form');
                
            }
            
            public function get_template_path()
            {
                
                $plugin_path = plugin_dir_path(__FILE__);
                return $plugin_path;
            }
            public function llsp_business_template($template_name, $data = array())
            {
                
                $result = $data;
                require_once(local_listing_pro_path . '/templates/' . $template_name . '.php');
                
            }
            
            public function llsp_session_start()
            {
                 if(!isset($_SESSION))
               { 
                session_start();
				}
                
            }
            
            public function llsp_business_template_file($template_name)
            {
                ob_start();
                require_once(local_listing_pro_path . '/templates/' . $template_name . '.php');
                return ob_get_clean();
            }
        }
    }
?>
