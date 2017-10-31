<?php
	include "../Connector.php";
	session_start();
	
	$fromStyleId		= $_GET["fromStyleId"];
	$toStyle			= $_GET["toStyle"];
	$StoresId			= $_GET["StoresId"];
	$buyerPONo 			= $_GET["BuyerPONo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Issue Items</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="materialsTransfer.js"></script>
</head>

<body onload="LoadItemDetails">
<form name="frmMaterialsPopUp" id="frmMaterialsPopUp">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr onmousedown="grab(document.getElementById('frmMaterialsPopUp'),event);" class="cursercross">
  	<td height="25" class="mainHeading">Materials Transfer Details</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
     
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="21" class="mainHeading2" ><div align="center"></div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divIssueItem" style="overflow:scroll; height:396px; width:950px;">
          <table id="tblMatPopUp" width="930" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="4%" height="25"><input type="checkbox" name="chkAll" id="chkAll" onclick="SelectAll(this);"/>                </td>
              <td width="14%" >Main Category </td>
              <td width="34%" >Material Descriotion </td>
              <td width="10%" >Buyer PoNo </td>
              <td width="11%" >Color</td>
              <td width="10%" >Size</td>
              <td width="7%" >Unit</td>
              <td width="7%" >Stock Balance</td>
			  <td width="3%" >GRN No</td>
              <td width="3%" >GRN Type </td>
            </tr>
<?php
$SQL="select a.*, ".
	 "interjobstock_view.Qty AS StockBal, ".
	 "MIL.strItemDescription, ".
	 "SPD.strUnit, ".
	 "MMC.strDescription, ".
	 "SPD.dblUnitPrice, ".
	 "concat(interjobstock_view.intGrnYear,'/',interjobstock_view.intGrnNo) as grnNo, ".
	 "interjobstock_view.strGRNType as GRNType ".
	 "from materialratio a ".
	 "inner join ".
	 "(select intStyleId as tostrStyleID, ".
	 "strBuyerPONO as tostrBuyerPONO, ".
	 "strMatDetailID as tostrMatDetailID, ".
	 "strColor as tostrColor, ".
	 "strSize as tostrSize ".
	 "from materialratio ".
	 "where intStyleId='$toStyle' and strBuyerPONO='$buyerPONo' )B ".
	 "on a.strMatDetailID=B.tostrMatDetailID and ".
	 "a.strColor=B.tostrColor and ".
	 "a.strSize=B.tostrSize ".
	 "inner join matitemlist as MIL on ".
	 "a.strMatDetailID=MIL.intItemSerial ".
	 "inner join matmaincategory as MMC on ".
	 "MIL.intMainCatID=MMC.intID ".
	 "Inner Join specificationdetails AS SPD ON a.intStyleId = SPD.intStyleId AND a.strMatDetailID = SPD.strMatDetailID ".
	 "inner join interjobstock_view on ".
	 "a.intStyleId=interjobstock_view.intStyleId AND ".
	 "a.strMatDetailID=interjobstock_view.intMatDetailId AND ".
	 "a.strBuyerPONO=interjobstock_view.strBuyerPoNo AND ".
     "a.strColor=interjobstock_view.strColor AND ".
	 "a.strSize=interjobstock_view.strSize ".
	 "where a.intStyleId='$fromStyleId' AND ".
	 "interjobstock_view.strMainStoresID='$StoresId' ".
	 "order by MMC.intID,MIL.strItemDescription,a.strColor,a.strSize,grnNo;";
	//echo $SQL;
		$result =$db->RunQuery($SQL);		
		while ($row=mysql_fetch_array($result))
		{
		$StockBal	= round($row["StockBal"],2);
		if($StockBal>0)
		{
		$styleID = $row["intStyleId"];
		$buyerPOName = $row["strBuyerPONO"];
		if($row["strBuyerPONO"] != '#Main Ratio#')
			$buyerPOName = getBuyerPOName($styleID,$row["strBuyerPONO"]);
			
		if($row["GRNType"]=='B')
			$grnType = 'Bulk';
		else
			$grnType = 'Style';
			
		//start 2011-11-29 get MRN bal Qty
		$mrnQty = getMRNQty($fromStyleId,$StoresId,$row["strMatDetailID"],$row["strBuyerPONO"],$row["strColor"],$row["strSize"],$row["grnNo"],$row["GRNType"]);
		$StockBal -= $mrnQty;
		
		//get Pending Gatepass qty
		$pendingGPQty = getPendingGPQty($fromStyleId,$StoresId,$row["strMatDetailID"],$row["strBuyerPONO"],$row["strColor"],$row["strSize"],$row["grnNo"],$row["GRNType"]);
		$StockBal -= $pendingGPQty;
		//end 	2011-11-29
			
?>
            <tr class="bcgcolor-tblrowWhite">
              <td><div align="center">
                <input type="checkbox" name="chksel" id="chksel" checked="checked" />
              </div></td>
              <td class="normalfnt"><?php echo $row["strDescription"];?></td>
              <td class="normalfnt" id="<?php echo $row["strMatDetailID"];?>"><?php echo $row["strItemDescription"];?></td>
              <td class="normalfntMid" id="<?php echo $row["strBuyerPONO"]; ?>"><?php echo $buyerPOName;?></td>
              <td class="normalfntMid" id="<?php echo $row["dblUnitPrice"];?>"><?php echo $row["strColor"];?></td>
              <td class="normalfntMid"><?php echo $row["strSize"];?></td>
              <td class="normalfntMid"><?php echo $row["strUnit"];?></td>
              <td class="normalfntRite"><?php echo $StockBal;?></td>			  
			  <td class="normalfntRite"><?php echo $row["grnNo"];?></td>			  
              <td class="normalfntRite" id="<?php echo $row["GRNType"];?>"><?php echo $grnType;?></td>
            </tr>
<?php
		}
		}  
?>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td width="40%" height="29">&nbsp;</td>
        <td width="11%"><img src="../images/ok.png" width="86" height="24" onclick="LoadDetailsToMainPage();" /></td>
        <td width="14%"><img src="../images/close.png" width="97" height="24" border="0" onclick="closeWindow2();" /></td>
        <td width="35%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
function getPendingGPQty($fromStyleId,$StoresId,$matDetailID,$buyerPONo,$color,$size,$grnNo,$grnType)
{
	global $db;
	$arrGRN = explode('/',$grnNo);
	
	$sql = " select mrd.dblBalQty from matrequisitiondetails mrd inner join matrequisition mrn on
mrn.intMatRequisitionNo = mrd.intMatRequisitionNo and mrn.intMRNYear = mrd.intYear
where intStyleId='$fromStyleId' and  strBuyerPONO ='$buyerPONo' and strMatDetailID='$matDetailID' and strColor='$color'  and strSize ='$size' and intGrnNo='".$arrGRN[1]."' and  intGrnYear='".$arrGRN[0]."' and  strGRNType ='$grnType' and strMainStoresID ='$StoresId' ";

	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblBalQty"];
}
function getMRNQty($fromStyleId,$StoresId,$matDetailID,$buyerPONo,$color,$size,$grnNo,$grnType)
{
	global $db;
	$arrGRN = explode('/',$grnNo);
	
	$sql = " select gpd.dblQty from gatepassdetails gpd inner join gatepass gp on 
gp.intGatePassNo = gpd.intGatePassNo and gp.intGPYear = gpd.intGPYear
inner join mainstores ms on ms.intCompanyId = gp.intCompany
where gpd.intStyleId ='$fromStyleId' and gpd.strBuyerPONO='$buyerPONo' and gpd.intMatDetailId ='$matDetailID'
and gpd.strColor='$color' and gpd.strSize='$size' and gpd.intGrnNo='".$arrGRN[1]."' and gpd.intGRNYear='".$arrGRN[0]."' and gpd.strGRNType='$grnType' and gp.intStatus=0 and ms.strMainID='$StoresId' ";

	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
?>
</form>
</body>
</html>
