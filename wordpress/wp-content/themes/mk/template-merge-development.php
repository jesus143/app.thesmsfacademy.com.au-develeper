<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 6/18/2016
 * Time: 12:29 PM
 *
 * Template Name: Template Merge Development
 */

$current_user = wp_get_current_user();
/**
 * @example Safe usage: $current_user = wp_get_current_user();
 * if ( !($current_user instanceof WP_User) )
 *     return;
 */
echo 'Username: ' . $current_user->user_login . '<br />';
echo 'User email: ' . $current_user->user_email . '<br />';
echo 'User first name: ' . $current_user->user_firstname . '<br />';
echo 'User last name: ' . $current_user->user_lastname . '<br />';
echo 'User display name: ' . $current_user->display_name . '<br />';
echo 'User ID: ' . $current_user->ID . '<br />';
?>

<center>
<h1> This is the title of the page </h1>
</center>

<?php

if(!empty($_GET['tmid'])) {
    $tmid = intval($_GET['tmid']);
} else {
    $tmid = 7;
}


echo " <br><br> <b> Template Merge Doc Id: $tmid </b> <br><br>";

$sql = "SELECT * FROM wp_tpl_templatemerge WHERE id= '".$tmid."' ";
$results = $wpdb->get_results($sql) or die(mysql_error());

echo "<pre>";
// print_r($results);
// echo " <br><br>serialize <br><br>";
// echo " <br><br> meta " . $results[0]->meta;
// $meta1 = json_decode($results[0]->meta, true);
$meta1 = unserialize($results[0]->meta);
$files = $meta1['files'];


echo "<br><br><span style='color:red'>Final Coding</span><br><br> ";





$proceed = 0;
$tpl_values = array();
$entry = array();
$counter=0;
foreach($files as $key => $file) {

    echo '<br> key = ' . $key . '';

    $tpl_values =  (rand(0,1) == 1) ? array("testing", "testing 1", "testing 2") : array("testing", "testing 1", "testing 2");

    if(!empty($file['filepath'])){
        $proceed = 1;
    }

    if($proceed == 1 && !empty($tpl_values)){
        $tpls[] = array('file'=>$file,'values'=>$tpl_values);
    }

   
    $remove = 0;

    // get the total operator in the file
    $totalOperatorInFile    = getTotalOperatorInFile($file);

    for($i=1; $i<=$totalOperatorInFile; $i++) {

        $operatorTotalParameter = getOperatorTotalParameter($i, $file);

        //form field value ex: form_fields_1, form_fields_2, form_fields_3 and etc....
        $fieldValue                 = getFieldValue($i, $file); 
         $form_field_entry_values   = explode("|",$entry[$fieldValue]);










        echo "<br> i = "  .$i . ".) operatorTotalParameter = $operatorTotalParameter";

        echo " | field value = $fieldValue ";
        echo (empty($fieldValue)) ? "<span style='color:red'>no parameter should be checked and display</span> " : "<span style='color:green'>parameter should be checked and display</span>";

        if(!empty($fieldValue)) {
            for ($j = 1; $j <= $operatorTotalParameter; $j++) {

                // this will get the parameter value
                $operatorParameterValue = getOperatorParameterValue($i, $j, $file);

                echo ' <br> j = ' . $j . ")  operatorParameterValue = $operatorParameterValue";

                if(!empty($operatorParameterValue) && $operatorParameterValue != $form_field_entry_values[0]) {
                    $remove = 1;
                }else if(empty($operatorParameterValue) && empty($entry[$fieldValue])) {
                    $remove = 1;
                }
                if($remove == 1) {
                    array_pop($tpls);
                }
            }
        } 

        else { 
            // I dont think if this is in used.
            if(!empty($operatorParameterValue) && !empty($fieldValue) && $operatorParameterValue != $form_field_entry_values) { 
                array_pop($tpls);
            }else if(empty($operatorParameterValue) && !empty($fieldValue) && empty($entry[$fieldValue])) { 
                array_pop($tpls);
            }
        }
    }
}

function getTotalOperatorInFile($file, $keyName = 'operator_value_total') {
    return $file[$keyName];
}
function getOperatorTotalParameter($i, $file) {
    return count($file['operator_values_'.$i]);
}
function getOperatorParameterValue($i, $j, $file) {
    return $file['operator_values_'.$i]['operator_values_'.$i.'_'.$j];
}
function getFieldValue($i, $file) {
    return $file['form_fields_'.$i];
}








