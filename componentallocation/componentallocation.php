<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Component Allocation</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="componentallocation.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<style type="text/css">
<!--

-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td align="center"><table width="700" border="0" cellspacing="3" cellpadding="0" class="tableBorder">
      <tr>
        <td class="mainHeading">Component Allocation</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1">
          <tr>
            <td width="15%" height="25">&nbsp;&nbsp;&nbsp;Buyer</dd></td>
            <td width="30%"><select name="cmbBuyer" class="txtbox" id="cmbBuyer" style="width:200px" onchange=" stylefilter();">
              <option value=""></option>
              <?php 
			$buyerstr="select 	intBuyerID,strName from buyers where intStatus=1 order by strName ";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
              <option value="<?php echo $buyerrow['intBuyerID'];?>"><?php echo $buyerrow['strName'];?></option>
              <?php } ?>
            </select></td>
            <td width="20%">&nbsp;&nbsp;&nbsp;PO No / Style No <span class="compulsoryRed"> *</span></td>
            <td width="35%"><select name="cmbStyle" class="txtbox" id="cmbStyle" style="width:200px" onchange=" getStyleData();">
            <option value=""></option>
			  <?php 
			$buyerstr="select intStyleId,concat(strOrderNo,'/ ',strStyle) as strOrderNo,strStyle from orders where intStatus=11 order by strOrderNo  ";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
             <option value="<?php echo $buyerrow['intStyleId'];?>"><?php echo $buyerrow['strOrderNo']?></option>
              <?php } ?>
             
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;Qty Pcs</td>
            <td height="30"><input name="txtQty" type="text" class="txtbox" maxlength="15" id="txtQty" style="text-align:right; width:198px"  tabindex="7" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
            <td>&nbsp;&nbsp;&nbsp;Accumulated Qty Pcs</td>
            <td><input name="txtActualQty" type="text" class="txtbox" maxlength="15" id="txtActualQty"  tabindex="7"  style="text-align:right; width:198px" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
          </tr>
          
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1">
          <tr>
            <td width="15%" height="30">&nbsp;&nbsp;&nbsp;Category</td>
            <td width="35%"><select name="cmbCategoryId" class="txtbox" id="cmbCategoryId" style="width:200px" onchange=" getComponent();">
              <option value=""></option>
              <?php 
			$str="select 	intCategoryNo, 
					strCategory
					from 
					component_category 
					where intStatus=1
					order by strCategory";
		
			$results=$db->RunQuery($str);
			
			while($row=mysql_fetch_array($results))
			{
		?>
              <option value="<?php echo $row['intCategoryNo'];?>"><?php echo $row['strCategory'];?></option>
              <?php } ?>
            </select></td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
              <td class="mainHeading2" style="text-align:left">Components</td>        
              
              <td>&nbsp;</td>
              
              <td class="mainHeading2" style="text-align:left">Allocated Components</td>
              </tr>
              <tr>
                <td width="46%" align="center"><div id="divcons"  style="overflow:scroll; height:250px; width:100%;">
        <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblComponent">
          <tr class="mainHeading4" >
            <td width="45%" height="25" >Component</td>
            <td width="55%" >Description</td>
          </tr>
        </table>
      </div>
    </div></td>
                <td width="8%" class="bcgl1"><table width="100%" border="0"  cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" height="25"><img src="../../images/bw.png" alt="fw" width="18" height="19" class="mouseover" onclick="allocateComponent()"/></td>
                  </tr>
                  <tr>
                    <td align="center" height="25"><img src="../../images/fw.png" alt="bw" width="18" height="19" class="mouseover" onclick="removeComponent()"/></td>
                  </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" height="25"><img src="../../images/ff.png" alt="af" width="18" height="19" class="mouseover" onclick="allocate_all_Component();"/></td>
                  </tr>
                  <tr>
                    <td align="center" height="25"><img src="../../images/fb.png" alt="ab" width="18" height="19" class="mouseover" onclick="remove_all_Component();" /></td>
                  </tr>
                </table></td>
                <td width="45%" align="center"><div id="divcons"  style="overflow:scroll; height:250px; width:100%;">
        <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblallowComp">
          <tr class="mainHeading4">
            
            <td width="46%" height="25">Component</td>
            <td width="55%" >Description</td>
          </tr>
        </table>
      </div></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
          <tr>
            <td width="19%" height="30"><div align="center"></div></td>
            <td width="15%"><img src="../../images/new.png" alt="n" width="96" height="24" class="mouseover" onclick="form_clear()"/></td>
            <td width="15%"><div align="center"><img src="../../images/save.png" alt="s" width="84" height="24" class="mouseover" onclick="saveHeader();" /></div></td>
            <td width="17%"><div align="center"><img src="../../images/delete.png" alt="d" width="100" height="24" class="mouseover" onclick="delete_style_allo();" /></div></td>
            <td width="17%"><div align="center"><a href="../../main.php" ><img src="../../images/close.png" alt="c" width="104" height="24" class="mouseover noborderforlink" /></a></div></td>
            <td width="17%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
