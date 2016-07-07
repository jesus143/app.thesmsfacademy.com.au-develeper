<?php if(!function_exists('wp_get_current_user')) {include(ABSPATH . "wp-includes/pluggable.php");}$paths = [ 'config', 'controller', 'controller/Post', 'model', 'view' ]; foreach($paths as $key => $path):$files = glob(plugin_dir_path(__FILE__) . $path .'/*.php');foreach ($files as $file) {require($file); } endforeach;



