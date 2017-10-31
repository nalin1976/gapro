<?php
session_start();


include "../../Connector.php";
include "../../EmailSender.php";
include "emailcode.php";
$eml =  new EmailSender();
//$Emaildb = new EmailSender();
//$emailcode = new ClassEmailcode();

//$db->CloseConnection();
//$id="saveGrnHeader";
$id=$_GET["id"];
///$abc = '';
//$db=NULL;
//$chkPriceDiscripancy = true;
if($id=="saveGrnHeader")
{
		global $db;
		//$db->OpenConnection();
		//if(isset( $_SESSION["sessionDB"]));
			
		//$db->RunQuery('BEGIN');
		
		//echo "error->GRN no is exceeded. GRN Not Saved. pls save it again.";
		//return;
				
		  //var tblGrn = document.getElementById("tblMainGrn");
		  $intGrnNo			=$_GET["intGrnNo"];
		  $intGRNYear		= $_GET["intGRNyear"];
		  $intPoNo			=trim($_GET["intPoNo"]);
		  $intYear			=trim($_GET["intYear"]);
		  $dtmRecievedDate	=$_GET["dtmRecievedDate"];
		  $strInvoiceNo		=trim($_GET["strInvoiceNo"]);
		  $strSupAdviceNo	=trim($_GET["strSupAdviceNo"]);
		  $dtmAdviceDate	=$_GET["dtmAdviceDate"];
		  $strBatchNO		=trim($_GET["strBatchNO"]);
		  $intUserId		=$_SESSION["UserID"];
		  $intCompanyId		=$_SESSION["FactoryID"];
		  $cusdecNo			= $_GET["cusdecNo"];
		  $entryNo			= $_GET["EntryNo"];
		  $grnValue			= $_GET["grnValue"];
		 // $invoiceValue 	= $_GET["invoiceValue"];
		  $remarks			= $_GET["remarks"];
		 // ======================= GET NEXT GRN NO ================================
		 
		// $result = $db->RunQuery('BEGIN');
		 
		  if($intGrnNo=="" && $intGRNYear == "")
		  {
		  	 $intGRNYear		= date("Y");
			 $intGrnNo          = generateGRNno();
		   
		 }
		  //==========================================================
		
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	//delete grn header
	$delSQL = "DELETE FROM grnheader WHERE intGrnNo = '$intGrnNo' AND intGRNYear = '$intGRNYear'";
	$delResult = $db->RunQuery($delSQL);

	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	
	
	$SQL="insert into grnheader".
	"(intGrnNo,".
	"intGRNYear, ".
	"intPoNo, ".
	"intYear, ".
	"dtmRecievedDate, ".
	"strInvoiceNo, ".
	"strSupAdviceNo, ".
	"intStatus, ".
	"intPrintStatus, ".
	"intUserId, ".
	"intConfirmedBy, ".
	"strCancelledReason, ".
	"intCancelledBy, ".
	"intGRNComplete, ".
	"intGRNApproved, ".
	"dtmAdviceDate, ".
	"strBatchNO,".
	"intCompanyID,".
	"strCusdecNo,".
	"strEntryNo,dblGRNValue,dblInvoiceValue,strPayDisReason )".
	"values".
   "($intGrnNo, ".
	"$intGRNYear, ".
	"$intPoNo, ".
	"$intYear, ".
	"now(), ".
	"'$strInvoiceNo', ".
	"'$strSupAdviceNo', ".
	"0, ".
	"0, ".
	"$intUserId, ".
	"0, ".
	"'', ".
	"0, ".
	"0, ".
	"0, ".
	"'$dtmAdviceDate', ".
	"'$strBatchNO',".
	"$intCompanyId,".
	" '$cusdecNo',".
	"'$entryNo',$grnValue,0,'$remarks')";
	
		//$result = $db->RunQuery('ROLLBACK');
		//return;
		//echo $SQL;
		$intSave = $db->RunQuery($SQL);
		
		if (!$intSave)
		{
			echo 'error->GRN Header not saved. Pls save it again.';
			return;
		}
		
	
	
	
		//^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^^^
		//delete grn Details and update purchaseorder details table*/

			$pSQL = "SELECT * FROM grndetails where intGrnNo='$intGrnNo' AND intGRNYear='$intGRNYear'";
			$qSQL="";
			$pResult = $db->RunQuery($pSQL);	
			while($row = mysql_fetch_array($pResult))
			{
			    	   $strStyleID2		 =$row["intStyleId"];
					   $intMatDetailID2	 =$row["intMatDetailID"];
					   $strColor2		 =$row["strColor"];
					   $strSize2		 =$row["strSize"];
					   $strBuyerPONO2	 = $row["strBuyerPONO"];
					   $dblQty2			 =$row["dblQty"];
					   $dblExQty         = $row["dblExcessQty"];
					   $dblQtywithoutEx  = $dblQty2 - $dblExQty;
					   //$dblAdditionalQty =$row["dblAditionalQty"];

				   $qSQL = "UPDATE purchaseorderdetails set dblPending = dblPending + $dblQty2 
						   WHERE intPoNo = $intPoNo 
						   AND intYear=$intYear 
						   AND intStyleId='$strStyleID2' 
						   AND intMatDetailID=$intMatDetailID2
						   AND strColor='$strColor2'
						   AND strSize='$strSize2'
						   AND strBuyerPONO='$strBuyerPONO2'";
					$qResult = $db->RunQuery($qSQL);
				if(!$qResult)
				{
					echo "error->Can't revice purchase order details.pls save it again";
					return;
				}

			
			}
			$delSQL = "DELETE FROM grndetails WHERE intGrnNo='$intGrnNo' AND intGRNYear='$intGRNYear'";
			$delResult = $db->RunQuery($delSQL);
		
			
				
		//========================================= FOR BINS ==========================================================


			$pSQL="";

				$pSQL = "SELECT * FROM stocktransactions_temp where intDocumentNo=$intGrnNo AND intDocumentYear=$intGRNYear AND strType='GRN'";
				$pResult = $db->RunQuery($pSQL);	
				while($row = mysql_fetch_array($pResult))
				{
					
								$strMainID = $row["strMainStoresID"]; 	
								$strSubID = $row["strSubStores"];  		 
								$strLocID = $row["strLocation"];  		 
								$strBinID = $row["strBin"];  			 		 
								$dblQty3 = $row["dblQty"]; 
								$intMatId  = $row["intMatDetailId"];

				//!!!!!!	FIND SUB CAT NO 	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$intSubCatNo='';
				$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatId ";
					$x1 = $db->RunQuery($x);	
					while($row1 = mysql_fetch_array($x1))
					{
						$intSubCatNo=$row1["intSubCatID"];
					}
			    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				
					$SQL4 = "UPDATE storesbinallocation 
								SET
								dblFillQty = dblFillQty-$dblQty3 
								WHERE
								strMainID = '$strMainID' 	AND
								strSubID = '$strSubID' 		AND 
								strLocID = '$strLocID' 		AND 
								strBinID = '$strBinID' 		AND 
								intSubCatNo = $intSubCatNo";
								
								$y = $db->RunQuery($SQL4);	
							if(!$y)
							{
								echo 'error->Storesbinallocation not found. pls check and save it again.' ; 
								return;
							}
				}
					
					$delSQL = "DELETE FROM stocktransactions_temp WHERE intDocumentNo=$intGrnNo AND intDocumentYear=$intGRNYear AND strType='GRN'";
					$delResult = $db->RunQuery($delSQL);
				//======================================================================
				
				$_SESSION["sessionDB"]= serialize($db);
				
				echo "saved->$intGrnNo/$intGRNYear"; 
				$db->CloseConnection();
				//$db->RunQuery('UNLOCK TABLES');
}

if($id=="commit")
{
	global $db;
	$db = unserialize($_SESSION["sessionDB"]);
	$db->commit();
	//$db->CloseConnection();
	//print_r($db);
}

if($id=="rollback")
{
	global $db;
	$db = unserialize($_SESSION["sessionDB"]);
	$db->rollback();	
	
}

