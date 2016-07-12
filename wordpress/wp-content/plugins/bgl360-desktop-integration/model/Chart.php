<?php

namespace App;

use App\People;

class Chart {

    public
        $totalMember,
        $fundMemberTitle,
        $fundMemberFirstName,
        $fundMemberSureName,
        $fundMemberGender,
        $fundMemberFullName,
        $fundMemberTFN,
        $fundMemberDOB,
        $fundMemberAddress;
    public
        $memberAddress;

    public
        $fundMemberAddressRoad1,
        $fundMemberAddressRoad2,
        $fundMemberAddressRoad3,
        $fundMemberAddressRoad4,
        $fundMemberAddressState;

    private static $chart_dbf_file;

    function __construct($chart_dbf=bgl360_di_chart_dbf) {
        self::$chart_dbf_file = dbf_arr($chart_dbf);
    }

    public static function getPeople($pCode) {
        foreach(self::$chart_dbf_file as $key => $value) {
            if($value['PCODE'] == $pCode) {
                return $value;
            }
        }
        return 0;
    }

    public function getFundMembers($index) {

        $fundMember = self::getChartWithPCode()[$index];

        $pCode = $fundMember['PCODE'];

        $peopleDetail = People::getPeopleByPCode($pCode)[0];

        $this->fundMemberTitle = $peopleDetail['TITLE'];
        $this->fundMemberSureName = $peopleDetail['PSURNAME'];
        $this->fundMemberFirstName = $peopleDetail['PFIRSTNAME'];
        $this->fundMemberGender = ($peopleDetail['SEX'] == 'M' ) ? "Male" : "Female";
        $this->fundMemberTFN = $peopleDetail['PTFN'];
        $this->fundMemberDOB = $peopleDetail['PDOB'];
        $this->fundMemberFullName = $peopleDetail['PFIRSTNAME'] .' ' . $peopleDetail['PSURNAME'];



        //echo "<br>\n  pcode " .  $pCode;


        $roCode =  People::getPeopleRoCodeByPCode($pCode);

        //echo "<br>\n rocode " .  $roCode;

        $Address = Office::getOfficeAddressByRoCode($roCode);

        //        echo "<br> \n print address";
        //                print_r($Address);

        $this->fundMemberAddressRoad1 = $Address['ROADD1'];
        $this->fundMemberAddressRoad2 = $Address['ROADD2'];
        $this->fundMemberAddressRoad3 = $Address['ROADD3'];
        $this->fundMemberAddressRoad4 = $Address['ROADD4'];
        $this->fundMemberAddressState = $Address['STATE'];

        $this->fundMemberAddress = $this->fundMemberAddressRoad1 . ', ' . $this->fundMemberAddressRoad2 . ', ' .  $this->fundMemberAddressRoad3 . ', ' . $this->fundMemberAddressRoad4 . ', ' . $this->fundMemberAddressState;

        // echo "pcode " . $fundMember['PCODE'];
        return;
    }

    public static function getChartWithPCode() {
         $dataArray = array();
        foreach(self::$chart_dbf_file as $key => $valueArray) {

            $pCode = str_replace(' ', '',$valueArray['PCODE']);
            if(!empty($pCode)) {
                if(!self::isExist($dataArray, $valueArray['PCODE'])) {
                    $dataArray[] = $valueArray;
                }
            }
        }
        return $dataArray;
    }

    private static function isExist($dataArray,$pCode) {
        //        echo "<br>-----------------------------------";
        //        print_r($dataArray);
        foreach($dataArray as $key => $val) {
                //            echo "<br> pcode " . $pCode;
                //            if(in_array($pCode, $val)) {
            if($val['PCODE'] == $pCode) {
                //                echo "<br><span style='color:green'>in array PCODE = $pCode</span>";
                return true;
            } else {
                //                echo "<br><span style='color:red'>not in array</span>";
            }
        }
        return false;
        //flat array
        //check if exist
        //if exist then return false
        //else return true
    }
}