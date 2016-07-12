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


/**
 * https://paulund.co.uk/php-delete-directory-and-files-in-directory
 * @param $dirname
 * @return bool
 * //delete folder
 * delete_directory(plugin_dir_path( __FILE__ ) . '/upload');
 */
function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}


/**
 * SRC: http://wordpress.stackexchange.com/questions/141088/wp-handle-upload-how-to-upload-to-a-custom-subdirectory-within-uploads
 */

/**
 * Override the default upload path.
 *
 * @param   array   $dir
 * @return  array
 * add_filter( 'upload_dir', 'wpse_141088_upload_dir' );
 * remove_filter( 'upload_dir', 'wpse_141088_upload_dir' );
 */
function wpse_141088_upload_dir( $dir ) {
    return array(
        'path'   => bgl360_di_upload_zip_file_dir,
        'url'    => bgl360_di_upload_zip_file_dir,
        'subdir' => bgl360_di_upload_zip_file_dir_sub,
    ) + $dir;
}



function bgl360_di_my_cust_filename($dir, $name, $ext) {
    return $_SESSION['bgl360_di_custom_upload_name'] . $ext;
}

function bgl360_di_get_uploaded_file_path_to_folder($filePath) {
    $uploadedPathToFolder = str_replace('.zip', '', $filePath);
    $uploadedPathToFolder = str_replace('.rar', '', $uploadedPathToFolder);
    return $uploadedPathToFolder;
}