if($id=="saveGrnDetails")
{	
			global $db;
			//$db->OpenConnection();
			$db = unserialize($_SESSION["sessionDB"]);
			 $intUserId		=$_SESSION["UserID"];
			//$db->$RunQuery('LOCK TABLES grndetails WRITE');
			//print_r($db);
			$count	   			= $_GET["count"];
			$intGrnNo   		= $_GET["intGrnNo"];
			$intGRNYear			= $_GET["intGRNYear"];
			$strStyleID			= trim($_GET["strStyleID"]);
			$strBuyerPONO		= $_GET["strBuyerPONO"];
			$strBuyerPOid       = $_GET["strBuyerPOid"];
			$intMatDetailID		= $_GET["intMatDetailID"];
			$strColor			= $_GET["strColor"];
			$strSize			= $_GET["strSize"];
			$dblQty 			= $_GET["dblQty"];
			$dblCapacityQty		= $_GET["dblCapacityQty"];
			$dblExcessQty		= $_GET["dblExcessQty"];
			$dblRate			= $_GET["dblRate"];
			$intPoNo			= $_GET["intPoNo"];
			$intYear			= $_GET["intYear"];
			$dblInvoicePrice    = $_GET["dblInvoicePrice"];
			$dblBalance			=   $dblQty;
			$dblValueBalance	=  ($dblQty * $dblRate);
			$strUnit			=$_GET["strUnit"];//dblPendingAddtionalQty
			$active			    = $_GET["pub_ActiveCommonBins"];
			//$automateBin 		= $_GET["pub_AutomateBin"];
			$mainStore			= $_GET["mainStore"];	
			///$dblPendingAddtionalQty			=$_GET["dblPendingAddtionalQty"];//dblPendingAddtionalQty
		
			/*if($strBuyerPOid == 'ratio')
				$strBuyerPOid = '#Main Ratio#';*/
	
				//!!!!!!	FIND SUB CAT NO 	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$intSubCatNo='';
				$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailID ";
					$x1 = $db->RunQuery($x);	
					while($row = mysql_fetch_array($x1))
					{
						$intSubCatNo=$row["intSubCatID"];
					}
			    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				
 $dblQtywithoutEx  = $dblQty - $dblExcessQty;
//echo $dblQtywithoutEx;
// INSERT GRN DETAILS 
		//check PO price and invoice price if there is a price difference payment price will be 0
		$paymentPrice = $dblRate;
		if($dblRate <> $dblInvoicePrice)
			$paymentPrice = 0;
			
	$SQLdetails = "insert into grndetails 
				(intGrnNo, 
				intGRNYear, 
				intStyleId, 
				strBuyerPONO, 
				intMatDetailID, 
				strColor, 
				strSize, 
				dblQty, 
				dblExcessQty, 
				dblBalance, 
				dblValueBalance,
				dblPoPrice,
				dblInvoicePrice,
				dblPaymentPrice
				)
				values
			    ('$intGrnNo', 
				 '$intGRNYear', 
				'$strStyleID', 
				'$strBuyerPOid', 
				 '$intMatDetailID', 
				'$strColor', 
				'$strSize', 
				 $dblQty, 
				 $dblExcessQty, 
				 $dblBalance, 
				 $dblValueBalance,
				 $dblRate,
				 $dblInvoicePrice,
				 $paymentPrice
				);";
		//$db->CloseConnection();
		$intSave = $db->RunQuery($SQLdetails);
		
		//echo 'xxxx('.$intSave.')xxxx';
				//return ;
				
		if(!$intSave)
		{
			echo "error->GRN details insert error. row no $count";
			return;
		}
		
		$SQL2 =    "UPDATE purchaseorderdetails set dblPending = dblPending - $dblQty 
				   WHERE intPoNo = $intPoNo 
				   AND intYear=$intYear 
				   AND intStyleId='$strStyleID' 
				   AND intMatDetailID=$intMatDetailID
				   AND strColor='$strColor'
				   AND strSize='$strSize'
				   AND strBuyerPONO='$strBuyerPOid'";
			$result = $db->RunQuery($SQL2);	
			if(!$result)
			{
				echo 'error->purchaseorder details update error. row no $count';
				return;
			}
			
			
			//////////////////				FOR STOCK TRANS ACTION  ///////////////////////////////////
			//start 2010-12-06 ********************************************************************
			//Default bin system activated 
			if($active==1)
			{
				
				//get bin details
				$strMainStoresID	= $mainStore;
				$binDet = getDefaultBinDetails($mainStore);
				while($row = mysql_fetch_array($binDet))
						{
							$strSubStores		=$row["strSubID"];
							$strLocation		=$row["strLocID"];
							$strBin				=$row["strBinID"];
						}
						
				//check availability of storesbinallocation
				$resBinAllo = chkBinAllocationAv($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo);
				
				if($resBinAllo != '1')
				{
					//insert data to storesbinallocation 
					$saveRes = saveStorebinAllocationDetails($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo);
					if(!$saveRes)
					{
						echo 'error->Bin allocation error. ';
						return;
					}
				}
				//check default bin has a auto assign bin
				$automateBin = 	getAutomateMainstoreDet($strMainStoresID);
				//get bin details for auto assign default bin
				if($automateBin == 1)
				{
					//get virtualMainstore id
					$VirtualMainStoresID = GetVirtualMainstore($strMainStoresID);
					
					//get virtual bin details
					$VirtualstrSubStores = GetVertualSubStore($strSubStores);
					$VirtualstrLocation  = GetVertualLocation($strLocation);
					$VirtualstrBin	     = GetVertualBin($strBin);
					
					
					$resVirtualBinAllo = chkBinAllocationAv($VirtualMainStoresID,$VirtualstrSubStores,$VirtualstrLocation,$VirtualstrBin,$intSubCatNo);
					if($resVirtualBinAllo != '1')
					{
						//insert data to storesbinallocation - virtual bin
						$saveResVbin = saveStorebinAllocationDetails($VirtualMainStoresID,$VirtualstrSubStores,$VirtualstrLocation,$VirtualstrBin,$intSubCatNo);
						if(!$saveResVbin)
						{
							echo 'error->Bin allocation error. ';
							return;
						}
					}
				}
				
				//save data to stocktransaction temp
				$save_temp = saveDatatoStockTemp($intYear,$strMainStoresID,$strSubStores,$strLocation,$strBin,$strStyleID,$strBuyerPOid,$intGrnNo,$intGRNYear,$intMatDetailID,$strColor,$strSize,$strUnit,$dblQty,$intUserId);
				
				//update bin details
				$save_bin = updateBinLocation($dblQty,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo);
				
				if(!$save_temp || !save_bin)
				{
					echo 'error->save stock details. ';
								return;
				}	
			}				
			
			
			
		
		//$_SESSION["sessionDB"]= serialize($db);
		//$db->$RunQuery('UNLOCK TABLES');
		echo 'saved->saved';
} 


if($id=="saveBin")
{
				global $db;
				$db = unserialize($_SESSION["sessionDB"]);
				$count	   			= $_GET["count"];

				$intGrnNo			=$_GET["intGrnNo"];
				$strStyleNo			=$_GET["strStyleNo"];
				$strMainStoresID	=$_GET["strMainStoresID"];
				$strSubStores		=$_GET["strSubStores"];
				$strLocation		=$_GET["strLocation"];
				$strBin				=$_GET["strBin"];
				$strBuyerPoNo		=$_GET["strBuyerPoNo"];//str_replace("***","#",$_GET["strBuyerPoNo"]);
				$strBuyerPOid       = $_GET["strBuyerPOid"];
				$intMatDetailId		=$_GET["intMatDetailId"];
				$strColor			=$_GET["strColor"];
				$strSize			=$_GET["strSize"];
				$strUnit			=$_GET["strUnit"];
				$dblQty				=$_GET["dblQty"];
			    $intUserId			=$_SESSION["UserID"];
				$intYear			= date("Y");
				$dtmDate			= date("Y-m-d");
			
			
				//!!!!!!	FIND SUB CAT NO 	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$intSubCatNo='';
				$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailId ";
					$x1 = $db->RunQuery($x);	
					while($row = mysql_fetch_array($x1))
					{
						$intSubCatNo=$row["intSubCatID"];
					}
			    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			
			

	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ STOCK TRANSACTION TABLE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
			//save details to stocktransaction temp
			$result = saveDatatoStockTemp($intYear,$strMainStoresID,$strSubStores,$strLocation,$strBin,$strStyleNo,$strBuyerPOid,$intGrnNo,$intYear,$intMatDetailId,$strColor,$strSize,$strUnit,$dblQty,$intUserId);
		
		if(!$result)
		{
			echo "error->bin saving error.. row no $count. pls save it again.";
			return;
		}
			
		
	$SQL = "UPDATE storesbinallocation  
			SET
			dblFillQty = dblFillQty+$dblQty 
			WHERE
			strMainID = '$strMainStoresID' 	AND
			strSubID = '$strSubStores' 		AND 
			strLocID = '$strLocation' 		AND 
			strBinID = '$strBin' 			AND 
			intSubCatNo = $intSubCatNo 		AND 
			intStatus=1" ;
			
			$y = $db->RunQuery($SQL);

			if(!$y)
			{
				echo 'error->storesbinallocation update(+) error . row no $count ';
				return;
			}
			
			echo 'saved->saved';
			
}

