<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | GL Allocation for Supplier</title>




<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="GLAllocationforSuppliers.js">

</script>
<script language="javascript" src="../../javascript/jquery.js">

</script>
</head>

<body>
<form name="frmGlAllocationForSup" id="frmGlAllocationForSup">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">GL Allocation for Supplier</div></div>
<div class="main_body">
<table width="600" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
    <td width="594">
    <fieldset style="-moz-border-radius: 5px;">
    <table width="76%" border="0" class="">
      <tr>
        
        <td width="91%">
          <table width="75%" border="0">
            <tr>
              <td height="3">
              <table width="100%" border="0" class="normalfnt">
                <tr>
                  <td width="10">&nbsp;</td>
                  <td width="80">Supplier</td>
                  <td colspan="2"><select name="cboSupliers" class="txtbox" id="cboSupliers" onchange="getAllocatedSupGls()" style="width:300px" tabindex="1">
				  <?php
	
					$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
					$result = $db->RunQuery($SQL);
					echo "<option value=\"0\"></option>" ;		
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					
					?>
				  
                  </select></td>
                  </tr>
                <tr>
                  <td width="10">&nbsp;</td>
                  <td width="80">GL Account</td>
                  <td width="300"><select name="cboGLAccID" class="txtbox" id="cboGLAccID" style="width:300px" onchange="AddRowtoGrid()" tabindex="2">
					<?php
						
						/*$SQL = "SELECT gla.strAccID,gla.strDescription,c.strAccountNo FROM glaccounts gla
								INNER JOIN companies c on c.strComCode=gla.strFacCode
								ORDER BY strDescription";	*/
						 $SQL="SELECT  gl.GLAccAllowNo,gla.strDescription,gla.strAccID,c.strCode
								FROM glallowcation gl
								INNER JOIN glaccounts gla on gla.intGLAccID=gl.GLAccNo
								INNER JOIN costcenters c on c.intCostCenterId=gl.FactoryCode
								ORDER BY gl.GLAccAllowNo;";
						$result = $db->RunQuery($SQL);		
						echo "<option value=\"0\"></option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["GLAccAllowNo"] ."\">" .$row['strAccID'].$row['strCode']." : ". $row["strDescription"] ."</option>" ;
						}
					
					?>
				  
				  </select></td>
                  <td width="187">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="17">
				  <div id="divtblGLAccs" style="overflow:scroll; height:330px; width:580px;">
                    <table width="560" bgcolor="" height="20" cellpadding="0" cellspacing="1" id="tblGLAccs">
                      <tr>
					  <td width="80" height="20" bgcolor="" class="grid_header">Del</td>
					  <td width="432" bgcolor="" class="grid_header">GL Description</td>
					  <td width="203" bgcolor="" class="grid_header">GL ID</td>
                      </tr>

                    </table>
                  </div>
				</td>
            </tr>
            <tr>
              <td height="32"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="">
                  <td width="32%">&nbsp;</td>
                  <td width="12%"><img src="../../images/new.png" onclick="clearGlAllocationForSup('frmGlAllocationForSup','tblGLAccs');" tabindex="5"/></td>
                  <td width="12%"><div align="left"><img src="../../images/save.png" onclick="allowcationSave()" alt="save" width="84" height="24" tabindex="3"/></div>                    </td>
                  <td width="12%"><div align="right"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" tabindex="4" /></a></div></td>
                  <td width="32%">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
        </td>
        
      </tr>
    </table>
    </fieldset>
    </td>
  </tr>
  
</table>
</div>
</div>
</form>

</body>
</html>
