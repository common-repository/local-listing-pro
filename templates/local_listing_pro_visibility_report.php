<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$directory=isset($result['directory_report']['directory'])?$result['directory_report']['directory']:'';

$local=isset($result['directory_report']['local'])?$result['directory_report']['local']:'';

$business_info=isset($result['business_info'])?$result['business_info']:'';

$order_listing_status=isset($business_info['_llsp_business_order_progress_status'][0])?$business_info['_llsp_business_order_progress_status'][0]:'';
$order_upgraded_listing_status=isset($business_info['_llsp_business_upgraded_order_progress_status'][0])?$business_info['_llsp_business_upgraded_order_progress_status'][0]:'';
$order_paid=isset($business_info['_llsp_business_upgraded'][0])?$business_info['_llsp_business_upgraded'][0]:'';
$thumbnail_id=	isset($business_info['_thumbnail_id'][0])?$business_info['_thumbnail_id'][0]:'';
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
$business_zipcode=isset($business_info['_llsp_business_zipcode'][0])?$business_info['_llsp_business_zipcode'][0]:'';
$progress_report=isset($business_info['_llsp_progress_report'])?$business_info['_llsp_progress_report'][0]:'';
$progress_details=json_decode(stripslashes($progress_report));;
$business_upgraded_report=isset($business_info['_llsp_upgraded_progress_report'])?$business_info['_llsp_upgraded_progress_report'][0]:'';
$upgraded_progress_details = json_decode($business_upgraded_report);
$business_email=isset($business_info['_llsp_business_email'][0])?$business_info['_llsp_business_email'][0]:
'';


