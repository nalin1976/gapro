<?php
session_start();
include "Connector.php"; 
$styleID = $_GET["styleID"];
$bpo = $_GET["bpo"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Ratio</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
  <table width="500" border="0" cellspacin="0" cellpadding="0" align="center" >
    <tr>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacin="0" cellpadding="0">
        <tr class="cursercross" onmousedown="grab(document.getElementById('frmHelper'),event);">
          <td width="100%" bgcolor="#0E4874"  colspan="2" class="PopoupTitleclass">Garment Color Size Ratio </td>
        </tr>

        <tr>
          <td colspan="2">
          <div id="divData" style="width:500px; height:300px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="480" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="stylecolorsize" >
              <tr>
              		<td bgcolor="#498CC2" class="normaltxtmidb2L"></td>
                <td width="40%" height="19" bgcolor="#498CC2" class="normaltxtmidb2L">Color</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Quantity</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT strColor,strSize,dblQty,dblExQty FROM styleratio WHERE intStyleId = '$styleID' AND strBuyerPONO = '$bpo';" ;
			
			
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-popup";
			   ?>">
               <td height="21" width="5%" class="normalfntMid"><input type="checkbox" /></td>
              	<td height="21" class="normalfnt"><?php echo  $row["strColor"]; ?></td>
               <td height="21" class="normalfnt"><?php echo  $row["strSize"]; ?></td>
               <td height="21" class="normalfntMid"><input type="text" value="<?php echo  $row["dblExQty"]; ?>" class="txtbox normalfntRite" style="width:75px;text-align:right"/></td>
				</tr>
              <?php
			  $pos ++;
			}
			?>
				
            </table>
          </div>
			<table>
			<tr>
<td width="30%">&nbsp;</td>
<td width="23%"><img src="images/addsmall.png" class="mouseover" alt="Add" width="95" height="24" onClick="AddToMatRatioBox();" /></td>
<td width="17%"><img src="images/close.png" class="mouseover" alt="Close" width="97" height="24" onClick="closeLayer();" /></td>
<td width="30%">&nbsp;</td>
</tr>
			</table>          
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
</body>
</html>
