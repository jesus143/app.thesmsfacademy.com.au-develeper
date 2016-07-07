<?php



/**
 * Short code call ex: [bgl360-di-import]
 */
add_shortcode('bgl360-di-import', 'bgl360_di_import');


function bgl360_di_import ($atts, $content=null) {

        $html = '<div  class="container container-main">';

        $html .='<div class="container-sub-import" style="width: 80%" >';

        $html .= '<form method="POST" />';

        $html .='<div class="row">
                <div class="col-md-8">
                    <b> Data To Be Imported </b> <br><br>
                    <ul>
                        <li> <b>Fund Name:</b> [Fund name goes here.. ]</li>
                        <li> <b>Trustee:</b> [Truestees name goes here.. ]</li>
                        <li> <b>Members:</b> [Members name goes here.. ]</li>
                     </ul>
                 </div>
                <div class="col-md-4">  </div>
            </div>';
        $html .='<br><br>';
        $html .= '<div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <p style="float:left; display: inline-block" > Which member will take the pension? </p> &nbsp; &nbsp;
                    <select>
                        <option>- Select One -</option>
                        <option>SMSF Pension</option>
                        <option>NEW SMSF</option>
                    </select>
                </div>
            </div>';
        $html .= '<div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <p style="float:left; display: inline-block" > Where would you like to import? </p> &nbsp; &nbsp;
                    <select>
                        <option>- Select One -</option>
                          <option>Tim Foster</option>
                          <option>Michael Barbecho</option>
                    </select>
                </div>
            </div>';



        $html .= '<div><input type="submit" value="Import" name="bgl360_di_import"  /></div>';

        $html .= '</div>';

    return $content . $html;
}





