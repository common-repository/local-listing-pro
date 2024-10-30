<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

   if( !isset($_SESSION['searched_business_list']))
   {
  
		$searched_business_list=isset($result['searched_business'])?$result['searched_business']:'';
		$_SESSION['searched_business_list'] = $searched_business_list;


	}
	else
	{
		$searched_business_list=$_SESSION['searched_business_list'];
		$business=$_POST['selected_business'];
		$business_list=$searched_business_list[$business];
		
	}
  
	
		$state_list=isset($result['states'])?$result['states']:'';
		$country_list=isset($result['countries'])?$result['countries']:'';
		$business_time= isset($result['time_options'])?$result['time_options']:'';
			
	
?>


<!-------------------------------------------------------------Business_info start------------------------------------------------------------>  
  
  
 
  <section class="business_info search_section">
  	<div class="custom_container">
    	<div class="col-xs-12 col-sm-12 col-md-12 logo2"><a href="#"><img src="<?php echo local_listing_pro_url ?>images/local_listing_pro.png" class="img-responsive" alt="logo"></a></div> 
          <div class="col-xs-12 col-sm-12 col-md-12 tab_box custom_tabs">
            <div id="tab" class="btn-group" >
                  <a href="#" class="btn btn-large btn-info active" >1. Verify Business Information</a>
                  <a href="#" class="btn btn-large btn-info border-lhs-rhs" >2. Free Directory Submission</a>
                  <a href="#" class="btn btn-large btn-info" >3. Upgrade to Premium</a>
                </div>
                
                <div class="tab-content">
                  <div class="tab-pane active" id="business">
                  <h1>Just steps away!</h1>
                  <p>You’re just steps away from your free local directory submission. If your business already exists, click from the choices below to pre-populate our form. If not, just continue completing the form to get the most accurate listing possible.</p>
                 <?php
                  if($searched_business_list=='')
				{
					?>
					
					<div class="no_rcords">
						No results Found
					</div>
				
					
					<?php
				}
			else
			{
				?>
                 <ul class="choose_list">
					   <?php
			
					$temp_searched_business_list=array();
					foreach($searched_business_list as $sb_key=>$sb_value)
					{	
						foreach($sb_value as $sb_item_key=>$sb_item)
						{     
	
							$temp_searched_business_list[$sb_item_key]=$sb_item;
						}
			
		
			
			

?>
<?php
			$business_name=isset($temp_searched_business_list['business_name'])?$temp_searched_business_list['business_name']:'';
			$business_street=isset($temp_searched_business_list['street'])?$temp_searched_business_list['street']:'';
			$business_state=isset($temp_searched_business_list['state'])?$temp_searched_business_list['state']:'';
			$business_zipcode=isset($temp_searched_business_list['zipcode'])?$temp_searched_business_list['zipcode']:'';
			$business_phone=isset($temp_searched_business_list['phone'])?$temp_searched_business_list['phone']:'';
			$business_website=isset($temp_searched_business_list['website'])?$temp_searched_business_list['website']:'';
		
   
?>
                  <li class="business_li">
                      <div class="inner-box active_box">
                        <div class="checkbox checkbox-circle check_lhs">
                            <input id="checkbox7" disabled  name="llsp_searched_item" value="<?php echo esc_attr($sb_key) ?>" class="styled checkbox7" type="radio">
                            <label for="checkbox7" ></label>
                        </div>
                      <div class="list-content">
                      <h2><?php echo esc_attr($business_name) ?></h2>
                      <p><?php echo esc_attr($business_street).','. esc_attr($business_state).','.esc_attr($business_zipcode).'<br>'.esc_attr($business_phone); ?></p>
                      <a href="#"><?php echo  esc_url($business_website) ?></a>
                      </div>
                      </div>
                  </li>    
                 <?php

}
}
?>

                   
                  </ul>
                                  
                </div>
                  <div class="tab-pane" id="Submission"></div>
                  <div class="tab-pane" id="Upgrade"></div>     
            
<!----------------------------------------------------form----------------------------------------------------------->    
 

