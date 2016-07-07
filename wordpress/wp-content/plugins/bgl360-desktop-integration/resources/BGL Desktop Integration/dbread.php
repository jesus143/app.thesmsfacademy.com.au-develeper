<?php
error_reporting('-1');
error_reporting(E_ALL);
ini_set("display_errors", 1); 
define('WP_USE_THEMES', false);
define('STYLESHEETPATH', '');
define('TEMPLATEPATH', '');
require "D:\\inetpub\\app\\wwwroot\\wp-blog-header.php";
global $wpdb;








//$db = dbase_open('funddefs.dbf', 0);
$db = dbase_open('people.dbf', 0);

if ($db) {
    $record_numbers = dbase_numrecords($db);
    $a = dbase_get_record_with_names($db, 1);
    //var_dump($a);
    $myfile = fopen("/temp_dbf/_test.txt", "w") or die("Unable to open file!");

    // creation
    if (!dbase_create('/temp_dbf/_temp.dbf', $a)) {
        echo "Error, can't create the database\n";
    }


  for ($i = 1; $i <= $record_numbers; $i++) {
      $row = dbase_get_record_with_names($db, $i);
        //var_dump($row);
      		
      		//echo $row['PCODE'].' '.$row['PSURNAME'].'<br/>';
      	
      
//      echo print_r($row,true);
      //if ($row['ismember'] == 1) {
       //   echo "Member #$i: " . trim($row['name']) . "\n";
      //}
  }

    return;

$leads = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."rg_lead WHERE orderStatus='complete' AND created_by='76'  " ,"")  );  
  if(!empty($leads)){
			echo "There are leads<br/> ";
			foreach($leads as $lead){
				$form = GFAPI::get_form( $lead->form_id);
				$entry = GFAPI::get_entry($lead->id);
				$fields = $form['fields'];
				if($form['title'] == 'New SMSF'){
				echo '<h2>'.$form['title'].'</h2><br/>';
				foreach($fields as $field){
					if(strlen($field->adminLabel)>0){
						echo $field->adminLabel.' : '.$entry[$field->id].'<br/>';
					}
				}
				//echo 'Form: '.print_r($fields, true).'<br/>';
				}
			}
		}
		else{
			echo "No Leads To Generate Docs";
		}
}
?>

