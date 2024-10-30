<?php  
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	
	
	   $args = array(
							'post_type' => 'attachment',
							'numberposts' => null,
							'post_status' => null,
							'post_parent' => $result['business_id'],
							'exclude' =>  get_post_thumbnail_id($result['business_id'])
							);		
							
							
				$attachments=	get_posts($args);
				
																
			
	?>
	
	
	 <input type="hidden"  value="<?php echo count($attachments); ?>" name="img#" />
	 
	  <?php
	  
	
	  
	  if ($attachments) 
	  {
		foreach ($attachments as $key=>$attachment) 
		{	
			
			
?>


	   
    
		<div class="col-xs-12 col-sm-4 col-md-4 upload_box">
		<img  id="gallery_image-<?php echo $attachment->ID  ?>" class="img-responsive drop_image"  src="<?php echo isset( $attachment->guid)?$attachment->guid:''  ?>" alt="your image" />
		<span id="fileselector">
			<label class="btn btn-default img_btn red" for="delete-file-selector<?php echo $key  ?>">
				
            <input   class="delete-file-selector"   id="delete-file-selector<?php echo $key   ?>"  class=""  attach_id="<?php echo  $attachment->ID ?>"  style="display:none"    image_type='gallery_image-<?php echo $attachment->ID ?>'    type="button"  name="gallery_image" >
           Delete Photo
        </label>
		</span>
    </div>
  

<?php


       
    }
}
?>

