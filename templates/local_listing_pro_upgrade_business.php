<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$business_info=isset($result['business_info'])?$result['business_info']:'' ;
$state_list=isset($result['states'])?$result['states']:'' ;
$llsp_business_id=isset($result['business_id'])?$result['business_id']:'';
$country_list=isset($result['countries'])?$result['countries']:'' ;
$business_country=isset($business_info['_llsp_business_country'][0])?$business_info['_llsp_business_country'][0]:'';
$business_state=isset($business_info['_llsp_business_state'][0])? $business_info['_llsp_business_state'][0]:'' ;
$business_city=isset($business_info['_llsp_business_city'][0])? $business_info['_llsp_business_city'][0]:'' ;
$business_address=isset($business_info['_llsp_business_street'][0])? $business_info['_llsp_business_street'][0]:'' ;
$business_zipcode=isset($business_info['_llsp_business_zipcode'][0])? $business_info['_llsp_business_zipcode'][0]:'' ;
$business_email=isset($business_info['_llsp_business_email'][0])? $business_info['_llsp_business_email'][0]:'' ;
$user_info=isset($result['user_info'])?$result['user_info']:'' ;
$user_country=isset($user_info['_llsp_user_country'])?$user_info['_llsp_user_country'][0]:(!empty($business_country)?$business_country:'');
$user_name=isset($user_info['_llsp_user_name'])?$user_info['_llsp_user_name'][0]:'';
$user_email=isset($user_info['_llsp_user_email'])?$user_info['_llsp_user_email'][0]:(!empty($business_email)?$business_email:'');
$user_zip=isset($user_info['_llsp_user_zip'])?$user_info['_llsp_user_zip'][0]:(!empty($business_zipcode)?$business_zipcode:'');
$user_address=isset($user_info['_llsp_user_address'])?$user_info['_llsp_user_address'][0]:(!empty($business_address)?$business_address:'');
$user_state=isset($user_info['_llsp_user_state'])?$user_info['_llsp_user_state'][0]:(!empty($business_state)?$business_state:'');
$user_city=isset($user_info['_llsp_user_city'])?$user_info['_llsp_user_city'][0]:(!empty($business_city)?$business_city:'');
$business_status =isset($business_info['_llsp_business_client_status'][0])?$business_info['_llsp_business_client_status'][0] : '';

