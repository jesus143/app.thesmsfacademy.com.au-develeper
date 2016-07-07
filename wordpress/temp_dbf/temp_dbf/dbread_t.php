<?php
error_reporting('-1');
error_reporting(E_ALL);
ini_set("display_errors", 1); 
define('WP_USE_THEMES', false);
define('STYLESHEETPATH', '');
define('TEMPLATEPATH', '');
require "D:\\inetpub\\app\\wwwroot\\wp-blog-header.php";
global $wpdb;

//  Copy Original DBF and create new one
$people_orig_file = '../people.dbf';
$people_new_file = 'new_people_tim.dbf';
if (!copy($people_orig_file, $people_new_file)) {
    die("Failed to copy file people.dbf");
}
$db = dbase_open('new_people_tim.dbf', 2);

if ($db) {
    $record_numbers = dbase_numrecords($db);
    printR($record_numbers,'Original Number of Records');

    for ($i = 1; $i <= $record_numbers; $i++) {
		
        $row = dbase_get_record($db, $i);
        $nf  = dbase_numfields($db);
        echo 'Fields: '.$nf.'<br/><br/>';    
        //$delete_row = dbase_delete_record($db, $i);
		echo print_r($row, true).'<br/>';
		unset($row['deleted']); // drop the field 
        // Update the date field with the current timestamp
		//$row = array_map(create_function('$n', 'return null;'), $row);       
        $row[0] = 'JOSEPH1234';	
		$row[127] = '';
		$row[128] = '';
        // Replace the record
		//$rarr = array(); //
    	//foreach ($row as $j=>$vl) $rarr[] = $vl; 
 		
 		//echo 'New NEW Row: '.print_r($row, true).'<br/>';
        if(dbase_add_record($db, $row)){
        	echo 'Success<br/>';
        }else {
        	echo 'Failed<br/>';
        }
        echo print_r($row, true).'<br/><br/>';

    }
    
    // Get column information
    $column_info = dbase_get_header_info($db);
    printR($column_info,'Column Info');

    //Re pack the dbf
    //dbase_pack($db);
    dbase_close($db);

    
    //printR($record_numbers,'Number of Records - after deletion');


//

    


// Query Wordpress DB

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

function printR($array,$title=''){

    if(is_array($array)){

        echo $title."<br/>".
            "||---------------------------------||<br/>".
            "<pre>";
        print_r($array);
        echo "</pre>".
            "END ".$title."<br/>".
            "||---------------------------------||<br/>";

    }else{
        echo $title."<br/>"."<pre>".$array.'</pre>';
    }
}


?>