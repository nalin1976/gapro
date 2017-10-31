<?php 
session_start();

include "../Connector.php";
$backwardseperator = "../";
				
	$orderId			= $_GET["OrderId"];
	$buyerPoNo			= $_GET["buyerPoNo"];
	$company			= $_GET["companyID"];
	$matMainCategory	= $_GET["mainMatCategoryId"];
	//$styleName			= $_GET["styleName"];
	
	$result_header = GetStyleDetails($orderId);
	while($row_header=mysql_fetch_array($result_header))
	{
		$orderNo		= $row_header["strOrderNo"];
		$styleNo		= $row_header["strStyle"];
		$scno			= $row_header["intSRNO"];
		$merchant		= $row_header["Merchandiser"];
	}
	
	$sql = "SELECT intCompanyId FROM mainstores WHERE strMainID = '$company'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$pocompany = $row["intCompanyId"];
	}
	$report_companyId   = $pocompany;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Check Status :: Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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

<table width="1200" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
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
    <td><p class="head2BLCK">CHECK STATUS REPORT </p>
      <p align="center" class="headRed"><?PHP		
			if($Status==10)
				echo "THIS IS NOT A VALID REPORT";			
	?>
	  </p>
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
              <td width="25%" class="normalfnt"><?php echo $buyerPoNo ;?></td>
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
            <tr>
              <td class="normalfnBLD1">Main Store</td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php 
$sqlCompany="select strName FROM mainstores where strMainID=$company";
$result_company=$db->RunQuery($sqlCompany);
while($row_company=mysql_fetch_array($result_company)){
	echo $row_company["strName"];
}
?></td>
              <td>&nbsp;</td>
              <td class="normalfnBLD1">Merchandiser</td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php echo $merchant;?></td>
              <td class="normalfnBLD1">&nbsp;</td>
            </tr>
          </table>
            </td>
        </tr>
    </table>      
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td width="100%"><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
<thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="1%" height="30"  >&nbsp;</th>
              <th width="6%"  >Color </th>
              <th width="6%"  >Size</th>
              <th width="5%"  >Unit</th>
              <th width="5%"  >Req Qty </th>
              <th width="6%"  >Bal To Order </th>
              <th width="4%"  >Ordered Qty </th>
              <th width="6%" >Stock Bal </th>
              <th width="4%"  >GRN Qty </th>
              <th width="6%"  >Issue Qty </th>
              <th width="6%"  >GatePass Qty  </th>
              <th width="6%" >GP Trans Qty </th>
              <th width="6%"  >IJTIN Qty </th>
              <th width="6%" >IJTOUT Qty </th>
              <th width="6%"  >Ret To Store </th>
              <th width="6%"  >Ret To Supp </th>
              <th width="6%"  >Bin Allo Out</th>
              <th width="6%"  >Bin Allo In</th>
              <th width="4%" >Bulk Allo In</th>   
              <th width="4%" >Leftover Allo In</th>     
              <th width="4%" >Leftover Out</th> 
              </tr>
</thead>
<?php 
$matDetailID = "";
$mainNo	= 0;
	$SQL_details = "SELECT s.intStyleId AS intStyleId, s.intSRNO,mc.strDescription, mil.strItemDescription,mil.intItemSerial AS intMatDetailId,
