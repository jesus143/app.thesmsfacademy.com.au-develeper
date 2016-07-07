<?php
//need to include wp-blog-header.php so that you can tap into wordpress functions.
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

		$formId = '6';
		$form = GFAPI::get_form( $formId ); //Do not delete
		$current_user = wp_get_current_user(); //Do not delete
    	$user_id = $current_user->ID; //Do not delete



		$entry = array();
		
		$entry['form_id'] = $formId; //Do not delete
		$entry['created_by'] = $user_id; //Do not delete
		$entry['orderStatus'] = 'incomplete';
		$entry['2'] = $firmdbf['ENTITYNAME'];
		$entry[]  = 

		$entry['orderStatus'] = 'incomplete';
		
		//$importResult = $formId.GFAPI::add_entry($entry);
		
?>		