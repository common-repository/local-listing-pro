<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$state_list=$result;
foreach($state_list as $state_abbr=>$state)
{
	
	echo '<option value="'.esc_attr($state_abbr).'">'.esc_attr($state).'</option>';
}

?>
