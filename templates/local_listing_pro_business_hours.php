<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$business_info=isset($result['business_info'])?$result['business_info']:'' ;
$llsp_business_id=isset($result['business_id'])?$result['business_id']:'';
$business_hours_temp=  isset($business_info['_llsp_business_hours'][0])?$business_info['_llsp_business_hours'][0]:'';
$business_hours= json_decode($business_hours_temp);
$business_time= isset($result['time_options'])?$result['time_options']:'';



if(!empty($business_hours))
{
$hours_array=array();
foreach($business_hours as $key=>$value)
{ 	
	
	 
	
		$hours_array[$key]=$value;
	
}
}


$monday_open=isset($hours_array['monday_open'])?$hours_array['monday_open']:'';
$monday_close=isset($hours_array['monday_close'])?$hours_array['monday_close']:'';
$tuesday_open=isset($hours_array['tuesday_open'])?$hours_array['tuesday_open']:'';
$tuesday_close=isset($hours_array['tuesday_close'])?$hours_array['tuesday_close']:'';
$wednesday_open=isset($hours_array['wednesday_open'])?$hours_array['wednesday_open']:'';
$wednesday_close=isset($hours_array['wednesday_close'])?$hours_array['wednesday_close']:'';
$thursday_open=isset($hours_array['thursday_open'])?$hours_array['thursday_open']:'';
$thursday_close=isset($hours_array['thursday_close'])?$hours_array['thursday_close']:'';
$friday_open=isset($hours_array['friday_open'])?$hours_array['friday_open']:'' ;
$friday_close=isset($hours_array['friday_close'])?$hours_array['friday_close']:'';
$saturday_open=isset($hours_array['saturday_open'])?$hours_array['saturday_open']:'';
$saturday_close=isset($hours_array['saturday_close'])?$hours_array['saturday_close']:'';
$sunday_open=isset($hours_array['sunday_open'])?$hours_array['sunday_open']:'';
$sunday_close=isset($hours_array['sunday_close'])?$hours_array['sunday_close']:'';
$business_country=isset($business_info['_llsp_business_country'][0])?$business_info['_llsp_business_country'][0]:'';
$business_state=isset($business_info['_llsp_business_state'][0])? $business_info['_llsp_business_state'][0]:'' ;
$thumbnail_id=isset($business_info['_thumbnail_id'][0])?$business_info['_thumbnail_id'][0]:'';
$logo_thumbnail_url= wp_get_attachment_url($thumbnail_id);
$business_phone=isset($business_info['_llsp_business_phone'][0])?$business_info['_llsp_business_phone'][0]:'';
$business_website=isset($business_info['_llsp_business_website'][0])?$business_info['_llsp_business_website'][0]:
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
$business_email=isset($business_info['_llsp_business_email'][0])?$business_info['_llsp_business_email'][0]:
'';

?>


