<?php 
 session_start();
include "../Connector.php";

$Category = $_GET["mainCategory"];
//$itemName = $_GET["itemName"];
$dfrom = $_GET["Dfrom"];
$dto   = $_GET["Dto"];

$mainCatID = $_GET["mainCatID"];
$mainStore = $_GET["mainStore"];
$matItem  = $_GET["matItem"];

$arrDfrom = explode('-',$dfrom);
$dateFrom = $arrDfrom[2].'/'.$arrDfrom[1].'/'.$arrDfrom[0];

$arrDto = explode('-',$dto);
$dateTo = $arrDto[2].'/'.$arrDto[1].'/'.$arrDto[0];

$orderNo = $_GET["orderNo"];
$orderName = $_GET["orderName"];
$color = $_GET["color"];
$size = $_GET["size"];
$scNo = $_GET["scNo"];
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Style :: Stock Movement</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2">Item Movement Details</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnth2B">
           <tr>
            <td width="206">Order No</td>
            <td width="594"><?php echo $orderName; ?></td>
          </tr>
           <tr>
            <td width="206">SC No</td>
            <td width="594"><?php echo $scNo; ?></td>
          </tr>
           <tr>
            <td width="206">Category</td>
            <td width="594"><?php echo $Category; ?></td>
          </tr>
          <tr>
            <td width="206">Size</td>
            <td width="594"><?php echo $size; ?></td>
          </tr>
          <tr>
            <td width="206">Color</td>
            <td width="594"><?php echo $color; ?></td>
          </tr>
          <tr>
            <td>Item Description</td>
            <td><?php echo getItemName($matItem);?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="400" border="0" cellspacing="0" cellpadding="0" align="center" class="normalfnth2B">
          <tr>
            <td width="75">From :</td>
            <td width="120"><?php echo $dateFrom; ?></td>
            <td width="50">To :</td>
            <td width="155"><?php echo $dateTo; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
         <td><table width="369" border="0" cellspacing="0" cellpadding="0" class="normalfnth2B">
          <tr>
            <td width="192">Opening Balance as at :</td>
            <td width="114"><?php echo $dateFrom; ?> :</td>
            <td width="101" class="normalfnBLD1" align="right">
            <?php 
				$sqlOB = "select sum(dblQty) as openBal
				from stocktransactions
				where intMatDetailId='$matItem' and date(dtmDate)<'$dfrom'  and strMainStoresID=$mainStore
				and intStyleId='$orderNo' and  strColor='$color' and  strSize = '$size' ";
				
				$result=$db->RunQuery($sqlOB);
				$row=mysql_fetch_array($result);
				$openBal = $row["openBal"];
				echo number_format($openBal,2); 
			?>            </td>
          </tr>
          <tr>
            <td>Closing Balance as at :</td>
            <td><?php echo $dateTo; ?> :</td>
            <td class="normalfnBLD1" align="right"><?php 
			$sqlCB = "select sum(dblQty) as openBal
				from stocktransactions
				where intMatDetailId='$matItem' and date(dtmDate) between '$dfrom' and '$dto' and strMainStoresID=$mainStore 
				and intStyleId='$orderNo' and  strColor='$color' and  strSize = '$size' ";
				
				$resultCB =$db->RunQuery($sqlCB);
				$rowB=mysql_fetch_array($resultCB);
				$closeBal = $rowB["openBal"];
				echo number_format($closeBal,2); 
			?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0" class="tablez">
        <thead>
          <tr>
            <td class="normalfntBtab" height="30">Style No</td>
            <td class="normalfntBtab">Doc No</td>
           <!-- <td class="normalfntBtab">Size</td>
            <td class="normalfntBtab">Color</td>-->
            <td class="normalfntBtab">Doc. Name</td>
            <td class="normalfntBtab">Unit</td>
            <td class="normalfntBtab">In Qty</td>
            <td class="normalfntBtab">Out Qty</td>
            <td class="normalfntBtab">Bal Qty</td>
            <td class="normalfntBtab">User</td>
            <td class="normalfntBtab">Location</td>
          </tr>
          </thead>
          <?php 
			$sql = " select concat(SUBSTRING(st.intDocumentYear,3,2),'/',st.intDocumentNo) as docNo,
			m.strItemDescription,st.strColor,st.dblQty as stockQty,
			st.strSize,s.strTypeName,st.strUnit,u.Name,DATE_FORMAT(date(st.dtmDate),'%d/%m/%Y') as stockDate, ms.strName,o.strStyle
			from stocktransactions st inner join matitemlist m on
			m.intItemSerial = st.intMatDetailId
			inner join stocktype s on st.strType = s.strType
			inner join useraccounts u on u.intUserID = st.intUser
			inner join mainstores ms on ms.strMainID = st.strMainStoresID
			inner join orders o on o.intStyleId = st.intStyleId 
			where intMatDetailId='$matItem' and date(st.dtmDate) between '$dfrom' and '$dto' and st.strMainStoresID=$mainStore
			and st.intStyleId='$orderNo' and  st.strColor='$color' and  st.strSize = '$size' 
			order by st.dtmDate";
		$firstRow = true;		
		$result=$db->RunQuery($sql);
		
		$totInQty =0;
		$totOutQty =0;
		$BalQty = $openBal ;
		
		while($row=mysql_fetch_array($result))
		{
			
			$currentDate = $row["stockDate"];
			$stockQty = $row["stockQty"];
			$stockInQty = $stockQty;
			$stockOutQty = $stockQty;
			if($firstRow)
			{
		  ?>
          <tr><td  height="25" colspan="9" ><table width="148" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50" class="normalfnth2B">Date :</td>
              <td width="98" class="normalfnth2B"><?php echo  $currentDate;?></td>
            </tr>
          </table></td>
          </tr>
          <tr>
           
            <td colspan="4" class="normalfntMidTAB" align="center">Starting Balance</td>
            <td class="normalfntRiteTAB"><?php echo number_format($openBal,2); ?></td>
            <td class="normalfntTAB">&nbsp;</td>
            <td class="normalfntTAB">&nbsp;</td>
            <td class="normalfntTAB">&nbsp;</td>
            <td class="normalfntTAB">&nbsp;</td>
          </tr>
          <tr>
                <td class="normalfntTAB"><?php echo $row["strStyle"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["docNo"]; ?></td>
               <!-- <td class="normalfntTAB"><?php echo $row["strSize"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>-->
                <td class="normalfntTAB"><?php echo $row["strTypeName"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
                <td class="normalfntRiteTAB"><?php if($stockInQty>=0)
														{
														$totInQty += $stockQty;
														$BalQty+=$stockInQty;
														}
													else
														{
														$stockInQty =0;
														$BalQty+=$stockInQty;
														}
												echo number_format($stockInQty,2);
											?></td>
                <td class="normalfntRiteTAB"><?php if($stockQty<0)
											   {
											   		$stockOutQty = $stockQty*-1;
													$totOutQty += abs($stockQty);
													$BalQty-=$stockOutQty;
											   }
												else
												{
													$stockOutQty= 0;
													$BalQty-=$stockOutQty;
												}
												echo number_format($stockOutQty,2);
																							 ?></td>
                <td class="normalfntRiteTAB"><?php echo number_format($BalQty,2); ?></td>
                <td class="normalfntTAB"><?php echo $row["Name"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strName"]; ?></td>
              </tr>
          <?php
		  $prevDate = $row["stockDate"];
		  	$firstRow = false;
		  	}//end first row if
			else
			{
			   if($prevDate != $currentDate)
				{
		  ?>
          	 <tr><td colspan="9" height="25"><table width="148" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50" class="normalfnth2B">Date :</td>
              <td width="98" class="normalfnth2B"><?php echo  $currentDate;?></td>
            </tr>
          </table></td></tr>
              <tr>
                <td class="normalfntTAB"><?php echo $row["strStyle"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["docNo"]; ?></td>
                <!--<td class="normalfntTAB"><?php echo $row["strSize"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>-->
                <td class="normalfntTAB"><?php echo $row["strTypeName"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
               <td class="normalfntRiteTAB"><?php if($stockInQty>=0)
			   											{
														$totInQty += $stockQty;
														$BalQty+=$stockInQty;
														}
													else
														{
														$stockInQty =0;
														$BalQty+=$stockInQty;
														}
												echo number_format($stockInQty,2);
											?></td>
                <td class="normalfntRiteTAB"><?php if($stockQty<0)
											   {
											   		$stockOutQty = $stockQty*-1;
													$totOutQty += abs($stockQty);
													$BalQty-=$stockOutQty;
											   }
												else
												{
													$stockOutQty= 0;
													$BalQty-=$stockOutQty;
												}
												echo number_format($stockOutQty,2);
																							 ?></td>
                <td class="normalfntRiteTAB"><?php echo number_format($BalQty,2);  ?></td>
                <td class="normalfntTAB"><?php echo $row["Name"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strName"]; ?></td>
              </tr>
		 <?php 
				}
				else
				{
         ?>
             <tr>
                <td class="normalfntTAB"><?php echo $row["strStyle"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["docNo"]; ?></td>
                <!--<td class="normalfntTAB"><?php echo $row["strSize"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>-->
                <td class="normalfntTAB"><?php echo $row["strTypeName"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
                <td class="normalfntRiteTAB"><?php if($stockInQty>=0)
														{
														$totInQty += $stockQty;
														$BalQty+=$stockInQty;
														}
													else
														{
														$stockInQty =0;
														$BalQty+=$stockInQty;
														}
												echo number_format($stockInQty,2);
											?></td>
                <td class="normalfntRiteTAB"><?php if($stockQty<0)
											   {
											   		$stockOutQty = $stockQty*-1;
													$totOutQty += abs($stockQty);
													$BalQty-=$stockOutQty;
											   }
												else
												{
													$stockOutQty= 0;
													$BalQty-=$stockOutQty;
												}
												echo number_format($stockOutQty,2);
																							 ?></td>
                <td class="normalfntRiteTAB"><?php echo number_format($BalQty,2);  ?></td>
                <td class="normalfntTAB"><?php echo $row["Name"]; ?></td>
                <td class="normalfntTAB"><?php echo $row["strName"]; ?></td>
              </tr>
          <?php
		  		} 
			}
			$prevDate = $currentDate;
		  }//end while
		  ?>
          <tr>
            <td>&nbsp;</td>
            
            <td>&nbsp;</td>
            <td colspan="2" class="normalfnth2B" align="center">Total</td>
            <td class="normalfntRite"><?php echo number_format($totInQty,2); ?></td>
            <td class="normalfntRite"><?php echo number_format($totOutQty,2); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
?>
