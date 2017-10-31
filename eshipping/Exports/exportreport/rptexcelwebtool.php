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
	header ("Content-Disposition: attachment; filename=WebTool.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	
	
	$i=1;
		
		xlsWriteLabel($i,0,"Seller Name");
		xlsWriteLabel($i,1,"Factory Code ");
		xlsWriteLabel($i,2,"Factory Name "); 
		xlsWriteLabel($i,3,"Brand");
		xlsWriteLabel($i,4,"Product Description ");
		xlsWriteLabel($i,5,"Product Code"); 
		xlsWriteLabel($i,6,"OA_Number(if Applicable) "); 
		xlsWriteLabel($i,7,"PO_Number");
		xlsWriteLabel($i,8,"DO_Number( if Applicable) ");
		xlsWriteLabel($i,9,"Invoice Qty "); 
		xlsWriteLabel($i,10,"Incoterm ");
		xlsWriteLabel($i,11,"Shipment Type/Mode "); 
		xlsWriteLabel($i,12,"OA Price (USD)");
		xlsWriteLabel($i,13,"Invoice Date ");
		xlsWriteLabel($i,14,"Invoice Number "); 
		xlsWriteLabel($i,15,"Actual Price* "); 
		xlsWriteLabel($i,16,"Demand origin");
		xlsWriteLabel($i,17,"Inv Total value"); 
		xlsWriteLabel($i,18,"WEB TOOL ID# "); 
		
	$sql="select distinct
	ED.strTitleid,
	ED.strInvoiceNo,	
	CIH.strInvoiceNo, 
	CS.strName, 
	FI.strBrand,
	CID.strDescOfGoods,
	CIH.strFinalDest, 
	CID.strStyleID,
	CID.strBuyerPONo,
	CID.strISDno,
	CID.dblQuantity,
	CIH.strIncoterms,
	CIH.strTransportMode,
	CID.dblUnitPrice,
	Date(CIH.dtmInvoiceDate) AS InvDate,
	(CID.dblUnitPrice+FI.dblInsurance+FI.dblDestCharge+FI.dblFreight) As FOBprice,
	C.strCity,
	((CID.dblUnitPrice+FI.dblInsurance+FI.dblDestCharge+FI.dblFreight)*CID.dblQuantity) AS totPrice,
	(select strCountry from country where country.strCountryCode=C.strCountryCode) as country
	
	
	 
	from 
	commercial_invoice_header CIH
	left join customers CS ON CIH.strCompanyID=CS.strCustomerID
	left join finalinvoice FI ON CIH.strInvoiceNo=FI.strInvoiceNo
	left join commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
	left join city C ON CIH.strFinalDest=C.strCityCode
	left join exportreport_detail ED ON ED.strInvoiceNo=CIH.strInvoiceNo
	where ED.strTitleid='$titleid'
	order by CIH.strInvoiceNo, CID.strBuyerPONo ;";
		
		$result = $db->RunQuery($sql);
		$i++;
		
		$previd=123;
		
		
		while ($row=mysql_fetch_array($result))
		{
		
			$currentid=$row["strInvoiceNo"];
			if($previd!=$currentid)
			{
				$i++;
				xlsWriteLabel($i,0,$Company);
				xlsWriteLabel($i,1,"S99"); 
				xlsWriteLabel($i,2,$row["strName"]); 
				xlsWriteLabel($i,3,$row["strBrand"]); 
				xlsWriteLabel($i,4,$row["strDescOfGoods"]);
				xlsWriteLabel($i,5,$row["strStyleID"]); 
				xlsWriteLabel($i,6,$row[" "]);
				xlsWriteLabel($i,7,$row["strBuyerPONo"]); 
				xlsWriteLabel($i,8,$row["strISDno"]);
				xlsWriteLabel($i,9,$row["dblQuantity"]);  
				xlsWriteLabel($i,10,$row["strIncoterms"]); 
				xlsWriteLabel($i,11,$row["strTransportMode"]); 
				xlsWriteLabel($i,12,number_format($row["dblUnitPrice"],2)); 
				xlsWriteLabel($i,13,$row["InvDate"] );
				xlsWriteLabel($i,14,$row["strInvoiceNo"] );
				xlsWriteLabel($i,15,number_format($row["FOBprice"],2));
				xlsWriteLabel($i,16,$row["country"] );
				xlsWriteLabel($i,17,number_format($row["totPrice"],2));
				xlsWriteLabel($i,18,"  " );
			}
			else
			{
				
				
				xlsWriteLabel($i,1,"S99"); 
				xlsWriteLabel($i,2,$row["strName"]); 
				xlsWriteLabel($i,3,$row["strBrand"]); 
				xlsWriteLabel($i,4,$row["strDescOfGoods"]);
				xlsWriteLabel($i,5,$row["strStyleID"]); 
				xlsWriteLabel($i,6,$row[" "]);
				xlsWriteLabel($i,7,$row["strBuyerPONo"]); 
				xlsWriteLabel($i,8,$row["strISDno"]);
				xlsWriteLabel($i,9,$row["dblQuantity"]);  
				xlsWriteLabel($i,10,$row["strIncoterms"]); 
				xlsWriteLabel($i,11,$row["strTransportMode"]); 
				xlsWriteLabel($i,12,number_format($row["dblUnitPrice"],2)); 
				xlsWriteLabel($i,13,$row["InvDate"] );
				xlsWriteLabel($i,14,$row["strInvoiceNo"] );
				xlsWriteLabel($i,15,number_format($row["FOBprice"],2));
				xlsWriteLabel($i,16,$row["country"] );
				xlsWriteLabel($i,17,number_format($row["totPrice"],2));
				xlsWriteLabel($i,18,"  " );
				
			}
			$previd=$currentid;
			$i++;
		}
		xlsEOF();
?>