$business_status =isset($business_info['_llsp_business_client_status'][0])?$business_info['_llsp_business_client_status'][0] : '';

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
		 <?php
				 
				if ( ($business_status == "paused" || $business_status == "inactive")) 
					{
						
					?>
		
				<div id="tab" class="btn-group" data-toggle="buttons-radio">
                  <a href="#" class="btn btn-large btn-info active tab_checked" data-toggle="tab">1. Verify Business Information</a>
                  <a href="#" class="btn btn-large btn-info border-lhs-rhs active tab_checked" data-toggle="tab">2. Free Directory Submission</a>
				 <a href="#" class="btn btn-large btn-info" data-toggle="tab">3. Upgrade to Premium</a>
                </div>  
  
 
  <?php
					}
				?>
				
               
				
              
              
                 <div class="tab-content">  
					 	 <?php
				 
					if ( ($business_status == "paused" || $business_status == "inactive")) 
					{
						
					?>
					    <div class="tab-pane active" id="business">
                  <h1>Congratulations !</h1>
                  <p>Your business has been submitted to Site.cards, your online business card and also Factual. Factual distributes local data to many online local directories However, you’ve only just begun. To get the most out of our service, upgrade to Premium to get all 10!.</p>
  
				</div>
				
				<?php
			}
			?>
                      <span class="headtitle img-responsive">
						 <Img class="thumbnail_img" src="<?php echo !empty($logo_thumbnail_url)?esc_url($logo_thumbnail_url):esc_url(local_listing_pro_url.'images/no-image-icon.png')?>" ></span>
						<span class="addres_user">
						<label class="firm_name">
                     <?php 
                      echo isset($business_info['_llsp_business_name'][0])?$business_info['_llsp_business_name'][0]:''; 
                      ?></label>
						<p><?php	echo "Address:- ".esc_attr($address)?> </p>
						<p><?php  echo "Phone:- ".esc_attr($business_phone) ?></p>
						<p><?php 	echo "Website:- ".esc_attr($business_website) ?></p>
						<p><?php 	echo "Email:- ".esc_attr($business_email) ?></p>
                    </span> 
            
			  
    <div class="table-responsive visi_tbl">          	     
     <table class="table reportV">
    <thead>
      <tr>
        <th class="first_1"><h5>Listing<h5></th>
        <th><h5>Status<h5></th>
        <th>View Your Listing</th>
      </tr>
    </thead>
    <tbody>
		<?php 

	

		   $un_upgrade_array = array();
		   $un_upgrade_array_key = array();
		   
  
		   foreach($progress_details as $directory=>$directory_progress){
  
			   if($directory == 'Site.cards'){
				  array_push($un_upgrade_array,$directory_progress);
				  array_push($un_upgrade_array_key,$directory);
			   }
  
			 
  
  
		   }
  
			 $unupgraded_progress_details = array_combine($un_upgrade_array_key,$un_upgrade_array);
			 $unupgraded_progress_details['Judybook'] =       array();  
		
			 
			 $progress_details  = (object)$unupgraded_progress_details; 

		   

		foreach($progress_details as $directory=>$directory_progress)
		{
       
		
		$imgsrc=$directory;	
		if(file_exists(local_listing_pro_path.'images/directory_logo/'.$directory.".png"))
		{
			$imgsrc=$directory.".png";
		}
		else
		{
			$imgsrc=$directory.".jpg";
		
		}
		?>


      <tr>
	
		

		 
		  
        <td><span class="list_firm"><img src="<?php echo local_listing_pro_url ?>images/directory_logo/<?php echo $imgsrc ?>" alt=""></span></td>
        
		    <td class="icons_status">
           <?php 
            $linked=isset($directory['acxiom']['results'])?$local['acxiom']['results']:0;
			
              if( in_array($directory_progress->status,array(0,1,2,-3)))
              {
				 
				if($directory_progress->submission != '' )
				{
				    echo '<span data-toggle="tooltip" title="Your business is currently listed on this website."  ><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently listed on this website." >';
					echo 'Listed</label>';
				}
				elseif($directory_progress->comment == 'Submitted'  && ($directory == 'Factual'))
				{   echo '<span data-toggle="tooltip" title="Your business is submitted on this website."  ><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip"  title="Your business is currently submitted on this website." >';
					echo 'Submitted</label>';
					
				}
			    elseif($directory != 'Factual' )
				{
					echo '<span data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days." ><img src="'.local_listing_pro_url.'images/pending.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days." >';
					echo 'In Progress</label>';
				}
				
              
            }
              else
              {
				  
			echo '<span data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days." ><img src="'.local_listing_pro_url.'images/pending.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days." >';
              echo 'In Progress</label>';
				}
		 
            ?></label>
			</td>


            
			
			<td align="center">
                
                <?php
			if( in_array($directory_progress->status,array(0,1,2,-3)) ){

				if($directory_progress->submission != '' )
				{
					
			?>
			<a href="<?php echo $directory_progress->submission ?>">View Listing</a>
			<?php
				}
				elseif($directory_progress->comment == 'Submitted' || $directory == 'Factual' )
				{
					?>
						<a data-toggle="tooltip" title="There is no link because this source does not provide a viewable link back. However, your business has been submitted and will be included in all of their data sources."  href="javascript:void(0);">No Link</a>
					<?php
				}
				else
				{
					?>
					<img width="20" height="20" title="In Progress" alt="check" src="<?php echo local_listing_pro_url ?>images/inprogress.png">
					<?php
				}
				
		    }
       
			elseif(!empty($directory_progress->submission) && in_array($directory_progress->status,array(3,4,5,6,7,8)) )
			{
				?>
				
			<img width="20" height="20" title="In Progress" alt="check" src="<?php echo local_listing_pro_url ?>images/inprogress.png">
			   
		    <?php	
			}
			
			elseif(empty($directory_progress->submission)){
			   
			?>
			   
			   
		  <img width="20" height="20" title="In Progress" alt="check" src="<?php echo local_listing_pro_url ?>images/inprogress.png">
			   
		   <?php
			   
		   }
			
           ?>
        </td>

       
      </tr>

      <?php
		}

		
		 $progres_array = array();
		 $progres_array_key = array();
		 

		 foreach($upgraded_progress_details as $directory=>$directory_progress){

             if($directory == 'Bing'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }

			 if($directory == 'Apple'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }


			 if($directory == 'BubbleLife'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }
			 if($directory == 'Verizon411'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }
			 if($directory == 'Here Live Maps'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }


			 if($directory == 'BrownBook'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }

			 if($directory == 'Google Public Add'){
				array_push($progres_array,$directory_progress);
				array_push($progres_array_key,$directory);
			 }


		 }

		   $upgraded_progress_details = array_combine($progres_array_key,$progres_array);
		   $upgraded_progress_details['DnB'] =       array();  
		   $upgraded_progress_details['Yelp'] =       array(); 
           
		   $upgraded_progress_details  = (object)$upgraded_progress_details;
		   
		
      

  	foreach($upgraded_progress_details as $directory=>$directory_progress)
		{
			
			
			
		
			
		$directory1=str_replace(" ","-",$directory);
		$directory1=str_replace("?","",$directory1);
		$imgsrc=$directory1;	
		
		if(file_exists(local_listing_pro_path.'images/directory_logo/'.$directory1.".png"))
		{
			$imgsrc=$directory1.".png";
		}
		else
		{
			$imgsrc=$directory1.".jpg";
		}
      ?>
    
      <tr>
        <td><span class="list_firm">
			<img src="<?php echo local_listing_pro_url ?>images/directory_logo/<?php echo $imgsrc ?>" alt=""></span></td>
          <td class="icons_status"><?php
          
					// if($directory == "DnB")
					// {
						

					// 	 if($order_upgraded_listing_status == 'complete' && in_array($directory_progress->status,array(0,1,2)))
					// 		  {
								  
									
								  
					// 			  if(!empty($directory_progress->submission))
					// 			  {
					// 			   echo '<span data-toggle="tooltip" title="Your business is currently listed on this website."><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently listed on this website.">';
					// 				echo 'Listed</label>';
					// 				}
					// 				else
					// 				{
					// 					  echo '<span data-toggle="tooltip" title="Your business is currently submitted on this website."><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently submitted on this website.">';
					// 						echo 'Submitted</label>';
					// 				}
							
					// 			}
							  
					// 		 else
					// 		  {
					// 				if($directory=='Google Web Search' || $directory=='Bing')
					// 				{
					// 				  echo '<span data-toggle="tooltip" title="Your business is currently submitted on this website."><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently submitted on this website.">';
					// 						echo 'Submitted</label>';
					// 				}
					// 				else
					// 				{
					// 				echo '<span> <img src="'.local_listing_pro_url.'images/pending.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days.">';
					// 				echo 'In Progress</label>';
					// 				}
					// 			}
					// }
					if(!$order_paid){
					
					echo '<span><img src="'.local_listing_pro_url.'images/lock.jpg" alt="check"></span><label>';
					echo  '<a class="upgrade_to_premium_lbl" href="?page=upgrade_business">Upgrade to Premium to Unlock</a></label>'; 
					
					}
					else{
				?> 
                <?php 
				
				$linked=isset($directory['acxiom']['results'])?$local['acxiom']['results']:0;
			  
				if($order_upgraded_listing_status == 'complete' && in_array($directory_progress->status,array(0,1,2))){
				  
					
				  
				  if(!empty($directory_progress->submission))
				  {
				   echo '<span data-toggle="tooltip" title="Your business is currently listed on this website."><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently listed on this website.">';
					echo 'Listed</label>';
					}
					else
					{
						  echo '<span data-toggle="tooltip" title="Your business is currently submitted on this website."><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently submitted on this website.">';
							echo 'Submitted</label>';
					}
			
				}
              
             else
              {
					if($directory=='Google Web Search' || $directory=='Bing')
					{
					  echo '<span data-toggle="tooltip" title="Your business is currently submitted on this website."><img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently submitted on this website.">';
							echo 'Submitted</label>';
					}
					else
					{
					echo '<span> <img src="'.local_listing_pro_url.'images/pending.jpg" alt="check"></span><label data-toggle="tooltip" title="Your business is currently in process of being included on this website. This can take anywhere from 7-35 business days.">';
					echo 'In Progress</label>';
					}
				}
			}
            ?></label>
            </td>
			
              <td align="center">
				 
				  <?php
				  /*
				  if($directory == "DnB")
				  {
					    if($order_upgraded_listing_status == 'complete' && in_array($directory_progress->status,array(0,1,2)))
              {
				  if(!empty($directory_progress->submission))
				  {
					  ?>
				 <a href="<?php echo $directory_progress->submission ?>">View Listing</a>
				
				<?php	}
					else
					{
						?>
						     <a data-toggle="tooltip" title="There is no link because this source does not provide a viewable link back. However, your business has been submitted and will be included in all of their data sources."  href="javascript:void(0);">No Link</a>
				<?php	
				}
			
				}
			
              
             else
              {
				  ?>
				  
			  <img width="20" height="20" title="In Progress" alt="check" src="<?php echo local_listing_pro_url ?>images/inprogress.png">
   
			<?php	}
				  }
				  */
                 if(!$order_paid) 
					{
					echo '<span><img src="'.local_listing_pro_url.'images/lock.jpg" alt="check"></span><label>';
					
					
					}
					else
					{   
                    if($order_upgraded_listing_status == 'complete' && in_array($directory_progress->status,array(0,1,2)))
              {
				  if(!empty($directory_progress->submission))
				  {
					  ?>
				 <a href="<?php echo $directory_progress->submission ?>">View Listing</a>
				
				<?php	}
					else
					{
						?>
						     <a data-toggle="tooltip" title="There is no link because this source does not provide a viewable link back. However, your business has been submitted and will be included in all of their data sources."  href="javascript:void(0);">No Link</a>
				<?php	
				}
			
				}
			
              
             else
              {
				  ?>
				  
			  <img width="20" height="20" title="In Progress" alt="check" src="<?php echo local_listing_pro_url ?>images/inprogress.png">
   
			<?php	}
			  }
              ?>
		
          
			

			
           
          </td>
      </tr>
      <?php
		}
      ?>
	  <?php /*
       <tr>
		  
        <td><span class="list_firm"><img style="width:200px;height:40px" src="<?php echo local_listing_pro_url ?>images/directory_logo/<?php echo 'local-safeguard.png' ?>" alt="Local Safeguard"></span></td>
        <td class="icons_status">
           <?php 
            	if(!$order_paid) 
					{
						
					echo '<span><img src="'.local_listing_pro_url.'images/lock.jpg" alt="check"></span><label>';
					echo  '<a class="upgrade_to_premium_lbl" href="?page=upgrade_business">Upgrade to Premium to Unlock</a>'; 
					
					}
					else
					{
						echo '<span data-toggle="tooltip" data-placement="left"  data-html="true" title="#1 Maintains NAP cosnistency on all local directories (NAP = Name Address and Phone Number) <br> #2 Regularly checks business details for Accuracy and makes sure listing is live. <br> #3 Corrects overwritten data . <br> #4 Monitors 3rd party citation sources ">
						<img src="'.local_listing_pro_url .'images/check.jpg" alt="check"></span><label data-toggle="tooltip" data-placement="left"  data-html="true" title="#1 Maintains NAP cosnistency on all local directories (NAP = Name Address and Phone Number) <br> #2 Regularly checks business details for Accuracy and makes sure listing is live. <br> #3 Corrects overwritten data . <br> #4 Monitors 3rd party citation sources ">';
						echo 'Active</label>';
			
						
					}
            
		 
            ?>
            
            </td>
               <td align="center">
				<?php
					
					if($order_paid) 
					{
						
						echo  '<a href="https://www.advicelocal.com/products/local-safeguard-monthly-maintenance/" data-placement="left"  data-html="true" title="#1 Maintains NAP cosnistency on all local directories (NAP = Name Address and Phone Number) <br> #2 Regularly checks business details for Accuracy and makes sure listing is live. <br> #3 Corrects overwritten data . <br> #4 Monitors 3rd party citation sources " data-toggle="tooltip"><label>View</label></a>'; 
					
					}
					else
					{
						echo '<span><img src="'.local_listing_pro_url.'images/lock.jpg" alt="check"></span><label>';
					
					}
					
					
					
					
					?>
				</td>
       
	  </tr>
	  */ ?>
      
      
    </tbody>
  </table>
 </div> 

  


</div><!--tab content-->  
       </div><!--tab box-->
     </div>  
  </section>



  
  
  
  
  
