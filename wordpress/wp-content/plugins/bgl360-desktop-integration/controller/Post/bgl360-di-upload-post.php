<?php

if(isset($_POST['bgl360_dt_upload'])) {

    // Register our path override.
    add_filter( 'upload_dir', 'wpse_141088_upload_dir' );

    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    $uploadedfile = $_FILES['file'];


    $upload_overrides = array( 'test_form' => false);




    // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

    if ( $movefile && ! isset( $movefile['error'] ) ) {
        echo "File is valid, and was successfully uploaded.\n";
        var_dump( $movefile );
        $_SESSION['bgl360_di_uploaded_file_settings'] = $movefile;




        $_SESSION['bgl360_di_uploaded_file_path_to_folder'] = bgl360_di_get_uploaded_file_path_to_folder($movefile['file']);
    } else {
        /**
         * Error generated by _wp_handle_upload()
         * @see _wp_handle_upload() in wp-admin/includes/file.php
         */
        echo $movefile['error'];
    }

    echo "file path = " .  $movefile['file'];

    // Set everything back to normal.
    remove_filter( 'upload_dir', 'wpse_141088_upload_dir' );

    //extract file
    $zip = new ZipArchive;
    if ($zip->open($movefile['file']) === TRUE) {
        $zip->extractTo( bgl360_di_upload_zip_file_dir );
        $zip->close();
        echo 'ok';
    } else {
        echo 'failed';
    }

    //delete uploaded zip file
     unlink($movefile['file']);

    // save uploaded settings to session


    // redirect to url import
   wp_redirect( site_url() . '/'. bgl360_di_page_name_parent . '/' . bgl360_di_page_name_import ); exit;

}



