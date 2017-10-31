<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Measurement Allocation Pop Up</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>

<script src="../../javascript/script.js"></script>
<script type="text/javascript" src="measurementAllocation-js.js"></script> 
<style type="text/css">
.popupdiv{
	width:408px;
	height:298px;
	position : absolute;
	top : 200px;
	left:400px;
	border:1px solid;
	float:left;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	background-color:#FFFFFF;
	border-right-color:#550000;
	padding-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom:13px solid #550000;
}
</style>

</head>
<body>

<div class="popupdiv">
	<div class="main_top">
		<div class="main_text">Sizes<span class="vol"></span><span id="size_popup_close_button"></span></div>
	</div>


<div style="overflow-x:hidden; overflow-y:scroll; height:298px; width:406px; vertical-align:top">
				 <table width="100%" bgcolor="#FFF3CF" border="0" align="center" style="vertical-align:top" class="thetable" cellspacing="1" cellpadding="0"  id="opt_table">
                  <tr >
                    <td width="16%" class="grid_header"><b>Select</b></td>
                    <td width="13%" class="grid_header"><b>Id</b></td>
                    <td width="54%" class="grid_header"><b>Description</b></td>
                    <td width="17%" class="grid_header"><b>Status</b></td>
                  </tr> 
				  <?php
				  	$id=$_GET['id'];
					
								$SQL_opt="SELECT * FROM measurementpoint";
										$result_opt=$db->RunQuery($SQL_opt);
										
										while($row=mysql_fetch_array($result_opt))
										{
											if($row["intStatus"]!=0)
											{
											 
				  ?>
	             <tr>
                    <td width="16%" >&nbsp;<img src="../../images/add.png" onclick="loadDataToGrid('<?php echo $row['intId'] ;?>');" /></td>
                    <td width="13%">&nbsp;<?php echo $row['intId'];?></td>
                    <td width="54%">&nbsp;<?php echo $row["strDescription"] ;?></td>
                    <td width="17%">&nbsp;<?php echo $row["intStatus"]; ?></td>
                </tr>
				  <?php 
											}
											
											}; ?>
	  </table>	
			</div>
            
            
            
</div>

</body>
</html>
