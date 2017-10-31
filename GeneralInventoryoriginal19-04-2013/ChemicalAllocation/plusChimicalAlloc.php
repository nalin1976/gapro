<?php
	session_start();
	include "../../Connector.php";	
	include("../class.glcode.php");
	$objgl = new glcode();
	$companyId = $_SESSION["FactoryID"];
	$index	   = $_GET['index'];
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Chemical Allocation</title>
<script type="text/javascript" src="chemicalAllocation.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>

<body >
<form id="frmChemicalPlus" name="frmChemicalPlus">
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="26" class="mainHeading">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="divPopPlusChimical" style="overflow:scroll; height:300px; width:950px;">
          <table id="tblPopPlusChimical" width="1000" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="25%" height="25" >Item Description</td>
              <td width="10%" >Unit</td>
              <td width="10%" >Stock Qty</td>
              <td width="10%">Add Qty</td>
              <td width="3%"><input name="chkAll" id="chkAll" type="checkbox" onclick="CheckPlusChemAll(this,'tblPopPlusChimical');" /></td>
              <td width="10%">GRN No</td>
              <td width="10%">GL Code</td>
              <td width="22%">GL Description</td>
              </tr>
         <?php
		 $sql = "select intMatDetailId,round(sum(dblQty),2) as stockQty,
				GMIL.strItemDescription,concat(GS.intGRNNo,'/',GS.intGRNYear) as GRNNo,GS.intGLAllowId,
				GS.strUnit,GS.intCostCenterId
				from genstocktransactions GS
				inner join genmatitemlist GMIL on GMIL.intItemSerial=GS.intMatDetailId
				where strMainStoresID='$companyId'
				group by GS.intGLAllowId,GS.intCostCenterId,
				GS.strMainStoresID,GS.intGRNNo,GS.intGRNYear,
				GS.intMatDetailId
				having stockQty>0";
		$result = $db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$GLAllowId    = $row["intGLAllowId"];
			$GLCode		  = $objgl-> getGLCode($GLAllowId);
			$GLDes        = $objgl-> getGLDescription($GLAllowId);
		 ?>
         <tr class="bcgcolor-tblrowWhite">
                <td width="25%" height="20" class="normalfnt" id="<?php echo $row['intMatDetailId']; ?>"><?php echo $row['strItemDescription']?></td>
                <td width="10%" class="normalfnt" ><?php echo $row['strUnit']; ?></td>
                <td width="10%" class="normalfntRite"><?php echo $row['stockQty']; ?></td>
                <td width="10%" class="normalfntMid"><input name="txtAddQty" id="txtAddQty" type="text" class="txtbox" style="width:90px;text-align:right" value="0" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="SetQtyToArray(this,<?php echo $index;?>);" onblur="checkEmptyQty(this);"/></td>
                <td width="3%" class="normalfntMid"><input name="chkQty" id="chkQty" type="checkbox" onclick="checkAddQty(this.parentNode.parentNode);" /></td>
                <td width="10%" class="normalfntRite"><?php echo $row['GRNNo']; ?></td>
                <td width="10%" class="normalfntMid" id="<?php echo $row['intGLAllowId']; ?>"><?php echo $GLCode; ?></td>
                <td width="22%" class="normalfnt" id="<?php echo $row['intCostCenterId']; ?>"><?php echo $GLDes; ?></td>	
         </tr>
         <?php
		}
		?>
            </table>
          </div></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr >
    <td height="30"><table width="100%" border="0" class="tableBorder">
      <tr>	
        <td width="15%" class="normalfntMid">
        <img src="../../images/addsmall.png" alt="add" border="0" id="butAdd" onclick="addChemToMain();" /><img src="../../images/close.png" alt="close" border="0" id="butClose" onclick="CloseOSPopUp('popupLayer1');" />
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>