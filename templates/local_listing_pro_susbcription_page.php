<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$business_info=$result['business_info'];
$invoice=$result['invoice'];
$billing_start_date=isset($business_info['_llsp_business_billing_start_date'])?$business_info['_llsp_business_billing_start_date'][0]:'';
$billing_end_date=isset($business_info['_llsp_business_billing_end_date'])?$business_info['_llsp_business_billing_end_date'][0]:'';
$subscription_start_date=isset($business_info['_llsp_business_subscription_start_date'])?$business_info['_llsp_business_subscription_start_date'][0]:'';
$subscription_status=isset($business_info['_llsp_business_subscription_status'])?$business_info['_llsp_business_subscription_status'][0]:'';
$subscription_plan_id=isset($business_info['_llsp_business_subscription_plan_id'])?$business_info['_llsp_business_subscription_plan_id'][0]:'';



?>
<div class="pre_loader">
</div>
<div class="col-xs-12 col-sm-10 col-md-10 tab_box">
<div class="tab-content">  
<table class="table">
        <thead>
          <tr>
            <th>Plan</th>
             <th>Started At</th>
			<th>Status</th>
            <th>Billing</th>
            <th>Cancel</th>
          </tr>
        </thead>
        <tbody>
		 <tr>
			<td><?php  echo esc_attr($subscription_plan_id); ?></td>
			<td><?php echo esc_attr($subscription_start_date); ?></td>
			<td><?php echo esc_attr($subscription_status);?></td>
			<td><?php echo '<input type="button" data-toggle="modal" class="view_billing" data-target="#paymentModal" value="Payment Details"/>'; ?></td>
			<td><?php echo '<input type="button" data-toggle="modal" data-target="#myModal" value="Cancel"/>'; ?></td>
          </tr>
           </tbody>
 </table>
 </div>
 </div>
   </section>
    <!-- Modal -->
  <div class="modal fade" id="paymentModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payment Details</h4>
        </div>
        <div class="modal-body">
        <table class="invoice_details table reportV" cellspacing="10">
			<thead>
				<th class="first_1">
					Billing Start Date
				</th>
				<th>
					Billing End Date
				</th>
				<th>
					Amount
				</th>
			</thead>
			<tbody>
				<?php 
				foreach($invoice as $pos=>$invoice_row)
				{
				
				?>
				<tr>
					<td>
					<?php echo esc_attr($invoice_row['start_date']); ?>
					</td>
					<td>
					<?php echo esc_attr($invoice_row['end_date']); ?>
					</td>
					<td>
					<?php echo esc_attr($invoice_row['amount']); ?>
					</td>
				</tr>
				<?php
					
					}
				?>
				
			</tbody>
        
        </table>
        </div>
        <div class="modal-footer">
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
      </div>
      
    </div>
 
  
</div>

   
   
   
