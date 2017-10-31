<?php
 session_start();
 include "../Connector.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Quick History report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="QuickHistoryReport.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>

<script src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>

<script type="text/javascript" src="../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../javascript/calendar/calendar-en.js"></script>


</head>

<body>
<table width="100%" border="0">
<tr><td><?php  include 'Header.php'; ?></td></tr>
<tr><td>
  <table width="1100" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="bcgl1">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Quick History report </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="1100" border="0" class="bcgl1">
                <tr>
                  <td width="89"  class="normalfnt">SC No</td>
                  <td width="180" ><select name="cboSR" class="txtbox" style="width:170px" id="cboSR" onchange="AutoSelect(this,'cboStNo'); loadOrderNo(this,'sc');">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by  intSRNO desc;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
	
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72"  class="normalfnt">Style No </td>
                  <td width="192"><select name="cboStNo" class="txtbox" style="width:170px" id="cboStNo" onchange="AutoSelect(this,'cboSR');loadOrderNo(this,'style');">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId, orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by orders.strOrderNo ;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="86"  class="normalfnt">Buyer Po No </td>
                  <td width="195" ><select name="cboBpo" class="txtbox" style="width:170px" id="cboBpo">
                    <option value="Select One" selected="selected">Select One</option>

                  </select></td>
                  <td width="61"  class="normalfnt">Buyer</td>
                  <td colspan="2" ><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
						$SQL = "SELECT buyers.strName, buyers.intBuyerID FROM buyers ;";	
						$result = $db->RunQuery($SQL);		
						while($row = mysql_fetch_array($result))
						{
								echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
						}
					?>
                  </select></td>
                  </tr>
				  

				  
                <tr>
                  <td  class="normalfnt">Mat Category</td>
                  <td><select name="matCategory" class="txtbox" style="width:170px" id="matCategory">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory ;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		
			echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td width="170"><div align="right"><img src="../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="gatDeta();" /></div></td>
                  <td width="15">&nbsp;</td>
                </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td align="center" colspan="2"><div align="center" id="divData" style="width:1100px; height:500px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="1090" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblBomDetails" >
              <tr>
                <td width="5%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Sc No</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">BPO</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Mat. Description</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Bom Qty </td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Po Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">GRN Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Prasara GP Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Trans In CWH</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Trans In FTY</td>
				<!--<td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Detail Rpt</td>-->
              </tr>
				<tbody id='aaa'>
                </tbody>
            </table>
          </div></td>
        </tr>
        
 
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
  </td></tr></table>

</body>
</html>
