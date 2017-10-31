<?php
	session_start();

	include "../../Connector.php" ;
	$backwardseperator 	= "../../";	
	$xmldoc=simplexml_load_file('../../config.xml');
	$Company=$xmldoc->companySettings->Declarant;
	
	$titleid			= $_GET["titleid"];
	
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
	header ("Content-Disposition: attachment; filename=Exportreport.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	
	$sql_title="select strTitleid,strTitle from exportreport_header where strTitleid='$titleid';";
	$result_title=  $db->RunQuery($sql_title);
	
	while($row_title=mysql_fetch_array($result_title))
	{
		xlsWriteLabel(1,0,$row_title["strTitle"]);
	}
	
	$i=3;
		
		xlsWriteLabel($i,0,"Vendor");
		xlsWriteLabel($i,1,"PAYMENT TERMS ");
		xlsWriteLabel($i,2,"ISD "); 
		xlsWriteLabel($i,3,"Brand/Div");
		xlsWriteLabel($i,4,"P/C ");
		xlsWriteLabel($i,5,"Contract#s "); 
		xlsWriteLabel($i,6,"ETD "); 
		xlsWriteLabel($i,7,"ETA");
		xlsWriteLabel($i,8,"Ctns. ");
		xlsWriteLabel($i,9,"Total qty "); 
		xlsWriteLabel($i,10,"CARRIER ");
		xlsWriteLabel($i,11,"Unit Price (FOB) "); 
		xlsWriteLabel($i,12,"Unit Price (DDU)");
		xlsWriteLabel($i,13,"Value (USD) ");
		xlsWriteLabel($i,14,"Freight (USD) "); 
		xlsWriteLabel($i,15,"Volume (CBMs) "); 
		xlsWriteLabel($i,16,"CSC");
		xlsWriteLabel($i,17,"Port of entry"); 
		xlsWriteLabel($i,18,"Estimated saving in domestic freight in USA (USD) "); 
		
		$sql="select  * from  exportreport_detail 
			  left join commercial_invoice_header on commercial_invoice_header.strInvoiceNo=exportreport_detail.strInvoiceNo
			  left join commercial_invoice_detail on commercial_invoice_detail.strInvoiceNo=exportreport_detail.strInvoiceNo 
			  left join buyers on commercial_invoice_header.strInvoiceNo=exportreport_detail.strInvoiceNo and buyers.strBuyerID=commercial_invoice_header.strBuyerID
			  left join city on commercial_invoice_header.strInvoiceNo=exportreport_detail.strInvoiceNo and city.strCityCode=commercial_invoice_header.strFinalDest
			  left join finalinvoice on finalinvoice.strInvoiceNo=exportreport_detail.strInvoiceNo 
			  where exportreport_detail.strTitleid='$titleid' ;";
		
		$result = $db->RunQuery($sql);
		$i++;
		
		$previd=0;
		
		
		while ($row=mysql_fetch_array($result))
		{
		
			$currentid=$row["strInvoiceNo"];
			if($previd!=$currentid)
			{
				$i++;
				xlsWriteLabel($i,0,$Company);
				xlsWriteLabel($i,1,"T/T"); 
				xlsWriteLabel($i,2,$row["strISDno"]); 
				xlsWriteLabel($i,3,$row["strBrand"]); 
				xlsWriteLabel($i,4,$row["strStyleID"]);
				xlsWriteLabel($i,5,$row["strBuyerPONo"]); 
				xlsWriteLabel($i,6,$row["dtmSailingDate"]);
				xlsWriteLabel($i,7,$row["dtmETA"]); 
				xlsWriteLabel($i,8,$row["intNoOfCTns"]);
				xlsWriteLabel($i,9,$row["dblQuantity"]);  
				xlsWriteLabel($i,10,$row["strCarrier"]); 
				xlsWriteLabel($i,11,$row["dblUnitPrice"]); 
				xlsWriteLabel($i,12," " ); 
				xlsWriteLabel($i,13,$row["dblAmount"] );
				xlsWriteLabel($i,14," - " );
				xlsWriteLabel($i,15,$row["dblCBM"] );
				xlsWriteLabel($i,16,$row["strCountry"] );
				xlsWriteLabel($i,17,$row["strCity"] );
				xlsWriteLabel($i,18," - " );
			}
			else
			{
				xlsWriteLabel($i,1,"T/T"); 
				xlsWriteLabel($i,2,$row["strISDno"]); 
				xlsWriteLabel($i,3,$row["strBrand"]); 
				xlsWriteLabel($i,4,$row["strStyleID"]);
				xlsWriteLabel($i,5,$row["strBuyerPONo"]); 
				xlsWriteLabel($i,6,$row["dtmSailingDate"]);
				xlsWriteLabel($i,7,$row["dtmETA"]); 
				xlsWriteLabel($i,8,$row["intNoOfCTns"]);
				xlsWriteLabel($i,9,$row["dblQuantity"]);  
				xlsWriteLabel($i,10,$row["strCarrier"]); 
				xlsWriteLabel($i,11,$row["dblUnitPrice"]); 
				xlsWriteLabel($i,12," " ); 
				xlsWriteLabel($i,13,$row["dblAmount"] );
				xlsWriteLabel($i,14," - " );
				xlsWriteLabel($i,15,$row["dblCBM"] );
				xlsWriteLabel($i,16,$row["strCountry"] );
				xlsWriteLabel($i,17,$row["strCity"] );
				xlsWriteLabel($i,18," - " );
				
			}
			$previd=$currentid;
			$i++;
		}
		xlsEOF();
?>