if($id=="confirmed")
{	
	$intGrnNo 	= 	$_GET["intGrnNo"];
	$intYear	= 	$_GET["intYear"];
	$intUserId	=	$_SESSION["UserID"];
	$dtmDate	= 	date("Y-m-d");
	$AutomateCom = 	$_GET["AutomateCom"];
	$MainStore	=	$_GET["MainStore"];
	$SubStore	=	$_GET["SubStore"];
	 $intCompanyId	=$_SESSION["FactoryID"];
	 $PONO      =   $_GET["PONo"];
	 $POYear    =   $_GET["poYear"];
	 
    $sql1 = "delete from purchaseorderheader_excess where intGrnNo='$intGrnNo' and intGrnYear='$intYear'";
	$result1=$db->RunQuery($sql1);
	
    $sql2 = "delete from purchaseorderdetails_excess where intGrnNo='$intGrnNo' and intGrnYear='$intYear'";
	$result2=$db->RunQuery($sql2);
	
	 
	 $xml = simplexml_load_file('../../config.xml');
	 $chkPriceDiscripancy = $xml->GRN->SendPriceDiscrepancyMail;
	
	 $a='';	
	 if(CheckIsExQtyAvalable($intGrnNo,$intYear))
	 {
	 	$pp = checkExcessPOApprove($intGrnNo,$intYear);
		if((GenarateAutoExPo($intGrnNo,$intYear))|| (!$pp))
		{
			if($AutomateCom == '1')
			{
				$CurrSTNno = checkSTNnoAvinGRNheader($intGrnNo,$intYear);
				
				if($CurrSTNno == '' || is_null($CurrSTNno))
				{
					//generate new STN no 
					$NewSTNno = generateSTNno($intCompanyId);
					$resSTN = updateSTNnoInGRN($NewSTNno,$intGrnNo,$intYear);
				}
								
			}
			$result = sendMailforAdditionalPO($intGrnNo,$intYear);
			
		}
		else
		{
			$result = 'Error in generating additional PO';
		}
	 }
	 else
	 {
	 	if($AutomateCom == '1')
		{
			//update automate bin details - trading apparel transaction
			$a = saveAutomateBinStock($intGrnNo,$intYear,$MainStore);
			
		}//end if trading apperal transaction 
		
		if($a == '')
		{
				//update stock details
				$result = updateStocktransaction($intGrnNo,$intYear);
				
				if($result == '1')
				{
					//send mail for price discripancy in grn detail table
					
					if($chkPriceDiscripancy)
					{
						sendPriceDiscrepencyMail($intGrnNo,$intYear,$PONO,$POYear);
					}
					//Send mail for trim inspection --------------------------------------------------
					senMainforTrimInspection($intGrnNo,$intYear);
				}
		}
		else
		{
			$result=$a;
		}
	 }
	 
				
	echo $result;
			
			
}


if($id=="cancel")
{
$intGrnNo 		= $_GET["intGrnNo"];
$intGrnYear 	= $_GET["intGrnYear"];
$intYear		= $_GET["intYear"];
$intUserId		= $_SESSION["UserID"];
$dtmDate		= date("Y-m-d");
$intPoNo 		= $_GET["intPoNo"];
$intDYear		= date("Y");
$intCompanyId	= $_SESSION["FactoryID"];
	 
//BEGIN - Check wheather STNT record available in GRN header table.
	$SQLSTN = "select * from grnheader where intGrnNo='$intGrnNo' and intGRNYear='$intGrnYear' ";
	$RESULTstn = $db->RunQuery($SQLSTN);	
	while($rwSTN = mysql_fetch_array($RESULTstn))
	{
		$GRNstnNo = $rwSTN["intSTNno"];
	}
//END - Check wheather STNT record available in GRN header table.

//BEGIN - Get main Store ID & Stock.
	if($GRNstnNo != '')
	{
		$SQLmainStore = "SELECT strMainID FROM mainstores WHERE intCompanyId='$intCompanyId' AND intAutomateCompany ='1' AND intStatus ='1'";
		$STNSQL = "SELECT * FROM stocktransactions where intDocumentNo='$GRNstnNo' AND intDocumentYear='$intGrnYear' AND strType='STNT'";
		
		$reStore = $db->RunQuery($SQLmainStore);
		while($rowS = mysql_fetch_array($reStore))
		{
			$MainStoreID = $rowS["strMainID"];
		}
	}
	else
	{
		$STNSQL = "SELECT * FROM stocktransactions where intDocumentNo='$intGrnNo' AND intDocumentYear='$intGrnYear' AND strType='GRN'";		
		$reStore = $db->RunQuery($STNSQL);
		while($rowS = mysql_fetch_array($reStore))
		{
			$MainStoreID = $rowS["strMainStoresID"];
		}		
	}
//
	if($MainStoreID=="")
		$MainStoreID = GetMainStoreIdFromStockTemp($intGrnNo,$intGrnYear);
//
//END - Get main Store ID & Stock.

	$pSQL = "SELECT * FROM grndetails where intGrnNo='$intGrnNo' AND intGRNYear='$intGrnYear'";
	$pResult = $db->RunQuery($pSQL);	
	while($row = mysql_fetch_array($pResult))
	{
		$intStyleId		= $row["intStyleId"];
		$intMatDetailID	= $row["intMatDetailID"];
		$strColor		= $row["strColor"];
		$strSize		= $row["strSize"];
		$strBuyerPONO	= $row["strBuyerPONO"];
		$GRNdblQty		= $row["dblQty"];
					   
//get Relavant Stock Quantity					   
		$SQLStock = "SELECT SUM(dblQty) AS StockQty FROM stocktransactions WHERE intStyleId='$intStyleId' AND strBuyerPONO = '$strBuyerPONO' AND intMatDetailId = '$intMatDetailID' AND strColor='$strColor' AND strSize='$strSize' AND strMainStoresID = '$MainStoreID' and intGrnNo= '$intGrnNo' and intGrnYear='$intGrnYear' and strGRNType='S' ";
		
		$notTrimStockQty = GetNotTrimStockQty($intStyleId,$strBuyerPONO,$intMatDetailID,$strColor,$strSize,$intGrnNo,$intGrnYear);							   
		$resStock =  $db->RunQuery($SQLStock);					   
	  	while($rowST = mysql_fetch_array($resStock))
	   	{
			$StockQty = $rowST["StockQty"]+$notTrimStockQty;
			
			if($StockQty < $GRNdblQty || $StockQty==0)
			{
				echo "Some items not in stock . So you can't cancel GRN No. \"$intGrnYear/$intGrnNo\"";
				return;
			}
	   	}
		
//BEGIN - CHECK WITH MATREQUETION
					   	   
		$SQLMRN = " SELECT SUM(dblQty) AS MRNqty FROM matrequisitiondetails md INNER JOIN matrequisition m ON
md.intMatRequisitionNo = m.intMatRequisitionNo and md.intYear = m.intMRNYear
  WHERE intStyleId='$intStyleId' AND strBuyerPONO='$strBuyerPONO' AND strMatDetailID ='$intMatDetailID' AND strColor='$strColor' AND strSize='$strSize' AND
strMainStoresID='$MainStoreID' and intGrnNo = '$intGrnNo' and  intGrnYear = '$intGrnYear' ";					   
		$resMRN =  $db->RunQuery($SQLMRN);					   
	   while($rowM = mysql_fetch_array($resMRN))
	   {									
			if($rowM["MRNqty"]>0)
			{
				echo "Items already MRN. Can't cancel GRN ";
				return;
			}				
	   }
//END -  CHECK WITH MATREQUETION 
						
	}			
		$chkOrderComStyle = chkGRNcontainOrdercompleteStyle($intGrnNo,$intGrnYear);
		if($chkOrderComStyle>0)
		{
			echo " GRN contain completed order item(s). Can't cancel GRN ";
			return; 
		}
			
		$STNRes = $db->RunQuery($STNSQL);			
		while($row = mysql_fetch_array($STNRes))
		{
			$strMainID 		= $row["strMainStoresID"]; 	
			$strSubID 		= $row["strSubStores"];  		 
			$strLocID 		= $row["strLocation"];  		 
			$strBinID 		= $row["strBin"];  			 		 
			$dblQty3 		= $row["dblQty"]; 
			$intMatDetailId	= $row["intMatDetailId"];			
			$styleID 		= $row["intStyleId"];
			$BuyerPO 		= $row["strBuyerPoNo"];
			$Color 			= $row["strColor"];
			$size 			= $row["strSize"];
			$Unit 			= $row["strUnit"];
			
//BEGIN - FIND SUB CAT NO
			$intSubCatNo='';
			$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailId ";
			$x1 = $db->RunQuery($x);	
			while($row = mysql_fetch_array($x1))
			{
				$intSubCatNo=$row["intSubCatID"];
			}
//END - FIND SUB CAT NO							
								
				$STqty = $dblQty3*-1;								
								
				$SQL4 = "UPDATE storesbinallocation 
						SET
						dblFillQty = dblFillQty-$dblQty3 
						WHERE
						strMainID = '$strMainID' 	AND
						strSubID = '$strSubID' 		AND 
						strLocID = '$strLocID' 		AND 
						strBinID = '$strBinID' 		AND 
						intSubCatNo = $intSubCatNo";								
				$y = $db->RunQuery($SQL4);	
						
//if STN record available, update grn & stn record else insert minus grn record						
				if($GRNstnNo != '')
				{				
//insert minus STNT record to apperal
					$SQLSTNTStock = "insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) values ('$intDYear','$strMainID','$strSubID','$strLocID','$strBinID','$styleID','$BuyerPO','$GRNstnNo','$intGrnYear','$intMatDetailId','$Color','$size','STNT','$Unit','$STqty','$dtmDate','$intUserId','$intGrnNo','$intGrnYear','S')";								
					$SaveStockUpdateSTNT = $db->RunQuery($SQLSTNTStock);
						
//get STNF record details
					$STNFSQL = "SELECT * FROM stocktransactions where intDocumentNo='$GRNstnNo' AND intDocumentYear='$intGrnYear' AND strType='STNF' AND intStyleId='$styleID' AND strBuyerPoNo='$BuyerPO' AND intMatDetailId='$intMatDetailId' AND strColor='$Color' AND strUnit='$Unit' AND strSize='$size'";
					$STNFResult = $db->RunQuery($STNFSQL);	
					while($rowST = mysql_fetch_array($STNFResult))
					{
						$STNFmainStore = $rowST["strMainStoresID"];
						$STNFsubStore  = $rowST["strSubStores"];
						$STNFLoc       = $rowST["strLocation"];
						$STNFBin       = $rowST["strBin"];
					}
							
//BEGIN - Insert plus STNF  record to trading 							 		
					$SQLSTNFStock = "insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) values ('$intDYear','$STNFmainStore','$STNFsubStore','$STNFLoc','$STNFBin','$styleID','$BuyerPO','$GRNstnNo','$intGrnYear','$intMatDetailId','$Color','$size','STNF','$Unit','$dblQty3','$dtmDate','$intUserId','$intGrnNo','$intGrnYear','S')";								
					$SaveStockSTNF = $db->RunQuery($SQLSTNFStock);							 
//END - Insert plus  STNF  record to trading 		
							 
//BEGIN - Insert minus GRN to trading							 
					$SQLGRNStock = "insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) values ('$intDYear','$STNFmainStore','$STNFsubStore','$STNFLoc','$STNFBin','$styleID','$BuyerPO','$intGrnNo','$intGrnYear','$intMatDetailId','$Color','$size','GRN','$Unit','$STqty','$dtmDate','$intUserId','$intGrnNo','$intGrnYear','S')";								
					$SaveStockGRN = $db->RunQuery($SQLGRNStock);							 
//END - Insert minus GRN to trading			
				}
				else
				{							
//BEGIN - Insert minus GRN record to trading.			
					$SQLAppStock = "insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) values ('$intDYear','$strMainID','$strSubID','$strLocID','$strBinID','$styleID','$BuyerPO','$intGrnNo','$intGrnYear','$intMatDetailId','$Color','$size','GRN','$Unit','$STqty','$dtmDate','$intUserId','$intGrnNo','$intGrnYear','S')";								
					$SaveStockUpdateGRN = $db->RunQuery($SQLAppStock);	
//END - Insert minus GRN record to trading.						 
				}
		}
				
//BEGIN - update puchase orders 
	$gSQL = "SELECT * FROM grndetails where intGrnNo='$intGrnNo' AND intGRNYear='$intGrnYear'";
	$qSQL="";
	$gResult = $db->RunQuery($gSQL);		
	while($rowG = mysql_fetch_array($gResult))
	{
		$strStyleID2		= $rowG["intStyleId"];
		$intMatDetailID2	= $rowG["intMatDetailID"];
		$strColor2			= $rowG["strColor"];
		$strSize2			= $rowG["strSize"];
		$strBuyerPONO2		= $rowG["strBuyerPONO"];
		$dblQty2			= $rowG["dblQty"];
		$exQty 				= $rowG["dblExcessQty"];
		$dblWithoutEx    	= $dblQty2-$exQty;
						
	   	$qSQL = "UPDATE purchaseorderdetails set dblPending = dblPending + $dblWithoutEx
			   WHERE intPoNo = '$intPoNo' 
			   AND intYear='$intYear' 
			   AND intStyleId='$strStyleID2' 
			   AND intMatDetailID=$intMatDetailID2
			   AND strColor='$strColor2'
			   AND strSize='$strSize2'
			   AND strBuyerPONO='$strBuyerPONO2'";
		$qResult = $db->RunQuery($qSQL);					
	}
//END - update puchase orders.

		$SQL = "UPDATE grnheader 
			set intStatus 			= 10 			,
			intCancelledBy		= $intUserId	,
			dtmCancelledDate 	= '$dtmDate'
			WHERE
			intGRNYear='$intGrnYear'  AND
			intGrnNo= '$intGrnNo' ";				   
		$result = $db->RunQuery($SQL);
		if($result)
		{
			echo '1';
		}
		else
		{
			echo 'process fail';
		}
}

