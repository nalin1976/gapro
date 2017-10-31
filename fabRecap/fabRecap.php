<?php
session_start();
$backwardseperator = "../";
include('../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title> </title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="fabRecap.js" type="text/javascript"></script>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
</head>

<body>
<table width="100%">
  <tr>
    <td><?php include($backwardseperator."Header.php"); ?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Fabric Recap<span class="vol"></span></div></div>
<div class="main_body">
<table width="950" border="0" class="main_border_line">
  <?php 
  $arrFieldNames=array('Style&nbsp;Name','PO&nbsp;date','PO#','Div','Style#','Color&nbsp;Code','Dim','Orig&nbsp;PO&nbsp;Qty','Rvsd&nbsp;PO&nbsp;Qty','Mill','Fabric&nbsp;Ref#','Fabrication','Price','Width','Shrinkage','Fiber&nbsp;Content','MM&nbsp;YY','ORIT&nbsp;MM','Est&nbsp;Reqd&nbsp;Ydge','PI#','PI&nbsp;Qty','Inv#','Inv&nbsp;Qty','Rcvd&nbsp;to&nbsp;Cut','Fab&nbsp;Act&nbsp;ETA','EPLAN #','Fabric&nbsp;req.&nbsp;date','Fab&nbsp;Tgt&nbsp;ETA','YY&nbsp;Po&nbsp;qty','PO&nbsp;ETD','IN&nbsp;LINE','FTY','ALLOCATED&nbsp;YDS&nbsp;FOR&nbsp;CUTTING&nbsp;DEPT','Shrinkage','Used&nbsp;Ydge','Bal Ydge','','Comments','WEERAKOON\'S&nbsp;ACT&nbsp;YY&nbsp;(with&nbsp;out&nbsp;3%)','Act&nbsp;Shrinkage','Act&nbsp;Width','ACT&nbsp;YY&nbsp;PER&nbsp;CUT&nbsp;QTY','ALLOCATED&nbsp;CUT&nbsp;QTY&nbsp;DZN','FINAL&nbsp;CUT&nbsp;QTY&nbsp;DZN','FTY&nbsp;RCVD','Act&nbsp;Used&nbsp;Ydge','rvsd&nbsp;cut&nbsp;qty %','Comments','proft/loss&nbsp;on&nbsp;fab&nbsp;value','PO&nbsp;SIGN&nbsp;DATE','sh.re&nbsp;tgt&nbsp;date','rcvd&nbsp;date','difference','CUTTING&nbsp;YY','CUTTIN&nbsp;USED&nbsp;YDGE','VARIANCE','EPLAN&nbsp;QTY','VARIANCE','ACT.EFF');
  
  $arrFieldAlign=array('normalfnt','normalfnt','normalfnt','normalfnt','normalfnt','normalfnt','normalfnt','normalfntRite','normalfntRite','normalfnt','normalfnt','normalfnt');
  $arrFieldSize=array('normalfnt','normalfnt','normalfnt','normalfnt','normalfnt','normalfnt','normalfnt','normalfntRite','normalfntRite','normalfnt','normalfnt','normalfnt');
?>
<tr>
  <td colspan="<?php echo count($arrTblRows);?>" align="center" height="27" class="sub_containers"></td>
</tr>
<tr>
<td align="center">
<div style="width:950px;height:500px;overflow:scroll;" align="center">
<table style="width:auto;">
	<thead>
    	<tr class="grid_header" height="20">
        <?php for($i=0;$i<count($arrFieldNames);$i++){?>
        	<td class="grid_header"><?php echo $arrFieldNames[$i];?></td>
        <?php }?>
        </tr>
    </thead>
    <tbody>
    <?php 
	$arrTblRows=array("strDescription","dtmDate","strStyle","strDivision","strOrderNo","strColorCode","dblDimension","intQty","intQty","strSupplierID",				"strFabricRefNo","strFabrication");
	
	$sql_q="SELECT 			
					o.strDescription,
					o.dtmDate,
					o.strStyle,
					bd.strDivision,
					o.strOrderNo,
					o.strColorCode,
					o.dblDimension,
					o.intQty,
					o.intQty,
					o.strSupplierID,
					o.strFabricRefNo,
					o.strFabrication
					FROM orders o
					INNER JOIN buyerDivisions bd ON bd.intDivisionId=o.intDivisionId;";
					$res=$db->RunQuery($sql_q);
					$count=0;
					$color="";
					while($row=mysql_fetch_array($res))
					{
						(($count%2) == 1)? $color="grid_raw2":$color="grid_raw";
						?>
						<tr class="<?php echo $color;?>">
        				<?php for($i=0;$i<count($arrTblRows);$i++){
                        $col=$arrTblRows[$i];
						$val="";
						if($arrTblRows[$i] == "dtmDate")
						{ $val= substr($row[$col],0,10); }
						else{  
						$val=$row[$col];
						} 
        				?><?php //echo 10*strlen($arrFieldNames[$i]);?>
						<td class="<?php echo $arrFieldAlign[$i];?>" style="width:300px;"><?php echo $val;?></td>
						<?php }?>
                        </tr>
					<?php 
					$count++;
					}	?>
    </tbody>
</table>
</div>
<table style="width:950px;" class="main_border_line">
</td>
</tr>
<tr> 
	<td width="33%">&nbsp;</td>
	<td width="13%"><img src="../images/print.png" class="mouseover" onclick="ClearForm();"/></td>
	<td width="10%"><img src="../images/save.png" class="mouseover"onclick="savedata();"/></td>
	<td width="20%"><img src="../images/close.png"class="mouseover" onclick="deleteData();"/></td>
	<td width="24%">&nbsp;</td>
</tr>
</table>
</div>
<div class="gap"></div>
</div>
</body>
</html>