<form class="form_data mar_up" name="llsp_submit_form">
	<div class="submit_tab_1">
	<h3 class="main_form_headings">
				<i class="fa fa-building" aria-hidden="true"></i>
					Business Details.
					</h3>
	
 	<div class="input-group col_M_full col-xs-12 col-md-12">
    	<input data-validation-error-msg="Field is required" data-validation="required" type="text" name="llsp_submit_field_business_name" value="<?php  echo isset( $business_list['business_name'])?esc_attr( $business_list['business_name']):''; ?>" class="form-control" placeholder="Business Name" />
    	<span class="asterisk_input_bus"> </span>
    </div>                
  
    <div class="input-group col_M_full col-md-12 col-xs-12 ">
    	<input data-validation-error-msg="Field is required" data-validation="required" type="text"  name="llsp_submit_field_street"  value="<?php echo isset( $business_list['street'])? esc_attr($business_list['street']):''; ?>" class="form-control" placeholder="Business Address" />
    		<span class="asterisk_input_bus"> </span>
    </div>    
       <div class="col_M_full">  
    <div class="input-group  col-sm-6 col-md-6 col-xs-6 select_F1">    
    	<input data-validation-error-msg="Field is required"  data-validation="required" type="text" name="llsp_submit_field_city" value="<?php echo isset( $business_list['city'])? esc_attr($business_list['city']):''; ?>" class="form-control col-R" placeholder="Business City" />
    		<span class="asterisk_input_bus"> </span>
    </div>
   
   
    
    <div class="input-group  col-sm-6 col-md-6 col-xs-6 select_F2">
    <select data-validation-error-msg="Field is required" data-validation="required" value="<?php echo isset( $business_list['country'])?esc_attr( $business_list['country']):''; ?>" id="options"  name="llsp_submit_field_country"   class="form-control select_box">
       
         <?php 
				 $selected='';
				 echo	'<option value="">Select</option>';
			foreach($country_list as $cntry_abbr=>$cntry)
			{	
				 $selected='';
				if( $cntry_abbr==$business_list['country'])
				{
					 $selected='selected';
				}
			?> 
			<option <?php echo  $selected ?> value=" <?php echo $cntry_abbr ?>"><?php echo $cntry ?></option>
			<?php
		   }
			?>
        
    </select>
    
    		<span class="asterisk_input_bus"> </span>
    </div>
    </div>
       <div class="col_M_full">  
    <div class="input-group  col-sm-6 col-md-6 col-xs-6 select_F1 select_Div2">
    <select data-validation-error-msg="Field is required" data-validation="required"  value="<?php echo isset( $business_list['state'])?esc_attr( $business_list['state']):''; ?>" name="llsp_submit_field_state" id="options"  class="form-control select_box2">
       <?php
						$selected='';
							 echo	'<option value="">Select</option>';
					foreach( $state_list as $state_abbr=>$state)
							{
								if($state_abbr==$state_abbr_key)
								{
									$selected='selected';
								}
	
							echo '<option  '.esc_attr($selected) .' value="'.esc_attr($state_abbr).'">'.esc_attr($state).'</option>';
							$selected='';
							
							}

       
       ?>
       
    		
    </select>
   <span class="asterisk_input_bus"> </span>
    </div     <div class="input-group col_M_full col-md-12 col-xs-12">

    
    <div class="input-group  col-sm-6 col-md-6 col-xs-6 select_F2 select_Div">
    <input data-validation-error-msg="Field is required" data-validation="required" name="llsp_submit_field_zipcode" type="text" value="<?php echo isset( $business_list['zipcode'])?esc_attr($business_list['zipcode']):''; ?>" class="form-control col-M pull-right" placeholder="Enter Business Zip Code" />  
    		<span class="asterisk_input_bus"> </span>
 	</div>
 	
    </div>
    
   
    <div class="input-group col_M_full col-md-12 col-xs-12 select_Div">
		
    <input  data-validation-error-msg="field is required" data-validation="required" name="llsp_submit_field_phone" type="text"  value="<?php echo isset( $business_list['phone'])? esc_attr($business_list['phone']):''; ?>" class="form-control" placeholder="(444) 444-4444" />  
       		<span class="asterisk_input_bus"> </span>
 	</div>
   
    
    <div class="input-group col_M_full col-md-12 col-xs-12">
    	<input data-validation-error-msg="Url Invalid. Please add valid url format  http://example.com/"  data-validation="url" name="llsp_submit_field_website" type="text" value="<?php echo isset( $business_list['website'])? esc_url($business_list['website']):''; ?>" class="form-control" placeholder="http://example.com/" />
    	   		<span class="asterisk_input_bus"> </span>
    </div>
    
     <div class="input-group col_M_full col-md-12 col-xs-12">
    	<input data-validation-error-msg="Email Invalid. Please add valid email format abc@example.com" data-validation="email"  name="llsp_submit_field_email" type="text" value="<?php echo isset( $business_list['email'])? esc_attr($business_list['email']):''; ?>" class="form-control" placeholder="abc@example.com" />
    	<span class="asterisk_input_bus"> </span>
    </div>
    
    
    	<hr class="form_sep">
    	<h3 class="main_form_headings">
				<i class="fa fa-info-circle" aria-hidden="true"></i>
				Additional Information.
				</h3>
				<div class="input-group col_M_full col-md-12 col-xs-12">
    	
		  
            <input  data-validation-error-msg="Field is required" data-validation="required"  type="text" name="_llsp_business_contact_name" value="<?php echo isset($business_list['owner'])?esc_attr($business_list['owner']):'' ?>" class="form-control col-L" placeholder="Contact Name" />
            <span class="asterisk_input_bus"> </span>
            
			</div>
      <div class="input-group col_M_full col-md-12 col-xs-12">
    	
		<textarea  data-validation-error-msg="Minimum 250 character is required" rows="5" data-validation="length" data-validation-length="min250"  name="_llsp_business_description"  class="text_desc col-L" placeholder="Business Description Maximum Length 250 Words"></textarea>    
		 <span id="word_left" ></span>	   	
    </div>
     <div class="input-group col_M_full col-md-12 col-xs-12">
		 
    	<input  data-validation-error-msg="Please add Category" data-validation="required"  name="_llsp_business_category" type="text" value="" class="form-control" placeholder="Business Category" />
      	<span class="asterisk_input_bus"> </span>
      	
    </div>
    
			<hr class="form_sep">
				<h3 class="main_form_headings">
				<i class="fa fa-picture-o" aria-hidden="true"></i>
				Business Logo.
				</h3>
			<div class="col_M_full col-xs-12 col-md-12"	>		
		  <div class="upload_box">
			
		   <img id="logo" class="img-responsive drop_image" src="<?php echo !empty( $logo_thumbnail_url)?$logo_thumbnail_url:local_listing_pro_url.'images/no-image-icon.png'  ?>" alt="your image" />
				<span id="fileselector">
					
					<label class="btn btn-default logo_btn red " for="upload-file-selector">
			
					<input data-validation="extension" data-validation-allowing="jpg, png, gif"  data-validation-max-size="2M" id="upload-file-selector"  class="logo-file-selector" style="display:none" image_type='logo'  name="logo"  type="file">
            
					Upload Logo
					
				</label>
			</span>	
		   
	
		</div>
		</div>
				<hr class="form_sep">
			<h3 class="main_form_headings">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
							Business Hours.
					</h3> 
				<div class="submit_business_hours">
					
			 
			 <div class="col_M_full col-md-12 col-xs-12">
					
                   <label class="col-sm-2" for="tuesday"></label>
                 <div class="col-sm-5">
                    Open
                 </div>
                 <div class="col-sm-5">
                    Close
                 </div>
				</div>
			<div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2" for="tuesday">Monday</label>
                 <div class="col-sm-5">
               <select  placeholder="Monday Open Hour"  name="monday_open"  id="monday" class="form-control" >
                    <?php 
                    $selected='';
                    echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						
					}
					
                    
                    ?>
                   
                    </select>
                
				</div>
           <div class="col-sm-5">
      
                    <select  type="text"  placeholder="Tuesday Close Hour" name="monday_close"  id="monday" class="form-control" >
                       <?php 
                     $selected='';
                  echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						
					}
					
                    
                    ?>
                   
                    </select>
                
               </div>
            </div>
            <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="tuesday">Tuesday</label>
                 <div class="col-sm-5 hour_div">
					 
                    <select   placeholder="Tuesday Open Hour"  name="tuesday_open"  id="tuesday" class="form-control" >
                       <?php 
                    
                    $selected='';
                   echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                   
                    </select>
                       		
                     	
				</div>
           <div class="col-sm-5 hour_div">
      
                    <select   placeholder="Tuesday Close Hour" name="tuesday_close" id="tuesday" class="form-control" >
                      <?php 
                    
                     $selected='';
                    echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
                    
                    ?>
                    
                      </select>
                      		
                    
               </div>
            </div>
            <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="Wednesday">Wednesday</label>
                 <div class="col-sm-5 hour_div">
                    <select  placeholder="Wednesday Open Hour"  name="wednesday_open"  id="wednesday" class="form-control" >
                      <?php 
                    $selected='';
                   echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value
						).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                    
                     </select>
                       		
                    
				</div>
           <div class="col-sm-5 hour_div">
      
                    <select   placeholder="Wednesday Close Hour" name="wednesday_close" id="wednesday" class="form-control" >
                      <?php 
                    
                     $selected='';
                     echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
                    
                    ?>
                     </select>
                       		
               </div>
            </div>
            <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="Wednesday">Thursday</label>
                 <div class="col-sm-5 hour_div">
                    <select  placeholder="Thursday Open Hour"  name="thursday_open"  id="thursday" class="form-control" >
                      <?php 
                    
                     $selected='';
                   echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                     		  
				</div>
           <div class="col-sm-5 hour_div">
      
                    <select    placeholder="Thursday Close Hour" name="thursday_close" id="thursday" class="form-control" >
                      <?php 
                    
                    $selected='';
                    echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                     		 
               </div>
            </div>
             <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="friday">Friday</label>
                 <div class="col-sm-5 hour_div">
                    <select   placeholder="Friday Open Hour"  name="friday_open"  id="friday" class="form-control" >
                      <?php 
                    
                   $selected='';
                    echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                        	
				</div>
            <div class="col-sm-5 hour_div">
      
                    <select     placeholder="Friday Close Hour" name="friday_close" id="friday" class="form-control" >
                      <?php 
                    
                     $selected='';
                    echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                       		
               </div>
            </div>
              <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="saturday">Saturday</label>
                 <div class="col-sm-5 hour_div">
                    <select   placeholder="Saturday Open Hour"  name="saturday_open"  id="saturday" class="form-control" >
                      <?php 
                    
                   $selected='';
                   echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                      	
				</div>
          
             <div class="col-sm-5 hour_div">
      
                    <select   placeholder="Saturday Close Hour" name="saturday_close" id="saturday" class="form-control" >
                      <?php 
                    
                    $selected='';
					echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
					
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
                    
                    ?>
                    </select>
                      		
               </div>
            </div>
			
			
			        <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="sunday">Sunday</label>
                 <div class="col-sm-5 hour_div">
                    <select   placeholder="Sunday Open Hour"  name="sunday_open"  id="sunday" class="form-control sunday_start" >
                      <?php 
                    
					$selected='';
					echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value ).'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
           
                  
                    ?>
                    
                     </select>
                      	
				</div>
          
             <div class="col-sm-5 hour_div">
      
                    <select   placeholder="Sunday Close Hour" name="sunday_close" id="sunday" class="form-control sunday_end" >
                      <?php 
                    
                    $selected='';
					echo '<option '.$selected.' value="select">Select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value).'">'.esc_attr($time_value).'</option>';
						  $selected='';
						  
						
					}
             
                    
                    ?>
                    
                    </select>
                      		
               </div>
            </div>
			
			
			
			</div>
			
			
	
		  <div class="col_M_full ">
    <button   class="btn btn-default orange_btn lss_get_listed ls_submit_site_btn" type="button">Get Listed!</button>
    <button   class="btn btn-default orange_btn ls_reset_btn"  type="button">Reset</button>
    </div>
 </form>
 
 
 </div>
            
        </div><!--tab_box-->
                  
    </div><!--custom_container-->
  </section><!--section business-->
  
<!-------------------------------------------------------------business_info end------------------------------------------------------------> 


  
  
  
  
  
