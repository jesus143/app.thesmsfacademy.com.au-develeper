

<?php if(!function_exists('wp_get_current_user')) {include(ABSPATH . "wp-includes/pluggable.php");}

require_once('helper.php');

$paths = [ 'config', 'controller', 'controller/Post', 'view' ];

foreach($paths as $key => $path):

    $files = glob(plugin_dir_path(__FILE__) . $path .'/*.php');

    foreach ($files as $file) {
        require($file);
    }
endforeach;

$path = plugin_dir_path(__FILE__);
require_once($path . '/model/People.php');
require_once($path . '/model/Office.php');
require_once($path . '/model/Firm.php');
require_once($path . '/model/Chart.php');
require_once($path . '/model/FundDeffs.php');
require_once($path . '/model/Fund.php');
require_once($path . '/model/Trustees.php');

new \App\FundDeffs();
new \App\People();
new \App\Office();
new \App\Firm();
new \App\Chart();



