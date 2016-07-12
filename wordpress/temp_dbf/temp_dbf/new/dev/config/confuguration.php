<?php


define('fund_deffs', 'dbf/funddefs.dbf');
define('people_dbf', 'dbf/people.dbf');
define('firm_dbf',   'dbf/firm.dbf');
define('office_dbf', 'dbf/office.dbf');
define('chart_dbf',  'dbf/chart.dbf');

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