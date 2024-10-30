<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$business_info=isset($result)?$result:'' ;



?>
<section class="dir_includ">
 	<div class="container">
    	<div class="row">
         <h1>Directories Included</h1>
         <div class="col-xs-12 col-sm-12 col-md-12">	 
         <div class="dir-dt">
         <ul>
         <li><span><img alt="yelp" src="<?php echo local_listing_pro_url ?>images/g-yelp.jpg"></span></li>
         <li><span><img alt="google" src="<?php echo local_listing_pro_url ?>images/g-google.jpg"></span></li>
         <li><span><img alt="yahoo" src="<?php echo local_listing_pro_url ?>images/g-yahoo.jpg"></span></li>
         <li><span><img alt="bing" src="<?php echo local_listing_pro_url ?>images/g-bing.jpg"></span></li>
         <li><span><img alt="search-magni" src="<?php echo local_listing_pro_url ?>images/g-search-magni.jpg"></span></li>
         <li><span><img alt="site-card" src="<?php echo local_listing_pro_url ?>images/g-site-card.jpg"></span></li>
         </ul>
         
          <ul class="dir-list">
         <li><span><img alt="su-pg" src="<?php echo local_listing_pro_url ?>images/g-super-pg.jpg"></span></li>
         <li><span><img alt="loc-stac" src="<?php echo local_listing_pro_url ?>images/G-loacl-stack.jpg"></span></li>
         <li><span><img alt="fact" src="<?php echo local_listing_pro_url ?>images/g-factual.jpg"></span></li>
         <li><span><img alt="acxi" src="<?php echo local_listing_pro_url ?>images/g-acxiom.jpg"></span></li>
         </ul>
         </div>
         
         </div>
       </div><!--row-->
   </div><!--container-->
 </section>

 <!----------------------------------------------------------------Features start------------------------------------------------------>
 
<section class="features">
 	<div class="container">
    	<div class="row">        	
         	<h1>Features</h1>
            <div class="col-xs-12 col-sm-6 col-md-4 feature-content">
            <span><img alt="ico1" src="<?php echo local_listing_pro_url ?>images/icon1.png"></span>
            <p>Get listed in the most important local search directories</p>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-4 feature-content">
            <span><img alt="ico2" src="<?php echo local_listing_pro_url ?>images/icon2.png"></span>
            <p>Watch your citation count grow<br> each month</p>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-4 feature-content2">
            <span><img alt="ico3" src="<?php echo local_listing_pro_url ?>images/icon3.png"></span>
            <p>Increase your chances of ranking highly for local Google searches</p>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-4 feature-content3">
            <span><img alt="ico4" src="<?php echo local_listing_pro_url ?>images/icon4.png"></span>
            <p>Get updated on submission progress in your visibility report</p>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-4 feature-content3">
            <span><img alt="ico5" src="<?php echo local_listing_pro_url ?>images/icon5.png"></span>
            <p>Get more calls and visits to your<br> business</p>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-4 feature-content4">
            <span><img alt="ico6" src="<?php echo local_listing_pro_url ?>images/icon6.png"></span>
            <p>Update your data across all directories with a single click</p>
            </div>
         	
        </div>
    </div>
 </section>
 
 

<section class="footer">
 	<div class="custom_container">
    	<div class="row">
        <h1>Contact & Support</h1>
        <div class="col-xs-12 col-sm-6 col-md-6 footer-content">
                <p>We’re here to answer any questions you may have about our services. Just fill in the contact form here and we’ll get back to you as soon as possible.</p>
                
                </div> 
       <div class="col-xs-12 col-sm-6 col-md-6 footer-content">       
		   
		     
             <div class="button-sky"> 
				<h3>Contact Us at : </h3>
				<p><a href="http://llpsupport.advicelocal.com/support/home">http://llpsupport.advicelocal.com/support/home</a><br>
				<span>Any Questions, concerns, and feedback are always welcome.</span>
				</p>
         
                  <?php /* ?>
         <form id="create_ticket_form"  name="create_ticket_form" action="javascript:void(0)" class="form_data" >   
            
            <input type="hidden" name="_llsp_business_client_id_footer" value="<?php echo !empty($business_info['_llsp_business_client_id'][0])?$business_info['_llsp_business_client_id'][0]:'' ?>"/>
            
             <div class="controls">
			        <input type="text" data-validation-error-msg="Please enter this field" data-validation="required"  id="subject" name="subject" placeholder="Enter your business name" class="input-xlarge">
			      </div>
			      
			        <div class="controls">
			        <input type="text" data-validation-error-msg="Please enter valid email" data-validation="required email"   id="email" name="email" placeholder="Enter email" class="input-xlarge">
			      </div>
	
	
			      <div class="form-group">
			        <textarea id="message" data-validation-error-msg="Please enter this field" data-validation="required" name="message" class="form-control"  placeholder="Ask away!"required></textarea>
		          </div>
			    <div class="control-group">
			      <!-- Button -->
			      <div class="controls">
			        <button class="btn btn-default create_ticket">Send Email</button>
			      </div>
             </div>
              <div class="result_message1"  >  
	
				</div> 
             </form>
             
             <?php */ ?>
             <div class="pre_loader" style="display: none;"> </div>
                </div><!--content-box-->
       </div><!--Footer-content-->
        
        </div>
    </div>
 </section> 

 </div>
 
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Remove Subscription</h4>
        </div>
        <div class="modal-body">
          <p>Do you really want cancel billing</p>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-default cancel_btn" >Cancel Billing</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
      </div>
      
    </div>
 
  
</div>

