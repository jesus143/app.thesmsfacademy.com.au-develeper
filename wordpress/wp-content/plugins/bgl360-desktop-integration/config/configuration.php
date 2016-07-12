<?php
$current_user = wp_get_current_user();


//set username when user uploaded the .zip files
define('bgl360_di_upload_zip_file_dir', plugin_dir_path(__DIR__) . 'upload/' . $current_user->user_login);
define('bgl360_di_upload_zip_file_dir_sub', $current_user->user_login);



//Path to the uploaded .zip file need to change
define('bgl360_di_dbf_uploaded_file_path' , bgl360_di_upload_zip_file_dir . '/BGL Desktop Integration/temp_dbf/new/');

define('bgl360_di_fund_deffs', bgl360_di_dbf_uploaded_file_path . 'funddefs.dbf');
define('bgl360_di_people_dbf', bgl360_di_dbf_uploaded_file_path . 'people.dbf');
define('bgl360_di_firm_dbf',   bgl360_di_dbf_uploaded_file_path . 'firm.dbf');
define('bgl360_di_office_dbf', bgl360_di_dbf_uploaded_file_path . 'office.dbf');
define('bgl360_di_chart_dbf',  bgl360_di_dbf_uploaded_file_path . 'chart.dbf');


define('bgl360_di_page_name_parent', 'bgl360');
define('bgl360_di_page_name_upload', 'upload');
define('bgl360_di_page_name_import', 'import');

//define('bgl360_di_zip_upload_path', );
$_SESSION['bgl360_di_uploaded_file_settings'] = (!empty($_SESSION['bgl360_di_uploaded_file_settings'])) ? $_SESSION['bgl360_di_uploaded_file_settings'] : null;

$_SESSION['bgl360_di_uploaded_file_path_to_folder'] = (!empty($_SESSION['bgl360_di_uploaded_file_path_to_folder'])) ? $_SESSION['bgl360_di_uploaded_file_path_to_folder'] : null;


$_SESSION['bgl360_di_forms'] = array( array('form_id'=>0, 'form_name'=>'- Select One -') , array('form_id'=>6, 'form_name'=>'NEW SMSF'));



//$_SESSION['bgl360_di_custom_upload_name']  = '';