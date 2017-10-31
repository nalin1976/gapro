<?php
$backwardseperator = "../../";
session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subcontractor</title>

<link href="../../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<script type="text/javascript" src="java.js" ></script>
<script src="../../javascript/script.js"></script>
</head>

<body >
<?php
	include "../../Connector.php";
?>
<form id="frmSubContranctors" name="frmSubContranctors" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator."Header.php";?></td>
  </tr>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Subcontractors<span class="vol">(Ver 0.3)</span><span id="subcontractor_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="700" border="0" class="tableBorder" cellspacing="0" cellpadding="3">

          <tr>
            <td height="96" align="center">
              <table width="79%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="3" class="normalfnt">
                  <table width="87%" border="0">
                  <tr>
                  	<td colspan="7">&nbsp;</td>
                  </tr>
                  	<tr>
                    	<td width="1" class="normalfnt">&nbsp;</td>
                      	<td width="136" class="normalfnt">Search</td>
                  <td colspan="5"> <select name="subcontractor_cboSearch" class="txtbox" id="subcontractor_cboSearch" tabindex="1" style="width:320px" onchange="getSubContractors()">
	<?php
	echo "<option value=\"". $row["strSubContractorID"] ."\"></option>" ;
	$SQL = "SELECT strSubContractorID, strName FROM subcontractors where intStatus<>10 order by strName ASC";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strSubContractorID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                  </select></td>
                    </tr>
                    <tr>
                    	<td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="1" class="normalfnt">&nbsp;</td>
                      <td width="136" class="normalfnt">Name  <span class="compulsoryRed">*</span></td>
                      <td colspan="5"><input name="subcontractor_txtName"  type="text" class="txtNum" id="subcontractor_txtName" style="width:320px" maxlength="50" tabindex="2"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="5"><input name="subcontractor_txtAddress1" type="text" class="txtbox" id="subcontractor_txtAddress1" style="width:320px" maxlength="50"  tabindex="3"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Street</td>
                      <td colspan="5"><input name="subcontractor_txtStreet" type="text" class="txtbox" id="subcontractor_txtStreet" style="width:320px" maxlength="50" tabindex="4" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">City</td>
                      <td ><input name="subcontractor_txtCity" type="text" class="txtbox" id="subcontractor_txtCity" style="width:120px" maxlength="50" tabindex="5"/></td>
                      <td style="width:70px">State</td>
                      <td colspan="2"><input name="subcontractor_txtState" type="text" class="txtbox" id="subcontractor_txtState" style="width:120px" maxlength="15" tabindex="6" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country</td>
                      <td><select name="subcontractor_txtCountry" class="txtbox" id="subcontractor_txtCountry" style="width:100px" tabindex="7" onchange="GetSubContractZipCode(this.value);">
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
                      </select>                        <img  src="../../images/add.png" width="16" height="16" align="absmiddle" class="mouseover" onclick="showCountryPopUpp()" /></td>
                      <td style="width:70px">Zip Code</td>
                      <td colspan="2"><input name="subcontractor_txtZipCode" type="text" class="txtbox" id="subcontractor_txtZipCode" style="width:120px" maxlength="10" tabindex="8" readonly=""/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Phone</td>
                      <td><input name="subcontractor_txtPhone" type="text" class="txtbox" id="subcontractor_txtPhone" style="width:120px"  maxlength="50" tabindex="9"/></td>
                      <td style="width:70px">Fax</td>
                      <td colspan="2"><input name="subcontractor_txtFax" type="text" class="txtbox" id="subcontractor_txtFax" style="width:120px"  maxlength="50" tabindex="10"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td colspan="4"><input name="subcontractor_txtEmail" type="text" class="txtbox" id="subcontractor_txtEmail" style="width:320px" maxlength="50" tabindex="11"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Web</td>
                      <td colspan="4"><input name="subcontractor_txtWeb" type="text" class="txtbox" id="subcontractor_txtWeb" style="width:320px" maxlength="50" tabindex="12"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt" >Contact Person</td>
                      <td colspan="4">
                        <input name="subcontractor_txtContactPerson" type="text" class="txtbox" id="subcontractor_txtContactPerson" style="width:320px" maxlength="50" tabindex="13"/>                     </td>
                    </tr>
                    <tr>
                     <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Contact Person Phone</td>
                      <td width="122"><input name="subcontractor_txtContPhone" type="text" class="txtbox" id="subcontractor_txtContPhone" style="width:120px" maxlength="50" tabindex="14"/></td>
                      <td style="width:70px"> VAT Reg No</td>
                      <td colspan="2"><input name="subcontractor_txtVatNo" type="text" class="txtbox" id="subcontractor_txtVatNo" style="width:120px" maxlength="20" tabindex="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="4">
					  
					  <textarea style="width:320px" onchange="imposeMaxValue(this,200);" name="subcontractor_txtRemarks"  rows="2" class="txtbox" id="subcontractor_txtRemarks" onkeypress="return imposeMaxLength(this,event, 200);"  tabindex="16" ></textarea>					  </td>
                    </tr>
					<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td colspan="4" align="left"><input type="checkbox" name="subcontractor_chkActive" id="subcontractor_chkActive" checked="checked" tabindex="17"/></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="4"><span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td bgcolor="" align="center" class="tableFooter">
                <table width="200" border="0" style="border:none;" >
                    <tr>
                      <td>&nbsp;</td>
                      <td><img id="butNew" src="../../images/new.png" alt="New" name="New" width="96" height="24" class="mouseover" onclick="clearFields();"  tabindex="22" /></td>
                      <td><img src="../../images/save.png" id="butSave" alt="Save" name="Save" width="84" height="24" class="mouseover" onclick="savecontractor(this.name)" tabindex="18"/></td>
                      <td><img src="../../images/delete.png" id="butDelete"  alt="delete" name="Delete" width="100" height="24" class="mouseover" onclick="ConformSCDelete(this.name)"  tabindex="19" /></td>
					  <td class="normalfnt"><img id="butReport" src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="listORDetails();"  tabindex="20"  /></td>
                      <td><a href="../../main.php"><img id="butClose" src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" class="mouseover"  tabindex="21"/></a></td>
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
</div>
</div>
<div style="left:590px; top:470px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="load_SC_Report();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="load_SC_Report();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>
</body>
</html>
