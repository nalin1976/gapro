<?php
session_start();
include "../../Connector.php";

$xml = simplexml_load_file("../../config.xml");

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$userID=$_SESSION["UserID"];

if($RequestType=="LoadOrderNo")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId	= $_GET["StyleId"];
	$cat		=	$_GET['cat'];
	$ResponseXML = "<MXLLoadOrderNo>\n";
	
	$result=GetOrderNo($styleId,$cat);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$ResponseXML .= "<OrderId><![CDATA[" . $row["intStyleId"]  . "]]></OrderId>\n";
		$ResponseXML .= "<OrderQty><![CDATA[" . $row["intQty"]  . "]]></OrderQty>\n";
		$ResponseXML .= "<ExPercent><![CDATA[" . $row["reaExPercentage"]  . "]]></ExPercent>\n";
		$ResponseXML .= "<DivisionId><![CDATA[" . $row["intDivisionId"]  . "]]></DivisionId>\n";
		$ResponseXML .= "<DivisionName><![CDATA[" . $row["strDivision"]  . "]]></DivisionName>\n";
		$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
	}
	$ResponseXML .= "</MXLLoadOrderNo>\n";
	echo $ResponseXML;
}
elseif($RequestType=="LoadOrderDetails")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId	= $_GET["StyleId"];
	$cat		=	$_GET['cat'];
	$ResponseXML = "<MXLLoadOrderNo>\n";
	
	$result=GetOrderDetails($styleId,$cat);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$ResponseXML .= "<OrderId><![CDATA[" . $row["intStyleId"]  . "]]></OrderId>\n";
		$ResponseXML .= "<OrderQty><![CDATA[" . $row["intQty"]  . "]]></OrderQty>\n";
		$ResponseXML .= "<ExPercent><![CDATA[" . $row["reaExPercentage"]  . "]]></ExPercent>\n";
		$ResponseXML .= "<DivisionId><![CDATA[" . $row["intDivisionId"]  . "]]></DivisionId>\n";
		$ResponseXML .= "<DivisionName><![CDATA[" . $row["strDivision"]  . "]]></DivisionName>\n";
		$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
	}
	$ResponseXML .= "</MXLLoadOrderNo>\n";
	echo $ResponseXML;
}
elseif($RequestType=="LoadMainFabAndMill")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId	= $_GET["StyleId"];
	$cat		=	$_GET['cat'];
	$ResponseXML = "<MXLLoadMainFabAndMill>\n";
	
	$result=GetMainFabAndMill($styleId,$cat);
	while($row=@mysql_fetch_array($result))
	{		
		$ResponseXML .= "<MatDetailId><![CDATA[" . $row["intMatDetailID"]  . "]]></MatDetailId>\n";
		$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		$ResponseXML .= "<MillId><![CDATA[" . $row["intMillId"]  . "]]></MillId>\n";
		$ResponseXML .= "<MillName><![CDATA[" . $row["strTitle"]  . "]]></MillName>\n";
	}
	$ResponseXML .= "</MXLLoadMainFabAndMill>\n";
	echo $ResponseXML;
}
elseif($RequestType=="LoadWashPriceDetailsRequest")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId	= $_GET["StyleId"];
	$cat		= $_GET['cat'];
	$ResponseXML = "<MXLText>\n";
	
	$result=GetWashPriceDetailsRequest($styleId,$cat);
	while($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<GarmentId><![CDATA[" . $row["intGarmentId"]  . "]]></GarmentId>\n";
		$ResponseXML .= "<GarmentName><![CDATA[" . $row["strCatName"]  . "]]></GarmentName>\n";
		$ResponseXML .= "<WasTypeId><![CDATA[" . $row["intWasTypeId"]  . "]]></WasTypeId>\n";
		$ResponseXML .= "<WasType><![CDATA[" . $row["strWasType"]  . "]]></WasType>\n";
		$ResponseXML .= "<Company><![CDATA[" . getCompany($styleId)  . "]]></Company>\n";
	}
	$ResponseXML .= "</MXLText>\n";
	echo $ResponseXML;
}
elseif($RequestType=="LoadBranch")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$cat=$_GET['cat'];
	$customerId	= $_GET["CustomerId"];
	
	$ResponseXML = "<MXLText>\n";
	
	$result=GetBranch($customerId,$cat);
	while($row=@mysql_fetch_array($result))
	{		
		$ResponseXML .= "<option value=\"".$row["strCity"]."\">".$row["strCity"]."</option>\n";

	}
	$ResponseXML .= "</MXLText>\n";
	echo $ResponseXML;
}
else if($RequestType=="LoadStyleWiseOrderNo")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$styleNo	= $_GET["StyleNo"];
$cat=$_GET['cat'];
$ResponseXML = "<XMLLoadStyleWiseOrderNo>\n";
	//$sql="select O.intStyleId,O.strOrderNo from orders O where strStyle like'%$styleNo%'";
	if($cat==0){
	$sql="SELECT  DISTINCT O.intStyleId POId,O.strOrderNo PONo
			FROM   orders O INNER JOIN  was_washpriceheader WPH ON O.intStyleId = WPH.intStyleId 
			WHERE   strStyle like'%$styleNo%';";
	}
	else{
	$sql="select op.intId POId ,op.intPONo PONo from was_outsidepo  op inner join was_washpriceheader wph ON wph.intStyleId = op.intId  where  op.strStyleNo ='$styleNo';";	
	}	
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"".$row["POId"]."\">".$row["PONo"]."</option>\n";
	}
