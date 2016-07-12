<?php



if(isset($_POST['bgl360_di_import'])) {

    $current_user = wp_get_current_user();
    $fund = new \App\Fund();
    $trustee = new \App\Trustees();

    if ($_POST['import_at'] == 6)
    {

        $fund_member_selected = $_POST['fundMemberSelected'];
        $formId = $_POST['import_at'];
        $user_id = $current_user->ID;

        $entry['orderStatus'] = 'incomplete';
        $entry['137'] = 'BGL SF Desktop Import';
        $entry['139'] = 'Other Address';
        $entry['337'] = 'Other Address';
        $entry['357'] = 'Manual Address Input';
        $entry['358'] = 'Manual Address Input';

        $entry['2']   = $trustee->fundName;
        $entry['338'] = $trustee->trusteeAddress;
        $entry['111'] = $trustee->trusteeType;
        $entry['12']  = $fund->fundMemberTotal;

        $member_counter = 1;
        for ($i = 0; $i < $fund->fundMemberTotal; $i++) {

            $fund->getFundMembers($i);

            if ($member_counter == 1)
            {
                $entry['71'] = $fund->fundMemberTitle;
                $entry['14'] = $fund->fundMemberFirstName;
                $entry['72'] = $fund->fundMemberSureName;
                $entry['417'] = $fund->fundMemberGender;
                $entry['323'] = $fund->fundMemberFullName;
                $entry['81'] = $fund->fundMemberTFN;
                $entry['15'] = $fund->fundMemberDOB;
                $entry['17'] = "Other Address";
                $entry['359.1'] = "Manual Address Input";
                $entry['316'] = $fund->fundMemberAddress;
            }
            else if ($member_counter == 2)
            {
                $entry['73'] = $fund->fundMemberTitle;
                $entry['25'] = $fund->fundMemberFirstName;
                $entry['74'] = $fund->fundMemberSureName;
                $entry['418'] = $fund->fundMemberGender;
                $entry['324'] = $fund->fundMemberFullName;
                $entry['82'] = $fund->fundMemberTFN;
                $entry['24'] = $fund->fundMemberDOB;
                $entry['169'] = "Other Address";
                $entry['360.1'] = "Manual Address Input";
                $entry['317'] = $fund->fundMemberAddress;
            }
            else if ($member_counter == 3)
            {
                // code here
            }
            else
            {
                // code here
            }

            $member_counter++;
        }

        // Fund Address
        $entry['416'] = $trustee->trusteeAddress;

        // Care Of
        $entry['265'] = 'undefined yet';
        echo "<pre>";
            print_r($entry);
        echo "<pre>";

    }

    if($_POST['import_at'] > 0) {

        print_r($_SESSION);

        //unlink($_SESSION['bgl360_di_uploaded_file_path_to_folder']);
        //  unlink($_SESSION['bgl360_di_uploaded_file_settings']['file']);
    }
}