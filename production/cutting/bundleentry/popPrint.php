<?php
	session_start();
	include "../../../Connector.php";	
	$style=$_GET["styleid"];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="450" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
      
      <tr  class="mainHeading">
        <td width="94%" height="25">Cut Panel  Printer</td>
        <td width="6%"><img src="../../../images/cross.png" alt="cross" width="17" height="17" onclick="ClosePOPrintWindow();" /></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="4" cellpadding="0" class="normalfnt bcgl1" >
          <!--<tr>
            <td colspan="4" >&nbsp;</td>
            </tr>-->
          <tr>
            <td width="22%" >&nbsp;Buyer</td>
            <td colspan="3"><select name="cbopopBuyer" class="txtbox" style="width:288px" id="cbopopBuyer" onchange="popfilterStyle();" tabindex="4">
                <option value=""></option>
                <?php 
			$buyerstr="select 	intBuyerID,buyerCode,strName from buyers where intStatus=1 order by strName";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
                <option value="<?php echo $buyerrow['intBuyerID'];?>"><?php echo $buyerrow['strName'];?></option>
                <?php } ?>
            </select> </td>
            </tr>
          <tr>
            <td nowrap="nowrap">&nbsp;PO No / Style No&nbsp;</td>
            <td colspan="3"><select name="cmbpopStyle" class="txtbox" style="width:288px" id="cmbpopStyle" tabindex="2"  onchange="pop_cutnos();">
                <option value=""></option>
                   <?php 
			$strpo="select  scch.intStyleId,strStyle,strOrderNo from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId  where orders.intStatus in(0,10,11) order by strOrderNo";
		
			$poresults=$db->RunQuery($strpo);			
			while($porow=mysql_fetch_array($poresults))
			{
			?>
                <option value="<?php echo $porow['intStyleId'];?>"><?php echo $porow['strOrderNo'].' / '.$porow['strStyle'];?></option>
             <?php } ?>
            </select></td>
            </tr>
          
          <tr>
            <td >&nbsp;Cut No</td>
            <td width="29%"><select name="cmbpopCutNo" class="txtbox" style="width:120px;" id="cmbpopCutNo"  tabindex="5" onchange="load_sizes_to_print(this);">
                <option value=""></option>
                <?php $str_cutno="select strCutNo from productionbundleheader where intStyleId='$style' order by strCutNo";
			$result_cut=$db->RunQuery($str_cutno);
			while($row=mysql_fetch_array($result_cut)){?>
                <option value="<?php echo $row['strCutNo'];?> "><?php echo $row['strCutNo'];?></option>
                <?php }?>
            </select></td>
            <td width="9%">&nbsp;Sizes</td>
            <td width="40%"><select name="cmbPopBundleSizes" class="txtbox" style="width:120px;" id="cmbPopBundleSizes"  tabindex="5" >
              <option value="all"></option>
              <?php $str_cutno="select strCutNo from productionbundleheader where intStyleId='$style' order by strCutNo";
			$result_cut=$db->RunQuery($str_cutno);
			while($row=mysql_fetch_array($result_cut)){?>
              <option value="<?php echo $row['strCutNo'];?> "><?php echo $row['strCutNo'];?></option>
              <?php }?>
            </select></td>
          </tr>

        </table></td>
      </tr>
      
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bcgl1 normalfnt">
          <tr>
            <td colspan="3" class="mainHeading2" style="text-align:left">Options</td>
            </tr>
          <tr>
            <td width="14%" height="25"><div align="center">
              <input type="radio" name="print_option" id="rpt1" class="txtbox" checked="checked" />
            </div></td>
            <td width="56%">Bundle Summary Report </td>
            <td width="30%">&nbsp;</td>
          </tr>
          <tr>
            <td height="25"><div align="center">
              <input type="radio" name="print_option" id="rpt2" class="txtbox" />
            </div></td>
            <td>Bundle Sticker</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25"><div align="center">
              <input type="radio" name="print_option" id="rpt4" class="txtbox" />
            </div></td>
            <td>Stickers in A4 Sheets </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25"><div align="center">
              <input type="radio" name="print_option" id="rpt3" class="txtbox" />
            </div></td>
            <td>Specific Component Sticker</td>
            <td>&nbsp;</td>
          </tr>
         <!-- <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>-->
        </table></td>
      </tr>
      <tr><td colspan="2" align="center"><div id="divcons"  class="bcgl1" style="overflow:scroll; height:177px; width:99%;">
      <table width="100%"  cellpadding="3" cellspacing="1" bgcolor="#996f03" id="tblpopprintSizes">
        <tr class="mainHeading4">
          <td width="20%" height="25" >Select</td>
          <td width="80%" >Component</td>
        </tr>
      </table>
    </div></td></tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder">
          <tr>
            <td width="15%" class="normalfntMid">
            <img src="../../../images/print.png" alt="s"   onclick="bundlesummery()" />
            <img src="../../../images/close.png" alt="c"   class="mouseover" onclick="ClosePOPrintWindow();" />
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
