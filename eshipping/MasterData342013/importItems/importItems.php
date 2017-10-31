<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Items</title>
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
<!--<script src="button.js"></script>
<script src="Search.js"></script>-->
<script src="button.js" type="text/javascript"></script>
<script src="Search.js" type="text/javascript"></script>
<script src="Item.js" type="text/javascript"></script>

</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmBuyers" name="frmBuyers" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Items</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  </tr>
                
                
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
                   <!-- <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Item Code </td>
                      <td><input name="txtCode" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="txtCode"  size="30" /></td>
                    </tr>-->
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Search</td>
                      <td><select name="cboItem" class="txtbox"  onchange="getItemDetails() ;" style="width:320px" id="cboItem">
                        <?php
	
	$SQL = "SELECT  strItemCode ,strDescription
FROM item ORDER BY strDescription ;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strItemCode"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Description</td>
                      <td><input name="txtName" type="text" class="txtbox" id="txtName"  size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Unit</td>
                      <td><select name="cboUnit" class="txtbox"   style="width:192px" id="cboUnit">
                        <?php
	
	$SQL = "SELECT  strUnit ,strTitle
FROM units;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                      </select></td>
                      </tr>
                    <!--<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td><input name="txtEmail" type="text" class="txtbox" id="txtEmail" size="30" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50" /></td>
                    </tr>-->
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Commodity Code</td>
                      <td><select name="cboCommodity" class="txtbox"   style="width:192px" id="cboCommodity">
                        <?php
	
	$SQL = "SELECT  strCommodityCode FROM commoditycodes GROUP BY strCommodityCode;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCommodityCode"] ."\">" . $row["strCommodityCode"] ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td class="normalfnt"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="30" style="width:192px" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td><span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="19%"><img src="../../images/new.png" alt="New" name="New" class="mouseover" onclick="ClearForm();"/></td>
					  <td><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" class="mouseover" onclick="saveData();"/></td>
                      <td width="15%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" class="mouseover" height="24" onclick="deleteData();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="26%">&nbsp;</td>
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
