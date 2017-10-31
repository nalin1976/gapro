<?php
include('../Connector.php');
$strshipping		= trim($_GET["q"]);
$cboSearch			= trim($_GET["strOrderNo"]);
$intStyleID			= trim($_GET["cboStyle"]);
$dblPcsPerPack		= trim($_GET["txtPcsPerpack"]); 
$strDimention		= trim($_GET["textDimension"]);
$strWashCode		= trim($_GET["textWashCode"]);
$intQty				= trim($_GET["textQty"]);	
$strVessal			= trim($_GET["textVessal"]);
$dtVessalDate		= trim($_GET["textVessalData"]);
$intShipMode		= trim($_GET["cboMode"]);	
$strGender			= trim($_GET["cboGender"]);
$strFabricRefNo		= trim($_GET["textFabricContent"]);
$intBuyerID			= trim($_GET["txtBuyers"]);
$strName			= trim($_GET["txtBuyer"]);	
$strPONo			= trim($_GET["txtBuyerPoNo"]);
$intShipTerm		= trim($_GET["cboShipmentTerm"]);
$intPayTerm			= trim($_GET["cboPaymentTerm"]);
$strGrmtType		= trim($_GET["txtGarmentType"]);	
$strQuataCat		= trim($_GET["txtQuataCat"]);
$strDescription		= trim($_GET["textDescription"]);
$strCTNType			= trim($_GET["textCtnType"]); 
$strItemDescription	= trim($_GET["txtMaterial"]);	
$strSupplierID		= trim($_GET["cboMill"]);

if($strshipping=="Save")
{    
$intStyleID			= trim($_GET["cboSearch"]);   	
$dblPcsPerPack		= trim($_GET["txtPcsPerpack"]); 
$strDimention		= trim($_GET["textDimension"]);	
$strWashCode		= trim($_GET["textWashCode"]);	
$intQty				= trim($_GET["textQty"]);
$strVessal			= trim($_GET["textVessal"]);
$dtVessalDate		= trim($_GET["textVessalData"]);
$intShipMode		= trim($_GET["cboMode"]);	
$strGender			= trim($_GET["cboGender"]);
$strFabricRefNo		= trim($_GET["textFabricRefNo"]);
$intBuyerID			= trim($_GET["txtBuyers"]);
$strName			= trim($_GET["txtBuyer"]);	
$strPONo			= trim($_GET["txtBuyerPoNo"]);
$intShipTerm		= trim($_GET["cboShipmentTerm"]);
$intPayTerm			= trim($_GET["cboPaymentTerm"]);
$strGrmtType		= trim($_GET["txtGarmentType"]);			
$textFabricContent	= trim($_GET["textFabricContent"]);	
$strQuataCat		= trim($_GET["txtQuataCat"]);	
$strDescription		= trim($_GET["textDescription"]);
$strCTNType			= trim($_GET["textCtnType"]);
$strItemDescription	= trim($_GET["txtMaterial"]);
$strSupplierID		= trim($_GET["cboMill"]);
$material			= trim($_GET["material"]);
	
	$SQL="delete from orderdata_destination where intStyleId='$intStyleID'";
	$db->RunQuery($SQL);
	
	$SQL="select * from orderdata where intStyleID='$intStyleID'"; 
	$Result =$db->RunQuery($SQL);
	$Re= mysql_num_rows($Result);	
	if($Re >0)
	{
		$SQL_Update="UPDATE orderdata SET dblPcsPerPack='$dblPcsPerPack',intStyleID='$intStyleID',strDimention='$strDimention',strWashCode='$strWashCode',strVessal='$strVessal',intQty='$intQty',dtVessalDate='$dtVessalDate',intShipMode='$intShipMode',strGender='$strGender',strFabricRefNo='$strFabricRefNo',intBuyerID='$intBuyerID',strName='$strName',strPONo='$strPONo',intShipTerm='$intShipTerm',intPayTerm='$intPayTerm',strGrmtType='$strGrmtType',strQuataCat='$strQuataCat',strDescription='$strDescription',strSupplierID='$strSupplierID',strItemDescription='$strItemDescription',strCTNType='$strCTNType',strMaterial='$material' where intStyleID='$intStyleID'";  
		$db->RunQuery($SQL_Update);				
		echo"Updated successfully.";
	}
	else
	{		 
		$sql_insert="insert into orderdata (dblPcsPerPack,intStyleID,strDimention,strWashCode,intQty,strVessal,dtVessalDate,intShipMode,strGender,strFabricRefNo,intBuyerID,strName,strPONo,intShipTerm,intPayTerm,strGrmtType,strQuataCat,strDescription,strCTNType,strSupplierID,strItemDescription,strMaterial) values(			'$dblPcsPerPack','$intStyleID','$strDimention','$strWashCode','$intQty','$strVessal','$dtVessalDate','$intShipMode','$strGender','$strFabricRefNo','$intBuyerID','$strName','$strPONo','$intShipTerm','$intPayTerm','$strGrmtType','$strDescription','$strQuataCat','$strDescription','$strSupplierID','$strCTNType','$material')";  
		$db->RunQuery($sql_insert);
		echo "Saved successfully."; 
	}
}	
else if($strshipping=="Delete")
{	
	$OrderNo=$_GET["OrderNo"];  
	$sql="delete from orderdata where intStyleID='$OrderNo'";
	$db->RunQuery($sql);
	echo"Deleted successfully.";
}
else if($strshipping=="LoadDetails")
{
	$SQL="SELECT  intStyleId,strOrderNo FROM orders where intStatus not in(13,14) order by strOrderNo";
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
}
else if($strshipping=="SaveDest")
{
$DestId = $_GET["DestId"];
$Qty = $_GET["Qty"];
$orderId = $_GET["orderId"];
	$sql="insert into orderdata_destination (intStyleId,intDestinationId,dblQty)values('$orderId','$DestId','$Qty');";
	$result = $db->RunQuery($sql);

}
?>