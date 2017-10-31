<?php 
session_start();

include "../../Connector.php";
$backwardseperator = "../../";
$StyleID = $_GET["StyleID"];
$MatDetailID = $_GET["MatDetailID"];
$companyId  	= $_SESSION["FactoryID"];
$report_companyId   = $companyId;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Item Stock Movement</title>
<link href="../../css/erpstyle.css" rel="stylesheet" />

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td class="head2BLCK">Stock Movement - <?php echo getItemName($MatDetailID); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td class="normalfnBLD1" height="25">PO Details</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
        <?php 
		$sql_po = "select distinct ph.intPONo,ph.intYear, c.strName as diverToCompamy,
cur.strTitle,DATE_FORMAT(ph.dtmDeliveryDate, '%d-%M-%Y') as DeliveryDate, s.strTitle as Supplier
 from purchaseorderheader ph 
inner join purchaseorderdetails pd on ph.intPONo = pd.intPoNo and ph.intYear = pd.intYear
inner join companies c on c.intCompanyID = ph.intDelToCompID
inner join currencytypes cur on cur.intCurID = ph.strCurrency
inner join suppliers s on s.strSupplierID = ph.strSupplierID
where ph.intStatus=10 and pd.intStyleId='$StyleID' and pd.intMatDetailID='$MatDetailID'";
		$res_po = $db->RunQuery($sql_po);
		while($row_po = mysql_fetch_array($res_po))
		{
			$poNo = $row_po["intYear"].'/'.$row_po["intPONo"];
		?>
          <tr bgcolor="#E4E4E4">
            <td width="61" class="normalfnt" height="20">PO No :</td>
            <td width="96" class="normalfnt"><?php echo $poNo; ?></td>
            <td width="65" class="normalfnt">Supplier :</td>
            <td width="256" class="normalfnt"><?php echo $row_po["Supplier"]; ?></td>
            <td width="71" class="normalfnt">Currency :</td>
            <td width="75" class="normalfnt"><?php echo $row_po["strTitle"]; ?></td>
            <td width="77" class="normalfnt">Deliver To :</td>
            <td width="282" class="normalfnt"><?php echo $row_po["diverToCompamy"]; ?></td>
            <td width="90" class="normalfnt">Delivery Date</td>
            <td width="107" class="normalfnt"><?php echo $row_po["DeliveryDate"]; ?></td>
          </tr>
          <tr><td colspan="10"><table width="668" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="146" height="20" class="normalfntMid">Color</th>
              <th width="115" class="normalfntMid">Size</th>
              <th width="94" class="normalfntMid">Unit</th>
              <th class="normalfntMid">PO Qty</th>
              <th width="106" class="normalfntMid">Unit Price</th>
               <th width="96" class="normalfntMid">Value</th>
            </tr>
            <?php 
				$sql_poDet = "select pd.strColor,pd.strSize,pd.strUnit,pd.dblUnitPrice,pd.dblQty 
				 from purchaseorderdetails pd
where pd.intStyleId='$StyleID' and pd.intMatDetailID='$MatDetailID' and pd.intPoNo='".$row_po["intPONo"]."' and pd.intYear='".$row_po["intYear"]."'";

				$res_pod = $db->RunQuery($sql_poDet);
				while($row_pod = mysql_fetch_array($res_pod))
				{
					$value = $row_pod["dblQty"]*$row_pod["dblUnitPrice"];
			?>
            <tr class="bcgcolor-tblrowWhite">
              <td class="normalfnt" height="20"><?php echo $row_pod["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_pod["strSize"]; ?></td>
              <td class="normalfnt"><?php echo $row_pod["strUnit"]; ?> </td>
              <td class="normalfntR"><?php echo $row_pod["dblQty"]; ?></td>
              <td class="normalfntR"><?php echo $row_pod["dblUnitPrice"]; ?></td>
               <td class="normalfntR"><?php echo number_format($value,4); ?></td>
               <?php 
			   }
			   ?>
            </tr>
          </table>
</td>
          </tr>
          <?php 
		  }
		  ?>
         
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnBLD1" height="25">GRN Details</td>
      </tr>
      <tr>
      	<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_grn = "select distinct gh.intGrnNo,gh.intGRNYear,gh.intPoNo,gh.intYear,gh.strInvoiceNo
from grnheader gh inner join grndetails gd on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear=gd.intGRNYear
where gh.intStatus=1 and gd.intStyleId='$StyleID' and gd.intMatDetailID='$MatDetailID'";
		$res_grn = $db->RunQuery($sql_grn);
		while($row_grn = mysql_fetch_array($res_grn))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="7%" height="20" class="normalfnt">GRN No :</td>
            <td width="11%" class="normalfnt"><?php echo $row_grn["intGRNYear"].'/'.$row_grn["intGrnNo"]; ?></td>
            <td width="6%" class="normalfnt">PO No :</td>
            <td width="12%" class="normalfnt"><?php echo $row_grn["intYear"].'/'.$row_grn["intPoNo"]; ?></td>
            <td width="8%" class="normalfnt">Invoice No :</td>
            <td width="17%" class="normalfnt"><?php echo $row_grn["strInvoiceNo"]; ?></td>
            <td width="5%" class="normalfnt">&nbsp;</td>
            <td width="10%" class="normalfnt">&nbsp;</td>
            <td width="7%" class="normalfnt">Main Store :</td>
            <td width="17%" class="normalfnt"><?php echo getGRNMainStore($row_grn["intGRNYear"],$row_grn["intGrnNo"]); ?></td>
          </tr>
          <tr><td colspan="10"><table width="68%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="16%" height="20" class="normalfntMid">Color</th>
              <th width="15%" class="normalfntMid">Size</th>
              <th width="12%" class="normalfntMid">Unit</th>
              <th width="14%" class="normalfntMid">PO Qty</th>
              <th width="14%" class="normalfntMid">GRN Qty</th>
              <th width="13%" class="normalfntMid">PO price</th>
              <th width="16%" class="normalfntMid">Value</th>
            </tr>
             <?php 
		  	 $sql_grnD = "select sum(st.dblQty) as grnQty,st.strColor,st.strSize,pd.strUnit,pd.dblUnitPrice as POprice,pd.dblQty as POqty 
from stocktransactions st 
inner join grnheader gh on gh.intGrnNo = st.intGrnNo and gh.intGRNYear = st.intGrnYear
 inner join purchaseorderdetails pd on pd.intPoNo = gh.intPoNo and pd.intYear = gh.intYear
 and pd.intStyleId = st.intStyleId and pd.intMatDetailID = st.intMatDetailId and pd.strColor = st.strColor and
pd.strSize = st.strSize
where st.intGrnNo='".$row_grn["intGrnNo"]."' and st.intGrnYear='".$row_grn["intGRNYear"]."' and st.intStyleId='$StyleID' and st.intMatDetailId='$MatDetailID' and 
strType in ('GRN','STNT') and st.strGRNType='S'
group by st.strColor,st.strSize" ;	
		$res_grnD = $db->RunQuery($sql_grnD);
		while($row_grnD = mysql_fetch_array($res_grnD))
		{
			$GRNvalue = $row_grnD["grnQty"]*$row_grnD["POprice"];
		  ?>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20"><?php echo $row_grnD["strColor"];?></td>
              <td class="normalfnt"><?php echo $row_grnD["strSize"];?></td>
              <td class="normalfnt"><?php echo $row_grnD["strUnit"];?></td>
              <td class="normalfntR"><?php echo $row_grnD["POqty"];?></td>
              <td class="normalfntR"><?php echo $row_grnD["grnQty"];?></td>
              <td class="normalfntR"><?php echo $row_grnD["POprice"];?></td>
              <td class="normalfntR"><?php echo number_format($GRNvalue,4);?></td>
            </tr>
            <?php 
			}
			?>
          </table></td></tr>
         
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnBLD1" height="25">Bulk Allocation Details</td>
      </tr>
       <tr>
        <td><table width="62%" border="0" cellspacing="0" cellpadding="1">
       <?php 
	   $sql_BAllo = "select distinct cbh.intTransferNo,cbh.intTransferYear,cbh.intMainStoresID
from commonstock_bulkheader cbh inner join commonstock_bulkdetails cbd on 
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intStatus=1 and cbh.intToStyleId='$StyleID' and cbd.intMatDetailId='$MatDetailID' ";
		$res_BAllo = $db->RunQuery($sql_BAllo);
		while($row_BAllo = mysql_fetch_array($res_BAllo))
		{
			$mainStore = getMainStore($row_BAllo["intMainStoresID"]);
	   ?>
          <tr bgcolor="E4E4E4">
            <td width="19%" height="20" class="normalfnt">Bulk Allocation No :</td>
            <td width="29%" class="normalfnt"><?php echo $row_BAllo["intTransferYear"].'/'.$row_BAllo["intTransferNo"]; ?></td>
            <td width="12%" class="normalfnt">Main Store :</td>
            <td width="40%" class="normalfnt"><?php echo $mainStore ?></td>
          </tr>
          <tr><td colspan="4"><table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="16%" height="21" class="normalfntMid">Bulk PO No</th>
              <th width="17%" class="normalfntMid">Bulk GRN No</th>
              <th width="14%" class="normalfntMid">Color</th>
              <th width="9%" class="normalfntMid">Size</th>
              <th width="12%" class="normalfntMid">Units</th>
              <th width="11%" class="normalfntMid">PO price</th>
              <th width="11%" class="normalfntMid">Allo Qty</th>
              <th width="10%" class="normalfntMid">Value</th>
            </tr>
            <?php 
			$sql_BAlloD = "select cbd.intBulkPoNo,cbd.intBulkPOYear,cbd.intBulkGrnNo,cbd.intBulkGRNYear,cbd.strColor,
cbd.strSize,cbd.strUnit,cbd.dblQty,po.dblUnitPrice
from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on 
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
inner join bulkpurchaseorderdetails po on po.intBulkPoNo = cbd.intBulkPoNo and po.intYear = cbd.intBulkPOYear
and cbd.intMatDetailId = po.intMatDetailId
where cbh.intToStyleId='$StyleID' and cbd.intMatDetailId='$MatDetailID' and cbh.intTransferNo='".$row_BAllo["intTransferNo"]."' and cbh.intTransferYear='".$row_BAllo["intTransferYear"]."' ";
		//echo $sql_BAlloD;
		$res_BAlloD = $db->RunQuery($sql_BAlloD);
		while($row_BAlloD = mysql_fetch_array($res_BAlloD))
		{
			$value = $row_BAlloD["dblUnitPrice"]*$row_BAlloD["dblQty"];
			?>
            <tr bgcolor="#FFFFFF">
              <td height="20" class="normalfnt"><?php echo  $row_BAlloD["intBulkPOYear"].'/'.$row_BAlloD["intBulkPoNo"]; ?></td>
              <td class="normalfnt"><?php echo  $row_BAlloD["intBulkGrnNo"].'/'.$row_BAlloD["intBulkGrnNo"]; ?></td>
              <td class="normalfnt"><?php echo $row_BAlloD["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_BAlloD["strSize"]; ?></td>
              <td class="normalfnt"><?php echo $row_BAlloD["strUnit"]; ?></td>
              <td class="normalfntR"><?php echo $row_BAlloD["dblUnitPrice"]; ?></td>
              <td class="normalfntR"><?php echo $row_BAlloD["dblQty"]; ?></td>
              <td class="normalfntR"><?php echo number_format($value,4); ?></td>
            </tr>
            <?php 
		}	
			?>
          </table></td></tr>
          <?php 
		 }
		  ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td class="normalfnBLD1" height="25">Leftover Allocation Details</td>
      </tr>
       <tr>
        <td><table width="69%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_LAllo = "select distinct clh.intTransferNo,clh.intTransferYear,clh.intMainStoresId
from commonstock_leftoverheader clh inner join commonstock_leftoverdetails cld on 
clh.intTransferNo = cld.intTransferNo and clh.intTransferYear=cld.intTransferYear
where clh.intStatus=1 and clh.intToStyleId='$StyleID' and cld.intMatDetailId='$MatDetailID' ";
		$res_LAllo = $db->RunQuery($sql_LAllo);
		while($row_LAllo = mysql_fetch_array($res_LAllo))
		{
			$mainStore = getMainStore($row_LAllo["intMainStoresId"]);
		?>
          <tr bgcolor="#E4E4E4">
            <td width="21%" height="20" class="normalfnt"> Leftover Allocation No :</td>
            <td width="27%" class="normalfnt"><?php echo $row_LAllo["intTransferYear"].'/'.$row_LAllo["intTransferNo"]; ?></td>
            <td width="16%" class="normalfnt">Main Store :</td>
            <td width="36%" class="normalfnt"><?php echo $mainStore; ?></td>
          </tr>
          <tr><td colspan="4"><table width="67%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="34%" height="20" class="normalfntMid">Color</th>
              <th width="25%" class="normalfntMid">Size</th>
              <th width="23%" class="normalfntMid">Unit</th>
              <th width="18%" class="normalfntMid">Allo Qty</th>
            </tr>
            <?php 
			$sql_LAlloD = "select cld.strColor,cld.strSize,cld.strUnit,cld.dblQty
from commonstock_leftoverdetails cld inner join commonstock_leftoverheader clh on
clh.intTransferNo = cld.intTransferNo and clh.intTransferYear = cld.intTransferYear
where clh.intToStyleId='$StyleID' and cld.intMatDetailId='$MatDetailID' and clh.intTransferNo = '".$row_LAllo["intTransferNo"]."' and clh.intTransferYear = '".$row_LAllo["intTransferYear"]."'";
			$res_LAlloD = $db->RunQuery($sql_LAlloD);
		while($row_LAlloD = mysql_fetch_array($res_LAlloD))
		{
			?>
            <tr bgcolor="#FFFFFF">
              <td height="20" class="normalfnt"><?php echo $row_LAlloD["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_LAlloD["strSize"]; ?></td>
              <td class="normalfnt"><?php echo $row_LAlloD["strUnit"]; ?></td>
              <td class="normalfntR"><?php echo $row_LAlloD["dblQty"]; ?></td>
            </tr>
           <?php 
		   }
		   ?> 
          </table></td></tr>
         <?php 
		 }
		 ?> 
        </table></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnBLD1" height="25">MRN Details</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php 
		$sql_mrn = "select distinct mrn.intMatRequisitionNo, mrn.intMRNYear,DATE_FORMAT(mrn.dtmDate, '%d-%M-%Y') as mrnDate ,d.strDepartment, ms.strName as mainstore
from matrequisition mrn inner join matrequisitiondetails mrd on
mrn.intMatRequisitionNo = mrd.intMatRequisitionNo and mrn.intMRNYear = mrd.intYear
inner join department d on d.intDepID = mrn.strDepartmentCode
inner join mainstores ms on ms.strMainID = mrn.strMainStoresID
where mrd.intStyleId='$StyleID'  and mrd.strMatDetailID='$MatDetailID' and mrn.intStatus=10 ";
		$res_mrn = $db->RunQuery($sql_mrn);
		while($row_mrn = mysql_fetch_array($res_mrn))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="10%" class="normalfnt" height="20">MRN No :</td>
            <td width="12%" class="normalfnt"><?php echo $row_mrn["intMRNYear"].'/'.$row_mrn["intMatRequisitionNo"]; ?></td>
            <td width="11%" class="normalfnt">Request Date :</td>
            <td width="18%" class="normalfnt"><?php echo $row_mrn["mrnDate"]; ?></td>
            <td width="13%" class="normalfnt">Department (From) :</td>
            <td width="12%" class="normalfnt"><?php echo $row_mrn["strDepartment"]; ?></td>
            <td width="9%" class="normalfnt">Main Store (To) :</td>
            <td width="15%" class="normalfnt"><?php echo $row_mrn["mainstore"]; ?></td>
          </tr>
          <tr><td colspan="8"><table width="71%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="15%" height="20" class="normalfntMid">Color</th>
              <th width="10%" class="normalfntMid">Size</th>
              <th width="12%" class="normalfntMid">MRN Qty</th>
              <th width="10%" class="normalfntMid">Issue Qty</th>
              <th width="12%" class="normalfntMid">GRN Qty</th>
              <th width="14%" class="normalfntMid">GRN No</th>
              <th width="13%" class="normalfntMid">GRN Year</th>
              <th width="14%" class="normalfntMid">GRN Type</th>
            </tr>
             <?php 
		  $sql_mrd = "select mrd.strColor,mrd.strSize,mrd.dblQty as mrnQty, (mrd.dblQty - mrd.dblBalQty) as issueQty,mrd.intGrnNo,mrd.intGrnYear,mrd.strGRNType
from matrequisitiondetails mrd 
where mrd.intStyleId='$StyleID' and mrd.strMatDetailID='$MatDetailID' and mrd.intMatRequisitionNo='".$row_mrn["intMatRequisitionNo"]."' and mrd.intYear='".$row_mrn["intMRNYear"]."'";
		$res_mrd = $db->RunQuery($sql_mrd);
		while($row_mrd = mysql_fetch_array($res_mrd))
		{
			$grnType = $row_mrd["strGRNType"];
			switch($grnType)
			{
				case 'B':
				{
					$strType = 'Bulk';
					break;
				}
				case 'S':
				{
					$strType = 'Style';
					break;
				}
			}
		  ?>
            <tr bgcolor="#FFFFFF">
              <td height="20" class="normalfnt"><?php echo $row_mrd["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_mrd["strSize"]; ?></td>
              <td class="normalfntR"><?php echo $row_mrd["mrnQty"]; ?></td>
              <td class="normalfntR"><?php echo $row_mrd["issueQty"]; ?></td>
              <td class="normalfntR"><?php echo getGRNQty($StyleID,$MatDetailID,$row_mrd["strColor"],$row_mrd["strSize"],$row_mrd["intGrnNo"],$row_mrd["intGrnYear"],$grnType); ?></td>
              <td class="normalfntR"><?php echo $row_mrd["intGrnNo"]; ?></td>
              <td class="normalfntR"><?php echo $row_mrd["intGrnYear"]; ?></td>
              <td class="normalfnt"><?php echo $strType; ?></td>
            </tr>
            <?php 
			}
			?>
          </table></td></tr>
          <?php 
		 } 
		  ?>
          
         </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td class="normalfnBLD1" height="25">Issue Details</td>
      </tr>
       <tr>
        <td><table width="62%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_issue = "select distinct i.intIssueNo, i.intIssueYear,DATE_FORMAT(i.dtmIssuedDate, '%d-%M-%Y') as issueDate , d.strDepartment
from issues i inner join issuesdetails id on
i.intIssueNo = id.intIssueNo and i.intIssueYear = id.intIssueYear
inner join department d on d.intDepID = i.strProdLineNo
where id.intStyleId='$StyleID' and id.intMatDetailID='$MatDetailID' ";
	$res_issue = $db->RunQuery($sql_issue);
		while($row_issue = mysql_fetch_array($res_issue))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="9%" class="normalfnt" height="20">Issue No :</td>
            <td width="18%" class="normalfnt"><?php echo $row_issue["intIssueYear"].'/'.$row_issue["intIssueNo"]; ?></td>
            <td width="12%" class="normalfnt">Department :</td>
            <td width="27%" class="normalfnt"><?php echo $row_issue["strDepartment"] ?></td>
            <td width="12%" class="normalfnt">Issue Date :</td>
            <td width="22%" class="normalfnt"><?php echo $row_issue["issueDate"] ?></td>
          </tr>
          <tr>
            <td colspan="6"><table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
              <tr bgcolor="#CCCCCC">
                <th width="21%" height="20" class="normalfntMid">Color</th>
                <th width="16%" class="normalfntMid">Size</th>
                <th width="14%" class="normalfntMid">Issue Qty</th>
                <th width="17%" class="normalfntMid">Return Qty</th>
                <th width="17%" class="normalfntMid">MRN No</th>
                <th width="15%" class="normalfntMid">MRN Year</th>
              </tr>
              <?php 
			  $sql_issueD = "select id.strColor, id.strSize,id.dblQty as issueQty, (id.dblQty - id.dblBalanceQty) as returnQty,id.intMatRequisitionNo,id.intMatReqYear
from issuesdetails id
where id.intStyleId='$StyleID' and id.intMatDetailID='$MatDetailID' and id.intIssueNo ='".$row_issue["intIssueNo"]."' and id.intIssueYear ='".$row_issue["intIssueYear"]."' ";
		$res_issueD = $db->RunQuery($sql_issueD);
		while($row_issueD = mysql_fetch_array($res_issueD))
		{
			  ?>
              <tr bgcolor="#FFFFFF">
                <td class="normalfnt" height="20"><?php echo $row_issueD["strColor"] ?></td>
                <td class="normalfnt"><?php echo $row_issueD["strSize"] ?></td>
                <td class="normalfntR"><?php echo $row_issueD["issueQty"] ?></td>
                <td class="normalfntR"><?php echo $row_issueD["returnQty"] ?></td>
                <td class="normalfntR"><?php echo $row_issueD["intMatRequisitionNo"] ?></td>
                <td class="normalfntR"><?php echo $row_issueD["intMatReqYear"] ?></td>
              </tr>
              <?php 
		}
			  ?>
            </table></td>
            </tr>
          <?php 
		 }
		  ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td class="normalfnBLD1" height="25">GatePass Details</td>
      </tr>
       <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_gp = "select distinct gp.intGatePassNo,gp.intGPYear,gp.strAttention,gp.dtmDate,
(select  strName from mainstores MS where MS.strMainID=gp.strTo)AS destination
from gatepass gp inner join gatepassdetails gpd on
gp.intGatePassNo = gpd.intGatePassNo and gp.intGPYear = gpd.intGPYear
where gp.intStatus=1 and gpd.intStyleId='$StyleID' and intMatDetailId='$MatDetailID'";
		$res_gp = $db->RunQuery($sql_gp);
		while($row_gp = mysql_fetch_array($res_gp))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="9%" class="normalfnt" height="20">GatePass No : </td>
            <td width="11%" class="normalfnt"><?php echo $row_gp["intGPYear"].'/'.$row_gp["intGatePassNo"]; ?></td>
            <td width="8%" class="normalfnt">Destination : </td>
            <td width="14%" class="normalfnt"><?php echo $row_gp["destination"];  ?></td>
            <td width="7%" class="normalfnt">Dispatched : </td>
            <td width="12%" class="normalfnt"><?php 
			$sql_d = "select distinct ms.strName from stocktransactions st inner join mainstores ms on 
ms.strMainID = st.strMainStoresID where st.intDocumentNo='".$row_gp["intGatePassNo"]."' and st.intDocumentYear='".$row_gp["intGPYear"]."' and strType='SGatePass'";
	$res_d = $db->RunQuery($sql_d);
	$row_d = mysql_fetch_array($res_d);
	echo $row_d["strName"];
			?></td>
            <td width="8%" class="normalfnt">Attention By : </td>
            <td width="10%" class="normalfnt"><?php echo $row_gp["strAttention"];  ?></td>
            <td width="8%" class="normalfnt">Date &amp; Time : </td>
            <td width="13%" class="normalfnt"><?php echo $row_gp["dtmDate"];  ?></td>
          </tr>
          <tr>
            <td colspan="10"><table width="44%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
              <tr bgcolor="#CCCCCC">
                <th width="30%" class="normalfntMid" height="20">Color</th>
                <th width="22%" class="normalfntMid">Size</th>
                <th width="18%" class="normalfntMid">GP Qty</th>
                <th width="30%" class="normalfntMid">GP Trans Qty</th>
              </tr>
		<?php 
        	$sql_gpd = "select gpd.strColor,gpd.strSize,gpd.dblQty,(gpd.dblQty-gpd.dblBalQty) as GpTransQty
from gatepassdetails gpd 
where gpd.intGatePassNo='".$row_gp["intGatePassNo"]."' and gpd.intGPYear='".$row_gp["intGPYear"]."' and intMatDetailId='$MatDetailID' and gpd.intStyleId ='$StyleID'";
		$res_gpd = $db->RunQuery($sql_gpd);
		while($row_gpd = mysql_fetch_array($res_gpd))
		{
        ?>
              <tr bgcolor="#FFFFFF">
                <td class="normalfnt" height="20"><?php echo $row_gpd["strColor"]; ?></td>
                <td class="normalfnt"><?php echo $row_gpd["strSize"]; ?></td>
                <td class="normalfntR"><?php echo $row_gpd["dblQty"]; ?></td>
                <td class="normalfntR"><?php echo $row_gpd["GpTransQty"]; ?></td>
              </tr>
          <?php 
		  }
		  ?>    
            </table></td>
            </tr>
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td class="normalfnBLD1" height="25">GatePass TransferIn Details</td>
      </tr>
       <tr>
        <td><table width="91%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_gpdT = "select distinct gpt.intTransferInNo,gpt.intTINYear,gpt.intGatePassNo,gpt.intGPYear,c.strName as GPTransferCompany
from gategasstransferinheader gpt inner join gategasstransferindetails gptd on
gpt.intTransferInNo = gptd.intTransferInNo and gpt.intTINYear = gptd.intTINYear
inner join companies c on c.intCompanyID = gpt.intCompanyId
where gptd.intStyleId = '$StyleID' and gptd.intMatDetailId='$MatDetailID' ";
		$res_gpdT = $db->RunQuery($sql_gpdT);
		while($row_gpT = mysql_fetch_array($res_gpdT))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="13%" class="normalfnt" height="20">GP Transfer In No :</td>
            <td width="20%" class="normalfnt"><?php echo $row_gpT["intTINYear"].'/'.$row_gpT["intTransferInNo"]; ?></td>
            <td width="9%" class="normalfnt">GatePass No :</td>
            <td width="15%" class="normalfnt"><?php echo $row_gpT["intGPYear"].'/'.$row_gpT["intGatePassNo"]; ?></td>
            <td width="15%" class="normalfnt">GP Transfer In Company :</td>
            <td width="28%" class="normalfnt"><?php echo $row_gpT["GPTransferCompany"]; ?></td>
          </tr>
          <tr><td colspan="6"><table width="40%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="41%" class="normalfntMid" height="20">Color</th>
              <th width="32%" class="normalfntMid">Size</th>
              <th width="27%" class="normalfntMid">GP In Qty</th>
            </tr>
            <?php 
				$sql_gpTD = "select GpTd.strColor,GpTd.strSize,GpTd.dblQty from gategasstransferindetails GpTd where GpTd.intTransferInNo='".$row_gpT["intTransferInNo"]."' and GpTd.intTINYear='".$row_gpT["intTINYear"]."' and GpTd.intStyleId='$StyleID' and GpTd.intMatDetailId='$MatDetailID' ";
$res_gpTD = $db->RunQuery($sql_gpTD);
		while($row_gpTD = mysql_fetch_array($res_gpTD))
		{
			?>
            <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20"><?php echo $row_gpTD["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_gpTD["strSize"]; ?></td>
              <td class="normalfntR"><?php echo $row_gpTD["dblQty"]; ?></td>
            </tr>
            <?php 
			}
			?>
          </table></td></tr>
          <?php 
		}  
		  ?>
        </table></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td class="normalfnBLD1" height="25">Return To Stores Details</td>
      </tr>
      <tr>
        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
        <?php 
		$sql_rs = "select rsh.intReturnNo,rsh.intReturnYear,rsh.dtmRetDate,d.strDepartment 
from returntostoresheader rsh inner join returntostoresdetails rsd on
rsh.intReturnNo = rsd.intReturnNo and rsh.intReturnYear = rsd.intReturnYear
inner join department d on d.intDepID = rsh.strReturnedBy
where rsd.intStyleId='$StyleID'  and rsd.intMatdetailID='$MatDetailID' and rsh.intStatus=1 ";
	$res_rs = $db->RunQuery($sql_rs);
		while($row_rs = mysql_fetch_array($res_rs))
		{
		?>
          <tr bgcolor="#E4E4E4" >
            <td width="10%" class="normalfnt" height="20">Return No :</td>
            <td width="21%" class="normalfnt"><?php echo $row_rs["intReturnYear"].'/'.$row_rs["intReturnNo"]; ?></td>
            <td width="11%" class="normalfnt">Return By :</td>
            <td width="21%" class="normalfnt"><?php echo $row_rs["strDepartment"]; ?></td>
            <td width="11%" class="normalfnt">Return Date :</td>
            <td width="26%" class="normalfnt"><?php echo $row_rs["dtmRetDate"];  ?></td>
          </tr>
          <tr><td colspan="6"><table width="61%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="20%" height="20" class="normalfntMid">Issue No</th>
              <th width="26%" class="normalfntMid">Color</th>
              <th width="21%" class="normalfntMid">Size</th>
              <th width="17%" class="normalfntMid">Issue Qty</th>
              <th width="16%" class="normalfntMid">Return Qty</th>
            </tr>
           <?php 
		   $sql_rsd = "select id.dblQty as issueQty, rsd.strColor,rsd.strSize,rsd.intIssueNo, rsd.intIssueYear,rsd.dblReturnQty
from returntostoresdetails rsd inner join issuesdetails id on 
id.intIssueNo = rsd.intIssueNo and id.intIssueYear=rsd.intIssueYear
where rsd.intReturnNo='".$row_rs["intReturnNo"]."'  and rsd.intReturnYear='".$row_rs["intReturnYear"]."' and rsd.intStyleId='$StyleID' and rsd.intMatdetailID='$MatDetailID'";
$res_rsd = $db->RunQuery($sql_rsd);
		while($row_rsd = mysql_fetch_array($res_rsd))
		{
		   ?> 
            <tr bgcolor="#FFFFFF">
              <td  class="normalfnt" height="20"><?php echo $row_rsd["intIssueYear"].'/'.$row_rsd["intIssueNo"] ?></td>
              <td  class="normalfnt"><?php echo $row_rsd["strColor"] ?></td>
              <td  class="normalfnt"><?php echo $row_rsd["strSize"] ?></td>
              <td class="normalfntR"><?php echo $row_rsd["issueQty"] ?></td>
              <td class="normalfntR"><?php echo $row_rsd["dblReturnQty"] ?></td>
            </tr>
            <?php 
			}
			?>
          </table></td></tr>
          <?php 
		  }
		  ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnBLD1" height="25">Return To Supplier</td>
      </tr>
      <tr>
        <td><table width="90%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_rsup = "select distinct rsh.intReturnToSupNo,rsh.intReturnToSupYear,rsh.dtmRetDate,s.strTitle
from returntosupplierheader rsh inner join returntosupplierdetails rsd on 
rsh.intReturnToSupNo = rsd.intReturnToSupNo and rsd.intReturnToSupYear = rsh.intReturnToSupYear
inner join suppliers s on s.strSupplierID = rsh.intRetSupplierID
where rsh.intStatus=1 and rsd.intStyleId='$StyleID' and rsd.intMatdetailID ='$MatDetailID'";
	$res_rsup = $db->RunQuery($sql_rsup);
		while($row_rsup = mysql_fetch_array($res_rsup))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td height="20" class="normalfnt">Return No : </td>
            <td class="normalfnt"><?php echo $row_rsup["intReturnToSupYear"].'/'.$row_rsup["intReturnToSupNo"] ?></td>
            <td class="normalfnt">Return Date</td>
            <td class="normalfnt"><?php echo $row_rsup["dtmRetDate"]; ?></td>
            <td class="normalfnt">Supplier</td>
            <td class="normalfnt"><?php echo $row_rsup["strTitle"]; ?></td>
          </tr>
          <tr><td colspan="6"><table width="74%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="18%" height="20" class="normalfntMid">GRN No</th>
              <th width="26%" class="normalfntMid">Color</th>
              <th width="27%" class="normalfntMid">Size</th>
              <th width="14%" class="normalfntMid">GRN Qty</th>
              <th width="15%" class="normalfntMid">Return Qty</th>
            </tr>
            <?php 
			$sql_rsupD = "select rsd.intGrnNo,rsd.intGrnYear,rsd.strColor,rsd.strSize,gd.dblQty as GRNQty,rsd.dblQty
from returntosupplierdetails rsd inner join grndetails gd on
rsd.intGrnNo = gd.intGrnNo and rsd.intGrnYear = gd.intGRNYear and rsd.intStyleId= gd.intStyleId 
and rsd.intMatDetailID= gd.intMatDetailID and rsd.strColor = gd.strColor and rsd.strSize= gd.strSize
where rsd.intReturnToSupNo='".$row_rsup["intReturnToSupNo"]."' and rsd.intReturnToSupYear='".$row_rsup["intReturnToSupYear"]."' and rsd.intStyleId='$StyleID' and rsd.intMatdetailID='$MatDetailID'";

	$res_rsupD = $db->RunQuery($sql_rsupD);
		while($row_rsupD = mysql_fetch_array($res_rsupD))
		{
			?>
              <tr bgcolor="#FFFFFF">
              <td class="normalfnt" height="20"><?php echo $row_rsupD["intGrnYear"].'/'.$row_rsupD["intGrnNo"]; ?></td>
              <td class="normalfnt"><?php echo $row_rsupD["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_rsupD["strSize"]; ?></td>
              <td class="normalfntR"><?php echo $row_rsupD["GRNQty"]; ?></td>
              <td class="normalfntR"><?php echo $row_rsupD["dblQty"]; ?></td>
            </tr>
           <?php 
		   }
		   ?> 
          </table></td></tr>
         <?php 
		}
		 ?> 
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnBLD1" height="25">Inter job Tranfer In Details</td>
      </tr>
      <tr>
        <td><table width="67%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_it = "select distinct IT.intTransferId,IT.intTransferYear,
  (SELECT O.strOrderNo FROM orders O INNER JOIN itemtransfer IT ON IT.intStyleIdFrom = O.intStyleId AND IT.intStatus=3) AS FromOrderNo,
IT.dtmTransferDate AS TransferDate
from itemtransfer IT INNER JOIN itemtransferdetails ITD ON 
ITD.intTransferId = IT.intTransferId AND ITD.intTransferYear= IT.intTransferYear
WHERE IT.intStatus=3 AND IT.intStyleIdTo='$StyleID' AND ITD.intMatDetailId='$MatDetailID' ";
		$res_it = $db->RunQuery($sql_it);
		while($row_it = mysql_fetch_array($res_it))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="18%" height="20" class="normalfnt">Inter Job Trans In No :</td>
            <td width="15%" class="normalfnt"><?php echo $row_it["intTransferYear"].'/'.$row_it["intTransferId"]; ?></td>
            <td width="13%" class="normalfnt">From Order No :</td>
            <td width="18%" class="normalfnt"><?php echo $row_it["FromOrderNo"]; ?></td>
            <td width="13%" class="normalfnt">Created Date :</td>
            <td width="23%" class="normalfnt"><?php echo $row_it["TransferDate"]; ?></td>
          </tr>
          <tr><td colspan="6"><table width="79%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="20%" height="20" class="normalfntMid">Color</th>
              <th width="21%" class="normalfntMid">Size</th>
              <th width="15%" class="normalfntMid">Unit</th>
              <th width="14%" class="normalfntMid">Qty</th>
              <th width="17%" class="normalfntMid">Rate</th>
              <th width="13%" class="normalfntMid">Value</th>
            </tr>
           <?php 
		   $SQL_ITD = "select ITD.strColor,ITD.strSize,ITD.strUnit,ITD.dblUnitPrice,ITD.dblQty
FROM itemtransferdetails ITD INNER JOIN itemtransfer IT ON
IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear
WHERE IT.intStyleIdTo='$StyleID' AND ITD.intMatDetailId='$MatDetailID' AND ITD.intTransferId='".$row_it["intTransferId"]."' AND ITD.intTransferYear='".$row_it["intTransferYear"]."' ";
		$RES_ITD = $db->RunQuery($SQL_ITD);	
		while($row_itd = mysql_fetch_array($RES_ITD))
		{
			$value = $row_itd["dblUnitPrice"]*$row_itd["dblQty"];	
		   ?> 
            <tr bgcolor="#FFFFFF">
              <td height="20" class="normalfnt"><?php echo $row_itd["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_itd["strSize"]; ?></td>
              <td class="normalfnt"><?php echo $row_itd["strUnit"]; ?></td>
              <td class="normalfntR"><?php echo $row_itd["dblQty"]; ?></td>
              <td class="normalfntR"><?php echo $row_itd["dblUnitPrice"]; ?></td>
              <td class="normalfntR"><?php echo number_format($value,4); ?></td>
            </tr>
           <?php 
		 }  
		   ?> 
          </table></td></tr>
          <?php 
		 } 
		  ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td class="normalfnBLD1" height="25">Inter job Tranfer Out Details</td>
      </tr>
      <tr>
        <td><table width="67%" border="0" cellspacing="0" cellpadding="1">
        <?php 
		$sql_it = "select distinct IT.intTransferId,IT.intTransferYear,
  (SELECT O.strOrderNo FROM orders O INNER JOIN itemtransfer IT ON IT.intStyleIdTo = O.intStyleId AND IT.intStatus=3) AS FromOrderNo,
IT.dtmTransferDate AS TransferDate
from itemtransfer IT INNER JOIN itemtransferdetails ITD ON 
ITD.intTransferId = IT.intTransferId AND ITD.intTransferYear= IT.intTransferYear
WHERE IT.intStatus=3 AND IT.intStyleIdFrom='$StyleID' AND ITD.intMatDetailId='$MatDetailID' ";
		$res_it = $db->RunQuery($sql_it);
		while($row_it = mysql_fetch_array($res_it))
		{
		?>
          <tr bgcolor="#E4E4E4">
            <td width="18%" height="20" class="normalfnt">Inter Job Trans In No :</td>
            <td width="15%" class="normalfnt"><?php echo $row_it["intTransferYear"].'/'.$row_it["intTransferId"]; ?></td>
            <td width="15%" class="normalfnt">From Order No :</td>
            <td width="15%" class="normalfnt"><?php echo $row_it["FromOrderNo"]; ?></td>
            <td width="13%" class="normalfnt">Created Date :</td>
            <td width="24%" class="normalfnt"><?php echo $row_it["TransferDate"]; ?></td>
          </tr>
          <tr><td colspan="6"><table width="79%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC">
              <th width="20%" height="20" class="normalfntMid">Color</th>
              <th width="21%" class="normalfntMid">Size</th>
              <th width="15%" class="normalfntMid">Unit</th>
              <th width="14%" class="normalfntMid">Qty</th>
              <th width="17%" class="normalfntMid">Rate</th>
              <th width="13%" class="normalfntMid">Value</th>
            </tr>
           <?php 
		   $SQL_ITD = "select ITD.strColor,ITD.strSize,ITD.strUnit,ITD.dblUnitPrice,ITD.dblQty
FROM itemtransferdetails ITD INNER JOIN itemtransfer IT ON
IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear
WHERE IT.intStyleIdFrom='$StyleID' AND ITD.intMatDetailId='$MatDetailID' AND ITD.intTransferId='".$row_it["intTransferId"]."' AND ITD.intTransferYear='".$row_it["intTransferYear"]."' ";
		$RES_ITD = $db->RunQuery($SQL_ITD);	
		while($row_itd = mysql_fetch_array($RES_ITD))
		{
			$value = $row_itd["dblUnitPrice"]*$row_itd["dblQty"];	
		   ?> 
            <tr bgcolor="#FFFFFF">
              <td height="20" class="normalfnt"><?php echo $row_itd["strColor"]; ?></td>
              <td class="normalfnt"><?php echo $row_itd["strSize"]; ?></td>
              <td class="normalfnt"><?php echo $row_itd["strUnit"]; ?></td>
              <td class="normalfntR"><?php echo $row_itd["dblQty"]; ?></td>
              <td class="normalfntR"><?php echo $row_itd["dblUnitPrice"]; ?></td>
              <td class="normalfntR"><?php echo number_format($value,4); ?></td>
            </tr>
           <?php 
		 }  
		   ?> 
          </table></td></tr>
          <?php 
		 } 
		  ?>
        </table></td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td class="normalfnBLD1" height="25">&nbsp;</td>
      </tr>
       <tr><td>&nbsp;</td></tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php 
function getItemName($itemID)
{
	global $db;
	$SQL = " select strItemDescription from matitemlist where intItemSerial='$itemID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strItemDescription"];
}

function getGRNQty($styleId,$matdetailId,$color,$size,$grnNo,$grnYear,$grnType)
{
	global $db;
	$sql = "select sum(dblQty) as grnQty from stocktransactions where intStyleId='$styleId' and intMatDetailId='$matdetailId' and strColor='$color' and strSize='$size' and intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType='$grnType' 
	and strType in('GRN','STNT')";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["grnQty"];
}

function getMainStore($mainStoreId)
{
	global $db;
	$sql = "select strName from mainstores where strMainID='$mainStoreId' ";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strName"];
}
function getGRNMainStore($grnYear,$grnNo)
{
	global $db;
	$sql = "select distinct strMainStoresID,ms.strName from stocktransactions st inner join mainstores ms on 
st.strMainStoresID = ms.strMainID where intGrnNo='$grnNo' and intGrnYear='$grnYear' and strType='GRN'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strName"];
}
?>
