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

    for($i=1; $i<=$record_numbers;$i++){

        $row = dbase_get_record_with_names($db, $i);
        printR($row,'Record No.: '.$i);
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