
<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$business_info=isset($result['business_info'])?$result['business_info']:'' ;
$state_list=isset($result['states'])?$result['states']:'' ;
$payment=isset($result['payment'])?$result['payment']:'' ;
$status=isset($result['status'])?$result['status']:'' ;
$llsp_business_id=isset($result['business_id'])?$result['business_id']:'';
$country_list=isset($result['countries'])?$result['countries']:'' ;
$business_country=isset($business_info['_llsp_business_country'][0])?$business_info['_llsp_business_country'][0]:'';
$business_state=isset($business_info['_llsp_business_state'][0])? $business_info['_llsp_business_state'][0]:'' ;
$thumbnail_id=isset($business_info['_thumbnail_id'][0])?$business_info['_thumbnail_id'][0]:'';
$logo_thumbnail_url= wp_get_attachment_url($thumbnail_id);
$business_phone=isset($business_info['_llsp_business_phone'][0])?$business_info['_llsp_business_phone'][0]:'';
$business_website=isset($business_info['_llsp_business_website'][0])?$business_info['_llsp_business_website'][0]:
'';
$business_email=isset($business_info['_llsp_business_email'][0])?$business_info['_llsp_business_email'][0]:
'';
$business_street=isset($business_info['_llsp_business_street'][0])?$business_info['_llsp_business_street'][0]:
'';

$business_city=isset($business_info['_llsp_business_city'][0])?$business_info['_llsp_business_city'][0]:
'';

$business_state=isset($business_info['_llsp_business_state'][0])?$business_info['_llsp_business_state'][0]:
'';
$business_zipcode=isset($business_info['_llsp_business_zipcode'][0])?$business_info['_llsp_business_zipcode'][0]:
'';

if($business_street!='' && $business_city!=''  && $business_state!=''   && $business_zipcode!='' )
{
$address=$business_street.', '.$business_city.', '.$business_state.', '.$business_zipcode;
}
else
{
$address='';
}


