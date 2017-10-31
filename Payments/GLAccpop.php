 <?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";	
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
 <table width="650" border="0" cellspacing="0" cellpadding="1" class="tableBorder" bgcolor="#FFFFFF">
  <tr>
  <td>
	  <table width="650" border="0" cellspacing="0" cellpadding="0">
		<tr>
		   <td width="650" height="25" class="mainHeading">GL Accounts</td>
		</tr>
		</table>	
  </td>
  </tr>
  <tr>
  	<td>
		<table width="650" cellspacing="0" cellpadding="0" border="0">
            <tr class="mainHeading2">
              <td width="81">Cost Center </td>
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
              <td width="63">Acc.Like</td>
              <td width="152"><input type="text" size="25" id="txtNameLike" name="txtNameLike" class="txtbox"></td>
              <td width="87"><img alt="search" onClick="getGLAccounts()" src="../images/search.png"></td>
            </tr>
        </table>
	</td>
  </tr>
  <tr>
  	<td>
		<div style="overflow: scroll; height: 350px; width: 650px;" id="divbuttons">
   	    <table width="650" cellspacing="1" cellpadding="0" border="0" bgcolor="#ccccff" id="tblallglaccounts">
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
          <td align="center"><img alt="Add" onClick="AddNewGLAccounttoMain(this);" src="../images/addsmall.png"><img height="24" width="97" id="Close" name="Close" alt="Close" onClick="CloseOSPopUp('popupLayer1');" src="../images/close.png"></td>
          </tr>
    	</table>
	</td>
  </tr>
  </table>

</body>
</html>
