<?php 
	session_start();
 $backwardseperator = "../../";
 
 $mainId 	= $_GET["mainId"];
 $subCatId	= $_GET["subCatId"];
 $ItemID	= $_GET["ItemID"];
 $mainStore	= $_GET["mainStore"];
 $itemDesc  = $_GET["itemDesc"];
 $tdate 	= date('Y-m-d');
 
/* $mainId 	='';
 $subCatId	= '';
 $ItemID	= '';
 $mainStore	= '1';
 $itemDesc  = '';
 $tdate 	= date('Y-m-d');*/
 
 $report_companyId =$_SESSION["FactoryID"];
 
 $deci = 2; //no of decimal places
 
 $repType = $_GET['excelRep'];
 
   if($repType == "E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="Age Analysis Report - General.xls"');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>General Age Analysis Report</title>
<link href="../../css/erpstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php 
include "../../Connector.php";

?>
<table width="1050" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="1050" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="head2BLCK">General Age Analysis Report as at - <?php echo date('d-F-Y'); ?></td>
      </tr>
      <tr>
        <td class="head2BLCK">&nbsp;Stores - <?php echo getMainStores($mainStore); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="1050" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
          <tr bgcolor="#CCCCCC">
          	<td width="59" class="normalfnBLD1" align="center">Item Code</td>
            <td width="149" class="normalfnBLD1" height="23" >Item Decription </td>
            <td width="59" class="normalfnBLD1" align="center">Unit</td>
            <td width="60" class="normalfnBLD1" align="center">Qty(1-30)</td>
            <td width="65" class="normalfnBLD1" align="center">Val(1-30)</td>
            <td width="69" class="normalfnBLD1" align="center">Qty(31-60)</td>
            <td width="76" class="normalfnBLD1" align="center">Val(31-60)</td>
            <td width="67" class="normalfnBLD1" align="center">Qty(61-90)</td>
            <td width="73" class="normalfnBLD1" align="center">Val(61-90)</td>
            <td width="64" class="normalfnBLD1" align="center">Qty(91-120)</td>
            <td width="85" class="normalfnBLD1" align="center">Val(91-120)</td>
            <td width="52" class="normalfnBLD1" align="center">Qty(120 or More)</td>
            <td width="58" class="normalfnBLD1" align="center">Val(120 or More)</td>
            <td width="64" class="normalfnBLD1" align="center">Total</td>
            <td width="66" class="normalfnBLD1" align="center">Total Val</td>
          </tr>
          <?php 
		  //get base currency details
		  $baseCurrncy = getBaseCurrency();
		  $totQty = 0;
		  $totValue = 0;
		  //get items in the stock
		  $sql = " select GMT.strItemDescription, GMT.strUnit,GST.intMatDetailId,GMT.strItemCode
				from genstocktransactions GST inner join genmatitemlist GMT on GMT.intItemSerial = GST.intMatDetailId
				where GST.strMainStoresID='$mainStore' and GST.intGRNNo is not null";
				
			if($mainId != '')	
				$sql .= " and GMT.intMainCatID = '$mainId' ";
				
			if($subCatId != '')
				 $sql .= " and GMT.intSubCatID = '$subCatId' ";
			
			if($itemDesc != '')
				 $sql .= " and GMT.strItemDescription like '%$itemDesc%' ";
				 
			if($ItemID != '')
				$sql .= " and GST.intMatDetailId = '$ItemID' ";
				
			$sql .= " group by GMT.strItemDescription, GMT.strUnit,GST.intMatDetailId
				having sum(GST.dblQty)>0
				order by GMT.strItemDescription ";
				
				$result = $db->RunQuery($sql);
				
				while($row = mysql_fetch_array($result))
						{
						
						$matDetailID = $row["intMatDetailId"];
		  ?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfnt"><?php echo $row["strItemCode"]; ?></td>
            <td class="normalfnt"><?php echo $row["strItemDescription"]; ?></td>
            <td class="normalfntMid"><?php echo $row["strUnit"]; ?></td>
            <td class="normalfntRite">
            <?php 
				$sql30 = "select  sum(GST.dblQty) as qty 
						from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo 
						 and GGH.intYear = GST.intGRNYear
						where GST.intMatDetailId='$matDetailID'  and  GST.strMainStoresID='$mainStore' and 
						TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate) between 1 and 30  ";
						
						$result30 = $db->RunQuery($sql30);
						$row30 = mysql_fetch_array($result30);
						$qty30 = $row30["qty"];
						
						$totQty += $qty30;
						echo $qty30;
			?>
            </td>
            <td class="normalfntRite"><?php 
			$totVal30 = '';
			$sqlV30 = " Select  sum(GST.dblQty) as qty, GST.intGrnNo,GPO.strCurrency,GGD.dblRate 
		from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo  and GGH.intYear = GST.intGRNYear
		inner join gengrndetails GGD on GGD.strGenGrnNo = GGH.strGenGrnNo and GGD.intYear = GGH.intYear
		and GGD.strGenGrnNo = GST.intGRNNo and GGD.intYear =GST.intGRNYear and 
		GGD.intMatDetailID = GST.intMatDetailId 
		 inner join generalpurchaseorderheader GPO on GPO.intGenPONo = GGH.intGenPONo and GGH.intGenPOYear = GPO.intYear
		where GST.intMatDetailId='$matDetailID'  and  GST.strMainStoresID='$mainStore' and
		TO_DAYS('$tdate')-TO_DAYS(GGH.dtmConfirmedDate) between 1 and 30
		  group by GST.intGRNNo 
		  having sum(GST.dblQty)>0" ;
  	
		$resultV30 = $db->RunQuery($sqlV30);
		while($rowV30 = mysql_fetch_array($resultV30))
			{
				$poCurrency = $rowV30["strCurrency"];
				$value      = $rowV30["qty"]*$rowV30["dblRate"];
				
				if($poCurrency != $baseCurrncy)
					$totVal30 += getUSDValue($value,$poCurrency);
				else
					$totVal30 += $value;	
			}
			$totVal30 = round($totVal30,$deci);
			$totValue += $totVal30;
			if($totVal30 != 0)
			echo number_format($totVal30,$deci);
  ?></td>
            <td class="normalfntRite"><?php 
				$sql60 = "select  sum(GST.dblQty) as qty 
						from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo 
						 and GGH.intYear = GST.intGRNYear
						where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore'  
						and TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate) between 31 and 60 ";
						
						$result60 = $db->RunQuery($sql60);
						$row60 = mysql_fetch_array($result60);
						
						$qty60 = $row60["qty"];
						
						$totQty += $qty60;
						echo $qty60;
			?></td>
            <td class="normalfntRite"><?php 
			
			$totVal60 = '';
			$sqlV60 = " Select  sum(GST.dblQty) as qty, GST.intGRNNo,GPO.strCurrency,GGD.dblRate 
		from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo  and GGH.intYear = GST.intGRNYear
		inner join gengrndetails GGD on GGD.strGenGrnNo = GGH.strGenGrnNo and GGD.intYear = GGH.intYear
		and GGD.strGenGrnNo = GST.intGrnNo and GGD.intYear = GST.intGrnYear and 
		GGD.intMatDetailID = GST.intMatDetailId 
		 inner join generalpurchaseorderheader GPO on GPO.intGenPONo = GGH.intGenPONo and GGH.intGenPOYear = GPO.intYear
		where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore' 
		and TO_DAYS('$tdate')-TO_DAYS(GGH.dtmConfirmedDate) between 31 and 60
		  group by GST.intGRNNo 
		  having sum(GST.dblQty)>0" ;
  	
		$resultV60 = $db->RunQuery($sqlV60);
		while($rowV60 = mysql_fetch_array($resultV60))
			{
				$poCurrency = $rowV60["strCurrency"];
				$value      = $rowV60["qty"]*$rowV60["dblRate"];
				
				if($poCurrency != $baseCurrncy)
					$totVal60 += getUSDValue($value,$poCurrency);
				else
					$totVal60 += $value;	
			}
			$totVal60 = round($totVal60,$deci);
			$totValue += $totVal60;
			if($totVal60 != 0)
			 echo number_format($totVal60,$deci);
  ?></td>
            <td class="normalfntRite"> <?php 
				$sql90 = "select  sum(GST.dblQty) as qty 
						from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo 
						 and GGH.intYear = GST.intGRNYear
						where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore'  
						and TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate) between 61 and 90 ";
						
						$result90 = $db->RunQuery($sql90);
						$row90 = mysql_fetch_array($result90);
						$qty90 = $row90["qty"];
						
						$totQty += $qty90;
						echo $qty90;
			?></td>
            <td class="normalfntRite"><?php 
			
			$totVal90 = '';
			$sqlV90 = " Select  sum(GST.dblQty) as qty, GST.intGRNNo,GPO.strCurrency,GGD.dblRate 
		from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo  and GGH.intYear = GST.intGRNYear
		inner join gengrndetails GGD on GGD.strGenGrnNo = GGH.strGenGrnNo and GGD.intYear = GGH.intYear
		and GGD.strGenGrnNo = GST.intGrnNo and GGD.intYear = GST.intGrnYear and 
		GGD.intMatDetailID = GST.intMatDetailId 
		 inner join generalpurchaseorderheader GPO on GPO.intGenPONo = GGH.intGenPONo and GGH.intGenPOYear = GPO.intYear
		where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore' 
		and TO_DAYS('$tdate')-TO_DAYS(GGH.dtmConfirmedDate) between 61 and 90
		  group by GST.intGRNNo 
		  having sum(GST.dblQty)>0" ;
  	
		$resultV90 = $db->RunQuery($sqlV90);
		while($rowV90 = mysql_fetch_array($resultV90))
			{
				$poCurrency = $rowV90["strCurrency"];
				$value      = $rowV90["qty"]*$rowV90["dblRate"];
				
				if($poCurrency != $baseCurrncy)
					$totVal90 += getUSDValue($value,$poCurrency);
				else
					$totVal90 += $value;	
			}
			$totVal90 = round($totVal90,$deci);
			$totValue += $totVal90;
			if($totVal90 != 0)
			  echo number_format($totVal90,$deci);
  ?></td>
            <td class="normalfntRite"><?php 
				$sql120 = "select  sum(GST.dblQty) as qty 
						from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo 
						 and GGH.intYear = GST.intGRNYear
						where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore'  
						and TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate) between 91 and 120  ";
						
						$result120 = $db->RunQuery($sql120);
						$row120 = mysql_fetch_array($result120);
						$qty120 = $row120["qty"];
						
						$totQty += $qty120;
						echo $qty120;
			?></td>
            <td class="normalfntRite"><?php 
			
			$totVal120 = '';
			
			$sqlV120 = " Select  sum(GST.dblQty) as qty, GST.intGRNNo,GPO.strCurrency,GGD.dblRate 
		from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo  and GGH.intYear = GST.intGRNYear
		inner join gengrndetails GGD on GGD.strGenGrnNo = GGH.strGenGrnNo and GGD.intYear = GGH.intYear
		and GGD.strGenGrnNo = GST.intGrnNo and GGD.intYear = GST.intGrnYear and 
		GGD.intMatDetailID = GST.intMatDetailId 
		 inner join generalpurchaseorderheader GPO on GPO.intGenPONo = GGH.intGenPONo and GGH.intGenPOYear = GPO.intYear
		where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore' 
		and TO_DAYS('$tdate')-TO_DAYS(GGH.dtmConfirmedDate) between 91 and 120
		  group by GST.intGRNNo 
		  having sum(GST.dblQty)>0" ;
  	
		$resultV120 = $db->RunQuery($sqlV120);
		while($rowV120 = mysql_fetch_array($resultV120))
			{
				$poCurrency = $rowV120["strCurrency"];
				$value      = $rowV120["qty"]*$rowV120["dblRate"];
				
				if($poCurrency != $baseCurrncy)
					$totVal120 += getUSDValue($value,$poCurrency);
				else
					$totVal120 += $value;	
			}
			$totVal120 = round($totVal120,$deci);
			$totValue += $totVal120;
			if($totVal120 != 0)
			echo number_format($totVal120,$deci);
  ?></td>
            <td class="normalfntRite"><?php 
				$sqlStock = "select  sum(GST.dblQty) as qty 
						from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo 
						 and GGH.intYear = GST.intGRNYear
						where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore'  
						and TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate)>120 ";
						
						$resultStock = $db->RunQuery($sqlStock);
						$rowS = mysql_fetch_array($resultStock);
						$qtyS = $rowS["qty"];
						
						$totQty += $qtyS;
						echo number_format($qtyS,2);
			?></td>
            <td class="normalfntRite"><?php 
			
			$totV = '';
			
			$sqlVal = " Select  sum(GST.dblQty) as qty, GST.intGRNNo,GPO.strCurrency,GGD.dblRate 
		from genstocktransactions GST inner join gengrnheader GGH on GGH.strGenGrnNo=GST.intGRNNo  and GGH.intYear = GST.intGRNYear
		inner join gengrndetails GGD on GGD.strGenGrnNo = GGH.strGenGrnNo and GGD.intYear = GGH.intYear
		and GGD.strGenGrnNo = GST.intGrnNo and GGD.intYear = GST.intGrnYear and 
		GGD.intMatDetailID = GST.intMatDetailId 
		 inner join generalpurchaseorderheader GPO on GPO.intGenPONo = GGH.intGenPONo and GGH.intGenPOYear = GPO.intYear
		where GST.intMatDetailId='$matDetailID'  and GST.strMainStoresID='$mainStore' 
		and TO_DAYS('$tdate')-TO_DAYS(GGH.dtmConfirmedDate) > 120
		  group by GST.intGRNNo 
		  having sum(GST.dblQty)>0" ;
  	
		$resultVal = $db->RunQuery($sqlVal);
		while($rowVal = mysql_fetch_array($resultVal))
			{
				$poCurrency = $rowVal["strCurrency"];
				$value      = $rowVal["qty"]*$rowVal["dblRate"];
				
				if($poCurrency != $baseCurrncy)
					$totV += getUSDValue($value,$poCurrency);
				else
					$totV += $value;	
			}
			$totV = round($totV,$deci);
			$totValue += $totV;
			if($totV != 0)
				echo number_format($totV,$deci);
  ?></td>
            <td class="normalfntRite"><?php echo number_format($totQty,2);
			$totQty =0;
			 ?></td>
            <td class="normalfntRite"><?php echo number_format($totValue,$deci);
			$totValue =0;
			 ?></td>
          </tr>
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 
function getBaseCurrency()
{
	global $db;
	
	$sql=" select strCurrency from currencytypes c inner join systemconfiguration s on c.intCurID = s.intBaseCurrency";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCurrency"];	
}

function getUSDValue($value,$currency)
{
	global $db;
	global $deci;
	$dollarRate = 1;
	$sql = "SELECT ER.rate FROM currencytypes CT inner join exchangerate ER on ER.currencyID=CT.intCurID WHERE CT.strCurrency = '". $currency . "' and ER.intStatus=1;";
	$rst = $db->RunQuery($sql);
	while($rw = mysql_fetch_array($rst))
	{
		$dollarRate = $rw["rate"];
		break;
	}
	return round(($value / $dollarRate),$deci);
}

function getMainStores($prmMainStoresId){
	
	global $db;
	
	$sql = " SELECT strName FROM mainstores WHERE strMainID = $prmMainStoresId ";
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result)){
		return $row['strName'];	
	}
		
	
}
?>
</body>
</html>
