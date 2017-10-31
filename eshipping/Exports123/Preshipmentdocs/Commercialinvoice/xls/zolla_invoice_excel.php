<?php
	session_start();
	$backwardseperator 	= "../../../../";	
	include $backwardseperator."Connector.php" ;
	$xmldoc=simplexml_load_file('../../../../config.xml');
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
	header ("Content-Disposition: attachment; filename=zolla_invoice_exce.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	$i=0;
	
	xlsWriteLabel(++$i,0,$Company);
	xlsWriteLabel(++$i,0,$Address.", ".$City.". Tel: ".  $phone." Fax: ". $Fax);
	$k=$i++;
	xlsWriteLabel(++$i,0,"INVOICE");
	
	
	xlsWriteLabel(++$i,6,"INVOICE NO:");
	xlsWriteLabel($i,7,$invoiceNo);
	xlsWriteLabel(++$i,6,"INVOICE Date:");
	xlsWriteLabel($i,7,$dateInvoice);
	
	xlsWriteLabel(++$i,0,"Seller:");
	xlsWriteLabel($i,1,$Company);
	xlsWriteLabel($i,6,"Consignee:");
	xlsWriteLabel($i,7,$dataholder['BuyerAName']);
	
	xlsWriteLabel(++$i,0,"Address:");
	xlsWriteLabel($i,1,$Address.", ".$City);
	xlsWriteLabel($i,6,"Address:");
	xlsWriteLabel($i,7,$dataholder['buyerAddress1'].', '.$dataholder['buyerAddress2'].', '.$dataholder['BuyerCountry']);
	
	xlsWriteLabel(++$i,0,"Shipper:");
	xlsWriteLabel($i,1,$Company);
	xlsWriteLabel($i,6,"Contract No:");
	$conNo=$r_summary->summary_string($invoiceNo,'strBuyerPONo');
	$arrayconNO	= explode('-',$conNo);
	xlsWriteLabel($i,7,$arrayconNO[1]); //79
	
	xlsWriteLabel(++$i,0,"Address:");
	xlsWriteLabel($i,1,$Address.", ".$City);
	xlsWriteLabel($i,6,"Contract date:");
	xlsWriteLabel($i,7,"");

	xlsWriteLabel(++$i,6,"Delivery Terms");
	
	$sql		="select strIncoterms from commercial_invoice_header
					where strInvoiceNo ='$invoiceNo';";
	$res_inc	= $db->RunQuery($sql);
	$row		= mysql_fetch_array($res_inc);
	xlsWriteLabel($i,7,$row["strIncoterms"]);
	xlsWriteLabel(++$i,6,"Manufacturer");
	xlsWriteLabel($i,7,$dataholder['CustomerName']);
	
	xlsWriteLabel(++$i,0,"Buyer:");
	xlsWriteLabel($i,1,$dataholder['BuyerAName']);
	xlsWriteLabel($i,6,"Address"); //manufacture address
	xlsWriteLabel($i,7,$dataholder['strAddress1'].', '. $dataholder['strAddress2'].', '.$dataholder['CustomerCountry']);
	
	xlsWriteLabel(++$i,0,"Address:"); // buyer address
	xlsWriteLabel($i,1,$dataholder['buyerAddress1'].', '.$dataholder['buyerAddress2'].', '.$dataholder['BuyerCountry']);
	
	xlsWriteLabel(++$i,6,"Country Of Origin");
	xlsWriteLabel($i,7,"Sri Lanka");
	
	
	
	$gridHeaderArray = array('No.','Article','Marking','Goods Description','Composition of fabric'
								,'Q-ty,Pcs','Price FOB,USD','Amount FOB,USD','HS Code');
	
    $c=0;$i+=2;
	foreach($gridHeaderArray as $val)
	{
		xlsWriteLabel($i,$c,"$val");
		$c++;
	}
	
	$k=$i;
	$original=$i; // to use on the  data of the subLeftArray array.
	
	$subLeftArray = array('Order no:','Specification No:');	
	$subLeftDataArray = array($conNo,'');
	
	$subRightArray = array('Order Date:','Specification Date:');
	$subRightDataArray = array($dateInvoice,'');
								
	foreach($subLeftArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i=$original;
	foreach($subLeftDataArray as $frstcolData)
	{
		xlsWriteLabel(++$i,1,$frstcolData);
	}	
	
	
	
	$i=$k;
	foreach($subRightArray as $scndcol)
	{
		xlsWriteLabel(++$i,4,$scndcol);
	}
	$i=$k;
	foreach($subRightDataArray as $scndcolData)
	{
		xlsWriteLabel(++$i,5,$scndcolData);
	}	
	
		### data rows for above grid goes here ############

	 
	  	$str_desc="select
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
					commercial_invoice_detail.dblCBM,
					shipmentplheader.strWashCode
					from
					commercial_invoice_detail
					left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
					$result_desc=$db->RunQuery($str_desc);
			
			$bool_rec_fst=1;
			while($row_desc=mysql_fetch_array($result_desc)){
			
			$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
			$totqty+=$row_desc["dblQuantity"];
			$totctns+=$row_desc["intNoOfCTns"];
			$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
			$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
			$hts_code=$row_desc["strHSCode"];
			$totVol+=$row_desc["dblCBM"];
			
			$count++;					  
		 
	
    	
			++$i;
		
			xlsWriteLabel($i,0,$count);
			xlsWriteLabel($i,1,$row_desc["strStyleID"]);
			xlsWriteLabel($i,2,"");
			xlsWriteLabel($i,3,$row_desc["strDescOfGoods"]);
			xlsWriteLabel($i,4,$row_desc["strFabric"]);
			xlsWriteNumber($i,5,$row_desc["dblQuantity"]);
			$totQty+=$row_desc["dblQuantity"];
			xlsWriteNumber($i,6,$row_desc["dblUnitPrice"]);
			xlsWriteNumber($i,7,$row_desc["dblAmount"]);
			$totAmount+=$row_desc["dblAmount"];
			xlsWriteLabel($i,8,$row_desc["strHSCode"]);
			
			
			
		
	}


	
	$i++;
	#grid footer #############	
	
	$gridFotterDataArray = array('','Total :','','','',$totQty,'',$totAmount,'');
    $c=0;
	foreach($gridFotterDataArray as $val)
	{
		xlsWriteLabel($i,$c,"$val");
		$c++;
	}
	
		$k=++$i;
	$totalArray = array('Total net Weight, kg :','Total gross weight, kg:','Total No. of cartons :','Total Volume, m3:');
	$totDataArray = array(number_format($dataholder['net'],2),number_format($dataholder['gross'],2),$totctns,$totVol);
	$nameArray = array('Name  :', 'Position  :','signature :');	
	foreach($totalArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i=$k;
	foreach($totDataArray as $frstcolData)
	{
		xlsWriteLabel(++$i,1,$frstcolData);
	}

	$i=$k;
	foreach($nameArray as $scndcol)
	{
		xlsWriteLabel(++$i,6,$scndcol);
	}

	
	
	xlsEOF();
	
?>