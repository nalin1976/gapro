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
	
	function GetYearFromDate($prmDate){
		
		$iYear = 0;
		
		$year = substr($prmDate,-4);
		
		return $year;
	}

	function GetFormatDate($prmDate){
		
		$_dtFormat = '';

		$arrFormatDate = explode('/', $prmDate);
		
		$year 	= $arrFormatDate[2];
		$month 	= $arrFormatDate[1];
		$day 	= $arrFormatDate[0];
		$_dtFormat = $year . "-" . $month . "-" . $day;
		
		return $_dtFormat;
		
	}
        
        function GetFormatDateUS($prmDate){
		
            $_dtFormat = '';

            $arrFormatDate = explode('/', $prmDate);

            $year 	= $arrFormatDate[2];
            $month 	= $arrFormatDate[0];
            $day 	= $arrFormatDate[1];
            $_dtFormat = $year . "-" . $month . "-" . $day;

            return $_dtFormat;
	}
        
        function DateIsFormatted($prmDate){
            
           $charPos = strpos($prmDate,"-");
           
           if($charPos > 0)
               return 1;
           else
               return 0;
            
        }
}

?>