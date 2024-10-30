<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$business_info=isset($result['business_info'])? esc_attr($result['business_info']):'';

$order_listing_status=isset($business_info['_llsp_business_order_progress_status'][0])? esc_attr($business_info['_llsp_business_order_progress_status'][0]):'';
$progress_report=isset($business_info['_llsp_progress_report'])? esc_attr($business_info['_llsp_progress_report'][0]):'';
$progress_details=json_decode($progress_report);
$thumbnail_id=isset($business_info['_thumbnail_id'][0])? esc_attr($business_info['_thumbnail_id'][0]):'';
$logo_thumbnail_url= wp_get_attachment_url($thumbnail_id);
$business_phone=isset($business_info['_llsp_business_phone'][0])? esc_attr($business_info['_llsp_business_phone'][0]):'';
$business_website=isset($business_info['_llsp_business_website'][0])? esc_attr($business_info['_llsp_business_website'][0]):
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
$address=$business_street.','.$business_city.','.$business_state.','.$business_zipcode;
}
else
{
$address='';
}
$business_email=isset($business_info['_llsp_business_email'][0])?$business_info['_llsp_business_email'][0]:
'';




?>



                 <!------------------------------------------- Left Tab end here--------------------------------------->
                    
   <div class="col-xs-12 col-sm-10 col-md-10 tab_box">
			<div id="tab" class="btn-group" data-toggle="buttons-radio">
                  <a href="#" class="btn btn-large btn-info active tab_checked" data-toggle="tab">1. Verify Business Information</a>
                  <a href="#" class="btn btn-large btn-info border-lhs-rhs active tab_checked" data-toggle="tab">2. Free Directory Submission</a>
					<a href="#" class="btn btn-large btn-info" data-toggle="tab">3. Upgrade to Premium</a>
                </div>  
  
 
             <div class="tab-content">
				 
				 
                  <div class="tab-pane active" id="business">
                  <h1>Congratulations !</h1>
                  <p>Your business has been submitted to Site.cards, your online business card and also Factual. Factual distributes local data to many online local directories However, you’ve only just begun. To get the most out of our service, upgrade to Premium to get all 10!.</p>
      <!--table start-->          
    
 <!--table end-->    
  </div>
  
  <span class="headtitle img-responsive">
						 <Img class="thumbnail_img" src="<?php echo !empty($logo_thumbnail_url)?$logo_thumbnail_url:local_listing_pro_url.'images/no-image-icon.png'?>" ></span>
						<span class="addres_user">
						<label class="firm_name">
                     <?php 
                      echo  isset($business_info['_llsp_business_name'][0])?$business_info['_llsp_business_name'][0]:''; 
                      ?></label>
						<p><?php	echo "Address:- ".$address ?> </p>
						<p><?php  echo "Phone:- ".$business_phone ?></p>
						<p><?php 	echo "Website:- ".$business_website ?></p>
						<p><?php 	echo "Email:- ".$business_email ?></p>
                    </span> 
  
  
       <div class="table-responsive">  
     <table class="table reportV">
    <thead>
      <tr>
        <th class="first_1">Listing</th>
        <th>Status</th>
       <th style="text-align:center">View Your Listing</th>
      </tr>
    </thead>
    <tbody>
     		<?php 
		foreach($progress_details as $directory=>$directory_progress)
		{
			
		?>
      <tr>
		  
        <td><span class="list_firm"><img src="<?php echo local_listing_pro_url ?>images/directory_logo/<?php echo $directory ?>" alt=""></span></td>
        <td class="icons_status">
           <?php 
            $linked=isset($directory['acxiom']['results'])?$local['acxiom']['results']:0;
              if($order_listing_status == 'complete')
              {
				   echo '<span data-toggle="tooltip" title="Your business is currently listed on this website."  ><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently listed on this website." >';
			  echo 'Listed</label>';
				}
              
            
              else
              {
			echo '<span data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days." ><img src="'.local_listing_pro_url.'images/pending.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days." >';
              echo 'In Progress</label>';
				}
		 
            ?></label></td>
               <td align="center">
                
                <?php
			if(isset($directory_progress->submission) && in_array($directory_progress->status,array(0,1,2)) )
				{
					 ?>
				<a href="<?php echo $directory_progress->submission ?>">View Listing</a>
			<?php
				}
           else
           {
           ?>

          
           
            <img width="20" height="20" title="In Progress" alt="check" src="<?php echo local_listing_pro_url ?>images/inprogress.png">
		 <?php
			}
           ?>
            </td>
       
      </tr>
      <?php
		}
		?>
     </tbody>
  </table>    
 </div>
 </div><!--tab content-->
 </div><!--tab box-->
 </div>  



 

  </section>
  
  

  

