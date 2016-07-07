<?php
error_reporting('-1');
error_reporting(E_ALL);
ini_set("display_errors", 1); 
define('WP_USE_THEMES', false);
define('STYLESHEETPATH', '');
define('TEMPLATEPATH', '');
require "D:\\inetpub\\app\\wwwroot\\wp-blog-header.php";
global $wpdb;

/*

$db_file = 'test_people.dbf';

$db_structure = array
(
    array ('album', 'C', 64),     # A field called 'album title' - holds up to 64 characters
    array ('artist', 'C', 64),    # A field called 'artist' - holds up to 64 characters
    array ('year', 'N', 4, 0),    # A field called 'year' - holds an integer of up to 4 digits
    array ('label', 'C', 64),     # A field called 'record label' - holds up to 64 characters
    array ('loaned', 'L'),        # A field called 'loaned' - holds 1 or 0
    array ('last_loan', 'C', 64), # A field called 'last_loaned_to' - holds up to 64 characters
    array ('notes', 'C', 256)     # A field called 'note' - holds up to 256 characters
);

# Create database or exit with an error message
$db_id = dbase_create ($db_file, $db_structure)
or die ("Could not create dbf file '$db_file'\n");

# Print success message
print "dbf file '$db_file' created\n";

// open in read-write mode
$db = dbase_open('test_people.dbf', 2);

if ($db) {

    for($i=1;$i<=10;$i++) {
        dbase_add_record($db, array(
            date('aaaa'),
            'Maxim Topolov',
            '1940',
            'saadsadsa',
            1,
            'dsadsadsa',
            'sasdassddsas'));
    }

    dbase_close($db);
}

$db3 = dbase_open('test_people.dbf', 2);
if($db3) {
    $record_numbers = dbase_numrecords($db3);
    echo 'Counts : '.$record_numbers;

}
return;
*/
//  Copy Original DBF and create new one

$people_orig_file = '../people.dbf';
$people_new_file = 'new_people.dbf';

if (!copy($people_orig_file, $people_new_file)) {
    die("Failed to copy file people.dbf");
}

// Open the newly copied dbf file
$db = dbase_open('new_people.dbf', 2);

if ($db) {

    $record_numbers = dbase_numrecords($db);
    $column_info = dbase_get_header_info($db);
    $p = 1;
    foreach($column_info as $ck=> $cv):

        foreach($cv as $cvk=> $cvv):
            $structure_arr[] = $cvv;
        endforeach;
        $new_structure_arr[] = $structure_arr;
           // echo $p.': N:'.$structure_arr[0].' | '.'T:'.$structure_arr[1].' | '.'L:'.$structure_arr[2].' | '.'P:'.$structure_arr[3].'<br/>';
        unset($structure_arr);
    $p++;
    endforeach;

    // Remove Field with data type of Memo
    //unset($new_structure_arr[124]);

    $db_file = 'test_people.dbf';

    # Create database or exit with an error message
    $db_id = dbase_create ($db_file, $new_structure_arr)
    or die ("Could not create dbf file '$db_file'\n");

    # Print success message
    print "dbf file '$db_file' created\n";

    dbase_close($db);

    //printR($record_numbers,'Number of Records - after deletion');

    $db2 = dbase_open('test_people.dbf', 2);
    if($db2){
        echo "Opened '$db_file' \n";
        $record_numbers = dbase_numrecords($db2);
        $header_info2 = dbase_get_header_info ($db2);

        //var_dump($header_info2);
        printR($header_info2);

            dbase_add_record($db2, array(   'JOHNAN0','A','A','O','A','JONES','JOHN','A','A','M',
                '113822','A','','','5/9/1947','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','','A','','A',
                'A','A','','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A',5,2,'A','A','A','','A','A','',
                'A','A','A','A',1,'A','A','','A','A',
                'A','A','A','A',5,'A','A','','A','A',
                '','A','A','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A','A',4,'A','','','','s','aa'));
            dbase_add_record($db2, array(   'JONESJ6','A','A','I','A','JOHN AND MARY JONES','MARY','A','A','F',
                '113829','A','','','5/9/1947','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','','A','','A',
                'A','A','','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A',5,2,'A','A','A','','A','A','',
                'A','A','A','A',1,'A','A','','A','A',
                'A','A','A','A',5,'A','A','','A','A',
                '','A','A','A','A','A','A','A','A','A',
                'A','A','A','A','A','A','A','A','A','A',
                'A','A',4,'A','','','','s1','aa'));


        dbase_close($db);
    }

    $db3 = dbase_open('test_people.dbf', 2);

    if($db3) {
        $record_numbers = dbase_numrecords($db3);
        echo 'Counts : '.$record_numbers;
        for($i=1; $i<=$record_numbers;$i++){

            $row = dbase_get_record_with_names($db3, $i);
            printR($row,$i);
        }

    }

    // Display information
    // print_r($column_info);

    $record_numbers2 = dbase_numrecords($db2);
    //var_dump($record_numbers2);


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