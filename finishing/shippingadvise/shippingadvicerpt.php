<?php
include "../../Connector.php";
include "../../eshipLoginDB.php";	
$backwardseperator 	= "../../";
$report_companyId  = $_SESSION["FactoryID"];
$userId			   = $_SESSION["UserID"];
$shipAdvNo         = $_GET["shipAdvNo"];
$shipAdvArray 	   = explode('/',$shipAdvNo);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shipping Advise</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center">
<tr>
	<td colspan="13"><?php include '../../reportHeader.php'?></td>
</tr>
  <tr>
    <td colspan="5"><table width="100%" cellpadding="0" cellspacing="0" >
     
	  <tr>
	    <td colspan="5">&nbsp;</td>
	    <td colspan="6" class="normalfnt">&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="5">&nbsp;</td>
	    <td colspan="6" class="normalfnt"><u><strong>	SHIPPING ADVICE :</strong></u></td>
	  </tr>
	  <tr>
	    <td width="5%"  class="normalfnt"><b>&nbsp;TO</b></td>
	    <td width="1%" class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	    <td width="16%">&nbsp;</td>
	    <td width="9%" class="normalfnt"><b>&nbsp;Date Advised</b></td>
	    <td width="1%" class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td class="normalfnt"><b>&nbsp;ATTN</b></td>
	    <td  class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="normalfnt"><b>&nbsp;Prepared by</b></td>
	    <td  class="normalfnt" >&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="normalfnt">&nbsp;<b>Q.A</b></td>
	    <td  class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="normalfnt">&nbsp;<b>M/DISER</b></td>
	    <td  class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="normalfnt">&nbsp;<b>TTL Dns Shpd</b></td>
	    <td  class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="normalfnt">&nbsp;<b>Ref #</b></td>
	    <td  class="normalfnt">&nbsp;:</td>
	    <td colspan="3" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3" class="normalfnt">&nbsp;<b>Vessel/Voyage/Flight #</b></td>
	    <td width="1%" class="normalfnt">&nbsp;:</td>
	    <td width="32%">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td width="12%">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3" class="normalfnt"><b>&nbsp;Ship/Airline/truck</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3" class="normalfnt"><b>&nbsp;ETD</b></td>
	    <td width="1%" class="normalfnt">&nbsp;:</td>
	    <td width="18%" class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3" class="normalfnt"><b>Container Seal # </b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3" class="normalfnt"><b>&nbsp;ETA</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3" class="normalfnt"><b>&nbsp;Port of Loading</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3" class="normalfnt"><b>&nbsp;TTL Doszs Shipped</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3" class="normalfnt"><b>&nbsp;Destination</b></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3" class="normalfnt"><b>&nbsp;TTL Gross Weight</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3" class="normalfnt"><b>&nbsp;Shipment Type</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="3" class="normalfnt"><b>&nbsp;TTL Net Weight</b></td>
	    <td class="normalfnt">&nbsp;:</td>
	    <td class="normalfnt">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="5">&nbsp;</td>
	    <td colspan="6">&nbsp;</td>
	    </tr>
		
	  <tr>
	    <td colspan="11"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablez">
          <tr>
            <td width="1%" class="normalfntBtab" nowrap="nowrap">#</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">PO #</td>
            <td width="0%" class="normalfntBtab" nowrap="nowrap">&nbsp;Mondial PO # </td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Product Code </td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Material #</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Color</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Dim</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">DO #</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">ISD #</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Inspected<br />Dozens</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Po Recap<br />
            PCS</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Shpd<br />
            PCS</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Bundle</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Mode</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap" >Ctns</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Item # </td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Pre pack<br />code</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Bal Status</td>
			<td width="3%" class="normalfntBtab" nowrap="nowrap">DC</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">GV<br />FOB</td>
            <td width="3%" class="normalfntBtab"  nowrap="nowrap">Maker<br />FOB</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Total<br />invoice FOB</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Quota<br />Cost $'s</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Terms</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Container<br />/MAWB #</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">B.O.L # /<br />HAWB #</td>
            <td width="3%" class="normalfntBtab"  nowrap="nowrap">Maker</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Comment's</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Hanger<br />Atch'd Y/N</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Price sticker<br />Y/N</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Lycra Tag<br />Y/N</td>
            <td width="3%" class="normalfntBtab" nowrap="nowrap">Ticket<br />Atch'd Y/N</td>
            </tr>
			<?php
			$i = 1;
			$tot_ins = 0;
			$tot_ship = 0;
			$tot_ctns = 0;
			$sql = "select distinct O.strOrderNo,O.strStyle,FOS.strMondialPONo,FOS.strMaterialNo,O.strOrderColorCode,
					(select strDescription from shipmentmode S where S.intShipmentModeId=FSAH.intShipmentModeId) as modeType,
					FOS.strItemNo,FOS.strPrePackCode,FSAD.intPLNo,O.intQty
					from finishing_shipping_advise_detail FSAD
					left join orders O on FSAD.intStyleId = O.intStyleId
					left join finishing_order_spec FOS on FOS.intStyleId = FSAD.intStyleId
					left join finishing_shipping_advise_header FSAH on FSAH.intShippingAdviseNo=FSAD.intShippingAdviseNo and
					FSAH.intShippingAdviseYear=FSAD.intShippingAdviseYear 
					where FSAD.intShippingAdviseNo='$shipAdvArray[0]' and FSAD.intShippingAdviseYear = '$shipAdvArray[1]';";
					
			$result=$db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				$PLNo      = $row["intPLNo"];
				$shipArray = (getShipData($PLNo));
				$inspectedDz = ($shipArray[0]/12);
				$tot_ins+=$inspectedDz;
				$tot_ship+=$shipArray[0];
				$tot_ctns+=$shipArray[1];
				$status = ($row["intQty"]<=$shipArray[0]?"NO BAL":"TO BE ADVICE");
		?>
			<tr>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo $i; ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strOrderNo"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strMondialPONo"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strStyle"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strMaterialNo"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strOrderColorCode"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" style="text-align:right" nowrap="nowrap"><?php echo number_format($inspectedDz,2); ?></td>
			  <td class="normalfntTAB" style="text-align:right" nowrap="nowrap"><?php echo ($row["intQty"]); ?></td>
			  <td class="normalfntTAB" style="text-align:right" nowrap="nowrap"><?php echo ($shipArray[0]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["modeType"]); ?></td>
			  <td class="normalfntTAB" style="text-align:right" nowrap="nowrap"><?php echo ($shipArray[1]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strItemNo"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo ($row["strPrePackCode"]); ?></td>
			  <td class="normalfntTAB" nowrap="nowrap"><?php echo $status; ?></td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  </tr>
		<?php
			$i++;
		}
		?>
			<tr>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  </tr>
			<tr>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			  </tr>
			<tr>
            <td colspan="9" nowrap="nowrap" class="normalfntTAB">&nbsp;<b>TOTALS :</b>   </td>
            <td width="3%" class="normalfntTAB" style="text-align:right" nowrap="nowrap"><b><?php echo $tot_ins; ?></b></td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" style="text-align:right" nowrap="nowrap"><b><?php echo $tot_ship; ?></b></td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" style="text-align:right" nowrap="nowrap"><b><?php echo $tot_ctns; ?></b></td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
			<td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            <td width="3%" class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
            </tr>
        </table></td>
	    </tr>
	  
	  <tr>
	    <td colspan="11">&nbsp;</td>
	    </tr>
	  <tr>
	  	<td colspan="11" class="normalfnt">&nbsp;&bull; <b>Shipping advice MUST! Be faxed to Production: 2days after vessel sails. Air advises MUST! Be faxed the very next day</b></td>
	  </tr>
	  <tr>
	    <td colspan="11" class="normalfnt">&nbsp;&bull;&nbsp;&nbsp;<b>Always attach the packing list for soild size /soild color orders.</b></td>
	    </tr>
	  <tr>
	    <td colspan="11" class="normalfnt">&nbsp;&bull;&nbsp;&nbsp;<b>Must total ctns/dzs by maker.*** Total Inv: FOB = Maker FOB x Dz = Paid to bank by Import Dept. (Ashok Fatnani)</b></td>
	    </tr>
	  <tr>
	    <td colspan="11" class="normalfnt">&nbsp;&bull; <b>Inv ,Packing List &amp; Awb Or Bill of Lading Must be faxed with shipment advise. </b></td>
	    </tr>
	  <tr>
	    <td colspan="11" class="normalfnt">&nbsp;&bull; <b>Must total ctns/dzs by Vessel.</b></td>
	    </tr>
	  <tr>
	  	<td colspan="11" class="normalfnt">&nbsp;&nbsp;&nbsp;<b></b> </td>
	  </tr>
    </table></td>
  </tr>
 </table>
 <?php
 function getShipData($PLNo)
 {
 	$eshipDB = new eshipLoginDB();
	$sql = "select sum(dblQtyPcs) as dblQty,sum(dblNoofCTNS) as dblNoofCTNS
			from shipmentpldetail
			where strPLNo='$PLNo'
			group by strPLNo ;";
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$Qty  = $row["dblQty"];
	$ctns = $row["dblNoofCTNS"];
	
	return array ($Qty,$ctns);

	
 }
 ?>
</body>
</html>