<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Module</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>
<script type="text/javascript" src="measurementPoint-js.js"></script>
</head>
<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php  include '../../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutS">
		<div class="trans_text">Measurement Points<span class="volu"></span></div>
<table width="99%" border="0" class="bcgl1" style="margin-bottom:5px">
<tr>
<td align="center">
<table width="67%" border="0">
				<tr>
					<td width="4%">&nbsp;</td>
					<td width="42%" class="normalfnt" align="right"> Measurement ID</td>
			  	  <td width="54%" class="normalfnt" align="center"><input type="text" class="txtbox" name="txtId" id="txtId" style="width:50px;" disabled="disabled" readonly="true"/></td>
				</tr>
				<tr>
					<td width="4%">&nbsp;</td>
					<td width="42%" class="normalfnt" align="right">Description</td>
			  	  <td width="54%" class="normalfnt" align="center"><input type="text" class="txtbox" name="txtDesc" id="txtDesc" style="width:130px;" onkeypress="checkEnterKey(event);"/></td>
                 
				</tr>
                <tr>
                	<td width="4%">&nbsp;</td>
                    <td width="42%" class="normalfnt" align="right">Status</td>
                    <td width="54%" class="normalfnt" align="center"><input type="checkbox" id="chkStatus" checked="checked"></td>
                </tr>
		  </table>
			<table width="272" border="0">
       	  <tr>
                	<td></td>
              </tr>
                <tr>
                	<td></td>
                </tr>
      			<tr>
					
					<td width="266"><img src="../../images/new.png" width="90" onclick="reloadPage();" /><img src="../../images/save.png" width="80" onclick="validateData();" /><a href="../../main.php"><img src="../../images/close.png" alt="close" width="90" border="0" /></a></td>
				</tr>
                <tr>
                	<td></td>
                </tr>
		  </table>
	</td>
    </tr>
    </table>
  		
            <table width="99%" border="0" class="bcgl1">
            <tr>
            <td>		
			<div style="overflow-x:hidden; height:150px; width:390px;">
				<table width="100%" style="width:390px" id="tbl_measurementDet" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF"><!--<table style="width:400px" class="transGrid" id="tbl_measurementDet" border="1" cellspacing="1">-->
					<thead>
					<tr class="mainHeading2">
	 			  			<td width="5%" class="normaltxtmidb2">Del</td>
							<td width="5%" class="normaltxtmidb2">Edit</td>
							<td width="10%" class="normaltxtmidb2">Id</td>
							<td width="60%" class="normaltxtmidb2">Description</td>
                            <td width="30%" class="normaltxtmidb2">Status</td>
					</tr>						
					</thead>	
					<tbody>
						<?php
	$SQL="SELECT intId,strDescription,intStatus FROM measurementpoint ";
	
	
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
?>							
								<tr class="bcgcolor-tblrowWhite">
									<td class="normalfnt"><img src="../../images/del.png" name="deleteBut" id="butDel" class="mouseover" onclick="deleteRow('<?php echo $row["intId"] ;?>');" /></td>
									<td class="normalfnt"><img src="../../images/edit.png" name="editBut" id="butEdit" class="mouseover" onclick="editRow('<?php echo $row["intId"] ;?>','<?php echo $row["strDescription"] ;?>')" /></td>	
									<td class="normalfnt"> &nbsp;<?php echo  $row["intId"]; ?> </td>
                                    <td class="normalfnt"> &nbsp;<?php echo  $row["strDescription"]; ?></td>
                                    <td class="normalfnt" style="text-align:center"> &nbsp;<?php if($row["intStatus"]==1){ echo "<input type='checkbox' checked='checked' disabled='disabled'/>";} else{echo "<input type='checkbox' disabled='disabled'/>";}?></td>								
								</tr>
	<?php
	};
	?>	
					</tbody>
				</table>
			</div>
            </td>
            </tr>
            </table>
			<br />
			
		</div>
	</div>
</div>
</body>
</html>
