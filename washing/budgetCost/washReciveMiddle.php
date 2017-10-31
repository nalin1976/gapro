<?php
require_once('../../Connector.php');
$request=$_GET['req'];
$xml = simplexml_load_file("../../config.xml");

if($request=="selectFabricDet")
{
$fabricID = $_GET['cID'];
$sql="SELECT m.intItemSerial,m.strItemDescription,sp.strTitle 
	FROM  matitemlist m 
	INNER JOIN orderdetails AS OD ON OD.intMainFabricStatus=1 
	INNER JOIN suppliers AS sp ON sp.strSupplierID=OD.intMillID
	AND OD.intMatDetailID= m.intItemSerial
	AND m.intItemSerial=$fabricID;";
$sqlRes=$db->RunQuery($sql);
$row=mysql_fetch_array($sqlRes);
echo $row['strItemDescription']."~".$row['strTitle'];
}
elseif($request=='selectDivision')
{
	$customerID=$_GET['cID'];
	$sql_SelectDiv="SELECT intDivisionId,strDivision FROM buyerdivisions WHERE intBuyerID='$customerID';";
	//echo $sql_SelectDiv;
	$res=$db->RunQuery($sql_SelectDiv);
	$htmlCbo="<option value=\"\">Select Item</option>";
	while($row=mysql_fetch_array($res))
	{
		$htmlCbo .="<option value=".$row['intDivisionId'].">".$row['strDivision']."</option>";
	}
	echo $htmlCbo;
}
elseif($request=="loadWashType")
{
	$washType	=$_GET['washType'];
	$sql_loadwashType="SELECT strWasType,dblUnitPrice FROM was_washtype WHERE intWasID='$washType';";
	$res=$db->RunQuery($sql_loadwashType);
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<WashTypes>";
	while($row=mysql_fetch_array($res))
	{
		$ResponseXML .= "<strWasType><![CDATA[" . $row["strWasType"]  . "]]></strWasType>\n";
		$ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
	}
	$ResponseXML .= "</WashTypes>";
	echo $ResponseXML;
}
elseif($request=="saveWashType")
{
	$washType  =$_GET['washType'];
	$unitPrice =$_GET['unitPrice'];
	$sql_chk="SELECT * FROM was_washtype WHERE strWasType='$washType';";
	$resChk=$db->RunQuery($sql_chk);
	if($resChk==0)
	{
		$sql_saveWashType="INSERT INTO was_washtype(strWasType,dblUnitPrice) VALUES('$washType',$unitPrice);";
		$resInWash=$db->RunQuery($sql_saveWashType);
		echo "Successfully Added.";
	}
	else
	{
		$sql_updateWashType="UPDATE was_washtype SET strWasType='$washType',dblUnitPrice=$unitPrice WHERE strWasType='$washType';";
		$resUpWash=$db->RunQuery($sql_updateWashType);
		echo "Successfully Updated.";
	}
	
}
elseif($request=="SearchProcesses")
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
	
	$sql_search="SELECT intSerialNo,strProcessName,dblLiqour,dblTime,dblHTime FROM was_washformula WHERE strProcessName like '%$id%'; ";
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
elseif($request=="SearchPreCosting")
{
$type  		= $_GET['Type'];
$text  		= $_GET['Text'];
$catId 		= $_GET['CatId'];
$inOrOut 	= $_GET['InOrOut'];

	$htm ="<tr bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" >".
			"<th class=\"grid_header\" height=\"25\">Serial</th>".
			"<th class=\"grid_header\" style=\"width:50px;display:none;\">Category</th>".
			"<th class=\"grid_header\" style=\"width:100px;\">Style Name</th>".
			"<th class=\"grid_header\" style=\"width:100px;\">Color</th>".
			"<th class=\"grid_header\" style=\"width:100px;\">Fabric Name</th>".
			"<th class=\"grid_header\" style=\"width:50px;\">Qty</th>".
			"</tr>";
	
	$sql="SELECT WBCH.intSerialNo,WBCH.intMachineId,WBCH.dblQty,WBCH.strStyleName,WM.strMachineName,WBCH.intCat,WBCH.strColor,WBCH.strFabricId FROM was_budgetcostheader WBCH left Join was_machine WM ON WM.intMachineId = WBCH.intMachineId WHERE WBCH.intStatus=$catId ";
	if($type!='')
		$sql .= "AND WBCH.$type like '%$text%' ";
	if($inOrOut!='')
		$sql .= "AND WBCH.intCat like '$inOrOut' ";
		
		$sql .= "order by WBCH.intSerialNo DESC";
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
		
		$htm .= "<tr class=\"bcgcolor-tblrowWhite mouseover\" id=".$row['intSerialNo']." ondblclick=\"loadDetails(this.id,1)\">".
					"<td height=\"20\" style=\"text-align:left;width:50px;\" class=".$r.">".$row['intSerialNo']."</td>".
					"<td style=\"text-align:left;display:none;\" class=".$r.">".$cat."</td>".
					"<td style=\"text-align:left\" class=".$r.">".$row['strStyleName']."</td>".
					"<td style=\"text-align:left\" class=".$r.">".$row['strColor']."</td>".
					"<td style=\"text-align:left\" class=".$r.">".$row['strFabricId']."</td>".
					"<td style=\"text-align:right\" class=".$r.">".$row['dblQty']."</td>".
				"</tr>";
		$c++;
	}
		$htm.="</tbody>";
	echo $htm;
}
elseif($request=="SearchChemical")
{
$pId=$_GET['pid'];
$id=$_GET['id'];
	$htm ="<tr bgcolor=\"#498CC2\" class=\"grid_header\">".
			"<th width=\"23\" height=\"25\" class=\"grid_header\" style=\"text-align:center;width:20px;\">No</th>".
			"<th width=\"251\" class=\"grid_header\" style=\"width:250px;\">Chemical Description</th>".
			"<th width=\"74\" class=\"grid_header\" style=\"width:50px;\">Unit</th>".
			"<th width=\"73\" class=\"grid_header\" style=\"width:50px;\">Qty</th>".
			"<th width=\"74\" class=\"grid_header\" style=\"width:50px;\">Unit Price</th>".
			"<th width=\"5\" class=\"grid_header\" style=\"width:1px;\"><input name=\"chkChemSelectAll\" type=\"checkbox\" id=\"chkChemSelectAll\" onclick=\"SelectAll(this,'tblChm');\" /></th>".
		"</tr>";
	
	$sql_search="SELECT DISTINCT wc.intChemicalId,wc.dblUnitPrice,GMIL.strItemDescription,GMIL.strUnit FROM was_chemical AS wc Inner Join genmatitemlist GMIL ON wc.intChemicalId = GMIL.intItemSerial WHERE GMIL.strItemDescription like '%$id%' AND wc.intChemicalID IN (SELECT
														wcl.intChemicalId
														FROM
														was_chemical AS wcl
														WHERE
														wcl.intProcessId = '$pId'
														order by wcl.intChemicalId) order by GMIL.strItemDescription"; //wc.intProcessId = '3' and 
	//echo $sql_search;
	$res_search=$db->RunQuery($sql_search);
	$i=1;
		$htm .="<tbody>";
	while($row=mysql_fetch_array($res_search))//; $row['strItemDescription']
	{
		($i%2==1)?$color='grid_raw':$color='grid_raw2';
		$des=split('-',$row['strItemDescription']);
		$htm .= "<tr class=\"bcgcolor-tblrowWhite\" id=".$i." style=\"height:20px;cursor:pointer;\">".
"<td class=".$color." style=\"text-align:left;\">".$row['intChemicalId']."</td>".
"<td style=\"width:100px;text-align:left;\" class=".$color.">".  $des[count($des)-1]."</td>".
"<td style=\"width:50px;text-align:left;\" class=".$color." >".$row['strUnit']."</td>".
"<td style=\"width:50px;\"  class=".$color."><input type=\"text\" value=\"".$row['dblQty']."\" style=\"width:60px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,3,event)\"/></td>".
"<td style=\"width:50px;\"  class=".$color."><input type=\"text\" style=\"width:60px;text-align:right;\" value=\"".$row['dblUnitPrice']."\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"  readonly=\"readonly\"/></td>".
"<td style=\"width:10px;;text-align:center;\"  class=".$color."><input name=\"checkbox2\" type=\"checkbox\" /></td>".
"</tr>";
		$i++;
	}
		$htm.="</tbody>";
	echo $htm;
}
elseif($request=="LoadCustomers")
{
$category = $_GET["Category"];
	if($category=='0')
	{
		$sql="select intCompanyID,strName from companies where intStatus=1 order by strName;";	
		$result=$db->RunQuery($sql);
			echo "<option value="."".">".""."</option>";
		while($row=mysql_fetch_array($result))
		{		
			echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
		}
	}
	elseif($category=='1')
	{
		$sql="select intCompanyID,strName from was_outside_companies where intStatus=1 order by strName;";	
		$result=$db->RunQuery($sql);
			echo "<option value="."".">".""."</option>";
		while($row=mysql_fetch_array($result))
		{		
			echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
		}
	}
}
elseif($request=="LoadStyleName")
{
	$sql="select distinct strStyleName from was_budgetcostheader order by strStyleName";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array .= $row['strStyleName']."|";
	}
	echo $array;
}
elseif($request=="LoadDivision")
{
	$sql="select distinct strDivision from was_budgetcostheader order by strStyleName";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array .= $row['strDivision']."|";
	}
	echo $array;
}
elseif($request=="LoadFabricId")
{
	$sql="(select distinct strFabricId from was_outsidewash_fabdetails) 
union 
(select distinct strFabricId from was_budgetcostheader)
order by strFabricId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array .= $row['strFabricId']."|";
	}
	echo $array;
}

