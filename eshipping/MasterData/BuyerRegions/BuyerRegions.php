<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Buyer Regions</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
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
<script src="BuyerRegions.js" type="text/javascript"></script>

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
            <td height="42" bgcolor="#588DE7" class="TitleN2white">Buyer Regions</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td valign="top">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" h class="normalfnt"><table width="97%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Search</td>
                      <td width="73%"><select name="cboSearch" class="txtbox"  onchange="getData(this);" style="width:198px" id="cboSearch">
                        <?php
	
	$SQL = "SELECT buyerregion.strBuyerRegion, intBuyerRegionId FROM buyerregion";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$intBuyerRegionId = $row["intBuyerRegionId"];
		$strBuyerRegion = $row["strBuyerRegion"];
	?>
    	<option value="<?php echo $intBuyerRegionId; ?>"><?php echo $strBuyerRegion; ?></option>
	<?php	
	}
	

	
	?>
                      </select></td>
                    </tr>
                   
                    <tr>
                      <td width="9%" class="normalfnt">&nbsp;</td>
                      <td width="18%" class="normalfnt">Description  <span id="txtHint" style="color:#FF0000">*</span> </td>
                      <td><input type="text" id="txtDescription" name="txtDescription" class="txtbox" style="width:198px"  /></td>
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
                      <td width="22%" height="26">&nbsp;</td>
                      <td width="19%"><img src="../../images/new.png" alt="New" name="New" onclick="ClearForm();"/></td>
					  <td><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" onclick="validateData();"/></td>
                      <td width="15%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="deleteData();"/></td>
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