$ResponseXML .= "</XMLLoadStyleWiseOrderNo>\n";
echo $ResponseXML;
}

else if($RequestType=='getMaxMachineCapacity'){
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$mId=$_GET['mId'];
	$sql="select max(intCapacity) as cap from was_machine where intMachineType='$mId';";
	$res=$db->RunQuery($sql);
	$ResponseXML = "<MQty>\n";
	while($row=mysql_fetch_array($res))
	{		
		$ResponseXML .= "<McQty><![CDATA[" . $row["cap"]  . "]]></McQty>\n";
	}
	$ResponseXML .= "</MQty>\n";
	echo $ResponseXML;	
}
//----------------
elseif($RequestType=="SearchPreCosting")
{
	//die($RequestType);
$type  		= $_GET['Type'];
$text  		= $_GET['Text'];
$catId 		= $_GET['CatId'];
$inOrOut 	= $_GET['InOrOut'];

	$htm ="<tr bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" height=\"25\">".
			"<th class=\"grid_header\" height=\"25\">Serial</th>".
			/*"<th class=\"grid_header\" style=\"width:50px;\">Category</th>".*/
			"<th class=\"grid_header\" style=\"width:100px;\">PO No</th>".
			"<th class=\"grid_header\" style=\"width:100px;\">Style Name</th>".
			
			"<th class=\"grid_header\" style=\"width:100px;\">Color</th>".
			
			"<th class=\"grid_header\" style=\"width:50px;\">Qty</th>".
		    "</tr>";
	$sql="SELECT was_actualcostheader.intSerialNo,
													was_actualcostheader.intMachineType, 
													was_actualcostheader.intStyleId, 
													was_actualcostheader.dblQty, 
													was_actualcostheader.strColor,
													orders.strStyle, 
													orders.strOrderNo, 
													was_machinetype.strMachineType, 
													was_actualcostheader.intCat,
													orders.strDescription
													FROM was_actualcostheader 
													Inner Join orders ON orders.intStyleId = was_actualcostheader.intStyleId 
													Inner Join was_machinetype ON was_machinetype.intMachineId = was_actualcostheader.intMachineType 
													WHERE was_actualcostheader.intStatus=$catId ";
	
	/*$sql="SELECT WBCH.intSerialNo,WBCH.intMachineId,WBCH.dblQty,WBCH.strStyleName,WM.strMachineName,WBCH.intCat,WBCH.strColor,WBCH.strFabricId FROM was_budgetcostheader WBCH Inner Join was_machine WM ON WM.intMachineId = WBCH.intMachineId  ";*/
	if($type!='')
		if($type=='intStyleId'){
			$sql.=" AND orders.strOrderNo like '%$text%' ";
		}
		else{
			$sql .= " AND was_actualcostheader.$type like '%$text%' ";
		}
	if($inOrOut!='')
		$sql .= "AND was_actualcostheader.intCat like '$inOrOut' ";
		
		$sql .= "order by was_actualcostheader.intSerialNo DESC";
		//echo $sql;
	$res_search=$db->RunQuery($sql);
	$i=1;
		$htm .="<tbody>";
	while($row=mysql_fetch_array($res_search))
	{
		$cat="";
		($row['intCat']==0)?$cat="In House":$cat="Out Side";
		$c="";
		$r="";
		($c%2==0)?$r="grid_raw":$r="grid_raw2";
		
		$htm .= "<tr class=\"bcgcolor-tblrowWhite mouseover\" id=".$row['intSerialNo']." ondblclick=\"loadActCostDetails(this.id,1,".$row['intCat'].")\">".
					"<td height=\"20\" style=\"text-align:left\" class=".$r.">".$row['intSerialNo']."</td>".
					/*"<td style=\"text-align:left\" class=".$r.">".$cat."</td>".*/
					"<td style=\"text-align:left\" class=".$r.">".$row['strOrderNo']."</td>".
					"<td style=\"text-align:left\" class=".$r.">".$row['strDescription']."</td>".
					
					"<td style=\"text-align:left\" class=".$r.">".$row['strColor']."</td>".
					"<td style=\"text-align:right\" class=".$r.">".$row['dblQty']."</td>";
					
		$htm .= "</tr>";
		$c++;
	}
		$htm.="</tbody>";
	echo $htm;
}
//----------------

