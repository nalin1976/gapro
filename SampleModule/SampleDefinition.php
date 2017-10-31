<?php
	session_start();
	include("../Connector.php");
	$backwardseperator = "../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Definition</title>

	<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
	<link href="../css/tableGrib.css" rel="stylesheet" type="text/css" />
	<link href="../css/JqueryTabs.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="../js/tablegrid.js"></script>
	
	<script type="text/javascript">
		$(function(){
			// TABS
			$('#tabs').tabs();
		});
	</script>
	
</head>

<body>
<table width="100%" align="center">
	<tr>
    	<td><?php include '../Header.php'; ?></td>
	</tr>
</table>
<div>
	<div align="center">
		<div class="trans_layoutL" style="padding-bottom:20px;">
			<div class="trans_text">Sample Definition<span class="volu"></span></div>
	
			<div  id="tabs" >
				<ul>
					<li><a href="#tabs-1" class="normalfnt">Sample Module</a></li>
					<li><a href="#tabs-2" class="normalfnt">Instructions</a></li>
					<li><a href="#tabs-3" class="normalfnt">Material and Trims</a></li>
					<li><a href="#tabs-4" class="normalfnt">Size Specification</a></li>
					<li><a href="#tabs-5" class="normalfnt">Color Block and Contrast Color</a></li>
				</ul>
				
				<!-----------------------------------------------SAMPLE MODULE------------------------------------------>
				<div id="tabs-1">
					<table width="90%" border="0">
						<tr>
							<td width="30%" class="normalfnt">Sample ID</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Sample Type</td>
							<td width="22%" class="normalfnt">
								<select style="width: 152px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
							</td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Date</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Style / Article No</td>
							<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Sample Order No</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Model / Design No</td>
							<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Cus. Style No</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Finish Date</td>
							<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Description</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Sample Factory</td>
							<td width="22%" class="normalfnt">
								<select style="width: 152px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
							</td>				
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Season</td>
							<td width="22%" class="normalfnt">
								<select style="width: 152px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
						  	</td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Customer</td>
							<td width="22%" class="normalfnt">
								<select style="width: 152px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
							</td>				
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Item Group</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Follow Up By</td>
							<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Sample Material</td>
							<td width="22%" class="normalfnt">
								<select style="width: 152px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
						  	</td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Sample Status</td>
							<td width="22%" class="normalfnt">
								<select style="width: 152px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
							</td>				
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Brand / Label</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td width="9%" class="normalfnt"></td>
							<td width="17%" class="normalfnt">Handle By</td>
							<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Various Attachment Files</td>
							<td colspan="4" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Measurement Photo for Spec</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td colspan="3" class="normalfnt"><img src="../images/search.png" width="60" /></td>
						</tr>
						<tr>
							<td width="30%" class="normalfnt">Technical Photo for Worksheet</td>
						  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
							<td colspan="3" class="normalfnt"><img src="../images/search.png" width="60" /></td>
						</tr>
					</table>
					<br />		
					<div style="overflow:scroll; height:150px; width:698px;">
						<table style="width:680px" class="transGrid" border="1" cellspacing="1">
							<thead>
								<tr>
									<td colspan="3">Sample Quality Color Size</td>			
								</tr>	
								<tr>
									<td width="255">Color</td>
									<td width="255">Size</td>
									<td width="254">City</td>				
								</tr>		
							</thead>	
							<tbody>
								<tr>
									<td width="255">****</td>
									<td width="255">****</td>
									<td width="254">****</td>				
								</tr>
								<tr>
									<td width="255">****</td>
									<td width="255">****</td>
									<td width="254">****</td>				
								</tr>	
							</tbody>
						</table>
					</div>
					<br />
					<table width="800" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../images/new.png" width="90" /></td>
							<td width="11%"><img src="../images/save.png" width="80" /></td>
							<td width="12%"><a href="../main.php"><img src="../images/close.png" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>
				</div>
				
				<!-----------------------------------------------INSTRUCTION------------------------------------------>
				<div id="tabs-2">
					<table width="84%" border="0">
						<tr>
							<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Assemble / Sewing</td>
							<td width="2%"></td>
							<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Closure / Zipper / Button / Velco</td>
							<td width="3%"></td>
							<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Internal Sample Remarks</td>
							<td width="2%"></td>
						</tr>
						<tr>
						  <td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
							<td width="2%"></td>
							<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
							<td width="3%"></td>
							<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
							<td width="2%"></td>
						</tr>	
						<tr>
							<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Labelling / Tags / hangtag</td>
							<td width="2%"></td>
							<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Packing</td>
							<td width="3%"></td>
							<td bgcolor="#e5e4e4" width="31%" class="normalfnt">Buyer Comment</td>
							<td width="2%"></td>
						</tr>
						<tr>
							<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
							<td width="2%"></td>
							<td width="31%" class="normalfnt"><textarea id="" name=""class="txtbox" style="width:200px; height:65px;"></textarea></td>
							<td width="3%"></td>
							<td width="31%" class="normalfnt"><textarea id="" name="" class="txtbox" style="width:200px; height:65px;"></textarea></td>
							<td width="2%"></td>
						</tr>			
		  			</table>
		  			<table width="84%" border="0">
						<tr>
							<td colspan="3" bgcolor="#e5e4e4" class="normalfnt">Remarks</td>
							<td colspan="3"></td>
						</tr>
						<tr>
						  <td colspan="3" class="normalfnt"><textarea  id="" name="" class="txtbox" style="width:420px; height:65px;"></textarea></td>
							<td width="4%"></td>
							<td width="15%" bgcolor="#e5e4e4" class="normalfnt"></td>
							<td width="15%" bgcolor="#e5e4e4"></td>
							<td width="3%"></td>
						</tr>
						<tr>
							<td colspan="4"></td>
							<td width="15%"><img src="../images/search.png" id="butSearch" name="butSearch" width="60"/></td>
							<td width="15%"><img src="../images/search.png" id="butSearch" name="butSearch" width="60" /></td>
							<td width="3%"></td>
						</tr>			
		  			</table>
					<br />
					<table width="800" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../images/new.png" id="butNew" name="butNew" width="90" /></td>
							<td width="11%"><img src="../images/save.png" id="butSave" name="butSave" width="80" /></td>
							<td width="12%"><a href="../main.php"><img src="../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>
				</div>
				
				<!-----------------------------------------------MATERIALS AND TRIMS------------------------------------------>
				<div id="tabs-3">
					<div style="overflow:scroll; height:150px; width:698px;">
					<table style="width:780px" class="transGrid" border="1" cellspacing="1">
						<thead>
							<tr>
								<td colspan="6">Materials and Trims</td>			
							</tr>	
							<tr>
								<td width="48">Select</td>
								<td width="407">Meterial, Parts, Trims Description</td>
								<td width="45">YY</td>	
								<td width="62">Unit</td>	
								<td width="190">Placement</td>				
							</tr>		
						</thead>	
						<tbody>
							<tr>
								<td width="48"><input id="" name="" type="checkbox" class="txtbox"  /></td>
								<td width="407">****</td>
								<td width="45">****</td>	
								<td width="62">****</td>
								<td width="190">****</td>			
							</tr>
							<tr>
								<td width="48"><input id="" name="" type="checkbox" class="txtbox"  /></td>
								<td width="407">****</td>
								<td width="45">****</td>
								<td width="62">****</td>
								<td width="190">****</td>				
							</tr>	
						</tbody>
					</table>
					</div>
					<br />
					<table width="800" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../images/new.png" id="butNew" name="butNew" width="90" /></td>
							<td width="11%"><img src="../images/save.png" id="butSave" name="butSave" width="80" /></td>
							<td width="12%"><a href="../main.php"><img src="../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>
				</div>
				
				<!-----------------------------------------------SIZE SPECIFICATION------------------------------------------>
				<div id="tabs-4">
					<table width="86%" border="0">
						<tr>
							<td width="10%" class="normalfnt">Meas. Unit</td>
							<td width="10%">
								<select id="" name="" style="width: 62px;" class="txtbox">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>
							</td>
							<td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name=""type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name=""type="text" class="txtbox" style="width:60px;" /></td>
							<td width="10%" class="normalfnt"><input id="" name=""type="text" class="txtbox" style="width:60px;" /></td>
						</tr>
		  			</table>
					<br />
					<div style="overflow:scroll; height:150px; width:698px;" id="DivSizeSpecification">
						<table style="width:680px" class="transGrid" id="tblSizeSpecification" border="1" cellspacing="1">
							<thead>
								<tr>
									<td colspan="11">Size Specification </td>
								</tr>
								<tr>
									<td width="37">Select</td>
									<td width="162">Measurement Point</td>
									<td>Tolarence</td>
									<td>Size A</td>
									<td>Size B</td>
									<td>Size C</td>
									<td>Size D</td>
									<td>Size E</td>
									<td>Size F</td>
									<td>Size G</td>
									<td>Size H</td>
								</tr>
							</thead>
              				<tbody>
								<tr>
								  	<td width="37"><input name="checkbox" id="checkbox" type="checkbox" class="txtbox"  /></td>
									<td width="162">****</td>
									<td width="60">****</td>
									<td width="48">****</td>
									<td width="48">****</td>
									<td width="43">****</td>
									<td width="43">****</td>
									<td width="45">****</td>
									<td width="45">****</td>
									<td width="45">****</td>
									<td width="46">****</td>
								</tr>
								<tr>
								  	<td width="37"><input name="checkbox2" id="checkbox2" type="checkbox" class="txtbox"  /></td>
									<td width="162">****</td>
									<td width="60">****</td>
									<td width="48">****</td>
									<td width="48">****</td>
									<td width="43">****</td>
									<td width="43">****</td>
									<td width="45">****</td>
									<td width="45">****</td>
									<td width="45">****</td>
									<td width="46">****</td>
								</tr>
              				</tbody>
            			</table>
		  			</div>
					<br />
					<table width="800" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../images/new.png" id="butNew" name="butNew" width="90" /></td>
							<td width="11%"><img src="../images/save.png" id="butSave" name="butSave" width="80" /></td>
							<td width="12%"><a href="../main.php"><img src="../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>
				</div>
				
				<!-----------------------------------------------COLOR BLOCK AND CONTRAST COLOR------------------------------------------>
				<div id="tabs-5">
					<div style="overflow:scroll; height:150px; width:698px;">
					<table width="1200" border="1" cellspacing="1" class="transGrid">
						<thead>
							<tr>
								<td colspan="11">Color Block & Contrast Color placement and body location instruction</td>
							</tr>
							<tr>
								<td width="75">Body Panel</td>
								<td width="124">Color Combo 1</td>
								<td>Color Combo 1</td>
								<td>Color Combo 2</td>
								<td>Color Combo 3</td>
								<td>Color Combo 4</td>
								<td>Color Combo 5</td>
								<td>Color Combo 6</td>
								<td>Color Combo 7</td>
								<td>Color Combo 8</td>
								<td>Color Combo 9</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="75"><input name="checkbox" id="checkbox" type="checkbox" class="txtbox"  /></td>
								<td width="124">****</td>
								<td width="98">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="110">****</td>
							</tr>
							<tr>
								<td width="75"><input name="checkbox2" id="checkbox2" type="checkbox" class="txtbox"  /></td>
								<td width="124">****</td>
								<td width="98">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="105">****</td>
								<td width="110">****</td>
							</tr>
              			</tbody>
            		</table>
		  			</div>
					<br />
					<table width="800" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../images/new.png" id="butNew" name="butNew" width="90" /></td>
							<td width="11%"><img src="../images/save.png" id="butSave" name="butSave" width="80" /></td>
							<td width="12%"><a href="../main.php"><img src="../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>

</body>
</html>