?>

 <!------------------------------------------- Left Tab end here--------------------------------------->
            <div class="pre_loader">
			</div>
          <div class="col-xs-12 col-sm-10 col-md-10 tab_box">
			  
		<div class="tab-content">  
			
			 <span class="headtitle img-responsive">
						<Img class="thumbnail_img" src="<?php echo !empty($logo_thumbnail_url)?$logo_thumbnail_url:local_listing_pro_url.'images/no-image-icon.png'?>" ></span>
						<span class="addres_user">
						<label class="firm_name">
                     <?php 
                      echo  isset($business_info['_llsp_business_name'][0])?$business_info['_llsp_business_name'][0]:''; 
                      ?></label>
						<p><?php	echo "Address:- ".esc_attr($address) ?> </p>
						<p><?php 	echo "Phone:- ".esc_attr($business_phone) ?></p>
						<p><?php 	echo "Website:- ".esc_attr($business_website) ?></p>
						<p><?php 	echo "Email:- ".esc_attr($business_email) ?></p>
                    </span> 
                
				<form class="form_data" id="llsp_submit_form" name="llsp_submit_form">
			<input type="hidden" value="<?php echo $business_info['_llsp_business_client_id'][0] ?>" name="_llsp_business_client_id" />
			<input type="hidden" value="<?php echo $llsp_business_id ?>" name="_llsp_business_id" />
				<div class="col-xs-12 col-md-12">
					
					<span style="font-size:15px;color:#487CA4">
						
						By filling out the Business Details in full will enhance your business listings across the internet.  The benefit of having more data will help users understand more about your business like hours and a business description. Also this helps with rankings within the search engines. 
						
						<?php
					 if ($payment && $status == "active") 
						{
							
						echo 'Business is upgraded <a href="?page=upgrade_business">check billing status</a>';
					}
				
						?>
					
					</span>
						
				</div>
			<div class="col-xs-12 col-md-12">
      		<h3 class="main_form_headings">
			<i class="fa fa-building" aria-hidden="true"></i>
					Business Details.
				</h3>
			</div>
        <div class="input-group col-xs-12 col-md-12">
			
            <input  data-validation-error-msg="Field is required" data-validation="required"  name="_llsp_business_name" type="text" value="<?php echo isset($business_info['_llsp_business_name'][0])?esc_attr($business_info['_llsp_business_name'][0]):'' ?>" class="form-control col-L" placeholder="Business Name" />
				<span class="asterisk_input_bus"> </span>
        </div>                
        
        <div class="input-group col-xs-12 col-md-12">
            <input name="_llsp_business_street" data-validation-error-msg="Field is required"  data-validation="required" type="text"  value="<?php echo isset($business_info['_llsp_business_street'][0])?esc_attr($business_info['_llsp_business_street'][0]):'' ?>"  class="form-control col-L" placeholder="Enter Your Business Address" />
        <span class="asterisk_input_bus"> </span>
        </div>    
            
        <div class="input-group col-xs-12 col-md-12">    
            <input data-validation-error-msg="Field is required"  data-validation="required" name="_llsp_business_city" type="text" value="<?php echo isset($business_info['_llsp_business_city'][0])?esc_attr($business_info['_llsp_business_city'][0]):'' ?>" class="form-control col-R" placeholder="Enter Your Business City" />
       <span class="asterisk_input_bus"> </span>
        </div>
       
        
        
        <div class="col-sm-6 col-md-6 col-xs-12 select_Div">
         <select data-validation-error-msg="Field is required"  name="_llsp_business_state" id="options" value="<?php echo esc_attr($business_state) ?>"  placeholder="Zipcode"  class="form-control select_box2">
				<?php
				$selected='';
				 echo '<option value="select"> Select State </option>';
				foreach($state_list as $state_abbr=>$state)
					{	if( $state_abbr==$business_state)
						{
						$selected='selected';
						}
	              
						echo '<option '.esc_attr($selected).' value="'.esc_attr($state_abbr).'">'.esc_attr($state).'</option>';
					    $selected='';
					}
				?>    
          
        </select>
        <div class="cl-sec"> <span class="caret"></span></div>
        </div>
        
        <div class="col-sm-6 col-md-6 col-xs-12  select_Div2">
       
         <input type="text"  data-validation-error-msg="Field is required" data-validation="required"  name="_llsp_business_zipcode" value="<?php echo isset($business_info['_llsp_business_zipcode'][0])?esc_attr($business_info['_llsp_business_zipcode'][0]):'' ?>" class="form-control col-L pull-right" placeholder="Zipcode" />  
        <span class="asterisk_input_bus"> </span>
        </div>
        
        <div class="input-group col-xs-12 col-md-12 select_Div">
       
        <select data-validation-error-msg="Field is required"  name="_llsp_business_country" id="options" value="<?php echo esc_attr($business_country) ?>"    class="form-control select_box">
           <?php
				  $selected='';
				 echo '<option value="select">Select Country</option>';
				foreach($country_list as $country_abbr=>$country)
					{
						if($country_abbr==$business_country)
						{
							$selected='selected';
						}
						echo '<option '.esc_attr($selected) .' value="'.esc_attr($country_abbr).'">'.esc_attr($country).'</option>';
						$selected='';
					}
					
				?>  
           
        </select>
        <div class="cl-sec2"> <span class="caret"></span></div>
        </div>
        
        
       
       <div class="input-group col-xs-12 col-md-12">
		   
        <input type="text"  data-validation-error-msg="Field is required" data-validation="required"  name="_llsp_business_phone" value="<?php echo isset($business_info['_llsp_business_phone'][0])?esc_attr($business_info['_llsp_business_phone'][0]):'' ?>" class="form-control col-M pull-left" placeholder="Business Phone Number" />  
      <span class="asterisk_input_bus"> </span>
       
        </div>
       
        
      
        <div class="input-group col-xs-12 col-md-12 ">
            <input type="text"  data-validation-error-msg="Url Invalid. Please add valid url format  http://example.com/" data-validation="url" name="_llsp_business_website" value="<?php echo isset($business_info['_llsp_business_website'][0])?esc_attr($business_info['_llsp_business_website'][0]):'' ?>" class="form-control col-L" placeholder="http://www.coastalclc.com/" />
			<span class="asterisk_input_bus"> </span>
        </div>    
            
        <div class="input-group col-xs-12 col-md-12 ">    
            <input data-validation="email" data-validation-error-msg="Email Invalid. Please add valid email format abc@example.com"  name="_llsp_business_email" type="text" value="<?php echo isset($business_info['_llsp_business_email'][0])?esc_attr($business_info['_llsp_business_email'][0]):'' ?>" class="form-control col-R" placeholder="abc@example.com" />
        <span class="asterisk_input_bus"> </span>
        </div>
    

 	<div class="magin-hr"></div> <!--------------------------margin-hr-->
               
        <div class="col_M_full">
 
    	<h3 class="main_form_headings">
				<i class="fa fa-info-circle" aria-hidden="true"></i>
				Contact Info.
				</h3>         
        <div class="input-group col-sm-6 col-md-6 col-xs-12 select_F1">
			        	
        
            
            <input  data-validation-error-msg="Field is required" data-validation="required"  type="text" name="_llsp_business_contact_name" value="<?php echo isset($business_info['_llsp_business_contact_name'][0])?esc_attr($business_info['_llsp_business_contact_name'][0]):'' ?>" class="form-control col-L" placeholder="Contact Name" />
            
			<span class="asterisk_input_bus"> </span>
      
        </div>    
            
        <div class="input-group col-sm-6 col-md-6 col-xs-12 select_F2">    
		
            <input type="text"  name='_llsp_business_contact_position'  value="<?php echo isset($business_info['_llsp_business_contact_position'][0])?esc_attr($business_info['_llsp_business_contact_position'][0]):'' ?>" class="form-control col-R" placeholder="Contact Position" />
     
       </div>
        </div>
        
		<div class="magin-hr"></div> <!--------------------------margin-hr-->
        
        
        
    	<h3 class="main_form_headings">
				<i class="fa fa-info-circle" aria-hidden="true"></i>
				Additional Info.
				</h3>
		<div class="input-group col-xs-12 col-md-12">
			
            
            
            <input type="text" data-validation="required" data-validation-error-msg="Field is required"  name='_llsp_business_category' value="<?php echo isset($business_info['_llsp_business_category'][0])?esc_attr($business_info['_llsp_business_category'][0]):'' ?>" class="form-control col-L" placeholder="Business Category" />
             
             
 
             
        
             <span class="asterisk_input_bus"> </span>
     
        </div>
		<div class="input-group col-xs-12 col-md-12">

            
             <textarea data-validation-error-msg="Minimum 250 character is required" rows="5" data-validation="length" data-validation-length="min250" name="_llsp_business_description"  class="text_desc col-L" placeholder="Business Description Maximum Length 250 Words"><?php echo isset($business_info['_llsp_business_description'])?esc_attr($business_info['_llsp_business_description'][0]):''  ?> </textarea>
         
            <span id="word_left" ></span>
        </div>
  	  <div class="input-group details_button_box col-sm-6 col-md-6 col-xs-12">
     <button class="btn btn-default orange_btn ls_submit_site_btn" type="button" >Save Changes</button> 
  
    
    </div>
    
       <div class="result_message"  >  
	
		  </div>         
                 </form>        
            
                 <!--form content-->  
		</div><!--tab content-->  

     
  
       </div><!--tab box-->
       
     </div>  
  </section>

 
  
  
  
  


