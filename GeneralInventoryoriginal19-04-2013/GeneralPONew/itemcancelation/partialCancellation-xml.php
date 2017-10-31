<?php

include "../../../Connector.php";
		
$id=$_GET["id"];

if($id=="getPoDetails")
{
	$poNo=$_GET["poNo"];
	$year=$_GET["year"];
	
	$SQL="	SELECT
			concat(PD.intPRYear,'/',PD.intPRNo)as prNo,
			PD.intMatDetailID,
			MIL.strItemDescription,
			PD.strRemarks,
			PD.dblUnitPrice,
			PD.dblPending
			FROM
			generalpurchaseorderdetails PD
			Inner Join generalpurchaseorderheader PH ON PH.intGenPONo = PD.intGenPoNo AND PH.intYear = PD.intYear
			Inner Join genmatitemlist MIL ON MIL.intItemSerial = PD.intMatDetailID			
			WHERE
			PD.intYear =  '$year' AND
			PD.intGenPoNo =  '$poNo' AND
			PD.dblPending >  '0' 	";		
			
			$result = $db->RunQuery($SQL);
				
			$header = " <tr>
              <td width=\"4%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\" height=\"22\">Del</td>
			  <td width=\"16%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\">PR No</td>
              <td width=\"19%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\">Description</td>
			  <td width=\"11%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\">Remarks </td>
              <td width=\"8%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\">Unit Price </td>
              <td width=\"8%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\">Qty</td>
              <td width=\"8%\" bgcolor=\"#804000\" class=\"normaltxtmidb2\">Value</td>
            </tr>";
				while($row = mysql_fetch_array($result))
				{
					$qty = (float)$row["dblPending"];
					$unitPrice = number_format((float)$row["dblUnitPrice"],2);
					$value = number_format(($unitPrice * (float)$row["dblPending"]),2);
					$styleID = $row["intStyleId"];
					$tableString .= "
					<tr id=\"".$row["intMatDetailID"]."\" >
				<td height=\"18\" bgcolor=\"#FFFFFF\">

				<div align=\"center\"><input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" onclick=\"rowclickColorChange(this);\" />
				</div>
				</td>
				<td bgcolor=\"#FFFFFF\" class=\"normalfnt\">".$row["prNo"]."</td>
				<td bgcolor=\"#FFFFFF\" class=\"normalfnt\">".$row["strItemDescription"]."</td>
				<td bgcolor=\"#FFFFFF\" class=\"normalfnt\">".$row["strRemarks"]."</td>
				<td bgcolor=\"#FFFFFF\" class=\"normalfntRite\">".$unitPrice."</td>
				<td bgcolor=\"#FFFFFF\" class=\"normalfnt\"><input name=\"txtQty\" type=\"text\" class=\"txtbox\" id=\"$qty\" size=\"10\" value='$qty' style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal2(this, 4,event);\" onkeyup=\"validNum(this);\" /></td>
				<td bgcolor=\"#FFFFFF\" class=\"normalfntRite\" >$value</td>
			</tr>
					
					";
				}
				echo $header.$tableString;
} 

if($id=="getPONo")
{
	
	$year=$_GET["intYear"];
	
	$SQL = 	"SELECT intPONo,intYear  FROM     purchaseorderheader
							WHERE (intStatus = 10) AND (intUserId = ".$_SESSION["UserID"].") 
							and (intYear='$year') ";
							
					
			
					$str .= "<option value=\"". "" ."\">" . "" ."</option>" ;
					
					$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
				{
					$str .= "<option value=\"". $row["intPONo"] ."\">" . trim($row["intPONo"]) ."</option>";
				}
				
				echo $str;
}
?>