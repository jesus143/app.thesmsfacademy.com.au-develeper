<?php
error_reporting('-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);
define('WP_USE_THEMES', false);
define('STYLESHEETPATH', '');
define('TEMPLATEPATH', '');
require "D:\\inetpub\\app\\wwwroot\\wp-blog-header.php";
global $wpdb;

//show_record_with_names('chart.dbf');

$dbf_file = 'chart.dbf';

echo '<h1>'.$dbf_file.'</h1><hr/>';
$db = dbase_open($dbf_file, 2);

$filtered_arr = array();

if ($db) {
    $record_numbers = dbase_numrecords($db);
    $cnt = 1;
    for($i=1; $i<=$record_numbers;$i++){
        $row = dbase_get_record_with_names($db, $i);
        //printR($row,'Record No.: '.$i);
        if(substr($row['ACODE1'],0,1) == 5 && trim($row['PCODE']) <> '') {

            if(!array_key_exists($row['PCODE'],$filtered_arr)){
                $filtered_arr[$row['PCODE']] = $row;
            }
            printR($row,'Record No.: '.$i. ' | Count : '.$cnt);

            $cnt++;
        }
    }

    printR($filtered_arr,'With Unique PCODE');
}



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