<?php
	session_start();

	include "../../Connector.php" ;
	$backwardseperator 	= "../../";	
	$xmldoc=simplexml_load_file('../../config.xml');
	$Company=$xmldoc->companySettings->Declarant;
	include "../Preshipmentdocs/Commercialinvoice/buyerwiseinvoices/common_report.php";
	
	$titleid			= $_GET["titleid"];
//	echo $titleid;
	function xlsBOF() 
	{
    	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
   	    return;
	}
	function xlsEOF()
    {
   	    echo pack("ss", 0x0A, 0x00);
        return;
    }
	function xlsWriteNumber($Row, $Col, $Value)
    {
   	    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
        echo pack("d", $Value);
        return;
    }
	function xlsWriteLabel($Row, $Col, $Value) 
	{
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
	header ("Content-Disposition: attachment; filename=Q2levis.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	
	$i=0;
		
		xlsWriteLabel($i,0,"MONTH");
		xlsWriteLabel($i,1,"INVOICE NUMBER");
		xlsWriteLabel($i,2,"FOB DATE");
		xlsWriteLabel($i,3,"SHIPPER"); 
		xlsWriteLabel($i,4,"DESTINATION");
		xlsWriteLabel($i,5,"BL \ AWB NO");
		xlsWriteLabel($i,6,"MODE OF SHIPMENT"); 
		xlsWriteLabel($i,7,"NO OF CARTONS");
		xlsWriteLabel($i,8,"NO OF UNITS");
		xlsWriteLabel($i,9,"TERMS OF PAYMENT"); 
		xlsWriteLabel($i,10,"COMMERICAL INVOICE VALUE-FOB"); 
		xlsWriteLabel($i,11,"COMMERICAL INVOICE VALUE-DDU OR DFC ");

		
	$sql="SELECT
		  ID.strInvoiceNo,
		  date(ID.dtmInvoiceDate) as dtmInvoiceDate,ID.strTransportMode,
		  ( CONCAT(UPPER(substr( MONTHNAME( ID.dtmInvoiceDate ),1,3)), '-',SUBSTR(EXTRACT(YEAR FROM ID.dtmInvoiceDate),3,2))) as month1,
		  if(isnull(FI.strBL),FI.strHAWB,FI.strBL)as blval,
		  FI.strFreightPC,
		  (FI.dblFreight+FI.dblInsurance+FI.dblDestCharge) as totunitchrg,
		  CT.strCity
		  
		  FROM
		  commercial_invoice_header AS ID
		  Inner Join exportreport_detail AS ED ON ED.strInvoiceNo = ID.strInvoiceNo
		  Left Join city AS CT ON ID.strFinalDest = CT.strCityCode
		  Left Join finalinvoice AS FI ON ID.strInvoiceNo = FI.strInvoiceNo
		  WHERE
		  ED.strTitleid =  '$titleid'
		  Group by ID.strInvoiceNo";
		
		$result = $db->RunQuery($sql);
		$i++;
		
		$previd = 123;
		
		while ($row=mysql_fetch_array($result))
		{
		
			$currentid=$row["strInvoiceNo"];
			$totalacrtons = $r_summary->summary_sum($currentid,'intNoOfCTns');
			$totalaunits = $r_summary->summary_sum($currentid,'dblQuantity');
			$fob		= number_format($r_summary->summary_sum($currentid,'dblAmount'),2);
			
			
			$month = $row["month1"];
			$fobDate = $row["dtmInvoiceDate"];
			$shipper = $Company;
			$destination = $row["strCity"];
			$bl = $row["blval"];
			
			$dduOdfc = number_format((($row["totunitchrg"] * $totalaunits) + $r_summary->summary_sum($currentid,'dblAmount') ),2) ;
	
			if($previd!=$month)
			{

				xlsWriteLabel($i,0,$month);
				xlsWriteLabel($i,1,$currentid);
				xlsWriteLabel($i,2,$fobDate); 
				xlsWriteLabel($i,3,$Company); 
				xlsWriteLabel($i,4,$destination); 
				xlsWriteLabel($i,5,$bl);
				xlsWriteLabel($i,6,$row["strTransportMode"]); 
				xlsWriteLabel($i,7,$totalacrtons); 
				xlsWriteLabel($i,8,$totalaunits);
				xlsWriteLabel($i,9,$row["strFreightPC"]);  
				xlsWriteLabel($i,10,$fob); 
				xlsWriteLabel($i,11,$dduOdfc); 
				
			}
			else
			{
				
				xlsWriteLabel($i,1,$currentid);
				xlsWriteLabel($i,2,$fobDate); 
				xlsWriteLabel($i,3,$Company); 
				xlsWriteLabel($i,4,$destination); 
				xlsWriteLabel($i,5,$bl);
				xlsWriteLabel($i,6,$row["strTransportMode"]); 
				xlsWriteLabel($i,7,$totalacrtons); 
				xlsWriteLabel($i,8,$totalaunits);
				xlsWriteLabel($i,9,$row["strFreightPC"]);  
				xlsWriteLabel($i,10,$fob); 
				xlsWriteLabel($i,11,$dduOdfc); 
				
			}
			$previd=$month;
			$i++;
		}
		xlsEOF();
?>
