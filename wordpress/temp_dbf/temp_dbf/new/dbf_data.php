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


$dbf_file = 'chart.dbf';

echo '<h1>'.$dbf_file.'</h1><hr/>';
$db = dbase_open($dbf_file, 2);

$filtered_arr = array();

if ($db) {
    $record_numbers = dbase_numrecords($db);

    for($i=1; $i<=$record_numbers;$i++){
        $row = dbase_get_record_with_names($db, $i);

        if(substr($row['ACODE1'],0,1) == 5 && trim($row['PCODE']) <> '') {

            if(!array_key_exists($row['PCODE'],$filtered_arr)){

                $filtered_arr[$row['PCODE']] = $row;
            }

        }
    }

    printR($filtered_arr,'Filtered from Chart.dbf');
}


show_record_with_names('people.dbf');
show_record_with_names('funddefs.dbf');
show_record_with_names('office.dbf');
show_record_with_names('firm.dbf');


function show_record_with_names($dbf_file){

    // Open the newly copied dbf file
    echo '<h1>'.$dbf_file.'</h1><hr/>';
    $db = dbase_open($dbf_file, 2);
    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for($i=1; $i<=$record_numbers;$i++){
            $row = dbase_get_record_with_names($db, $i);
            printR($row,'Record No.: '.$i);
        }
    }

    return;
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