elseif($RequestType=="SearchProcesses")
{
$id=$_GET['id'];
	$htm ="<tr bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" height=\"25px;\">".
	"<td width=\"56\" class=\"grid_header\" style=\"width:10px;\">Serial</td>".
	"<td width=\"143\" class=\"grid_header\" style=\"width:300px;\">Process Description</td>".
	"<td width=\"60\" class=\"grid_header\" style=\"width:10px;\">Liquor</td>".
	"<td width=\"53\" class=\"grid_header\" style=\"width:10px;\">Temp</td>".
	"<td width=\"82\" class=\"grid_header\" style=\"width:10px;\">Time</td>".
	"<td width=\"79\" class=\"grid_header\" style=\"width:10px;\">Time<br/>(Hand)</td>".
	"</tr>";
	
	$sql_search="SELECT intSerialNo,strProcessName,dblLiqour,dblTime,dblHTime,dblTemp FROM was_washformula WHERE strProcessName like '%$id%'; ";
	//echo $sql_search;
	$res_search=$db->RunQuery($sql_search);
	$i=1;
		$htm .="<tbody>";
	while($row=mysql_fetch_array($res_search))
	{
		if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}
		
		$htm .= "<tr class=\"bcgcolor-tblrowWhite\" id=".$i." style=\"height:20px;cursor:pointer;\" ondblclick=\"addProcesses(this.id);\"> ".
		"<td class=".$color.">".$row['intSerialNo']."</td>".
		"<td style=\"width:300px;text-align:left;\" class=".$color.">".$row['strProcessName']."</td>".
		"<td style=\"width:10px;text-align:right\" class=".$color.">".$row['dblLiqour']."</td>".
		"<td style=\"width:10px;text-align:right\" class=".$color.">".$row['dblTemp']."</td>".
		"<td style=\"width:10px;text-align:right\" class=".$color.">".$row['dblTime']."</td>".
		"<td style=\"width:10px;text-align:right\" class=".$color.">".$row['dblHTime']."</td>".
		"</tr>";
		$i++;
	}
		$htm.="</tbody>";
	echo $htm;
}

//===========================

