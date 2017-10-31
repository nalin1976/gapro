<?php
session_start();
include "../Connector.php";
		
$id=$_GET["id"];

if($id=="savePoDtails")
{
	$poNo			= $_GET["poNo"];
	$year			= $_GET["year"];
	$styleId		= $_GET["styleId"];
	$matDetailId	= $_GET["matDetailId"];
	$color			= $_GET["color"];
	$size			= $_GET["size"];
	$buyerPo		= $_GET["buyerPo"];
	$qty			= $_GET["qty"];
	
	
	// 										STEP 1 , check GRN 
	$SQL = "	SELECT
				dblPending,
				dblQty
				FROM `purchaseorderdetails`
				WHERE
				purchaseorderdetails.intPoNo =  '$poNo' AND
				purchaseorderdetails.intYear =  '$year' AND
				purchaseorderdetails.intStyleId =  '$styleId' AND
				purchaseorderdetails.intMatDetailID =  '$matDetailId' AND
				purchaseorderdetails.strColor =  '$color' AND
				purchaseorderdetails.strSize =  '$size' AND
				purchaseorderdetails.strBuyerPONO =  '$buyerPo'
				";
			$dblPending=0;
			$dblQty=0;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$dblPending = $row["dblPending"];
				$dblQty		= $row["dblQty"];
			}
			
			if(($dblQty - $qty)<0)
			{
				echo "Error-$qty";
				die();
			}
		///////////////////////////////////////// save history table
			$SQL = "
				select 	`intPoNo`, 
					`intYear`, 
					`intStyleId`, 
					`intMatDetailID`, 
					`strColor`, 
					`strSize`, 
					`strBuyerPONO`, 
					`strRemarks`, 
					`strUnit`, 
					`dblUnitPrice`, 
					`dblQty`, 
					`dblPending`, 
					`dblAdditionalQty`, 
					`dblAdditionalPendingQty`, 
					`intDeliverToCompId`, 
					`dtmItemDeliveryDate`, 
					`intPOType`
					from 
					purchaseorderdetails
					
					WHERE
					purchaseorderdetails.intPoNo =  '$poNo' AND
					purchaseorderdetails.intYear =  '$year' AND
					purchaseorderdetails.intStyleId =  '$styleId' AND
					purchaseorderdetails.intMatDetailID =  '$matDetailId' AND
					purchaseorderdetails.strColor =  '$color' AND
					purchaseorderdetails.strSize =  '$size' AND
					purchaseorderdetails.strBuyerPONO =  '$buyerPo'
					";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$compId = $row["intDeliverToCompId"];
				$SQL1= "
						insert into `eplan`.`purchaseorderhistory` 
							(
							`intPoNo`, 
							`intYear`, 
							`intStyleId`, 
							`intMatDetailID`, 
							`strColor`, 
							`strSize`, 
							`strBuyerPONO`, 
							`strRemarks`, 
							`strUnit`, 
							`dblUnitPrice`, 
							`dblQty`, 
							`dblPending`, 
							`dblAdditionalQty`, 
							`intDeliverToCompId`, 
							`dtmItemDeliveryDate`, 
							`intPOType`, 
							`cancelDate`, 
							`cancelUser`
							)
							values
							( 
							'".$row["intPoNo"]."', 
							'".$row["intYear"]."', 
							'".$row["intStyleId"]."', 
							'".$row["intMatDetailID"]."', 
							'".$row["strColor"]."', 
							'".$row["strSize"]."', 
							'".$row["strBuyerPONO"]."', 
							'".$row["strRemarks"]."', 
							'".$row["strUnit"]."', 
							'".$row["dblUnitPrice"]."', 
							'".$qty."', 
							'".$qty."', 
							'".$row["dblAdditionalQty"]."', 
							'$compId', 
							'".substr($row["dtmItemDeliveryDate"],0,10)."', 
							'".$row["intPOType"]."', 
							'".date('Y-m-d')."', 
							'".$_SESSION["UserID"]."'
							);";
				$result1 = $db->RunQuery($SQL1);
			}
			
			
			
			/////////////////////////////////////////			UPDATE PURCHASEORDER TABLE
				$SQL = "update purchaseorderdetails 
				set dblPending=dblPending-$qty , dblQty=dblQty-$qty
				WHERE
				purchaseorderdetails.intPoNo =  '$poNo' AND
				purchaseorderdetails.intYear =  '$year' AND
				purchaseorderdetails.intStyleId =  '$styleId' AND
				purchaseorderdetails.intMatDetailID =  '$matDetailId' AND
				purchaseorderdetails.strColor =  '$color' AND
				purchaseorderdetails.strSize =  '$size' AND
				purchaseorderdetails.strBuyerPONO =  '$buyerPo'
				";
			$result = $db->RunQuery($SQL);
			
			/////////////////////////////////////////			UPDATE PURCHASEORDER TABLE
				$SQL = "update materialratio  set dblBalQty=dblBalQty + $qty
				WHERE intStyleId = '$styleId' 
				AND strMatDetailID = '$matDetailId' 
				AND strColor = '$color' 
				AND strSize = '$size' 
				AND strBuyerPONO = '$buyerPo'
				";
			$result = $db->RunQuery($SQL);
			
			
			
	echo $result;
}

