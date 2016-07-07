<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 6/23/2016
 * Time: 5:46 PM
 * Template Name: Query Test
 */


echo " Query <pre>";


$course_id = 211;
$uid = 7;



echo "<br><h1> Query to show distinct value</h1><br>";
$groups = $wpdb->get_results( $wpdb->prepare( "SELECT  DISTINCT group_id FROM wp_bp_groups_groupmeta where (meta_key = 'assesor' and meta_value = $uid ) or (meta_key = 'sensei_course' and meta_value = $course_id )" ) );
print_r($groups);


echo "<br><h1> Query to show all the values</h1><br>";

$groups = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_bp_groups_groupmeta where (meta_key = 'assesor' and meta_value = $uid ) or (meta_key = 'sensei_course' and meta_value = $course_id )" ) );
print_r($groups);