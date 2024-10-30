<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(isset($result))
{
	
$business_info=isset($result['business_info'])?$result['business_info']:'' ;
$llsp_business_id=isset($result['business_id'])?$result['business_id']:'';
$logo_id =isset( $business_info['_thumbnail_id'][0])?$business_info['_thumbnail_id'][0]:'';
$logo_thumbnail_url= wp_get_attachment_url($logo_id);
$thumbnail_id=isset($business_info['_thumbnail_id'][0])?$business_info['_thumbnail_id'][0]:'';
$args = array(
    'post_type' => 'attachment',
    'numberposts' => null,
    'post_status' => null,
    'post_parent' => $llsp_business_id[0],
    'exclude' =>  $thumbnail_id,
);
$attachments = get_posts($args);
$number_of_images=count($attachments);

}

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
      

                 <!------------------------------------------- Left Tab end here--------------------------------------->
              <div class="pre_loader">
			</div>          
          <div class="col-xs-12 col-sm-10 col-md-10 tab_box">
           <div class="tab-content"> 
			 
       	 <span class="headtitle img-responsive">
						
			    
           <form class="form_data"  id="business_photo_form" name="business_form_photo" enctype="multipart/form-data">           
            <div class="col_M_full">
			<h3 class="main_form_headings">
			<i class="fa fa-picture-o" aria-hidden="true"></i>
					Business Logo and Photos
				</h3>
			<div class="magin-hr"></div>
			<label class="lable_heading">Logo</label>
				<div class="col_M_full col-xs-12 col-md-12"	>
			<div class="upload_box logo_upload_info">
				<?php
				if( !empty( $logo_thumbnail_url))
				{
				?>
					<img id="logo" class="img-responsive drop_image" src="<?php echo !empty( $logo_thumbnail_url)? esc_url($logo_thumbnail_url):''  ?>" alt="your image" />
				
				<span id="fileselector">
					
					<label class="btn btn-default logo_btn red" for="upload-file-selector">
			
					<input id="upload-file-selector"   class="upload-file-selector" style="display:none" image_type='logo' logo_id="<?php echo $logo_id  ?>"  name="logo"  type="file">
            
					Change Logo
				</label>
			</span>	
			<?php
			
		}
		else
		{
			?>
				<img id="logo" class="img-responsive drop_image" src="<?php echo !empty( $logo_thumbnail_url)? esc_url($logo_thumbnail_url): esc_url(local_listing_pro_url.'images/no-image-icon.png')  ?>" alt="your image" />
				<span id="fileselector">
					
					<label class="btn btn-default logo_btn red " for="upload-file-selector">
			
					<input id="upload-file-selector"  class="upload-file-selector" style="display:none" image_type='logo'  name="logo"  type="file">
            
					Upload Logo
					
				</label>
			</span>	
	    <?php
			
		}
		?>
    </div>
				 	<span class="logo_section_businessinfo">
						
					<label class="firm_name">
                     <?php 
                      echo  isset($business_info['_llsp_business_name'][0])? esc_attr($business_info['_llsp_business_name'][0]):''; 
                      ?>
                      </label>
						<p><?php	echo "Address:- ".esc_attr($address) ?> </p>
						<p><?php  echo "Phone:- ".esc_attr($business_phone) ?></p>
						<p><?php 	echo "Website:- ".esc_attr($business_website) ?></p>
						<p><?php 	echo "Email:- ".esc_attr($business_email) ?></p>
                    </span> 
         
				</div>
				</div>
			<input type="hidden" value="<?php echo isset($business_info['_llsp_business_client_id'][0])? esc_attr($business_info['_llsp_business_client_id'][0]):'' ?>" name="_llsp_business_client_id" />   
		   <input type="hidden" value="<?php echo esc_attr($llsp_business_id[0]) ?>" name="_llsp_business_id" />
		   <input type="hidden"  value="<?php echo isset($business_info['_thumbnail_id'][0])? esc_attr($business_info['_thumbnail_id'][0]):'' ?>" name="_thumbnail_id" />
		  <h3 class="main_form_headings">
				<i class="fa fa-picture-o" aria-hidden="true"></i>
					Other Photos
					</h3>
			<div class="magin-hr"></div>
			<div class="col_M_full  uploaded_image_box">
				
	 <input type="hidden"  value="<?php echo  count($attachments)==0?0:count($attachments); ?>" name="img#" />
		
	  <?php
	  
	
	  
	  if ($attachments) 
	  {
		  
		
		foreach ($attachments as $key=>$attachment) 
		{	
				
				
				
				
				
?>


    
		<div class="col-xs-12 col-sm-4 col-md-4 upload_box">
			
		<img  id="gallery_image-<?php echo $attachment->ID  ?>" class="img-responsive drop_image"  src="<?php echo isset( $attachment->guid)? esc_attr($attachment->guid):''  ?>" alt="your image" />
		<span id="fileselector">
			<label class="btn btn-default img_btn red" for="delete-file-selector<?php echo $key ?>">
				
            <input id="delete-file-selector<?php echo $key ?>" class="delete-file-selector"   attach_id="<?php echo  $attachment->ID ?>"  style="display:none"    image_type='gallery_image-<?php echo $attachment->ID ?>'    type="button"  name="gallery_image" >
           Delete Photo
        </label>
		</span>
    </div>
  

<?php
       

	 

    }
}
?>
    </div>
			<div class="col_M_full">  
			<div class="col_M_full custom_padding col-xs-12 col-md-12"	>
           <div class="upload_box">
		  
			<span id="fileselector">
			<label class="btn btn-default red upload_image"  for="upload-file-selector1">
	
            <input id="upload-file-selector1" style="display:none" class="upload-file-selector"  image_type='gallery_image'    name="gallery_image" type="file">
            upload Image
        </label>
    </span>
    </div>
			</div>
    </div>                
                    

 
    </form>
		  
		
		
		</div><!--tab content-->  

     
  
       </div><!--tab box-->
       
      
  </section>
<!----------------------------------------------------------------------footer---------------------------------------------------------------------->


  
  
  
  


