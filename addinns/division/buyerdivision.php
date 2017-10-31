<?php
session_start();
include"../../Connector.php";
$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buyer Division</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="buyerdivision.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
</head>

<body>

<form>
<table width="950" border="0" align="center">
  <tr>
    <td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="23%" height="335">&nbsp;</td>
        <td width="54%"><table width="500" border="0" align="center">
          <tr>
            <td width="486" height="24" bgcolor="#498CC2" class="TitleN2white"><table width="100%" border="0">
                <tr>
                  <td width="94%">Buyer Division </td>
                  <td width="6%">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0">
                <tr>
                  <td width="22%" rowspan="2">&nbsp;</td>
                  <td width="30%" class="normalfnt">Buyer</td>
                  <td width="48%"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:140px" onchange="ShowBuyerDivisions();">
				 
					  <?Php
					 	$SQL="SELECT intBuyerID,strName FROM buyers WHERE intStatus = '1';";	
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
						}
                      ?>
                    </select>                  </td>
                </tr>
                <tr>
                  <td width="30%" class="normalfnt">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="216"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td height="19" bgcolor="#80AED5" class="normaltxtmidb2L">Division</td>
                        <td height="19" bgcolor="#80AED5" class="normaltxtmidb2L">&nbsp;</td>
                        <td height="19" bgcolor="#80AED5" class="normaltxtmidb2L">Avaliabe 
                          Division</td>
                      </tr>
                      <tr> 
                        <td width="46%" height="141" valign="top"><select name="cboDivision" size="10" class="txtbox" id="cboDivision" style="width:225px" ondblclick="MoveItemRight();">
               
                          </select></td>
                        <td width="8%">&nbsp;</td>
                        <td width="46%" valign="top"><table width="100%" border="0">
                          <tr>
                            <td colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center"></div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center"></div></td>
                          </tr>
                          <tr>
                            <td width="56%"><div align="center" class="normalfntMid">Division</div></td>
                            <td width="44%"><input name="txtDevision" type="text" class="txtbox" id="txtDevision" size="20" maxlength="30" /></td>
                          </tr>
                          <tr>
                            <td><div align="center"></div></td>
                            <td><div align="left"><img src="../../images/addsmall.png" alt="add" width="95" height="24" onclick="saveDivision();" id="add" name="add" class="mouseover"/></div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center"></div></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr> 
                        <td height="19" colspan="3" >&nbsp;</td>
                      </tr>
                      
                  </table></td>
          </tr>
          <tr>
            <td bgcolor=""><table width="100%" border="0">
                <tr>
                  <td width="25%" height="26">&nbsp;</td>
                  <td width="29%"><img src="../../images/save.png" alt="save" id="save" name="save" width="84" height="24" onclick="SaveandFinish();"/></td>
                        <td width="21%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" width="97" height="24" border="0" /></a></td>
                  <td width="25%">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="23%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
