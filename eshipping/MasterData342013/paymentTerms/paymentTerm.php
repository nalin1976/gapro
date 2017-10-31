<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web | Payment Term</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->


</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="paymentTerm.js"></script>
</head>
<body onload="focusTextBox();">
<?php
	include "../../Connector.php";	
?>

<form id="frmContainer" name="frmContainer" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
	<td><table width="100%" border="0">
		<tr>
			<td>
			  <table width="500" border="0" class="bcgl1" align="center">
			    <tr>
			      <td height="30" bgcolor="#588DE7" class="TitleN2white" align="center">Payment Term</td>
			      </tr>
			    <tr bgcolor="#FFFFFF">
			      <td ><table width="100%" border="0" cellpadding="2" cellspacing="10">
			        
			          <tr>
			            <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Term &nbsp;<span class="compulsory">*</span> </td>
			                <td width="44%" class="normalfnt">
							<input name="txtTerms" id="txtTerms" style="width:130px" class="txtbox" type="text" tabindex="1" />
			                  </td>
			                <td width="15%" class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td width="9%" class="normalfnt">&nbsp;</td>
			                <td width="32%" class="normalfnt">&nbsp;Term Description &nbsp;</td>
			                <td class="normalfnt"><input name="txtDescription" id="txtDescription" style="width:130px" class="txtbox" type="text" tabindex="1" /></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
									             
		                </table></td>
		              </tr>
			        <tr>
			          <td>
					  	<table width="100%" border="0" cellpadding="2" cellspacing="10">
			        
			          <tr>
			            <td align="center"><div id="divcons" style="overflow:scroll; height:130px; width:600px;">
                                  <table width="100%" cellpadding="0" cellspacing="1" class='normalfnt'  id="tbl_paymentTerm">
                                    <tr>
									<td width="11%" height="16" bgcolor="#498CC2" class="normaltxtmidb2" >Del</td>
									<td width="11%" bgcolor="#498CC2" class="normaltxtmidb2" >Edit</td>
									<td width="14%" bgcolor="#498CC2" class="normaltxtmidb2" >Id</td>
                                    <td width="29%" bgcolor="#498CC2" class="normaltxtmidb2" >Term </td>
									<td width="35%" bgcolor="#498CC2" class="normaltxtmidb2" >Description</td>  
									  
								    </tr>
									
									<?php
										$SQL="SELECT intPaymentTermId,strPaymentTerm,strDescription	FROM paymentterm WHERE intStatus=1;";
										$result = $db->RunQuery($SQL);
										$i=1;
										while($row = mysql_fetch_array($result))
									{
										$id=$row['intPaymentTermId'];
										$term=$row['strPaymentTerm'];
										$desc=$row['strDescription'];
									?>
									<tr>
										<td align="center"><img src="../../images/del.png" id="<?php echo $i; ?>" onclick="deleteRow(this)" /></td>
										<td align="center"><img src="../../images/edit.png" id="<?php echo $i; ?>" onclick="editRow(this)" />
										</td>
										<td class="normalfntMid"><?php echo $row['intPaymentTermId']; ?></td>
										<td class="normalfntMid"><?php echo $row['strPaymentTerm']; ?>
										</td>
										<td class="normalfntMid"><?php echo $row['strDescription']; ?>
										</td>
									</tr>
									<?php
									 $i++;   									
									}	
									?>
   
									
									
									  </table>
									  </div></td>
		              </tr>
			        <tr>
			          <td></td>
			          </tr>
			        </table>
					  </td>
			          </tr>
			        </table></td>
		        </tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			    <tr>
			      <td height="34" colspan="2"><table width="100%" border="0" class="bcgl1">
			        <tr>
			          <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
			            <tr>
			              
			              <td align="center"><img src="../../images/new.png" id="btnNew" class="mouseover" name="btnNew" tabindex="7" onclick="clearForm();" /><img src="../../images/save.png" alt="Save" width="84" height="24" name="btnSave" id="btnSave"  class="mouseover" onclick="validateData();" tabindex="6" /><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" tabindex="8"/></a></td>
			              </tr>
			            
			            </table></td>
			          </tr>
			        </table>
		          </td>
		        </tr>
		      </table>		    </td>
		  </tr>
	</table>
	</td>
</tr>
</table>
</form>
</body>
</html>
