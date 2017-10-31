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
	$invoiceNo	=	$_GET['InvoiceNo'];
	$plno		=	$_GET["plno"];
	
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
	header ("Content-Disposition: attachment; filename=zolla_dpl_excel.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	xlsWriteLabel(++$i,0,$Company);
	xlsWriteLabel(++$i,0,$Address.", ".$City.". Tel: ".  $phone." Fax: ". $Fax);
	xlsWriteLabel(++$i,0,"DETAILED PACKING LIST");	
	
	++$i;
	xlsWriteLabel(++$i,0,"PACKING LIST");
	
	$conNo=$r_summary->summary_string($invoiceNo,'strBuyerPONo');
	$arrayconNO	= explode('-',$conNo); // deriving data for the contract number.


	$arrayGrid = array('INVOICE No.','Date','Contract No.','Date');
	$arrayGridData	=	array($invoiceNo,$dateInvoice,$arrayconNO[
	
	
	
	
	1],""); // data for above arrayGrid heading.
	//$arrayGridData	=	array(1210,'xxxx','$arrayconNO[1]',"yyyyy"); //test  data for above arrayGrid heading must be commented.
	$origPosition	= $i;
	
	foreach($arrayGrid as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	// populating data for arrayGrid heading.
	$i=	$origPosition;	
	foreach($arrayGridData as $frstcolData)
	{
		xlsWriteLabel(++$i,1,$frstcolData);
	}
	
	$k=$i++;
	
	$firstColArray 		= array('Order No..','Specification No.');
	$firstColArrayData	= array($conNo,""); // data for the firstColArray 
	//$firstColArrayData	= array('dddd',"dddd"); // Test data for the firstColArray must be commented
	
	$secondColArray		= array('Order Date :','Specification Date:');
	$secondColArrayData	= array($dateInvoice,"");//data fro the secondColArray 
	//$secondColArrayData	= array('dddd',"ddddd");//Testr data fro the secondColArray must be commented
	$origPosition = $i;
								
	foreach($firstColArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i = $origPosition; // re arrenge the row to the row where 'Order No' label is
	
	foreach($firstColArrayData as $frstcolData)
	{
		xlsWriteLabel(++$i,1,$frstcolData);	
	}
	
	$i=++$k;
	foreach($secondColArray as $scndcol)
	{
		xlsWriteLabel(++$i,3,$scndcol);
	}
	$i=$k;
	foreach($secondColArrayData as $scndcolData)
	{
		xlsWriteLabel(++$i,4,$scndcolData);
	}	
	
	################################################################
	# Query that retreives the dynomic size names                  #
	################################################################
	$str_dyn		="select strSize from shipmentplsizeindex where strPLNo='$plno'";
	$result_dyn		=$db->RunQuery($str_dyn);
	++$i;
		# creating the column headers
		xlsWriteLabel($i,0,'ARTICLE');
		xlsWriteLabel($i,1,'COLOR');
		xlsWriteLabel($i,2,'Carton /Bar code Number'); // now the column position is 2 actual cs value is 3.
	
	$c=3;	
	while($row_dyn=mysql_fetch_array($result_dyn))
	{
		$no_sizes++;	
		# setting the dynomic sise headers
		xlsWriteLabel($i,$c++,$row_dyn['strSize']);
			
	}
		# setting the tail column headers	
		xlsWriteLabel($i,$c++,'TOTAL PCS/CTN');
		xlsWriteLabel($i,$c++,'QTY OF CTN');
		xlsWriteLabel($i,$c++,'TOTAL QTY/ART');

		###################################################
		# populating the data to the grid                 #
		###################################################	
	
		
		 //to get the  colour and article
			    $sql="SELECT
				commercial_invoice_detail.strPLno,
				commercial_invoice_detail.strStyleID,
				commercial_invoice_detail.dblCBM,
				commercial_invoice_detail.intNoOfCTns,
				shipmentplheader.strColor,
				shipmentplheader.strCTNsvolume
				FROM
				commercial_invoice_detail
				Inner Join shipmentplheader ON commercial_invoice_detail.strPLno = shipmentplheader.strPLNo
				WHERE
				commercial_invoice_detail.strInvoiceNo = '$invoiceNo'
				 and commercial_invoice_detail.strPLno = '$plno'";
				
		$answer=$db->RunQuery($sql);
		$row_answer=mysql_fetch_array($answer);
		
		$article	=	$row_answer["strStyleID"];
		$colour		= 	$row_answer["strColor"];
		$demensionArray= explode('X',$row_answer["strCTNsvolume"]);
		$totVol		+= (($demensionArray[0]*$demensionArray[1]*$demensionArray[2]*$row_answer["intNoOfCTns"])/1000000);
		
		$sql_detail="SELECT
					shipmentpldetail.strPLNo,
					shipmentpldetail.dblNoofPCZ,
					shipmentpldetail.dblNoofCTNS,
					shipmentpldetail.dblQtyPcs,
					shipmentpldetail.intRowNo,
					shipmentpldetail.strColor,
					shipmentpldetail.strTagNo
					FROM
					shipmentpldetail
					WHERE
					shipmentpldetail.strPLNo = '$plno'";
	 $res_shpPlDtl	= $db->RunQuery($sql_detail);
	 while($row_shpPlDtl= mysql_fetch_array($res_shpPlDtl))
	 {
		 	$i++; // increment the row to the next row to populate the data.
			$c=0; // reset the column index to 0 when new data row is inserted
		$totCrtns+= $row_shpPlDtl["dblNoofCTNS"];
		$totQtyPcs+= $row_shpPlDtl["dblQtyPcs"];
			
		xlsWriteLabel($i,$c++,$article);
		xlsWriteLabel($i,$c++,$row_shpPlDtl["strColor"]);
		xlsWriteLabel($i,$c++,$row_shpPlDtl["strTagNo"]);
		
######## Handling the dynomic size data   #############################
		$row_index	=	$row_shpPlDtl["intRowNo"];
			
			$sql_shpSubDtl ="select ssi.strPLNo, 
							ssi.intColumnNo, 
							ssi.strSize,
							ssi.dblGross,
							ssi.dblNet,
							ssd.intRowNo,
							ssd.dblPcs																									
							from 
							shipmentplsizeindex ssi
							left join shipmentplsubdetail ssd
							on ssi.intColumnNo=ssd.intColumnNo and ssi.strPLNo=ssd.strPLNo
							where ssi.strPLNo='$plno' 
							and ssd.intRowNo='$row_index' order by ssi.intColumnNo";
		 $freez_col=$c;
		 $res_row	=	$db->RunQuery($sql_shpSubDtl);
		 while($row=mysql_fetch_array($res_row))
		 {
			$col_index=$row["intColumnNo"]+$freez_col;
			xlsWriteLabel($i,$col_index++,$row["dblPcs"]);
			 
		 }
		xlsWriteLabel($i,$no_sizes+1,$row_shpPlDtl["dblNoofPCZ"]);
		$j=$c;
		xlsWriteLabel($i,$no_sizes+2,$row_shpPlDtl["dblNoofCTNS"]);
		xlsWriteLabel($i,++$no_sizes+3,$row_shpPlDtl["dblQtyPcs"]);
	 }
		
	############### grid footer ###############################
	++$i;
		xlsWriteLabel($i,1,$row_shpPlDtl["TOTAL"]);
		xlsWriteLabel($i,$j,$totCrtns);
		xlsWriteLabel($i,++$j,$totQtyPcs);
	
	#### footer ####################################################################################################
	++$i;
		$subLeftArray = array('Total net weight:','Total gross weight:','Total No. of cartons:','Total Volume:');	
		$subLeftArrayData=array(number_format($dataholder['net'],2),number_format($dataholder['gross'],2),$totCrtns,$totVol);
	$nameArray = array('Name  :', 'Position  :','signature :');	
	$k=$i++;								
	foreach($subLeftArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i=$k;
	foreach($subLeftArray as $frstcoldata)
	{
		xlsWriteLabel(++$i,1,$frstcoldata);
	}
	
	$i=++$k;
	foreach($nameArray as $scndcol)
	{
		xlsWriteLabel(++$i,3,$scndcol);
	}	
	
	
	xlsEOF();

?>