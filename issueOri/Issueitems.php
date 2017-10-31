<?php

session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Issue Items</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body onload="LoadItemDetails">

<?php

include "../Connector.php";

?>
<form name="frmIssueItem" id="frmIssueItem">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="950%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="6%" height="24" class="normalfnt">Order No</td>
            <td width="9%" class="normalfnt"><select name="cboorderno" class="txtbox" id="cboorderno" style="width:80px">
            
			
<?php
	
	$SQL ="select intSRNO,intStyleId from specification ; ";
		
	$result = $db->RunQuery($SQL);
	
	echo "<option vale=\"".""."\">" ."select style"."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSRNO"] ."\">" . $row["intStyleId"] ."</option>" ;
	}

?>
			
			</select>            </td>
            <td width="4%" class="normalfnt">SC No</td>
            <td width="11%" class="normalfnt"><input name="cboscno" type="text" class="txtbox" id="cboscno" style="width:50px">
                        </select></td>
            <td width="12%" class="normalfnt">Buyer PO No</td>
            <td width="11%" class="normalfnt"><select name="cbobuyerpono" class="txtbox" id="cbobuyerpono" style="width:100px">
            </select></td>
            <td width="5%" class="normalfnt">Material</td>
            <td width="11%" class="normalfnt"><select name="cbomaterial" class="txtbox" id="cbomaterial" style="width:100px">
  <?php
	
	$SQL ="select intID,strDescription from matmaincategory ;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value =\"".""."\">"."select category"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intId"] ."\">" . $row["strDescription"] ."</option>";
	}
		
  ?>			
			</select>            </td>
            <td width="5%" class="normalfnt">MRN No</td>
            <td width="11%" class="normalfnt"><select name="cbomrnno" class="txtbox" id="cbomrnno" style="width:100px">
                  </select></td>
            <td width="15%" class="normalfnt"><img src="../images/search.png" alt="search" width="80" height="24" onclick="" /></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="21" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">Issue Items</div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divIssueItem" style="overflow:scroll; height:130px; width:950px;">
          <table id="IssueItem" width="1000" cellpadding="0" cellspacing="0">
            <tr>
              <td width="6%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Select</td>
              <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2L">Details</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
              <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">GRN Balance</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Select</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">BIN</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2R">Issue Qty</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2R">Con Bal</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2R">Req Qty</td>
              </tr>
            <tr>
              <td><div align="center">
                <input type="checkbox" name="chksel" id="chksel" />
              </div></td>
              <td class="normalfnt">FABR</td>
              <td class="normalfntMid">POC</td>
              <td class="normalfntMid">10</td>
              <td class="normalfntMid">10</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntMid">6.34</td>
              <td class="normalfntMid">41245</td>
              <td class="normalfntRite">.4542</td>
              <td class="normalfntRite">0.250</td>              
              </tr>
            <tr>
              <td><div align="center">
                <input type="checkbox" name="chksel2" id="chksel2" />
              </div></td>
              <td class="normalfnt">ACCE</td>
              <td class="normalfntMid">ZIPPR</td>
              <td class="normalfntMid">10</td>
              <td class="normalfntMid">10</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntMid">145.24</td>
              <td class="normalfntMid">442</td>
              <td class="normalfntRite">.2542</td>
              <td class="normalfntRite">0.254</td>              
              </tr>
            <tr>
              <td><div align="center">
                <input type="checkbox" name="chksel3" id="chksel3" />
              </div></td>
              <td class="normalfnt">ACCE</td>
              <td class="normalfntMid">LABLE</td>
              <td class="normalfntMid">12</td>
              <td class="normalfntMid">10</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntMid">789.21</td>
              <td class="normalfntMid">4247</td>
              <td class="normalfntRite">.2241</td>
              <td class="normalfntRite">0.175</td>             
              </tr>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="32%" height="29">&nbsp;</td>
        <td width="12%"><img src="../images/ok.png" width="86" height="24" /></td>
        <td width="14%"><img src="../images/report.png" width="108" height="24" onclick="ShowPreOrderReport();" /></td>
        <td width="10%"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" /></a></td>
        <td width="32%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
