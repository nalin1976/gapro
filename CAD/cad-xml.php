<?php

include "../Connector.php";
		
/*		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
		
$id=$_GET["id"];

if($id=="loadFabric")
{
	$strStyleId=$_GET["styleId"];
	$SQL="	SELECT
			materialratio.strMatDetailID,
			matitemlist.strItemDescription
			FROM
			materialratio
			Inner Join matitemlist ON matitemlist.intItemSerial = materialratio.strMatDetailID
			WHERE
			matitemlist.intMainCatID =  '1' ";
	$SQL.= " AND materialratio.intStyleId =  '$strStyleId'";		
	
				$result = $db->RunQuery($SQL);
				$ComboString= "<option value=\"". '' ."\">" . '' ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					$ComboString .= "<option value=\"". $row["strMatDetailID"] ."\">" . $row["strItemDescription"] ."</option>" ;
				}
				echo $ComboString;
} 
if($id=="loadColor")
{
	$strStyleId		=$_GET["strStyleId"];
	$strFabric		=$_GET["FabricId"];
	$strBuyerPo		= str_replace("***","#",$_GET["strBuyerPo"]);
	
	$SQL="	SELECT DISTINCT
			strColor
			FROM
			styleratio
			WHERE intStyleId =  '$strStyleId'  ";

	if(trim($strBuyerPo)!='')	
		$SQL .= 	"  AND strBuyerPONO =  '$strBuyerPo'";
			
				$result = $db->RunQuery($SQL);
				$ComboString= "<option value=\"". 'N/A' ."\">" . 'N/A' ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					$ComboString .= "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
				}
				echo $ComboString;
} 

if($id=="loadBuyerPo")
{
	$strStyleId=$_GET["styleId"];
	$SQL="SELECT strBuyerPONO from style_buyerponos where intStyleId='$strStyleId'";
	//$SQL="SELECT disinct strBuyerPONO FROM styleratio where intStyleId='$strStyleId'";
				$result = $db->RunQuery($SQL);
				$ComboString= "<option value=\"". '#Main Ratio#' ."\">" . '#Main Ratio#' ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					$ComboString .= "<option value=\"". $row["strBuyerPONO"] ."\">" . $row["strBuyerPONO"] ."</option>" ;
				}
				echo $ComboString;
} 

if($id=="loadWidth")
{
	$strStyleId		=$_GET["styleId"];
	$strFabric		=$_GET["strFabric"];
	$strColor		=$_GET["strColor"];
	
	$SQL="	SELECT
			fabricinspection.dblCutWidth
			FROM
			fabricinspection
			Inner Join matitemlist ON matitemlist.intItemSerial = fabricinspection.intItemSerial
			WHERE
				 strStyle='$strStyleId' ";
	if(trim($strFabric)!='') 
		$SQL .=		" AND matitemlist.intSubCatID =  '$strFabric'";
	
	if(trim($strColor)!='') 
		$SQL .=		" AND fabricinspection.strColor =  '$strColor'";

			
				$result = $db->RunQuery($SQL);
				$ComboString= "<option value=\"". '' ."\">" . '' ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					$ComboString .= "<option value=\"". $row["dblCutWidth"] ."\">" . $row["dblCutWidth"] ."</option>" ;
				}
				echo $ComboString;
} 

if($id=="getMaterials")
{
	$strStyleId		=$_GET["styleId"];
	$strsubCat		=$_GET["subCat"];
	$strColor		=$_GET["strColor"];
	$strbpo		=  str_replace("***","#",$_GET["strBuyerPo"]);
	
	$SQL="select materialratio.strMatDetailID, matitemlist.strItemDescription, matitemlist.intSubCatID from materialratio inner join matitemlist on materialratio.strMatDetailID = matitemlist.intItemSerial where materialratio.intStyleId = '$strStyleId' and materialratio.strColor = '$strColor' and materialratio.strBuyerPONO ='$strbpo' and  matitemlist.intSubCatID  = '$strsubCat'";

				$result = $db->RunQuery($SQL);
				$ComboString= "<option value=\"". '' ."\">" . '' ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					$ComboString .= "<option value=\"". $row["strMatDetailID"] ."\">" . $row["strItemDescription"] ."</option>" ;
				}
				echo $ComboString;
} 

if($id=="getUserByStyle")
{
	$strStyleId		=$_GET["styleId"];

	$SQL="	SELECT  useraccounts.Name,useraccounts.intUserID
			FROM orders Inner Join useraccounts ON useraccounts.intUserID = orders.intApprovedBy
			WHERE orders.intStyleId =  '$strStyleId'";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
				{
					$name =$row["intUserID"].'--'. $row["Name"]  ;
					break;
				}
				echo $name;
				
} 

if($id=="getRatioQty")
{
	$strStyleId		=$_GET["styleId"];
	$strBuyerPo		= str_replace("***","#",$_GET["strBuyerPo"]);
	$strColor		=$_GET["strColor"];

	$SQL="	SELECT
			round(Sum(dblQty),2) AS TotalQty
			FROM styleratio
			WHERE
			intStyleId =  '$strStyleId' AND
			strColor =  '$strColor' AND
			strBuyerPONO =  '$strBuyerPo'
			GROUP BY
			intStyleId,
			strColor,
			strBuyerPONO ";

				$Tqty = 0;
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
				{
					$Tqty .= $row["TotalQty"] ;
					break;
				}
				echo $Tqty;
} 
///////////////////////////////////////////       get details		/////////////////////////////////////
function Methord1($strStyleId,$strBuyerPo,$strColor,$intMaterialId)
{
	global $db;
	$SQL1="	SELECT
			cadconsumptionmarkerdetails.strMarkerName,
			cadconsumptionmarkerdetails.dblCopy,
			cadconsumptionmarkerdetails.dblLayers,
			cadconsumptionmarkerdetails.dblMarKerLengthYrd,
			cadconsumptionmarkerdetails.dblMarKerLengthInch,
			cadconsumptionmarkerdetails.dblEFF,
			cadconsumptionmarkerdetails.dblTotalYrd
			FROM cadconsumptionmarkerdetails
			WHERE
			cadconsumptionmarkerdetails.intStyleId =  '$strStyleId' AND
			cadconsumptionmarkerdetails.intMatdetailId =  '$intMaterialId' AND
			cadconsumptionmarkerdetails.strColor =  '$strColor'";
	$A = $db->RunQuery($SQL1);

	while($row1 = mysql_fetch_array($A))
	{
		$MarkerName =  $row1["strMarkerName"];
		$dblCopy =  $row1["dblCopy"];
		$dblLayers =  $row1["dblLayers"];
		$dblMarKerLengthYrd =  $row1["dblMarKerLengthYrd"];
		$dblMarKerLengthInch =  $row1["dblMarKerLengthInch"];
		$dblEFF =  $row1["dblEFF"];
		$dblTotalYrd =  $row1["dblTotalYrd"];
	
	$strNewString1 .="<tr><td><div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"removeRow(this)\"/></div></td>
                <td  class=\"normalfnt\"><input  name=\"txtTotalYards\" value=\"$MarkerName\"  type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\"  /></td>
				<td class=\"normalfnt\"><input name=\"xx\" value=\"$dblCopy\" style=\"text-align:right\"  type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                	<td class=\"normalfnt\"><input name=\"txtLayer\" value=\"$dblLayers\"  style=\"text-align:right\"  type=\"text\" class=\"txtbox\" id=\"txtLayer\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onblur=\"verticalCalculate(this);\"  onkeyup=\"sizeCalculation(this);\"  /></td>";

					$SQL2="	SELECT
							cadconsumptionsizedetails.dblQty
							FROM cadconsumptionsizedetails
							WHERE
							cadconsumptionsizedetails.intStyleId =  '$strStyleId' AND
							cadconsumptionsizedetails.intMatdetailId =  '$intMaterialId' AND
							cadconsumptionsizedetails.strColor =  '$strColor' AND
							cadconsumptionsizedetails.strMarkerName =  '$MarkerName'";
					
				$R2 = $db->RunQuery($SQL2);
				while($row2 = mysql_fetch_array($R2))
				{
					$qty = $row2["dblQty"];
$strNewString1.="<td  class=\"normalfntRite\"><input value=\"$qty\" name=\"txtSize\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtSize\" size=\"10\"  onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onkeyup=\"sizeCalculation(this);\" /></td>";
				}

$strNewString1.="<td  class=\"normalfntRite\"><input  value=\"$dblMarKerLengthYrd\"   name=\"txtTotalYards\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\"  onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  onblur=\"verticalCalculate(this);\"  /></td>
<td class=\"normalfnt\"><input  value=\"$dblMarKerLengthInch\"   name=\"txtMarkerLenghtYrd\" style=\"text-align:right\"  type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtYrd\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  onblur=\"verticalCalculate(this);\"   /></td>
                <td class=\"normalfnt\"><input  value=\"$dblEFF\"   name=\"txtMarkerLenghtInch\"  type=\"text\" style=\"text-align:right\" class=\"txtbox\" id=\"txtMarkerLenghtInch\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input  value=\"$dblTotalYrd\"   name=\"txtEff\" type=\"text\" style=\"text-align:right\" onfocus=\"this.blur();\" class=\"txtbox\" id=\"txtEff\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td></tr>";
				
}
				$Tqty = 0;
				//$result = $db->RunQuery($SQL1);
			
			$strString1 = "<tr>
                <td width=\"5\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">DEL</td>
                <td width=\"10\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Marker Name</td>
                <td width=\"10\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Copy </td>
                <td width=\"10\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Layer</td>";
				
			$strString2 = "<tr>
                <td>&nbsp;</td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" type=\"text\"
				 class=\"txtboxbackcolor\" id=\"txtTotalYards\" size=\"10\" value=\"Total\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onfocus=\"this.blur();\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  onfocus=\"this.blur();\"  /></td>";
				
				/////////////////////////////// FOR 2ND LINE /////////////////////////////////////////////
				$x2 = "<tr>
                <td>&nbsp;</td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" type=\"text\" class=\"txtboxbackcolor\" id=\"txtTotalYards\" size=\"10\" value=\"Pending\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\"  onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event)\"   /></td>";
				//////////////////////////////////////////////////////////////////////////////////////////
				$SQL2="	SELECT 	strSize, dblQty FROM styleratio
					WHERE intStyleId = '$strStyleId' 
					AND strColor = '$strColor' 
					AND strBuyerPONO = '$strBuyerPo' ORDER BY strSize";
					
				$R2 = $db->RunQuery($SQL2);
				while($row = mysql_fetch_array($R2))
				{
					$strSize 	= $row["strSize"];
					$dblQty 	= $row["dblQty"];
					$dblQty1 = (0-$dblQty);
					$strString3 .= " <td width=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">$strSize<br/>$dblQty</td>";
					$strString4	.= " <td  class=\"normalfntRite\"><input name=\"txtTotalYards\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\"   alt=\"$dblQty\" value=\"$dblQty\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onfocus=\"this.blur();\"/></td>";

					//////////////////////////////////////////// FOR 2ND LINE ///////////////////////////////////////
					$x4 .= " <td  class=\"normalfntRite\"><input name=\"txtTotalYards\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\" value=\"$dblQty1\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onfocus=\"this.blur();\"/></td>";
					///////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				}
  $strString5 ="<td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Marker Length YRD </td>
                <td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Marker Length Inch </td>
                <td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">EFF</td>
                <td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Yards </td>
                </tr>";
  $strString6= "<td class=\"normalfnt\"><input name=\"txtMarkerLenghtYrd\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtYrd\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtMarkerLenghtInch\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtInch\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtEff\" type=\"text\" onfocus=\"this.blur();\" class=\"txtbox\" id=\"txtEff\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                </tr>";
				
				////////////////////////////////////// FOR 2ND LINE ///////////////////////////////////////////
				$x6 = "<td class=\"normalfnt\"><input name=\"txtMarkerLenghtYrd\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtYrd\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtMarkerLenghtInch\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtInch\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtEff\" type=\"text\" onfocus=\"this.blur();\" class=\"txtbox\" id=\"txtEff\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"/></td>
                </tr>";
				///////////////////////////////////////////////////////////////////////////////////////////////
				
				$totString = $strString1  . $strString3 . $strString5  .$strNewString1.$strString2  .$strString4 .$strString6;
				$totString .= $x2.$x4.$x6;

				echo $totString;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
if($id=="getSizes")
{
	$strStyleId		=$_GET["styleId"];
	$strBuyerPo		= str_replace("***","#",$_GET["strBuyerPo"]);
	$strColor		=$_GET["strColor"];
	$intMaterialId	=$_GET["intMaterialId"];
	
	$SQL = "select count(*)as reCount from cadconsumptionheader where intStyleId='$strStyleId' AND intMatdetailId='$intMaterialId' AND strColor='$strColor'";
	$result = $db->RunQuery($SQL);
	$intRec=0;
	while($row = mysql_fetch_array($result))
	{
		$intRec = $row["reCount"];
	}

	if($intRec > 0 )
	{
		Methord1($strStyleId,$strBuyerPo,$strColor,$intMaterialId);
		return;
	}
	
	
	
	$SQL="	SELECT 	strSize, dblQty FROM styleratio
			WHERE intStyleId = '$strStyleId' 
			AND strColor = '$strColor' 
			AND strBuyerPONO = '$strBuyerPo' ORDER BY strSize";

				$Tqty = 0;
				$result = $db->RunQuery($SQL);
			
			$strString1 = "<tr>
                <td width=\"5\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">DEL</td>
                <td width=\"10\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Marker Name</td>
                <td width=\"10\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Copy </td>
                <td width=\"10\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Layer</td>";
				
			$strString2 = "<tr>
                <td>&nbsp;</td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" type=\"text\"
				 class=\"txtboxbackcolor\" id=\"txtTotalYards\" size=\"10\" value=\"Total\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onfocus=\"this.blur();\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  onfocus=\"this.blur();\"  /></td>";
				
				/////////////////////////////// FOR 2ND LINE /////////////////////////////////////////////
				$x2 = "<tr>
                <td>&nbsp;</td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" type=\"text\" class=\"txtboxbackcolor\" id=\"txtTotalYards\" size=\"10\" value=\"Pending\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                <td class=\"normalfnt\"><input name=\"xx\"  onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event)\"   /></td>";
				//////////////////////////////////////////////////////////////////////////////////////////
				
				while($row = mysql_fetch_array($result))
				{
					$strSize 	= $row["strSize"];
					$dblQty 	= $row["dblQty"];
					$dblQty1 = (0-$dblQty);
					$strString3 .= " <td width=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">$strSize<br/>$dblQty</td>";
					$strString4	.= " <td  class=\"normalfntRite\"><input name=\"txtTotalYards\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\"   alt=\"$dblQty\" value=\"$dblQty\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onfocus=\"this.blur();\"/></td>";

					//////////////////////////////////////////// FOR 2ND LINE ///////////////////////////////////////
					$x4 .= " <td  class=\"normalfntRite\"><input name=\"txtTotalYards\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\" value=\"$dblQty1\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onfocus=\"this.blur();\"/></td>";
					///////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				}
  $strString5 ="<td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Marker Length YRD </td>
                <td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Marker Length Inch </td>
                <td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">EFF</td>
                <td width=\"7\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Yards </td>
                </tr>";
  $strString6= "<td class=\"normalfnt\"><input name=\"txtMarkerLenghtYrd\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtYrd\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtMarkerLenghtInch\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtInch\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtEff\" type=\"text\" onfocus=\"this.blur();\" class=\"txtbox\" id=\"txtEff\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                </tr>";
				
				////////////////////////////////////// FOR 2ND LINE ///////////////////////////////////////////
				$x6 = "<td class=\"normalfnt\"><input name=\"txtMarkerLenghtYrd\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtYrd\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtMarkerLenghtInch\" onfocus=\"this.blur();\" type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtInch\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>
                <td class=\"normalfnt\"><input name=\"txtEff\" type=\"text\" onfocus=\"this.blur();\" class=\"txtbox\" id=\"txtEff\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>
                <td class=\"normalfnt\"><input name=\"txtTotalYards\" onfocus=\"this.blur();\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"/></td>
                </tr>";
				///////////////////////////////////////////////////////////////////////////////////////////////
				
				$totString = $strString1  . $strString3 . $strString5  .$strString2  .$strString4 .$strString6;
				$totString .= $x2.$x4.$x6;

				echo $totString;
} 

if($id=="getFabricRecieved")
{
	$strStyleId		=$_GET["styleId"];
	$strBuyerPo		= str_replace("***","#",$_GET["strBuyerPo"]);
	$strColor		=$_GET["strColor"];

	$SQL="	SELECT
			sum(dblQty) as dblQty
			FROM grndetails
			WHERE
			grndetails.intStyleId =  '$strStyleId' AND
			grndetails.strBuyerPONO =  '$strBuyerPo' AND
			grndetails.strColor =  '$strColor'";

	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$Total = $row["dblQty"];
	}
	echo $Total;
}



if($id=="getCadListingDetails")
{
		$SearchStyle	= $_GET["SearchStyle"];
		$SearchFabric	= $_GET["SearchFabric"];
		$fromDate		= $_GET["fromDate"];
		$toDate			= $_GET["toDate"];
		$status			= $_GET["status"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<CAD>";
		$SQL=  "SELECT
				cadconsumptionheader.intStyleId,
				cadconsumptionheader.intMatdetailId as MatDetailId,
				matitemlist.strItemDescription as Description,
				cadconsumptionheader.strColor ,
				cadconsumptionheader.dblwidth,
				cadconsumptionheader.dtmDate,
				cadconsumptionheader.strUserId,
				useraccounts.Name
				FROM
				cadconsumptionheader
				Inner Join matitemlist ON matitemlist.intItemSerial = cadconsumptionheader.intMatdetailId
				Inner Join useraccounts ON useraccounts.intUserID = cadconsumptionheader.strUserId
				where cadconsumptionheader.intStatus=$status";
				
				if($SearchStyle!=0)
				{
					$SQL.=" AND cadconsumptionheader.intStyleId='$SearchStyle'";
				}
						
				if($SearchFabric!="")
				{
					$SQL.=" AND cadconsumptionheader.intMatdetailId='$SearchFabric'";
				}

				if($fromDate!="")
				{
					$SQL.=" AND cadconsumptionheader.dtmDate>='$fromDate' ";
				}
				if($toDate!="")
				{
					$SQL.=" AND cadconsumptionheader.dtmDate<='$toDate'";
				}
				
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strStyleId><![CDATA[" . $row["intStyleId"]  . "]]></strStyleId>\n";
				 $ResponseXML .= "<MatDetailId><![CDATA[" . $row["MatDetailId"]  . "]]></MatDetailId>\n"; 
				 $ResponseXML .= "<Description><![CDATA[" . $row["Description"]  . "]]></Description>\n"; 
				 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n"; 
				 $ResponseXML .= "<dblwidth><![CDATA[" . $row["dblwidth"]  . "]]></dblwidth>\n";
				 $ResponseXML .= "<dtmDate><![CDATA[" . substr($row["dtmDate"],0,10)  . "]]></dtmDate>\n";
				 $ResponseXML .= "<strUserId><![CDATA[" . $row["strUserId"]. "]]></strUserId>\n";
				 $ResponseXML .= "<Name><![CDATA[" . $row["Name"]. "]]></Name>\n";
			}
			$ResponseXML .= "</CAD>";
			echo $ResponseXML;
}

if($id=="getHeaderDetails")
{
		$styleid		= $_GET["styleid"];
		$matDetailId	= $_GET["matDetailId"];
		$color			= $_GET["color"];

		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<CAD>";
		$SQL=  "SELECT
				cadconsumptionheader.dblBudgetedPipingConsumption,
				cadconsumptionheader.dblBudgetedConPcs,
				cadconsumptionheader.dblFabricRecievedExpected,
				cadconsumptionheader.dblPipingConsumptionYrd,
				cadconsumptionheader.dblProductionConPcsPercentage,
				cadconsumptionheader.dblProductionConPcsYrd,
				cadconsumptionheader.dblCuttableQtyYrd,
				cadconsumptionheader.dtmDate
				FROM cadconsumptionheader
				WHERE
				cadconsumptionheader.intStyleId =  '$styleid' AND
				cadconsumptionheader.intMatdetailId =  '$matDetailId' AND
				cadconsumptionheader.strColor =  '$color'";
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<dblBudgetedPipingConsumption><![CDATA[" . $row["dblBudgetedPipingConsumption"]  . "]]></dblBudgetedPipingConsumption>\n";
				 $ResponseXML .= "<dblBudgetedConPcs><![CDATA[" . $row["dblBudgetedConPcs"]  . "]]></dblBudgetedConPcs>\n"; 
				 $ResponseXML .= "<dblFabricRecievedExpected><![CDATA[" . $row["dblFabricRecievedExpected"]  . "]]></dblFabricRecievedExpected>\n"; 
				 $ResponseXML .= "<dblPipingConsumptionYrd><![CDATA[" . $row["dblPipingConsumptionYrd"]  . "]]></dblPipingConsumptionYrd>\n"; 
				 $ResponseXML .= "<dblProductionConPcsPercentage><![CDATA[" . $row["dblProductionConPcsPercentage"]  . "]]></dblProductionConPcsPercentage>\n";
				 $ResponseXML .= "<dtmDate><![CDATA[" . substr($row["dtmDate"],0,10)  . "]]></dtmDate>\n";
				 $ResponseXML .= "<dblProductionConPcsYrd><![CDATA[" . $row["dblProductionConPcsYrd"]. "]]></dblProductionConPcsYrd>\n";
				 $ResponseXML .= "<CuttableQtyYrd><![CDATA[" . $row["dblCuttableQtyYrd"]. "]]></CuttableQtyYrd>\n";


			}
			$ResponseXML .= "</CAD>";
			echo $ResponseXML;
}


?>