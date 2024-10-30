<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

   if( !isset($_SESSION['searched_business_list']))
   {
     session_start();
	$searched_business_list=$result['data']['data'];
	$_SESSION['searched_business_list'] = $searched_business_list;


	}
	else
	{
		$searched_business_list=$_SESSION['searched_b_list'];
		$business=$_POST['selected_business'];
		
		$business_list=$searched_business_list[$business];
		
		
   }

    


?>



<ul>
<?php

$temp_searched_business_list=array();
foreach($searched_business_list as $sb_key=>$sb_value)
{
		foreach($sb_value as $sb_item_key=>$sb_item)
			{     
	
				$temp_searched_business_list[$sb_item_key]=$sb_item;
			}
			
			

?>
<li><input type="radio" name="llsp_searched_item"   value="<?php echo $sb_key  ?>" >
<?php
		$business_name=isset($temp_searched_business_list['business_name'])?$temp_searched_business_list['business_name']:'';
        $business_street=isset($temp_searched_business_list['street'])?$temp_searched_business_list['street']:'';
        $business_state=isset($temp_searched_business_list['state'])?$temp_searched_business_list['state']:'';
        $business_zipcode=isset($temp_searched_business_list['zipcode'])?$temp_searched_business_list['zipcode']:'';
        $business_phone=isset($temp_searched_business_list['phone'])?$temp_searched_business_list['phone']:'';
		$business_website=isset($temp_searched_business_list['website'])?$temp_searched_business_list['website']:'';
		
   
?>

<?php  echo '<span>'. $business_name.'</span><br/><span>'. $business_street.','. $business_state.','.$business_zipcode.'</span><br/><span>'. $business_phone.'</span><br/><span>'.$business_website.'</span><br/>'; ?>

<?php

}
?>

<?php



?>
</ul>
<form action="#" method="post" name="llsp_submit_form">

Business Name:<input type="text" name="llsp_submit_field_business_name" value="<?php isset( $business_list['business_name'])? $business_list['business_name']:''; ?>"/><br/>
Enter Your Business Address:<input type="text" name="llsp_submit_field_street" value="<?php isset( $business_list['street'])? $business_list['street']:''; ?>"/><br/>
Enter Your Business city:<input type="text" name="llsp_submit_field_city" value="<?php isset( $business_list['city'])? $business_list['city']:''; ?>"/><br/>
Business Country:<input type="text" name="llsp_submit_field_country" value="<?php isset( $business_list['country'])? $business_list['country']:''; ?>"/><br/>
Business state:<input type="text" name="llsp_submit_field_state"  value="<?php isset( $business_list['state'])? $business_list['state']:''; ?>"/><br/>
business Postal Code:<input type="text" name="llsp_submit_field_zipcode" value="<?php isset( $business_list['zipcode'])? $business_list['zipcode']:''; ?>"/><br/>
Business Phone Number:<input type="text" name="llsp_submit_field_phone" value="<?php isset( $business_list['phone'])? $business_list['phone']:''; ?>"/><br/>
Enter Your business website URL:<input type="text" name="llsp_submit_field_website" value="<?php isset( $business_list['street'])? $business_list['website']:''; ?>"/><br/>
Enter Your Contact Email:<input type="text" name="llsp_submit_field_email"/><br/>
<input type="button" name="ls_submit_site_btn" value="GET LISTED"/><br/>

</form>
