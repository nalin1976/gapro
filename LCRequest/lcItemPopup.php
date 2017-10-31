<?php 
session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";
	$intMatDetailID = $_GET["intMatDetailID"];
	$rwIndex= $_GET["rwIndex"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<table width="641" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
  <tr >
    <td colspan="4" ><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="97%"  height="25" class="mainHeading">Order No Details</td>
        <td width="3%" class="mainHeading" ><img src="../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1');" align="right"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="99">&nbsp;</td>
    <td width="208">&nbsp;</td>
    <td width="94">&nbsp;</td>
    <td width="193">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">Style No</td>
    <td><select name="cboPopStyleNo" id="cboPopStyleNo" style="width:200px;">
    <option value=""></option>
    <?php 
	$sql_s = "select distinct o.strStyle from orders o inner join orderdetails od on 
o.intStyleId = od.intStyleId where od.intMatDetailID='$intMatDetailID' and intStatus not in (13,14) order by strStyle ";

	$res_S =$db->RunQuery($sql_s); 
		
		while($rowS=mysql_fetch_array($res_S))
		{
			echo "<option value=\"". $rowS["strStyle"] ."\">" . $rowS["strStyle"] ."</option>" ;
		}
	
	?>
    </select>    </td>
    <td class="normalfnt">Order No</td>
    <td><select name="cboPopOrderNo" id="cboPopOrderNo" style="width:200px;">
    <option value="" ></option>
    <?php 
	$sql_o = "select  o.intStyleId,o.strOrderNo from orders o inner join orderdetails od on 
o.intStyleId = od.intStyleId where od.intMatDetailID='$intMatDetailID' and intStatus not in (13,14) order by o.strOrderNo ";
	$res_O =$db->RunQuery($sql_o); 
		
		while($rowO=mysql_fetch_array($res_O))
		{
			echo "<option value=\"". $rowO["intStyleId"] ."\">" . $rowO["strOrderNo"] ."</option>" ;
		}
	?>
    </select>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img src="../images/view2.png" width="62" height="21" align="right" onClick="viewOrderDetails(<?php echo $intMatDetailID; ?>);"></td>
  </tr>
   <tr>
    <td colspan="4"><div id="divcons" style="overflow:scroll; height:350px; width:100%;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblPopupGrid">
        <tr class="mainHeading4">
        <td width="5%" height="20"><input name="chkItempopup" type="checkbox" id="chkItempopup" onClick="CheckAll(this,'tblPopupGrid');"></td>
          <td width="21%">Style No</td>
          <td width="22%">OrderNo</td>
          <td width="12%">OrderQty</td>
          <td width="12%">Conpc</td>
          <td width="12%">Unitprice</td>
          <td width="16%">DeliveryDate</td>
        </tr>
      </table>
 
    </div></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
      <tr>
        <td align="center"><img src="../images/addsmall.png" width="95" height="24" onClick="addStyleDetails(<?php echo $rwIndex; ?>,<?php echo $intMatDetailID; ?>)"></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
