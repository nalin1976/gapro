<?php
 session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Property Modify</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="wizard.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/autofill.js" type="text/javascript"></script>
<script src="../../javascript/tablednd.js" type="text/javascript"></script>
<script src="organizeCategory.js"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

</head>

<body>
	 <?php
		include "../../Connector.php";
	?>
 <table bgcolor="#FFFFFF" width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
 	<tr>
		<td colspan="2">
			
				<table width="400" id="tblContent"  border="0" bgcolor="#FDC042" cellpadding="0" align="center" >
					
				 <tr>
				  <td  align="left" colspan="4" class="mainHeading" >Property Modify<img align="right" src="../../images/cross.png" width="17" height="17" class="mouseover" onclick="closeWindow();" />
				  </td>
				</tr>
				<tr bgcolor="#FDC042">
				  <td width="250" >Property Name</td>
				  <td width="50">Save</td>
				  <td width="35" >Delete</td>
				  <td width="75" >Edit</td>
				</tr>
				<tr>
				<td colspan="4">
				<div id="divcons" style="overflow:scroll; height:350px; width:420px;">
				<table width="400" id="tblContent"  border="0" bgcolor="#FDC042" cellpadding="0" align="center" >
			  <?php
			  $SQL = "SELECT  intPropertyId,strPropertyName FROM matproperties ORDER BY strPropertyName;";
				
				$result = $db->RunQuery($SQL);
				$pos = 0;
				while($row = mysql_fetch_array($result))
				{
			  		if($row["strPropertyName"]==$_GET["propStr"]){
				?>
						<tr class="<?php echo "bcgcolor-highlighted"; ?>">
				<?php	
					}
					else{
			  ?>
				<tr class="<?php 
						  if ($pos % 2 == 0)
								echo "bcgcolor-tblrow";
							else
								echo "bcgcolor-tblrowWhite";
						   ?>">
				<?php } ?>
				  <td width="*" cellspacing="0"  height="20" class="normalfnt"><div id="<?php echo "div".$row["intPropertyId"]; ?>">&nbsp;<input name="<?php echo $row["intPropertyId"]; ?>"id="<?php echo $row["intPropertyId"]; ?>" style="width:250px" height="25" value="<?php echo $row["strPropertyName"];  ?>" type="text" class="txtboxRightAllign" disabled="disabled" maxlength="50" /></div></td>
				  <?php
				  		$sql1="select count(intPropertyId) as num from matpropertyassign where intPropertyId='".$row["intPropertyId"]."';";
		
						$result1 = $db->RunQuery($sql1);	
								
						if($row1 = mysql_fetch_array($result1)){
							if($row1["num"]>0){
				  ?>
				  				<td width="50" align="center">&nbsp;</td>
				  			<?php } else { ?>
									<td width="50" align="center"><img src="../../images/del.png" width="15" alt="Delete" height="15" onclick="delProperty('<?php echo $row["intPropertyId"]; ?>','<?php echo $row["strPropertyName"]; ?>');" /></td>
							<?php } ?>
				  <?php } ?>
				  <td width="50" align="center"><img src="../../images/edit.png" width="15" alt="Edit" height="15" onclick="editProperty('<?php echo $row["intPropertyId"]; ?>','<?php echo $row["strPropertyName"]; ?>');" /></td>					  			 
				</tr>
			<?php					
					$pos ++;
				}
			?>
			</table>
			</div>
			</td>
			</tr>
				<tr>
				  <td height="32" class="mbari13" colspan="4" ><table width="100%" border="0">
					  <tr>
						<td width="100%" align="center"><img onclick="closeWindow();" src="../../images/close.png" alt="Close" width="97" height="24" border="0" class="mouseover" /></td>						
					  </tr>
				  </table></td>
				</tr>
			  </table>
			
		</td>
	</tr>
  </table>
</body>
</html>
