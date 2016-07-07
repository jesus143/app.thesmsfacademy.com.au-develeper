<?php
error_reporting(E_ALL);
//$db = dbase_open('funddefs.dbf', 0);
//var_dump(dbase_open('firm.dbf', 2));
$db = dbase_open('chart.dbf',2);


if ($db) {

//Load empty DBF file,
//Query wordpress database for fields
//Write the fields into empty DBF file
//Save DBF file in folder
//We do this process for each DBF file, then zip the DBF files for download.

	// Get column information
	
  $record_numbers = dbase_numrecords($db);
  echo 'Record Numbers: '.$record_numbers.'<br/>';
  $row = dbase_get_record_with_names($db, 1);
  
  for ($i = 1; $i <= $record_numbers; $i++) {
      $row = dbase_get_record_with_names($db, $i);
      
      if((substr($row['ACODE1'],0,2) == '50') && (strlen(trim($row['PCODE'])) > 1)){
      	echo 'Row: '.$row['ACODE1'].' '.$row['PCODE'].' '.$row['ATYPE'].' '.$row['ANAME'].' '.$row['MODE'].'<br/>';
      }
      else {
      //unset($row["deleted"]); // drop the field
      $delete = dbase_delete_record($db, $i);
      echo 'Deleted row number '.$i.': '.$delete.'<br/>';
       //$rarr = array(); 
        //foreach ($row as $i=>$vl) $rarr[] = $vl; 
        //dbase_replace_record($db, $rarr, 1); 
        //dbase_close($db); 
        //dbase_replace_record($db, $row, 1);
      }
  }
  
  dbase_close($db); 
  //foreach ($row as $key => $value){
  			
			 //{
      			//echo 'Row: '.$row['ACODE1'].'<br/>';
			 //}
      		

      		//echo $key.': '.$value.'<br/>';	
      	
      //}
  //unset($row["deleted"]); // drop the field 
  //$row['ENTITYNAME'] = 'TIM SUPER FUND';
  //$rarr = array(); 
       // foreach ($row as $i=>$vl) $rarr[] = $vl; 
        //dbase_replace_record($db, $rarr, 1); 
        //dbase_close($db); 
        
//dbase_replace_record($db, $row, 1);
//echo print_r($row, true);
 
}
else {
	echo 'cannot open database.';
}
?>

