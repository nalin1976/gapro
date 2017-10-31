<?php
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Wise Buyer PO Numbers</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="javascript/buyerPO.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>
</head>
<?php
	
include "Connector.php";

//$SQL = "select specification.intSRNO,specification.intStyleId,specification.dblQuantity from specification where intStyleId  = '" . $_GET["styleID"]. "';";

$SQL = "select intStyleId,intQty from orders where intStyleId = '" . $_GET["styleID"]. "';";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		$StyleNo =  $row["intStyleId"];
		$Qty =  $row["intQty"];
	}
?>

<body>
<form name="frmstylewise" id="frmstylewise">
  <table width="500" border="0" align="left" bgcolor="#FFFFFF">
    <tr>
      <td><table width="480" border="0">
          <tr>
            
            <td width="62%"><table width="100%" border="0">
                <tr class="cursercross" onmousedown="grab(document.getElementById('frmBuyerPOs'),event);">
                  <td height="23" bgcolor="#498CC2" class="TitleN2white">Style wise Buyer PO Nos</td>
                </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" class="bcgl1">
                      <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="12%" class="normalfnt">Style No</td>
                        <td width="21%" class="normalfnth2"><label id="lblStyleNo"><?php echo $StyleNo; ?></label></td>
                        <td width="16%" class="normalfnt">&nbsp;</td>
                        <td width="18%" class="normalfnth2"><label></label></td>
                        <td width="15%" class="normalfnt">Order Qty</td>
                        <td width="16%" class="normalfnth2"><label id="lblTotalQty" ><?php echo $Qty; ?>

						</label></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="30" valign="bottom" class="head1">New Buyer PO</td>
                </tr>
                <tr>
                  <td height="142"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                      <tr>
                        <td width="1%" height="24">&nbsp;</td>
                        <td width="16%" class="normalfnt">Buyer PO No</td>
                        <td width="27%"><input name="txtbuyerpo" type="text" class="txtbox" id="txtbuyerpo" /></td>
                        <td width="11%" class="normalfnt">Country</td>
                        <td width="45%"><select name="cbocountry" class="txtbox" id="cbocountry" style="width:150px">
                          <?php
	
	$SQL = "select strCountryCode,strCountry from country where intStatus != 0;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["strCountryCode"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
                                                  </select>
                        </td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Qty</td>
                        <td><input name="txtqty" type="text" class="txtbox" id="txtqty"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" value="1" size="9"  /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="51">&nbsp;</td>
                        <td valign="top" class="normalfnt">Remarks</td>
                        <td colspan="3" valign="top"><textarea name="txtremarks" cols="70" rows="3" class="txtbox" id="txtremarks"></textarea></td>
                      </tr>
                      <tr>
                        <td bgcolor="#9BBFDD">&nbsp;</td>
                        <td bgcolor="#9BBFDD">&nbsp;</td>
                        <td bgcolor="#9BBFDD">&nbsp;</td>
                        <td colspan="2" bgcolor="#9BBFDD"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="12%" height="21">&nbsp;</td>
                              <td width="64%">&nbsp;</td>
                              <td width="24%"><img src="images/add_alone.png" alt="Add" width="72" height="18" class="mouseover" onclick="AddNewPO();" /></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" class="bcgl1">
                      <tr>
                        <td colspan="3"><div id="divcons" style="overflow:scroll; height:110px; width:500px;">
                            <table id="BuyerPO" width="560" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="9%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
                                <td width="27%" bgcolor="#498CC2" class="normaltxtmidb2L">Buyer PO No</td>
                                <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2R">Order Qty</td>
                                <td width="21%" bgcolor="#498CC2" class="normaltxtmidb2">Country</td>
                                <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2L">Remarks</td>
                              </tr>
							  <?php
							  
							  $SQL = "select style_buyerponos.intStyleId,style_buyerponos.strBuyerPONO,style_buyerponos.strRemarks,style_buyerponos.dblQty,style_buyerponos.strCountryCode,country.strCountry from style_buyerponos, country where style_buyerponos.strCountryCode = country.strCountryCode AND style_buyerponos.intStyleId = '" . $_GET["styleID"] . "';";
							  
							  $result = $db->RunQuery($SQL);
							  $total = 0;
	
								while($row = mysql_fetch_array($result))
								{
								$total +=  $row["dblQty"];
								?>
                              <tr>
                                <td><img src="images/del.png" alt="del" width="15" height="15" border="0" class="mouseover" onclick="RemovePONumber(this);" /></td>
                                <td class="normalfnt" ondblclick="changeToTextBox(this);"><?php echo  $row["strBuyerPONO"]; ?></td>
                                <td class="normalfntRite" ondblclick="changeToTextBox(this);"><?php echo  $row["dblQty"]; ?></td>
                                <td class="normalfntMid"><?php echo  $row["strCountryCode"]; ?></td>
                                <td class="normalfnt"><?php echo  $row["strRemarks"]; ?></td>
                              </tr>
							  <?php
							  }
							  
							  ?>
                              
                            </table>
                        </div></td>
                      </tr>
                      <tr>
                        <td width="63%">&nbsp;</td>
                        <td width="15%" class="normalfnt">Total Qty</td>
                        <td width="22%"><input name="txttotalqty" type="text" class="txtbox" id="txttotalqty" disabled="disabled" size="20" value="<?php echo $total; ?>"  /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="28%" bgcolor="#D6E7F5">&nbsp;</td>
                      <td width="27%" bgcolor="#D6E7F5"><img src="images/save.png" alt="Save" width="84" height="24" border="0" class="mouseover" onclick="MakeDatabaseForSaving();" /></td>
                      <td width="17%" bgcolor="#D6E7F5"><img src="images/close.png" alt="Close" width="97" height="24" border="0" class="mouseover" onclick="closeWindow();" /></td>
                      <td width="28%" bgcolor="#D6E7F5">&nbsp;</td>
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

