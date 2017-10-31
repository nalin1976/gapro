<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Departments</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmDepartment" name="frmDepartment" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator."Header.php";?></td>
  </tr>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Departments<span class="vol">(Ver 0.3)</span><span id="department_popup_close_button"></span></div>
	</div>
	<div class="main_body">
	<table width="550" border="0" align="center">
      <tr>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="64%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="10%" rowspan="5" class="normalfnt">&nbsp;</td>
                  <td width="26%" height="11" class="normalfnt">Department</td>
                  <td><select name="cbodepartment" class="txtbox" id="cbodepartment" onchange="getDepartmentDetails();"style="width:150px" tabindex="1">
				  <?php
	$SQL="SELECT * FROM department WHERE intStatus <> 10 order by strDepartment ASC";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". cdata($row["intDepID"]) ."\">" . cdata($row["strDepartment"]) ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
                </tr>
                <tr>
                  <td height="12" class="normalfnt">Department Code&nbsp;<span class="compulsoryRed">*</span></td>
                  <td><input name="txtDepCode" type="text" class="txtbox" style="width:148px"  id="txtDepCode" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"/></td>
                </tr>
                <tr>
                  <td width="23%" height="13" class="normalfnt">Department Name&nbsp;<span class="compulsoryRed">*</span></td>
                  <td><input name="txtDepartment" type="text" class="txtbox" id="txtDepartment" style="width:280px" maxlength="50" tabindex="3"/></td>
                </tr>
				
                <tr>
                  <td width="23%" height="21" valign="top" class="normalfnt">Remarks</td>
                  <td >
				    <textarea style="width:280px" onchange="imposeMaxValue(this,200);" name="txtRemarks"  rows="2" class="txtbox" id="txtRemarks" onkeypress="return imposeMaxLength(this,event, 200);"  tabindex="4" ></textarea>				  </td>
                </tr>
				<!--<tr>
                  <td colspan="2" height="21" valign="top" class="normalfnt">&nbsp;</td>
                </tr>-->
				<tr>
				  <td  class="normalfnt">Company Name&nbsp;<span class="compulsoryRed">*</span></td>
				  <td><select name="cmbCompany" id="cmbCompany" class="txtbox" style="width:282px;" tabindex="5">
                  <?php 
				  	$SQL = " 	SELECT
								companies.intCompanyID,
								companies.strName,
								usercompany.userId
								FROM
								companies
								Inner Join usercompany ON usercompany.companyId = companies.intCompanyID
								WHERE
								usercompany.userId =  '".$_SESSION['UserID']."' AND
								companies.intStatus =1";
					$result = $db->RunQuery($SQL);	
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". cdata($row["intCompanyID"]) ."\">" . cdata($row["strName"]) ."</option>" ;
	}		  
				  ?>
				    </select>				  </td>
				  </tr>
				<tr>
					<td width="13%" class="normalfnt">&nbsp;</td>
                  
                      <td width="23%"  class="normalfnt">Active</td>
                      <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked"  tabindex="6"/></td>
                    </tr>                
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="10%">&nbsp;</td>
                      <td ><img src="../../images/new.png" alt="New" name="New" id="butNew"
					  width="96" height="24" onclick="ClearForm();" class="mouseover"  tabindex="11"/></td>
                      <td ><img src="../../images/save.png" alt="Save" name="Save" id="butSave" width="84" height="24" onclick="butCommand(this.name)" class="mouseover"  tabindex="7"/></td>
                      <td ><img src="../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)" class="mouseover" id="butDelete"  tabindex="8"/></td>
					  					  				  					  					                     <td class="normalfnt"><img src="../../images/report.png" alt="Report" id="butReport" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  tabindex="9"  /></td>
                      <td ><a href="../../main.php"><img src="../../images/close.png" alt="Close" id="butClose" name="Close" width="97" height="24" border="0"   tabindex="10"/></a></td>
                      <td width="15%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
</tr>
</div>
</div>

</form>
</body>
</html>
