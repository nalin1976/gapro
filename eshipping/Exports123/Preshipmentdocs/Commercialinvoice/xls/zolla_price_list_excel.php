<?php
	session_start();
	$backwardseperator 	= "../../../../";	
	include $backwardseperator."Connector.php" ;
	$xmldoc=simplexml_load_file($backwardseperator.'config.xml');
	$Company=$xmldoc->companySettings->Declarant;
	$Address=$xmldoc->companySettings->Address;
	$City=$xmldoc->companySettings->City;
	$phone=$xmldoc->companySettings->phone;
	$Fax=$xmldoc->companySettings->Fax;
	$email=$xmldoc->companySettings->Email;
	$Website=$xmldoc->companySettings->Website;
	$Country=$xmldoc->companySettings->Country;
	$Com_TinNo=$xmldoc->companySettings->TinNo;
	$invoiceNo=$_GET['InvoiceNo'];
	include '../buyerwiseinvoices/common_report.php';
	include '../buyerwiseinvoices/invoice_queries.php'; 
	
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
	header ("Content-Disposition: attachment; filename=zolla_price_list_excel.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	

	
	
	
	xlsBOF();
	
	xlsWriteLabel(++$i,0,$Company);
	xlsWriteLabel(++$i,0,$Address." ".$Country." Tel ".$phone." Fax ".$Fax);
	xlsWriteLabel(++$i,0,"PRICE LIST");	
	xlsWriteLabel(++$i,0,"This is a price list valid for all dispatches from");	
	
	xlsWriteLabel(++$i,0,ucwords(strtolower($Company)));
	$tmpCityArray	= explode(',',$City);
	
	$address1		= ucwords(strtolower($Address)).",".ucwords(strtolower($tmpCityArray[1])).",".ucwords(strtolower($tmpCityArray[2]));
	xlsWriteLabel(++$i,0,$address1);	
	$i+=3;
	$sql		="select strIncoterms from commercial_invoice_header
					where strInvoiceNo ='$invoiceNo';";
	$res_inc	= $db->RunQuery($sql);
	$row		= mysql_fetch_array($res_inc);
	
	
	$arraycol 	= array('Price list edition No.','Validity :','Price are given on terms :','Manufactured by:');
	$arrayData	= array('','',$row["strIncoterms"],ucwords(strtolower($Company)),$address1);
	$letterArray= array(0,1);
	
	$k=$i;

	foreach($arraycol as $frstcol)
	{
		
		xlsWriteLabel(++$i,0,$frstcol);
		
	}
	foreach($arrayData as $scndcol)
	{
		xlsWriteLabel(++$k,1,$scndcol);
	}
	
	$i+=2;

	$arrayGrid = array('Article','Good Description','Composition of fabric','Price FOB, USD');
    $c=0;$i++;
	foreach($arrayGrid as $val)
	{
		xlsWriteLabel($i,$c++,"$val");
	}
	
	$sql_grid	= "select
					commercial_invoice_detail.strDescOfGoods,
					commercial_invoice_detail.strBuyerPONo,
					commercial_invoice_detail.strStyleID,
					commercial_invoice_detail.dblQuantity,
					commercial_invoice_detail.dblUnitPrice,
					commercial_invoice_detail.dblAmount,
					commercial_invoice_detail.intNoOfCTns,
					commercial_invoice_detail.strISDno,
					commercial_invoice_detail.strHSCode,
					commercial_invoice_detail.strFabric,
					shipmentplheader.strWashCode
					from
					commercial_invoice_detail
					left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno					
					where 
					strInvoiceNo='$invoiceNo';";
	
	$res_grid	= $db->RunQuery($sql_grid);
	
	
		### data rows for above grid goes here ############

	
	while($row_grid	= mysql_fetch_array($res_grid))
	{
		++$i;
		xlsWriteLabel($i,0,$row_grid["strStyleID"]);
		xlsWriteLabel($i,1,$row_grid["strDescOfGoods"]);
		xlsWriteLabel($i,2,$row_grid["strFabric"]);
		xlsWriteLabel($i,3,$row_grid["dblUnitPrice"]);
		
	}

	
	++$i;
	$nameArray = array('Name  :', 'Position  :','signature :');	
		foreach($nameArray as $scndcol)
	{
		xlsWriteLabel(++$i,0,$scndcol);
	}

	
	xlsEOF();

?>