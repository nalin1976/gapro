<?php
session_start();
include "Connector.php";
$styleID = $_GET["styleID"];
?>

<html>
<head>
	<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="javascript/script.js"></script>
</head>
<body style="background-color:#D6E7F5;">
	<table width="650" border="0"  bgcolor="#D6E7F5">
		<tr class="cursercross" onMouseDown="grab(document.getElementById('frmSubContract'),event);">		
			<td colspan="4">
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr bgcolor="#498CC2" class="TitleN2white">
						<td>Sub Contractors For the Style - <?php
						echo $styleID;
							
						?></td>		
						<td style="text-align:right;"><img src="images/cross.png" class="mouseover" onClick="closeWindow();" ></td>			
					</tr>
				</table>			
			</td>		
		</tr>	
		<tr>
			<td width="15%" height="30" class="normalfnt">Style : </td>	
			<td width="35%" class="normalfnt"><?php echo $styleID; ?></td>	
			<td width="15%" class="normalfnt">Buyer PO </td>	
			<td width="35%" class="normalfnt"><select class="txtbox" id="subContractBuyerPO" style="width:150px;" onChange="showBuyerPOWiseQuantity();" >
			 <option value="-1" selected="selected">Select One</option>
			<?php
			//$sql = "SELECT DISTINCT strBuyerPONO  FROM styleratio WHERE intStyleId = '$styleID';";
			$sql = "SELECT strBuyerPONO, ROUND(SUM(dblExQty)) AS bpoQty  FROM styleratio WHERE intStyleId = '$styleID'  GROUP BY strBuyerPONO";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["bpoQty"] ."\">" . $row["strBuyerPONO"] ."</option>" ;
								
			}
			?>			
			</select></td>		
		</tr>
		<tr>
			<td width="15%" height="30" class="normalfnt">Quantity : </td>	
			<td width="35%" class="normalfnt" id="bpoQty"></td>	
			<td colspan="2" class="normalfnt"><div style="visibility:hidden;"><select class="txtbox" style="width:200px;" id="cboContractors" style="width:150px;" >
			 <option value="-1" selected="selected">Select One</option>
			<?php
			$sql = "SELECT intSubContractorID,strName FROM subcontractors;";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intSubContractorID"] ."\">" . $row["strName"] ."</option>" ;
								
			}
			?>			
			</select></div></td>		
		</tr>
		<tr>
      <td height="99" colspan="4" valign="top">
      <table  width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#9BBFDD"><div align="left" class="normalfnth2">Sub Contractors</div></td>
          <td height="20" bgcolor="#9BBFDD"><div align="right"><img src="images/add-new.png" onClick="AddSubContractor();" width="109" height="18" border="0" class="mouseover" /></div></td>
        </tr>
        </table>
        <div style="overflow:scroll; height:220px; width:650px;background-color:#FFFFFF;">
        <table id="tblContractors"  bgcolor="#CCCCFF" width="100%" cellpadding="0" cellspacing="1">
        <tr>
        	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
          <td width="45%" height="24" bgcolor="#498CC2" class="normaltxtmidb2">Sub Contractor</td>
          <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
          <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
          <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Del. Date</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2">Quantity</td>
        </tr>
       </div>
      </table></td>
    </tr>
    <tr>
			<td height="30" class="normalfnt"></td>	
			<td class="normalfnt"></td>	
			<td class="normalfnt"></td>	
			<td class="normalfnt"><div align="right">
			<table>
				<tr>
					<td><img src="images/save.png" class="mouseover" onClick="SaveSubContractorDetails();"  ></td>
					<td><img src="images/cancel.jpg" class="mouseover" onClick="closeWindow();"></td>				
				</tr>			
			</table>	</div>		
			</td>		
		</tr>
	</table>
</body>
</html>