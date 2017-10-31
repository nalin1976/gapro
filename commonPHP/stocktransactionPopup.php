<?php 
	include "../Connector.php";
	$companyId  =$_SESSION["FactoryID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100%" class="mainHeading">Stock transaction</td>
    <td class="mainHeading"><div align="right"><img src="/gapro/images/cross.png" onClick="closePopupBox(20);"></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><div style="overflow: scroll; height: 302px; width: 602px;" id="divcons">
		<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
          <tr class="mainHeading4">
            <td width="48%" height="22">Type</td>
            <td width="10%" >Date</td>
            <td nowrap="nowrap">Document No</td>
            <td nowrap="nowrap">Document Year</td>
            <td width="12%">Qty</td>
          </tr>
<?php 
$type 		= $_GET["type"];
$styleID 	= $_GET["styleID"];
$buyerPO 	= $_GET["buyerPO"];
$store 		= $_GET["store"];
$matID 		= $_GET["matID"];
$color 		= $_GET["color"];
$size 		= $_GET["size"];
$grnNo 		= $_GET["grnNo"];
$grnYear 	= $_GET["grnYear"];
$grnType 	= $_GET["grnType"]; // S = style  , B = Bulk this is a grn types
	
	if($type == "MRN")
	{
		$sql = " SELECT strTypeName as strType,dtmDate,dblQty,intDocumentNo,intDocumentYear
		 FROM stocktransactions s inner join stocktype ST ON s.strType = ST.strType 
		  WHERE intStyleId='$styleID' AND strBuyerPoNo='$buyerPO' AND intMatDetailId='$matID' AND strColor='$color' AND strSize='$size' and strMainStoresID = '$store' and intGrnNo = '$grnNo' and  intGrnYear = '$grnYear' and strGRNType='$grnType' ;";
	}
	else if($type == "ISSUE")
	{
		$sql = "SELECT strTypeName as strType,dtmDate,dblQty,intDocumentNo,intDocumentYear FROM stocktransactions S 
			Inner Join stocktype ST ON S.strType = ST.strType 
			Inner Join mainstores MS ON MS.strMainID=S.strMainStoresID  
			WHERE intStyleId='$styleID' 
			and strBuyerPoNo='$buyerPO'
			and intMatDetailId='$matID'
			and strColor='$color'
			and strSize='$size'
			and intCompanyId='$companyId' 
			and intStatus=1 
			and MS.strMainID=$store 
			and S.intGrnNo = '$grnNo' 
			and S.intGrnYear = '$grnYear'
			and S.strGRNType='$grnType' ";
	}	
	else if($type == "GatePass")
	{
		$sql=" SELECT strTypeName as strType,dtmDate,dblQty,intDocumentNo,intDocumentYear FROM stocktransactions S  
			Inner Join stocktype ST ON S.strType = ST.strType 
			Inner Join mainstores AS MS ON MS.strMainID = S.strMainStoresID 
			WHERE intStyleId='$styleID'
			and strBuyerPoNo='$buyerPO'
			and intMatDetailId='$matID'
			and strColor='$color'
			and strSize='$size'
			and MS.intCompanyId='$companyId'
			and intStatus=1
			and MS.strMainID=$store
			and S.intGrnNo = '$grnNo'
			and S.intGrnYear = '$grnYear'
			and S.strGRNType='$grnType' ";
	}	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	$qty= $row["dblQty"];
$total+=$qty;
	
?>
		<tr bgcolor="#FFFFFF">
			<td class="normalfnt"><?php  echo $row["strType"]; ?></td>
			<td class="normalfntMid" nowrap="nowrap">&nbsp;<?php echo $row["dtmDate"]; ?>&nbsp;</td>
			<td class="normalfntMid"><?php echo $row["intDocumentNo"]; ?></td>
			<td class="normalfntMid"><?php echo $row["intDocumentYear"]; ?></td>
			<td class="normalfntRite"><?php echo $row["dblQty"]; ?></td>
		</tr>
<?php 
	}
