<?php
error_reporting('-1');
$db = dbase_open('chart.dbf', 0);

if ($db) {
  $record_numbers = dbase_numrecords($db);
  for ($i = 1; $i <= $record_numbers; $i++) {
      $row = dbase_get_record_with_names($db, $i);
      foreach ($row as $key => $value){
      	
      		
      		echo $key.': '.$value.'<br/>';	
      	
      }
//      echo print_r($row,true);
      //if ($row['ismember'] == 1) {
       //   echo "Member #$i: " . trim($row['name']) . "\n";
      //}
  }
}
?>

