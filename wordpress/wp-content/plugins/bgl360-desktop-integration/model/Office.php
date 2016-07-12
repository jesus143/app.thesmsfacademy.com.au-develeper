<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 7/7/2016
 * Time: 5:20 PM
 */

namespace App;




class Office
{

    private static $office_dbf_array,$counter=0;

    function __construct($office_dbf=bgl360_di_office_dbf) {
        self::$office_dbf_array =  dbf_arr($office_dbf);
    }

    public static function getTrusteesAddressByRoCode($roCode) {
        //        echo "<br> \n rocode now in function " . $roCode;
        foreach (self::$office_dbf_array as $key => $officeArray) {
            if( in_array($roCode,  $officeArray)) {
                return $officeArray;
            }
        }
        return 0;
    }

    public static function getOfficeAddressByRoCode($roCode) {

        return self::getTrusteesAddressByRoCode($roCode);
    }
}