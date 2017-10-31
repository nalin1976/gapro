<?php 

		require_once 'SpreadsheetReader/SpreadsheetReaderFactory.php';
		
		
		$spreadsheetsFilePath = 'upload/test3.xls'; //or test.xls, test.csv, etc.
		$reader = SpreadsheetReaderFactory::reader($spreadsheetsFilePath);
//die("PASS");
		$sheets = $reader->read($spreadsheetsFilePath);

		echo $sheets[0][5][1]."PASS";
		/*$file_name="test4.xls";
	  move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $file_name);
      echo "Stored in: " . "upload/" . $file_name;
	  */
	 // $excel->read('upload/test3.xls');
	 
	  /*while($x<=$excel->sheets[0]['numRows'])
	  {
		$cell = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
        echo $cell; 
	}*/
?>