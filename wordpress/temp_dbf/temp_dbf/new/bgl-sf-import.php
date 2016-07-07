<?php /* Template Name: BGL360 Import */  //get_header();

    error_reporting('-1');
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require_once( $_SERVER['DOCUMENT_ROOT']."\wp-blog-header.php");
    if($current_user->ID < 1) { header("location: https://app.thesmsfacademy.com.au/wp-login.php"); }
    global $wpdb;

    $dbf_file = 'chart.dbf';
    $db = dbase_open($dbf_file, 2);

    $chart = array();

    if ($db) {

        $record_numbers = dbase_numrecords($db);

        for($i=1; $i<=$record_numbers;$i++){
            $row = dbase_get_record_with_names($db, $i);

            if(substr($row['ACODE1'],0,1) == 5 && trim($row['PCODE']) <> '') {

                if(!array_key_exists($row['PCODE'],$chart)){

                    $chart[] = $row;
                }

            }
        }

        //printR($chart,'Filtered from Chart.dbf');
    }

    $people = dbf_arr('people.dbf');
    $funddefs = dbf_arr('funddefs.dbf');
    $office = dbf_arr('office.dbf');
    $firm = dbf_arr('firm.dbf');

    function show_record_with_names($dbf_file){

        // Open the newly copied dbf file
        echo '<h1>'.$dbf_file.'</h1><hr/>';
        $db = dbase_open($dbf_file, 2);
        if ($db) {
            $record_numbers = dbase_numrecords($db);
            for($i=1; $i<=$record_numbers;$i++){
                $row = dbase_get_record_with_names($db, $i);
                printR($row,'Record No.: '.$i);
            }
        }

        return;
    }

    function dbf_arr($dbf_file){

        $db = dbase_open($dbf_file, 2);

        $arr = array();

        if ($db) {

            $record_numbers = dbase_numrecords($db);

            for($i=1; $i<=$record_numbers;$i++){

                $row = dbase_get_record_with_names($db, $i);
                $arr[] = $row;

            }
        }

        return $arr;
    }


    function printR($array,$title=''){

        if(is_array($array)){

            echo $title."<br/>".
                "||---------------------------------||<br/>".
                "<pre>";
            print_r($array);
            echo "</pre>".
                "END ".$title."<br/>".
                "||---------------------------------||<br/>";

        }else{
            echo $title."<br/>"."<pre>".$array.'</pre>';
        }
    }

    function recursive_array_search($needle,$haystack) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }


    function recursive_array_searchby_key($needle,$haystack,$key) {

        $n_array = array();
        foreach($haystack as $k => $v):

            if(is_array($v)){

                foreach($v as $vk => $vv):
                    if($vk==$key){
                        $n_array[$k][$key] = $vv;
                    }
                endforeach;

            }else{
                if($k==$key){
                    $n_array[$k] = $v;
                }

            }



        endforeach;
        $return = recursive_array_search($needle,$n_array);
        return ($return);


    }

