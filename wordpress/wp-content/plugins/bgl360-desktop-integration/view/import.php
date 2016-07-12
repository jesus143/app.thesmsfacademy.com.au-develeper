<?php

/**
 * Short code call ex: [bgl360-di-import]
 */
add_shortcode('bgl360-di-import', 'bgl360_di_import');


function bgl360_di_import ($atts, $content=null) {

        $fund      = new \App\Fund();
        $trustee   = new \App\Trustees();

        //echo "<br> fund name " . $trustee->fundName;

        //echo "<br> fund address " . $trustee->fundAddress;

        //print_r($_SESSION['bgl360_di_uploaded_file_settings']);


        $html = '<div  class="container container-main">';

        $html .='<div class="container-sub-import" style="width: 80%" >';

        $html .= '<form method="POST" />';

        $html .='<div class="row">
                <div class="col-md-8">
                    <b> Data To Be Imported </b> <br><br>
                    <ul>
                        <li> <b>Fund Name:</b><br> ' . $trustee->fundName . '</li>
                        <li> <b>Trustee:</b> <br>';

                                $html .=  $trustee->trusteeFullName;

                        $html .= '
                        </li>
                        <li> <b>Members:</b>';
                             for($i=0; $i<$fund->fundMemberTotal; $i++) {
                                  $fund->getFundMembers($i);
                                  $html .= '<br>';
                                  $html .= $fund->fundMemberFullName ;
                             }
                        $html .= '
                         </li>
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
                    <select name="fundMemberSelected">';

                        $html .= '<option>- Select One-</option>';
                        for($i=0; $i<$fund->fundMemberTotal; $i++) {
                            $fund->getFundMembers($i);
                            $html .= '<option value="' . $fund->fundMemberFullName . '">' . $fund->fundMemberFullName . '</option>' ;
                        }
                    $html .= '
                    </select>
                </div>
            </div>';
        $html .= '<div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <p style="float:left; display: inline-block" > Where would you like to import? </p> &nbsp; &nbsp;
                       <select name="import_at">';
                        foreach($_SESSION['bgl360_di_forms']  as $key => $form) {

                                $html .= '<option value="'  . $form['form_id']. '">' . $form['form_name'] . ' </option> ';
                        }
                     $html .= '
                     </select>
                </div>
            </div>';



        $html .= '<div><input type="submit" value="Import" name="bgl360_di_import"  /></div>';

        $html .= '</div>';

    return $content . $html;
}