elseif($RequestType=="SearchChemical")
{
$pId=$_GET['pid'];
$id=$_GET['id'];
	$htm ="<tr bgcolor=\"#498CC2\" class=\"grid_header\">".
			"<th width=\"23\" height=\"25\" class=\"grid_header\" style=\"text-align:center;width:20px;\">No</th>".
			"<th width=\"200\" class=\"grid_header\" style=\"width:250px;\">Chemical Description</th>".
			"<th width=\"74\" class=\"grid_header\" style=\"width:50px;\">Unit</th>".
			"<th width=\"73\" class=\"grid_header\" style=\"width:50px;\">Qty</th>".
			"<th width=\"74\" class=\"grid_header\" style=\"width:50px;\">Unit Price</th>".
			"<th width=\"5\" class=\"grid_header\" style=\"width:1px;\"><input name=\"chkChemSelectAll\" type=\"checkbox\" id=\"chkChemSelectAll\" onclick=\"SelectAll(this,'tblChm');\" /></th>".
		"</tr>";
	
	$sql_search="SELECT DISTINCT wc.intChemicalId,wc.dblUnitPrice,GMIL.strItemDescription,GMIL.strUnit FROM was_chemical AS wc Inner Join genmatitemlist GMIL ON wc.intChemicalId = GMIL.intItemSerial WHERE  GMIL.strItemDescription like '%$id%' AND wc.intChemicalID IN (SELECT
														wcl.intChemicalId
														FROM
														was_chemical AS wcl
														WHERE
														wcl.intProcessId = '$pId'
														order by wcl.intChemicalId ) order by GMIL.strItemDescription"; //wc.intProcessId = '3' and
	//echo $sql_search;
	$res_search=$db->RunQuery($sql_search);
	$i=1;
		$htm .="<tbody>";
	while($row=mysql_fetch_array($res_search)) 
	{
		$des=split('-',$row['strItemDescription']);
		($i%2==1)?$color='grid_raw':$color='grid_raw2';
		
		$htm .= "<tr class=\"bcgcolor-tblrowWhite\" id=".$i." style=\"height:20px;cursor:pointer;\">".
"<td class=".$color." style=\"text-align:left;\">".$row['intChemicalId']."</td>".
"<td style=\"width:100px;text-align:left;\" class=".$color.">".$des[count($des)-1]."</td>".
"<td style=\"width:50px;text-align:left;\" class=".$color." >".$row['strUnit']."</td>".
"<td style=\"width:50px;\"  class=".$color."><input type=\"text\" value=\"".$row['dblQty']."\" style=\"width:60px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,3,event)\"/></td>".
"<td style=\"width:50px;\"  class=".$color."><input type=\"text\" style=\"width:60px;text-align:right;\" value=\"".$row['dblUnitPrice']."\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\" /></td>".
"<td style=\"width:10px;;text-align:center;\"  class=".$color."><input name=\"checkbox2\" type=\"checkbox\" /></td>".
"</tr>";
		$i++;
	}
		$htm.="</tbody>";
	echo $htm;
}
//-==============================================
function GetOrderNo($styleId,$cat)
{
global $db;
if($cat==0){
	$sql="select O.intStyleId,O.strOrderNo,O.intQty,O.reaExPercentage,O.intDivisionId,BD.strDivision,O.strDescription from orders O  left join buyerdivisions BD on BD.intDivisionId=O.intDivisionId where O.intStyleId='$styleId';";
}
else{
 $sql="";
}
//echo $sql;
return $db->RunQuery($sql);
}

function GetOrderDetails($styleId,$cat)
{
global $db;
	if($cat==0){
		$sql="select O.intStyleId,O.strOrderNo,O.intQty,O.reaExPercentage,O.intDivisionId,BD.strDivision,O.strDescription from orders O  left join buyerdivisions BD on BD.intDivisionId=O.intDivisionId where O.intStyleId='$styleId';";	
		}
	else{
		$sql="SELECT
				was_outsidepo.intId as intStyleId ,
				was_outsidepo.intPONo as strOrderNo,
				was_outsidepo.dblOrderQty as intQty,
				was_outsidepo.dblEx as reaExPercentage,
				buyerdivisions.intDivisionId,
				buyerdivisions.strDivision,
				was_outsidepo.strStyleDes as strDescription
				FROM
				was_washpriceheader
				Inner Join was_outsidepo ON was_washpriceheader.intStyleId = was_outsidepo.intId
				Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId
				Inner Join buyers ON was_outsidewash_fabdetails.intBuyer = buyers.intBuyerID
				left Join buyerdivisions ON buyers.intBuyerID = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
				WHERE
				was_washpriceheader.intStyleId = '$styleId';";	
	}
	//echo $sql;
	return $db->RunQuery($sql);
}