echo "<br><br>";
print_r($meta1['files']);
// print_r($meta1['files'][15]);
echo "</pre>";



































//
//
//$proceed = 0;
//$tpl_values = array();
//$entry = array();
//$counter=0;
//foreach($files as $key => $file) {
//
//
//    echo '<br> key = ' . $key . '';
//
//
//    $tpl_values =  (rand(0,1) == 1) ? array("testing", "testing 1", "testing 2") : array();
//
//    if(!empty($file['filepath'])){
//        $proceed = 1;
//    }
//
//    if($proceed == 1 && !empty($tpl_values)){
//        $tpls[] = array('file'=>$file,'values'=>$tpl_values);
//    }
//
//    $form_field_entry_values   = explode("|",$entry[$file['form_fields_1']]);
//
//
//
//    $operator_values_total     = count($file['operator_values_1']);
//    $operator_values_array     = count($file['operator_values_1']);
//
//
//    //get total operator value
//    $operator_value_total = $file['operator_value_total'];
//
//
//    $form_fields_1 = $file['form_fields_1'];
//    $remove = 0;
//
//
//
//    // echo "| Total Operator " . $operator_value_total . ' ';
//
//
//    $totalOperatorInFile    = getTotalOperatorInFile($file);
//
//    for($i=1; $i<=$totalOperatorInFile; $i++) {
//
//        $operatorTotalParameter = getOperatorTotalParameter($i, $file);
//
//        $fieldValue             = getFieldValue($i, $file);
//
//        echo "<br> i = "  .$i . ".) operatorTotalParameter = $operatorTotalParameter  ";
//        for($j=1; $j<=$operatorTotalParameter; $j++) {
//            $operatorParameterValue = getOperatorParameterValue($i, $j, $file);
//
//            echo ' <br> j = ' . $j . ")  operatorParameterValue = $operatorParameterValue";
//        }
//    }
//
//    if(false):
//        // Execute the test validation in order to remove
//        if(!empty($file['form_fields_1'])) {
//            for($i1=0; $i1<$operator_values_total; $i1++) {
//                $operator_values_1_1 = $operator_values_array['operator_values_1_1'];
//                if(!empty($operator_values_1_1) && !empty($form_fields_1) && $operator_values_1_1 != $form_field_entry_values[0]) {
//                    $remove = 1;
//                }else if(empty($operator_values_1_1) && !empty($form_fields_1) && empty($entry[$form_fields_1])) {
//                    $remove = 1;
//                }
//                if($remove == 1) {
//                    //echo "remove";
//                    array_pop($tpls);
//                }
//            }
//        } else {
//            if(!empty($operator_values_1_1) && !empty($form_fields_1) && $operator_values_1_1 != $form_field_entry_values) {
//                array_pop($tpls);
//            }else if(empty($operator_values_1_1) && !empty($form_fields_1) && empty($entry[$form_fields_1])) {
//                array_pop($tpls);
//            }
//        }
//    endif;
//    echo "<br> <hr>  ";
//}
//
//













//
//
//if(false):
//    // Execute the test validation in order to remove
//    if(!empty($file['form_fields_1'])) {
//        for($i1=0; $i1<$operator_values_total; $i1++) {
//
//
//            $operator_values_1_1 = $operator_values_array['operator_values_1_1'];
//            if(!empty($operator_values_1_1) && !empty($form_fields_1) && $operator_values_1_1 != $form_field_entry_values[0]) {
//                $remove = 1;
//            }else if(empty($operator_values_1_1) && !empty($form_fields_1) && empty($entry[$form_fields_1])) {
//                $remove = 1;
//            }
//            if($remove == 1) {
//                //echo "remove";
//                array_pop($tpls);
//            }
//
//
//        }
//    } else {
//        if(!empty($operator_values_1_1) && !empty($form_fields_1) && $operator_values_1_1 != $form_field_entry_values) {
//            array_pop($tpls);
//        }else if(empty($operator_values_1_1) && !empty($form_fields_1) && empty($entry[$form_fields_1])) {
//            array_pop($tpls);
//        }
//    }
//endif;
//echo "<br> <hr>  ";