<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Colors</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include"../../Connector.php";
?>
<form method="get" id="frmColors" name="frmColors">
<table width="100%" border="0" align="center">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="520" border="0" align="center">
      <tr>
        <td width="54%"><table width="100%" border="0" align="center" class="tableBorder">
          <tr>
            <td width="100%" height="24" bgcolor="" class="mainHeading">Colors</td>
          </tr>
          <tr>
            <td><table width="100%" border="0">
                <tr>
                  <td width="8%" rowspan="2">&nbsp;</td>
                  <td width="23%" class="normalfnt">Buyer</td>
                  <td width="69%"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:250px" onchange="ShowBuyerDivisions();">	 
<?php
$SQL="SELECT intBuyerID,strName FROM buyers WHERE intStatus = '1' ORDER BY strName;";
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
                  <td width="23%" class="normalfnt">Division</td>
                  <td><select name="cboDivision" class="txtbox" id="cboDivision" style="width:250px" onchange="ShowBuyerDivisionColors();">
                                    </select></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td height="20" bgcolor="" class="mainHeading4">Colors                        </td>
                        <td height="20" bgcolor="" class="mainHeading4">&nbsp;</td>
                        <td height="20" bgcolor="" class="mainHeading4">Available 
                          Colors </td>
                      </tr>
                      <tr> 
                        <td width="46%" height="141" valign="top"><select name="cbocolors" size="10" class="txtbox" id="cbocolors" style="width:225px" ondblclick="MoveItemRight();">
                <?php
	
	$SQL_Colors = "SELECT distinct C.strColor from colors C order by C.strColor;";
	
	$result_Colors = $db->RunQuery($SQL_Colors);
	
	while($row = mysql_fetch_array($result_Colors))
	{
		echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
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
                        <td width="46%" valign="top"><select name="cboAvailable" size="10" class="txtbox" id="cboAvailable" style="width:225px" onkeypress="DeleteItem(event);">
                          </select></td>
                      </tr>
                      <tr> 
                        <td height="15" colspan="3" class="specialFnt1">*Press 
                          Delete Key to Remove</td>
                      </tr>
                      <tr> 
                        <td height="11" colspan="3" class=""><table width="45%" border="0" class="tableBorder">
                            <tr> 
                              <td height="21" colspan="2" class="mainHeading4">New</td>
                            </tr>
                            <tr> 
                              <td width="58%" class="normalfnt">Color Name<span class="compulsoryRed">*</span></td>
                              <td><input name="txtcolorname" type="text" class="txtbox" id="txtcolorname" size="20" maxlength="30" /></td>
                            </tr>
                            <tr> 
                              <td><span class="normalfnt">Description</span></td>
                              <td><input name="txtdescription" type="text" class="txtbox" id="txtdescription" size="20" maxlength="30"/></td>
                            </tr>
                            <tr> 
                              <td colspan="2" bgcolor=""><table width="100%" border="0">
                                  <tr> 
                                    <td width="15%"></td>
                                    <td width="39%">&nbsp;</td>
                                    <td width="46%"><img src="../../images/addsmall.png" alt="add" width="95" height="24" onclick="saveAndAssign();" id="add" name="add"/></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
          </tr>
          <tr>
            <td bgcolor=""><table width="100%" border="0" class="tableFooter" align="center">
                <tr>
                  <td align="center">
				  <img src="../../images/new.png" alt="save" id="butNew" onclick="ClearForm();"/>
				  <img src="../../images/save.png" alt="save" id="butSave" onclick="SaveandFinish();"/>
  				  <img src="../../images/report.png" alt="Report" border="0" class="mouseover" onclick="listORDetails();"/>
                  <a href="../../main.php"><img src="../../images/close.png" alt="Close" border="0" /></a>                </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="left:555px; top:430px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReport();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>
</body>
</html>
