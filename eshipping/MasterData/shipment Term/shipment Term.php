<?php
 session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | shipment Term</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
</head>

<body>
<?php
include "../../connector.php";
?>
<form id="frmshipmentTerm" name="form1" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498CC2" class="TitleN2white">shipment Term</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="normalfnt">&nbsp; </td>
                  <td class="normalfnt">Shipment Term </td>
                  <td width="72%"><select name="cboshipment" class="txtbox" id="cboshipment" onchange="getshipmentDetails();"style="width:135px">

				  
				  <?php
				$SQL="select strShipmentTermId, concat(strShipmentTermId,'-->',strShipmentTerm)AS Shipment from shipmentterms where intStatus=1;";
				
				$result = $db->RunQuery($SQL);
				
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}  
				
				?>	  
				  
				  
                  </select>                  </td>
                </tr>
                
                <tr>
                  <td width="5%" rowspan="2" class="normalfnt">&nbsp;</td>
                  <td width="23%" height="25" class="normalfnt">Shipment Term ID</td>
                  <td><input name="txtshipment" type="text" class="txtbox" id="txtshipment" /></td>
                </tr>
                <tr>
                  <td width="23%" height="26" class="normalfnt">Shipment Term</td>
                  <td><input name="txtshipmentmode" type="text" class="txtbox" id="txtshipmentmode" size="40" /></td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="16%">&nbsp;</td>
                      <td width="18%"><img src="../../images/new.png" alt="New" name="New" onclick="ClearForm();"width="96" height="24" /></td>
                      <td width="15%"><img src="../../images/save.png" alt="Save" name="Save" onclick="butCommand(this.name)"width="84" height="24" /></td>
                      <td width="18%"><img src="../../images/delete.png" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name)"width="100" height="24" /></td>
                      <td width="18%"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" onclick="backtopage();"/></td>
                      <td width="15%">&nbsp;</td>
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
</form>
</body>
</html>
