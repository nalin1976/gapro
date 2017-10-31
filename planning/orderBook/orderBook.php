<?php
 session_start();
 include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Learning Curves</title>

<link href="file:///C|/Program Files/Inetpub/wwwroot/eplan/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/rb.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/calendar_functions.js" type="text/javascript"></script>

</head>

<body>

<table width="564" height="198" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross" onmousedown="grab(document.getElementById('frmOrderBook'),event);">
    <td height="25" bgcolor="#498CC2" class="mainHeading">Select Styles For Planning</td>
  </tr>
  <tr>
    <td><table width="96%" border="0">
      <tr>
        <td width="90%"><form>
          <table width="87%" border="0">

            <tr>
              <td height="17"><table width="89%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                  <td height="137" colspan="5"><div  style="width:747px;height:200px;overflow:scroll"  align="left" class="bcgl1">
                    <table  width="730" height="20" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="normalfnt" id="tblOrderBook">
                      <tr >
                        <td height="10" colspan="13" class="backcolorGreen" align="center"><span><b>Curve List</b> </span></td>
                      </tr>
                      <tr>
                        <td width="27"  class="grid_raw"><b>Edit</b></td>
                        <td nowrap="true" width="56" class="grid_raw"><div align="center"><b>Style Id</b> </div></td>
                        <td width="125"  class="grid_raw"><b>Description</b></td>
                        <td width="56" class="grid_raw"><b>Quantity</b></td>
						<td width="108"  class="grid_raw"><b>Cut Date</b></td>
						<td width="89" class="grid_raw"><b>Ex-Factory</b></td>
						<td width="72" class="grid_raw"><b>Status</b></td>
						<td width="47" class="grid_raw"><b>Type</b></td>
						<td width="48" class="grid_raw"><b>SMV</b></td>
						<td width="48" class="grid_raw"><b>Cut:SMV</b></td>
						<td width="48" class="grid_raw"><b>Sew:SMV</b></td>
						<td width="48" class="grid_raw"><b>Pack:SMV</b></td>
                      </tr>
					  <?php
					  							
						
						$sql = "select * from(SELECT DISTINCT
								orders.intStyleID,
								orders.strStyle,
								orders.intQty as intQty,
								orders.dtmDate,
								orders.dtmAppDate,
								'Original' AS `type`,
								'Approved' AS intStatus,
								orders.reaSMV,
								orders.dblCuttingSmv,
								orders.dblSewwingSmv,
								orders.dblPackingSmv
								 
								FROM
								orders
								LEFT  JOIN plan_stripes ON plan_stripes.strStyleID = orders.strStyle
								WHERE
								orders.intStatus <>  '13') as T";
								
						$result = $db->RunQuery($sql);
						while($row=mysql_fetch_array($result))
						{
							if($row['dblCuttingSmv']=='')
								$row['dblCuttingSmv']=0;
							if($row['dblSewwingSmv']=='')
								$row['dblSewwingSmv']=0;
							if($row['dblPackingSmv']=='')
								$row['dblPackingSmv']=0;
							
					  ?>
                      <tr  ondblclick="createObject(this)" class="mouseover" onmouseover="this.style.backgroundColor='#E0E0E0';" onmouseout="this.style.backgroundColor='#FFFFFF';"
>
                        <td align="center" valign="middle" class="normalfntMid"><div align="center"></div></td>
                        <td style="white-space:normal" width="56" class="normalfntMid" ><?php echo $row["intStyleID"]; ?></td>
                        <td width="125" class="normalfntMid"><?php echo $row["strStyle"]; ?></td>
                        <td width="56" class="normalfntMid"><?php echo $row["intQty"]; ?></td>
						<td  width="108" class="normalfntMid"><?php echo substr($row["dtmDate"],0,10); ?></td>
						<td  width="89" class="normalfntMid"><?php echo substr($row["dtmAppDate"],0,10); ?></td>
						<td  width="72" class="normalfntMid"><?php echo $row["intStatus"]; ?></td>
						<td  width="47" class="normalfntMid"><?php echo $row["type"]; ?></td>
						<td  width="48" class="normalfntMid"><?php echo $row["reaSMV"]; ?></td>
						<td width="48"><input type="text" name="txt_cutSmv" id="txt_cutSmv" style="text-align:center" size="8"  value="<?php echo $row['dblCuttingSmv'] ?>"  onkeypress="return isNumberKey(event);"  onkeydown="loadSaveImage(this);" /></td>
						<td width="48"><input type="text" name="txt_sewSmv" id="txt_sewSmv" style="text-align:center" size="8" value="<?php echo $row['dblSewwingSmv'] ?>" onkeypress="return CheckforValidDecimal(this.value,2,event);" onkeydown="loadSaveImage(this);" /></td>
						<td width="48"><input type="text" name="txt_packSmv" id="txt_packSmv" style="text-align:center" size="8" value="<?php echo $row['dblPackingSmv'] ?>" onkeypress="return isNumberKey(event);" onkeydown="loadSaveImage(this);" /></td>
						<td width="20"></td>
                      </tr>
					 <?php
					 	}
					 ?>
					 
					 
					  <?php
					  
						$sql = "SELECT
								PNO.strStyleId,
								PNO.strDescription,
								PNO.dbQuantity,
								PNO.dtmCutCode,
								PNO.dtmExFactory,
								'Original' AS `type`,
								'Approved' AS intStatus,
								PNO.smv,
								PNO.dblCuttingSmv,
								PNO.dblSewwingSmv,
								PNO.dblPackingSmv
								FROM
								plan_newoders PNO";
								
						$result = $db->RunQuery($sql);
						while($row=mysql_fetch_array($result))
						{
							
					  ?>
                      <tr  ondblclick="createObject(this)" class="mouseover" onmouseover="this.style.backgroundColor='#E0E0E0';" onmouseout="this.style.backgroundColor='#FFFFFF';"
>
                        <td align="center" valign="middle" class="normalfntMid"><div align="center"></div></td>
                        <td style="white-space:normal" width="56" class="normalfntMid" ><?php echo $row["strStyleId"]; ?></td>
                        <td width="125" class="normalfntMid"><?php echo $row["strDescription"]; ?></td>
                        <td width="56" class="normalfntMid"><?php echo $row["dbQuantity"]; ?></td>
						<td  width="108" class="normalfntMid"><?php echo substr($row["dtmCutCode"],0,10); ?></td>
						<td  width="89" class="normalfntMid"><?php echo substr($row["dtmExFactory"],0,10); ?></td>
						<td  width="72" class="normalfntMid"><?php echo $row["intStatus"]; ?></td>
						<td  width="47" class="normalfntMid"><?php echo $row["type"]; ?></td>
						<td  width="48" class="normalfntMid"><?php echo $row["smv"]; ?></td>
						<td width="48"><input type="text" name="txt_cutSmv" id="txt_cutSmv" style="text-align:center" size="8"  value="<?php echo $row['dblCuttingSmv'] ?>"  onkeypress="return isNumberKey(event);" /></td>
						<td width="48"><input type="text" name="txt_sewSmv" id="txt_sewSmv" style="text-align:center" size="8" value="<?php echo $row['dblSewwingSmv'] ?>" onkeypress="return isNumberKey(event);" /></td>
						<td width="48"><input type="text" name="txt_packSmv" id="txt_packSmv" style="text-align:center" size="8" value="<?php echo $row['dblPackingSmv'] ?>" onkeypress="return isNumberKey(event);" /></td>
						<td width="20"></td>
                      </tr>
					 <?php
					 	}
					 ?>
                     
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td width="258" height="12">&nbsp;</td>
                  <td width="97"><span class="normalfntp2"><img src="../../images/new.png" class="mouseover" alt="report" width="96" height="24" onclick="newOrderBookData()" /></span></td>
                
                  <td width="394"><span class="normalfntp2"><img src="../../images/close.png" class="mouseover" alt="close" width="97" height="24" border="0" onclick="closeWindow();" align="left" /></span></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    
  </tr>
</table>
<p class="grid-1">&nbsp;</p>
</body>
</html>