if($id=="deductQtyFromMatRatio")
{
 $buyerPONO  = 	$_GET["buyerPONO"];
 $matId 	 = 	$_GET["matId"];
 $styleId 	 = 	$_GET["styleId"];
 $size 	     = 	$_GET["size"];
 $color 	 = 	$_GET["color"];
 $exQty 	 = 	$_GET["exQty"];
 
 $intGrnNo 	= 	$_GET["grnNo"];
 $intYear	= 	$_GET["grnYear"];
 $intUserId	=	$_SESSION["UserID"];
 
 $sql1 = "select dblBalQty from materialratio where strBuyerPONO='$buyerPONO' and strMatDetailID='$matId' and intStyleId='$styleId' and strSize='$size' and                    strColor='$color'";
 $result1 = $db->RunQuery($sql1);
	while($rowMatBal = mysql_fetch_array($result1))
	{
	 $dblBalQty = $rowMatBal["dblBalQty"];
	}
	
	$bomEcxeedQty = $exQty - $dblBalQty;
	
	if($dblBalQty < $exQty){
	 
	  $sql2 = "update  materialratio set dblBalQty = dblBalQty-$dblBalQty where strBuyerPONO='$buyerPONO' and strMatDetailID='$matId' and intStyleId='$styleId' and              strSize='$size' and strColor='$color'";
	  $db->RunQuery($sql2);
	  
	  $sql3 = "update purchaseorderdetails_excess set dblQtyExceedBom = '$bomEcxeedQty' where strBuyerPONO='$buyerPONO' and intMatDetailID='$matId' and                           intStyleId='$styleId' and strSize='$size' and strColor='$color' and intGrnNo='$intGrnNo' and intGrnYear='$intYear'";
	  $db->RunQuery($sql3);
	  
	  $sql4 = "update purchaseorderheader_excess set intStatus = '1' where intGrnNo = '$intGrnNo' AND intGrnYear = '$intYear'";
	  $db->RunQuery($sql4);

	 }else{

	  $sql5 = "update  materialratio set dblBalQty = dblBalQty-$exQty where strBuyerPONO='$buyerPONO' and strMatDetailID='$matId' and intStyleId='$styleId' and              strSize='$size' and strColor='$color'";
	  $db->RunQuery($sql5);
	 }
}

if($id=="checkForSecondApproval"){

 $intGrnNo 	= 	$_GET["grnNo"];
 $intYear	= 	$_GET["grnYear"];
 
	 $sql6 = "select count(intStatus) as savedCount from purchaseorderheader_excess where intGrnNo = '$intGrnNo' AND intGrnYear = '$intYear' AND intStatus = '2'";
	 $result6 = $db->RunQuery($sql6);
    	while($row = mysql_fetch_array($result6))
	    {
	     $savedCount = $row["savedCount"];
	    }
		
		if($savedCount > 0){
		// echo "Excess Qty exceeds Material Ratio Qty. You have to get the second approval";
		 echo 1;
		}else{
		 echo 0;
		}
}

