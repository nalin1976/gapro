<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function A(){
if(document.getElementById("shipingagents_cboCustomer").value!="")
document.getElementById("shipingagents_txtAddress1").focus();

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shipping Agents</title>
<link href="file:///C|/Inetpub/wwwroot/css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<!--<script src="button.js"></script>
<script src="Search.js"></script>-->
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="Button.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmshipingag" name="frmshipingag" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498cc2" class="mainHeading">Shipping Agents</td>
          </tr>
          <tr>
            <td height="96" align="center">
              <table width="90%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="3" class="normalfnt">
                  <table width="100%" border="0">
                  	<tr>
                    	<td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td width="13" class="normalfnt">&nbsp;</td>
                    	<td class="normalfnt">Search</td>
                  <td colspan="5"><select name="shipingagents_cboCustomer" class="txtbox"  onchange="getAgentDetails();" style="width:320px" id="shipingagents_cboCustomer">
							<?php
	
	$SQL = "SELECT intAgentId,strName FROM shipping_agents where intStatus<>10 order by strName ASC";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intAgentId"] ."\">" . $row["strName"] ."</option>" ;
		
	}
	
	?>
                  </select></td>
                    </tr>
                    <tr>
                    	<td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="13" class="normalfnt">&nbsp;</td>
                      <td width="119" class="normalfnt">Name</td>
                      <td colspan="3"><input name="shipingagents_txtName" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="shipingagents_txtName"  style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="3"><input name="shipingagents_txtAddress1" type="text" class="txtbox" id="shipingagents_txtAddress1" style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="shipingagents_txtAddress2" type="text" class="txtbox" id="shipingagents_txtAddress2"  style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Street</td>
                      <td colspan="3"><input name="shipingagents_txtStreet" type="text" class="txtbox" id="shipingagents_txtStreet" style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">City</td>
                      <td  style="width:120px"><input name="shipingagents_txtCity" type="text" class="txtbox" id="shipingagents_txtCity" style="width:120px"/></td>
                      <td style="width:70px">State</td>
                      <td colspan="2" ><input name="shipingagents_txtState" type="text" class="txtbox" id="shipingagents_txtState" style="width:120px"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country</td>
                      <td><select name="shipingagents_txtCountry" class="txtbox" id="shipingagents_txtCountry" style="width:100px">
                        <?php
			$SQL="SELECT country.strCountry,country.strCountryCode FROM country WHERE (((country.intStatus)=1));";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
	if($cboCountry==$row["strCountry"]){
	echo "<option value=\"". $row["strCountry"] ."\" selected=\""."selected"."\">" . $row["strCountry"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["strCountry"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	}
		  
					?>
                      </select>
                        <img  src="../../images/add.png" width="16" height="16" onclick="showCountryPopUpp()" /></td>
                      <td style="width:70px">Zip Code</td>
                      <td colspan="2"><input name="shipingagents_txtZipCode" type="text" class="txtbox" id="shipingagents_txtZipCode" style="width:120px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Phone</td>
                      <td><input name="shipingagents_txtPhone" type="text" class="txtbox" id="shipingagents_txtPhone" style="width:120px"  onkeypress="return CheckforValidDecimal(this.value, 0,event);"/></td>
                      <td style="width:70px">Fax</td>
                      <td colspan="2"><input name="shipingagents_txtFax" type="text" class="txtbox" id="shipingagents_txtFax" style="width:120px" onkeypress="return CheckforValidDecimal(this.value, 0,event);" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td colspan="3"><input name="shipingagents_txtEmail" type="text" class="txtbox" id="shipingagents_txtEmail" style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Web</td>
                      <td colspan="3"><input name="shipingagents_txtWeb" type="text" class="txtbox" id="shipingagents_txtWeb" style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Contact Person </td>
                      <td colspan="3"><input name="shipingagents_txtcontactper" type="text" class="txtbox" id="shipingagents_txtcontactper" style="width:320px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="3"><input name="shipingagents_txtRemarks" type="text" class="txtbox" id="shipingagents_txtRemarks" style="width:320px"/></td>
                    </tr>
					<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td colspan="3"><input type="checkbox" name="shipingagents_chkActive" id="shipingagents_chkActive" checked="checked" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""  align="center" class="tableFooter">
                <table width="80%" border="0" >
                    <tr>
                      <td>&nbsp;</td>
					  <td><img src="../../images/new.png" alt="New" name="New" onClick="clearFields();"/></td>
                      <td><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onClick="butCommand(this.name)"/></td>
                      <td><img src="../../images/delete.png" alt="Delete" width="100" height="24" name="Delete" onClick="ConfirmDelete(this.name);"/></td>
					  <td class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="listORDetails();"  /></td>
                      <td><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td>&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="left:575px; top:450px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReport();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>
</body>
</html>
