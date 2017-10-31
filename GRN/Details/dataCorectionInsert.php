
<?php 
	
	session_start();
	include "../../Connector.php";
				
$sql2 = "SELECT * FROM grndetails";
$result2 = $db->RunQuery($sql2);
while($row2= mysql_fetch_array($result2))
{
					
					$grnNo	=	$row2["intGrnNo"]; 
					$grnYear	=	$row2["intGRNYear"]; 
					$strStyleID = $row2["strStyleID"];
					$strBuyerPONO = $row2["strBuyerPONO"];
					$intMatDetailID = $row2["intMatDetailID"];
					$strColor = $row2["strColor"];
					$strSize = $row2["strSize"];
					$dblQty = round($row2["dblQty"],2);
					
					$sql3 = "select stocktransactions.dblQty
							FROM stocktransactions
							WHERE
							stocktransactions.strStyleNo =  '$strStyleID' AND
							stocktransactions.strBuyerPoNo =  '$strBuyerPONO' AND
							stocktransactions.intDocumentNo =  '$grnNo' AND
							stocktransactions.intDocumentYear =  '$grnYear' AND
							stocktransactions.intMatDetailId =  '$intMatDetailID' AND
							stocktransactions.strColor =  '$strColor' AND
							stocktransactions.strSize =  '$strSize' AND
							stocktransactions.strType =  'GRN'";
					
					$stockHave = 0;
					$result3 = $db->RunQuery($sql3);
					while($row3= mysql_fetch_array($result3))
					{
						$stockHave = 1;
						$stockQty  =round( $row3["dblQty"],2);
					}
					
					if(($stockHave==1) && ($stockQty!=$dblQty))
					{
/*						

						$sql10 = "select sum(dblQty) as returnQty from   stocktransactions 
								WHERE
								stocktransactions.strStyleNo 		=  '$strStyleID' AND
								stocktransactions.strBuyerPoNo 		=  '$strBuyerPONO' AND
								stocktransactions.intMatDetailId 	=  '$intMatDetailID' AND
								stocktransactions.strColor 			=  '$strColor' AND
								stocktransactions.strSize 			=  '$strSize' AND
								stocktransactions.strType 			=  'SRTSUP'
								";	
								
								
						$result10 = $db->RunQuery($sql10);
						while($row10= mysql_fetch_array($result10))
							$returnQty = $row10["returnQty"]*(-1);
						
						
						$total = $returnQty+$dblQty;
	
						if(($total==$stockQty) || ($dblQty<=0))
						{
							$sql8 = "UPDATE grndetails
									set dblQty = $stockQty
									WHERE
									grndetails.intGrnNo 			=  '$grnNo' AND
									grndetails.intGRNYear 			=  '$grnYear' AND
									grndetails.strStyleID 			=  '$strStyleID' AND
									grndetails.strBuyerPONO 		=  '$strBuyerPONO' AND
									grndetails.intMatDetailID 		=  '$intMatDetailID' AND
									grndetails.strColor 			=  '$strColor' AND
									grndetails.strSize 				=  '$strSize'
									";	
							$result8 = $db->RunQuery($sql8);
							if($result8)
							{
								$count++;
								echo "$grnNo/$grnYear , stock( $stockQty ) = grn( $dblQty )  , returnQty( $returnQty ) ( Done with Return $stockQty )<br>";
							}
						}
						else
						{
								
								$sql8 = "UPDATE stocktransactions set dblQty=$dblQty 
								WHERE
								stocktransactions.strStyleNo =  '$strStyleID' AND
								stocktransactions.strBuyerPoNo =  '$strBuyerPONO' AND
								stocktransactions.intDocumentNo =  '$grnNo' AND
								stocktransactions.intDocumentYear =  '$grnYear' AND
								stocktransactions.intMatDetailId =  '$intMatDetailID' AND
								stocktransactions.strColor =  '$strColor' AND
								stocktransactions.strSize =  '$strSize' AND
								stocktransactions.strType =  'GRN'
								";	
							$result8 = $db->RunQuery($sql8);
							$count++;
							echo "$grnNo/$grnYear , stock( $stockQty ) = grn( $dblQty )  , returnQty( $returnQty ) ( DONE save grn amount $dblQty )<br>";
						}*/
					}
					else if($stockHave!=1 )	
					{
					
								$sql4 = "SELECT
								storesbinallocation.strMainID,
								storesbinallocation.strSubID,
								storesbinallocation.strLocID,
								storesbinallocation.strBinID,
								storesbinallocation.intSubCatNo
								FROM
								storesbinallocation
								Inner Join matitemlist ON matitemlist.intSubCatID = storesbinallocation.intSubCatNo
								WHERE
								storesbinallocation.intStatus =  '1' AND
								matitemlist.intItemSerial =  '$intMatDetailID'
								";
								
							$result4 = $db->RunQuery($sql4);
						    while($row4=mysql_fetch_array($result4))
							{
								$mainId = $row4["strMainID"];	
								$strSubID = $row4["strSubID"];	
								$strLocID = $row4["strLocID"];	
								$strBinID = $row4["strBinID"];	
								$intSubCatNo = $row4["intSubCatNo"];
								break;				
							}
							
							$sql11 = "SELECT
										grndetails.intGrnNo,
										grndetails.intGRNYear,
										purchaseorderdetails.strUnit
										FROM
										purchaseorderdetails
										Inner Join grnheader ON purchaseorderdetails.intPoNo = grnheader.intPoNo AND purchaseorderdetails.intYear = grnheader.intYear
										Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear AND purchaseorderdetails.strStyleID = grndetails.strStyleID AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
										WHERE
										grndetails.strStyleID =  '$strStyleID' AND
										grndetails.strBuyerPONO =  '$strBuyerPONO' AND
										grndetails.intMatDetailID =  '$intMatDetailID' AND
										grndetails.strColor =  '$strColor' AND
										grndetails.strSize =  '$strSize' AND
										grndetails.intGrnNo =  '$grnNo' AND
										grndetails.intGRNYear =  '$grnYear'
										";
							$result11 = $db->RunQuery($sql11);
						    while($row11=mysql_fetch_array($result11))
							{
								$strUnit = $row11["strUnit"];	
							 }
							 
							$sql5 = "INSERT INTO eplan.stocktransactions 
									( 
									intYear, 
									strMainStoresID, 
									strSubStores, 
									strLocation, 
									strBin, 
									strStyleNo, 
									strBuyerPoNo, 
									intDocumentNo, 
									intDocumentYear, 
									intMatDetailId, 
									strColor, 
									strSize, 
									strType, 
									strUnit, 
									dblQty, 
									dtmDate, 
									intUser
									)
									VALUES
									('$grnYear', 
									'$mainId', 
									'$strSubID', 
									'$strLocID', 
									'$strBinID', 
									'$strStyleID', 
									'$strBuyerPONO', 
									'$grnNo', 
									'$grnYear', 
									'$intMatDetailID', 
									'$strColor', 
									'$strSize', 
									'GRN', 
									'$strUnit', 
									'$dblQty', 
									now(), 
									'1'
									);";
							$result5 = $db->RunQuery($sql5);
							$count++;
						if($result5)
						{
							echo "$grnNo/$grnYear  grn( $dblQty )  , returnQty( $returnQty ) (done insert )<br>";
						}
						else
							die( $sql5);
					}
if($count>200)
die('die');
						
								
}

'done all';
?>

</body>
</html>