mr.strColor, mr.strSize,mr.strBuyerPONo,spd.strUnit,mr.dblQty AS Qty , mr.dblBalQty AS BalQty,mr.dblRecutQty,
(select sum(pd.dblQty) as purchQty from purchaseorderdetails pd inner join purchaseorderheader ph on ph.intPONo = pd.intPONo and 
ph.intYear = pd.intYear where pd.intStyleId = s.intStyleId and pd.intMatDetailID = mr.strMatDetailID and pd.strColor = mr.strColor and pd.strSize= mr.strSize and pd.strBuyerPONO = mr.strBuyerPONo and ph.intStatus=10 
and ph.intDelToCompID='$pocompany') as purchQty,
(select sum(st.dblQty) as stockQty from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' ) as stockQty,
(select sum(st.dblQty) as grnQty from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' and st.strType='GRN') as grnQty,
(select abs(sum(st.dblQty)) as binAlloout from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' and st.strType='BINTROUT') as binAlloout,
(select abs(sum(st.dblQty)) as binAllIn from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' and st.strType='BINTRIN') as binAllIn
FROM specification s inner join specificationdetails spd on spd.intStyleId = s.intStyleId
INNER JOIN matitemlist mil on mil.intItemSerial = spd.strMatDetailID
INNER JOIN  materialratio mr on mr.intStyleId = s.intStyleId and mr.strMatDetailID=spd.strMatDetailID
INNER JOIN matmaincategory mc on mc.intID = mil.intMainCatID
WHERE s.intStyleId ='$orderId'  ";
					if($buyerPoNo != ""){
						$SQL_details .= " AND mr.strBuyerPONo = '". $buyerPoNo ."' ";
					}
					if($matMainCategory!=""){
						$SQL_details .= " AND mc.intID = '". $matMainCategory ."' ";
					}
	$SQL_details .= "ORDER BY mc.intID ASC, mr.strMatDetailID ASC ";


	$result_search = $db->RunQuery($SQL_details);
	while($row_search = mysql_fetch_array($result_search )){
	$color = $row_search["strColor"];
		$size = $row_search["strSize"];	
		$intMatDetailId = $row_search["intMatDetailId"];
		$grnQty = $row_search["grnQty"];
		
		//start 2011-09-19 Bulk Allocation Qty
		$bulkAlloQty = getBulkAlloQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,1);
		$cancelBAlloQty =getBulkAlloQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,10); 
		$BAlloQty = $bulkAlloQty-$cancelBAlloQty;
		//end 2011-09-19 Bulk Allocation Qty
		
		//start 2011-09-20 Leftover Allocation In Qty
		$leftAlloInQty = getLeftoverAllocationQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,1);
		$cancelLAlloQty = getLeftoverAllocationQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,10); 
		$lAlloQty = $leftAlloInQty-$cancelLAlloQty;
		//end 2011-09-20 Leftover Allocation In Qty
		
		$leftoverStockQty = getLeftoverStockQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size);	
			
		if($matDetailID<>$row_search["intMatDetailId"])
		{
			$matDetailID = $row_search["intMatDetailId"];
			
?>           
			<tr bgcolor="#E9E9E9" class="normalfntMid">
              <td height="20" ><?php echo ++$mainNo;?></td>
              <td colspan="2" ><?php echo $row_search["strDescription"];?></td>
              <td colspan="18" class="normalfnt" ><?php echo $row_search["strItemDescription"]?></td>
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
              <td class="normalfntRite"><?php $totQty = $row_search["Qty"] + $row_search["dblRecutQty"];
			  echo number_format($totQty,2);?></td>
              <td class="normalfntRite"><?php echo number_format($row_search["BalQty"],2)?></td>
              <td class="normalfntRite"><?php 
			echo ($row_search["purchQty"]==''?'':round($row_search["purchQty"],2));
?></td>
              <td class="normalfntRite"><?php 
echo ($row_search["stockQty"]==''?'':round($row_search["stockQty"],2));
?></td>
              <td class="normalfntRite"><?php
echo ($grnQty==0?'':round($grnQty,2));
?></td>
              <td class="normalfntRite"><?php
$sql_i = "select sum(id.dblQty) as issueQty from issuesdetails id inner join issues i on
i.intIssueNo = id.intIssueNo and i.intIssueYear = id.intIssueYear where intStyleId='$orderId' and id.strColor ='$color'  
and id.strSize='$size' and i.intCompanyID = '$pocompany' and id.strBuyerPONO ='$buyerPoNo' and id.intMatDetailID='$intMatDetailId' ";

		$result_i = $db->RunQuery($sql_i);
		$rowI = mysql_fetch_array($result_i);
		$issueQty = $rowI["issueQty"];
		echo ($issueQty==0?'':round($issueQty,2));
?></td>
              <td class="normalfntRite"><?php 
$sql_gp = "select sum(gpd.dblQty) as gpQty from gatepass gp inner join gatepassdetails gpd on 
gp.intGatePassNo = gpd.intGatePassNo and gp.intGPYear = gpd.intGPYear 
where gpd.intStyleId ='$orderId' and gpd.strBuyerPONO='$buyerPoNo' and gpd.strColor='$color' and gpd.intMatDetailId='$intMatDetailId'  and gpd.strSize='$size' and gp.intCompany='$pocompany' ";
	$result_gp = $db->RunQuery($sql_gp);
	$rowGp = mysql_fetch_array($result_gp);
	
	echo ($rowGp["gpQty"]==0?'':round($rowGp["gpQty"],2));
?></td>
              <td class="normalfntRite"><?php 
$sql_gpT = "select sum(TD.dblQty) AS gpTransInQty from gategasstransferinheader TH 
	INNER JOIN gategasstransferindetails TD ON
	TH.intTransferInNo = TD.intTransferInNo AND TH.intTINYear = TD.intTINYear
	WHERE TH.intCompanyId='$pocompany' AND TD.intStyleId='$orderId' AND TD.strBuyerPONO='$buyerPoNo' AND TD.intMatDetailId='$intMatDetailId' AND TD.strColor ='$color' 	AND TD.strSize='$size'";
	
	$result_gpT = $db->RunQuery($sql_gpT);
	$rowGpT = mysql_fetch_array($result_gpT);
	echo $rowGpT["gpTransInQty"];
	
	?></td>
              <td class="normalfntRite"><?php
$intjobInQty = getIntejobAlloInQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,3);	
	$cancelIjobQty = getIntejobAlloInQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,10);
	if($intjobInQty>0)
		echo ($intjobInQty-$cancelIjobQty);	
