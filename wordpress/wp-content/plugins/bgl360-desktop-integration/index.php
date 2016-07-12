<?php

session_start();
/*
Plugin Name: Bgl360 Desktop Integration
Plugin URI: https://www.automationlab.com.au
Description: This will integrate bgl36o data from desktop your wordpress site
Author: Michael Barbecho
Version: 0.1
Author URI: http://michaelbarbecho.com/
Author Mail: michael@automationlab.com.au
*/

require('autoload.php');



// register jquery and style on initialization
add_action('init', 'register_script');
function register_script() {

    wp_register_script( 'custom_jquery', plugins_url('assets/js/custom-jquery.js', __FILE__), array('jquery'), '2.5.1' );

    wp_register_style( 'new_style', plugins_url('assets/css/new-style.css', __FILE__), false, '1.0.0', 'all');

    //    wp_register_style( 'bootstrap_min_css', plugins_url('assets/css/bootstrap.min.css', __FILE__ ), false, '1.0.0', 'all');
}

// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'enqueue_style');

function enqueue_style(){
    wp_enqueue_script('custom_jquery');

    wp_enqueue_style( 'new_style' );

    //    wp_enqueue_style( 'bootstrap_min_css' );
}

function my_init_method() {
//    wp_deregister_script( 'jquery' );
//    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
}

//add_action('init', 'my_init_method');
?>





