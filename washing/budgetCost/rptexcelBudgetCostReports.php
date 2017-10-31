<?php 
session_start();
include "../../Connector.php" ;	

$backwardseperator 	= "../../";	
	$strStyleNo			= $_GET["serial"];
	
function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
    return;
}
// Excel end of file footer
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}
// Function to write a Number (double) into Row, Col
function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}
// Function to write a label (text) into Row, Col
function xlsWriteLabel($Row, $Col, $Value) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
return;
} 
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");    
header ("Pragma: no-cache");    
header ('Content-type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=Budget_Cost_Details.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream
	

	$i=4;
		 xlsWriteLabel(2,3,"BUDGET COST DETAILS");
		 
				xlsWriteLabel($i,0,"Serial No");
				xlsWriteLabel($i,1,"Style");
				xlsWriteLabel($i,2,"Color");
				xlsWriteLabel($i,3,"Fabric Name");
				xlsWriteLabel($i,4,"Status");
				$i++;
				
				$detailSql="";
			
				$detailSql .= " SELECT
								was_budgetcostheader.intSerialNo,
								was_budgetcostheader.strStyleName,
								was_budgetcostheader.strColor,
								was_budgetcostheader.strFabricDescription,
								was_budgetcostheader.strFabricId,
								was_budgetcostheader.intStatus
								FROM
								was_budgetcostheader
								ORDER BY
								was_budgetcostheader.intSerialNo ASC; ";	
			$detailResult = $db->RunQuery($detailSql);
			
			
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$details["intSerialNo"]); 
				xlsWriteLabel($i,1,$details["strStyleName"]); 
				xlsWriteLabel($i,2,$details["strColor"]);
				xlsWriteLabel($i,3,$details["strFabricId"]);
				if($details["intStatus"]==1)
					xlsWriteLabel($i,4,"Confirmed");
				else
					xlsWriteLabel($i,4,"Pending");
					
				$i++;	
			}
			
		//}				
			xlsEOF();
?>
