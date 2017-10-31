 <?php
	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";	
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>

<style>
.main_bottom_center3 {
	width:auto; height:auto;
	position : absolute; 
	top:280px; left:283px;
	background-color:#FFFFFF;
	border:1px solid;
	-moz-border-radius-topright:15px;
	-moz-border-radius-topleft:15px;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	background-color:#FFFFFF;
	border-right-color:#550000;
	padding-right:15px;
	padding-top:20px;
	padding-bottom:15px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom:10px solid #550000;
}

.main_top3 {
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	background-color:#550000;
	position : absolute; top : -10px; left:-1px; width:100%; height:24px;
	border:1px solid;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	border-right-color:#550000;
	cursor:move;
}
</style>
</head>

<body>

<div class="main_bottom_center3">
	<div class="main_top3" onMouseDown="grab(document.getElementById('frmPopItem'),event);" >
		<div class="main_text">GL Accounts<span class="vol"></span><span id="grnDet_popup_close_button"></span></div>
	</div>
	
 <table width="650" border="0" cellspacing="0" cellpadding="1" class="tableBorder" bgcolor="#FFFFFF">
  <tr>
  	<td>
		<table width="650" cellspacing="0" cellpadding="0" border="0">
            <tr class="mainHeading2">
              <td width="35">&nbsp;</td>
              <td width="50">Factory</td>
              <td width="250"><select style="width: 250px;" id="cboFactory" class="normalfnt" name="cboFactory">
                <?php
					$sql = "select intCostCenterId,strDescription
							from costcenters
							where intStatus='1'
							order by strDescription";
					$result = $db->RunQuery($sql);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
					}
				?>
              </select></td>
              <td>&nbsp;</td>
              <td width="100">Acc.Like</td>
              <td width="200"><input type="text" size="25" id="txtNameLike" name="txtNameLike" class="txtbox"></td>
              <td><img alt="search" onClick="getGLAccounts()" src="../../images/search.png"></td>
            </tr>
        </table>
	</td>
  </tr>
  <tr>
  	<td>
		<div style="overflow: scroll; height: 350px; width: 650px;" id="divbuttons">
   	    <table width="630" cellspacing="1" cellpadding="0" border="0" bgcolor="#ccccff" id="tblallglaccounts">
        <tr class="mainHeading4">
          <td height="22" width="39">*</td>
          <td width="350">GL Acc Id</td>
          <td width="450">Description</td>
        </tr>
    	</table>
  		</div>
   </td>
  </tr>
  <tr>
  	<td>
		<table border="0" width="100%" class="tableBorder">
        <tr>
          <td align="center"><img alt="Add" onClick="AddNewGLAccounttoMain(this);" src="../../images/addsmall.png"><img height="24" width="97" id="Close" name="Close" alt="Close" onClick="CloseOSPopUp('popupLayer1');" src="../../images/close.png"></td>
          </tr>
    	</table>
	</td>
  </tr>
  </table>
</div>
</body>
</html>
