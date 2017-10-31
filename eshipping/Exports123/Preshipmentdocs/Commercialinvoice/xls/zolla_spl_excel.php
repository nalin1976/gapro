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
	header ("Content-Disposition: attachment; filename=zolla_spl_excel.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();

	xlsWriteLabel(++$i,0,$Company);
	xlsWriteLabel(++$i,0,$Address." ".$Country." Tel ".$phone." Fax ".$Fax);
	$i++;
	xlsWriteLabel(++$i,0,"PACKING LIST");
	$k=$i;
	$arrayGrid 		= array('INVOICE No.','Date','Contract No.','Date');
	
	$conNo=$r_summary->summary_string($invoiceNo,'strBuyerPONo');
	$arrayconNO	= explode('-',$conNo);
	
	$arrayGridData	= array($invoiceNo,$dateInvoice,$arrayconNO[1],'');
	
	foreach($arrayGrid as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	
	foreach($arrayGridData as $frstcol1)
	{
		xlsWriteLabel(++$k,1,$frstcol1);
	}



	$arrayGrid = array('Article','Good Description','CTN qty','Items pcs','Net weight,kg','Gross weight, kg','Volume, m3','Carton L','Carton W','Carton H','HS Code');
    $c=0;$i++;
	foreach($arrayGrid as $val)
	{
		xlsWriteLabel($i,$c++,"$val");
	}
	$k=$i;
	$original = $i;
	
	$firstColArray = array('Order No. ','Specification No');
	$firstColDataArray = array($conNo,'');
		
	$secondColArray = array('Order Date','Specification Date');
	$secondColDataArray = array($dateInvoice,'');
	foreach($firstColArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	
	foreach($firstColDataArray as $frstcolData)
	{
		xlsWriteLabel(++$original,1,$frstcolData);
	}
	
	
	$i=$k;
	$original = $i;
	foreach($secondColArray as $scndcol)
	{
		xlsWriteLabel(++$i,3,$scndcol);
	}
	foreach($secondColDataArray as $scndcolData)
	{
		xlsWriteLabel(++$original,4,$scndcolData);
	}	

###### populating the grid with dummy data ######################
	$sql_populate="SELECT
					commercial_invoice_detail.strStyleID,
					commercial_invoice_detail.strDescOfGoods,
					commercial_invoice_detail.dblUnitPrice,
					commercial_invoice_detail.dblQuantity,
					shipmentplheader.strCTNsvolume,
					shipmentplheader.strArticle,
					commercial_invoice_detail.strHSCode,
					commercial_invoice_detail.intNoOfCTns,
					commercial_invoice_detail.dblNetMass,
					commercial_invoice_detail.dblGrossMass,
					commercial_invoice_detail.dblAmount,
					commercial_invoice_detail.dblCBM,
					commercial_invoice_detail.strPLno
					FROM
					commercial_invoice_detail
					inner Join shipmentplheader ON commercial_invoice_detail.strPLno = shipmentplheader.strPLNo
					WHERE
					commercial_invoice_detail.strInvoiceNo =  '$invoiceNo'";
					
		$res_grid	= $db->RunQuery($sql_populate);			

	
	while($row_grid=mysql_fetch_array($res_grid))
	{
		++$i;
		xlsWriteLabel($i,0,$row_grid["strStyleID"]);
		xlsWriteLabel($i,1,$row_grid["strDescOfGoods"]);
		xlsWriteLabel($i,2,$row_grid["intNoOfCTns"]);
		$totCtns+=$row_grid["intNoOfCTns"]; //total number of cartoons
		
		xlsWriteLabel($i,3,$row_grid["dblQuantity"]);
		$totitems+=$row_grid["dblQuantity"];
		
		xlsWriteLabel($i,4,$row_grid["dblNetMass"]);
		$totNetWeight+=$row_grid["dblNetMass"];
		
		xlsWriteLabel($i,5,$row_grid["dblGrossMass"]);
		$totGrossWeight+=$row_grid["dblGrossMass"];
		
		xlsWriteLabel($i,6,$row_grid["dblCBM"]);
		$totVol+=$row_grid["dblCBM"];
		
		$demValArray	= $row_grid["strCTNsvolume"];
		$demArray		= explode('X',$demValArray);
		xlsWriteLabel($i,7,$demArray[0]);
		xlsWriteLabel($i,8,$demArray[1]);
		xlsWriteLabel($i,9,$demArray[2]);
		xlsWriteLabel($i,10,$row_grid["strHSCode"]);

	}
	
    $c=0;
	++$i;
   $footerArray = array('TOTAL','N/A',$totCtns,$totitems,$totNetWeight,$totGrossWeight,$totVol,'','','','N/A');	
	
	foreach($footerArray as $val)
	{
		xlsWriteLabel($i,$c++,"$val");
	}
	++$i;
	
	$nameArray = array('Name  :', 'Position  :','signature :');	
		foreach($nameArray as $scndcol)
	{
		xlsWriteLabel(++$i,0,$scndcol);
	}
	


	xlsEOF()
?>