else if($request=="LoadColors"){
	$sql="SELECT DISTINCT TBL.strColor FROM (SELECT c.strColor FROM colors  c 
		  UNION 
		  SELECT wh.strColor FROM was_budgetcostheader wh) AS TBL ORDER BY TBL.strColor ASC;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array .= $row['strColor']."|";
	}
	echo $array;
}

else if($request=="LoadWashType"){
	$sql="SELECT DISTINCT tbl.WASHTYPE FROM (SELECT was_budgetcostheader.intWashType AS WASHTYPE
			FROM
			was_budgetcostheader 
			UNION 
			SELECT was_washtype.strWasType AS WASHTYPE
			FROM
			was_washtype) AS TBL ORDER BY TBL.WASHTYPE ASC;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array .= $row['WASHTYPE']."|";
	}
	echo $array;
}

elseif($request=="GetFabricSerial")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$FId	= $_GET["FId"];
$ResponseXML = "<GetFabricSerial>";
	$sql="select strFabricDsc,strFabricContent from was_outsidewash_fabdetails where strFabricId='$FId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<FD><![CDATA[" . trim($row["strFabricDsc"])  . "]]></FD>\n";
		$ResponseXML.="<FC><![CDATA[" . trim($row["strFabricContent"])  . "]]></FC>\n";
	}

$ResponseXML .= "</GetFabricSerial>";
echo $ResponseXML;
}
elseif($request=="LoadJobToCopy")
{
	$sql="SELECT intSerialNo FROM was_budgetcostheader order by intSerialNo desc";//where intStatus=1 
	$result=$db->RunQuery($sql);
		echo "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["intSerialNo"].">".$row["intSerialNo"]."</option>";
	}
}

else if($request=="GetColors"){
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$cId	= $_GET["cId"];
$ResponseXML = "<GetColor>";
	$sql="SELECT DISTINCT strColor FROM colors  where strColor = '$cId' order by strColor";
	//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<CD><![CDATA[" . trim($row["strColor"])  . "]]></CD>\n";

	}

$ResponseXML .= "</GetColor>";
echo $ResponseXML;
}
elseif($request=="LoadJobToCopy")
{
	$sql="SELECT intSerialNo FROM was_budgetcostheader order by intSerialNo desc";//where intStatus=1 
	$result=$db->RunQuery($sql);
		echo "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["intSerialNo"].">".$row["intSerialNo"]."</option>";
	}
}
?>