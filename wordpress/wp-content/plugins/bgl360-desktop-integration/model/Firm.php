<?php
namespace App;


use App\People;
use App\Office;

class Firm {

    public $fundAddress,$fundName,$trusteeType;

    public $trusteeAddress,$memberAddress, $FundMemberTotal;

    public $trusteeGender,$trusteeFirstName,$trusteeFamilyName,$trusteeTitle,$trusteeFullName;


    public $trusteesTotal;

    public $memberTotalTrustee;

    public $pCode;

    private $firm_dbf_array,$counter=0;

    function __construct($firm_dbf=bgl360_di_firm_dbf,$counter=0) {
        $this->firm_dbf_array =  dbf_arr($firm_dbf);
        $this->counter = $counter;
        $this->setData();
    }

    public function setData() {
        // echo "<H3> Chart </H3>";
        // rint_r( $this->firm_dbf_array[$this->counter]);
        $pcode = $this->firm_dbf_array[$this->counter]['TRUSTEE'];
        $fundName = $this->firm_dbf_array[$this->counter]['ENTITYNAME'];
        $this->FundMemberTotal = $this->firm_dbf_array[$this->counter]['MEMBERS'];

        $this->pCode = $pcode;

        //get fund name
        $this->fundName = $fundName;

        //get trustees address
        // echo "<br>get trustees address pcode = " . $pcode;
        $peopleDetail  = People::getPeopleByPCode($pcode);




        //echo "<br> people array ";
//        echo "<pre>";
//        print_r($peopleDetail);
//        echo "</pre>";

        $this->trusteeGender = $peopleDetail[0]['SEX'];
        $this->trusteeFirstName = $peopleDetail[0]['PFIRSTNAME'];
        $this->trusteeFamilyName = $peopleDetail[0]['PSURNAME'];
        $this->trusteeTitle = $peopleDetail[0]['TITLE'];
        $this->trusteeFullName = $peopleDetail[0]['PFIRSTNAME'] . ' ' . $peopleDetail[0]['PSURNAME'];


        $roCode = $peopleDetail[0]['ROCODE'];

        // echo "<br> office address rocode = " . $roCode;
        $officeDetail = Office::getTrusteesAddressByRoCode($roCode);
        // print_r($officeDetail);

        $this->trusteeAddress = $officeDetail['ROADD1'] .', '. $officeDetail['ROADD2'] .','. $officeDetail['ROADD3'];
        $this->memberTotalTrustee = People::getMemberTotal($pcode);

        //get trustee type
        if( strtolower($peopleDetail[0]['PTYPE']) == 'j'){
            $this->trusteeType = 'Individuals';
        } else {
            $this->trusteeType = 'Company - Already Registered';
        }
    }

    public function getMemberTrustees() {
        return People::getTrusteesMemberByFirmPCode($this->pCode);
    }
}