function GetMainFabAndMill($styleId,$cat)
{
global $db;
/*$sql="select OD.intMatDetailID,MIL.strItemDescription,OD.intMillId,S.strTitle from orderdetails OD 
inner join suppliers S on S.strSupplierID=OD.intMillId
inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID
where OD.intStyleId=$styleId and intMainFabricStatus=1";*/
if($cat==0){
	$sql="SELECT OD.intMatDetailID,MIL.strItemDescription,OD.intMillId,S.strTitle,orders.strStyle FROM orderdetails AS OD Inner Join suppliers AS S ON S.strSupplierID = OD.intMillId Inner Join matitemlist AS MIL ON MIL.intItemSerial = OD.intMatDetailID Inner Join orders ON orders.intStyleId = OD.intStyleId  WHERE orders.intStyleId =  '$styleId' AND OD.intMainFabricStatus =  1;";
	//echo $sql;AND orders.strOrderNo = OD.strOrderNo
}
else{
	$sql="SELECT was_outsidewash_fabdetails.strFabricId as strItemDescription ,was_outsidewash_fabdetails.intId as intMatDetailID,suppliers.strTitle,suppliers.strSupplierID as intMillId
			FROM
			was_outsidepo
			Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId
			Inner Join suppliers ON was_outsidepo.intMill = suppliers.strSupplierID
			WHERE
			was_outsidepo.intId =  '$styleId';";
}

return $db->RunQuery($sql);
}
function GetWashPriceDetailsRequest($styleId,$cat)
{
global $db;
	if($cat==0){
	$sql="select  WPH.strColor,WPH.intGarmentId,G.strCatName,WPH.intWasTypeId,WT.strWasType 
from was_washpriceheader WPH
		inner join productcategory G on G.intCatId=WPH.intGarmentId
		inner join was_washtype WT on WT.intWasID=WPH.intWasTypeId
		where intStyleId='$styleId';";
	}
	else{
		$sql="SELECT was_washpriceheader.strColor,was_washtype.strWasType,productcategory.strCatName,productcategory.intCatId as intGarmentId,was_washtype.intWasID as intWasTypeId
			FROM
			was_washpriceheader
			Inner Join was_washtype ON was_washtype.intWasID = was_washpriceheader.intWasTypeId
			Inner Join productcategory ON was_washpriceheader.intGarmentId = productcategory.intCatId
			WHERE
			was_washpriceheader.intStyleId =  '$styleId';";
	}
	//echo $sql;
return $db->RunQuery($sql);
}
function GetBranch($customerId,$cat)
{
global $db;
if($cat==0){
	$sql="select strCity from  companies where intCompanyID=$customerId;";
}
else{
	$sql="SELECT was_outside_companies.strCity FROM was_outside_companies WHERE was_outside_companies.intCompanyID =  '$customerId';";
}
	//echo $sql;
return $db->RunQuery($sql);
}

