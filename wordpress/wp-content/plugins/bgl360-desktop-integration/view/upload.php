<?php

/**
 * Short code call ex: [bgl360-di-upload]
 */
add_shortcode('bgl360-di-upload', 'bgl360_di_upload');

function bgl360_di_upload ($atts, $content=null) {

    $html = '<div  class="container container-main">';

    $html .='<div class="container-sub" >';


    $html .= '<form method="POST" method="post" enctype="multipart/form-data">';

    $html .='
            <div class="row">
                <div class="col-md-8">
                    <input type="file" name="file" />
                </div>
                <div class="col-md-4">
                    <input type="submit" name="bgl360_dt_upload"   />
                </div>
            </div>';
    $html .= '</div>';

    $html .= '</form>';

    $html .= '</div>';

    return $content . $html;
}





