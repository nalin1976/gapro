<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GRN Excess Qty </title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
	include "../../Connector.php";
?>
<form id="frmgrn" name="form1" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="32%">&nbsp;</td>
        <td width="49%"><table width="82%" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading">GRN Excess Qty </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="71%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="4%" rowspan="5" class="normalfnt">&nbsp;</td>
                  <td width="25%" height="11" class="normalfnt">From-To</td>
                  <td><select name="cbogrn" class="txtbox" id="cbogrn" onchange="getgrnDetails();"style="width:134px">
				  <?php
	$SQL="SELECT * FROM grnexcessqty WHERE intStatus <> 10 order by  intFrom ASC";
		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
		while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intNo"] ."\">" . $row["intFrom"] ."-". $row["strTo"]."</option>" ;
	}		  
			  
				  ?>

				  
                </select></td>
                </tr>
                <tr>
                  <td height="12" class="normalfnt">From</td>
                  <td><input name="txtfrom" type="text" class="txtbox" id="txtfrom" /></td>
                </tr>
                <tr>
                  <td width="25%" height="13" class="normalfnt">To</td>
                  <td><input name="txtto" type="text" class="txtbox" id="txtto" /></td>
                </tr>
                <tr>
                  <td width="25%" height="21" valign="top" class="normalfnt">%</td>
                  <td><input name="txtpre" type="text" class="txtbox" id="txtpre" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                </tr>
                <tr>
                  <td height="21" colspan="2" valign="top" class="normalfnt"><div id="divcons2" style="overflow:auto; height:130px; width:400px;">
                    <table width="383" cellpadding="0" cellspacing="0" id="tblMainBin">
                      <tr>
                        <td width="27%" height="19" bgcolor="#498CC2" class="mainHeading3">From</td>
                        <td width="38%" bgcolor="#498CC2" class="mainHeading3">To</td>
                        <td width="35%" bgcolor="#498CC2" class="mainHeading3">%</td>
                      </tr>
                      <?php
						$SQL="SELECT * FROM grnexcessqty where intStatus=1 order by intFrom ASC ";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							$i++;
							if(($i % 2)==0)
								$color = "#FFFFCE";
							else
								$color = "";
						  
				  	?>
                      <tr bgcolor="<?php echo $color; ?>" id="<?php echo $row["intNo"]; ?>" onclick="clickGrid(this);">
                        <td align="center" bgcolor=""><?php echo $row["intFrom"]; ?></td>
                        <td align="center"><?php echo $row["strTo"]; ?></td>
                        <td align="center"><?php echo $row["dblPercentage"]; ?></td>
                      </tr>
                      <?php
						
						}
					
					?>
                    </table>
                  </div></td>
                  </tr>
				  <tr>
				  	  <td width="4%" class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked" /></td>
                    </tr>
                <tr>
                  <td colspan="3" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
                <tr>
                  <td colspan="3" class="normalfnt">&nbsp;</td>
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
					  width="96" height="24" onclick="ClearFields();"/></td>
                      <td width="15%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name)"/></td>
                      <td width="18%"><img src="../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)"/></td>
					  <td width="12%" class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  /></td>
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

