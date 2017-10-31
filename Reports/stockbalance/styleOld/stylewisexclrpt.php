<?php
	session_start();
	include "../../../Connector.php" ;

	$mainId		= $_GET["mainId"];
	$subId		= $_GET["subId"];
	$matItem	= $_GET["maiItem"];
	$color		= $_GET["color"];
	$size		= $_GET["size"];
	$style		= $_GET["style"];
	$mainStores	= $_GET["mainStores"];
	$with0		= $_GET["with0"];
	$x			= $_GET["x"];
	$dfrom		= $_GET["dfrom"];
	$dTo		= $_GET["dTo"];
	$CompanyID  	= $_SESSION["FactoryID"];
	$report_companyId = $CompanyID;
	//$checkDate  = $_GET["checkDate"];
	
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
header ("Content-Disposition: attachment; filename=StyleWiseStockBalance.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream


			$SQL = 	"SELECT  mainstores.strName FROM mainstores where strMainID=$mainStores";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
				$sStores =  $row["strName"];
				
			if($sStores=='')
				$sStores = 'All';	
				
			switch($x)
			{
				case 'all':
				{
					$reportType = 'All';
					break;
				}
				case 'running':
				{
					$reportType = 'Running';
					break;
				}
				case 'leftOvers':
				{
					$reportType = 'Leftover';
					break;
				}
			}	
	$i=5;	
	xlsWriteLabel(3,2,"STOCK BALANCE REPORT ($sStores) - $reportType ");
	xlsWriteLabel($i,0,"Style No");
    xlsWriteLabel($i,1,"Order No");				
	xlsWriteLabel($i,2,"SCNo");
	xlsWriteLabel($i,3,"Material");
	xlsWriteLabel($i,4,"Color");
	xlsWriteLabel($i,5,"Size");
	xlsWriteLabel($i,6,"Stock Balance");
	xlsWriteLabel($i,7,"Stock Balance Value");
	if($x == 'all')
	{
		xlsWriteLabel($i,8,"Leftover Stock Balance");
		xlsWriteLabel($i,9,"Leftover Stock Value");
	}
	$i++;
	$check	= false;
		
		if($x=='leftOvers')
			$tbl='stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
				
			$SQL = 	"(SELECT
					MIL.strItemDescription,
					O.intStyleId,
					O.strOrderNo,O.strStyle,(select intSRNO from specification where specification.intStyleId=ST.intStyleId)As ScNo,
					ST.strColor,
					ST.strSize,
					round(sum(ST.dblQty),4) as balanceQty,
					ST.intMatDetailId,
					(select sum(SL.dblQty) from stocktransactions_leftover SL
					Inner Join matitemlist MIL ON MIL.intItemSerial = SL.intMatDetailId
					  where SL.intMatDetailId=ST.intMatDetailId and SL.strColor=ST.strColor and SL.strSize=ST.strSize and SL.strMainStoresID >0 ";
					  //get search criteria wise leftover stock qty
				if($mainStores != '')
				$SQL1 .=" and SL.strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL1 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL1 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL1 .=" and SL.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL1 .=" and SL.strColor ='$color' ";
			if($size!='')
				$SQL1 .=" and SL.strSize ='$size' ";	
			if($style!='')
				$SQL1 .=" and SL.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL1 .=" and MIL.strItemDescription like '%$txtmatItem%' ";
					
				$SQL1 .=" ) as leftoverStockQty ,1 as stockType
					FROM
					$tbl ST
					Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId
					left join orders O ON O.intStyleId = ST.intStyleId
					where strMainStoresID>0";
			if($mainStores != '')
				$SQL1 .=" and strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL1 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL1 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL1 .=" and ST.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL1 .=" and strColor ='$color' ";
			if($size!='')
				$SQL1 .=" and strSize ='$size' ";	
			if($style!='')
				$SQL1 .=" and ST.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL1 .=" and MIL.strItemDescription like '%$txtmatItem%' ";	
			if($x=='running')
				$SQL1 .=" and O.intStatus not in (13,14) ";
			/*if($x=='leftOvers')
				$SQL1 .=" and O.intStatus=13 ";*/
				
			$SQL2 = " GROUP BY O.intStyleId,ST.intMatDetailId,strColor,strSize";
			
			if($with0=='true')
				$SQL2 .= " having balanceQty>=0 )";
			else
				$SQL2 .= " having balanceQty>0 )";
			
			//get items which are in leftoverstock
			if($x == 'all')
			{
				$SQL2 .= " union
(select mil.strItemDescription,O.intStyleId,O.strOrderNo,O.strStyle,(select intSRNO from specification where specification.intStyleId=sl.intStyleId)As ScNo,sl.strColor,sl.strSize,0,sl.intMatDetailId,round(sum(sl.dblQty),4) as balanceQty,2
from stocktransactions_leftover sl inner join matitemlist mil on
mil.intItemSerial = sl.intMatDetailId
left join orders O ON O.intStyleId = sl.intStyleId 
where sl.intMatDetailId not in (select st.intMatDetailId from stocktransactions st
inner join matitemlist mil on mil.intItemSerial = st.intMatDetailId
 where st.intMatDetailId=sl.intMatDetailId and sl.strColor = st.strColor and st.strSize=sl.strSize ";
//get search criteria wise leftover stock qty
	if($mainStores != '')
				$SQL2 .=" and strMainStoresID =$mainStores ";	
	if($mainId!='')
				$SQL2 .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$SQL2 .=" and intSubCatID =$subId ";
	if($matItem!='')
		$SQL2 .=" and st.intMatDetailId =$matItem ";	
	if($color!='')
		$SQL2 .=" and strColor ='$color' ";
	if($size!='')
		$SQL2 .=" and strSize ='$size' ";	
	if($style!='')
		$SQL2 .=" and st.intStyleId ='$style' ";
	if($txtmatItem!='')
		$SQL2 .=" and mil.strItemDescription like '%$txtmatItem%' ";				
				//end search criteria wise leftover stock qty
	$SQL2 .= " ) ";
				if($mainStores != '')
				$SQL2 .=" and strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL2 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL2 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL2 .=" and sl.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL2 .=" and strColor ='$color' ";
			if($size!='')
				$SQL2 .=" and strSize ='$size' ";	
			if($style!='')
				$SQL2 .=" and sl.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL2 .=" and mil.strItemDescription like '%$txtmatItem%' ";	
				
				$SQL2 .= "GROUP BY O.intStyleId,sl.intMatDetailId,strColor,strSize";
			
			if($with0=='true')
				$SQL2 .= " having balanceQty>=0 )";
			else
				$SQL2 .= " having balanceQty>0 )";
			}
			
			//if leftover don't show the not trim inspected 
		if($x !='leftOvers')
			{
			$SQL2 .= " union
(select mil.strItemDescription,O.intStyleId,O.strOrderNo,O.strStyle,(select intSRNO from specification where specification.intStyleId=sl.intStyleId)As ScNo,sl.strColor,sl.strSize,round(sum(sl.dblQty),4) as balanceQty,sl.intMatDetailId,0,3
from stocktransactions_temp sl inner join matitemlist mil on
mil.intItemSerial = sl.intMatDetailId
inner join grnheader gh on gh.intGrnNo= sl.intGrnNo and gh.intGRNYear=sl.intGrnYear
left join orders O ON O.intStyleId = sl.intStyleId 
where  sl.strType='GRN' and gh.intStatus=1 ";
				if($mainStores != '')
				$SQL2 .=" and strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL2 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL2 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL2 .=" and sl.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL2 .=" and strColor ='$color' ";
			if($size!='')
				$SQL2 .=" and strSize ='$size' ";	
			if($style!='')
				$SQL2 .=" and sl.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL2 .=" and mil.strItemDescription like '%$txtmatItem%' ";	
				
				$SQL2 .= "GROUP BY O.intStyleId,sl.intMatDetailId,strColor,strSize";
				
			if($with0=='true')
				$SQL2 .= " having balanceQty>=0 )";
			else
				$SQL2 .= " having balanceQty>0 )";
			}	
			$SQL3 = " ORDER BY strOrderNo,strItemDescription,strColor,strSize ASC ";
			$SQL = $SQL.$SQL1.$SQL2.$SQL3;
			//echo $SQL;
			$result = $db->RunQuery($SQL);
			$totRunStock =0;
			$totLeftStock = 0;
			$totVal=0;
			$totLeftVal =0;
			$preStyleId = 0;
			while($row = mysql_fetch_array($result))
			{
				
				$currStyleId = $row["intStyleId"];
				$totRunStock +=  $row["balanceQty"];
				$totLeftStock +=  $row["leftoverStockQty"];
				$style		 = $row["intStyleId"];
				$trimInsValue =0;
				$value=0;
			//stockType 1-get data from stocktransation , 3- get data from stocktransaction temp(not trim inspected data)
				$stockType = $row["stockType"];
				switch($stockType)
				{
					case 1:
					{
						$value = getStockValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,$tbl);
						$trimInsValue =0;
						$tblVal=$tbl;
						break;
					}
					case 3:
					{
						$value = 0;
						$trimInsValue =getTrimInspectValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,'stocktransactions_temp');
						$tblVal= 'stocktransactions_temp';
						break;
					}
				}
				$value += $trimInsValue;

			if($check)
			{
				if($currStyleId!=$preStyleId && $total>0)
				{
					xlsWriteLabel($i,0,"Order Wise Sub Total ");
					xlsWriteLabel($i,6,$total);
					$i++;
					$total=0;
				}
			}
			$total +=$row["balanceQty"];
			if($stockType !=3)	
			{
				$check =true;
				xlsWriteLabel($i,0,$row["strStyle"]);	
				xlsWriteLabel($i,1,$row["strOrderNo"]);
				xlsWriteLabel($i,2,$row["ScNo"]);
				xlsWriteLabel($i,3,$row["strItemDescription"]);
				xlsWriteLabel($i,4,$row["strColor"]);
				xlsWriteLabel($i,5,$row["strSize"]);
				xlsWriteLabel($i,6,round($row["balanceQty"],4));
				$totVal += $value;
				xlsWriteLabel($i,7,number_format($value,4));
			
				if($x == 'all')
				{
					$check =true;
					xlsWriteLabel($i,8,round($row["leftoverStockQty"],4));
					$leftValue = getStockValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,'stocktransactions_leftover');
					$totLeftVal += $leftValue;
					xlsWriteLabel($i,9,number_format($leftValue,4));
					
				}
			}
			else
			{
				$check =true;
				xlsWriteLabel($i,0,$row["strStyle"]);	
				xlsWriteLabel($i,1,$row["strOrderNo"]);
				xlsWriteLabel($i,2,$row["ScNo"]);
				xlsWriteLabel($i,3,$row["strItemDescription"]);
				xlsWriteLabel($i,4,$row["strColor"]);
				xlsWriteLabel($i,5,$row["strSize"]);
				xlsWriteLabel($i,6,round($row["balanceQty"],4));
				$totVal += $value;
				xlsWriteLabel($i,7,number_format($value,4));
				
				if($x == 'all')
				{
					$check =true;
					xlsWriteLabel($i,8,round($row["leftoverStockQty"],4));
					$leftValue = getStockValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,'stocktransactions_leftover');
					$totLeftVal += $leftValue;
					xlsWriteLabel($i,9,number_format($leftValue,4));
			  	}
			}
			$preStyleId=$currStyleId;	
			$i++;
		}
		
			xlsWriteLabel($i,0,"Order Wise Sub Total ");	
			xlsWriteLabel($i,5,$total);	    
			$i++;
			xlsWriteLabel($i,0,"Grand Total");	
			xlsWriteLabel($i,6,round($totRunStock,4));	
			xlsWriteLabel($i,7,number_format($totVal,4));	
		if($x == 'all')
			{
				xlsWriteLabel($i,8,round($totLeftStock,4));	
				xlsWriteLabel($i,9,number_format($totLeftVal,4));	      
		  	}
function getStockValue($matDetailID,$color,$size,$with0,$mainStores,$style,$tbl)
{
	global $db;
	$sql = "select sum(dblQty) as qty,intGrnNo,intGrnYear,strGRNType,intStyleId";
	
	if($tbl == 'stocktransactions_leftover')
		$sql .= " ,dblUnitPrice ";
		
 	$sql .= " from $tbl where intMatDetailId='$matDetailID' and strColor='$color' and strSize='$size' ";
	
	if($mainStores !='')
		$sql .= " and strMainStoresID = '$mainStores' ";
	if($style !='')
		$sql .= " and intStyleId = '$style' ";
	
	$sql .= " group by intGrnNo,intGrnYear,strGRNType";
	
	/*if($tbl == 'stocktransactions_leftover')
		$sql .= " ,dblUnitPrice ";*/
	
	if($with0 == 'false')
		$sql .= " having qty>0 ";
	//echo $sql;
	$result = $db->RunQuery($sql);
	$value =0;
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$intGrnNo = $row["intGrnNo"];
		$intGrnYear = $row["intGrnYear"];
		$strGRNType = $row["strGRNType"];
		$intStyleId = $row["intStyleId"];
		
		if($strGRNType == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor='$color' and  gd.strSize = '$size' and gd.intStyleId = '$intStyleId' ";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($strGRNType == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$intGrnNo' and gd.intYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor ='$color'  and gd.strSize ='$size' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
		}
		
		$value += $grnQty*$unitPrice/$exRate;
		if($intGrnNo<20)
			$value+=$grnQty*$row["dblUnitPrice"];
	}
	return round($value,4);
	
}
function getTrimInspectValue($matDetailID,$color,$size,$with0,$mainStores,$style,$tbl)
{
	global $db;
	$sql = "select sum(dblQty) as qty,ST.intGrnNo,ST.intGrnYear,ST.strGRNType,ST.intStyleId
 from $tbl  ST 
 inner join grnheader gh on gh.intGrnNo= ST.intGrnNo and gh.intGRNYear=ST.intGrnYear
 where strType='GRN' and gh.intStatus=1 and intMatDetailId='$matDetailID' and strColor='$color' and strSize='$size'
  ";
	
	if($mainStores !='')
		$sql .= " and strMainStoresID = '$mainStores' ";
	if($style !='')
		$sql .= " and ST.intStyleId = '$style' ";
	
	$sql .= " group by ST.intGrnNo,ST.intGrnYear,ST.strGRNType";
	
	if($with0 == 'false')
		$sql .= " having qty>0 ";
	//echo $sql;	
	$result = $db->RunQuery($sql);
	$value =0;
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$intGrnNo = $row["intGrnNo"];
		$intGrnYear = $row["intGrnYear"];
		$strGRNType = $row["strGRNType"];
		$intStyleId = $row["intStyleId"];
		
		if($strGRNType == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor='$color' and  gd.strSize = '$size' and gd.intStyleId = '$intStyleId' ";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($strGRNType == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$intGrnNo' and gd.intYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor ='$color'  and gd.strSize ='$size' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
		}
		
		$value += $grnQty*$unitPrice/$exRate;
		if($intGrnNo<20)
			$value=0;
	}
	//echo $value;
	return round($value,4);
	
}
xlsEOF();
?>