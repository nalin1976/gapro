<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>group events</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="groupEvents-js.js"></script>
<script src="../../javascript/script.js"></script>
<script src="../../js/jquery-1.3.2.min.js"></script>



</head>

<body>

<?php
include "../../Connector.php";

?>
<form id="frmUserEvents" name="frmUserEvents" method="post" action="">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
	<td><table width="66%" align="center" class="bcgl1">
	  <tr>
	    <td class="normalfnt" ><table width="101%" align="center" class="bcgl1">
	      <tr>
	        <td colspan="3" class="normalfnt">&nbsp;</td>
	        </tr>
	      <tr>
	        <td colspan="3" bgcolor="#498CC2" class="mainHeading">Group Event Visibility</td>
	        </tr>
	      <tr>
	        <td class="normalfnt">&nbsp;</td>
	        <td>
           <input style="width:200px;display:none;" class="txtbox" id="txtMachineTypeID" type="text"  />
            </td>
	        </tr>
	      <tr>
	        <td class="normalfnt" width="149" style="padding-left:80px; padding-right:10px;"> Group </td>
	        <td width="454"><select name="cboGroup" class="txtbox"  id="cboGroup" style="width:203px;" onchange="loadExEventsForGroup()">
	          <?php
		$SQL="SELECT intGroupId,strGroupName FROM events_group ORDER BY strGroupName ASC";		
			$result = $db->RunQuery($SQL);
			
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intGroupId"] ."\">" . $row["strGroupName"] ."</option>" ;
		}		  
			 ?>
	          </select></td>
			  
	        </tr>

	      <tr>
	        <td align="center" colspan="2"><table bgcolor="#d6e7f5" width="100%">

	          </table>
              <br/>
	   <div id="maingrid" style="overflow:scroll; height:150px; width:520px;">
		<table style="width:500px" id="tblmaingrid" class="thetable" border="1" cellspacing="1">
        					
					<thead>
                    <tr>
						<th width="46">Del</th>
						<th width="441">User</th>
					</tr>
                    </thead>			 		
		    <tbody>
		</table>
	 </div>
	          <p><img src="../../images/save.png" onclick="deleteBeforeSave();"/></p></td>

	      </table></td>
	    </tr>
	</table></td>
	</tr>
	</table>
</form>
</body>
</html>
