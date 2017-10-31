<?php
$backwardseperator = "../../";
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Quality</title>

<link href="../../css/JqueryTabs.css" rel="stylesheet" type="text/css" />
<script src="QualityButton.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.normalfontBold {
		font-family: Verdana;
		font-size: 11px;
		color: #000000;
		margin: 0px;
		font-weight: bold;
		text-align:center;
	}
</style>

</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmQuality" name="frmQuality" method="post">
	<tr>
    	<td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
	<tr>
	<tr>
		<td>&nbsp;</td>
		</tr>
	<table width="653" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
		<td align="center">
			<table width="653" align="center" border="0" class="bcgl1">
				<tr>
					<td width="645" class="mainHeading">
						<table align="center" border="0">
							<tr>
								<td>Quality</td>
							</tr>
						</table>
				  </td>
				</tr>
		  </table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="653" align="center" border="0" bgcolor="#FFFFFF">
	 <tr>
        <td height="7" colspan="3">&nbsp;</td>
     </tr>
	<tr>
		<td width="53">&nbsp;</td>
		<td width="157" class="normalfnt">Qualities</td>
		<td width="302" align="left">
			<select name="cboQuality" onchange="ShowQualityDetails();"class="txtbox" id="cboQuality" style="width:150px" tabindex="1">
			 <?php
					  $SQL="SELECT * FROM quality  order by strQuality";
					
					
						$result = $db->RunQuery($SQL);
						
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intQualityId"] ."\">" . $row["strQuality"] ."</option>" ;
						}  
			?></select>
	  </td>
	</tr>
	<tr>
		<td width="53">&nbsp;</td>
		<td width="157" class="normalfnt">Quality Code <span class="compulsoryRed">*</span></td>
		<td width="302" align="left">
			<input name="txtQualityCd" id="txtQualityCd" class="txtbox" style="width:150px;" tabindex="2" type="text" maxlength="10" />
	  </td>
	</tr>
	<tr>
		<td width="53">&nbsp;</td>
		<td width="157" class="normalfnt">Quality <span class="compulsoryRed">*</span></td>
		<td width="302" align="left">
			<input name="txtQuality" id="txtQuality" class="txtbox" style="width:300px;" tabindex="3" type="text" maxlength="50" />
	  </td>
	</tr>
	<tr>
		<td width="53">&nbsp;</td>
		<td width="157" class="normalfnt">Remarks</td>
		<td width="302" align="left">
			<textarea style="width:300px;" name="txtRemarks" id="txtRemarks" tabindex="4"></textarea>
	  </td>
	</tr>
	<tr>
		<td width="53">&nbsp;</td>
		<td width="157" class="normalfnt">Active</td>
		<td width="302" align="left">
			<input type="checkbox" checked="checked" id="chkActive" name="chkActive" tabindex="5" /> 
	  </td>
	</tr>
	</table>
	</td>
	</tr>
	 <tr>
         <td height="21" colspan="5">
            <table width="653" align="center" border="0" class="tableFooter">
              <tr>
			  	  <td width="120">&nbsp;</td>  
                  <td width="96"><img src="../../images/new.png" name="butNew" id="butNew" onclick="ClearForm();"  class="mouseover" tabindex="10"/>				  
				  </td>
                  <td width="84"><img src="../../images/save.png" alt="Save" name="butSave" id="butSave" class="mouseover" onclick="qualityValidation();" tabindex="6"/>				  
				  </td>
                  <td width="100"><img src="../../images/delete.png" alt="Save" name="butSave" id="butSave" class="mouseover" onclick="ConfirmDelete();" tabindex="7"/>				 
				  </td>
                  <td width="108"><img src="../../images/report.png" alt="Save" name="butSave" id="butSave" class="mouseover" onclick="loadReport();" tabindex="8"/>
				  </td>
                <td width="117"><a href="../../main.php"><img src="../../images/close.png" name="butClose" border="0" id="butClose" /></a>
				</td> 
				<td width="53">&nbsp;</td>    
              </tr>
               </table>             
			   </td>
          </tr>
		  </tr>
</table> 
</form>
</body>
</html>