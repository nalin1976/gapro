<?php 
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
$styleId = $_GET["styleId"];
$type = $_GET["type"];
$orderNo = $_GET["orderNo"];
//include '../../eshipLoginDB.php';
if($type=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="LeftoverDetails.xls"');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Leftover Details Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="950" border="0" cellspacing="0" cellpadding="2" align="center">
      <tr>
        <td><table width="950" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="head2BLCK">Item Detail Report - <?php echo $orderNo; ?></td>
          </tr>
          <tr>
            <td class="normalfnBLD1" height="25">Leftover &amp; Interjob Details</td>
          </tr>
          <tr>
            <td><table width="1041" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
              <tr bgcolor="#CCCCCC" class="normalfntMid">
                <th width="214" height="24">Item Name</th>
                <th width="99">Color</th>
                <th width="83">Size</th>
                <th width="90">Unit</th>
                <th width="87">Qty</th>
                <th width="103">Allocation No</th>
                <th width="86">Allocation Type</th>
                <th width="86">GRN No</th>
                <th width="74">GRN Year</th>
                <th width="68">GRN Type</th>
                </tr>
              <?php 
			  $sql = "select CBH.intToStyleId,CBH.strToBuyerPoNo,
MIL.strItemDescription,CBD.strColor,CBD.strSize,CBD.strUnit,CBD.dblQty,
CBD.intMatDetailId,concat(CBD.intTransferYear,'/',CBD.intTransferNo) as allocationNo,
date(CBH.dtmDate) as allocationDate,intGrnYear,intGrnNo,CBD.strGRNType,'Leftover' as Allotype
FROM commonstock_leftoverdetails CBD 
INNER JOIN commonstock_leftoverheader CBH ON (CBD.intTransferNo=CBH.intTransferNo) AND (CBH.intTransferYear=CBD.intTransferYear) 
INNER JOIN matitemlist MIL ON (CBD.intMatDetailId=MIL.intItemSerial) 
INNER JOIN orders O ON CBH.intToStyleId=O.intStyleId 
WHERE CBH.intCompanyId <>'0' and CBH.intToStyleId='$styleId' AND CBH.intStatus=1
union 
select IH.intStyleIdTo as intToStyleId,IH.strToBuyerPoNo,MIL.strItemDescription,ID.strColor,
ID.strSize,ID.strUnit,ID.dblQty,ID.intMatDetailId as intMatDetailId,
concat(ID.intTransferYear,'/',ID.intTransferId) as allocationNo,date(IH.dtmTransferDate) as allocationDate,
ID.intGrnYear,ID.intGrnNo, ID.strGRNType,'Interjob' as Allotype
from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
inner join matitemlist MIL on MIL.intItemSerial = ID.intMatDetailId
where IH.intStyleIdTo='$styleId' and IH.intStatus=3 ";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
			  ?>
              <tr bgcolor="#FFFFFF" class="normalfnt">
                <td height="20"><?php echo $row["strItemDescription"] ?></td>
                <td><?php echo $row["strColor"] ?></td>
                <td><?php echo $row["strSize"] ?></td>
                <td><?php echo $row["strUnit"] ?></td>
                <td class="normalfntRite"><?php echo $row["dblQty"] ?></td>
                <td><?php echo $row["allocationNo"] ?></td>
                <td><?php echo $row["Allotype"] ?></td>
                <td><?php echo $row["intGrnNo"] ?></td>
                <td><?php echo $row["intGrnYear"] ?></td>
                <td><?php echo $row["strGRNType"] ?></td>
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
            <td class="normalfnBLD1" height="25">Issue Details</td>
          </tr>
          <?php 
		  $SQL_C = " select distinct MIL.intSubCatID,MS.StrCatName from commonstock_leftoverheader CBH 
INNER JOIN commonstock_leftoverdetails CBD ON CBH.intTransferNo = CBD.intTransferNo AND CBH.intTransferYear = CBD.intTransferYear
INNER JOIN matitemlist MIL ON MIL.intItemSerial = CBD.intMatDetailId
INNER JOIN matsubcategory MS ON MS.intSubCatNo=MIL.intSubCatID
WHERE  CBH.intStatus=1 and CBH.intToStyleId='$styleId'
union 
select distinct MIL.intSubCatID,MS.StrCatName from itemtransfer IH 
INNER JOIN itemtransferdetails ID ON IH.intTransferId = ID.intTransferId AND IH.intTransferYear= ID.intTransferYear
INNER JOIN matitemlist MIL ON MIL.intItemSerial = ID.intMatDetailId
INNER JOIN matsubcategory MS ON MS.intSubCatNo=MIL.intSubCatID
WHERE  IH.intStatus=3 and IH.intStyleIdTo='$styleId'";
		$result_c = $db->RunQuery($SQL_C);	
	while($rowC=mysql_fetch_array($result_c))
	{
		$subCategoryId = $rowC["intSubCatID"];
		  ?>
           <tr>
            <td class="normalfnBLD1" height="25"><?php echo $rowC["StrCatName"]; ?></td>
          </tr>
          <tr>
          	<td><table width="950" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
              <tr bgcolor="#CCCCCC" class="normalfntMid">
                <th width="264" height="20">Item Name</th>
                <th width="107">Color</th>
                <th width="94">Size</th>
                <th width="82">Unit</th>
                <th width="70">Used Qty</th>
                <th width="75">Unitprice</th>
                <th width="81">GRN No</th>
                <th width="63">GRN Year</th>
                <th width="68">GRN Type</th>
                </tr>
               <?php
			  $type = 'GRN';
			  if($subCategoryId ==29) 
			  	$type='ISSUE';
				 
			  $result = getIssueItemDetails($styleId,$subCategoryId,$type);
			  while($row = mysql_fetch_array($result))
			  {
			  		$issueQty = abs($row["issueQty"]);
					$returnQty = getThreadReturnQty($styleId,$row["intMatDetailId"],$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"],$subCategoryId,$row["strColor"],$row["strSize"]);
					if($type == 'GRN')
						$returnQty=0;
					$usedQty = $issueQty-$returnQty;
					$grnType = $row["strGRNType"];
					
					switch($grnType)
					{
						case 'S':
						{
							$grnprice = getGRNprice($row["intGrnNo"],$row["intGrnYear"],$row["strColor"],$row["strSize"],$styleId,$row["intMatDetailId"]);
							break;
						}
						case 'B':
						{
							$grnprice = getBulkGRNprice($row["intGrnNo"],$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["intMatDetailId"]);
							
						}
					}
					
					$bgcolor =($grnprice==''?'#A8F1FF':'#FFFFFF');
			   ?> 
              <tr bgcolor="<?php echo $bgcolor; ?>" class="normalfnt">
                <td><?php echo $row["strItemDescription"]; ?></td>
                <td><?php echo $row["strColor"]; ?></td>
                <td><?php echo $row["strSize"]; ?></td>
                <td><?php echo $row["strUnit"]; ?></td>
                <td class="normalfntRite"><?php echo $usedQty; ?></td>
                <td class="normalfntRite"><?php echo $grnprice; ?></td>
                <td><?php echo $row["intGrnNo"]; ?></td>
                <td><?php echo $row["intGrnYear"]; ?></td>
                <td><?php echo $row["strGRNType"]; ?></td>
                </tr>
                <?php 
				}	
				?>
            </table></td>
          </tr>
  <?php }?> 
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getIssueItemDetails($styleId,$subCategoryId,$type)
{
	global $db;
	$sql = "select sum(st.dblQty) as issueQty,st.intGrnNo,st.intGrnYear,st.strGRNType,st.intMatDetailId, st.strColor,st.strSize , mil.strItemDescription,st.strUnit
 from stocktransactions st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
where  st.intStyleId='$styleId' and mil.intSubCatID=$subCategoryId ";

	if($type == 'GRN')
		$sql .= " and st.strType in ('GRN','LAlloIn','IJTIN') ";
	else
		$sql .= " and st.strType ='$type' ";
			
	$sql .= " group by st.intGrnNo,st.intGrnYear,st.strGRNType,st.intMatDetailId, st.strColor,st.strSize";
//echo $sql;
	return $db->RunQuery($sql);
}

function getThreadReturnQty($styleId,$matDetailId,$grnNo,$grnYear,$grnType,$threadSubcatID,$color,$size)
{
	global $db;
	
	$sql = "select sum(st.dblQty) as Qty  
 from stocktransactions st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
where  st.intStyleId='$styleId' and mil.intSubCatID=$threadSubcatID and st.strType in ('SRTS','CSRTS')  and st.intGrnNo='$grnNo' and 
 st.intGrnYear='$grnYear' and st.strGRNType='$grnType'  and st.intMatDetailId='$matDetailId' and st.strColor='$color' and st.strSize = '$size' 
 group by st.intGrnNo,st.intGrnYear,st.strGRNType,st.intMatDetailId, st.strColor,st.strSize";
	 $result = $db->RunQuery($sql);
	 $row = mysql_fetch_array($result);
	 
	 return $row["Qty"];
}
function getGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$styleId,$matDetailId)
{
	global $db;
	
	$sql = "select gd.dblInvoicePrice/gh.dblExRate as unitPrice
from grndetails gd inner join grnheader gh on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intStatus =1 and gd.intStyleId='$styleId' and gd.intMatDetailID='$matDetailId' and gd.strColor='$strColor' and gd.strSize = '$strSize' and  gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$grnYear'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["unitPrice"];
}
function getBulkGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$matDetailId)
{
	global $db;
	
	$sql = "select bpo.dblInvoicePrice/bgh.dblRate as uintprice
from  bulkgrnheader bgh inner join bulkgrndetails bgd on
bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear = bgd.intYear		
inner join bulkpurchaseorderdetails bpo on
bpo.intBulkPoNo = bgh.intBulkPoNo and 
bpo.intYear = bgh.intBulkPoYear and 
bpo.intMatDetailId = bgd.intMatDetailID
where bgh.intStatus=1 and  bgd.intMatDetailID='$matDetailId' and bgh.intBulkGrnNo='$intGrnNo' and bgh.intYear='$grnYear' and bgd.strColor='$strColor' and  bgd.strSize='$strSize'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["uintprice"];
}
?>
</body>
</html>