<!-------------------------------------------Top Header start--------------------------------------->  
		<!------------------------------------------- Left Tab end here--------------------------------------->
        <div class="pre_loader">
			</div>
         <div class="col-xs-12 col-sm-10 col-md-10 tab_box hours_box">			        
           <div class="tab-content">  
         
       	 <span class="headtitle img-responsive">
			<Img class="thumbnail_img" src="<?php echo !empty($logo_thumbnail_url)? esc_url($logo_thumbnail_url): esc_url(local_listing_pro_url.'images/no-image-icon.png')?>" ></span>
			<span class="addres_user">
						<label class="firm_name">
                     <?php 
                      echo  isset($business_info['_llsp_business_name'][0])? esc_attr($business_info['_llsp_business_name'][0]):''; 
                      ?></label>
						<p><?php	echo "Address:- ".esc_attr($address) ?> </p>
						<p><?php  echo "Phone:- ".esc_attr($business_phone) ?></p>
						<p><?php 	echo "Website:- ".esc_url($business_website) ?></p>
						<p><?php 	echo "Email:- ".esc_attr($business_email) ?></p>
                    </span> 
       
        <form class="form_data business_hours" name="business_form_update" >   
			  <input type="hidden" value="<?php echo isset($business_info['_llsp_business_client_id'][0])?esc_attr($business_info['_llsp_business_client_id'][0]):'' ?>" name="_llsp_business_client_id" />   
			 <input type="hidden" value="<?php echo esc_attr($llsp_business_id[0]) ?>" name="_llsp_business_id" />
			 <div class="form-group">
			 	  <div class="col-xs-12 col-md-12">
					<h3 class="main_form_headings">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						Business Hours.
						</h3>
						</div>  
					</div> 
			<div class="submit_business_hours">
			 <div class="col_M_full col-md-12 col-xs-12 ">
					
                   <label class="col-sm-2" for="tuesday"></label>
                 <div class="col-sm-5">
                    Open
                 </div>
                 <div class="col-sm-5">
                    close
                 </div>
				</div>
			<div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2" for="tuesday">Monday</label>
                 <div class="col-sm-5 hour_div">
               <select  data-validation-error-msg="Field is required" data-validation="required"  value="<?php echo esc_attr($monday_open)  ?>"  placeholder="Monday Open hour"  name="monday_open"  id="monday" class="form-control" >
                    <?php 
                    $selected='';
                     echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($monday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						$selected='';
					}
					
                    
                    ?>
                   
                    </select>
                    <div class="cl-sec2"> <span class="caret"></span></div>
				</div>
           <div class="col-sm-5 hour_div">
      
                    <select data-validation-error-msg="Field is required" data-validation="required" type="text" value="<?php echo esc_attr($monday_close) ?>" placeholder="Monday Close hour" name="monday_close" id="monday" class="form-control" >
                       <?php 
                     $selected='';
                     echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($monday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						$selected='';
					}
					
                    
                    ?>
                   
                    </select>
                    <div class="cl-sec2"> <span class="caret"></span></div>
               </div>
            </div>
           <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="tuesday">Tuesday</label>
                 <div class="col-sm-5 hour_div">
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $tuesday_open;  ?>"  placeholder="Tuesday Open hour"  name="tuesday_open"  id="tuesday" class="form-control" >
                       <?php 
                    
                    $selected='';
                    echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($tuesday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.esc_attr($selected).' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                   
                    </select>
                    <div class="cl-sec2"> <span class="caret"></span></div>
				</div>
				<div class="col-sm-5 hour_div">
      
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $tuesday_close; ?>"  placeholder="Tuesday Close hour" name="tuesday_close" id="tuesday" class="form-control" >
                      <?php 
                    
                     $selected='';
                      echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($tuesday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
                    
                    ?>
                    
                      </select>
                      <div class="cl-sec2"> <span class="caret"></span></div>
                    
               </div>
            </div>
			<div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="Wednesday">Wednesday</label>
                 <div class="col-sm-5 hour_div">
                    <select data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $wednesday_open ?>"  placeholder="Tuesday Open hour"  name="wednesday_open"  id="wednesday" class="form-control" >
                      <?php 
                    $selected='';
                     echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($wednesday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                    
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
                    
				</div>
           <div class="col-sm-5 hour_div">
      
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $wednesday_close   ?>" placeholder="Tuesday Close hour" name="wednesday_close" id="wednesday" class="form-control" >
                      <?php 
                    
                     $selected='';
                      echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($wednesday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
                    
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
               </div>
            </div>
           <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="Wednesday">Thursday</label>
                 <div class="col-sm-5 hour_div">
                    <select data-validation-error-msg="Field is required" data-validation="required" value="<?php echo  $thursday_open; ?>" placeholder="Thursday Open hour"  name="thursday_open"  id="thursday" class="form-control" >
                      <?php 
                    
                     $selected='';
                     echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($thursday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
				</div>
           <div class="col-sm-5 hour_div">
      
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $thursday_close; ?>" placeholder="Thursday Close hour" name="thursday_close" id="thursday" class="form-control" >
                      <?php 
                    
                    $selected='';
                    echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($thursday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
               </div>
            </div>
            <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="friday">Friday</label>
                 <div class="col-sm-5 hour_div">
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $friday_open; ?>" placeholder="Friday Open hour"  name="friday_open"  id="friday" class="form-control" >
                      <?php 
                    
                   $selected='';
                    echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($friday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
				</div>
            <div class="col-sm-5 hour_div">
      
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo  $friday_close ?>"  placeholder="Friday Close hour" name="friday_close" id="friday" class="form-control" >
                      <?php 
                    
                     $selected='';
                      echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($friday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
			
					
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
               </div>
         
            </div>
              <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="friday">Saturday</label>
                 <div class="col-sm-5 hour_div">
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $saturday_open; ?>" placeholder="Saturday Open hour"  name="saturday_open"  id="saturday" class="form-control" >
                      <?php 
                    
                   $selected='';
                    echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($saturday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                    
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
				</div>
            <div class="col-sm-5 hour_div">
      
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo  $saturday_close ?>"  placeholder="Saturday Close hour" name="saturday_close" id="saturday" class="form-control" >
                      <?php 
                    
                     $selected='';
                      echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($saturday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
			
					
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
               </div>
         
            </div>
            <div class="col_M_full col-md-12 col-xs-12 hour_box">
                   <label class="col-sm-2 " for="friday">Sunday</label>
                 <div class="col-sm-5 hour_div">
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo $sunday_open; ?>" placeholder="Sunday Open hour"  name="sunday_open"  id="sunday" class="form-control" >
                      <?php 
                    
                   $selected='';
                    echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($sunday_open==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
					
                
                    ?>
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
				</div>
            <div class="col-sm-5 hour_div">
				
                    <select  data-validation-error-msg="Field is required" data-validation="required" value="<?php echo  $sunday_close ?>"  placeholder="Sunday Close hour" name="sunday_close" id="sunday" class="form-control" >
                      <?php 
                    
                     $selected='';
                     echo '<option '.$selected.' value="select">select</option>';
                    foreach($business_time as $time_key=>$time_value )
                    {
						if($sunday_close==$time_value)
						{
							$selected='selected';
				     	}
						echo '<option '.$selected.' value="'.esc_attr($time_value) .'">'.esc_attr($time_value).'</option>';
						  $selected='';
					}
				
                    
                    ?>
                    
                     </select>
                     <div class="cl-sec2"> <span class="caret"></span></div>
               </div>
            </div>
            </div>
              <button   class="btn btn-default orange_btn ls_submit_changes_btn" type="button">Save changes</button>
   
			<div class="result_message"  >  
		   
		  </div>   
    </form>  
  
    
		
		
		
		</div><!--tab content-->  

     
  
       </div><!--tab box-->
       
     </div>  
  </section>
<!----------------------------------------------------------------------footer---------------------------------------------------------------------->


  


