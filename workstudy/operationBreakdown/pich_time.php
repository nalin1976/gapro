<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pich Time</title>
<script src="Operation.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
include "../../Connector.php";
?>
<form id="frmOperations" name="frmOperations" method="post" action="">
 
<div class="main_bottom_center1">
	<div class="main_top">
		<div class="main_text">Pich Time<span class="vol"></span></div>
	</div>
	<div class="main_body">
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="126" class="normalfnt">Style No</td>
			<td width="256"><input style="width: 201px;" class="txtbox" type="text" id="styleNumber" name="styleNumber" readonly="readonly" ></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">PO No</td>
			<td><input style="width: 201px;" class="txtbox" type="text" readonly="readonly" name="poNumber" id="poNumber"></td>     
		</tr>
	</table>	
	
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="164" bgcolor="#E8E8E8" class="normalfnt"><b>Workers :</b></td>  
			<td width="429">&nbsp;</td>  
		</tr>
	</table>
	
	<table border="0" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="128" class="normalfnt">M/O</td>
			<td width="254"><input style="width: 201px;" class="txtbox" type="text" id="moValue" name="moValue" onkeyup="setTotalWorks();"></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Helpers</td>
			<td><input style="width: 201px;" class="txtbox" name="helpers" id="helpers" type="text" onkeyup="setTotalWorks();" ></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Total Workers</td>
			<td><input style="width: 201px;" class="txtbox" type="text" readonly="readonly" name="totalWorks" id="totalWorks"></td>    
		</tr>
	</table>
		
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="166" bgcolor="#E8E8E8" class="normalfnt"><b>Total SMV :</b></td>
			<td width="427">&nbsp;</td>   
		</tr>
	</table>
	
	<table border="0" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="131" class="normalfnt">M/SMV</td>
			<td width="251"><input style="width: 201px;" class="txtbox" type="text" id="mSMV" name="mSMV" readonly="readonly" ></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">H/SMV</td>
			<td><input style="width: 201px;" class="txtbox" type="text" id="hSMV" name="hSMV" readonly="readonly" ></td>    
		</tr>
		 
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Total SMV</td>
			<td><input style="width: 201px;" class="txtbox" type="text" id="tSMV" name="tSMV" readonly="readonly"></td>    
		</tr>
	</table>		
	
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="141" class="normalfnt"></td>
			<td width="142"><img src="../../images/cal.png" border="0" onclick="doCalculation();"/></td>
			<td width="107">&nbsp;</td>   
		</tr>
	</table>
	
	<table border="0" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="131" class="normalfnt">Total P/T</td>
			<td width="251"><input style="width: 201px;" class="txtbox" type="text" name="totalPT" id="totalPT"></td>  
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Machine P/T</td>
			<td><input style="width: 201px;" class="txtbox" type="text" name="machinePT" id="machinePT"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Req. M/O</td>
			<td><input style="width: 201px;" class="txtbox" type="text" name="reqMO" id="reqMO"></td>    
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>	
			<td class="normalfnt">Req. Helpers</td>
			<td><input style="width: 201px;" class="txtbox" type="text" name="reqHelpers" id="reqHelpers"></td>    
		</tr>
	</table>
	
	<table border="0" class="table" cellspacing="1" width="400">
		<tr>	
			<td width="8" class="normalfnt">&nbsp;</td>	
			<td width="131" class="normalfnt">P/T Variance %</td>
			<td width="251"><input style="width: 201px;" class="txtbox" type="text"></td>  
		</tr>		
	</table>
	
	<table class="table" width="400">
		<tr>
			<td width="22%">&nbsp;</td>
			<td width="19%"><img src="../../images/edit_icon.png"name="New"></td>
			<td><img src="../../images/save.png"></td>
			<td width="18%"><img src="../../images/close.png" border="0" onclick="CloseWindow();" ></td>
			<td width="26%">&nbsp;</td>
		</tr>
	</table>
	</div>
</div>
</form>	
</body>
</html>