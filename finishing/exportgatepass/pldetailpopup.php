<?php
	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	include "../../eshipLoginDB.php";
	$orderNo = $_GET["orderNo"];	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td width="610" ><table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="575" class="mainHeading">Shipment Packing List Search</td>
    <td width="25" class="mainHeading"><img src="../../images/cross.png" width="17" height="17" align="right" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table></td>
  </tr>
<tr>
<td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
  <tr bgcolor="#FAD163" class="tableBorder">
    <td ><table width="100%" border="0" cellspacing="2" cellpadding="0" >
        <tr>
          <td width="33" class="normalfnt">PL No </td>
          <td width="120"  ><select name="cboPLNo" id="cboPLNo" style="width:120px;">
             <option value=""></option> 
              <?php 
			$eshipDB = new eshipLoginDB();
			$buyerstr="select distinct strPLNo from shipmentplheader order by strPLNo desc";
		
			$buyerresults=$eshipDB->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
          <option value="<?php echo $buyerrow['strPLNo'];?>"><?php echo $buyerrow['strPLNo'];?></option>
          <?php } ?>
            </select>
          </td>
          <td width="42"  class="normalfnt">PO No </td>
          <td width="126"  ><select name="cboPONo" id="cboPONo" style="width:120px;" disabled="disabled">
               <option value="<?php echo $orderNo; ?>"><?php echo $orderNo; ?></option> 
              <?php 
			$eshipDB = new eshipLoginDB();
			$buyerstr="select distinct strStyle from shipmentplheader order by strStyle";
		
			$buyerresults=$eshipDB->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
          <option value="<?php echo $buyerrow['strStyle'];?>"><?php echo $buyerrow['strStyle'];?></option>
          <?php } ?>
            </select>
          </td>
          <td width="51"  class="normalfnt">Style No </td>
          <td width="120"  ><select name="cboStyleNo" id="cboStyleNo" style="width:120px;">
             
              <?php 
			$eshipDB = new eshipLoginDB();
			$buyerstr="select distinct strProductCode from shipmentplheader order by strProductCode";
		
			$buyerresults=$eshipDB->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
          <option value="<?php echo $buyerrow['strProductCode'];?>"><?php echo $buyerrow['strProductCode'];?></option>
          <?php } ?>
          </select></td>
          <td width="86"><img src="../../images/search.png" alt="searchpop" align="right" onClick="loadPlData();"></td>
        </tr>
    </table></td>
  </tr>
  
</table>
</td>
</tr>
 
  <tr>
    <td><div id="delPopup" style="width:600px; height:200px; overflow:scroll;">
      <table width="600" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="popupPlSearch">
        <tr class="mainHeading4">
          <td width="27" height="20">&nbsp;</td>
          <td width="154">PL No </td>
          <td width="168">Date</td>
          <td width="107">PO No </td>
          <td width="112">Style No </td>
          <td width="96">Item</td>
          <td width="128">Qty</td>
        </tr>
      </table>
    
    </div></td>
  </tr>
  
   <tr>
    <td height="5"></td>
  </tr>
</table>
</body>
</html>
