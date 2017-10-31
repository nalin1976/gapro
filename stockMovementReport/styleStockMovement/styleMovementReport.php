<?php 
session_start();

include "../../Connector.php";
$backwardseperator = "../../";
				
	$orderId			= $_GET["styleId"];
	$matMainCategory	= $_GET["matMainCategory"];
	$SubCat = $_GET["SubCat"];
	$matDetailId =$_GET["matDetailId"];
	$matItemDesc = $_GET["matItemDesc"];
	$color =$_GET["color"];
	$size = $_GET["size"];
	$companyId  	= $_SESSION["FactoryID"];
	$report_companyId   = $companyId;
	$result_header = GetStyleDetails($orderId);
	while($row_header=mysql_fetch_array($result_header))
	{
		$orderNo		= $row_header["strOrderNo"];
		$styleNo		= $row_header["strStyle"];
		$scno			= $row_header["intSRNO"];
		$merchant		= $row_header["Merchandiser"];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Stock Movement :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}
</script>
</head>


<body>

<table width="100%" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td ><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
              </tr>
             <!-- <tr>
                <td width="18%"><img src="../images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>

              <td width="18%" class="normalfnt">&nbsp;</td>
				  
				   <td width="51%" class="tophead"><p class="topheadBLACK">&nbsp;</p>
		<p class="normalfnt">&nbsp;</p>        </td>
                 <td width="13%" class="tophead">&nbsp;</td>
              </tr>-->
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><p class="head2BLCK">Stock Movement</p>
      
      <table width="100%" border="0" cellpadding="0">
        
        <tr>
          <td width="50%" height="53"><table width="100%" border="0">
            <tr>
              <td width="9%" class="normalfnBLD1">Style No</td>
			  <td width="1%"><span class="normalfnBLD1">:</span></td>
              <td width="27%"><span class="normalfnt"><?php echo  $styleNo; ?></span></td>
              <td width="6%">&nbsp;</td>
              <td width="11%"><span class="normalfnBLD1"> Buyer PO No </span></td>
			  
              <td width="1%"><span class="normalfnBLD1">:</span></td>		  
              <td width="25%" class="normalfnt"><?php echo '#Main Ratio#' ;?></td>
              <td width="20%" class="normalfnBLD1">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnBLD1">Order No </td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php echo $orderNo;?></td>
              <td>&nbsp;</td>
              <td class="normalfnBLD1">SC No</td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php echo $scno;?></td>
              <td class="normalfnBLD1">&nbsp;</td>
            </tr>
           
          </table>
            </td>
        </tr>
    </table>      
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td width="100%"><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="1%" height="31"   class="normalfntMid">&nbsp;</th>
              <th width="6%"  class="normalfntMid">Color </th>
              <th width="6%"  class="normalfntMid" >Size</th>
              <th width="5%"  class="normalfntMid" >Unit</th>
              <th width="5%"  class="normalfntMid" >Req Qty </th>
              <th width="6%"   class="normalfntMid">Bal To Order </th>
              <th width="4%"   class="normalfntMid">Ordered Qty </th>
              <th width="6%"  class="normalfntMid">Stock Bal </th>
              <th width="4%" class="normalfntMid" >GRN Qty </th>
              <th width="4%"  class="normalfntMid" >Bulk Allo Qty </th>
              <th width="4%"  class="normalfntMid" >Leftover Allo Qty </th>
               <th width="4%" class="normalfntMid" >MRN Qty </th>
              <th width="6%"  class="normalfntMid">Issue Qty </th>
              <th width="6%"  class="normalfntMid">GatePass Qty  </th>
              <th width="6%"   class="normalfntMid">GP Trans Qty </th>
              <th width="6%"   class="normalfntMid">IJTIN Qty </th>
              <th width="6%"  class="normalfntMid">IJTOUT Qty </th>
              <th width="6%"  class="normalfntMid">Ret To Store </th>
              <th width="6%"  class="normalfntMid">Ret To Supp </th>
              <th width="6%"   class="normalfntMid">Bin Allo Out</th>
              <th width="6%"  class="normalfntMid">Bin Allo In</th>
              </tr>

