<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include $backwardseperator."authentication.inc";
	/*$updateFabConpc=true;
	$updatePockConpc = true;
	$updateThreadConpc = false;
	$updateSMV = false;*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Actual Consumption</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<!--<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />-->
<script src="../../javascript/script.js" type="text/javascript"></script>
<script language="javascript" src="aConpc.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
		$(function(){
			// TABS
			$('#tabs').tabs();
		});
	</script>

</head>

<body onLoad="loadPendingData(<?php 
$id = $_GET["id"];
if($id !=0)
	echo $_GET["StyleID"];
else
	echo "0";  ?>);">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
</table>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td colspan="4">&nbsp; </td>
  </tr>
  <tr>
    <td colspan="4" class="mainHeading">Actual Consumptions </td>
  </tr>
  <tr>
    <td colspan="4"><div  id="tabs" style="background-color:#FFFFFF">
				<ul>
					<li><a href="#tabs-1" class="normalfnt">Cost Work Sheet</a></li>
					<li><a href="#tabs-2" class="normalfnt">Pending Cost Work Sheet</a></li>
					<li><a href="#tabs-3" class="normalfnt">Approved Cost Work Sheet</a></li>
				</ul>
				
				<!-----------------------------------------------SAMPLE MODULE------------------------------------------>
				<div id="tabs-1">
                <table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><form name="frmAcualConpc" id="frmAcualConpc">
    <table width="850" border="0" cellspacing="0" cellpadding="1" align="center" >
     
      <tr>
        <td width="151">&nbsp;</td>
        <td width="233">&nbsp;</td>
        <td width="79">&nbsp;</td>
        <td width="157">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="118">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">Style No</td>
        <td class="normalfnt"><select name="cboStyleNo" id="cboStyleNo" style="width:150px;" class="txtbox" onChange="loadStylewiseOrderNo();" >
        <option value=""></option>
        <?php 
			$SQL = "select distinct o.strStyle from orders o order by o.strStyle";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
			}
		?>
        </select>        </td>
        <td class="normalfnt">Order No</td>
        <td class="normalfnt"><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onChange="setSCNo();loadOrderDetails();">
         <option value=""></option>
         <?php 
			$SQL = "select  o.intStyleId,o.strOrderNo from orders o inner join 
firstsalecostworksheetheader fs on o.intStyleId = fs.intStyleId
where fs.intStatus=0 order by o.strOrderNo";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
			}
		?>
        </select>        </td>
        <td class="normalfnt">SC No</td>
        <td class="normalfnt"><select name="cboScNo" id="cboScNo" style="width:80px;" onChange="setOrderNo();">
         <option value=""></option>
         <?php 
		 	$SQL = "select  o.intStyleId,s.intSRNO from orders o inner join 
firstsalecostworksheetheader fs on o.intStyleId = fs.intStyleId
inner join specification s on s.intStyleId = o.intStyleId
and s.intStyleId = fs.intStyleId
where fs.intStatus=0 order by s.intSRNO desc";

			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
			}
		 ?>
        </select>        </td>
      </tr>
      <tr>
        <td class="normalfnt">Style Description</td>
        <td colspan="2" id="styleDesc" class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr><td>&nbsp;</td></tr>
       <tr>
         <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="18%"><span class="normalfnt">Main Fabric</span></td>
             <td width="82%"><input type="text" name="txtMainFabric" id="txtMainFabric" style="width:660px;" disabled></td>
           </tr>
           <tr>
             <td height="25"><span class="normalfnt">Fabric  Consumption</span></td>
             <td><input type="text" name="txtfabricConpc" id="txtfabricConpc" style="width:100px;" onKeyPress="return CheckforValidDecimal(this.value, 4,event);" <?php if(!($updateFabConpc)){?> disabled <?php }?>></td>
           </tr>
           <tr>
             <td height="25"><span class="normalfnt">Pocketing </span></td>
             <td><input type="text" name="txtpocket" id="txtpocket" style="width:660px;" disabled></td>
           </tr>
           <tr>
             <td><span class="normalfnt">Pocketing  Consumption</span></td>
             <td><input type="text" name="txtPocketConpc" id="txtPocketConpc" style="width:100px;" onKeyPress="return CheckforValidDecimal(this.value, 4,event);" <?php if(!($updatePockConpc)){?> disabled <?php }?>></td>
           </tr>
         </table></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td class="normalfnt">SMV Rate</td>
         <td><input type="text" name="txtSMVrate" id="txtSMVrate" style="width:100px;" onKeyPress="return CheckforValidDecimal(this.value, 4,event);" <?php if(!($updateSMV)){?> disabled <?php }?>></td>
         <td>&nbsp;</td>
         <td class="normalfnt">Thread Consumption</td>
         <td><input type="text" name="txtThreadConpc" id="txtThreadConpc" style="width:100px;" onKeyPress="return CheckforValidDecimal(this.value, 4,event);" <?php if(!($updateThreadConpc)){?> disabled <?php }?>></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td class="normalfnt">Dry Wash Price</td>
         <td><input type="text" name="txtDryWashPrice" id="txtDryWashPrice" style="width:100px;" <?php if(!($updateDryWashPrice)){?> disabled <?php }?>></td>
         <td>&nbsp;</td>
         <td class="normalfnt">Wet Wash Price</td>
         <td><input type="text" name="txtWetWashPrice" id="txtWetWashPrice" style="width:100px;" <?php if(!($updateWetWashPrice)){?> disabled <?php }?>></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td colspan="6" align="center">
         <table width="850" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
           <tr>
             <td align="center" valign="middle"> <img src="../../images/new.png" width="96" height="24" onClick="clearForm();"  >      
          <img src="../../images/save.png" width="84" height="24" onClick="saveDetails();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
           </tr>
         </table>        </td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>
                </div>
                

              
                <div id="tabs-2">
                <table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
    <div style="overflow:scroll; height:250px; width:850px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
      <tr class="mainHeading4">
        <td width="200" height="22" >Order No</td>
        <td width="190" >Fabric Conpc</td>
        <td width="162" >Pocketing conpc</td>
        <td width="162" >Thread Conpc</td>
        <td width="134" >SMV</td>
         <td width="134" >Dry Wash Price</td>
          <td width="134" >Wet Wash Price</td>
      </tr>
      <?php 
	  	$sql = "select fs.intStyleId,fs.strOrderNo,fsa.dblFabricConpc,fsa.dblPocketConpc,fsa.dblThreadConpc,fsa.dblSMV,
fsa.dblDryWashPrice,fsa.dblWetWashPrice,fs.intStatus
from firstsalecostworksheetheader fs inner join firstsale_actualdata fsa on
fs.intStyleId = fsa.intStyleId and fs.intStatus in (0,1) ";
//echo $sql;
		$result = $db->RunQuery($sql);
		while($rows = mysql_fetch_array($result))
			{
				
				$cls = ($rows["intStatus"] == 0 ?'grid_raw_white' :'grid_raw_pink');
				$strUrl  = "aConpc.php?id=1&StyleID=".$rows["intStyleId"];
				
	  ?>
      <tr class="<?php echo $cls; ?>">
      <?php 
	  if($rows["intStatus"] ==0)
	  {
	  ?>
        <td height="20"><a href="<?php echo $strUrl; ?>" style="text-decoration:underline"><?php echo $rows["strOrderNo"];?></a></td>
        <?php 
		}
		else
		{
		?>
        <td height="20"><?php echo $rows["strOrderNo"];?></td>
        <?php 
		}
		?>
        <td><?php echo (is_null($rows["dblFabricConpc"]) ?'&nbsp;' :$rows["dblFabricConpc"])?></td>
        <td><?php echo //(is_null($rows["dblPocketingConpc"]) ?'&nbsp;' :$rows["dblPocketingConpc"]);
		$rows["dblPocketConpc"]; ?></td>
        <td><?php echo (is_null($rows["dblThreadConpc"]) ?'&nbsp;' :$rows["dblThreadConpc"]);//$rows["dblThreadConpc"]; ?></td>
        <td><?php echo (is_null($rows["dblSMV"]) ?'&nbsp;' :$rows["dblSMV"]);//$rows["dblSMV"]; ?></td>
        <td><?php echo (is_null($rows["dblDryWashPrice"]) ?'&nbsp;' :$rows["dblDryWashPrice"]);//$rows["dblSMV"]; ?></td>
        <td><?php echo (is_null($rows["dblWetWashPrice"]) ?'&nbsp;' :$rows["dblWetWashPrice"]);//$rows["dblSMV"]; ?></td>
      </tr>
      <?php 
	  }
	  ?>
    </table></div></td>
    </tr>
 
</table>
        </div>
                
                <div id="tabs-3">
                <table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"> <div style="overflow:scroll; height:350px; width:850px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
      <tr class="mainHeading4">
        <td width="200" height="22" >Order No</td>
        <td width="190" >Fabric Conpc</td>
        <td width="162">Pocketing conpc</td>
        <td width="162" >Thread Conpc</td>
        <td width="134" >SMV</td>
         <td width="134" >Dry Wash Price</td>
          <td width="134" >Wet Wash Price</td>
      </tr>
      <?php 
	  	$sql = "select fs.intStyleId,fs.strOrderNo,fsa.dblFabricConpc,fsa.dblPocketConpc,fsa.dblThreadConpc,fsa.dblSMV,
fsa.dblDryWashPrice,fsa.dblWetWashPrice,fs.intStatus
from firstsalecostworksheetheader fs inner join firstsale_actualdata fsa on
fs.intStyleId = fsa.intStyleId and fs.intStatus =10";
		$result = $db->RunQuery($sql);
		while($rows = mysql_fetch_array($result))
			{
				//$cls = ($rw%2 == 0 ?'grid_raw' :'grid_raw2');
				$cls = 'grid_raw_white';
				$strUrl  = "aConpc.php?id=1&StyleID=".$rows["intStyleId"];
	  ?>
      <tr class="<?php echo $cls; ?>">
        <td height="20"><?php echo $rows["strOrderNo"];?></td>
        <td><?php echo $rows["dblFabricConpc"]; ?></td>
        <td><?php echo $rows["dblPocketingConpc"]; ?></td>
        <td><?php echo $rows["dblThreadConpc"]; ?></td>
        <td><?php echo $rows["dblSMV"]; ?></td>
         <td><?php echo (is_null($rows["dblDryWashPrice"]) ?'&nbsp;' :$rows["dblDryWashPrice"]);//$rows["dblSMV"]; ?></td>
        <td><?php echo (is_null($rows["dblWetWashPrice"]) ?'&nbsp;' :$rows["dblWetWashPrice"]);//$rows["dblSMV"]; ?></td>
      </tr>
      <?php 
	  }
	  ?>
    </table></div></td>
   
  </tr>
  
</table>
                </div>
               </div> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
