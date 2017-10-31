<?php

class CommonPHP{

	function GetFormatDateToDB($prmDate){
		
		$_dtFormat = '';
		
		$year = substr($prmDate,-4);
		$month = substr($prmDate,-7,-5);
		$day = substr($prmDate,-10,-8);
		$_dtFormat = $year . "-" . $month . "-" . $day;
		
		return $_dtFormat;
		
	}
	
}

?>