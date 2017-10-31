<?php
session_start();
include "../../../Connector.php";
$requestType = $_GET["RequestType"];

if($requestType=="LoadChemical")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<data>\n";
$processId = $_GET["ProcessId"];
	$sql="select WC.intChemicalId,GMIL.strItemDescription,WC.strUnit,WC.dblUnitPrice from was_chemical WC inner join genmatitemlist GMIL on GMIL.intItemSerial=WC.intChemicalId where WC.intProcessId=$processId";
	$results=$db->RunQuery($sql);
	while($row=mysql_fetch_array($results))
	{
		$ResponseXML .= "<ChemicalId><![CDATA[" . $row["intChemicalId"] . "]]></ChemicalId>\n";
	 	$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";
		$ResponseXML .= "<UnitId><![CDATA[" . $row["strUnit"] . "]]></UnitId>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . round($row["dblUnitPrice"],4) . "]]></UnitPrice>\n";
	}

$ResponseXML .= "</data>";
echo $ResponseXML;
}
else if($requestType=="SearchChemical"){
	$Id=$_GET['id'];
	
		$htm = "<tr class=\"mainHeading4\" height=\"25\">";
		$htm .="<th width=\"4%\">";
		$htm .="<input type=\"checkbox\" name=\"chkAll\" id=\"chkAll\" onclick=\"CheckAll(this);\" /> ";
		$htm .="</th>";
		$htm .="<th width=\"66%\">Chemical Description </th>";
		$htm .="<th width=\"15%\">Unit</th>";
		$htm .="<th width=\"15%\">Unit Price</th>";
		$htm .="</tr>";
	
	$sql="select GMIL.intItemSerial,GMIL.strItemDescription,GMIL.strUnit,GMIL.dblLastPrice 
	from genmatitemlist GMIL where GMIL.intMainCatID=1 AND GMIL.strItemDescription like '%$Id%' order by GMIL.strItemDescription";
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$htm .="<tr class=\"bcgcolor-tblrowWhite\" >";
			$htm .="<td width=\"4%\"><input type=\"checkbox\" name=\"chkSelect\" id=\"chkSelect\" /></td>";
			$htm .="<td width=\"66%\" class=\"normalfnt\" id=\"".$row["intItemSerial"]."\">".$row["strItemDescription"]."</td>";
			$htm .="<td width=\"15%\" class=\"normalfnt\" id=\"".$row["strUnit"]."\">".$row["strUnit"]."</td>";
			$htm .="<td width=\"15%\" class=\"normalfnt\" ><input type=\"text\" name=\"txtUP\" id=\"txtUP\" style=\"width:70px;text-align:right\" value=\"". round($row["dblLastPrice"],4) ."\" /></td>";
			$htm .="</tr>";  
		
		}
		echo $htm;
}
?>
