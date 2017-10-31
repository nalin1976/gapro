<?php 
session_start();
include "../../Connector.php";
$backwardseperator = "../../";
include "{$backwardseperator}authentication.inc";
$companyId=$_SESSION["FactoryID"];
$MatDetailID = $_GET["matID"];
$ItemName = $_GET["ItemName"];
$Dfrom  = $_GET["Dfrom"];
$Dto = $_GET["Dto"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bulk Purchase Utilization Report</title>
<link href="../../css/erpstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">Bulk Purchase Utilization Report</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="101" class="normalfnt2bldBLACK">Item Name :</td>
        <td width="419" class="normalfnt2bldBLACK"><?php echo $ItemName; ?></td>
        <td width="96" class="normalfnt2bldBLACK">Date From :</td>
        <td width="136" class="normalfnt"><?php echo $Dfrom ?></td>
        <td width="74" class="normalfnt2bldBLACK">Date To:</td>
        <td width="174" class="normalfnt"><?php echo $Dto ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="1000" border="0" cellspacing="0" cellpadding="2" class="tablez">
      <tr>
        <td width="74" class="normalfntBtab">PO No</td>
        <td width="261" class="normalfntBtab">Item Description</td>
        <td width="67" class="normalfntBtab">Color</td>
        <td width="75" class="normalfntBtab">Size</td>
        <td width="73" class="normalfntBtab">Unit</td>
        <td width="65" class="normalfntBtab">Price</td>
        <td width="58" class="normalfntBtab">Rec.Qty</td>
        <td width="63" class="normalfntBtab">Style ID</td>
        <td width="66" class="normalfntBtab">Alloc.No</td>
        <td width="37" class="normalfntBtab">Qty</td>
        <td width="56" class="normalfntBtab">Entered By </td>
        <td width="42" class="normalfntBtab">Date</td>
        <td width="63" class="normalfntBtab">Value</td>
      </tr>
      <?php
	  
	  $arrDfrom = explode('/',$Dfrom);
	  $arrDto   = explode('/',$Dto);
	  
	  $DateFrom = $arrDfrom[2].'-'.$arrDfrom[1].'-'.$arrDfrom[0];
	  $DateTo   = $arrDto[2].'-'.$arrDto[1].'-'.$arrDto[0];
	   
	   //start 2010-09-17 bulkItem data report from 1 query
		/*$SQL = " SELECT CSBD.intMatDetailId,CSBD.strColor,CSBD.strSize,CSBD.strUnit,CSBD.dblQty as AlloQty,CSBD.intBulkPoNo,
				CSBD.intBulkPOYear,CSBD.intTransferNo,CSBD.intTransferYear,BPOD.dblUnitPrice,
				M.strItemDescription,O.strStyle,(BPOD.dblQty - BPOD.dblPending) as grnQty
				from commonstock_bulkdetails CSBD 
				inner join bulkpurchaseorderheader BPOH on CSBD.intBulkPoNo = BPOH.intBulkPoNo and 
				CSBD.intBulkPOYear = BPOH.intYear 
				inner join  bulkpurchaseorderdetails BPOD on BPOD.intBulkPoNo = BPOH.intBulkPoNo and 
				BPOD.intYear = BPOH.intYear and BPOD.intMatDetailId= CSBD.intMatDetailId
				inner join matitemlist M on M.intItemSerial = CSBD.intMatDetailId and 
				M.intItemSerial = BPOD.intMatDetailId 
				inner join commonstock_bulkheader CSBH on CSBH.intTransferNo = CSBD.intTransferNo and
				CSBH.intTransferYear = CSBD.intTransferYear
				inner join orders O on O.intStyleId = CSBH.intToStyleId
				where BPOH.intStatus=1 and BPOH.dtDate between '$DateFrom' and '$DateTo' 
				and CSBD.intMatDetailId='$MatDetailID' and CSBH.intStatus=1
				order by CSBD.intBulkPOYear,CSBD.intBulkPoNo,CSBD.intTransferYear,CSBD.intTransferNo ";
				
				$result = $db->RunQuery($SQL);
			$checkponoAndYear = '';
			while($row =  mysql_fetch_array($result))
			{
			
			$bulkPONo = $row["intBulkPOYear"].'/'.$row["intBulkPoNo"];
			
			if($bulkPONo != $checkponoAndYear){
			$checkponoAndYear = $bulkPONo;
			$noLoop =0;	*/
			
			$SQLPOdata = "SELECT DISTINCT CBD.intBulkPoNo,CBD.intBulkPOYear,BPOD.strColor,
						BPOD.strSize,BPOD.strUnit,BPOD.dblUnitPrice,(BPOD.dblQty-BPOD.dblPending) AS GRNQty,
						M.strItemDescription
						FROM bulkpurchaseorderheader BPOH INNER JOIN bulkpurchaseorderdetails BPOD ON BPOH.intBulkPoNo = BPOD.intBulkPoNo
						AND BPOH.intYear = BPOD.intYear
						INNER JOIN matitemlist M ON M.intItemSerial = BPOD.intMatDetailId
						INNER JOIN commonstock_bulkdetails CBD ON BPOH.intBulkPoNo = CBD.intBulkPoNo
						AND BPOH.intYear = CBD.intBulkPOYear
						INNER JOIN commonstock_bulkheader CBH ON CBH.intTransferNo = CBD.intTransferNo
						AND CBH.intTransferYear = CBD.intTransferYear
						WHERE BPOH.dtDate BETWEEN '$DateFrom' AND '$DateTo' AND 
						BPOH.intDeliverTo='$companyId' AND BPOH.intStatus=1 AND BPOD.intMatDetailId='$MatDetailID' AND CBH.intStatus=1 
						AND CBH.intStatus='$companyId'";
						
						$resultD = $db->RunQuery($SQLPOdata);
						while($row =  mysql_fetch_array($resultD))
							{
							$PONo = $row["intBulkPoNo"];
							$POyear = $row["intBulkPOYear"];
							$bulkPONo = $POyear.'/'.$PONo;
							$color = $row["strColor"];
							$size  = $row["strSize"];
							$price = $row["dblUnitPrice"];
							$totAllQty = 0;
							$GRNQty = $row["GRNQty"];
			
	  ?>
      <tr >
        <td class="normalfnt" height="22" style="border-bottom-style:dotted"><?php echo $bulkPONo; ?></td>
        <td class="normalfnt" style="border-bottom-style:dotted"><?php echo $ItemName; ?></td>
        <td class="normalfnt" style="border-bottom-style:dotted"><?php echo $color; ?></td>
        <td class="normalfnt" style="border-bottom-style:dotted"><?php echo $size; ?></td>
        <td class="normalfnt" style="border-bottom-style:dotted"><?php echo $row["strUnit"] ?></td>
        <td class="normalfntRite" style="border-bottom-style:dotted"><?php echo $row["dblUnitPrice"] ?></td>
        <td class="normalfntRite" style="border-bottom-style:dotted"><?php echo $GRNQty; ?></td>
        <td class="normalfnt" style="border-bottom-style:dotted">&nbsp;</td>
        <td class="normalfnt" style="border-bottom-style:dotted">&nbsp;</td>
        <td class="normalfnt" style="border-bottom-style:dotted">&nbsp;</td>
        <td class="normalfnt" style="border-bottom-style:dotted">&nbsp;</td>
        <td class="normalfnt" style="border-bottom-style:dotted">&nbsp;</td>
        <td class="normalfnt" style="border-bottom-style:dotted">&nbsp;</td>
		</tr>
		<?php 
			//get allocation details
			
				$sqlAllo = " SELECT CBD.intTransferNo,CBD.intTransferYear,O.strStyle,U.Name,
							DATE_FORMAT(CBH.dtmDate, '%d/%m/%Y')  AS dtmDate,CBD.dblQty as alloQty
							FROM commonstock_bulkdetails CBD INNER JOIN commonstock_bulkheader CBH ON
							CBH.intTransferNo = CBD.intTransferNo AND 
							CBD.intTransferYear = CBH.intTransferYear 
							INNER JOIN orders O ON O.intStyleId = CBH.intToStyleId 
							INNER JOIN useraccounts U ON U.intUserID = CBH.intUserId
							WHERE CBD.intBulkPoNo='$PONo' AND CBD.intBulkPOYear='$POyear' AND
							CBD.intMatDetailId=327 AND CBD.strColor='N/A' AND CBD.strSize='N/A'
							AND CBH.intStatus=1";
							
							$resAllo = $db->RunQuery($sqlAllo);
						while($rowA =  mysql_fetch_array($resAllo))
							{
							$AllQty = $rowA["alloQty"];
							$totAllQty += $AllQty;
		?>
		 <tr>
        <td class="normalfnt" height="21"><?php //echo $bulkPONo; ?></td>
        <td class="normalfnt"><?php //echo $ItemName; ?></td>
        <td class="normalfnt"><?php //echo $color; ?></td>
        <td class="normalfnt"><?php //echo $size; ?></td>
        <td class="normalfnt"><?php //echo $row["strUnit"] ?></td>
        <td class="normalfnt"><?php //echo $row["dblUnitPrice"] ?></td>
        <td class="normalfnt"><?php //echo $row["GRNQty"]; ?></td>
        <td class="normalfnt"><?php echo $rowA["strStyle"]; ?></td>
        <td class="normalfnt"><?php echo $rowA["intTransferYear"].'/'.$rowA["intTransferNo"]; ?></td>
        <td class="normalfntRite"><?php echo $AllQty; ?></td>
        <td class="normalfnt"><?php echo $rowA["Name"]; ?></td>
        <td class="normalfnt"><?php echo $rowA["dtmDate"]; ?></td>
        <td class="normalfntRite"><?php $value = (float)$AllQty*(float)$price;
		echo $value;
		//$totVal += $value;
		?></td>
		</tr>
		<?php }?>
       <tr bgcolor="#BED6E9">
        <td class="normalfnt" height="25"><?php //echo $bulkPONo; ?></td>
        <td class="normalfntRite" style="font-weight:bold">Total Allocated :</td>
        <td class="normalfntRite" style="font-weight:bold"><?php echo $totAllQty; ?></td>
        <td class="normalfntRite" style="font-weight:bold" colspan="3">Balance in this PO</td>
        
        <td class="normalfntRite" style="font-weight:bold" colspan="2"><?php echo $GRNQty - $totAllQty; ?></td>
       
        <td class="normalfnt"></td>
        <td class="normalfnt"></td>
        <td class="normalfnt"></td>
        <td class="normalfnt"></td>
        <td class="normalfnt"></td>
		</tr>
			  <?php 
              }
              ?>
     
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
