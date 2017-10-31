<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operation Selection</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../javascript/script.js"></script>


</head>

<body>

<?php
include "../../Connector.php";

?>
 

		
	<table align="center" width="100%"   bgcolor="#FFFFFF">
		<tr><td align="right" colspan="3"><img src="../../images/closelabel.gif" onclick="closePopup2();" style="width:40px;" /></td></tr>
		<tr class="cursercross" onmousedown="grab(document.getElementById('frmOpBox'),event);">
         	<td height="35"  bgcolor="#498CC2" class="TitleN2white" colspan="3">Operations</td>
        </tr>
		
		<tr><td>
		
<div id="divcons" class="main_border_line" style="overflow:scroll; height:auto; width:380px;">		<table>
		
		<tr style="display:none">
		<td colspan="1" class="operation_header" id="td_coHeader">Back </td>
		<td id="td_coDelete">&nbsp;</td>
		<td><input name="popup_close_button" type="button" value="Close" id="popup_close_button" /></td>
		</tr>
		<?php
		$styleNo = $_GET['styleNo'];
		$side    = $_GET['side'];
		$rowId	 = $_GET['rowid'];
		
		$SQL = "SELECT
				ws_operationbreakdowndetails.strStyleID,
				ws_operationbreakdowndetails.intOperationID AS opID,
				ws_operations.intStatus,
				components.intComponentId,
				ws_operations.intComponent,
				components.strComponent AS strComponent,
				ws_operations.strOperation AS strOperation
				FROM ws_operationbreakdowndetails 
				INNER JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID 
				INNER JOIN components ON components.intComponentId = ws_operations.intComponent
				WHERE ws_operationbreakdowndetails.strStyleID = '$styleNo' order by strComponent asc";
		 //echo $SQL;
		$result = $db->RunQuery($SQL);	 
		$strComponent = "";
		while($row = mysql_fetch_array($result))
		{
				if($strComponent == "" || ($strComponent != $row['strComponent']) )	{
					echo "<tr><td colspan=\"3\" class=\"operation_header\">".$row['strComponent']."</td></tr>";
				}
				 
				echo "<tr onMouseOver=\"this.style.backgroundColor='#FF9797'\" onMouseOut=\"this.style.backgroundColor='#FFFFFF'\" bgcolor=\"#FFFFFF\" ><td width=\"10%\">*</td>
					  <td width=\"33%\" class=\"normalfnt\" colspan=\"2\"><a href=\"#\" 
					  onclick=\"addRowintoOperationLayoutSheet('".$rowId."','".$styleNo."','".$row['opID']."',".$side.");\">".$row['strOperation']."</a></td>
					  </tr>";				 
				$strComponent = $row['strComponent']; 
				/* assign component string <td width=\"57%\">
				 <img  src=\"../../images/addmark.png\" onclick=\"addRowintoOperationLayoutSheet(".$rowId.",".$styleNo.",".$row['opID'].",".$side.");\" /></td>	 */			 
		} 		
		?>
		
		
</table>
		</div>
</td></tr>		
		
		
		
		
	</table>

	
</body>
</html>
