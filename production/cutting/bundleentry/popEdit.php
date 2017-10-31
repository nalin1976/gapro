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
<table width="450" height="330" border="0" cellspacing="3" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
      <tr>
        <td><div align="right"><img src="../../../images/closelabel.gif" alt="close" width="66"  onclick="closeWindow();" /></div></td>
      </tr>
      <tr>
        <td class="mainHeading"  style="text-align:left">Edit Cut Details </td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1" >
          <!--<tr>
            <td colspan="4" >&nbsp;</td>
            </tr>-->
          <tr>
            <td width="20%" height="30"><dd>Buyer</dd></td>
            <td width="30%"><select name="cbopopBuyer" class="txtbox" style="width:120px" id="cbopopBuyer" onchange="popfilterStyle();" tabindex="4">
                <option value=""></option>
                <?php 
			$buyerstr="select 	intBuyerID,buyerCode,strName from buyers where intStatus=1  order by strName ";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
                <option value="<?php echo $buyerrow['intBuyerID'];?>"><?php echo $buyerrow['strName'];?></option>
                <?php } ?>
            </select></td>
            <td width="20%">&nbsp;Style/PO No</td>
            <td width="30%"><select name="cmbpopStyle" class="txtbox" style="width:120px" id="cmbpopStyle" tabindex="2"  onchange="pop_edit_cutnos();">
                <option value=""></option>
                   <?php 
			$strpo="select 	intStyleId, strStyle from orders where intStatus=11 order by strStyle ";
		
			$poresults=$db->RunQuery($strpo);
			
			while($porow=mysql_fetch_array($poresults))
			{?>
                <option value="<?php echo $porow['intStyleId'];?>"><?php echo $porow['strStyle'];?></option>
             <?php } ?>
            </select></td>
          </tr>
          
          <tr>
            <td height="30"><dd>Cut No</dd></td>
            <td><select name="cmbpopEditCut" class="txtbox" style="width:120px;" id="cmbpopEditCut"  tabindex="5"  onchange="load_edit_size_grid();">
                <option value=""></option>
                <?php $str_cutno="select strCutNo from productionbundleheader where intStyleId='$style' order by strCutNo";
			$result_cut=$db->RunQuery($str_cutno);
			while($row=mysql_fetch_array($result_cut)){?>
                <option value="<?php echo $row['strCutNo'];?> "><?php echo $row['strCutNo'];?></option>
                <?php }?>
            </select></td>
            <td colspan="2">&nbsp;</td>
          </tr>

        </table></td>
      </tr>
      
      <tr>
        <td class="mainHeading2" style="text-align:left">Edit Sizes </td>
      </tr>
      <tr><td align="center"><div id="divcons"  class="bcgl1" style="overflow:scroll; height:150px; width:99%;">
      <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblChangeSizes">
        <tr class="mainHeading4">
          <td width="20%" height="25" >&nbsp;</td>
          <td width="40%" height="25" >Old Size</td>
          <td width="40%" >New Size</td>
        </tr>
      </table>
    </div></td></tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder">
          <tr>
            
            <td width="33%"><div align="center"><img src="../../../images/save.png" alt="save" width="84" height="24" onclick="save_cut_change()"/></div></td>
            <td width="33%"><div align="center"><img src="../../../images/delete.png" alt="delete" width="100" height="24" onclick="delete_cut()"/></div></td>
            <td width="33%" align="center"> 
              <img src="../../../images/close.png" alt="c"  class="mouseover" onclick="closeWindow();"  />
           </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
