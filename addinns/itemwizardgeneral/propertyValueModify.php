<?php
 session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Property Value Modify</title>

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
				  <td  align="left" colspan="4" class="mainHeading">Property Value Modify<img align="right" src="../../images/cross.png" width="17" height="17" class="mouseover" onClick="closeLayer1();" /></td>
				</tr>
				<tr bgcolor="#FDC042">
				  <td width="250" >Value</td>
				  <td width="50">Save</td>
				  <td width="35" >Delete</td>
				  <td width="75" >Edit</td>
				</tr>
				<tr>
				<td colspan="4">
				<div id="divcons" style="overflow:scroll; height:350px; width:420px;">
				<table width="400" id="tblContent"  border="0" bgcolor="#FDC042" cellpadding="0" align="center" >
			  <?php
			  $SQL = "SELECT  intSubPropertyNo,strSubPropertyName FROM matpropertyvalues ORDER BY strSubPropertyName;";
				
				$result = $db->RunQuery($SQL);
				$pos = 0;
				while($row = mysql_fetch_array($result))
				{
			  		if($row["strSubPropertyName"]==$_GET["propValStr"]){
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
				  <td width="*" cellspacing="0"  height="20" class="normalfnt"><div id="<?php echo "div".$row["intSubPropertyNo"]; ?>">&nbsp;<input name="<?php echo $row["intSubPropertyNo"]; ?>"id="<?php echo $row["intSubPropertyNo"]; ?>" height="25" style="width:250px" value="<?php echo $row["strSubPropertyName"];  ?>" type="text" class="txtboxRightAllign" disabled="disabled" maxlength="45" /></div></td>
				  <?php
				  		//$sql1="select count(intSubPropertyNo) as num from matsubpropertyassign where intSubPropertyNo='".$row["intSubPropertyNo"]."';";
						$sql1 = "select intMatItemSerial from matpropertyvaluesinitems
						 Inner Join matitemlist ON matitemlist.intItemSerial = matpropertyvaluesinitems.intMatItemSerial
						 where intMatPropertyValueId='".$row["intSubPropertyNo"]."' and matitemlist.intStatus=1";
						//echo $sql1;
						$result1 = $db->RunQuery($sql1);	
						$have = false;
						$alreadyItems ;
						while($row1=mysql_fetch_array($result1))
						{
							$have = true;
							$alreadyItems = $alreadyItems ." , ".$row["intSubPropertyNo"];
						}
						
						if($have)
						{
							
				 			?>
				  				<td width="50" align="center">&nbsp;</td>
								<td width="50" align="center">&nbsp;</td>
				  			<?php 
						}
						 else 
						{ 
						?>
									<td width="50" align="center"><img src="../../images/del.png" width="15" alt="Delete" height="15" onclick="delPropertyValue('<?php echo $row["intSubPropertyNo"]; ?>','<?php echo $row["strSubPropertyName"]; ?>');" /></td>

				  <td width="50" align="center"><img src="../../images/edit.png" width="15" alt="Edit" height="15" onclick="editPropertyValue('<?php echo $row["intSubPropertyNo"]; ?>','<?php echo $row["strSubPropertyName"]; ?>');" /></td>		
				  
				  	     <?php
						 } 
						 ?>			  			 
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
				  <td height="32" colspan="4" class="mbari13"><table width="100%" border="0">
					  <tr>
						<td width="100%" align="right"><img onClick="closeLayer1();" src="../../images/close.png" alt="Close" width="97" height="24" border="0" class="mouseover" /></td>						
					  </tr>
				  </table></td>
				</tr>
			  </table>
			</div>
		</td>
	</tr>
  </table>
</body>
</html>
