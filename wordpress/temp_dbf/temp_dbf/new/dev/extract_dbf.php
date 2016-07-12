<?php

define('fund_deffs', 'dbf/funddefs.dbf');
define('people_dbf', 'dbf/people.dbf');
define('firm_dbf',   'dbf/firm.dbf');
define('office_dbf', 'dbf/office.dbf');
define('chart_dbf',  'dbf/chart.dbf');


//echo "<pre>";
/**
 * Remember
 * PCODE is a unique id for a person in the person.dbf
 * REGADD is a unique id for an address (“registered address = regadd”) in the office.dbf
 * I wrote 1,2,3 so that you could see what fields join the files together. If you look at the Google Sheet i shared with you, it should make sense
 *
 * PCODE in chart.dbf are the Fund Members
 * PCODE in firm.dbf is the Trustee(s)
 * so you would look at the PCODE in both files, and then query people.dbf to get the details
 *
 * Issue: its counting 2 trustees member in firm but code actually found 1 member trustees, so default calculation of array is not correct to the actual calculation of the code
 */

require_once('other/helper.php');
require_once('class/People.php');
require_once('class/Office.php');
require_once('class/Firm.php');
require_once('class/Chart.php');
require_once('class/FundDeffs.php');
require_once('class/Fund.php');
require_once('class/Trustees.php');

new \App\FundDeffs();
new \App\People();
new \App\Office();
new \App\Firm();
new \App\Chart();

$fund      = new \App\Fund();
$trustee   = new \App\Trustees();




//
///**
// * Fund name = 2
// * State law to govern the fund (state)= 9
// *
// */
//
////echo "</pre>";
echo "<br>\n fund name = " . $trustee->fundName;
echo "<br>\n trustees address = " . $trustee->trusteeAddress;
echo "<br>\n trustees type = " . $trustee->trusteeType;
echo "<br>\n total trustee = " . $fund->fundMemberTotal;
echo "<br>\n fund code = " . $fund->fundCode;
echo "<br>\n trustee full name = " . $trustee->trusteeFullName;




$counter=0;
for($i=0; $i< $fund->fundMemberTotal; $i++) {
    $counter++;
    echo "<br> \n -----------------------------------------------------";
    $fund->getFundMembers($i);
    echo "<br>\n fund member number " . $counter;
    echo "<br>\n fundMemberTitle: " . $fund->fundMemberTitle;
    echo "<br>\n fundMemberFirstName: " . $fund->fundMemberFirstName;
    echo "<br>\n fundMemberSureName: " . $fund->fundMemberSureName;
    echo "<br>\n fundMemberGender: " . $fund->fundMemberGender;
    echo "<br>\n fundMemberFullName: " . $fund->fundMemberFullName;
    echo "<br>\n fundMemberTFN: " . $fund->fundMemberTFN;
    echo "<br>\n fundMemberDOB: " . $fund->fundMemberDOB . "\n\n\n";
    echo "<br>\n fund member address = " . $fund->fundMemberAddress;
}




//echo "\n \n \n \n <br><br><br><br> get trustees member <pre> ";
//
//print_r($trustee->getMemberTrustees());
//