?></td>
              <td class="normalfntRite"><?php 
$intjobOutQty = getIntejobAlloOutQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,3);
	$cancelIjobOutQty = getIntejobAlloOutQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,10);
	if($intjobOutQty>0)
		echo ($intjobOutQty - $cancelIjobOutQty);?></td>
              <td class="normalfntRite"><?php
$retStoreQty = getReturnToStoreQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,1);
	$cncelRetStoreQty = getReturnToStoreQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,10);
	if($retStoreQty>0)
		echo ($retStoreQty - $cncelRetStoreQty);
?></td>
              <td class="normalfntRite"><?php
$retSupQty = getRetSupQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,1);
	$cancelRetSupQty = getRetSupQty($orderId,$buyerPoNo,$company,$intMatDetailId,$color,$size,10);
	if($retSupQty>0)
		echo ($retSupQty - $cancelRetSupQty);
?></td>
              <td class="normalfntRite"><?php
echo $row_search["binAlloout"];
?></td>
              <td class="normalfntRite"><?php
echo $row_search["binAllIn"];
?></td>
<td  class="normalfntRite" ><?php echo ($BAlloQty==0?'':$BAlloQty); ?></td>   
                <td  class="normalfntRite" ><?php echo ($lAlloQty==0?'':$lAlloQty); ?></td>     
                <td  class="normalfntRite"><?php echo ($leftoverStockQty==0?'':$leftoverStockQty); ?></td> 
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

function getBulkAlloQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = " select sum(cbd.dblQty) as bulkAlloQty from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intToStyleId='$styleno' and cbh.intMainStoresID='$company' and cbd.intMatDetailId='$matDetailId' and cbd.strColor='$color' and cbd.strSize = '$size' and cbh.intStatus='$status' and strToBuyerPoNo ='$buyerpono'";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["bulkAlloQty"];
}

function getIntejobAlloInQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(id.dblQty) as ijobQty from itemtransfer i inner join itemtransferdetails id on
i.intTransferId = id.intTransferId and i.intTransferYear = id.intTransferYear
where i.intStyleIdTo='$styleno' and i.strToBuyerPoNo='$buyerpono'  and i.intMainStoreID ='$company'
and i.intMatDetailId='$matDetailId' and id.strColor='$color' and id.strSize='$size' and i.intStatus ='$status' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["ijobQty"];
}

function getIntejobAlloOutQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(id.dblQty) as ijobQty from itemtransfer i inner join itemtransferdetails id on
i.intTransferId = id.intTransferId and i.intTransferYear = id.intTransferYear
where i.intStyleIdFrom='$styleno' and id.strBuyerPoNo='$buyerpono'  and i.intMainStoreID ='$company'
and i.intMatDetailId='$matDetailId' and id.strColor='$color' and id.strSize='$size' and i.intStatus ='$status' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["ijobQty"];
}

function getReturnToStoreQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(rsd.dblReturnQty) as returnQty from returntostoresdetails rsd inner join returntostoresheader rsh on
rsh.intReturnNo = rsd.intReturnNo and rsh.intReturnYear = rsd.intReturnYear
where rsh.intStatus='$status' and rsh.intCompanyID='$pocompany' and rsd.intStyleId='$styleno' and rsd.strBuyerPoNo='$buyerpono' and rsd.intMatdetailID='$matDetailId' and rsd.strColor='$color' and rsd.strSize='$size' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["returnQty"];
}
function getRetSupQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(rsd.dblQty) as retSupQty from returntosupplierdetails rsd inner join returntosupplierheader rs on
rs.intReturnToSupNo = rsd.intReturnToSupNo and rs.intReturnToSupYear= rsd.intReturnToSupYear
where rs.intStatus='$status' and rs.intCompanyID='$pocompany' and rsd.intStyleId='$styleno' and rsd.strBuyerPoNo='$buyerpono' and rsd.intMatdetailID ='$matDetailId' and rsd.strColor='$color' and rsd.strSize='$size' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["retSupQty"];
}
function getLeftoverAllocationQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(lcd.dblQty) as leftQty from commonstock_leftoverdetails lcd inner join 
	commonstock_leftoverheader lch on
lch.intTransferNo = lcd.intTransferNo and lch.intTransferYear= lcd.intTransferYear
where lch.intStatus='$status' and lch.intMainStoresId='$company' and lch.intToStyleId='$styleno' and lch.strToBuyerPoNo='$buyerpono' and lcd.intMatDetailId='$matDetailId' and lcd.strColor='$color' and lcd.strSize='$size' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["leftQty"];
}
function getLeftoverStockQty($styleno,$buyerpono,$company,$matDetailId,$color,$size)
{
	global $db;
	$sql = " select sum(dblQty) as leftStock from stocktransactions_leftover where strMainStoresID='$company'
and intStyleId='$styleno' and strBuyerPoNo='$buyerpono' and intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size' ";

	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["leftStock"];
}
?>
</html>