?>
          
<?php 
		if($type == "GatePass")
		{
			$sqlmrn="SELECT
			MRD.dblBalQty, 
			MR.dtmDate,
			MR.intMatRequisitionNo,
			MR.intMRNYear
			FROM 
			matrequisitiondetails AS MRD 
			Inner Join matrequisition AS MR ON MR.intMatRequisitionNo = MRD.intMatRequisitionNo AND MRD.intYear = MR.intMRNYear 
			Inner Join mainstores MS ON MS.strMainID=MR.strMainStoresID 
			WHERE 
			MRD.intStyleId ='$styleID' and 
			MRD.strBuyerPONO ='$buyerPO' and 
			MRD.strMatDetailID ='$matID' and 
			MRD.strColor ='$color' and 
			MRD.strSize ='$size' and 
			MS.intCompanyId ='$companyId' and
			MR.strMainStoresID = $store and
			MRD.intGrnNo='$grnNo' and  MRD.intGrnYear = '$grnYear' and dblBalQty>0 and strGRNType='$grnType' ";

			$resultMRN = $db->RunQuery($sqlmrn);
			while($rowmrn = mysql_fetch_array($resultMRN))
			{						
				$mrnQty = $rowmrn["dblBalQty"] * -1;
				$total+=$mrnQty;
						
?>
				<tr bgcolor="#FFFFFF">
					<td class="normalfnt"><?php  echo 'MRN'; ?></td>
					<td class="normalfntMid" nowrap="nowrap"><?php echo $rowmrn["dtmDate"]; ?></td>
					<td class="normalfntMid"><?php echo $rowmrn["intMatRequisitionNo"]; ?></td>
					<td class="normalfntMid"><?php echo $rowmrn["intMRNYear"]; ?></td>
					<td class="normalfntRite"><?php echo $mrnQty ?></td>
				</tr>
<?php 					
			}
			
				/*Start - 11-12-2010 - Rejected qty not added to stock tablec therefor no need to reduce from grn table
				$sql_reject="SELECT dtmRecievedDate,SUM(intRejectQty) AS rejectQty 
				 FROM grndetails AS GD 
				 Inner Join grnheader AS GH ON GH.intGrnNo = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear 
				 WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND intMatDetailID=$matID 
				 AND strColor='$color' AND strSize='$size' AND GH.intCompanyID = '$companyId' and GH.intGrnNo='$grnNo'
				 and intReject>0
				 GROUP BY dtmRecievedDate ";			 
				 $resultRJ = $db->RunQuery($sql_reject);
					while($rowGRN = mysql_fetch_array($resultRJ))
					{
						$rejectQty = $rowGRN["rejectQty"] * -1;	
						$total+=$rejectQty;	
				End - 11-12-2010 - Rejected qty not added to stock tablec therefor no need to reduce from grn table
				*/
?>
						<!--
						Start - 11-12-2010 - Rejected qty not added to stock tablec therefor no need to reduce from grn table
							<tr bgcolor="#FFFFFF">
							<td class="normalfnt"><?php  echo 'GRN-Rejected'; ?></td>
							<td class="normalfntMid" nowrap="nowrap"><?php echo $rowGRN["dtmRecievedDate"]; ?></td>
							<td class="normalfntMid"><?php echo $grnNo; ?></td>
							<td class="normalfntMid"><?php echo $grnYear; ?></td>
							<td class="normalfntRite"><?php echo $rejectQty ?></td>
						</tr>
						End - 11-12-2010 - Rejected qty not added to stock tablec therefor no need to reduce from grn table
						-->
					
<?php			  
			 		//}
		}
 ?>
        </table></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="133" height="20" ></td>
        <td width="273" ></td>
        <td width="110" class="normalfnBLD1">Total Stock</td>
        <td width="114" class="normalfntRiteTABb-ANS"><?php echo $total; ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