if($id=="ConfirmExGrn")
{
	$intGrnNo 	= 	$_GET["grnNo"];
	$intYear	= 	$_GET["grnYear"];
	$intUserId	=	$_SESSION["UserID"];
	$dtmDate	= 	date("Y-m-d");
	$AutomateCom =0;
	$MainStore = '';
	$grnSTNno = checkSTNnoAvinGRNheader($intGrnNo,$intYear);
	//echo $grnSTNno;
	$a = '';
	if($grnSTNno != '' || (!is_null($grnSTNno)))
	{
		$AutomateCom =1;
		//get Mainstore id
		$MainStoreID = getMainstoreID($intGrnNo,$intYear);
		//getvirtual Mainstore id
		$MainStore = GetVirtualMainstore($MainStoreID);
	}
	
	if($AutomateCom == '1')
		{
			//update automate bin details - trading apparel transaction
			$a = saveAutomateBinStock($intGrnNo,$intYear,$MainStore);
			
		}//end if trading apperal transaction 
		
		
		if($a == '')
		{
				//update stock details
				$result = updateStocktransaction($intGrnNo,$intYear);
					$a = 1;
				if($result == '1')
				{
					//send mail for price discripancy in grn detail table
					
					if($chkPriceDiscripancy)
					{
						$resPO = getPODetails($intGrnNo,$intYear);
						while($rowPO = mysql_fetch_array($resPO))
						 {
							$PONO  =  $rowPO["intPoNo"];
							$POYear = $rowPO["intYear"];
							
						 }
						sendPriceDiscrepencyMail($intGrnNo,$intYear,$PONO,$POYear);
					}
					//Send mail for trim inspection --------------------------------------------------
					senMainforTrimInspection($intGrnNo,$intYear);
				}
				
			updateExPOdetails($intGrnNo,$intYear);
		}
		$result=$a;
		
		return $result;
}
elseif($id=="RemoveFile")
{
	$url	= $_GET["url"];
	$fh = fopen($url, 'a');
	fclose($fh);	
	unlink($url);
}
function generateGRNno()
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 

	$strSQL="update syscontrol set  dblsGrnNo= dblsGrnNo+1 WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblsGrnNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$GRNNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$GRNNo  =  $row["dblsGrnNo"] ;
		break;
	 }
	return $GRNNo;
}

//start 2010-11-02 -- check whether all items in the grn has default bin in the apperal store.
function checkBinAvforTradingApperalTrans($grnNo,$grnYear,$mainStoreID)
{
	global $db; 
	
	$binCnt =0;
	
	$sql = "select  m.intSubCatID,st.strMainStoresID,st.strSubStores,st.strLocation,st.strBin
		from matitemlist m inner join stocktransactions_temp st on
		m.intItemSerial = st.intMatDetailId
		where st.intDocumentNo='$grnNo' and st.intDocumentYear='$grnYear' ";
	
	$result=$db->RunQuery($sql);
	$rowCnt = mysql_num_rows($result);
		
	while($row = mysql_fetch_array($result))
	 {
			$subCat = $row["intSubCatID"];
			//$mainStore = $row["strMainStoresID"];
			//$subStore = $row["strSubStores"];
			//$location = $row["strLocation"];
			//$bin = $row["strBin"];
			//Start - Get vertual location
			$subStore = GetVertualSubStore($row["strSubStores"]);
			$location = GetVertualLocation($row["strLocation"]);
			$bin = GetVertualBin($row["strBin"]);
			//
			$SQLbinAvInApp = " SELECT * FROM storesbinallocation WHERE strMainID='$mainStoreID' AND strSubID='$subStore' AND strLocID='$location' AND strBinID='$bin' AND intSubCatNo='$subCat' and storesbinallocation.intStatus='1' ";
		//	echo $SQLbinAvInApp;
			$AppBinAv = $db->CheckRecordAvailability($SQLbinAvInApp);	
			
			if($AppBinAv == true)
				$binCnt++;
	 }
	// echo $binCnt.' -'.$rowCnt;
	 if($binCnt == $rowCnt)
	 return true;
	 else
	 return false;	
}

function GetVertualSubStore($subStoreId)
{
global $db;
$sql="select strSubID from substores where intSourceStores='$subStoreId'";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["strSubID"];
}
function GetVertualLocation($location)
{
global $db;
$sql="select strLocID from storeslocations where intSourceStores='$location'";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["strLocID"];
}
function GetVertualBin($bin)
{
global $db;
$sql="select strBinID from storesbins where intSourceStores='$bin'";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["strBinID"];
}

function GetVirtualMainstore($mainStore)
{
	global $db;
	$sql="select strMainID from mainstores where intSourceStores='$mainStore' and intStatus=1";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strMainID"];
}
//end 2010-11-02
function getDefaultBinDetails($mainStore)
{
	global $db;
	$SQL = "SELECT strBinID,strSubID,strLocID,intStatus,intSourceStores
			FROM storesbins
			WHERE strMainID='$mainStore' and intStatus = 1";
			
			return $db->RunQuery($SQL);
}
function chkBinAllocationAv($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo)
{
	global $db;
	
	$SQLbinAllo = " Select * from storesbinallocation
where strMainID='$strMainStoresID' and strSubID='$strSubStores' and strLocID='$strLocation' and strBinID='$strBin' and intSubCatNo = '$intSubCatNo' ";

	return $db->CheckRecordAvailability($SQLbinAllo);
}

function saveStorebinAllocationDetails($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo)
{
	global $db;
	$sql = "INSERT INTO storesbinallocation(strMainID,strSubID,strLocID,strBinID,intSubCatNo,intStatus,dblCapacityQty)
								VALUES($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo,'1','10000000')";
								
	 return $db->RunQuery($sql);
								
}


function saveDatatoStockTemp($intYear,$strMainStoresID,$strSubStores,$strLocation,$strBin,$strStyleID,$strBuyerPOid,$intGrnNo,$intGRNYear,$intMatDetailId,$strColor,$strSize,$strUnit,$dblQty,$intUserId)
{
	global $db;
	$SQL = "INSERT INTO stocktransactions_temp
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
									intUser,
									intGrnNo,
									 intGrnYear,
									 strGRNType
									)
									values
									('$intYear', 
									'$strMainStoresID', 
									'$strSubStores', 
									'$strLocation', 
									'$strBin', 
									'$strStyleID', 
									'$strBuyerPOid', 
									 '$intGrnNo', 
									 '$intGRNYear', 
									 '$intMatDetailId', 
									'$strColor', 
									'$strSize', 
									'GRN', 
									'$strUnit', 
									 $dblQty, 
									now(), 
									 $intUserId,
									  '$intGrnNo', 
									 '$intGRNYear',
									 'S')";
	$result = $db->RunQuery($SQL);	
	return $result;
}

function updateBinLocation($dblQty,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo)
{
global $db;
	$SQL = "UPDATE storesbinallocation 
						SET
						dblFillQty = dblFillQty+$dblQty 
						WHERE
						strMainID = '$strMainStoresID' 	AND
						strSubID =  '$strSubStores' 		AND 
						strLocID =  '$strLocation' 		AND 
						strBinID =  '$strBin' 			AND 
						intSubCatNo = $intSubCatNo 		AND 
						intStatus=1" ;
	
	$result = $db->RunQuery($SQL);	
	return $result;
}

function dedutStockFromBin($dblQty,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo)
{
global $db;
	$SQL = "UPDATE storesbinallocation 
						SET
						dblFillQty = dblFillQty-$dblQty 
						WHERE
						strMainID = '$strMainStoresID' 	AND
						strSubID =  '$strSubStores' 		AND 
						strLocID =  '$strLocation' 		AND 
						strBinID =  '$strBin' 			AND 
						intSubCatNo = $intSubCatNo 		AND 
						intStatus=1" ;
	
	$result = $db->RunQuery($SQL);	
	return $result;
}

function getAutomateMainstoreDet($mainstore)
{
	global $db;
	$sql = " select intAutomateCompany from mainstores where intSourceStores=$mainstore ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intAutomateCompany"];
}

function saveStocktransactionData($intYear,$mainStoreID,$subStoreID,$locationID,$binID,$styleID,$BuyerPO,$DocNo,$DocYear,$MatId,$Color,$size,$type,$Unit,$Qty1,$userId,$intGrnNo)
{
	global $db;
	$SQLNegQtyRec = "insert into stocktransactions 
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
											intUser,
											intGrnNo,
											intGrnYear,
											strGRNType
											)
											values
											('$intYear', 
											'$mainStoreID', 
											'$subStoreID', 
											'$locationID', 
											'$binID', 
											'$styleID', 
											'$BuyerPO', 
											'$DocNo', 
											'$DocYear', 
											'$MatId', 
											'$Color', 
											'$size', 
											'$type', 
											'$Unit', 
											'$Qty1', 
											now(), 
											'$userId',
											'$intGrnNo',
											'$intYear',
											'S')";
				return $db->RunQuery($SQLNegQtyRec);	
}

function checkInnpectionForSubcat($intSubCat)
{
	global $db;
	$sql = " select intInspection from matsubcategory where intSubCatNo='$intSubCat' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intInspection"];
}

function getPendingStockDetails($intGrnNo,$intYear)
{
	global $db;
	$SQLCurrStock = "Select * from stocktransactions_temp 
						where intDocumentNo='$intGrnNo' and intDocumentYear='$intYear' and strType='GRN'";
		
		return  $db->RunQuery($SQLCurrStock);	
}

function getSubcatNo($MatId)
{
	global $db;
	$sql = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$MatId ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intSubCatID"];
}