?>

 <!------------------------------------------- Left Tab end here--------------------------------------->
          
          <div class="response_container">
			  
           <div class="pre_loader">
			</div>
          <div class="col-xs-12 col-sm-10 col-md-10 tab_box">
			  
           <div class="tab-content">                      
             <form class="form_data" id="llsp_submit_form" name="llsp_submit_form">
			
			<input type="hidden" value="<?php echo  esc_attr($business_info['_llsp_business_client_id'][0]) ?>" name="_llsp_business_client_id" />
			<input type="hidden" value="<?php echo esc_attr($llsp_business_id) ?>" name="_llsp_business_id" />
			<input type="hidden" value="<?php echo esc_url(get_site_url()) ?>" name="_llsp_request_url" />
				<?php
      			if ( ($business_status == "paused" || $business_status == "inactive")) 
					
					{
						?>
							<div class="col-xs-12 col-md-12">
					
					<span style="font-size:15px;color:#487CA4">
					 
					 Upgrade to Premium to unlock even more directories and data aggregators. By upgrading you will
					 have your business submitted to top online business directories. Additionaly you will get the Local Safeguard monthly check to make sure your business data is correct, current and has not been deleted or overwitten by other sources. Its only $5.99 month. Upgrade now!
					
					</span>
						
				</div>
				
				
				<?php
						}
				
				?>
      
       <div class="col-xs-12 col-md-12">
      		<h3 class="main_form_headings">
			<i class="fa fa-building" aria-hidden="true"></i>
					User Details
				</h3>
       </div>
        <div class="input-group col-xs-12 col-md-12">
			
            <input  data-validation-error-msg="Field is required" data-validation="required"  name="_llsp_card_input_name" type="text" value="<?php echo esc_attr($user_name) ?>" class="form-control col-L" placeholder="Card Holder Name" />
        </div>                
        
        <div class="input-group col-xs-12 col-md-12">
            <input name="_llsp_card_input_street" data-validation-error-msg="Field is required"  data-validation="required" type="text"  value="<?php echo esc_attr($user_address) ?>"  class="form-control col-L" placeholder="Address" />
        </div>    
            
        <div class="input-group col-xs-12 col-md-12">    
            <input data-validation-error-msg="Field is required"  data-validation="required" name="_llsp_card_input_city" type="text" value="<?php echo esc_attr($user_city) ?>" class="form-control col-R" placeholder="City" />
        </div>
       
        
        
        <div class="col-sm-6 col-md-6 col-xs-12 select_Div">
         <select data-validation-error-msg="Field is required"  name="_llsp_card_input_state" id="options" value="<?php echo $user_state ?>"  placeholder="Zipcode"  class="form-control select_box2">
				<?php
				$selected='';
				 echo '<option value="select"> Select State </option>';
				foreach($state_list as $state_abbr=>$state)
					{	if( $state_abbr==$user_state)
						{
						$selected='selected';
						}
	              
						echo '<option '.$selected.' value="'.esc_attr($state_abbr).'">'.esc_attr($state).'</option>';
					    $selected='';
					}
				?>    
          
        </select>
        <div class="cl-sec"> <span class="caret"></span></div>
        </div>
        
        <div class="col-sm-6 col-md-6 col-xs-12  select_Div2">
       
         <input type="text"  data-validation-error-msg="Field is required" data-validation="required"  name="_llsp_card_input_zipcode" value="<?php echo esc_attr($user_zip) ?>" class="form-control col-L pull-right" placeholder="Zipcode" />  
        
        </div>
        
        <div class="input-group col-xs-12 col-md-12 select_Div">
       
        <select data-validation-error-msg="Field is required"  name="_llsp_card_input_country" id="options" value=""    class="form-control select_box">
           <?php
				  $selected='';
				  echo '<option value="select">Select Country</option>';
				foreach($country_list as $country_abbr=>$country)
					{
						if($country_abbr==$user_country)
						{
							$selected='selected';
						}
						echo '<option '.$selected .' value="'.esc_attr($country_abbr).'">'.esc_attr($country).'</option>';
						$selected='';
					}
					
				?>  
           
        </select>
        <div class="cl-sec2"> <span class="caret"></span></div>
        </div>
        
        
        <div class="input-group col-xs-12 col-md-12 ">
			
			  <input type="text"  data-validation-error-msg="Field is required" data-validation="email"  name="_llsp_card_input_email" value="<?php echo esc_attr($user_email) ?>" class="form-control col-L pull-right" placeholder="email" /> 
			
			</div>
       
       
        
      
  
            
     

 	<div class="magin-hr"></div> <!--------------------------margin-hr-->
               
      
 
    	<h3 class="main_form_headings">
				<i class="fa fa-info-circle" aria-hidden="true"></i>
				Card details
				</h3>     
				<div class="col_M_full">    
				<div class="input-group col-sm-6 col-md-6 col-xs-12 select_F1">        	
            <input  data-validation="required" data-validation-error-msg="Field is required" type="text" name="_llsp_card_input_number" value="" class="form-control col-L" placeholder="Card Number" />
        </div>    
            
				<div class="col-sm-6 col-md-6 col-xs-12 select_f2">    
			<select data-validation="required" data-validation-error-msg="Field is required"  name="_llsp_card_input_month" value="" class="form-control " placeholder="" >
			<option>01</option>
			<option>02</option>
			<option>03</option>
            <option>04</option> 
            <option>05</option>
            <option>06</option>
            <option>07</option>
            <option>08</option>
            <option>09</option>
            <option>10</option>
            <option>11</option> 
            <option>12</option>          
          </select>
        </div>
				</div>
		<div class="col_M_full"> 
		<div class="input-group col-sm-6 col-md-6 col-xs-12 select_F1">        	
            <select  data-validation="required" data-validation-error-msg="Field is required" name="_llsp_card_input_year" id="upgr_years" value="" class="form-control col-L" placeholder="" >
				</select>
        </div>    
            
        <div class="input-group col-sm-6 col-md-6 col-xs-12 select_f2">    
            <input type="text"  data-validation-error-msg="Field is required"  data-validation="required" name='_llsp_card_input_cvv'  value="" class="form-control col-R" placeholder="CVV" />
        </div>
        </div>
        

      
     <button class="btn btn-default orange_btn llsp_upgrade_btn" type="button" >Upgrade to Premium</button> 
         
       <div class="result_message" >  
		</div>         
  
     
  </form>        
                     
		</div><!--tab content-->  

     
  
       </div><!--tab box-->
       </div>
    
  </section>

 
  
  
  
  


