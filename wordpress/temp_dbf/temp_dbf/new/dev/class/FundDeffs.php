<?php

namespace App;

class FundDeffs extends \App\Chart {
    private $fund_deffs_dbf_file;
    public $fundCode;

    function __construct($fund_deffs=fund_deffs)
    {
        parent::__construct();
        $this->fund_deffs_dbf_file = dbf_arr($fund_deffs);
        $this->loadData();
    }

    public function loadData() {
        //        echo "<pre>";
        //        print_r($this->fund_deffs_dbf_file);
        //        echo "</pre>";
        $this->fundCode = $this->getFundCode()['DEFVAL'];//$this->fund_deffs_dbf_file[0]['FUND_CODE'];

        //        print_r($this->getFundCode());

    }

    public function getFundCode() {
        foreach($this->fund_deffs_dbf_file as $key =>   $val) {
            if( in_array('FUND_CODE', str_replace(' ', '', $val))) {
                return $val;
            }
        }
        return false;
    }
}