if($id=="saveGRNDtails")
{
	$intGrnNo			= $_GET["poNo"];
	$intGrnYear			= $_GET["year"];
	$styleId		= $_GET["styleId"];
	$matDetailId	= $_GET["matDetailId"];
	$color			= $_GET["color"];
	$size			= $_GET["size"];
	$buyerPo		= $_GET["buyerPo"];
	$qty			= $_GET["qty"];
	$unitPrice      = $_GET["unitPrice"];     
	$intDYear		=  date("Y");
	$intUserId		= 	$_SESSION["UserID"];
	$dtmDate		= 	date("Y-m-d");
	
	$SQLSTN = "select * from grnheader where intGrnNo='$intGrnNo' and intGRNYear='$intGrnYear' ";
	$RESULTstn = $db->RunQuery($SQLSTN);
	
	while($rwSTN = mysql_fetch_array($RESULTstn))
	{
		$GRNstnNo = $rwSTN["intSTNno"];
		$PONo     = $rwSTN["intPoNo"];
		$POYear   = $rwSTN["intYear"];
	}
	
	//Get main Store ID & Stock
	if($GRNstnNo != '')
	{
		$SQLmainStore = "SELECT strMainID FROM mainstores WHERE intCompanyId='$intCompanyId' AND intAutomateCompany ='1' AND intStatus ='1'";
		$Type = 'STNT';
		$STNSQL = "SELECT * FROM stocktransactions where intDocumentNo=$GRNstnNo AND intDocumentYear=$intGrnYear AND strType='STNT' and intStyleId='$styleId' and strBuyerPoNo='$buyerPo' and intMatDetailId='$matDetailId' and strColor= '$color'
		and strSize='$size' ";
		
		}
	else
	{
		$SQLmainStore = "SELECT strMainID FROM mainstores WHERE intCompanyId='$intCompanyId' AND intStatus ='1' and intAutomateCompany ='0'";
		$Type = 'GRN';
		$STNSQL = "SELECT * FROM stocktransactions where intDocumentNo=$intGrnNo AND intDocumentYear=$intGrnYear AND strType='GRN' and intStyleId='$styleId' and strBuyerPoNo='$buyerPo' and intMatDetailId='$matDetailId' and strColor= '$color'
		and strSize='$size' ";
		}
		
		$reStore = $db->RunQuery($SQLmainStore);
		while($rowS = mysql_fetch_array($reStore))
			{
				$MainStoreID = $rowS["strMainID"];
			}
		//echo $STNSQL;	
		//update GRN Details
		$SQLGRNdet = " UPDATE grndetails
					SET dblQty= dblQty-$qty
					WHERE intGrnNo='$intGrnNo' AND intGRNYear='$intGrnYear' AND intStyleId = '$styleId' AND  strBuyerPONO ='$buyerPo' AND intMatDetailID = '$matDetailId' AND  strColor = '$color'  AND strSize='$size' ";
					
		$resultGRN = $db->RunQuery($SQLGRNdet);
		
		//update Stocktransaction 
		
		$reStock = $db->RunQuery($STNSQL);
		while($rowSt = mysql_fetch_array($reStock))
			{
				$strMainID = $rowSt["strMainStoresID"]; 	
								$strSubID = $rowSt["strSubStores"];  		 
								$strLocID = $rowSt["strLocation"];  		 
								$strBinID = $rowSt["strBin"];  			 		 
								$dblQty3 = $rowSt["dblQty"]; 
								$intMatDetailId=$rowSt["intMatDetailId"]; 
								
								$styleID = $rowSt["intStyleId"];
								$BuyerPO = $rowSt["strBuyerPoNo"];
								$Color = $rowSt["strColor"];
								$size = $rowSt["strSize"];
								$Unit = $rowSt["strUnit"];
								//echo $strMainID;
							//!!!!!!	FIND SUB CAT NO 	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
								$intSubCatNo='';
								$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailId ";
									$x1 = $db->RunQuery($x);	
									while($row = mysql_fetch_array($x1))
									{
										$intSubCatNo=$row["intSubCatID"];
									}
			    			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
								
								
								$STqty = $qty*-1;
								//$newDblQty = $dblQty3-$qty;
				//update bin details				
					$SQL4 = "UPDATE storesbinallocation 
								SET
								dblFillQty = dblFillQty-$qty 
								WHERE
								strMainID = '$strMainID' 	AND
								strSubID = '$strSubID' 		AND 
								strLocID = '$strLocID' 		AND 
								strBinID = '$strBinID' 		AND 
								intSubCatNo = $intSubCatNo";
								
								$y = $db->RunQuery($SQL4);	
						//echo $SQL4;		
								
								if($GRNstnNo != '')
						{
						
						//insert minus STNT record to apperal
							$SQLSTNTStock = "insert into stocktransactions 
																(intYear, 
																strMainStoresID, 
																strSubStores, 
																strLocation, 
																strBin, 
																intStyleId, 
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
																values
																('$intDYear', 
																'$strMainID', 
																'$strSubID', 
																'$strLocID', 
																'$strBinID', 
																'$styleID', 
																'$BuyerPO', 
																'$GRNstnNo', 
																'$intGrnYear', 
																'$intMatDetailId', 
																'$Color', 
																'$size', 
																'STNT', 
																'$Unit', 
																'$STqty', 
																'$dtmDate', 
																'$intUserId'
																)";
								
					         $SaveStockUpdateSTNT = $db->RunQuery($SQLSTNTStock);	
							//echo $SQLSTNTStock;
							 //get STNF record details
							 $STNFSQL = "SELECT * FROM stocktransactions where intDocumentNo=$GRNstnNo AND intDocumentYear=$intGrnYear AND strType='STNF' AND intStyleId='$styleID' AND strBuyerPoNo='$BuyerPO' AND intMatDetailId='$intMatDetailId' AND strColor='$Color' AND strUnit='$Unit' AND strSize='$size'";
							//echo $STNFSQL;
							 $STNFResult = $db->RunQuery($STNFSQL);	
								while($rowST = mysql_fetch_array($STNFResult))
								{
									$STNFmainStore = $rowST["strMainStoresID"];
									$STNFsubStore  = $rowST["strSubStores"];
									$STNFLoc       = $rowST["strLocation"];
									$STNFBin       = $rowST["strBin"];
								}
							
							 //insert plus  STNF  record to trading -----------------------------
							 		
								$SQLSTNFStock = "insert into stocktransactions 
																(intYear, 
																strMainStoresID, 
																strSubStores, 
																strLocation, 
																strBin, 
																intStyleId, 
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
																values
																('$intDYear', 
																'$STNFmainStore', 
																'$STNFsubStore', 
																'$STNFLoc', 
																'$STNFBin', 
																'$styleID', 
																'$BuyerPO', 
																'$GRNstnNo', 
																'$intGrnYear', 
																'$intMatDetailId', 
																'$Color', 
																'$size', 
																'STNF', 
																'$Unit', 
																'$qty', 
																'$dtmDate', 
																'$intUserId'
																)";
								
					         $SaveStockSTNF = $db->RunQuery($SQLSTNFStock);
							 
							 //------------------------------------------------------------------	
							 
							 //insert minus GRN to trading ***************************
							 
							 $SQLGRNStock = "insert into stocktransactions 
																(intYear, 
																strMainStoresID, 
																strSubStores, 
																strLocation, 
																strBin, 
																intStyleId, 
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
																values
																('$intDYear', 
																'$STNFmainStore', 
																'$STNFsubStore', 
																'$STNFLoc', 
																'$STNFBin', 
																'$styleID', 
																'$BuyerPO', 
																'$intGrnNo', 
																'$intGrnYear', 
																'$intMatDetailId', 
																'$Color', 
																'$size', 
																'GRN', 
																'$Unit', 
																'$STqty', 
																'$dtmDate', 
																'$intUserId'
																)";
								
					         $SaveStockGRN = $db->RunQuery($SQLGRNStock);
							 
							 //*****************************************************			
//			
						}
						else
						{
							
								//insert minus GRN record to trading --------------------------------------------				
												$SQLAppStock = "insert into stocktransactions 
																(intYear, 
																strMainStoresID, 
																strSubStores, 
																strLocation, 
																strBin, 
																intStyleId, 
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
																values
																('$intDYear', 
																'$strMainID', 
																'$strSubID', 
																'$strLocID', 
																'$strBinID', 
																'$styleID', 
																'$BuyerPO', 
																'$intGrnNo', 
																'$intGrnYear', 
																'$intMatDetailId', 
																'$Color', 
																'$size', 
																'GRN', 
																'$Unit', 
																'$STqty', 
																'$dtmDate', 
																'$intUserId'
																)";
								//echo $SQLAppStock;
					         $SaveStockUpdateGRN = $db->RunQuery($SQLAppStock);	
							 
							 //------------------------------------------------------------------------
						}
						
						//update purchase order details 
						
						 $qSQL = "UPDATE purchaseorderdetails set dblPending = dblPending + $qty
						   WHERE intPoNo = $PONo 
						   AND intYear=$POYear 
						   AND intStyleId='$styleId' 
						   AND intMatDetailID=$matDetailId
						   AND strColor='$color'
						   AND strSize='$size'
						   AND strBuyerPONO='$buyerPo'";
						  // echo $qSQL;
					$qResult = $db->RunQuery($qSQL);
			}
		
		
}
?>