function deleteStockTempData($intGrnNo,$intYear,$mainStoreID,$subStoreID,$locationID,$binID,$styleID,$BuyerPO,$MatId,$Color,$size,$type,$Unit,$Qty,$userId)
{
	global $db;
	
	$sql = "delete from stocktransactions_temp 
			where
			intGrnNo = '$intGrnNo' and intGrnYear = '$intYear' and strMainStoresID='$mainStoreID' 
			and strSubStores = '$subStoreID' and strLocation = '$locationID' and strBin = '$binID' 
			and intStyleId = '$styleID' and strBuyerPoNo = '$BuyerPO' and  intMatDetailId = '$MatId' 
			and strColor = '$Color' and strSize = '$size' and strType = '$type' ";
			
			$result = $db->RunQuery($sql);	
}

function sendPriceDiscrepencyMail($intGrnNo,$intYear,$PONO,$POYear)
{
	global $db;
	global $eml;
	$intUserId		    =$_SESSION["UserID"];
	$intCompanyId		=$_SESSION["FactoryID"]; 
	
	$SQLGRNprice = " SELECT * FROM grndetails
					WHERE intGrnNo='$intGrnNo' AND intGRNYear='$intYear' AND dblPoPrice<>dblInvoicePrice";
					
					$resGRNPrice =  $db->CheckRecordAvailability($SQLGRNprice);
					
				if($resGRNPrice>0)
				{
				
													
					$SenderDet = "SELECT UserName,Name as SenderName FROM useraccounts
									WHERE intUserID='$intUserId' AND intCompanyID='$intCompanyId'";
									
					$resultSender = $db->RunQuery($SenderDet);
					$senderName = '';
					while($RowSend = mysql_fetch_array($resultSender))
					{
						$senderEmail = $RowSend["UserName"];
						$senderName  = $RowSend["SenderName"];
					}		
					
			//*******************************************************				
			
			
							
				$reciever= '';
					$serverIp 		= $_SERVER["SERVER_ADDR"];
					$body 		= "<br><br>".	
								 "User Comments : Grn No : $intYear/$intGrnNo<br><br><a href=http://".$serverIp."/gapro/confirmInvoicePrice/additionalPOprice.php?intGRNno=$intGrnNo&intGRNYear=$intYear&intPONo=$PONO&intYear=$POYear>To view and approve price details click here</a>";			
					
					$fieldName = 'intApprovePriceDiffId';
					
					$subject = "PO Price Discrimination for  Approval";				
					$eml->SendMail($fieldName,$body,$intUserId,$reciever,$subject);
				
			}	
}

function senMainforTrimInspection($intGrnNo,$intYear)
{
	global $db;
	global $eml;
	$intUserId		    =$_SESSION["UserID"];
	$intCompanyId		=$_SESSION["FactoryID"]; 
	
	$SQLTrim = " select g.intMatDetailID,strColor,intGrnNo
						from grndetails g inner join matitemlist m on 
						g.intMatDetailID = m.intItemSerial 
						inner join matsubcategory ms on
						ms.intSubCatNo = m.intSubCatID 
						where g.intGrnNo='$intGrnNo' and g.intGRNYear='$intYear' and 
						ms.intInspection=1";
						
					$resultTrim = $db->CheckRecordAvailability($SQLTrim);	
					
					if($resultTrim>0)
					{
						$SQLTrimUser = " SELECT UserName,Name as UserAccountName
										FROM useraccounts
										WHERE trimInspection=1 AND intCompanyID='$intCompanyId'";
										
								$resultTrmUser = $db->RunQuery($SQLTrimUser);	
								
								while($rowT = mysql_fetch_array($resultTrmUser))
								{
									$TrimUserEmail = $rowT["UserName"];
									$TrimUserName  = $rowT["UserAccountName"];
								}	
								
				
				//email details ----------------------------------------
				
				$serverIp 		= $_SERVER["SERVER_ADDR"];
					$body 		= "<br><br>".	
								 "User Comments : Grn No : $intYear/$intGrnNo<br><br><a href=http://".$serverIp."/gapro/TrimInspection/TrimInspactionGrnWise.php?intGRNno=$intGrnNo&intGRNYear=$intYear>To view trim inspection item details click here</a>";			
					
					$fieldName = 'intTriminspectedId';
					
					$subject = "Trim Inspection";				
					$eml->SendMail($fieldName,$body,$intUserId,$TrimUserName,$subject);
					
				//end -----------------------------
								
					}
}

function saveAutomateBinStock($intGrnNo,$intYear,$MainStore)
{
	global $db;
	
	$intUserId		    =$_SESSION["UserID"];
	$intCompanyId		=$_SESSION["FactoryID"]; 
	$a = '';		
			//check bin availability of apperal store
			$binAvInApperal = checkBinAvforTradingApperalTrans($intGrnNo,$intYear,$MainStore);
			
			if($binAvInApperal == true)
			{
				//check STN no availability in the GRN
				$CurrSTNno = checkSTNnoAvinGRNheader($intGrnNo,$intYear);
				
				if($CurrSTNno == '' || is_null($CurrSTNno))
				{
					//generate new STN no 
					$NewSTNno = generateSTNno($intCompanyId);
					$resSTN = updateSTNnoInGRN($NewSTNno,$intGrnNo,$intYear);
				}
				else
				{
					$NewSTNno = $CurrSTNno;
				}
					
			
			
			//get stock details 
			$SQLCurrStock = "Select * from stocktransactions_temp 
						where intDocumentNo='$intGrnNo' and intDocumentYear='$intYear' and strType='GRN'";
			
			//$ResultCrrStock = $db->RunQuery($SQLCurrStock);
			$ResultCrrStock = getPendingStockDetails($intGrnNo,$intYear);
				while($row1 = mysql_fetch_array($ResultCrrStock))
				{
					$mainStoreID = $row1["strMainStoresID"];
					$subStoreID = $row1["strSubStores"];
					$locationID = $row1["strLocation"];
					$binID = $row1["strBin"];
					$styleID = $row1["intStyleId"];
					$BuyerPO = $row1["strBuyerPoNo"];
					$DocNo = $row1["intDocumentNo"];
					$DocYear = $row1["intDocumentYear"];
					$MatId = $row1["intMatDetailId"];
					$Color = $row1["strColor"];
					$size = $row1["strSize"];
					$Unit = $row1["strUnit"];
					$Qty = $row1["dblQty"];
					$Qty1 = $Qty*-1;
					//$QtyVal = intval('$Qty1');
					$dtmDate = $row1["dtmDate"];
					$userId = $row1["intUser"];
					
					$intSubCatNo='';
					
					$intSubCatNo = getSubcatNo($MatId);
					//check trim inspection need for the subcategory				
					$chkInspect = checkInnpectionForSubcat($intSubCatNo); 	
						//deduct stock from stocktransaction when stock transfer from trading to apperal
						
					if($chkInspect != 1)
					{
						$SaveNegRec = saveStocktransactionData($intYear,$mainStoreID,$subStoreID,$locationID,$binID,$styleID,$BuyerPO,$NewSTNno,$DocYear,$MatId,$Color,$size,'STNF',$Unit,$Qty1,$userId,$intGrnNo);
					
							if($SaveNegRec >0)
							{
												
							//deduct stock from storesbinallocation	
									
					$bin  = dedutStockFromBin($Qty,$mainStoreID,$subStoreID,$locationID,$binID,$intSubCatNo);
					//allocate stock to apperal
					
					//Start - 03-12-2010
					$vertualSubStore = GetVertualSubStore($subStoreID);
					$vertualLocation = GetVertualLocation($locationID);
					$vertualBin 	 = GetVertualBin($binID);
					//End - 03-12-2010
									
							$SaveStockUpdate = saveStocktransactionData($intYear,$MainStore,$vertualSubStore,$vertualLocation,$vertualBin,$styleID,$BuyerPO,$NewSTNno,$DocYear,$MatId,$Color,$size,'STNT',$Unit,$Qty,$userId,$intGrnNo);	
						//update storesbinallocation 
								
						$y = updateBinLocation($Qty,$MainStore,$vertualSubStore,$vertualLocation,$vertualBin,$intSubCatNo);
							}
					}		
					
							
				} //end while
				
				/*$SQLGRN =  "UPDATE grnheader 
				set	intSTNno 			= '$NewSTNno'
				   WHERE 
				       intGRNYear=$intYear 
				    AND intGrnNo= $intGrnNo ";
				   
			$resultgrn = $db->RunQuery($SQLGRN);	*/
			
			//Update SysControl
			/*$SqlSTNupdate = "UPDATE syscontrol SET dblSTNno='$NewSTNno' WHERE intCompanyID='$intCompanyId'";
			$STNupdate = $db->RunQuery($SqlSTNupdate);	*/
			
			}//end if bin availability
			else
			{
				$a="There is no bin to allocate stock";
			}
						
	return $a;	
}

