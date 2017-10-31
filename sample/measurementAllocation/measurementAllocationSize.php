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
<script type="text/javascript" src="measurementAllocation-js.js"></script> 

</head>
<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Sizes<span class="vol"></span><span id="measurement_allocation_popup_close_button"></span></div>
	</div>
	<div class="main_body">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr > 
                        <td height="20" style="background-color: rgb(255, 213, 170); color:#006" class="normaltxtmidb2L">Sizes</td>
                        <td height="20" style="background-color: rgb(255, 213, 170); color:#006" bgcolor="#FFF3CF" class="normaltxtmidb2L">&nbsp;</td>
                        <td height="20" style="background-color: rgb(255, 213, 170); color:#006" class="normaltxtmidb2L">Available 
                          Sizes</td>
                      </tr>
                      <tr> 
                        <td width="41%" height="141" valign="top"><select name="cbosizes" size="10" class="txtbox" id="cbosizes" style="width:225px" ondblclick="MoveItemRight();">
                            <?php
	
							
	
	
	$SQL_Colors = "SELECT distinct sizes.strSize from sizes  order by strSize";
	
	$result_Colors = $db->RunQuery($SQL_Colors);
	
	
	while($row = mysql_fetch_array($result_Colors))
	{
		$available = 0;
		
		for($x=0;$x<sizeof($arrStr);$x++)
		{	
			
			if(strcmp($row['strSize'],$arrStr[$x])==0)
			{
				$available = 1;
			}
			
		}
		
		if($available==0)
			echo "<option value=\"". $row["strSize"] ."\">" . $row["strSize"] ."</option>" ;
		
	}
		
						
	?>
                        </select></td>
                        <td width="12%"><table width="100%" border="0">
                            <tr> 
                              <td><div align="center"></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" onclick="MoveItemRight();"/></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" onclick="MoveAllItemsRight();"/></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"></div></td>
                            </tr>
                            <tr> 
                              <td><div align="center"></div></td>
                            </tr>
                        </table></td>
                        <td width="47%" valign="top"><select name="cboAvailable" size="10" class="txtbox" id="cboAvailable" style="width:225px" onkeypress="DeleteItem(event);">
                        
                    <?php
	
						for($p=0;$p<sizeof($arrStr)-1;$p++)
						{	
							
						  		echo "<option value=\"". $arrStr[$p] ."\">" . $arrStr[$p] ."</option>";
							
						}
	
					?>
                        
                        </select></td>
                      </tr>
                      <tr> 
                        <td height="17" colspan="3" class="specialFnt1">*Press 
                          Delete Key to Remove</td>
                      </tr>
					  
					   <tr>
                  				  
                  <td><img src="../../images/addsmall.png" align="right" alt="save" width="83" height="24" onclick="saveToGrid();"/></td>
				  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                    </table></td>
          </tr>
         
 
        </table>
		  </div>
	  </div>
		</div>
		</body>
</html>
