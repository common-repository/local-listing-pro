  <?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
				$business_info= isset($result['business_info'])?$result['business_info']:'';
			     $citations_data= isset($result['citations'])?$result['citations']:'';
			    
			     $citations='';
			     $citations_flag=false;
			    if( $citations_data != '')
			    {
			     if($citations_data['data']['total']!=0 )
			     {   
					 $citations= $citations=array_filter(($citations_data['data']['data']), function ($key)  {
					return $key['competitor_id']==0;
					});
					 $citations_flag=true;
				 }
				}
				
		
			  
				$business_phone=isset($business_info['_llsp_business_phone'][0])?$business_info['_llsp_business_phone'][0]:'';
				$business_website=isset($business_info['_llsp_business_website'][0])?$business_info['_llsp_business_website'][0]:'';
				$business_street=isset($business_info['_llsp_business_street'][0])?$business_info['_llsp_business_street'][0]:'';

				$business_city=isset($business_info['_llsp_business_city'][0])?$business_info['_llsp_business_city'][0]:'';

				$business_state=isset($business_info['_llsp_business_state'][0])?$business_info['_llsp_business_state'][0]:'';
				$business_zipcode=isset($business_info['_llsp_business_zipcode'][0])?$business_info['_llsp_business_zipcode'][0]:'';
				$thumbnail_id=isset($business_info['_thumbnail_id'][0])?$business_info['_thumbnail_id'][0]:'';
				$logo_thumbnail_url= wp_get_attachment_url($thumbnail_id);
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
                    
          <div class="col-xs-12 col-sm-10 col-md-10 tab_box">
                 <div class="tab-content">  
                       <span class="headtitle img-responsive">
						 <Img class="thumbnail_img" src="<?php echo !empty($logo_thumbnail_url)? esc_url($logo_thumbnail_url):esc_url(local_listing_pro_url.'images/no-image-icon.png')?>" ></span>
                    <span class="addres_user">
                     <label class="firm_name">
                     <?php 
                      echo  isset($business_info['_llsp_business_name'][0])?esc_attr($business_info['_llsp_business_name'][0]):''; 
                      ?></label>
						<p><?php	echo "Address:- ".esc_attr($address) ?> </p>
						<p><?php  echo "Phone:- ".esc_attr($business_phone) ?></p>
						<p><?php 	echo "Website:- ".esc_attr($business_website) ?></p>
						<p><?php 	echo "Email:- ".esc_attr($business_email) ?></p>
                    </span> 
             <div id="citation-timeline" style="width: 100%; height: 400px;" ></div>
			
            
         <div class="table-responsive citation_div">
       

       <?php 
       if( $citations_flag)
       {
		   
		  
	  
        ?>
         <table class="table citation_tbl pading_btm">
        <thead>
          <tr>
            <th ><span data-placement="right" data-toggle="tooltip" title="Having Relevant Citations are more important than citations on Authority sites. Relevant citations means your NAP is on a site that is relevant to your industry or location. Relevancy score measures how relevant a website is.">Site</span></th>
            <th><span data-placement="right" data-toggle="tooltip" title="Having Relevant Citations are more important than citations on Authority sites. Relevant citations means your NAP is on a site that is relevant to your industry or location. Relevancy score measures how relevant a website is.">Relevancy</span> </th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
			<?php 
			
		   $month='';
			foreach( $citations as $citation_key=>$citation_option)
			{	$month_temp=date('m', strtotime($citation_option['date_added']) );
					
				
				$recent_month =  !empty($recent_month) ?$recent_month:(!empty($month) ?$month:$month_temp);
				$month = $month_temp ;
				
			    if($month  ==  $recent_month)
			    {
				$temp_citation=(json_decode($citation_option['data']));
				$var=$temp_citation[0];
			    $nap_link=!empty($var->value->link)?$var->value->link:$citation_option['provider'];
		
			
			
				
			 ?>
          <tr>
			 
            <td class="citation_col_1"><a href="<?php echo  	$nap_link ?>" target="_blank" data-placement="right" data-toggle="tooltip" title="The citation listed here is an instance of your business name, adress and phone number. Its possible that your business name, address and phone number may be listed several times on the same website. All of these instances can count as a citation. The more citations you have the better." class="t-tooltip"><?php echo 	$nap_link ?></a></td>
            <td  class="tb-margin"><span data-placement="right" data-toggle="tooltip" title="Having Relevant Citations are more important than citations on Authority sites. Relevant citations means your NAP is on a site that is relevant to your industry or location. Relevancy score measures how relevant a website is."><?php  echo  $var->relevancy ?></span></td>
            <td ><?php  echo  $citation_option['date_added'];  ?></td>
          </tr>
          
         <?php
         	$nap_link='';
		}
			}
			
			?>
           
        </tbody>
      </table>
      <?php
      
	}
		else
		{
			?>
		
			<table class="table reportV" >
				 <thead>
					<tr>
					<th>Site</th>
					<th>Relevancy </th>
					<th>Date</th>
					</tr>
				</thead>
			<tbody>			
				<tr class="no_rcords">
				<td colspan="3">
					Citation report is in process.
				</td>
				
			</tr>
			</table>
			<?php
		}
		
      ?>
       </div>   
       
      
</div><!--tab content-->  
       </div><!--tab box-->
        
     </div>  
  </section>
  
