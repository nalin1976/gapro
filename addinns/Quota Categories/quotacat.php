<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quota Categories</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmquota" name="form1" method="post" action="">
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
            <td height="35" bgcolor="#498CC2" class="mainHeading">Quota Categories </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="5%" rowspan="6" class="normalfnt">&nbsp;</td>
                  <td width="23%" height="11" class="normalfnt">From-To</td>
                  <td><select name="cboquota" class="txtbox" id="cboquota" onchange="getquotaDetails();"style="width:134px">
						<?php
	
	$SQL = "SELECT * FROM quotacategories where intStatus=1;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCategoryID"] . "\"" . $row["intStatus"] . "\">" . $row["strCategoryID"] ."</option>" ;
	}
	
	?>

				  
                                                      </select></td>
                </tr>
                <tr>
                  <td height="12" class="normalfnt">Category ID </td>
                  <td><input name="txtid" type="text" class="txtbox" id="txtid" onclick="A();"/></td>
                </tr>
                <tr>
                  <td width="23%" height="5" class="normalfnt">Description</td>
                  <td rowspan="2"><input name="txtdescription" type="text" class="txtbox" id="txtdescription" size="40" style="height:40px"/></td>
                </tr>
                <tr>
                  <td height="6" class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td width="23%" height="21" valign="top" class="normalfnt">Unit</td>
                  <td><input name="txtunit" type="text" class="txtbox" id="txtunit" /></td>
                </tr>
                <tr>
                  <td height="21" valign="top" class="normalfnt">Price</td>
                  <td><input name="txtprice" type="text" class="txtbox" id="txtprice"  onkeypress="return isNumberKey(event);" /></td>
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
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="16%">&nbsp;</td>
                      <td width="18%"><img src="../../images/new.png" alt="New" name="New"
					  width="96" height="24" onclick="ClearForm();"/></td>
                      <td width="15%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name)"/></td>
                      <td width="18%"><img src="../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
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