<?php

$matDetailID = "";
$mainNo	= 0;
	$sql_details="SELECT orders.intStyleId AS intStyleId, specification.intSRNO,
					matmaincategory.strDescription, matitemlist.strItemDescription,
					matitemlist.intItemSerial AS intMatDetailId,
					materialratio.strColor, materialratio.strSize,materialratio.strBuyerPONo, 	
					matitemlist.strUnit,
					materialratio.dblQty AS Qty , materialratio.dblBalQty AS BalQty
					FROM orders Inner Join matitemlist
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					Inner Join materialratio 
					ON specification.intStyleId = materialratio.intStyleId 
					AND materialratio.strMatDetailID = matitemlist.intItemSerial
					Inner Join matmaincategory 
					ON matitemlist.intMainCatID = matmaincategory.intID
					WHERE orders.intStyleId = '$orderId' ";
if($matMainCategory!="")
	$sql_details .= " AND matmaincategory.intID = '$matMainCategory' ";
if($SubCat != "")
	$sql_details .= " and matitemlist.intSubCatID = '$SubCat' ";
if($matDetailId != "")
	$sql_details .= " and matitemlist.intItemSerial = '$matDetailId' ";
if($matItemDesc != "")
	$sql_details .= " and matitemlist.strItemDescription like '%$matItemDesc%' ";
if($color != "")
	$sql_details .= " and materialratio.strColor = '$color' ";
if($size != "")
	$sql_details .= " and materialratio.strSize = '$size' ";
				
	$sql_details .= "ORDER BY matmaincategory.intID ASC, materialratio.strMatDetailID ASC ;";
