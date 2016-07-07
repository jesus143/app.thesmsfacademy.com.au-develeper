<?php
if(isset($_POST['bgl360_dt_upload'])) {
    echo "<br>upload file";
    wp_redirect( site_url() . '/'. bgl360_di_page_name_parent . '/' . bgl360_di_page_name_import ); exit;
} else if(isset($_POST['bgl360_di_import'])) {
    echo "<br> import file";
}




