<?php
$backwardseperator = "../";
session_start();
include("../Connector.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="360" height="120" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
  <tr class="bcgcolor-highlighted">
    <td height="25" colspan="3"  class="normaltxtmidb2L">&nbsp; Packing List Printer</td>
    <td width="20" align="left" class="bcgcolor-highlighted"><img src="../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td width="5%" height="25">&nbsp;</td>
    <td  width="27%" class="normalfnth2Bm" style="text-align:left">PL Number </td>
    <td width="63%"><select name="cboPLnumber"  class="txtbox" id="cboPLnumber" style="width:220px" onchange="load_pl_format()" >
      <option value=''></option>
      <?php
                   			$str="select strPLNo,strStyle,strSailingDate,strISDno from shipmentplheader order by strPLNo desc";
                  			$exec=$db->RunQuery( $str);
									while($row=mysql_fetch_array( $exec)) 
						 			echo "<option value=".$row['strPLNo'].">".$row['strPLNo']."-".$row['strStyle']."/".$row['strSailingDate']."</option>";                 
                  			 ?>
    </select></td>
    <td width="20">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left">Report Format</td>
    <td><select name="cboRptFormat"  class="txtbox" id="cboRptFormat" style="width:220px" >
      <option value=''></option>
      <option value='packinglist_formats/gap_br.php'>GAP BR</option>
      <option value='packinglist_formats/gap_br_withWt.php'>GAP BR With Wt</option>
      <option value='packinglist_formats/gap_brWithSku.php'>GAP BR With SKU</option>
	  <option value='packinglist_formats/eddie_bauer.php'>Eddie Bauer</option>
      <option value='packinglist_formats/lands_end.php'>Lands End</option>
       <option value='packinglist_formats/trent.php'>Trent</option>
        <option value='packinglist_formats/kohls.php'>KOHL'S</option>
      <!--<option value='packinglist_formats/pl_levis_newyork.php'>Levi's</option>
      <option value='packinglist_formats/pl_levis_newyork.php'>Levi's Newyork</option>
      <option value='packinglist_formats/pl_levis_euro.php'>Levi's Europe</option>
      <option value='packinglist_formats/pl_levis_length_wise.php'>Levi's (Length Wise)</option>
      <option value='packinglist_formats/levis_color_breakdown.php'>Levi's (Color Breakdown) </option>
      <option value='packinglist_formats/pl_levis_pakistan.php'>Levi's APD </option>
      <option value='packinglist_formats/pl_levis_china.php'>Levi's China </option>
      <option value='packinglist_formats/pl_levis_hybrid.php'>Levi's Hybrid </option>
      <option value='packinglist_formats/gv_ratio.php'>GV</option>
      <option value='packinglist_formats/gv_ratio.php'>GV Ratio</option>
      <option value='packinglist_formats/gv_ratio.php'>GV Solid</option>
      <option value='packinglist_formats/gv_color_breakdown.php'>GV Solid(Color Breakdown) </option>
      <option value='packinglist_formats/gv_ratio_hanging.php'>GV Hanging </option>
      <option value='packinglist_formats/gv_color_breakdown_hanging.php'>GV Hanging(Color Breakdown) </option>
      <option value='packinglist_formats/pl_tema.php'>TEMA  </option>
      <option value='packinglist_formats/cv_summary.php'>CHARLES VOEGELE  </option>
      <option value='packinglist_formats/zolla_dpl.php'>ZOLLA DPL</option>-->      
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center" valign="middle"><img src="../images/save_small.jpg" alt="save" title="Save report format." class="mouseover" onclick="save_pl_format()" />&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/go.png" width="30" height="22" alt="go" onclick="do_print()" class="mouseover" title="Print"/></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