//echo $sql_details;
	$result_search = $db->RunQuery($sql_details);
	while($row_search = mysql_fetch_array($result_search )){		
		if($matDetailID<>$row_search["intMatDetailId"])
		{
			$matDetailID = $row_search["intMatDetailId"];
			$strUrl  = "itemStockMovementReport.php?StyleID=".$orderId.'&MatDetailID='.$matDetailID;
?>           
			<tr bgcolor="#E9E9E9">
              <td class="normalfnt" height="25"><?php echo ++$mainNo;?></td>
              <td colspan="2" class="normalfnt"><?php echo $row_search["strDescription"];?></td>
              <td colspan="18" class="normalfnt"><a href="<?php echo $strUrl; ?>" target="itemStockMovement"><?php echo $row_search["strItemDescription"]?></a></td>
              </tr>
<?php
		$subno	=$mainNo;
		}
		
?>
			  
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20">&nbsp;</td>
              <td class="normalfnt"><?php echo $row_search["strColor"];?></td> 
              <td class="normalfnt"><?php echo $row_search["strSize"]?></td>
              <td class="normalfntMid"><?php echo $row_search["strUnit"];?></td>
              <td class="normalfntR"><?php echo number_format($row_search["Qty"],2)?></td>
              <td class="normalfntR"><?php echo number_format($row_search["BalQty"],2)?></td>
              <td class="normalfntR"><?php 
$SQL_orderqty="SELECT sum(purchaseorderdetails.dblQty)as qty, purchaseorderdetails.intStyleId,
		 purchaseorderdetails.intMatDetailId,purchaseorderdetails.strColor,purchaseorderdetails.strSize
		 FROM purchaseorderdetails
		 Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo
		 AND purchaseorderheader.intYear = purchaseorderdetails.intYear
		 WHERE purchaseorderdetails.intStyleId =  '".$row_search["intStyleId"]."'
		 AND purchaseorderdetails.intMatDetailID =  '".$row_search["intMatDetailId"]."'
		 AND purchaseorderdetails.strColor =  '".$row_search["strColor"]."'
		 AND purchaseorderdetails.strSize =  '".$row_search["strSize"]."' 	 
		 AND purchaseorderheader.intStatus =  '10'
		 GROUP BY
		 purchaseorderdetails.intStyleId,
		 purchaseorderdetails.intMatDetailID,
		 purchaseorderdetails.strColor,
		 purchaseorderdetails.strSize,
		 purchaseorderdetails.strBuyerPONO ";		 

	$result_orderqty = $db->RunQuery($SQL_orderqty);
	while($row_orderqty=mysql_fetch_array($result_orderqty))
	{
			echo number_format($row_orderqty["qty"],2);
	}
?></td>
              <td class="normalfntR"><?php 
$hasStock = false;					
$SQL_bal="SELECT COALESCE(SUM(dblQty)) AS StockBal ".
		 "FROM stocktransactions ".
		 "WHERE intStyleId ='".$row_search["intStyleId"]."' ".
		 "and intMatDetailId =".$row_search["intMatDetailId"]." and ".
		 "strColor ='".$row_search["strColor"]."' ".
		 "and strSize = '".$row_search["strSize"]."'  ".
		 "GROUP BY intStyleId,intMatDetailId, strColor, ".
		 "strSize;";
	//echo $SQL_bal;	 
	$result_bal = $db->RunQuery($SQL_bal);
	while($row_bal=mysql_fetch_array($result_bal))
	{
		echo round($row_bal["StockBal"],2);
		$hasStock = true;
	}
?></td>
              <td class="normalfntR"><?php
if($hasStock){
$SQL_grn="SELECT COALESCE(SUM(ST.dblQty)) AS grnqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='GRN' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize;";
									
	$result_grn = $db->RunQuery($SQL_grn);
	while($row_grn=mysql_fetch_array($result_grn))
	{
		echo round($row_grn["grnqty"],2);
	}
}
?></td>
	<td class="normalfntR">
    	<?php
			$sql_b = "SELECT COALESCE(sum(BCD.dblQty),0) as BAlloQty
					FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
					BCD.intTransferNo = BCH.intTransferNo AND BCD.intTransferYear = BCH.intTransferYear
					WHERE BCH.intToStyleId = '$orderId'  and BCD.intMatDetailId = '" .$row_search["intMatDetailId"] ."' and BCH.intStatus=1 and BCD.strColor='".$row_search["strColor"]."' and BCD.strSize = '".$row_search["strSize"]."'"; 
			
	$result_b = $db->RunQuery($sql_b);
	$row_b = mysql_fetch_array($result_b);
	echo round($row_b["BAlloQty"],2);
		?>
    </td>
    <td class="normalfntR">
    	<?php 
			$sql_l = "SELECT COALESCE(sum(LCD.dblQty),0) as LeftAlloqty
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 	LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$orderId'  and 
						LCD.intMatDetailId = '" . $row_search["intMatDetailId"] ."' and LCH.intStatus=1 and LCD.strColor ='".$row_search["strColor"]."'  and LCD.strSize = '".$row_search["strSize"]."' ";
	$result_l = $db->RunQuery($sql_l);
	$row_l = mysql_fetch_array($result_l);
	echo round($row_l["LeftAlloqty"],2);
		?>
    </td>
    <td class="normalfntR">
    	<?php 
			$sql_m = "select COALESCE(sum(mrd.dblQty),0) as MRNQty from matrequisition mrn inner join matrequisitiondetails mrd on
mrn.intMatRequisitionNo = mrd.intMatRequisitionNo and mrn.intMRNYear= mrd.intYear
where mrd.intStyleId='$orderId' and strMatDetailID='".$row_search["intMatDetailId"]."' and strColor='".$row_search["strColor"]."' and strSize='".$row_search["strSize"]."'";

	$result_m = $db->RunQuery($sql_m);
	$row_m = mysql_fetch_array($result_m);
	echo round($row_m["MRNQty"],2);
		?>
    </td>
              <td class="normalfntR"><?php
if($hasStock){
$SQL_issue="SELECT COALESCE(SUM(ST.dblQty)) AS issueqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='ISSUE' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
				
	$result_issue = $db->RunQuery($SQL_issue);
	while($row_issue=mysql_fetch_array($result_issue))
	{
		echo round(($row_issue["issueqty"] * -1),2);
	}
}
?></td>
              <td class="normalfntR"><?php 
$totGatePassQty=0;
$GatePassQty=0;
$GatePassCancelQty=0;
if($hasStock){
$hasGatepass= false;
$sql_gatepass="SELECT COALESCE(SUM(ST.dblQty)) AS gatepassqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='SGatePass' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
				
	$result_gatepass = $db->RunQuery($sql_gatepass);
	while($row_gatepass=mysql_fetch_array($result_gatepass))
	{
		$GatePassQty=($row_gatepass["gatepassqty"] * -1);
		$hasGatepass= true;
	}
	
	if($hasGatepass){					
		$SQL_gatepass_cancel="SELECT COALESCE(SUM(dblQty)) AS jobtransoutcancelqty FROM stocktransactions ".
						"WHERE intStyleId ='".$row_search["intStyleId"]."' AND ".
						"strType='CSGatePass' and ".
						"intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
						"strColor ='".$row_search["strColor"]."' and ".
						"strSize = '".$row_search["strSize"]."'  ".
						"GROUP BY intStyleId,intMatDetailId, ".
						"strColor,strType, ".
						"strSize";
								
			$result_gatepass_cancel = $db->RunQuery($SQL_gatepass_cancel);
		while($row_gatepass_cancel=mysql_fetch_array($result_gatepass_cancel))
		{
			$GatePassCancelQty = $row_gatepass_cancel["jobtransoutcancelqty"];
		}
			$totGatePassQty = $GatePassQty-$GatePassCancelQty;	
			echo ($totGatePassQty==0 ? "":round($totGatePassQty));
	}
}
?></td>
              <td class="normalfntR"><?php 
$totGatePassTranIn=0;
$GatePassTranIn=0;
$GatePassTranInCancelQty =0;
if($hasStock){
$hasGPTransFerring = false;
$sql_gptransin="SELECT COALESCE(SUM(ST.dblQty)) AS gptransinqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='TI' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";						
						
						$result_gptransin = $db->RunQuery($sql_gptransin);
						while($row_gptransin=mysql_fetch_array($result_gptransin))
						{
							$GatePassTranIn=$row_gptransin["gptransinqty"];
							$hasGPTransFerring	= true;
                        }
	if($hasGPTransFerring){
		$sql_gptransin_cancel="SELECT COALESCE(SUM(dblQty)) AS gptransincancelqty FROM stocktransactions ".
				"WHERE intStyleId ='".$row_search["intStyleId"]."' AND ".
				"strType='CTI' and ".
				"intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"strColor ='".$row_search["strColor"]."' and ".
				"strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY intStyleId,intMatDetailId, ".
				"strColor,strType, ".
				"strSize";
						
				$result_gptransin_cancel = $db->RunQuery($sql_gptransin_cancel);
				while($row_gptransin_cancel=mysql_fetch_array($result_gptransin_cancel))
				{
					$GatePassTranInCancelQty = ($row_gptransin_cancel["gptransincancelqty"]*-1);
				}
					$totGatePassTranIn = $GatePassTranIn-$GatePassTranInCancelQty;
				
					echo ($totGatePassTranIn==0 ? "":round($totGatePassTranIn));
	}
}
?></td>
              <td class="normalfntR"><?php
$totInterJobTransIn=0;
$InterJobTransIn=0;
$InterJobTransInCancelQty =0;
if($hasStock){
$hasInterjobTransferIN = false;
$SQL_jobtransin="SELECT COALESCE(SUM(ST.dblQty)) AS jobtransinqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='IJTIN' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";			  			
						$result_jobtransin = $db->RunQuery($SQL_jobtransin);
						while($row_jobtransin=mysql_fetch_array($result_jobtransin))
						{
							$InterJobTransIn = $row_jobtransin["jobtransinqty"];
							$hasInterjobTransferIN	= true;
                        }
	if($hasInterjobTransferIN){
		$SQL_jobin_cancel="SELECT COALESCE(SUM(dblQty)) AS jobtransincancelqty FROM stocktransactions ".
				"WHERE intStyleId ='".$row_search["intStyleId"]."' AND ".
				"strType='CIJTIN' and ".
				"intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"strColor ='".$row_search["strColor"]."' and ".
				"strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY intStyleId,intMatDetailId, ".
				"strColor,strType, ".
				"strSize";
						
						$result_jobin_cancel = $db->RunQuery($SQL_jobin_cancel);
						while($row_jobin_cancel=mysql_fetch_array($result_jobin_cancel))
						{
							$InterJobTransInCancelQty = ($row_jobin_cancel["jobtransincancelqty"]*-1);
                        }
						$totInterJobTransIn = $InterJobTransIn-$InterJobTransInCancelQty;
						
						echo ($totInterJobTransIn==0 ? "":round($totInterJobTransIn));
	}
}
?></td>
              <td class="normalfntR"><?php 
$interjoboutqty=0;
$jobtransoutqty=0;
$jobtransoutcancelqty=0;
if($hasStock){
$hasInterjobTransferOut = false;
$SQL_jobtransout="SELECT COALESCE(SUM(ST.dblQty)) AS jobtransoutqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='IJTOUT' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
				
						$result_jobtransout = $db->RunQuery($SQL_jobtransout);
						while($row_jobtransout=mysql_fetch_array($result_jobtransout))
						{
							$jobtransoutqty = ($row_jobtransout["jobtransoutqty"]*-1);
							$hasInterjobTransferOut	= true;
                        }
	if($hasInterjobTransferOut){
		$SQL_jobtransout_cancel="SELECT COALESCE(SUM(dblQty)) AS jobtransoutcancelqty FROM stocktransactions ".
				"WHERE intStyleId ='".$row_search["intStyleId"]."' AND ".
				"strType='CIJTOUT' and ".
				"intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"strColor ='".$row_search["strColor"]."' and ".
				"strSize = '".$row_search["strSize"]."'  ".
					"GROUP BY intStyleId,intMatDetailId, ".
				"strColor,strType, ".
				"strSize";
						
						$result_jobtransout_cancel = $db->RunQuery($SQL_jobtransout_cancel);
						while($row_jobtransout_cancel=mysql_fetch_array($result_jobtransout_cancel))
						{
							$jobtransoutcancelqty = $row_jobtransout_cancel["jobtransoutcancelqty"];
                        }
						$interjoboutqty = $jobtransoutqty-$jobtransoutcancelqty;
						
						echo ($interjoboutqty==0 ? "":round($interjoboutqty));
	}
}
						
?></td>
              <td class="normalfntR"><?php
$totRtsQty=0;
$rstQty=0;
$rtsCancelQty =0;
if($hasStock){
$hasReturnToStores = false;
$SQL_rts="SELECT COALESCE(SUM(ST.dblQty)) AS rtsqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='SRTS' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
				
			  			$result_rts = $db->RunQuery($SQL_rts);
						while($row_rts=mysql_fetch_array($result_rts))
						{
							$rstQty = ($row_rts["rtsqty"]);
							$hasReturnToStores	= true;
                        }
if($hasReturnToStores){
$SQL_rts_cancel="SELECT COALESCE(SUM(dblQty)) AS rtscancelqty FROM stocktransactions ".
				"WHERE intStyleId ='".$row_search["intStyleId"]."' AND ".
				"strType='CSRTS' and ".
				"intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"strColor ='".$row_search["strColor"]."' and ".
				"strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY intStyleId,intMatDetailId, ".
				"strColor,strType, ".
				"strSize";
						
						$result_rts_cancel = $db->RunQuery($SQL_rts_cancel);
						while($row_rts_cancel=mysql_fetch_array($result_rts_cancel))
						{
							$rtsCancelQty = ($row_rts_cancel["rtscancelqty"]*-1);
                        }
						$totRtsQty = $rstQty-$rtsCancelQty;
						
						echo ($totRtsQty==0 ? "":round($totRtsQty));
	}
}
?></td>
              <td class="normalfntR"><?php
$totreturnToSuppQty=0;
$returnToSuppQty=0;
$returnToSuppCancelQty=0;
if($hasStock){
$hasReturnToSupplier = false;
$SQL_rtsup="SELECT COALESCE(SUM(ST.dblQty)) AS returntosuppqty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='SRTSUP' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
						$result_rtsup = $db->RunQuery($SQL_rtsup);
						while($row_rtsup=mysql_fetch_array($result_rtsup))
						{
							 $returnToSuppQty=($row_rtsup["returntosuppqty"] * -1);
							 $hasReturnToSupplier = true;
                        }
	if($hasReturnToSupplier){
		$sql_rtsup_cancel="SELECT COALESCE(SUM(dblQty)) AS returntosuppcancelqty FROM stocktransactions ".
				"WHERE intStyleId ='".$row_search["intStyleId"]."' AND ".
				"strType='CSRTSUP' and ".
				"intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"strColor ='".$row_search["strColor"]."' and ".
				"strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY intStyleId,intMatDetailId, ".
				"strColor,strType, ".
				"strSize";
						
						$result_rtsup_cancel = $db->RunQuery($sql_rtsup_cancel);
						while($row_rtsup_cancel=mysql_fetch_array($result_rtsup_cancel))
						{
							$returnToSuppCancelQty = $row_rtsup_cancel["returntosuppcancelqty"];
                        }
						$totreturnToSuppQty = $returnToSuppQty-$returnToSuppCancelQty;
						
						echo ($totreturnToSuppQty==0 ? "":round($totreturnToSuppQty));
	}
}
?></td>
              <td class="normalfntR"><?php
if($hasStock)
{
$SQL_allow="SELECT COALESCE(SUM(ST.dblQty)) AS allowOutQty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='BINTROUT' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
				
	$result_allow = $db->RunQuery($SQL_allow);
	while($row_allow=mysql_fetch_array($result_allow))
	{
		echo round(($row_allow["allowOutQty"] * -1),2);
	}
}
?></td>
              <td class="normalfntR"><?php
if($hasStock)
{
$SQL_allow="SELECT COALESCE(SUM(ST.dblQty)) AS allowInQty FROM stocktransactions ST ".
				"WHERE ST.intStyleId ='".$row_search["intStyleId"]."' AND ".
				"ST.strType='BINTRIN' and ".
				"ST.intMatDetailId ='".$row_search["intMatDetailId"]."' and ".
				"ST.strColor ='".$row_search["strColor"]."' and ".
				"ST.strSize = '".$row_search["strSize"]."'  ".
				"GROUP BY ST.intStyleId,ST.intMatDetailId, ".
				"ST.strColor,ST.strType, ".
				"ST.strSize";
				
	$result_allow = $db->RunQuery($SQL_allow);
	while($row_allow=mysql_fetch_array($result_allow))
	{
		echo round($row_allow["allowInQty"],2);
	}
}
?></td>
              </tr>
<?php
}
?>
          </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
</table>
</body>
<?php 
function GetStyleDetails($orderId)
{
global $db;
	$sql="select O.strOrderNo,O.strStyle,S.intSRNO,
	(SELECT NAME FROM useraccounts UA WHERE UA.intUserID = O.intCoordinator) AS Merchandiser
	from orders O
	inner join specification S on S.intStyleId=O.intStyleId
	where O.intStyleId='$orderId'";
	return $db->RunQuery($sql);
}
?>
</html>