function updateStocktransaction($intGrnNo,$intYear)
{
	global $db;
	$intUserId		    = $_SESSION["UserID"];
	$intCompanyId		= $_SESSION["FactoryID"]; 
	
	$SQLstock = getPendingStockDetails($intGrnNo,$intYear);
	while($rowS = mysql_fetch_array($SQLstock))
	{
		$mainStoreID 	= $rowS["strMainStoresID"];
		$subStoreID 	= $rowS["strSubStores"];
		$locationID 	= $rowS["strLocation"];
		$binID 			= $rowS["strBin"];
		$styleID 		= $rowS["intStyleId"];
		$BuyerPO 		= $rowS["strBuyerPoNo"];
		$MatId 			= $rowS["intMatDetailId"];
		$Color 			= $rowS["strColor"];
		$size 			= $rowS["strSize"];
		$Unit 			= $rowS["strUnit"];
		$Qty			= $rowS["dblQty"];	
		$dtmDate 		= $rowS["dtmDate"];
		$userId 		= $rowS["intUser"];
					
		$intSubCatNo 	= getSubcatNo($MatId);
		//check trim inspection need for the subcategory				
		$chkInspect 	= checkInnpectionForSubcat($intSubCatNo); 
					
			if($chkInspect != 1)
			{
				//insert data to stocktransaction 
				$SaveStockUpdate1 = saveStocktransactionData($intYear,$mainStoreID,$subStoreID,$locationID,$binID,$styleID,$BuyerPO,$intGrnNo,$intYear,$MatId,$Color,$size,'GRN',$Unit,$Qty,$userId,$intGrnNo);
				
				if($SaveStockUpdate1 == 1)
				{
					//delete data from stock temp
					deleteStockTempData($intGrnNo,$intYear,$mainStoreID,$subStoreID,$locationID,$binID,$styleID,$BuyerPO,$MatId,$Color,$size,'GRN',$Unit,$Qty,$userId);
					
				}
			}	
		}
		$sql_po="select PH.strCurrency from purchaseorderheader PH inner join grnheader GH on GH.intPoNo=PH.intPONo and GH.intYear=PH.intYear where GH.intGrnNo='$intGrnNo' and GH.intGRNYear='$intYear'";
		$result_po=$db->RunQuery($sql_po);
		$row_po=mysql_fetch_array($result_po);
		$curId	= $row_po["strCurrency"];
		
		$exRate = GetExchangeRate($curId);
		$SQL = "UPDATE grnheader 
		set intStatus		= 1,
		intConfirmedBy 		= $intUserId,
		dtmConfirmedDate 	= '$dtmDate',
		intGRNApproved 		= 1,
		dblExRate			= $exRate
		WHERE 
		intGRNYear			= $intYear 
		AND intGrnNo		= $intGrnNo";
		$result = $db->RunQuery($SQL);		
		return $result;
}

function CheckIsExQtyAvalable($grnNo,$grnYear)
{
//bookmark

	$grnExPer = getUserwiseExQty();
	global $db;
	$booEx	= 0;

	//ROUND((((PD.dblQty  /100) *  5 )-GD.dblExcessQty),4)as exQty1
	$sql=	"	SELECT
				ROUND((((purchaseorderdetails.dblQty  /100) *  $grnExPer )+purchaseorderdetails.dblPending )*(-1),4)as exQty
				FROM
				grnheader
				Left Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo 
				AND grndetails.intGRNYear = grnheader.intGRNYear
				Left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = grnheader.intPoNo 
				AND purchaseorderdetails.intYear = grnheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId 
				AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID 
				AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO 
				AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize
				where grndetails.intGrnNo='$grnNo' and grndetails.intGRNYear='$grnYear'";
	//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$val = $row["exQty"];
		
		if($val>0)
			$booEx	= true;
	}
return $booEx;
}

function getUserwiseExQty()
{
	 global $db;
	  $intUserId	= $_SESSION["UserID"];
	 $SQL = "select intExPercentage from useraccounts where intUserID= '$intUserId' ";
	 $result = $db->RunQuery($SQL);
	 $row = mysql_fetch_array($result);
	// echo $row["intExPercentage"];
	 return $row["intExPercentage"];
}
function checkExcessPOApprove($grnno,$grnyear)
{
	global $db;
	$sql = " select intStatus from purchaseorderheader_excess where intGrnNo='$grnno' 
	and intGRNYear='$grnyear' and intStatus=1";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
		return true;
	else
		return false;	


	
}

function GenaratePoHeader($grnNo,$grnYear)
{
	global $db;

	
	$sql="insert into purchaseorderheader_excess 
		(intGrnNo, 
		intGrnYear, 
		intPONo, 
		intYear, 
		dtmDate, 
		intUserID, 
		strSupplierID, 
		strRemarks, 
		dtmDeliveryDate, 
		strCurrency, 
		intStatus,
		intInvCompID, 
		intPrintStatus, 
		intDelToCompID, 
		intPreviousUserId, 
		dblPOValue, 
		dblPOBalance, 
		intPOCompleteq, 
		dblExchangeRate, 
		strPayTerm, 
		strPayMode, 
		strInstructions, 
		strPINO, 
		intCanceledPONo, 
		intCanceledPOYear, 
		strShipmentMode, 
		strShipmentTerm, 
		dtmETA, 
		dtmETD, 
		intRevisionNo, 
		dtmRevisionDate, 
		intRevisedBy, 
		strAttention, 
		intCheckedBy, 
		dtmCheckedDate, 
		intCompanyID
		)
		select
		intGrnNo,
		intGRNYear,
		GH.intPoNo,
		GH.intYear,
		dtmDate, 
		PH.intUserID, 
		strSupplierID, 
		strRemarks, 
		dtmDeliveryDate, 
		strCurrency, 
		'0',
		intInvCompID, 
		PH.intPrintStatus, 
		intDelToCompID, 
		intPreviousUserId,
		(SELECT
sum(purchaseorderdetails_excess.dblUnitPrice *purchaseorderdetails_excess.dblQty) as povalue
FROM purchaseorderdetails_excess
WHERE
purchaseorderdetails_excess.intGrnNo =  GH.intGrnNo AND
purchaseorderdetails_excess.intGrnYear =  GH.intGRNYear ) as povalue1, 
		(SELECT
sum(purchaseorderdetails_excess.dblUnitPrice *purchaseorderdetails_excess.dblQty) as povalue
FROM purchaseorderdetails_excess
WHERE
purchaseorderdetails_excess.intGrnNo 	=  	'$grnNo' 	AND
purchaseorderdetails_excess.intGrnYear 	=  	'$grnYear' ) as povalue2, 
		intPOCompleteq, 
		dblExchangeRate, 
		strPayTerm, 
		strPayMode, 
		strInstructions, 
		strPINO, 
		intCanceledPONo, 
		intCanceledPOYear, 
		strShipmentMode, 
		strShipmentTerm, 
		dtmETA, 
		dtmETD, 
		intRevisionNo, 
		dtmRevisionDate, 
		intRevisedBy, 
		strAttention, 
		intCheckedBy, 
		dtmCheckedDate, 
		PH.intCompanyID 
		from grnheader GH 
		inner join purchaseorderheader PH on PH.intPONo=GH.intPoNo and PH.intYear=GH.intYear 
		where GH.intGrnNo='$grnNo' and GH.intGRNYear='$grnYear'";
		//echo $sql;
	$result=$db->RunQuery($sql);
	return $result;
}

