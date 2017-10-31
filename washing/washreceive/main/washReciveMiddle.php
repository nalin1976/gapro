<?php
require_once('../../../Connector.php');
$request=$_GET['req'];
if($request=="selectFabricDet")
{
	$fabricID=$_GET['cID'];
	$sql_Fabric="SELECT m.intItemSerial,m.strItemDescription,sp.strTitle 
					FROM  matitemlist m 
					INNER JOIN orderdetails AS OD ON OD.intMainFabricStatus=1 
					INNER JOIN suppliers AS sp ON sp.strSupplierID=OD.intMillID
					AND OD.intMatDetailID= m.intItemSerial
					AND m.intItemSerial=$fabricID;";
					//echo $sql_Fabric;
	$sqlRes=$db->RunQuery($sql_Fabric);
	$row=mysql_fetch_array($sqlRes);
	echo $row['strItemDescription']."~".$row['strTitle'];
}
if($request=='selectStyles')
{
	$customerID=$_GET['cID'];
	$sql_Styles="SELECT O.intStyleId,O.strStyle FROM orders O WHERE O.intBuyerID='$customerID';";
	$resSty=$db->RunQuery($sql_Styles);
	$htmlCbo="<option value=\"\">Select Item</option>";
	while($rowSty=mysql_fetch_array($resSty))
	{
		$htmlCbo .="<option value=".$rowSty['intStyleId'].">".$rowSty['strStyle']."</option>";
 	}
	echo $htmlCbo;
						
}
if($request=='selectDivision')
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
if($request=="selectColor")
{
	$cID	=$_GET['cID'];
	$divID	=$_GET['divID'];
	//WHERE intDivisionID='$divID' AND intCustomerId='$cID';
	$sql_Color="SELECT strColor,strDescription FROM colors;";
	//echo $sql_Color;
	$res=$db->RunQuery($sql_Color);
	$htmlCbo="<option value=\"\">Select Item</option>";
	while($row=mysql_fetch_array($res))
	{
		$htmlCbo .="<option value=".$row['strColor'].">".$row['strDescription']."</option>";
	}
	echo $htmlCbo;
}
if($request=="loadWashType")
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
if($request=="saveWashType")
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

if($request=="searcProcesses")
{
	$id=$_GET['id'];
	$htm="";
	$htm.="<tr bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">";
	$htm.="<td>Serial</td>";
	$htm.="<td style=\"width:100px;\">Process Description</td>";
	$htm.="<td style=\"width:50px;\">Liquor</td>";
	$htm.="<td style=\"width:50px;\">Temp</td>";
	$htm.="<td style=\"width:50px;\">Time</td>";
	$htm.="<td style=\"width:50px;\">Time(Hand)</td></tr>";
	
	$sql_search="SELECT intSerialNo,strProcessName,dblLiqour,dblTime,dblHTime FROM was_washformula WHERE strProcessName like '%$id%'; ";
	$res_search=$db->RunQuery($sql_search);
	$i=1;
	while($row=mysql_fetch_array($res_search))
	{
		$htm .="<tr class=\"bcgcolor-tblrowWhite\" id=\"".$row['intSerialNo']."\" style=\"height:20px;cursor:pointer;\" ondblclick=\"addProcesses(this.id);\">";
		$htm .="<td>".$row['intSerialNo']."</td>";
		$htm .="<td>".$row['intSerialNo']."</td>";
		$htm .="<td style=\"width:100px;\">".$row['strProcessName']."</td>";
		$htm .="<td>".$row['dblLiqour']."</td>";
		$htm .="<td>".$row['dblTime']."</td>";
		$htm .="<td>".$row['dblHTime']."</td></tr>";
		$i++;
	}
	echo $htm;
}
?>
