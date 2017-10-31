<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Layout</title>
 <link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../js/jquery-1.2.6.min.js"></script>
<script src="../../js/table_script.js"></script>
<script language="javascript"> 
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=910,height=540');");
} 
</script> 
</head>
<body>
<?php include "../../Connector.php"; ?> 
	
<table width="100%"  bgcolor="#FFFFFF"><tr><td>
<table align="left" width="960">	
	<tr><td align="right" colspan="5"><img src="../../images/closelabel.gif" onclick="closePopup1();" style="width:40px;" /></td></tr>
		<tr class="cursercross" onmousedown="grab(document.getElementById('frmLayout'),event);">
		<td height="35"  bgcolor="#498CC2" class="TitleN2white" colspan="5">Layout</td>
    </tr>
		<td>								 
	<td width="100" height="24" class="normalfnt" id="tdHeader">SC No</td>
		  	<td width="267">
			<select class="txtbox" style="width: 202px;" onchange="loadLayoutGridRelatedData(this.value);" name="orderNo" id="orderNo">
			<option value="0">select</option>
		<?php
		
		$SQL="	SELECT DISTINCT s.strStyleID,s.intSRNO 
				FROM specification s";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["strStyleID"]."\">".$row["intSRNO"]."</option>";
			}
	
 	    ?>
			</select>			</td> 
			<td class="normalfnt" width="113">Style No</td>
		  	<td width="420" id="tdDelete"><input style="width: 200px;" class="txtbox" type="text" id="txtStyleNo" name="txtStyleNo" readonly="readonly"> <a href="#" onclick="reportLayout();">View Reort</a> <!--onclick="popitup('layoutReport.php?styleId='+document.getElementById('txtStyleNo').value);" ></a>--> </td>        
		</tr>
	</table>
	</td></tr>
	<tr><td>	
	<br />
	<table align="center" width="920">
		<tr>
			<td width="460">
				<div id="divcons1" class="main_border_line" style="overflow:scroll;  height:250px; width:450px;">
					<div id="layoutLeftGrid">					 
<!--	
				<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblLayoutOperationLeft">
						<caption></caption>
						<thead>
							<tr>
								<th>No</th>
								<td>Operation</th>
								<th>Machine</th>
								<th>SMV</th>
								<th>R</th>
								<th>TGT</th>
								<th>MR</th>
								<th>EFF %</th>
								<th>Tot Tgt</th>
								<th>Nos</th>
							</tr>
						</thead>
						<tbody>
							<?php $k =90; $n=1;
							for($i=30;$i>0;$i--){
							for($j=3;$j>0;$j--){ ?>
							<tr id="<?php echo $k; ?>">
								<td><?php echo "L".$i;  $machineName = "machine".$n; ?></td>
								<td><img src="../../images/aad.png" alt="add" border="0" onclick="forceToSelectOrderNo()"/>operation</td>
								<td><select class="txtbox" id="<?php echo $machineName; ?>" name="<?php echo $machineName; ?>" style="width: 70px;">
									<option value="0">select</option>
									</select></td>
								<td>0.00</td>
								<td>0</td>
								<td>0.00</td>
								<td><input type="checkbox" class="chkbox"></td>
								<td>0.00%</td>
								<td>0.00</td>
								<td>0.00</td>
							</tr>
							 <?php  $k--; $n++; } } $i=0; $j=0; $k=0;  ?>
						</tbody>
					</table>
	-->
					</div>
				</div>
			</td>
			<td width="460">
			<div id="divcons2" class="main_border_line" style="overflow:scroll;  height:250px; width:450px;">
				<div id="layoutRightGrid">
<!--	
				<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblLayoutOperationRight">
						<caption></caption>
						<thead>
							<tr>
								<th>No</th>
								<th>Operation</th>
								<th>Machine</th>
								<th>SMV</th>
								<th>R</th>
								<th>TGT</th>
								<th>MR</th>
								<th>EFF %</th>
								<th>Tot Tgt</th>
								<th>Nos</th>
							</tr>
						</thead>
						<tbody>
							<?php $k =90; 
							for($i=30;$i>0;$i--){
							for($j=3;$j>0;$j--){ ?>
							<tr id="<?php echo $k; ?>">
								<td><?php echo "R".$i; ?></td>
								<td><img src="../../images/aad.png" alt="add" border="0"  onclick="forceToSelectOrderNo()" />operation</td>
								<td>
									 
				<select class="txtbox" id="machine" name="machine" style="width: 70px;">	
				<option value="0">select</option> 
				</select>
								</td>
								<td>0.00</td>
								<td>0</td>
								<td>0.00</td>
								<td><input type="checkbox" class="chkbox"></td>
								<td>0.00%</td>
								<td>0.00</td>
								<td>0.00</td>
							</tr>
							 <?php  $k--; } } $i=0; $j=0; $k=0; ?>
						</tbody>
					</table>
	-->
					
				</div>
			  </div>
			</td>
		</tr>
	</table>
	</td></tr><tr><td>
	<br />
<table width="100%">
	<th colspan="9"  class="normalfnt" style="text-align:left;"><b>Color Codes</b></th>
	<tr>
		<td width="23" class="normalfnt">&nbsp;</td>
		<td width="22" class="normalfnt"><img src="../../images/normal.jpg"/></td>
		<td width="50" class="normalfnt">Normal</td>
		<td width="18"><img src="../../images/yellow.jpg"/></td>
		<td width="200" class="normalfnt">Add Machine/Operation to Layout</td>
		<td width="20"><img src="../../images/green.jpg"/></td>
		<td width="117" class="normalfnt">Operation Overload</td>
		<td width="21"><img src="../../images/blue.jpg"/></td>
		<td width="281" class="normalfnt">Work Station Overload</td>
	</tr>
</table>
</td></tr>
<tr><td>	 
<table width="100%">
	<tr>
		<td width="20%">&nbsp;</td>
		<td width="15%"><img src="../../images/new.png" class="mouseover" onclick="javascript:location.reload(true);"></td>
		<td width="15%"><img src="../../images/save.png" alt="Save" class="mouseover" onclick="saveLayoutData();"></td>
		<td width="15%"><img src="../../images/delete.png" class="mouseover" height="24"></td>
		<!--<td width="15%" id="tdDelete"><a href="#"><img src="../../images/close.png" id="Close" border="0" onclick="backToTheMainPage();" ></a></td>-->
		<td width="20%">&nbsp;</td>
	</tr>
</table>
</td></tr></table>
</body>
<script type="text/javascript">
	var objleft = document.getElementById('layoutLeftGrid');
		objleft.scrollTop = objleft.scrollHeight;
		alert(objleft.scrollHeight);
</script>
</html>