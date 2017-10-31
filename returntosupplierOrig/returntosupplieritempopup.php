<?php
	include "../Connector.php";
	session_start();
	$companyId=$_SESSION["FactoryID"];
	
	$StyleID		= $_GET["StyleID"];
	$supplierID		= $_GET["supplierID"];
	$buyerPoNo		= $_GET["buyerPoNo"];	
	$mainStoreId	= $_GET["mainStore"];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gatepass Items</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<form name="frmItemPoPUp" id="frmItemPoPUp">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td></td>
  </tr>
  <tr>
 
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="17" class="mainHeading"><div align="center">Stock Items</div></td>
       </tr>
     
        <td><div id="divItemPopUp" style="overflow:scroll; height:392px; width:950px;">
          <table id="tblItemPopUp" width="930" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="2%" height="25"> <input type="checkbox" name="checkbox1" id="checkbox1" onclick="SelectAll(this)"/></td>
              <td width="10%" >Grn No</td>
              <td width="11%" >Main Materials</td>
              <td width="29%"> Materials Description</td>
              <td width="11%" >Color</td>
              <td width="10%" >Size</td>
              <td width="9%" >Units</td>
              <td width="9%" >Grn Qty</td>
              <td width="9%" >Stock Bal</td>			  
<?php
$SQL="SELECT ".
	"CONCAT(GH.intGRNYear,'/',GH.intGrnNo)AS GrnNo, ".
	"CONCAT(POH.intYear,'/',POH.intPONo) AS PoNo, ".
	"POH.strSupplierID, ".
	"GD.intStyleId, ".
	"GD.strBuyerPONO, ".
	"GD.intMatDetailID, ".
	"GD.strColor, ".
	"GD.strSize, ".
	"GD.dblBalance, ".
	"MIL.strItemDescription, ".
	"MMC.strDescription, ".
	"MIL.strUnit, ".
	"MIL.intSubCatID,GH.intGrnNo,GH.intGRNYear ".
	"FROM ".
	"grnheader AS GH ".
	"Inner Join purchaseorderheader AS POH ON POH.intPONo = GH.intPoNo AND POH.intYear = GH.intYear ".
	"Inner Join grndetails AS GD ON GH.intGrnNo = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear ".
	"Inner Join matitemlist AS MIL ON MIL.intItemSerial = GD.intMatDetailID ".
	"Inner Join matmaincategory AS MMC ON MIL.intMainCatID = MMC.intID ".
	"WHERE ".
	"POH.strSupplierID ='$supplierID' AND ".
	"GD.intStyleId =  '$StyleID' AND ".
	"GD.strBuyerPONO =  '$buyerPoNo' AND ".
	"GH.intStatus =  '1' AND ".
	"GH.intCompanyID =  '$companyId' ".
	"ORDER BY GH.intGrnNo,MIL.intMainCatID,MIL.strItemDescription ASC;";
	$result =$db->RunQuery($SQL);	
	while ($row=mysql_fetch_array($result))
	{
		$QTY	= $row["dblBalance"];
		if($QTY>0)
		{
			$StyleID		= $row["intStyleId"];
			$BuyerPONO		= $row["strBuyerPONO"];
			$MatDetailID	= $row["intMatDetailID"];
			$Color			= $row["strColor"];
			$Size			= $row["strSize"];
			$grnNo 			= $row["intGrnNo"];
			$grnYear 		= $row["intGRNYear"];
			
		$StockBal = GetStockBal($StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$mainStoreId,'S');
		if($StockBal>0)
		{
?>          
	</tr>
		<tr class="bcgcolor-tblrowWhite" onmouseover="this.style.background ='#EEEEEE';" onmouseout="this.style.background=''">
			<td height="15" class="normalfntRite" id="0"><div align="center"><input type="checkbox" name="checkbox" id="checkbox"/></div></td>
			<td class="normalfntSM" id="<?php echo $row["PoNo"]  ?>"><?php echo $row["GrnNo"]?></td>
			<td class="normalfntSM"><?php echo $row["strDescription"] ?></td>
			<td class="normalfntSM" id="<?php echo $row["intMatDetailID"]  ?>"><?php echo $row["strItemDescription"]  ?></td>
			<td class="normalfntMidSML" id="<?php echo $row["MrnNo"]  ?>"><?php echo  $Color ?></td>
			<td class="normalfntMidSML"><?php echo $Size  ?></td>
			<td class="normalfntMidSML" id="<?php echo $row["intSubCatID"];?>"><?php echo $row["strUnit"] ?></td>
			<td class="normalfntMidSML"><?php echo round($QTY,2) ?></td>
			<td class="normalfntRite"><?php echo round($StockBal,2) ;?></td>			  
		</tr>  
<?php
		}
		$temp_StockBal = GetTempStockBal($StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$mainStoreId,'S');
		if($temp_StockBal>0)
		{
?>
</tr>
	<tr class="bcgcolor-InvoiceCostTrim" onmouseover="this.style.background ='#EEEEEE';" onmouseout="this.style.background=''">
		<td class="normalfntRite" id="1"><div align="center"><input type="checkbox" name="checkbox" id="checkbox"/></div></td>
		<td class="normalfntSM" id="<?php echo $row["PoNo"]  ?>"><?php echo $row["GrnNo"]?></td>
		<td class="normalfntSM"><?php echo $row["strDescription"] ?></td>
		<td class="normalfntSM" id="<?php echo $row["intMatDetailID"]  ?>"><?php echo $row["strItemDescription"]  ?></td>
		<td class="normalfntMidSML" id="<?php echo $row["MrnNo"]  ?>"><?php echo  $Color ?></td>
		<td class="normalfntMidSML"><?php echo $Size  ?></td>
		<td class="normalfntMidSML" id="<?php echo $row["intSubCatID"];?>"><?php echo $row["strUnit"] ?></td>
		<td class="normalfntMidSML"><?php echo round($QTY,2) ?></td>
		<td class="normalfntRite"><?php echo round($temp_StockBal,2) ;?></td>			  
</tr> 
<?php
			}
			
		}		
?>

<?php		
	}
