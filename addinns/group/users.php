<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Machines</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="machines-js.js"></script>
<script src="../../javascript/script.js"></script>
<script src="../../js/jquery-1.3.2.min.js"></script>



</head>

<body onload="rowclickColorChangetbl(this)">

<?php
include "../../Connector.php";

?>
<form id="frmmachines" name="frmmachines" method="post" action="">

<table width="400" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"></td>
  </tr>
  <tr>
	<td><table width="66%" align="center" class="bcgl1">
	  <tr>
	    <td class="normalfnt" ><table width="101%" align="center" class="bcgl1">
	      <tr>
	        <td width="226" class="normalfnt"></td>
	        <td width="378"></td>
	        </tr>
	      <tr>
	        <td align="center" colspan="2"><table bgcolor="#d6e7f5" width="100%">

	          </table>
              <br/>
	   <div id="machinegrid" style="overflow:scroll; height:150px; width:520px;">
		<table style="width:500px" id="tblusersgrid" class="thetable" border="1" cellspacing="1">
        						<caption>Users</caption>
					<thead>
                    <tr>
						<th width="37">#</th>
						<th width="450">Name</th>
					</tr>
                    </thead>
					<?php
					$sql = "select intUserID,Name from useraccounts";
					$result = $db->RunQuery($sql);
					while($row = mysql_fetch_array($result)){
					?>	
					<tbody>
					<tr>
					<td><input type="checkbox"/></td>
					<td class="normalfnt" id="<?php echo $row["intUserID"];?>"><?php echo $row["Name"]; ?></td>
					</tr>
					<?php
					}	
					?>	 
					</tbody>		
		</table>
	 </div>
	          <p><img src="../../images/ok.png" onclick="loadUsersToGrid();"/><img src="../../images/close.png" onclick="closeUsersPopUp();"/></p></td>
	      </table></td>
	    </tr>
	</table></td>
	</tr>
	</table>
</form>
</body>
</html>
