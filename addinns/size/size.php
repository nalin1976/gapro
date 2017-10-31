<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Size</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Button.js"></script>
</head>

<body>
<?php 
include"../../Connector.php";
?>
<form id="frmSize" name="frmSize">
<table width="100%" border="0" align="center">
  <tr>
    <td><?php include '../../Header.php' ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="23%">&nbsp;</td>
        <td width="54%"><table width="500" border="0" align="center" class="tableBorder">
          <tr>
            <td width="486" height="24"><table width="100%" border="0">
                <tr class="mainHeading" height="35" bgcolor="#498CC2">
                  <td width="100%" colspan="2">Sizes</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0">
                <tr>
                  <td width="22%" rowspan="2">&nbsp;</td>
                  <td width="30%" class="normalfnt">Buyer<span class="compulsoryRed">*</span></td>
                  <td width="48%"><select name="sizes_cboBuyer" class="txtbox" id="sizes_cboBuyer" style="width:140px" onchange="ShowBuyerDivisions();">
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
                  <td width="30%" class="normalfnt">Division<span class="compulsoryRed">*</span></td>
                  <td><select name="sizes_cboDivision" class="txtbox" id="sizes_cboDivision" style="width:140px" onchange="ShowBuyerDivisionColors();">
                                    </select></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="273"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td height="20" bgcolor="#80AED5" class="normaltxtmidb2L">Sizes</td>
                        <td height="20" bgcolor="#80AED5" class="normaltxtmidb2L">&nbsp;</td>
                        <td height="20" bgcolor="#80AED5" class="normaltxtmidb2L">Avaliabe 
                          Sizes</td>
                      </tr>
                      <tr> 
                        <td width="46%" height="141" valign="top"><select name="sizes_cbocolors" size="10" class="txtbox" id="sizes_cbocolors" style="width:225px" ondblclick="MoveItemRight();">
                            <?php
	
	$SQL_Colors = "SELECT distinct sizes.strSize from sizes order by strSize;";
	
	$result_Colors = $db->RunQuery($SQL_Colors);
	
	while($row = mysql_fetch_array($result_Colors))
	{
		echo "<option value=\"". $row["strSize"] ."\">" . $row["strSize"] ."</option>" ;
	}
	
	?>
                          </select></td>
                        <td width="8%"><table width="100%" border="0">
                            <tr> 
                              <td><div align="center"></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" onclick="MoveItemRight();"/></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" onclick="MoveAllItemsRight();"/></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"></div></td>
                            </tr>
                          </table></td>
                        <td width="46%" valign="top"><select name="sizes_cboAvailable" size="10" class="txtbox" id="sizes_cboAvailable" style="width:225px" onkeypress="DeleteItem(event);">
                          </select></td>
                      </tr>
                      <tr> 
                        <td height="15" colspan="3" class="specialFnt1">*Press 
                          Delete Key to Remove</td>
                      </tr>
                      <tr> 
                        <td height="11" colspan="3" class="normaltxtmidb2L"><table width="45%" border="0" class="bcgl2Lbl">
                            <tr> 
                              <td height="21" colspan="2" class="normalfnBLD1 backcolorGreen">New</td>
                            </tr>
                            <tr> 
                              <td width="58%" class="normalfnt">Size Name</td>
                              <td><input name="sizes_txtcolorname" type="text" class="txtbox" id="sizes_txtcolorname" size="20" maxlength="30" /></td>
                            </tr>
                            <tr> 
                              <td><span class="normalfnt">Description</span></td>
                              <td><input name="sizes_txtdescription" type="text" class="txtbox" id="sizes_txtdescription" size="20" /></td>
                            </tr>
                            <tr> 
                              <td colspan="2" bgcolor=""><table width="100%" border="0">
                                  <tr> 
                                    <td width="15%">&nbsp;</td>
                                    <td width="39%">&nbsp;</td>
                                    <td width="46%"><img src="../../images/addsmall.png" alt="add" width="95" height="24" onclick="saveAndAssign();"/></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
          </tr>
          <tr>
          <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
            <td  align="center" class="tableFooter"><table width="100%" border="0" style="border:none;">
                <tr>
                  <td width="25%">&nbsp;</td>
                  <td><img src="../../images/save.png" alt="save" width="84" height="24" onclick="SaveandFinish();"/></td>
                  <td><img src="../../images/report.png" onclick="loadReport();"/></td>
                  <td><a href="../../main.php"><img src="../../images/close.png" alt="Close" width="97" height="24" border="0" /></a></td>
                </tr>
            </table></td>
            </tr>
            </table>
            </td>
          </tr>
        </table></td>
        <td width="23%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="left:550px; top:470px; z-index:10; position:absolute; width: 120px; visibility:hidden; height: 20px;" id="reportsPopUp">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="CostSheet" onclick="loadReportSize();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="WashFormula" onclick="loadReportSize();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>

</body>
</html>