?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0">
      <tr>
        <td ><table width="100%" border="0" class="tableBorder">
          <tr>
            <td ><div align="center"> 
			<img src="../images/ok.png" alt="ok" width="86" height="24" onclick="AddToMainPage();"/>
            <img src="../images/close.png" alt="close" width="97" height="24" onclick="closeWindow();" />
			</div></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
<?php
function GetStockBal($StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$mainStoreId,$grnType)
{
	global $db;
	global $companyId;
	
	$sqlInStock="SELECT ".
				"Sum(ST.dblQty) AS StockBal ".
				"FROM ".
				"stocktransactions AS ST ".
				"Inner Join mainstores AS MS ON ST.strMainStoresID = MS.strMainID ".
				"WHERE ".
				"ST.intStyleId =  '$StyleID' and ".
				"ST.strBuyerPoNo =  '$BuyerPONO' and ".
				"ST.intMatDetailId =  '$MatDetailID' and ".
				"ST.strColor =  '$Color' and ".
				"ST.strSize =  '$Size' and ".
				//"MS.intCompanyId = '$companyId' and ".
				//"intAutomateCompany=0 and ".
				"MS.intStatus=1 and ".
				"ST.intGrnNo='$grnNo' and ".
				"ST.intGrnYear='$grnYear' and ".
				"MS.strMainID=$mainStoreId and ST.strGRNType='$grnType' ".
				"GROUP BY ".
				"ST.intStyleId, ".
				"ST.strBuyerPoNo, ".
				"ST.intMatDetailId, ".
				"ST.strColor, ".
				"ST.strSize, ST.strGRNType ";	
	//echo $sqlInStock;
	$resultStock=$db->RunQuery($sqlInStock);
	$rowcount = mysql_num_rows($resultStock);
		if ($rowcount > 0)
		{
			while($rowStock=mysql_fetch_array($resultStock))
			{
				return $rowStock["StockBal"];
			}
		}
		else 
		{
			return 0;
		}
}
function GetTempStockBal($StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$mainStoreId,$grnType)
{
	global $db;
	global $companyId;
	
	$sqlInStock="SELECT ".
				"Sum(ST.dblQty) AS StockBal ".
				"FROM ".
				"stocktransactions_temp AS ST ".
				"Inner Join mainstores AS MS ON ST.strMainStoresID = MS.strMainID ".
				"WHERE ".
				"ST.intStyleId =  '$StyleID' and ".
				"ST.strBuyerPoNo =  '$BuyerPONO' and ".
				"ST.intMatDetailId =  '$MatDetailID' and ".
				"ST.strColor =  '$Color' and ".
				"ST.strSize =  '$Size' and ".
				"MS.intStatus=1 and ".
				"ST.intGrnNo='$grnNo' and ".
				"ST.intGrnYear='$grnYear' and ".
				"MS.strMainID=$mainStoreId and ST.strGRNType='$grnType' ".
				"GROUP BY ".
				"ST.intStyleId, ".
				"ST.strBuyerPoNo, ".
				"ST.intMatDetailId, ".
				"ST.strColor, ".
				"ST.strSize,ST.strGRNType";	
	//echo $sqlInStock;
	$resultStock=$db->RunQuery($sqlInStock);
	$rowcount = mysql_num_rows($resultStock);
		if ($rowcount > 0)
		{
			while($rowStock=mysql_fetch_array($resultStock))
			{
				return $rowStock["StockBal"];
			}
		}
		else 
		{
			return 0;
		}
}
?>
</form>
</body>
</html>