$formId = 6;
    $i = 0;

    $formId		  		  = 6;
    $form 		  		  = GFAPI::get_form( $formId );
    $title 		  		  = '';
    $current_user   	  = wp_get_current_user();
    $user_id 	          = $current_user->ID;
    $entry                = array();
    $entry['form_id']     = $formId;
    $entry['created_by']  = $user_id;
    $entry['orderStatus'] = 'incomplete';
    $numMembers 		  = $firm[0]['MEMBERS'];


            $entry['2']     = $firm[$i]['ENTITYNAME'];
			$entry['137']   = 'BGL SF Desktop Import';
            $entry['139']   = 'Other Address';
            $entry['337']   = 'Other Address'; 
            $entry['357']   = 'Manual Address Input';
            $entry['358']   = 'Manual Address Input';
            /* Fund Address */
            $people_trustee_key = recursive_array_searchby_key($firm[$i]['TRUSTEE'],$people,'PCODE'); //
            $pcode = $people[$people_trustee_key]['PCODE'];
            $rcode = $people[$people_trustee_key]['ROCODE'];
            $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
            $fund_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];

            $entry['338']     = $fund_address;
            /*/ Fund Address */

            /* PTYPE */
            $ptype = $people[$people_trustee_key]['PTYPE'];
            if($ptype == 'j'){
                $entry['111'] = 'Individuals';
            }else{
                $entry['111'] = 'Company - Already Registered';
            }
            /*/ PTYPE */

            /* FIRM */
            $entry['12']     = $firm[$i]['MEMBERS'];
            /*/ FIRM */


            //$entry['137']   = $funddefs['DEFVAL'];



            if($people['PTYPE']=='J'){
                $entry['111']   = 'Individuals';
            }else{
                $entry['111']   = 'Individuals';
            }
                $entry['104'] = 'Other Address';

            $people_pcode_key = recursive_array_searchby_key($chart[$i]['PCODE'],$people,'PCODE');


            if($numMembers == 4)
            { //4 members
                $people_pcode_key = recursive_array_searchby_key($chart[0]['PCODE'],$people,'PCODE');
                /* Member 1*/
                $entry['71']   = $people[$people_pcode_key]['TITLE'];
                $entry['14']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['72']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['417']   = $people[$people_pcode_key]['SEX'];
                $entry['323']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['81']   = $people[$people_pcode_key]['PTFN'];
                $entry['15']   = date('d/m/Y',$people[$people_pcode_key]['PDOB']);

                $entry['17'] = "Other Address";
                $entry['359.1'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['316']     = $member_address;
                /** Member 1 */

                $people_pcode_key = recursive_array_searchby_key($chart[1]['PCODE'],$people,'PCODE');
                /* Member 2*/
                $entry['73']   = $people[$people_pcode_key]['TITLE'];
                $entry['25']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['74']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['418']   = $people[$people_pcode_key]['SEX'];
                $entry['324']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['82']   = $people[$people_pcode_key]['PTFN'];
                $dob = $people[$people_pcode_key]['PDOB'];
                $entry['24']   = substr($dob,6,2).'/'.substr($dob,4,2).'/'.substr($dob,0,4);

                $entry['169'] = "Other Address";
                $entry['360'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE');
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['317']     = $member_address;
                /** Member 2 */

                $people_pcode_key = recursive_array_searchby_key($chart[2]['PCODE'],$people,'PCODE');
                /* Member 3*/
                $entry['75']   = $people[$people_pcode_key]['TITLE'];
                $entry['33']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['76']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['419']   = $people[$people_pcode_key]['SEX'];
                $entry['325']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['83']   = $people[$people_pcode_key]['PTFN'];
                $entry['34']   = $people[$people_pcode_key]['PDOB'];

                $entry['170'] = "Other Address";
                $entry['361'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['318']     = $member_address;
                /** Member 3 */

                $people_pcode_key = recursive_array_searchby_key($chart[3]['PCODE'],$people,'PCODE');
                /* Member 4*/
                $entry['77']   = $people[$people_pcode_key]['TITLE'];
                $entry['42']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['78']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['420']   = $people[$people_pcode_key]['SEX'];
                $entry['326']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['84']   = $people[$people_pcode_key]['PTFN'];
                $entry['43']   = $people[$people_pcode_key]['PDOB'];

                $entry['184'] = "Other Address";
                $entry['362'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['319']     = $member_address;
                /** Member 4 */

            }
            elseif($numMembers == 3)
            {  // 3 members

                $people_pcode_key = recursive_array_searchby_key($chart[0]['PCODE'],$people,'PCODE');
                /* Member 1*/
                $entry['71']   = $people[$people_pcode_key]['TITLE'];
                $entry['14']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['72']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['417']   = $people[$people_pcode_key]['SEX'];
                $entry['323']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['81']   = $people[$people_pcode_key]['PTFN'];
                $entry['15']   = $people[$people_pcode_key]['PDOB'];

                $entry['17'] = "Other Address";
                $entry['359.1'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['316']     = $member_address;
                /** Member 1 */

                $people_pcode_key = recursive_array_searchby_key($chart[1]['PCODE'],$people,'PCODE');
                /* Member 2*/
                $entry['73']   = $people[$people_pcode_key]['TITLE'];
                $entry['25']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['74']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['418']   = $people[$people_pcode_key]['SEX'];
                $entry['324']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['82']   = $people[$people_pcode_key]['PTFN'];
                $dob = $people[$people_pcode_key]['PDOB'];
                $entry['24']   = substr($dob,6,2).'/'.substr($dob,4,2).'/'.substr($dob,0,4);

                $entry['169'] = "Other Address";
                $entry['360'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE');
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['317']     = $member_address;
                /** Member 2 */

                $people_pcode_key = recursive_array_searchby_key($chart[2]['PCODE'],$people,'PCODE');
                /* Member 3*/
                $entry['75']   = $people[$people_pcode_key]['TITLE'];
                $entry['33']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['76']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['419']   = $people[$people_pcode_key]['SEX'];
                $entry['325']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['83']   = $people[$people_pcode_key]['PTFN'];
                $entry['34']   = $people[$people_pcode_key]['PDOB'];

                $entry['170'] = "Other Address";
                $entry['361'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['318']     = $member_address;
                /** Member 3 */

            }
            elseif($numMembers == 2)
            { //2 members

                $people_pcode_key = recursive_array_searchby_key($chart[0]['PCODE'],$people,'PCODE');

                /* Member 1*/
                $entry['71']   = $people[$people_pcode_key]['TITLE'];
                $entry['14']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['72']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['417']   = $people[$people_pcode_key]['SEX'];
                $entry['323']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['81']   = $people[$people_pcode_key]['PTFN'];
                $dob = $people[$people_pcode_key]['PDOB'];
                $entry['15']   = substr($dob,6,2).'/'.substr($dob,4,2).'/'.substr($dob,0,4);

                $entry['17'] = "Other Address";
                $entry['359.1'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];

                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['316']     = $member_address;
                /** Member 1 */

                $people_pcode_key = recursive_array_searchby_key($chart[1]['PCODE'],$people,'PCODE');

                /* Member 2*/
                $entry['73']   = $people[$people_pcode_key]['TITLE'];
                $entry['25']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['74']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['418']   = $people[$people_pcode_key]['SEX'];
                $entry['324']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['82']   = $people[$people_pcode_key]['PTFN'];
                $dob = $people[$people_pcode_key]['PDOB'];
                $entry['24']   = substr($dob,6,2).'/'.substr($dob,4,2).'/'.substr($dob,0,4);

                $entry['169'] = "Other Address";
                $entry['360'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE');
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['317']     = $member_address;
                /** Member 2 */

            }
            else
            {

                $people_pcode_key = recursive_array_searchby_key($chart[0]['PCODE'],$people,'PCODE');
                /* Member 1*/
                $entry['71']   = $people[$people_pcode_key]['TITLE'];
                $entry['14']   = $people[$people_pcode_key]['PFIRSTNAME'];
                $entry['72']   = $people[$people_pcode_key]['PSURNAME'];
                $entry['417']   = $people[$people_pcode_key]['SEX'];
                $entry['323']   = $people[$people_pcode_key]['PFIRSTNAME']. ' '.$people[$people_pcode_key]['PSURNAME'];
                $entry['81']   = $people[$people_pcode_key]['PTFN'];

                $dob            = $people[$people_pcode_key]['PDOB'];
                $entry['15']   = substr($dob,6,2).'/'.substr($dob,4,2).'/'.substr($dob,0,4);

                $entry['17'] = "Other Address";
                $entry['359.1'] = "Manual Address Input";
                $pcode = $people[$people_pcode_key]['PCODE'];
                $rcode = $people[$people_pcode_key]['ROCODE'];
                $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
                $member_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];
                $entry['316']     = $member_address;
                /** Member 1 */
            }

            /* Fund Address */
            $people_regadd_key = recursive_array_searchby_key($firm[$i]['REGADD'],$people,'PCODE'); //
            $pcode = $people[$people_regadd_key]['PCODE'];
            $rcode = $people[$people_regadd_key]['ROCODE'];
            $office_rcode_key = recursive_array_searchby_key($rcode,$office,'ROCODE'); //
            $fund_address   = $office[$office_rcode_key]['ROADD1'].' '.$office[$office_rcode_key]['ROADD2'].' '.$office[$office_rcode_key]['ROADD3'].' '.$office[$office_rcode_key]['STATE'].' '.$office[$office_rcode_key]['ROADD4'];

            $entry['416']     = $fund_address;
            /*/ Fund Address */

            /* Care Of */
            $entry['265']   = $office[$office_rcode_key]['PSURNAME'];
            /*/ Care Of */

    printR($entry,'ENTRY');
    // Add entry to database
    $importResult = $formId.' - '.GFAPI::add_entry($entry);
    echo 'Import: '.$importResult;

 // End post
