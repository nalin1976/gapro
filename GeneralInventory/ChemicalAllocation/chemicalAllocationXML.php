<?php
include "../../Connector.php";
include("../class.glcode.php");
$objgl = new glcode();
header('Content-Type: text/xml');
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="URLLoadPopItems")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLURLLoadPopItems>";

	$itemDesc 	= $_GET["ItemDesc"];
	$itemCode 	= $_GET["ItemCode"];
	$MainCatId 	= $_GET["MainCatId"];
	$SubCatId 	= $_GET["SubCatId"];
	
	$sql = "select GMIL.strItemDescription,GMIL.strUnit,GMIL.intItemSerial	from genmatitemlist GMIL 
			where GMIL.intStatus=1 ";
	
	if($MainCatId!="")
		$sql .= "and GMIL.intMainCatID='$MainCatId' ";
	if($SubCatId!="")
		$sql .= "and GMIL.intSubCatID='$SubCatId' ";
	if($itemDesc!="")
		$sql .= "and GMIL.strItemDescription like '%$itemDesc%' ";
	if($itemCode!="")
		$sql .= "and GMIL.intItemSerial like '%$itemCode%' ";
		
		$sql .= "order by GMIL.strItemDescription ";

		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$Unit         = $row["strUnit"] ;
			$comboUnit    = getUnit($Unit);
			$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
			$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
			$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
			$ResponseXML .= "<comboUnit><![CDATA[" . $comboUnit . "]]></comboUnit>\n";
		}
	$ResponseXML .= "</XMLURLLoadPopItems>\n";
	echo $ResponseXML;
}
if($requestType=="loadGLDescription")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLURLloadGLDescription>";

	$GLAllowId    = $_GET["GLId"];
	$GLDes        = $objgl-> getGLDescription($GLAllowId);
	$ResponseXML .= "<GLDes><![CDATA[" . $GLDes  . "]]></GLDes>\n";
	$ResponseXML .= "</XMLURLloadGLDescription>";
	echo $ResponseXML;
}
if($requestType=="URLLoadSubCat")
{
	$intMainCatId = $_GET["mainCatId"];	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .= "<genmatsubcategory>";

		$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";
				
		$result = $db->RunQuery($SQL);
		$str = '';
		$str .= "<option value=\"". "" ."\">" . "" ."</option>";
		
			while($row = mysql_fetch_array($result))
			{
				 $str .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
			}
			$ResponseXML .= "<SubCat><![CDATA[" . $str  . "]]></SubCat>\n";
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}
if($requestType=="URLGetNewSerialNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
    $No=0;
	$ResponseXML = "<XMLGetNewSerialNo>\n";
	
		$Sql="select dblGenChemAllocationNo from syscontrol where intCompanyID='$companyId'";		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblGenChemAllocationNo"];
					$NextNo=$No+1;
					$ReturnYear = date('Y');
					$sqlUpdate="UPDATE syscontrol SET dblGenChemAllocationNo='$NextNo' WHERE intCompanyID='$companyId';";
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
					$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</XMLGetNewSerialNo>";
	echo $ResponseXML;
}
if($requestType=="URLSaveHeader")
{
	$serialNo	= $_GET["SerialNo"];
	$serialYear	= $_GET["SerialYear"];
	//$costCenter	= $_GET["costCenter"];

	$sql="insert into gen_chemicalallocation_header 
			(intChemAllocationNo, intChemAllocationYear, intCompanyId, intCostCenterId, 
			intUserId, dtmSaveDate)
			values
			('$serialNo', '$serialYear', '$companyId', '0', '$userId', now())";
	$result=$db->RunQuery($sql);
	if($result)
		echo "saved";
	else
		echo "header save error";
}
if($requestType=="URLSaveDetail")
{
	$serialNo		= $_GET["SerialNo"];
	$serialYear		= $_GET["SerialYear"];
	$tarMatId		= $_GET["tarMatId"];
	$tarUnit		= $_GET["tarUnit"];
	$tarUnitPrice	= $_GET["tarUnitPrice"];
	$tarQty			= $_GET["tarQty"];
	//$tarGLId		= $_GET["tarGLId"];
	//$costCenter		= $_GET["costCenter"];
	
	$sql_detail = "insert into gen_chemicalallocation_detail 
					(
					intChemAllocationNo, 
					intChemAllocationYear, 
					intTargetMatDetailId, 
					strUnit, 
					dblUnitPrice, 
					dblStockQty, 
					intGLAllowId
					)
					values
					(
					'$serialNo', 
					'$serialYear', 
					'$tarMatId', 
					'$tarUnit', 
					'$tarUnitPrice', 
					'$tarQty', 
					'0'
					);";
	$result_detail=$db->RunQuery($sql_detail);
	if($result_detail)
	{
		$sql_insertStock = "insert into genstocktransactions 
							( 
							intYear, strMainStoresID, intDocumentNo, intDocumentYear, intMatDetailId, 
							strType, strUnit, dblQty, dtmDate, intUser, intGRNNo, intGRNYear, intCostCenterId, 
							dblUnitPrice, intGLAllowId
							)
							values
							(
							'$serialYear', '$companyId', '$serialNo', '$serialYear', '$tarMatId', 
							'ChemicalAllow', '$tarUnit', '$tarQty',now(), '$userId',1, '$serialYear', 
							'$costCenter', '$tarUnitPrice', '$tarGLId'
							);";
		$result_stock=$db->RunQuery($sql_insertStock);
		if($result_stock)
			echo "savedDetail";
		else
			echo "error";
	}
	else
	{
		echo "error";
	}
}
if($requestType=="URLSaveSubDetail")
{
	$SerialNo		= $_GET["SerialNo"];
	$SerialYear		= $_GET["SerialYear"];
	$tarMatId		= $_GET["tarMatId"];
	$srcMatId		= $_GET["srcMatId"];
	$SrcUnit		= $_GET["SrcUnit"];
	$SrcQty			= $_GET["SrcQty"];
	$SrcgrnNoArry	= explode('/',$_GET["SrcgrnNo"]);
	$SrcGLId		= $_GET["SrcGLId"];
	$costCenter		= $_GET["costCenter"];
	
	$sql_subdetail = "insert into gen_chemicalallocation_subdetail 
						(
						intChemAllocationNo, 
						intChemAllocationYear, 
						intTargetMatDetailId, 
						intSourceMatDetailId, 
						strUnit, 
						dblQty, 
						intGRNNo, 
						intGRNYear, 
						intGLAllowId
						)
						values
						(
						'$SerialNo', 
						'$SerialYear', 
						'$tarMatId', 
						'$srcMatId', 
						'$SrcUnit', 
						'$SrcQty', 
						'$SrcgrnNoArry[0]', 
						'$SrcgrnNoArry[1]', 
						'$SrcGLId'
						);";
	$result_subdetail=$db->RunQuery($sql_subdetail);
	if($result_subdetail)
	{
		$stockQty = $SrcQty*(-1);
		$sql_insertStock = "insert into genstocktransactions 
							( 
							intYear, strMainStoresID, intDocumentNo, intDocumentYear, intMatDetailId, 
							strType, strUnit, dblQty, dtmDate, intUser, intGRNNo, intGRNYear, intCostCenterId, 
							intGLAllowId
							)
							values
							(
							'$SerialYear', '$companyId', '$SerialNo', '$SerialYear', '$srcMatId', 
							'ChemicalAllow', '$SrcUnit', '$stockQty',now(), '$userId','$SrcgrnNoArry[0]', 
							'$SrcgrnNoArry[1]', '$costCenter', '$SrcGLId' );";
		$result_stock=$db->RunQuery($sql_insertStock);
		if($result_stock)
			echo "savedSubDetail";
		else
			echo "error";
	}
	else
	{
		echo "error";
	}
}
function getUnit($Unit)
{
	global $db;
	$text = "<select name=\"cboUnit\" id=\"cboUnit\" style=\"width:90px;\">";
	$text.= "<option value=\"\"></option>";
	$sql  = " select strUnit from units where intStatus=1 order by strUnit ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($Unit==$row['strUnit'])
			$text.= "<option value=".$row['strUnit']." selected=\"selected\">".$row['strUnit']."</option>";
		else
			$text.= "<option value=".$row['strUnit']." >".$row['strUnit']."</option>";
	}
	$text.="</select>";
	return $text;
}

?>