if($RequestType=="loadActDetails")
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial =	$_GET['serial'];
	$cat 	=	$_GET['cat'];	
		$ResponseXML ="<loadWashProcess>";
		
		$sql_loadHeader="SELECT
						was_actualcostheader.intSerialNo,
						was_actualcostheader.intRevisionNo,
						was_actualcostheader.intYear,
						was_actualcostheader.intCustomerId,
						was_actualcostheader.intStyleId,
						was_actualcostheader.intStatus,
						was_actualcostheader.intMatDetailId,
						was_actualcostheader.intDivisionId,
						was_actualcostheader.intGarmentId,
						was_actualcostheader.intWashType,
						was_actualcostheader.intMachineType,
						was_actualcostheader.strColor,
						was_actualcostheader.dblQty,
						was_actualcostheader.dblWeight,
						was_actualcostheader.dblHTime";
						if($cat==0){
							$sql_loadHeader.=" ,orders.strStyle,orders.strOrderNo";
						}
						else{
							$sql_loadHeader.=" ,was_outsidepo.strStyleDes as strStyle,was_outsidepo.intPONo as strOrderNo"; 
						}
							$sql_loadHeader.=" FROM was_actualcostheader";
						if($cat==0){
							$sql_loadHeader.=" Inner Join orders ON orders.intStyleId = was_actualcostheader.intStyleId";
							}
						else{
							$sql_loadHeader.=" Inner Join was_outsidepo ON was_outsidepo.intId = was_actualcostheader.intStyleId";
						}
							$sql_loadHeader.=" WHERE intSerialNo=$serial;";
								
								//echo $sql_loadHeader;
		$resHeader = $db->RunQuery($sql_loadHeader);
		while($row=mysql_fetch_array($resHeader))
		{
			$ResponseXML.="<intSerialNo><![CDATA[" . trim($row["intSerialNo"])  . "]]></intSerialNo>\n";
			$ResponseXML.="<intStatus><![CDATA[" . trim($row["intStatus"])  . "]]></intStatus>\n";
			$ResponseXML.="<intRevisionNo><![CDATA[".trim($row["intRevisionNo"])."]]></intRevisionNo>\n";
			$ResponseXML.="<intYear><![CDATA[" . trim($row["intYear"])  . "]]></intYear>\n";	
			$ResponseXML.="<intCustomerId><![CDATA[" . trim($row["intCustomerId"])  . "]]></intCustomerId>\n";
			$ResponseXML.="<intStyleId><![CDATA[" . trim($row["intStyleId"])  . "]]></intStyleId>\n";
			$ResponseXML.="<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";	
			$ResponseXML.="<intMatDetailId><![CDATA[" . trim($row["intMatDetailId"])  . "]]></intMatDetailId>\n";	
			$ResponseXML.="<intDivisionId><![CDATA[" . trim($row["intDivisionId"])  . "]]></intDivisionId>\n";	
			$ResponseXML.="<intGarmentId><![CDATA[" . trim($row["intGarmentId"])  . "]]></intGarmentId>\n";	
			$ResponseXML.="<intWashType><![CDATA[" . trim($row["intWashType"])  . "]]></intWashType>\n";
			$ResponseXML.="<cboMachine><![CDATA[" . trim($row["intMachineType"])  . "]]></cboMachine>\n";
			$ResponseXML.="<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";	
			$ResponseXML.="<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
			$ResponseXML.="<dblWeight><![CDATA[" . trim($row["dblWeight"])  . "]]></dblWeight>\n";	
			$ResponseXML.="<dblHTime><![CDATA[" . trim($row["dblHTime"])  . "]]></dblHTime>\n";
		}
		$sql_loadDetails="SELECT 
							wb.intRowID,wb.intProcessId,wb.dblTemp,wb.dblLiqour,wb.dblTime,wf.strProcessName,wb.dblPHValue
							FROM  
							was_actualcostdetails wb
							INNER JOIN was_washformula AS wf ON wf.intSerialNo=wb.intProcessId
							WHERE
							wb.intSerialNo=$serial;";
													//echo $sql_loadDetails;
		$resGrid=$db->RunQuery($sql_loadDetails);
		while($rowG=mysql_fetch_array($resGrid))
		{
			$ResponseXML.="<intRowOder><![CDATA[" . trim($rowG["intRowID"])  . "]]></intRowOder>\n";
			$ResponseXML.="<strProcessName><![CDATA[" . trim($rowG["strProcessName"])  . "]]></strProcessName>\n";
			$ResponseXML.="<intProcessId><![CDATA[" . trim($rowG["intProcessId"])  . "]]></intProcessId>\n";
			$ResponseXML.="<dblTemp><![CDATA[" . trim($rowG["dblTemp"])  . "]]></dblTemp>\n";
			$ResponseXML.="<PHValue><![CDATA[" . trim($rowG["dblPHValue"])  . "]]></PHValue>\n";
			$ResponseXML.="<dblLiqour><![CDATA[" . trim($rowG["dblLiqour"])  . "]]></dblLiqour>\n";
			$ResponseXML.="<dblTime><![CDATA[" . trim($rowG["dblTime"])  . "]]></dblTime>\n";
		}
		
		$ResponseXML .="</loadWashProcess>";
		echo $ResponseXML;
}
function getCompany($po){
	global $db;
	//$sql="SELECT DISTINCT wst.intFromFactory FROM was_stocktransactions AS wst WHERE wst.intStyleId ='$po' and strType='FTransIn';";
	//changed 20-06-2011
	
	$sql="SELECT DISTINCT productiongpheader.intTofactory FROM productiongpheader WHERE productiongpheader.intStyleId='$po' GROUP BY productiongpheader.intStyleId";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['intTofactory'];
}
?>