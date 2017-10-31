<?php
 session_start();
 include "../../Connector.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Quick History report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="OrderDetails.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>

<script src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>

<script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>


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
          <td width="4%"><div align="center"><img src="../../images/butt_1.png" width="15" height="15" /></div></td>
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
                  <td width="170"><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="gatDeta();" /></div></td>
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
                <td width="5%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Customer</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">SC#</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Style #</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Po #</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Order Qty Unit</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Production location</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">X-fty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Cargo Handover</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Customer delivery</td>
                 <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Shipped to</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Shiping mode</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">SMV</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">SAH</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">BPO Fob Unit</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Total FOB</td>
                
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Factory CM</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Total CM</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">RMC per pc</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Total RMC</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">RMC %</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Front End cost</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Projected NP</td>
                 <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Shipped Qty</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Order to shipped %</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">FOB shipped</td>
                
                                 <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">SAH shipped</td>
                 <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">RMC shipped</td>
                 <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">short/Over shipped Value</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Front End</td>	 
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">NP</td>
                  <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">CDN Date</td>	
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
      <td><table width="1382" border="0">
  <tr>
    <td class="normaltxtmidb2" width="4">&nbsp;</td>
    <td class="normalfnt" width="55">TTL NP</td>
    <td class="normalfnt" width="100"><input style="width:100px" name="ttlNp" id="ttlNp" type="text"  /></td>
     
     <td class="normaltxtmidb2" width="12">&nbsp;</td>
     <td class="normalfnt" width="94">TTL Front End</td>
     <td class="normalfnt" width="100"><input name="fntEnd" id="fntEnd" type="text" style="width:100px" /></td>
     
     <td class="normaltxtmidb2" width="9">&nbsp;</td>
     <td class="normalfnt" width="197">TTL short/Over shipped Value</td>
     <td class="normalfnt" width="773"><input name="shOvShpVal" id="shOvShpVal" type="text" style="width:100px" /></td>
  </tr>




</table>
</td>
      
  </tr>
  </table>
  </td></tr></table>

</body>
</html>
