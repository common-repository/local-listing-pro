<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$business_phone=isset($result['phone'])?$result['phone']:'';
$business_website=isset($result['website'])?$result['website']:'';
$business_street=isset($result['street'])?$result['street']:'';

$business_city=isset($result['city'])?$result['city']:'';

$business_state=isset($result['state'])?$result['state']:'';
$business_zipcode=isset($result['zipcode'])?$result['zipcode']:'';

if($business_street!='' && $business_city!=''  && $business_state!=''   && $business_zipcode!='' )
{
$address=$business_street.','.$business_city.','.$business_state.','.$business_zipcode;
}
else
{
$address='';
}


?>
<span class="addres_user">
<label class="firm_name">
 <?php 
 
 echo  isset($result['business_name'])?$result['business_name']:''; 
 
 ?>
  </label>
</br><?php	echo $address ?>
</br><?php  echo $business_phone ?>
 </br><?php echo $business_website ?>
 </span> 
