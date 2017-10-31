<?php
 session_start();
 $buyerName	= $_GET["buyerName"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buyers</title>
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

</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmBuyers" name="frmBuyers" method="post" action="">
<table width="500" border="0" align="center" bgcolor="#FFFFFF">
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="20" bgcolor="#0E4874" class="TitleN2white"><div align="center" class="style1">Buyer Division </div></td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="28%" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" class="normalfnt">                   
				  <div id="divcons" style="overflow:scroll; height:140px; width:480px;">
                      <table id="mytable" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="bcgl1">
                        <tr>
						  <td width="39" height="17" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                          <td width="436" bgcolor="#498CC2" class="normaltxtmidb2" style="text-align:center">Buyer Division </td>
						</tr>
<?php
$sql="select strDivision from buyerdivisions where buyerCode='$buyerName' order By strDivision";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
						<tr class="bcgcolor-tblrowWhite">
							<td class="normalfntMid"><input type="checkbox" checked="checked"/></td>
							<td class="normalfnt" ><?php echo $row["strDivision"];?></td>
						</tr>
<?php
}
?>
                      </table>
                    </div></td>
                  </tr>
                <tr height="5">
                  <td height="5"class="normalfnt">&nbsp;</td>
                  <td height="5" class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Search</td>
                      <td width="216%" colspan="3"><select name="cboDivisionName" class="txtbox"  onchange="GetBuyerDivisionDetails();" style="width:320px" id="cboDivisionName">
                        <?php
	
	$SQL = "SELECT intDivisionId, strDivision FROM buyerdivisions where buyerCode='$buyerName' Order By strDivision";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intDivisionId"] ."\">" . $row["strDivision"] ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Name</td>
                      <td colspan="3"><input name="txtBDName" type="text" class="txtbox" id="txtBDName"  size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="3"><input name="txtBDRemarks" type="text" class="txtbox" id="txtBDRemarks" size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td colspan="3"><input type="checkbox" name="chkActive" id="chkActive" checked="checked" /></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                </tr>
              </table>              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="28%"><img src="../../images/new.png" alt="New" name="butBoNew" onclick="ClearDivisionDetails(1);"/></td>
                      <td width="22%"><img src="../../images/save.png" alt="Save" name="butBosave" width="84" height="24" onClick="butSaveBuyerDivision();"/></td>
                      <td width="24%"><img src="../../images/delete.png" alt="Delete" name="butBoDelete" width="100" height="24" onClick="ConformDelete(this.name)"/></td>
                      <td width="26%"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" onclick="closeWindow();"/></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
