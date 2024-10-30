<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('local_listing_pro_apifuns')) {
    class local_listing_pro_apifuns
    {
        
	
		
        function __construct()
        {
            
            
            
            
        }
        



     
        
        static function get_local_listing_pro_apifuns()
        {
            return new local_listing_pro_apifuns;
        }
        
        function llsp_send_mail($mail, $data)
        {
            
            
            $subject = sanitize_text_field($data['subject']);
            $email   = sanitize_email( $data['customer_email']);
            $from   =  isset($data['sender_email'])?sanitize_email($data['sender_email'] ): "Help@adviceinteractive.com";
            $message = $this->llsp_business_template_file('emails/llsp_' .$mail, $data);	
            $to      = sanitize_email($email);
  
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: <' . $from . ">\r\n" . 'Reply-To: <Help@adviceinteractive.com>';
            
		
            
            mail($to, $subject, $message, $headers);
        
        }
        
        function llsp_search_business()
        {
			
            
            if (isset($_SESSION['searched_business_list'])) {
                unset($_SESSION['searched_business_list']);
            }
            
            $search_name    = sanitize_text_field($_POST['search_name']);
            $search_zipcode = sanitize_text_field($_POST['search_zipcode']);
     
            $params         = array(
                'search' => $search_name,
                'zipcode' => $search_zipcode,
            
            );
       
           
             $result   = $this->llsp_process_request( 'searchbusiness',$params);
            
            
            if (!empty($result['data']['data']) && $result['success']) {
                $searched_business         = $result['data']['data'];
                $data['searched_business'] = $searched_business;
            }
            
            $data['states']       = $this->llsp_get_state_list(false);
            $data['countries']    = $this->llsp_get_country_list(false);
            $data['time_options'] = $this->get_time_options();
            $this->llsp_business_template('local_listing_pro_search_result', $data);
            exit;
            
            
        }
        
        function change_time_format($time){
         return date("H:i", strtotime($time));

        }


     
        function llsp_submit_business()
        {
            
            global $display_name, $user_email;
            get_currentuserinfo();
            if (!isset($_POST['business_id'])) {
         
                foreach ($_POST['business_form_data'] as $key => $value) {
                    switch ($value['name']) {
                        case 'llsp_submit_field_business_name':
                            $data['name'] =sanitize_text_field( $value['value']);
                            break;
                        
                        case 'llsp_submit_field_street':
                            $data['street'] =sanitize_text_field( $value['value']);
                            break;
                        
                        case 'llsp_submit_field_city':
                            $data['city'] = sanitize_text_field($value['value']);
                            break;
                        
                        case 'llsp_submit_field_country':
                            $data['country'] = sanitize_text_field( $value['value']);
                            break;
                        
                        case 'llsp_submit_field_state':
                            $data['state'] = sanitize_text_field($value['value']);
                            break;
                        
                        case 'llsp_submit_field_zipcode':
                            $data['zipcode'] =sanitize_text_field( $value['value']);
                            break;
                        case 'llsp_submit_field_website':
                            $data['website'] =sanitize_text_field( $value['value']);
                            break;
                        case 'llsp_submit_field_phone':
                            $data['phone'] = sanitize_text_field($value['value']);
                            break;
                        case 'llsp_submit_field_email':
							$data['email '] = sanitize_text_field($value['value']);
                            $user_email = sanitize_email( $value['value'] );
                            break;
                        
                        case '_llsp_business_description':
                            $data['description'] = sanitize_text_field($value['value']);
                            break;
                        case '_llsp_business_contact_name':
                            $data['owner'] = sanitize_text_field($value['value']);
                            break;
                        case '_llsp_business_category':
                            $data['keyword1'] = sanitize_text_field($value['value']);
                            break;
                        
                        
                        case "monday_open":
                            $data_hour['monday_open'] = sanitize_text_field($value['value']);
                            break;
                        
                        case "monday_close":
                            $data_hour["monday_close"] = sanitize_text_field( $value['value']);
                            break;
                        
                        case "tuesday_open":
                            $data_hour['tuesday_open'] =sanitize_text_field( $value['value'] );
                            break;
                        
                        case "tuesday_close":
                            $data_hour['tuesday_close'] = sanitize_text_field( $value['value']);
                            break;
                        case "wednesday_open":
                            $data_hour['wednesday_open'] =sanitize_text_field( $value['value']);
                            break;
                        
                        case "wednesday_close":
                            $data_hour['wednesday_close'] =sanitize_text_field( $value['value']);
                            break;
                        case "thursday_open":
                            $data_hour['thursday_open'] = sanitize_text_field($value['value']);
                            break;
                        case "thursday_close":
                            $data_hour['thursday_close'] =sanitize_text_field( $value['value']);
                            break;
                        
                        case "friday_open":
                            $data_hour['friday_open'] =sanitize_text_field( $value['value']);
                            break;
                        case "friday_close":
                            $data_hour['friday_close'] =sanitize_text_field( $value['value']);
                            break;
                        case "saturday_open":
                            $data_hour['saturday_open'] = sanitize_text_field($value['value']);
                            break;
                        
                        case "saturday_close":
                            $data_hour['saturday_close'] = sanitize_text_field($value['value']);
                            break;
                        case "sunday_open":
                            $data_hour['sunday_open'] =sanitize_text_field($value['value']);
                            break;
                        
                        case "sunday_close":
                            $data_hour['sunday_close'] =sanitize_text_field($value['value']);
                            break;
                            
                            
                    }
                    
                }
                
              if(($data_hour['monday_open'] != 'select') || ($data_hour['monday_open'] != 'closed') ):

                $data_hour_temp[0] = array(
                    "openDay" => 'Monday',
                    "closeDay"=> 'Monday',
                    "openTime" => $this->change_time_format($data_hour['monday_open']),
                    "closeTime" => $this->change_time_format($data_hour["monday_close"])
                    );
              endif;
                

              if(($data_hour['tuesday_open'] != 'select') || ($data_hour['tuesday_open'] != 'closed') ):  
                $data_hour_temp[1] = array(
                    "openDay" => 'Tuesday',
                    "closeDay"=> 'Tuesday',
                    "openTime" => $this->change_time_format($data_hour['tuesday_open']),
                    "closeTime" => $this->change_time_format($data_hour["tuesday_close"])
                    
                );
              endif;


               if(($data_hour['wednesday_open'] != 'select') || ($data_hour['wednesday_open'] != 'closed')):  
                $data_hour_temp[3] = array(
                    "openDay" => 'Wednesday',
                    "closeDay" => 'Wednesday',
                    "openTime" => $this->change_time_format($data_hour['wednesday_open']),
                    "closeTime" => $this->change_time_format($data_hour["wednesday_close"])
                    
                );
              endif;
              
              if(($data_hour['thursday_open'] != 'select') || ($data_hour['thursday_open'] != 'closed')):  
                $data_hour_temp[4] = array(
                    "openDay" => 'Thursday',
                    "closeDay" => 'Thursday',
                    "openTime" => $this->change_time_format($data_hour['thursday_open']),
                    "closeTime" => $this->change_time_format($data_hour["thursday_close"])
                    
                );
             endif;


             if(($data_hour['friday_open'] != 'select') || ($data_hour['friday_open'] != 'closed')): 
                $data_hour_temp[5] = array(
                     "openDay" => 'Friday',
                     "closeDay" => 'Friday',
                     "openTime" => $this->change_time_format($data_hour['friday_open']),
                     "closeTime" => $this->change_time_format($data_hour["friday_close"])
                    
                );
              endif;
            


             if(($data_hour['saturday_open'] != 'select') || ($data_hour['saturday_open'] != 'closed')):  
                 $data_hour_temp[6] = array(
                    "openDay"  => 'Saturday',
                    "closeDay" => 'Saturday',
                    "openTime" => $this->change_time_format($data_hour['saturday_open']),
                    "closeTime" => $this->change_time_format($data_hour['saturday_close'])
                );

            endif;


              if(($data_hour['sunday_open'] != 'select') || ($data_hour['sunday_open'] != 'closed')):

                $data_hour_temp[7] = array(
                     "openDay" =>  'Sunday',
                     "closeDay" => 'Sunday',
                     "openTime" => $this->change_time_format($data_hour['sunday_open']),
                     "closeTime" => $this->change_time_format($data_hour['sunday_close'])
                 );

             endif;
                 

                 $working_hours = '';
                 foreach($data_hour_temp as $data_sent_to_api){
                  $working_hours .=json_encode($data_sent_to_api,JSON_FORCE_OBJECT).',';
                 }    
                   
               
                $modified_working_hours ='{"periods":['.rtrim($working_hours,",").']}';
            
                
               $data['hours']     = (string)$modified_working_hours;
                $data_meta_hours   = json_encode($data_hour);
                $client_id         = '';
                $order_id          = '';
           
                $params  = array(
				
                    "fields" => $data
                );


                $saved_user  = $this->llsp_process_request( 'submit_business',$params,'https://p.lssdev.com/legacyclients');
                
            
                $saved_user = json_decode($saved_user);
               
                $saved_user = (array)$saved_user;

                
                
               
                 if ($saved_user['success']) {
                    $data_arr = $saved_user['data'];
                    $client_id     = $data_arr->id;
                    $login_user_id = get_current_user_id();
                    $business_args = array(
                        'post_title' => sanitize_text_field($data['name']),
                        'post_type' => 'llsp_business',
                        'post_name' => sanitize_text_field($data['name']),
                        'post_author' => $login_user_id,
                        'post_status' => 'publish'
                    );
                    global $display_name, $user_email;
                    get_currentuserinfo();
                    $created_business_id = wp_insert_post($business_args);
              
                    update_post_meta($created_business_id, '_llsp_business_name', sanitize_text_field($data['name']));
                    update_user_meta($login_user_id, '_llsp_usr_business_id', $created_business_id);
                    update_user_meta($login_user_id, '_llsp_user_payment', false);
                    update_user_meta($login_user_id, '_llsp_user_country', sanitize_text_field($data['country']));
                    update_user_meta($login_user_id, '_llsp_user_city',sanitize_text_field ($data['city']));
                    update_user_meta($login_user_id, '_llsp_user_state', sanitize_text_field($data['state']));
                    //update_user_meta($login_user_id, '_llsp_user_address', sanitize_text_field($data['address']));
                    update_user_meta($login_user_id, '_llsp_user_zip', sanitize_text_field($data['zipcode']));
                    update_user_meta($login_user_id, '_llsp_user_name',sanitize_text_field( $display_name));
                    update_user_meta($login_user_id, '_llsp_user_email',sanitize_email( $user_email));
                    update_post_meta($created_business_id, '_llsp_business_city',sanitize_text_field( $data['city']));
                    update_post_meta($created_business_id, '_llsp_business_street',sanitize_text_field( $data['street']));
                    update_post_meta($created_business_id, '_llsp_business_zipcode',sanitize_text_field( $data['zipcode']));
                    update_post_meta($created_business_id, '_llsp_business_state',sanitize_text_field( $data['state']));
                    update_post_meta($created_business_id, '_llsp_business_phone', sanitize_text_field($data['phone']));
                    update_post_meta($created_business_id, '_llsp_business_website',sanitize_text_field( $data['website']));
                    update_post_meta($created_business_id, '_llsp_business_country', sanitize_text_field($data['country']));
                    update_post_meta($created_business_id, '_llsp_business_email', sanitize_email($user_email));
                    update_post_meta($created_business_id, '_llsp_business_client_id', $client_id);
                    update_post_meta($created_business_id, '_llsp_business_description',sanitize_text_field($data['description']));
                    update_post_meta($created_business_id, '_llsp_business_contact_name', sanitize_text_field($data['owner']));
                   
                    update_post_meta($created_business_id, '_llsp_business_category',sanitize_text_field( $data['keyword1']));
                    update_post_meta($created_business_id, '_llsp_business_hours', sanitize_text_field($data_meta_hours));
                    update_post_meta($created_business_id, '_llsp_business_report
                    _time', date('Y-m-d H:i:s'));
                    update_post_meta($created_business_id, '_llsp_report_date',time());
                    update_post_meta($created_business_id, '_llsp_business_upgraded', false);
                    update_post_meta($created_business_id, '_llsp_business_client_status', 'inactive');


                    $this->upload_image($_FILES['logo'], 'logo',$created_business_id, $client_id, 0);
                      $params  = array(
                        "client_id" => $client_id,
                      );
                          

					 $saved_order = $this->llsp_process_request( 'free_order',$params);
					
                    
                    if ($saved_order['success']) {
                        
                        $order_id        = $saved_order['data']["order"]["id"];
                        $this->update_order_detail($created_business_id, $order_id);
                        $mail_data['subject']        = 'Business Submitted';
                        $mail_data['business_url']   = sanitize_text_field($data['website']);
                        $mail_data['state']          = sanitize_text_field($data['state']);
         				$mail_data['city']           = sanitize_text_field($data['city']);
                        $mail_data['address']        = sanitize_text_field($data['street']);
                        $mail_data['business']       = sanitize_text_field($data['name']);
                     
                       $mail_data['customer_email'] = sanitize_email( $user_email);
                       $this->llsp_send_mail('submit_business_mail', $mail_data);
                      
                        if (isset($_SESSION['searched_business_list'])) {
                            unset($_SESSION['searched_business_list']);
                        }
                        
                 
                        
                    }
                    
                }
                
              }
            
            else {


                $data_temp       = array();
                $exist_client_id = '';
                foreach ($_POST['business_form_data'] as $key => $value) {
                     switch ($value['name']) {
                        case '_llsp_business_name':
                            $data_temp['name '] = $value['value'];
                            break;
                        
                        case '_llsp_business_city':
                            $data_temp['city'] = $value['value'];
                            break;
                        
                        case '_llsp_business_street':
                            $data_temp['street'] = $value['value'];
                            break;
                        
                        case '_llsp_business_zipcode':
                            $data_temp['zipcode'] = $value['value'];
                            break;
                        
                        case '_llsp_business_state':
                            $data_temp['state'] = $value['value'];
                            break;
                        
                        case '_llsp_business_phone':
                            $data_temp['phone'] = $value['value'];
                            break;
                        
                        case '_llsp_business_country':
                            $data_temp['country'] = $value['value'];
                            break;
                        
                        case '_llsp_business_email':
                            $data_temp['email'] = $value['value'];
                            break;
                        
                        case '_llsp_business_website':
                            $data_temp['website'] = $value['value'];
                            break;
                        
                        case '_llsp_business_client_id':
                            $exist_client_id = $value['value'];
                            break;
                        
                        case '_llsp_business_description':
                            $data_temp['description'] = $value['value'];
                            break;
                        
                        case '_llsp_business_category':
                            $data_temp['keyword1 '] = $value['value'];;
                            break;
                        
                        case '_llsp_business_contact_name':
                            $data_temp['owner'] = $value['value'];
                            break;
                            
                            
                            
                    }
                    update_post_meta($_POST['business_id'], sanitize_text_field(  $value['name']),  sanitize_text_field( $value['value']));
                   
                }
                
           
                
                
                
                $params     = array(
                    'client_id' => $exist_client_id,
                    "fields" => $data_temp,
                  
                );
               
               
               	$saved_user = $this->llsp_process_request( 'updateclient',$params,'new_api');
                $this->llsp_business_template('local_listing_pro_address_info', $data_temp);
                
                
                
            }
            
            exit;
            
            
            
            
        }
        
        function llsp_update_business()
        {
            
            $data               = array();
            $data1              = array();
            $business_id        =sanitize_text_field($_POST['business_id']);
            $business_client_id = sanitize_text_field($_POST['business_client_id']);
            $request_type       =sanitize_text_field( $_POST['type']);
            if ($request_type == 'hours') {
                
                
                foreach ($_POST['business_updated_data'] as $key => $value) {
                    switch ($value['name']) {
                        case "monday_open":
                            $data['monday_open'] = sanitize_text_field($value['value']);
                            break;
                        case "monday_close":
                            $data["monday_close"] = sanitize_text_field($value['value']);
                            break;
                        case "tuesday_open":
                            $data['tuesday_open'] =sanitize_text_field( $value['value']);
                            break;
                        case "tuesday_close":
                            $data['tuesday_close'] =sanitize_text_field( $value['value']);
                            break;
                        case "wednesday_open":
                            $data['wednesday_open'] =sanitize_text_field( $value['value']);
                            break;
                        case "wednesday_close":
                            $data['wednesday_close'] =sanitize_text_field( $value['value']);
                            break;
                        case "thursday_open":
                            $data['thursday_open'] = sanitize_text_field($value['value']);
                            break;
                        case "thursday_close":
                            $data['thursday_close'] = sanitize_text_field($value['value']);
                            break;
                        case "friday_open":
                            $data['friday_open'] =sanitize_text_field( $value['value']);
                            break;
                        case "friday_close":
                            $data['friday_close'] =sanitize_text_field($value['value']);
                            break;
                        case "saturday_open":
                            $data['saturday_open'] =sanitize_text_field( $value['value']);
                            break;
                        case "saturday_close":
                            $data['saturday_close'] = sanitize_text_field($value['value']);
                            break;
                        case "sunday_open":
                            $data['sunday_open'] =sanitize_text_field( $value['value']);
                            break;
                        case "sunday_close":
                            $data['sunday_close'] = sanitize_text_field($value['value']);
                            break;
                    }
                    
                }
                
                
                
                if(($data['monday_open'] != 'select') || ($data['monday_open'] != 'closed') ):

                $data_hour_temp[0] = array(
                    "openDay" => 'Monday',
                    "closeDay"=> 'Monday',
                    "openTime" => $this->change_time_format($data['monday_open']),
                    "closeTime" => $this->change_time_format($data["monday_close"])
                    );
              endif;
                

              if(($data['tuesday_open'] != 'select') || ($data['tuesday_open'] != 'closed') ):  
                $data_hour_temp[1] = array(
                    "openDay" => 'Tuesday',
                    "closeDay"=> 'Tuesday',
                    "openTime" => $this->change_time_format($data['tuesday_open']),
                    "closeTime" => $this->change_time_format($data["tuesday_close"])
                    
                );
              endif;


               if(($data['wednesday_open'] != 'select') || ($data['wednesday_open'] != 'closed')):  
                $data_hour_temp[3] = array(
                    "openDay" => 'Wednesday',
                    "closeDay" => 'Wednesday',
                    "openTime" => $this->change_time_format($data['wednesday_open']),
                    "closeTime" => $this->change_time_format($data["wednesday_close"])
                    
                );
              endif;
              
              if(($data['thursday_open'] != 'select') || ($data['thursday_open'] != 'closed')):  
                $data_hour_temp[4] = array(
                    "openDay" => 'Thursday',
                    "closeDay" => 'Thursday',
                    "openTime" => $this->change_time_format($data['thursday_open']),
                    "closeTime" => $this->change_time_format($data["thursday_close"])
                    
                );
             endif;


             if(($data['friday_open'] != 'select') || ($data['friday_open'] != 'closed')): 
                $data_hour_temp[5] = array(
                     "openDay" => 'Friday',
                     "closeDay" => 'Friday',
                     "openTime" => $this->change_time_format($data['friday_open']),
                     "closeTime" => $this->change_time_format($data["friday_close"])
                    
                );
              endif;
            


             if(($data['saturday_open'] != 'select') || ($data['saturday_open'] != 'closed')):  
                 $data_hour_temp[6] = array(
                    "openDay"  => 'Saturday',
                    "closeDay" => 'Saturday',
                    "openTime" => $this->change_time_format($data['saturday_open']),
                    "closeTime" => $this->change_time_format($data['saturday_close'])
                );

            endif;


              if(($data['sunday_open'] != 'select') || ($data['sunday_open'] != 'closed')):

                $data_hour_temp[7] = array(
                     "openDay" =>  'Sunday',
                     "closeDay" => 'Sunday',
                     "openTime" => $this->change_time_format($data['sunday_open']),
                     "closeTime" => $this->change_time_format($data['sunday_close'])
                 );

             endif;
                
                 $working_hours = '';
                 foreach($data_hour_temp as $data_sent_to_api){
                  $working_hours .=json_encode($data_sent_to_api,JSON_FORCE_OBJECT).',';
                 }    
                   
               
                $modified_working_hours ='{"periods":['.rtrim($working_hours,",").']}';
            
                
                $data_hour_new['hours']     = (string)$modified_working_hours;



               
                $data_meta_hours   = json_encode($data);
                 $params     = array(
                    'client_id' => $business_client_id,
                    "fields" => $data_hour_new,
                   
                );
                
              
				  $updated_user= $this->llsp_process_request( 'updateclient',$params,'new_api');
               
                
                
                if ($updated_user['success']) {
                    
                    update_post_meta($business_id, '_llsp_business_hours',sanitize_text_field( $data_meta_hours));
                }
            
               
            } elseif ($request_type == 'photos') {{

                      $img_number = $_POST['img_#'];
                    
                    if (!empty($_FILES['logo']['name'])) {

                        if(isset($_POST['business_logo_id'])) {

                            $deleted    = wp_delete_attachment($_POST['business_logo_id']);
                           



                            $logo_image_url  = get_post_meta($business_id, '_llsp_business_logo_image');
                           
                          
                            $params      = array(
                                "client_id" => $business_client_id,
                                "image" => sanitize_text_field($logo_image_url[0]),
                         
                            );
                            
                        $result = $this->llsp_process_request('delimage',$params);


                        }

                        $this->upload_image($_FILES['logo'], 'logo', $business_id, $business_client_id, 0);
                  
                    } else {
                        
                        
                        
                        if (!empty($_FILES['gallery_image']['name'])) {
                            
                            
                            $this->upload_image($_FILES['gallery_image'], 'gallery_image', $business_id, $business_client_id, $img_number);
                      
                            
                        }
                    }
                    
                    
                    
                    
                    
                    
                    
                    
                    
                }
                
            }
   
                elseif ($request_type == 'delete_photo') {
                 
                $image_type = sanitize_text_field($_POST['image_type']);
                $image_url = get_post_meta($business_id, '_llsp_business_' . $image_type);

                

                
                if (!empty($image_url)) {
                delete_post_meta($business_id, '_llsp_business_' . $image_type);
                wp_delete_attachment($_POST['attach_id']);

                $image_name = $image_url[0];

                
                $params  =  array(
                             "client_id" => $business_client_id,
                             "image" => sanitize_text_field($image_name),
                            );
               
              
                            
                  $this->llsp_process_request( 'delimage',$params);
                  
                  $data['business_id'] = $business_id;
                  
                  $this->llsp_business_template('local_listing_pro_attached_images', $data);
           
                    exit;
                    
                }
            }
            
            
            exit;
        }

        function upload_image($image_data, $type, $business_id, $business_client_id, $img_number)
        {
            
            
            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }
                             
            $uploadedfile     = $image_data;
             $upload_overrides = array(
                'test_form' => false,
                'mimes' => get_allowed_mime_types()
            );
            $movefile         = wp_handle_upload($uploadedfile, $upload_overrides);
            if ($movefile && !isset($movefile['error'])) {
                
                
                $moved_file_url = $movefile['url'];
                $filename       = $movefile['file'];
                $parent_post_id = $business_id;
                $filetype       = wp_check_filetype(basename($filename), null);
                $wp_upload_dir  = wp_upload_dir();
                $attachment     = array(
                    'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                    'post_mime_type' =>sanitize_text_field( $filetype['type']),
                    'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
              
                $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);              
                require_once(ABSPATH . 'wp-admin/includes/image.php');         
                $attach_data   = wp_generate_attachment_metadata($attach_id, $filename);

                $attach_data['type'] = 'logo';

                wp_update_attachment_metadata($attach_id, $attach_data);

               if ($type == 'logo') {
                    
                    if (set_post_thumbnail($parent_post_id, $attach_id)) {
                    
                        $im = file_get_contents($moved_file_url);
                        $imdata = base64_encode($im);

                        $img_data['image_code'] = $imdata;
                        
                       


                         $params1        = array(
                            "image"      => $img_data,
                            "client_id"  => $business_client_id,
                            "tag"        => 'logo' ,
                            "image_name" =>  explode('.',basename($filename))[0]  
                           );
                        
                       
                       
                     
                         $result =   $this->llsp_process_request('image_upload',$params1);
                         


                        
                        if ($result['success']) {
                            
                       
                                update_post_meta($business_id, '_llsp_business_logo_image', sanitize_text_field($result['data']['logo']['original']));

                                update_post_meta($business_id, '_llsp_business_logo_thumbnail',sanitize_text_field($result['data']['logo']['thumbnail']));
                                
                            
                            return true;
                            
                        }
               
                    }
                } else {
                    
                    $im     = file_get_contents($moved_file_url);
                    $imdata = base64_encode($im);
                    $img_data['image_code'] = $imdata;

                    settype($img_number, "integer");
                    $img_index = $img_number;
                    
                    $params1   = array(
                        "image" => $img_data,
                        "client_id" => $business_client_id,
                        "tag" =>  "gallery",
                        "image_name" =>  explode('.',basename($filename))[0]);

                    
                  
                   
                     $result =  $this->llsp_process_request('image_upload',$params1);



                    if ($result['success']) {

                     array_shift($result['data']);

                      if(count($result['data']) > 0 ):

                 
                      
                     
                        
                      foreach ($result['data'] as $gallery) {
           
                     if(explode('.',basename($filename))[0].'-'.$business_client_id == explode('.',basename($gallery['original']))[0]){

						$meta_key = '_llsp_business_gallery_image-'.$attach_id;

						update_post_meta($business_id, $meta_key,sanitize_text_field($gallery['original']));
                        break;
                          }

                        }

                      endif;  
                        
                        $data['business_id'] = $business_id;
                   
                             
                        $this->llsp_business_template('local_listing_pro_attached_images', $data);
                      
                        exit;
                    }
                }
                
            } else {
                
                echo $movefile['error'];
                
            }
            
            
        }
        function llsp_create_ticket()
        {
            
            $subject           = sanitize_text_field( $_POST['subject']);
            $message          = sanitize_text_field( $_POST['message']);
            $client_id        = sanitize_text_field( $_POST['business_client_id']);
          
            $params            = array(
                'subject' => $subject,
                'message' => $message,
                'client_id' => $client_id,
              
            );
           
		
			 $result =   $this->llsp_process_request( 'contact',    $params);	
           if($result['success'] )
           {
				$mail['subject']        = 'Thanks for contacting us';
				$mail['customer_email'] = sanitize_email( $_POST['email']);
				$supoort_sender_mail         = $this->llsp_send_mail('new_ticket', $mail);
				$mail_admin['subject']        = 'New support Ticket';
				$mail_admin['sender_email'] =  sanitize_email( $_POST['email']); 
				$mail_admin['message_text'] =     $message ;
				$mail_admin['message_subject'] =     $subject   ;
				$mail_admin['customer_email'] = 'Help@adviceinteractive.com';
				$support_admin_mail = $this->llsp_send_mail('admin_support_ticket', $mail_admin);
				echo $result['success'] ;
				exit;
			}
			else
			{     echo 0;	
					exit ;
			}
            
          }
        
        function llsp_get_client_citations($client_id)
        {

        
            $cont   = array(
                "params" => array(
                    "client_id" => $client_id,
                ),
             
            );
          $result =   $this->llsp_process_request( 'get_citations', $cont );
			return $result;
            
            
            
        }
        
        function get_order_detail($order_id)
        {
            
           
			
            $params     = array("order_id" => $order_id );  
          
          
     
           $order_detail = $this->llsp_process_request("get_order_details",$params);
         
			
           return $order_detail;
            
            
        }
        
        function update_order_detail($saved_business_id, $order_id)
        {
            
           
            $order_data = $this->get_order_detail($order_id);      
           
            $order_progress_status = isset($order_data['data']['progress_status']) ? $order_data['data']['progress_status'] : '';  
            update_post_meta($saved_business_id, '_llsp_buisness_order_id', $order_id);       
            update_post_meta($saved_business_id, '_llsp_business_order_progress_status', $order_progress_status);
		
          
            //$order_progress = isset($order_data['data']['progress']) ? $order_data['data']['progress'] : '';
            $order_progress = '';
			$listing_detail =   array(
                    'Site.cards' => array('link'=> '','submission'=>'','status'=>-3,'comment' => 'Submitted'),
                    'Factual' =>  array('link'=> '','submission'=>'','status'=>-3,'comment'=>'Submitted'),
					 'DnB' => array('link'=> '','submission'=>'','status'=>-3,"comment" => 'Submitted')
                   
                );
            if (!empty($order_progress)) {
                foreach ($order_progress as $key1 => $directory) {
                    foreach ($directory as $key2 => $directory_detail) {
					
                        $listing_details = array();
                        foreach ($directory_detail as $key3 => $value) {
						
                            if ($key3 == 'link') {
                                $listing_details[$key3] = $value;
                            }
                            if ($key3 == 'submission') 
                            {
                                if(isset($value['urlproof']))
								{
                                $listing_details[$key3]    = $value['urlproof'];
								}
								else
								{
								$listing_details[$key3]    = '';
								}
                                $listing_details['status'] = $value['status'];
                                $listing_details['comment'] = $value['comment'];
                            }
                            
                        }
                        
                        
                        $listing_detail[$key2] = $listing_details;
                        
                    }
                    
                    
                }
        			
                $progress_report = json_encode($listing_detail);
                
                update_post_meta($saved_business_id, '_llsp_progress_report', $progress_report);
                $upgraded_progress_report = json_encode(array(
                      'Acxiom' => '', 
                   // 'Yelp' => '', 
                    'Bing' =>'', 
                    //'LocalStack' => '', 
                    'Apple' => '', 
                    'Google Web Search' => '', 
                   // 'FourSquare' => '', 
                   // 'Bing Places' =>'', 
                    'SuperPages' => '', 
                    'BubbleLife' => '', 
                    'CitySquares' => '', 
                    'DexKnows' => '', 
                    //'DnB' => '', 
                    'Verizon411' => '', 
                    'Here Live Maps' => '', 
                    'Bizsheet' =>'', 
                    'Enroll Business' => '', 
                    'N49' => '', 
                    'EZLocal'=> '', 
                    'Wherezit' => '', 
                    'BrownBook' => '', 
                    'US City' => '', 
                    'EBusinessPages' => '', 
                    'Cataloxy' => '', 
                    'Yalwa' =>'', 
                    'HubBiz' => '', 
					'Where To?' => '', 
                    'ExpressBusinessDirectory' =>'', 
                    'ShowMeLocal' => '', 
                    'YelloYello' => '', 
                    'YaSabe' => '', 
                    'OpenDi.us' => '', 
                    'Merchant Circle'=>'', 
                    'Judy\'s Book' => '', 
                    'Bing Web Search' => '', 
                    'Google Public Add' => '', 
                ));
               
             
                
                update_post_meta($saved_business_id, '_llsp_upgraded_progress_report',  $upgraded_progress_report);
                
                 }
            
            else {
                
                
                $upgraded_progress        = json_encode(array(
                        'Acxiom' => '', 
                   // 'Yelp' => '', 
                    'Bing' =>'', 
                    //'LocalStack' => '', 
                    'Apple' => '', 
                    'Google Web Search' => '', 
                   // 'FourSquare' => '', 
                   // 'Bing Places' =>'', 
                    'SuperPages' => '', 
                    'BubbleLife' => '', 
                    'CitySquares' => '', 
                    'DexKnows' => '', 
                    //'DnB' => '', 
                    'Verizon411' => '', 
                    'Here Live Maps' => '', 
                    'Bizsheet' =>'', 
                    'Enroll Business' => '', 
                    'N49' => '', 
                    'EZLocal'=> '', 
                    'Wherezit' => '', 
                    'BrownBook' => '', 
                    'US City' => '', 
                    'EBusinessPages' => '', 
                    'Cataloxy' => '', 
                    'Yalwa' =>'', 
                    'HubBiz' => '', 
					'Where To?' => '', 
                    'ExpressBusinessDirectory' =>'', 
                    'ShowMeLocal' => '', 
                    'YelloYello' => '', 
                    'YaSabe' => '', 
                    'OpenDi.us' => '', 
                    'Merchant Circle'=>'', 
                    'Judy\'s Book' => '', 
                    'Bing Web Search' => '', 
                    'Google Public Add' => '', 
                ));
                $upgraded_progress_report = json_encode($upgraded_progress);
                update_post_meta($saved_business_id, '_llsp_upgraded_progress_report', $upgraded_progress);

                $progress_report = json_encode(array(
                    'Site.cards' => array('link'=> '','submission'=>'','status'=>-3,'comment' => 'Submitted'),
                    'Factual' =>  array('link'=> '','submission'=>'','status'=>-3,'comment'=>'Submitted'),
                     'DnB' => array('link'=> '','submission'=>'','status'=>-3,"comment" => 'Submitted')
                   
                ));




                update_post_meta($saved_business_id, '_llsp_progress_report', $progress_report);
                
                
            }
            
        }
        
        function llsp_process_request($func, $params,$is_new_api = NULL){	

             if($is_new_api == NULL){
                $params["is_new_api"] = 0;
              }else{
                $params["is_new_api"] = 1;
              }

			$url = "http://todd.aig10.net/xtr/". $func;
            $ch  = curl_init();
           

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
            curl_setopt($ch, CURLOPT_POST, True);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            
            $output = curl_exec($ch);
           
        

            curl_close($ch);  
            return json_decode($output, True);
        }
        
        
       
        function llsp_create_upgraded_order($login_user_id, $business_id, $client_id, $card_info, $extra_data)
        {
            $business_status = $extra_data['business_status'];
            $order_id        = '';
            $saved_order     = '';
          
            if ($business_status != 'paused') {
                $params      = array(
                               "client_id" => $client_id,
                               );
                $saved_order = $extra_data['saved_order'];
                $order_id    = $saved_order['data'];
                
                
            }
            
            if ($business_status == 'paused') {
                $order_id    = $extra_data['order_id'];
                $params      = array(
                    "client_id" => $client_id
                );
                $saved_order = $extra_data['saved_order'];
                
                
            }
            if ($saved_order['success'] == 1) {

                $this->update_upgraded_order_detail($business_id, $order_id);

                $address_city         = $card_info['address_city'];
                $country              = $card_info['address_country'];
                $addressline1         = $card_info['address_line1'];
                $address_zip          = $card_info['address_zip'];
                $address_state        = $card_info['address_state'];
                $card_holder_name     = $card_info['name'];
                $customer_id          = $extra_data['customer_id'];
                $subscription_id      = $extra_data['subscription_id'];
                $card_holder_email    = $extra_data['card_holder_email'];
                $billing_start_date   = $extra_data['billing_start_date'];
                $billing_end_date     = $extra_data['billing_end_date'];
                $billing_plan_id      = $extra_data['billing_plan_id'];
                $subscription_created = $extra_data['subscription_created'];
                $subscription_status  = $extra_data['billing_status'];
                update_post_meta($business_id, '_llsp_business_upgraded', true);
                update_post_meta($business_id, '_llsp_business_billing_start_date', sanitize_text_field($billing_start_date));
                update_post_meta($business_id, '_llsp_business_billing_end_date', sanitize_text_field($billing_end_date));
                update_post_meta($business_id, '_llsp_business_subscription_plan_id', $billing_plan_id);
                update_post_meta($business_id, '_llsp_business_subscription_start_date', sanitize_text_field($subscription_created));
                update_post_meta($business_id, '_llsp_business_subscription_status',sanitize_text_field( $subscription_status));
                update_post_meta($business_id, '_llsp_stripe_customer_id', $customer_id);
                update_post_meta($business_id, '_llsp_stripe_subscription_id', $subscription_id);
                update_post_meta($business_id, '_llsp_business_client_status', 'active');
                update_user_meta($login_user_id, '_llsp_user_country',sanitize_text_field( $country));
                update_user_meta($login_user_id, '_llsp_user_city',sanitize_text_field( $address_city));
                update_user_meta($login_user_id, '_llsp_user_state',sanitize_text_field( $address_state));
                update_user_meta($login_user_id, '_llsp_user_address', sanitize_text_field($addressline1));
                update_user_meta($login_user_id, '_llsp_user_zip',sanitize_text_field( $address_zip));
                update_user_meta($login_user_id, '_llsp_user_name',sanitize_text_field( $card_holder_name));
                update_user_meta($login_user_id, '_llsp_user_email', sanitize_email($card_holder_email));
                update_user_meta($login_user_id, '_llsp_user_payment', true);
       
            }
            
            
            
        }
        function update_upgraded_order_detail($business_id, $order_id)
        {
            
            $order_data = $this->get_order_detail($order_id);  
            
              
            $order_progress_status = isset($order_data['data']['progress_status']) ? $order_data['data']['progress_status'] : '';        
            update_post_meta($business_id, '_llsp_buisness_upgraded_order_id', $order_id);        
            update_post_meta($business_id, '_llsp_business_upgraded_order_progress_status', sanitize_text_field($order_progress_status));
            $listing_detail = array();
            $order_progress = isset($order_data['data']['progress']) ? $order_data['data']['progress'] : '';
			$listing_detail =   array(
                  'Acxiom' => array('link'=> '','submission'=>'','status'=>-3), 
                   // 'Yelp' =>  array('link'=> '','submission'=>'','status'=>-3),
                    'Bing' => array('link'=> '','submission'=>'','status'=>-3),
                    //'LocalStack' => array('link'=> '','submission'=>'','status'=>-3),
                    'Apple' => array('link'=> '','submission'=>'','status'=>-3),
                    'Google Web Search' => array('link'=> '','submission'=>'','status'=>-3),
                   // 'FourSquare' => array('link'=> '','submission'=>'','status'=>-3),
                   // 'Bing Places' => array('link'=> '','submission'=>'','status'=>-3),
                    'SuperPages' => array('link'=> '','submission'=>'','status'=>-3),
                    'BubbleLife' => array('link'=> '','submission'=>'','status'=>-3),
                    'CitySquares' => array('link'=> '','submission'=>'','status'=>-3),
                    'DexKnows' => array('link'=> '','submission'=>'','status'=>-3),
                    //'DnB' => array('link'=> '','submission'=>'','status'=>-3),
                    'Verizon411' => array('link'=> '','submission'=>'','status'=>-3),
                    'Here Live Maps' => array('link'=> '','submission'=>'','status'=>-3),
                    'Bizsheet' => array('link'=> '','submission'=>'','status'=>-3),
                    'Enroll Business' => array('link'=> '','submission'=>'','status'=>-3),
                    'N49' => array('link'=> '','submission'=>'','status'=>-3),
                    'EZLocal'=> array('link'=> '','submission'=>'','status'=>-3),
                    'Wherezit' => array('link'=> '','submission'=>'','status'=>-3),
                    'BrownBook' => array('link'=> '','submission'=>'','status'=>-3),
                    'US City' => array('link'=> '','submission'=>'','status'=>-3),
                    'EBusinessPages' => array('link'=> '','submission'=>'','status'=>-3),
                    'Cataloxy' => array('link'=> '','submission'=>'','status'=>-3),
                    'Yalwa' => array('link'=> '','submission'=>'','status'=>-3),
                    'HubBiz' => array('link'=> '','submission'=>'','status'=>-3),
					'Where To?' => array('link'=> '','submission'=>'','status'=>-3),
                    'ExpressBusinessDirectory' => array('link'=> '','submission'=>'','status'=>-3),
                    'ShowMeLocal' => array('link'=> '','submission'=>'','status'=>-3),
                    'YelloYello' => array('link'=> '','submission'=>'','status'=>-3),
                    'YaSabe' => array('link'=> '','submission'=>'','status'=>-3),
                    'OpenDi.us' => array('link'=> '','submission'=>'','status'=>-3),
                    'Merchant Circle'=> array('link'=> '','submission'=>'','status'=>-3),
                    'Judy\'s Book' => array('link'=> '','submission'=>'','status'=>-3),
                    'Bing Web Search' => array('link'=> '','submission'=>'','status'=>-3),
                    'Google Public Add' => array('link'=> '','submission'=>'','status'=>-3),
                   
                );
				
            if (!empty($order_progress)) {
                foreach ($order_progress as $key1 => $directory) {
                    foreach ($directory as $key2 => $directory_detail) {
                        $listing_details = array();
                        
                        foreach ($directory_detail as $key3 => $value) {
                            if ($key3 == 'link') {
                                $listing_details[$key3] = $value;
                            }
                            if ($key3 == 'submission') {
                                $listing_details[$key3]    = isset($value['urlproof'])?$value['urlproof']:'';
                                $listing_details['status'] = $value['status'];
                            }
                            
                            
                        }
                        $listing_detail[$key2] = $listing_details;
                        
                    }
                    
                }
                
                $upgraded_progress_report = json_encode($listing_detail);
                update_post_meta($business_id, '_llsp_upgraded_progress_report', sanitize_text_field($upgraded_progress_report));
                
                
            } else {
				
                $progress_report = json_encode(array(
                   'Acxiom' => '', 
                   // 'Yelp' => '', 
                    'Bing' =>'', 
                    //'LocalStack' => '', 
                    'Apple' => '', 
                    'Google Web Search' => '', 
                   // 'FourSquare' => '', 
                   // 'Bing Places' =>'', 
                    'SuperPages' => '', 
                    'BubbleLife' => '', 
                    'CitySquares' => '', 
                    'DexKnows' => '', 
                    //'DnB' => '', 
                    'Verizon411' => '', 
                    'Here Live Maps' => '', 
                    'Bizsheet' =>'', 
                    'Enroll Business' => '', 
                    'N49' => '', 
                    'EZLocal'=> '', 
                    'Wherezit' => '', 
                    'BrownBook' => '', 
                    'US City' => '', 
                    'EBusinessPages' => '', 
                    'Cataloxy' => '', 
                    'Yalwa' =>'', 
                    'HubBiz' => '', 
					'Where To?' => '', 
                    'ExpressBusinessDirectory' =>'', 
                    'ShowMeLocal' => '', 
                    'YelloYello' => '', 
                    'YaSabe' => '', 
                    'OpenDi.us' => '', 
                    'Merchant Circle'=>'', 
                    'Judy\'s Book' => '', 
                    'Bing Web Search' => '', 
                    'Google Public Add' => '', 
                ));
                update_post_meta($business_id, '_llsp_upgraded_progress_report',sanitize_text_field( $progress_report));
                
            }
            
        }
        
  
        function llsp_get_state_list($template_call = true)
        {
            
            
            $template_call = isset($_POST['load_view']) ? sanitize_text_field($_POST['load_view']) : $template_call;
            $state_list    = array(
                'AL' => "Alabama",
                'AK' => "Alaska",
                'AZ' => "Arizona",
                'AR' => "Arkansas",
                'CA' => "California",
                'CO' => "Colorado",
                'CT' => "Connecticut",
                'DE' => "Delaware",
                'DC' => "District Of Columbia",
                'FL' => "Florida",
                'GA' => "Georgia",
                'HI' => "Hawaii",
                'ID' => "Idaho",
                'IL' => "Illinois",
                'IN' => "Indiana",
                'IA' => "Iowa",
                'KS' => "Kansas",
                'KY' => "Kentucky",
                'LA' => "Louisiana",
                'ME' => "Maine",
                'MD' => "Maryland",
                'MA' => "Massachusetts",
                'MI' => "Michigan",
                'MN' => "Minnesota",
                'MS' => "Mississippi",
                'MO' => "Missouri",
                'MT' => "Montana",
                'NE' => "Nebraska",
                'NV' => "Nevada",
                'NH' => "New Hampshire",
                'NJ' => "New Jersey",
                'NM' => "New Mexico",
                'NY' => "New York",
                'NC' => "North Carolina",
                'ND' => "North Dakota",
                'OH' => "Ohio",
                'OK' => "Oklahoma",
                'OR' => "Oregon",
                'PA' => "Pennsylvania",
                'RI' => "Rhode Island",
                'SC' => "South Carolina",
                'SD' => "South Dakota",
                'TN' => "Tennessee",
                'TX' => "Texas",
                'UT' => "Utah",
                'VT' => "Vermont",
                'VA' => "Virginia",
                'WA' => "Washington",
                'WV' => "West Virginia",
                'WI' => "Wisconsin",
                'WY' => "Wyoming"
            );
            
            if ($template_call == true) {
                $this->llsp_business_template('list_of_states', $state_list);
                exit;
            } else {
                
                return $state_list;
            }
            
        }
        function get_time_options()
        {
            
            
            $time_options = array(
                '1:00 AM',
                '2:00 AM',
                '3:00 AM',
                '4:00 AM',
                '5:00 AM',
                '6:00 AM',
                '7:00 AM',
                '8:00 AM',
                '9:00 AM',
                '10:00 AM',
                '11:00 AM',
                '12:00 PM',
                '1:00 PM',
                '2:00 PM',
                '3:00 PM',
                '4:00 PM',
                '5:00 PM',
                '6:00 PM',
                '7:00 PM',
                '8:00 PM',
                '9:00 PM',
                '10:00 PM',
                '11:00 PM',
                '12:00 AM',
                'closed'
            );
            return $time_options;
            
        }
        function llsp_get_country_list($template_call = true)
        {
            
            
            $template_call = isset($_POST['load_view']) ?sanitize_text_field( $_POST['load_view']) : $template_call;
            $country_list  = array(
                'US' => "USA"
            );
            if ($template_call == true) {
             
                exit;
                
            } else {
                
                return $country_list;
            }
            
        }
        public function delete_upgarded_order($business_id, $user_id, $client_id, $sub_data)
        {

           
            
            $deactivated_status = $sub_data['deactive_status'];
            
            if ($deactivated_status['data'] == 1) {
                
               
                update_post_meta($business_id, '_llsp_business_subscription_ended_at', sanitize_text_field($sub_data['ended_at']));
                update_post_meta($business_id, '_llsp_business_subscription_canceled_at',sanitize_text_field( $sub_data['canceled_at']));
                update_post_meta($business_id, '_llsp_business_upgraded', false);
                update_post_meta($business_id, '_llsp_business_subscription_status', 'inactive');
                
                $upgraded_progress_report = json_encode(array(
                    'Acxiom' => '',
                    'Yelp' => '',
                    'Bing' => '',
                    'LocalStack' => '',
                    'Apple' => '',
                    'Google Web Search' => '',
                    'FourSquare' => '',
                    'Bing Places' => '',
                    'SuperPages' => ''
                ));
                update_post_meta($business_id, '_llsp_upgraded_progress_report',sanitize_text_field( $upgraded_progress_report));
                update_post_meta($business_id, '_llsp_business_client_status', 'paused');
                update_user_meta($user_id, '_llsp_user_payment', false);
                
                
            }
            
        }
        
        public function llsp_business_template($template_name, $data = array())
        {
            
            
            $result = $data;
            require_once(local_listing_pro_path . '/templates/' . $template_name . '.php');
            
        }
        
        public function llsp_session_start()
        {
            session_start();
            
        }
        
        public function llsp_business_template_file($template_name, $data)
        {
            ob_start();
            require_once(local_listing_pro_path . '/templates/' . $template_name . '.php');
            return ob_get_clean();
        }
        
        
    }
}
?>