function GenaratePoDetails($grnNo,$grnYear)
{
	//bookmark
	
	$grnExPer= getUserwiseExQty();

	global $db;
	$sql="insert into purchaseorderdetails_excess 
		(intGrnNo, 
		intGrnYear, 
		intPoNo, 
		intYear, 
		intStyleId, 
		intMatDetailID, 
		strColor, 
		strSize, 
		strBuyerPONO, 
		strRemarks, 
		strUnit, 
		dblUnitPrice, 
		dblQty, 
		dblPending, 
		dblAdditionalQty, 
		intDeliverToCompId, 
		dtmItemDeliveryDate, 
		intPOType)
		select
		GH.intGrnNo,
		GH.intGRNYear,
		GH.intPoNo,
		GH.intYear,
		PD.intStyleId,
		PD.intMatDetailID,
		PD.strColor,
		PD.strSize,
		PD.strBuyerPONO,
		PD.strRemarks,
		PD.strUnit,
		PD.dblUnitPrice,
		
		IF((ROUND((((PD.dblQty /100) * $grnExPer )+PD.dblPending )*(-1),2)-GD.dblQty)<0,ROUND((((PD.dblQty /100) * $grnExPer )+PD.dblPending )*(-1),2),ROUND(GD.dblQty,2)) AS EX1,
		IF((ROUND((((PD.dblQty /100) * $grnExPer )+PD.dblPending )*(-1),2)-GD.dblQty)<0,ROUND((((PD.dblQty /100) * $grnExPer )+PD.dblPending )*(-1),2),ROUND(GD.dblQty,2)) AS EX2,
		
		GD.dblAditionalQty,
		PD.intDeliverToCompId,
		PD.dtmItemDeliveryDate,
		PD.intPOType 
		from grnheader GH 
		inner join purchaseorderheader PH on PH.intPONo=GH.intPoNo and PH.intYear=GH.intYear
		inner join grndetails GD on GD.intGrnNo=GH.intGrnNo and GD.intGRNYear=GH.intGRNYear
		inner join purchaseorderdetails PD on PD.intStyleId=GD.intStyleId and PD.strBuyerPONO=GD.strBuyerPONO and PD.intMatDetailID=GD.intMatDetailID and PD.strColor=GD.strColor and PD.strSize=GD.strSize
		and PH.intPONo = PD.intPoNo and PH.intYear = PD.intYear
		where GH.intGrnNo='$grnNo' and GH.intGRNYear='$grnYear' and GD.dblExcessQty >'0'
		and ROUND((((PD.dblQty /100) * $grnExPer )+PD.dblPending )*(-1),2)>0";
		
		//and (GD.dblExcessQty-((GD.dblQty-GD.dblExcessQty) /100 *  $grnExPer ))>0";
		
		//ROUND((((PD.dblQty /100) * $grnExPer )+PD.dblPending )*(-1),4)
		//(GD.dblExcessQty-(((GD.dblQty-GD.dblExcessQty) * $grnExPer)/100 ) )as additionalPoQty
		$result=$db->RunQuery($sql);
		//echo $sql;
	//die();
	$response = getRecordCountInPOdetailExcess($grnNo,$grnYear);
	
	if($response)
	{
		if(GenaratePoHeader($grnNo,$grnYear))
			return true;
		else
			return false;
	}
	return false;
}

function GenarateAutoPo($grnNo,$grnYear)
{
	global $db;
	
	return GenaratePoDetails($grnNo,$grnYear);
}
function GenarateAutoExPo($grnNo,$grnYear)
{
global $db;
	//$booCheck = CheckUserPermission();
	//if(!$booCheck)
	//{
		$val = GenarateAutoPo($grnNo,$grnYear);
		return $val;
	//}
return true;
}
function sendMailforAdditionalPO($intGrnNo,$intYear)
{
	global $db;
	global $eml;
	$intUserId		    =$_SESSION["UserID"];
	$intCompanyId		=$_SESSION["FactoryID"]; 	
	$serverIp 	= $_SERVER["SERVER_NAME"];
			
		/*$body 		= "User Comments : Grn No : $intYear/$intGrnNo<br><br><a href=http://".$serverIp."/eplan/GRN/Details/expoconfirmation/expoconfirmationreport.php?serialNo=$intGrnNo&serialYear=$intYear>To Confirm a Ex Grn No :$intYear/$intGrnNo click this link</a>";
		$sender		= GetSenderName($intUserId);
		//$reciever	= GetReceiverName($intGrnNo,$intYear);
		$subject	= "Need Approve for Confirm Ex Grn";
		$eml->sendMailThroughNet($body,$sender,$reciever,$subject);
		$res = "Sorry !\nYou don't have Permission to comfirm Grn with Excess Qty.\nSystem will genarate Po with Excess Qty and send mail to user :$reciever for Approval.";*/
		
		$fieldName = 'intAdditionalPO';
		$body 		= "User Comments : Grn No : $intYear/$intGrnNo<br><br><a href=http://".$serverIp."/gapro/GRN/expoconfirmation/expoconfirmationreport.php?serialNo=$intGrnNo&serialYear=$intYear>To Confirm a Ex Grn No :$intYear/$intGrnNo click this link</a>";			
					$subject = "Need Approve for Confirm Ex Grn";	
					$reciever = '';			
					$eml->SendMail($fieldName,$body,$intUserId,$reciever,$subject);
					
		$res = " Sorry !\nYou  have no Permission to confirm the GRN with Excess Qty.\nSystem will genarate Po with Excess Qty and send mail  for Approval.";
		return $res;
}

function getRecordCountInPOdetailExcess($intGrnNo,$intYear)
{
	global $db;
	$sql = "select count(*) as recCount from purchaseorderdetails_excess
where intGrnNo='$intGrnNo' and intGrnYear='$intYear' ";
	$result=$db->RunQuery($sql);
	
	if(mysql_num_rows($result)>0)
		return true;
	else
		return false;
} 

function checkSTNnoAvinGRNheader($intGrnNo,$intYear)
{
	global $db;
	
	$sql = " select intSTNno from grnheader where intGrnNo='$intGrnNo' and intGRNYear='$intYear' ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["intSTNno"];
}

function generateSTNno($intCompanyId)
{
	global $db;
	
	//get Current STN No from Syscontrol
		$SQLgetSTN = "SELECT dblSTNno FROM syscontrol WHERE intCompanyID='$intCompanyId'";
		
		$ResultSTN = $db->RunQuery($SQLgetSTN);
		$row = mysql_fetch_array($ResultSTN);
		$CurrSTNno = $row["dblSTNno"];
		
		$NewSTNno = $CurrSTNno+1;
		updateSTNnoDetails($NewSTNno,$intCompanyId);
		
		return $NewSTNno;
}

function updateSTNnoDetails($STNno,$intCompanyId)
{
	global $db;
	
	$SqlSTNupdate = " UPDATE syscontrol SET dblSTNno='$STNno' WHERE intCompanyID='$intCompanyId'";
	$STNupdate = $db->RunQuery($SqlSTNupdate);	
}

function updateSTNnoInGRN($NewSTNno,$intGrnNo,$intYear)
{
	global $db;
	$SQLGRN =  "UPDATE grnheader 
				set	intSTNno 			= '$NewSTNno'
				   WHERE 
				       intGRNYear=$intYear 
				    AND intGrnNo= $intGrnNo ";
				   
		return $db->RunQuery($SQLGRN);	
}

function getMainstoreID($intGrnNo,$intYear)
{
	global $db;
	
	$sql = "select distinct strMainStoresID from stocktransactions_temp where intGrnNo='$intGrnNo' and intGrnYear= '$intYear'";
	
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strMainStoresID"];
}

function getPODetails($intGrnNo,$intYear)
{
	global $db;
	
	$sql = "select intPoNo,intYear from grnheader where intGrnNo = '$intGrnNo' and intGRNYear='$intYear' ";
	
	$result=$db->RunQuery($sql);
	
	return $result;
}

function updateExPOdetails($intGrnNo,$intYear)
{
	global $db;
	$intUserId		    =$_SESSION["UserID"];
	$dtmDate   = date('Y-m-d');
	
	$SQL = "UPDATE purchaseorderheader_excess 
	set intStatus = 1,
	intConfirmedBy = $intUserId,
	dtmConfirmedDate = '$dtmDate'		
	WHERE 
	intGrnYear=$intYear 
	AND intGrnNo= $intGrnNo ";
	$result = $db->RunQuery($SQL);
}
function chkGRNcontainOrdercompleteStyle($intGrnNo,$intGrnYear)
{
	global $db;
	$sql = "select distinct intStyleId from grndetails where intGrnNo='$intGrnNo' and intGRNYear='$intGrnYear'";
	
	$result = $db->RunQuery($sql);
	$loop =0;
	$styleId_array 	= array();
	
	while($row = mysql_fetch_array($result))
	{
		$styleId_array[$loop] = "'" . $row["intStyleId"] . "'";
		$loop++;
	}
	
	$styleID = implode(",",$styleId_array);
	
	$sqlStatus = " select * from orders where intStatus=13 and intStyleId in ($styleID) ";
	$res = $db->RunQuery($sqlStatus);
	
	$numRows = mysql_num_rows($res);
	
	return $numRows;
}
function GetExchangeRate($curId)
{
global $db;
	$sql="select rate from exchangerate where currencyID=$curId and intStatus=1";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["rate"];
}

function GetMainStoreIdFromStockTemp($intGrnNo,$intGrnYear)
{
global $db;
	$sql="select strMainStoresID from stocktransactions_temp where intDocumentNo='$intGrnNo' and intDocumentYear='$intGrnYear' and strType='GRN'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strMainStoresID"];
	}
}

function GetNotTrimStockQty($intStyleId,$strBuyerPONO,$intMatDetailID,$strColor,$strSize,$intGrnNo,$intGrnYear)
{
global $db;
$qty = 0;
	$sql="SELECT COALESCE(SUM(dblQty),0) AS StockQty FROM stocktransactions_temp WHERE intStyleId='$intStyleId' AND strBuyerPONO = '$strBuyerPONO' AND intMatDetailId = '$intMatDetailID' AND strColor='$strColor' AND strSize='$strSize' and intGrnNo= '$intGrnNo' and intGrnYear='$intGrnYear'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["StockQty"];
	}
	return $qty;
}
?>