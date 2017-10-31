<?php 
 session_start();
include "../../Connector.php";
$backwardseperator 	= '../../';
$Category = $_GET["mainCategory"];
$dfrom = $_GET["Dfrom"];
$dto   = $_GET["Dto"];
$mainCatID = $_GET["mainCatID"];
$mainStore = $_GET["mainStore"];
$matItem  = $_GET["matItem"];
$report_companyId =$_SESSION["FactoryID"];

$arrDfrom = explode('-',$dfrom);
$dateFrom = $arrDfrom[2].'/'.$arrDfrom[1].'/'.$arrDfrom[0];

$arrDto = explode('-',$dto);
$dateTo = $arrDto[2].'/'.$arrDto[1].'/'.$arrDto[0];
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>General Item :: Stock Movement</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
     <td><?php include $backwardseperator.'reportHeader.php'; ?>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td class="head2"></td>
      </tr>
      <tr>
        <td class="head2">General Item Movement Details</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="900" border="0" cellspacing="0" cellpadding="0" class="normalfnth2B">
                  <tr>
                    <td width="206">Category</td>
                    <td width="594"><?php echo $Category; ?></td>
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
                    <td width="102">From</td>
                    <td width="115"><?php echo $dateFrom; ?></td>
                    <td width="46">To</td>
                    <td width="137"><?php echo $dateTo; ?></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><table width="900" border="0" cellspacing="0" cellpadding="0" class="normalfnth2B">
                  <tr>
                    <td width="192">Opening Balance as at :</td>
                    <td width="114"><?php echo $dateFrom; ?> :</td>
                    <td width="294"><?php 
				$sqlOB = "select sum(dblQty) as openBal
				from genstocktransactions
				where intMatDetailId='$matItem' and date(dtmDate)<'$dfrom'  and strMainStoresID='$mainStore'";
				
				$result=$db->RunQuery($sqlOB);
				$row=mysql_fetch_array($result);
				$openBal = $row["openBal"];
				echo number_format($openBal,2); 
			?>
                    </td>
                  </tr>
                  <tr>
                    <td>Closing Balance as at :</td>
                    <td><?php echo $dateTo; ?> :</td>
                    <td><?php 
			$sqlCB = "select sum(dblQty) as openBal
				from genstocktransactions
				where intMatDetailId='$matItem' and date(dtmDate) <= '$dto' and strMainStoresID='$mainStore' ";
						
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
              <td><table width="900" border="0" cellspacing="0" cellpadding="0" class="tablez">
                  <thead>
                    <tr>
                      <td width="88" height="30" class="normalfntBtab"> Mat Detail ID </td>
                      <td width="102" class="normalfntBtab">Doc No</td>
                      <td width="131" class="normalfntBtab" nowrap="nowrap">Doc. Name</td>
                      <td width="51" class="normalfntBtab">Unit</td>
                      <td width="77" class="normalfntBtab">In Qty</td>
                      <td width="92" class="normalfntBtab">Out Qty</td>
                      <td width="88" class="normalfntBtab">Bal Qty</td>
                      <td width="59" class="normalfntBtab">User</td>
                      <td width="110" class="normalfntBtab" nowrap="nowrap">Location</td>
                    </tr>
                  </thead>
                  <?php 
			$sql = " select concat(GST.intDocumentYear,'/',GST.intDocumentNo) as docNo,GST.intMatDetailId,
		GMIL.strItemDescription,GST.dblQty as stockQty,
		GST.strType,GST.strUnit,u.Name,DATE_FORMAT(date(GST.dtmDate),'%d/%m/%Y') as stockDate, C.strName,GSTY.strName as stockType
		from genstocktransactions GST inner join genmatitemlist GMIL on
		GMIL.intItemSerial = GST.intMatDetailId
		inner join useraccounts u on u.intUserID = GST.intUser
		inner join companies C on C.intCompanyID = GST.strMainStoresID
		inner join genstocktype GSTY on GSTY.strType=GST.strType
		where intMatDetailId='$matItem' and date(GST.dtmDate) between '$dfrom' and '$dto' and GST.strMainStoresID='$mainStore'
			";
			$sql .= "order by GST.dtmDate";
			//echo $sql;
		$firstRow = true;		
		$result=$db->RunQuery($sql);
		
		$totInQty =$openBal;
		$totOutQty =0;
		$balQty=$openBal;
		while($row=mysql_fetch_array($result))
		{
			
			$currentDate = $row["stockDate"];
			$stockQty = $row["stockQty"];
			$stockInQty = $stockQty;
			$stockOutQty = $stockQty;
			if($firstRow)
			{
		  ?>
                  <tr>
                    <td  height="25" colspan="9" ><table width="148" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50" class="normalfnth2B">Date :</td>
                          <td width="98" class="normalfnth2B"><?php echo  $currentDate;?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="normalfntTAB" align="center">Starting Balance</td>
                    <td class="normalfntRiteTAB"><?php echo number_format($openBal,2); ?></td>
                    <td class="normalfntTAB">&nbsp;</td>
                    <td class="normalfntTAB">&nbsp;</td>
                    <td class="normalfntTAB">&nbsp;</td>
                    <td class="normalfntTAB" nowrap="nowrap">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfntTAB"><?php echo $row["intMatDetailId"]; ?></td>
                    <td class="normalfntTAB"><?php echo $row["docNo"]; ?></td>
                    <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["stockType"]; ?></td>
                    <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
                    <td class="normalfntRiteTAB"><?php if($stockInQty>=0)
														{
														$totInQty += $stockQty;
														$balQty+=$stockInQty;
														}
													else
													{
														$stockInQty =0;
														$balQty+=$stockInQty;
													}
												echo number_format($stockInQty,2);
											?></td>
                    <td class="normalfntRiteTAB"><?php if($stockQty<0)
											   {
											   		$stockOutQty = $stockQty*-1;
													$totOutQty += abs($stockQty);
													$balQty-=$stockOutQty;
													
											   }
												else
												{
													$stockOutQty= 0;
													$balQty-=$stockOutQty;
												}
												echo number_format($stockOutQty,2);
												
																							 ?></td>
                    <td class="normalfntRiteTAB"><?php echo number_format($balQty,2) ; ?></td>
                    <td class="normalfntTAB"><?php echo $row["Name"]; ?></td>
                    <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strName"]; ?></td>
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
                  <tr>
                    <td colspan="9" height="25"><table width="148" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50" class="normalfnth2B">Date :</td>
                          <td width="98" class="normalfnth2B"><?php echo  $currentDate;?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="normalfntTAB"><?php echo $row["intMatDetailId"]; ?></td>
                    <td class="normalfntTAB"><?php echo $row["docNo"]; ?></td>
                    <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["stockType"]; ?></td>
                    <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
                    <td class="normalfntRiteTAB"><?php if($stockInQty>=0)
														{
														$totInQty += $stockQty;
														$balQty+=$stockInQty;
														}
													else
													{
														$stockInQty =0;
														$balQty+=$stockInQty;
													}
												echo number_format($stockInQty,2);
											?></td>
                    <td class="normalfntRiteTAB"><?php if($stockQty<0)
											   {
											   		$stockOutQty = $stockQty*-1;
													$totOutQty += abs($stockQty);
													$balQty-=$stockOutQty;
											   }
												else
												{
													$stockOutQty= 0;
													$balQty-=$stockOutQty;
												}
												echo number_format($stockOutQty,2);
																							 ?></td>
                    <td class="normalfntRiteTAB"><?php echo number_format($balQty,2); ?></td>
                    <td class="normalfntTAB"><?php echo $row["Name"]; ?></td>
                    <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strName"]; ?></td>
                  </tr>
                  <?php 
				}
				else
				{
         ?>
                  <tr>
                    <td class="normalfntTAB"><?php echo $row["intMatDetailId"]; ?></td>
                    <td class="normalfntTAB"><?php echo $row["docNo"]; ?></td>
                    <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["stockType"]; ?></td>
                    <td class="normalfntTAB"><?php echo $row["strUnit"]; ?></td>
                    <td class="normalfntRiteTAB"><?php if($stockInQty>=0)
														{
														$totInQty += $stockQty;
														$balQty+=$stockInQty;
														}
													else
														{
														$stockInQty =0;
														$balQty+=$stockInQty;
														}
												echo number_format($stockInQty,2);
											?></td>
                    <td class="normalfntRiteTAB"><?php if($stockQty<0)
											   {
											   		$stockOutQty = $stockQty*-1;
													$totOutQty += abs($stockQty);
													$balQty-=$stockOutQty;
											   }
												else
												{
													$stockOutQty= 0;
													$balQty-=$stockOutQty;
												}
												echo number_format($stockOutQty,2);
																							 ?></td>
                    <td class="normalfntRiteTAB"><?php echo number_format($balQty,2); ?></td>
                    <td class="normalfntTAB"><?php echo $row["Name"]; ?></td>
                    <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["strName"]; ?></td>
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
    </table></td>
  </tr>
</table>

</body>
</html>
<?php 
function getItemName($itemID)
{
	global $db;
	$SQL = " select strItemDescription from genmatitemlist where intItemSerial='$itemID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strItemDescription"];
}
?>
