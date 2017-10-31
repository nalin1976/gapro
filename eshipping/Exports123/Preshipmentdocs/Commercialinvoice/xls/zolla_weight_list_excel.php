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
	header ("Content-Disposition: attachment; filename=zolla_weight_list_excel.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	xlsWriteLabel(++$i,0,"ORIT TRADING LANKA (PVT) LTD");
	xlsWriteLabel(++$i,0,"07-02, East Tower, World Trade Centre, Echelon Square, Colombo 01, Sri Lanka. Tel: 0094-111-2346370 Fax:0094-111-2346376");
	++$i;
	xlsWriteLabel(++$i,0,"NET WEIGHTS");
	

	$arraycol 		= array('INVOICE No:','Date :','Contract No :','Date :');
	$conNo=$r_summary->summary_string($invoiceNo,'strBuyerPONo');
	$arrayconNO	= explode('-',$conNo);
	$arraycolData	= array($invoiceNo,$dateInvoice,$arrayconNO[1],'');
	//$arraycolData	= array(1234,'12/07/2011',79,'12/07/2011');//testing data must be commented
	$original	=	$i;
	foreach($arraycol as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i=$original;
	foreach($arraycolData as $frstcoldata)
	{
		xlsWriteLabel(++$i,1,$frstcoldata);
	}
	
	
	$k			=	$i++;
	$original	=	$i;
	$firstColArray	 		= array('Order No.','Specification No.');
	$firstColDataArray		= array($conNo,'');
	//$firstColDataArray		= array('109-79','2');//testing data must be commented
	
	foreach($firstColArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i=$original;
	foreach($firstColDataArray as $frstcolData)
	{
		xlsWriteLabel(++$i,1,$frstcolData);
	}
	
	$secondColArray			= array('Order Date :','Specification Date:');
	$secondCoDatalArray		= array('','');
	//$secondCoDatalArray		= array('12/07/2011','12/07/2011'); //testing data must be commented
	$i=++$k;
	$original	=	$i;

	foreach($secondColArray as $scndcol)
	{
		xlsWriteLabel(++$i,5,$scndcol);
	}
	
	$i=$original;
	foreach($secondCoDatalArray as $scndcolData)
	{
		xlsWriteLabel(++$i,6,$scndcolData);
	}
	
	

############################################################
# supporting function                                      #
############################################################

function size_wise_total($obj,$plno)
{
	global $db;
	$size_tot		=0;
	$str			="select intRowNo,dblPcs from shipmentplsubdetail
						where strPLNo='$plno' and intColumnNo='$obj'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=size_ctn_total($row['intRowNo'],$row['dblPcs'],$plno);
	}
	return $size_tot;
}

function size_ctn_total($row,$pcs,$plno)
{
	global $db;
	$size_tot		=0;
	$str			="select dblNoofCTNS from shipmentpldetail 
						where strPLNo='$plno' and intRowNo='$row'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=$row['dblNoofCTNS']*$pcs;
	}
	return $size_tot;
} 

   $arrayGrid = array('ARTICLE','colour');
   $i++; $c=0;
	## developing the query############################
	
	$str_pl="select strPLno,strStyleID ,dblCBM,intNoOfCTns from commercial_invoice_detail where strInvoiceNo='$invoiceNo'";
	$result_pl=$db->RunQuery($str_pl);
	
	while($row_pl=mysql_fetch_array($result_pl))
	{
			$colPrev = 2; // assigning the initial column val
			$plno=$row_pl['strPLno'];
			$StyleID=$row_pl['strStyleID'];
				
			$str_dyn="select strSize,intColumnNo+2 as colind,intColumnNo,dblNet from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
			$result_dyn=$db->RunQuery($str_dyn);
			
			 while($row_dyn=mysql_fetch_array($result_dyn)){
				

				xlsWriteLabel($i,0,'ARTICLE');
				xlsWriteLabel($i,1,'Colour');
				xlsWriteLabel($i,$row_dyn['colind'],$row_dyn['strSize']);
				$k=$row_dyn['colind'];
			 }
			 //including the last column heder
			xlsWriteLabel($i,++$k,'Empty carton weight,kg');
			$i++;
			// body goes here
	
	     $sql="SELECT
				shipmentplheader.strColor
				FROM
				shipmentplheader				
				WHERE
				shipmentplheader.strPLno =  '$plno';";
				
		$answer=$db->RunQuery($sql);
		$row_answer=mysql_fetch_array($answer);
		
				xlsWriteLabel($i,0,$StyleID);
				xlsWriteLabel($i,1,$row_answer["strColor"]);
				$totVol+=$result_pl["dblCBM"];
				$totctns+=$result_pl["intNoOfCTns"];
	
			$result_dyn=$db->RunQuery($str_dyn);
			while($row_dyn=mysql_fetch_array($result_dyn)){
			$pl_pcs=round((size_wise_total($row_dyn['intColumnNo'],$plno)*$row_dyn['dblNet']),2);
			$tot_net_wt+=$pl_pcs;
		   
			xlsWriteLabel($i,$colPrev++, number_format($pl_pcs,2));}
			
		##########################################################
		# populating the ctn weight	
		
		$sql_ctnWt="SELECT
					Avg(shipmentpldetail.dblCTNWeight) as ctnWt
					FROM
					shipmentpldetail
					WHERE
					shipmentpldetail.strPLNo = '$plno'
					GROUP BY
					shipmentpldetail.strPLNo
					";
		$resCtnWt=$db->RunQuery($sql_ctnWt);
		$row_ctnWt=mysql_fetch_array($resCtnWt);
		xlsWriteNumber($i,$colPrev++,$row_ctnWt['ctnWt']);
			
			
			$i+=2;
		
		}
	
	
	$i+=4;
	$k=$i;
	
	$firstColArray = array('Total net weight :','Total gross weight:','Total No of cartons:','Total Volume:');	
	$firstColDataArray=array(number_format($dataholder['net'],2),number_format($dataholder['gross'],2),$totctns,$totVol);
	//$firstColDataArray=array(0.00,0.00,0,0.00);//test data must be commented
	$nameArray = array('Name  :', 'Position  :','signature :');	
		
	foreach($firstColArray as $frstcol)
	{
		xlsWriteLabel(++$i,0,$frstcol);
	}
	$i=$k;
	foreach($firstColDataArray as $frstcolData)
	{
		xlsWriteLabel(++$i,1,$frstcolData);
	}	
	
	$i=$k;
	foreach($nameArray as $scndcol)
	{
		xlsWriteLabel(++$i,3,$scndcol);
	}
	xlsEOF()
?>
