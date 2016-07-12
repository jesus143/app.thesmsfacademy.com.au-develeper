<?php

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

function dbf_arr($dbf_file){

    $db = dbase_open($dbf_file, 2);

    $arr = array();

    if ($db) {

        $record_numbers = dbase_numrecords($db);

        for($i=1; $i<=$record_numbers;$i++){

            $row = dbase_get_record_with_names($db, $i);
            $arr[] = $row;

        }
    }

    return $arr;
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

function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

function recursive_array_searchby_key($needle,$haystack,$key) {

    $n_array = array();
    foreach($haystack as $k => $v):

        if(is_array($v)){

            foreach($v as $vk => $vv):
                if($vk==$key){
                    $n_array[$k][$key] = $vv;
                }
            endforeach;

        }else{
            if($k==$key){
                $n_array[$k] = $v;
            }
        }
    endforeach;
    $return = recursive_array_search($needle,$n_array);
    return ($return);
}
