<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
	
	$styleid = $_GET['StyleID'];
	$str     = $_GET['str'];
	$arrStr  = split(",",$str);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sizes Pop Up</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>

<script src="../../javascript/script.js"></script>
<script type="text/javascript" src="SampleRequisition.js"></script>

</head>
<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF" id="thi">
  <tr>
    <td id="td_coHeader"></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Sizes<span class="vol"></span><span id="sample_popup_close"></span></div>
	    </div>
		      <div class="main_body">
             	<table width="500" border="0" style="background-color: rgb(244, 233, 215);">
					  <tr class="cursercross" onmousedown="grab(document.getElementById('frmSelector'),event);">
						<td width="486" height="24" bgcolor="#fcb334" class="TitleN2white">Select Colors and Sizes</td>
					  </tr>
					  
					  <tr>
						<td height="367"><table width="100%" border="0" cellpadding="0" cellspacing="0">
						  <tr>
							<td height="20" colspan="3" bgcolor="#fcb334" class="normaltxtmidb2L">Colors</td>
							</tr>
						  <tr>
							<td width="46%" class="normalfntMid">Colors</td>
							<td width="8%" >&nbsp;</td>
							<td width="46%" class="normalfntMid">Selected Colors</td>
						  </tr>
						  <tr>
							<td height="141" valign="top"><select name="cbocolors" size="10" class="txtbox" id="cbocolors" style="width:225px" ondblclick="MoveColorRight();">
                            
                            
                            <?php
	
							
	
	
	$SQL_Colors = "SELECT distinct colors.strColor from colors  order by strColor";
	
	$result_Colors = $db->RunQuery($SQL_Colors);
	
	
	while($row = mysql_fetch_array($result_Colors))
	{
		$availablecolor = 0;
		
		for($x=0;$x<sizeof($arrStr);$x++)
		{	
			
			if(strcmp($row['strColor'],$arrStr[$x])==0)
			{
				$availablecolor = 1;
			}
			
		}
		
		if($availablecolor==0)
			echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>";
		
	}
		
						
	?>	
							</select></td>
							<td><table width="100%" border="0">
							  <tr>
								<td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" class="mouseover" onClick="MoveColorRight();" /></div></td>
							  </tr>
							  <tr>
								<td><div align="center"><img src="../../images/fw.png" alt="&lt;" width="18" height="19" class="mouseover" onClick="MoveColorLeft();" /></div></td>
							  </tr>
							  <tr>
								<td><div align="center"></div></td>
							  </tr>
							  <tr>
								<td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" class="mouseover" onClick="MoveAllColorsLeft();" /></div></td>
							  </tr>
							  <tr>
								<td><div align="center"><img src="../../images/fb.png" alt="&lt;&lt;" width="18" height="19\ class="mouseover" id="imgMoveRight" onClick="MoveAllColorsRight();" /></div></td>
							  </tr>
							</table></td>
							<td valign="top"><select name="cboselectedcolors" size="10" class="txtbox" id="cboselectedcolors" style="width:225px;" ondblclick="MoveColorLeft();">
							</select>
												
							</td>
						  </tr>
						 <tr>
							<td height="21" colspan="3" bgcolor="#fcb334" class="normaltxtmidb2L">Sizes</td>
							</tr>
						  <tr>
							<td style="background-color: rgb(244, 233, 215);" class="normalfntMid">Sizes</td>
							<td style="background-color: rgb(244, 233, 215);">&nbsp;</td>
							<td style="background-color: rgb(244, 233, 215);" class="normalfntMid">Selected Sizes</td>
						  </tr>
						  <tr>
							<td valign="top">
                            <select name="cbosizes" size="10" class="txtbox" id="cbosizes" style="width:225px" ondblclick="MoveSizeRight();">
								<?php
	
							
	
	
	$SQL_Colors = "SELECT distinct sizes.strSize from sizes  order by strSize";
	
	$result_Colors = $db->RunQuery($SQL_Colors);
	
	
	while($row = mysql_fetch_array($result_Colors))
	{
		$availablesize = 0;
		
		for($x=0;$x<sizeof($arrStr);$x++)
		{	
			
			if(strcmp($row['strSize'],$arrStr[$x])==0)
			{
				$availablesize = 1;
			}
			
		}
		
		if($availablesize==0)
			echo "<option value=\"". $row["strSize"] ."\">" . $row["strSize"] ."</option>" ;
		
	}
		
						
	?>	
                                    
                            </select></td>
							<td><table width="100%" border="0">
							  <tr>
								<td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" class="mouseover" onClick="MoveSizeRight();" /></div></td>
							  </tr>
							  <tr>
								<td><div align="center"><img src="../../images/fw.png" alt="&lt;" width="18" height="19" class="mouseover" onClick="MoveSizeLeft();" /></div></td>
							  </tr> 
							  <tr>
								<td><div align="center"></div></td>
							  </tr>
							  <tr>
								<td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" class="mouseover" onClick="MoveAllSizesLeft();" /></div></td> 
							  </tr>
							  <tr>
								<td><div align="center"><img src="../../images/fb.png" alt="&lt;&lt;" width="18" height="19" class="mouseover" id="imgDownMoveRight" onClick="MoveAllSizesRight();" /></div></td>
							  </tr>
							</table></td>
							<td valign="top"><select name="cboselectedsizes" size="10" class="txtbox" id="cboselectedsizes" style="width:225px" ondblclick="MoveSizeLeft();">
									</select>
														
							</td>
						  </tr>
						</table></td>
					  </tr>
					  <tr>
						<td style="background-color: rgb(244, 233, 215);"><table width="100%" border="0">						  <tr>
							<td width="25%">&nbsp;</td>
							<td width="29%"><img src="../../images/ok.png" alt="OK" width="86" height="24" class="mouseover" onClick="AddSelection();" /></td>
							<td width="21%"><img src="../../images/close.png" alt="Close" width="97" height="24" class="mouseover" onClick="closePopupBox(2);" /></td>
							<td width="25%">&nbsp;</td>
						 </tr>
					</table></td>
					  </tr>
					</table>
		      </div>
	</div>
</div>
</body>
</html>
