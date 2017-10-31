<?php
session_start();


include "../../Connector.php";
include "../../EmailSender.php";
include "emailcode.php";
$Emaildb = new EmailSender();
$id=$_GET["id"];
$companyId	= $_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];
if($id=="saveGrnHeader")
{
		global $db;

		  $bulkGrnNo			= $_GET["bulkGrnNo"];
		  $intGRNYear		= date("Y");
		  $intPoNo			= trim($_GET["bulkPoNo"]);
		  $intYear			= trim($_GET["bulkPoYear"]);
		  $dtmRecievedDate	= $_GET["recievedDate"];
		  $strInvoiceNo		= trim($_GET["invoiceNo"]);
		  $strSupAdviceNo	= trim($_GET["supAdviceNo"]);
		  $dtmAdviceDate	= $_GET["adviceDate"];		 
		  if($bulkGrnNo!=""){
			$no				= $_GET["bulkGrnNo"];
			$noArray		= explode('/',$no);
			$bulkGrnNo		= $noArray[1];
		 	$intGRNYear		= $noArray[0];
		  }
		  	
		  if($bulkGrnNo=="")
		  {
		  
		  		$bulkGrnNo		= generateBulkGRNno();
		 		$intGRNYear		= date("Y");
		  	
		    /*$SQL="SELECT strValue FROM settings WHERE strKey='GRNID$companyId'";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$bulkGrnNo =  $row["strValue"];
				break;
			}
			
			$strRange = "";
			$SQL="SELECT strValue FROM settings WHERE strKey='$companyId'";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$strRange =  $row["strValue"];
				break;
			}
			
			$A = split("-",$strRange);
			if((int)$A[1]<$bulkGrnNo+1)
			{
				echo "error->GRN no is exceeded. GRN Not Saved";
				return;
			}
			if($bulkGrnNo=="")
			{
						$bulkGrnNo = $A[0];
						$SQL="INSERT INTO settings(strKey,strValue)values('GRNID".$companyId."','".($A[0]+1)."')";
						$result = $db->RunQuery($SQL);
			}
			else
			{
						$SQL = "UPDATE settings set strValue=strValue+1 where strKey='GRNID$companyId'";
						$result = $db->RunQuery($SQL);
			}*/
		 }
		
	$delSQL = "DELETE FROM bulkgrnheader WHERE intBulkGrnNo = $bulkGrnNo AND intYear = $intGRNYear";
	$delResult = $db->RunQuery($delSQL);
	
	$SQL="insert into bulkgrnheader".
	"(intBulkGrnNo,".
	"intYear, ".
	"intBulkPoNo, ".
	"intBulkPoYear, ".
	"dtRecdDate, ".
	"strInvoiceNo, ".
	"strSupAdviceNo, ".
	"intStatus, ".
	"intPrintStatus, ".
	"intUserId, ".
	"dtAdviceDate, ".
	"intCompanyId,".
	"dblRate".
	")".
	"values".
   "($bulkGrnNo, ".
	"$intGRNYear, ".
	"$intPoNo, ".
	"$intYear, ".
	"now(), ".
	"'$strInvoiceNo', ".
	"'$strSupAdviceNo', ".
	"0, ".
	"0, ".
	"$userId, ".
	"'$dtmAdviceDate', ".
	"$companyId,".
	"0".
	")";	
$intSave = $db->RunQuery($SQL);
		
		if (!$intSave)
		{
			echo 'error->GRN Header not saved. Pls save it again.';
			return;
		}
	$pSQL = "SELECT * FROM bulkgrndetails where intBulkGrnNo=$bulkGrnNo AND intYear=$intGRNYear";
		$qSQL="";
		$pResult = $db->RunQuery($pSQL);	
		while($row = mysql_fetch_array($pResult))
		{
				   $intMatDetailID2	 =$row["intMatDetailID"];
				   $strColor2		 =$row["strColor"];
				   $strSize2		 =$row["strSize"];
				   $dblQty2			 =$row["dblQty"];
	
			   $qSQL = "UPDATE bulkpurchaseorderdetails set dblPending = dblPending + $dblQty2 
					   WHERE intBulkPoNo = $intPoNo 
					   AND intYear=$intYear 
					   AND intMatDetailID='$intMatDetailID2'
					   AND strColor='$strColor2'
					   AND strSize='$strSize2'";
				$qResult = $db->RunQuery($qSQL);
			if(!$qResult)
			{
				echo "error->Can't revice purchase order details.pls save it again";
				return;
			}			
		}
		$delSQL = "DELETE FROM bulkgrndetails WHERE intBulkGrnNo=$bulkGrnNo AND intYear=$intGRNYear";
		$delResult = $db->RunQuery($delSQL);
				

			$pSQL="";

		$pSQL = "SELECT * FROM stocktransactions_bulk_temp where intDocumentNo=$bulkGrnNo AND intDocumentYear=$intGRNYear AND strType='GRN'";
		$pResult = $db->RunQuery($pSQL);	
		while($row = mysql_fetch_array($pResult))
		{
			
			$strMainID = $row["strMainStoresID"]; 	
			$strSubID = $row["strSubStores"];  		 
			$strLocID = $row["strLocation"];  		 
			$strBinID = $row["strBin"];  			 		 
			$dblQty3 = $row["dblQty"]; 
			$intMatId  = $row["intMatDetailId"];

		$intSubCatNo='';
		$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatId ";
			$x1 = $db->RunQuery($x);	
			while($row1 = mysql_fetch_array($x1))
			{
				$intSubCatNo=$row1["intSubCatID"];
			}
		
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
//
		$delSQL = "DELETE FROM stocktransactions_bulk_temp WHERE intDocumentNo=$bulkGrnNo AND intDocumentYear=$intGRNYear AND strType='GRN'";
		$delResult = $db->RunQuery($delSQL);
				
		$_SESSION["sessionDB"]= serialize($db);
		echo "saved->$intGRNYear"."/"."$bulkGrnNo";
		$db->CloseConnection();
}

if($id=="commit")
{
	global $db;
	$db = unserialize($_SESSION["sessionDB"]);
	die($db);
	$db->commit();
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
			$db 				= unserialize($_SESSION["sessionDB"]);
			$count	   			= $_GET["count"];
			$intGrnNo   		= $_GET["intGrnNo"];
			$intGRNYear   		= $_GET["intGrnYear"];
			$intYear			= date("Y");
			$intMatDetailID		= $_GET["matDetailId"];
			$strColor			= $_GET["color"];
			$strSize			= $_GET["size"];
			$dblQty 			= $_GET["dblQty"];
			$dblCapacityQty		= $_GET["dblCapacityQty"];
			$dblExcessQty		= $_GET["dblExcessQty"];
			$dblRate			= $_GET["dblRate"];
			$strUnit			= $_GET["unit"];
			$poNo				= $_GET["bulkPoNo"];	
			$active			    = $_GET["pub_ActiveCommonBins"];
			$mainStore			= $_GET["mainStore"];	
			$intUserId		=$_SESSION["UserID"];
				$poNoArray = explode("/",$poNo);				
			$dblBalance			= $dblQty;			
	
				$intSubCatNo='';
				$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailID ";
					$x1 = $db->RunQuery($x);	
					while($row = mysql_fetch_array($x1))
					{
						$intSubCatNo=$row["intSubCatID"];
					}
	$SQLdetails = "insert into bulkgrndetails 
				(intBulkGrnNo, 
				intYear, 
				intMatDetailID, 
				strColor, 
				strSize,
				strUnit,
				dblRate,
				dblQty, 
				dblExQty,
				dblBalance)
				values
			    ($intGrnNo, 
				$intGRNYear, 
				'$intMatDetailID', 
				'$strColor',				
				'$strSize',
				'$strUnit',
				'$dblRate',
				$dblQty, 
				$dblExcessQty, 
				$dblBalance);";
		$intSave = $db->RunQuery($SQLdetails);
		
		if(!$intSave)
		{
			echo "error->GRN details insert error. row no $count";
			return;
		}
		
		$SQL2 =    "UPDATE bulkpurchaseorderdetails set dblPending = dblPending - $dblQty 
				   WHERE intBulkPoNo = $poNoArray[1] 
				   AND intYear=$poNoArray[0] 
				   AND intMatDetailId=$intMatDetailID
				   AND strColor='$strColor'
				   AND strSize='$strSize'";
			$result = $db->RunQuery($SQL2);	
			if(!$result)
			{
				echo 'error->purchaseorder details update error. row no $count';
				return;
			}		
			//////////////////				FOR STOCK TRANS ACTION  ///////////////////////////////////
				/*$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
				$result = $db->RunQuery($SQL);
				$active =10;
				while($row = mysql_fetch_array($result))
				{
					$active = $row["strValue"];
					break;
				}*/
					
		if($active==1)
		{		
						
						
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
				$save_temp = saveDatatoStockTemp($intYear,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intGrnNo,$intGRNYear,$intMatDetailID,$strColor,$strSize,$strUnit,$dblQty,$intUserId);
				
				//update bin details
				$save_bin = updateBinLocation($dblQty,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo);
				
				if(!$save_temp || !save_bin)
				{
					echo 'error->save stock details. ';
								return;
				}	
		}
		echo 'saved->saved';
} 


if($id=="saveBin")
{
				global $db;
				$db = unserialize($_SESSION["sessionDB"]);
				$count	   			= $_GET["count"];

				$intGrnNo			=$_GET["intGrnNo"];
				$intGrnYear			=$_GET["intGrnYear"];
				$strMainStoresID	=$_GET["strMainStoresID"];
				$strSubStores		=$_GET["strSubStores"];
				$strLocation		=$_GET["strLocation"];
				$strBin				=$_GET["strBin"];
				$intMatDetailId		=$_GET["intMatDetailId"];
				$strColor			=$_GET["strColor"];
				$strSize			=$_GET["strSize"];
				$strUnit			=$_GET["strUnit"];
				$dblQty				=$_GET["dblQty"];
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
			$SQL = "INSERT INTO stocktransactions_bulk_temp 
						(intYear, 
						strMainStoresID, 
						strSubStores, 
						strLocation, 
						strBin, 
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
						intBulkGrnNo,
						intBulkGrnYear
						)
						values
						($intYear, 
						'$strMainStoresID', 
						'$strSubStores', 
						'$strLocation', 
						'$strBin', 
						 $intGrnNo, 
						 $intGrnYear, 
						 $intMatDetailId, 
						'$strColor', 
						'$strSize', 
						'GRN', 
						'$strUnit', 
						 $dblQty, 
						now(), 
						 $userId,
						 $intGrnNo, 
						 $intGrnYear 
						 )";
			$result = $db->RunQuery($SQL);

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
	$dtmDate	= 	date("Y-m-d");
	$AutomateCom = 	$_GET["AutomateCom"];
	$MainStore	=	$_GET["MainStore"];
	$SubStore	=	$_GET["SubStore"];
	 $PONO      =   $_GET["PONo"];
	 $POYear    =   $_GET["poYear"];
	
//-------------------------------------------------------------------------
		//Automated Process for Orit Trading to Orit Apperal Tranfer 
		//Subtract quantities from stock transaction from trading and add details to apperal. 
//-------------------------------------------------------------------------
	$a="";	
		if($AutomateCom == '1')
		{
			$a = saveAutomateBinStock($intGrnNo,$intYear,$MainStore);
		}
	
		if($a == '')
		{
				//update stock details
				$result = updateStocktransaction($intGrnNo,$intYear);
				
				
		}
		else
		{
			$result=$a;
		}
		
		echo $result;
	
	echo $a;	
}

if($id=="cancel")
{ 

	$no 			= 	$_GET["intGrnNo"];
	$noArray        = explode('/',$no);
	
	$intGrnYear 	= 	$_GET["intGrnYear"];
	$intYear		= 	$_GET["intYear"];
	$dtmDate		= 	date("Y-m-d");
	$intPoNo 		= 	$_GET["intPoNo"];

	$autoTransferNo = GetAutoTransferNo($noArray[0],$noArray[1]);
	
	/*if($autoTransferNo=="")
		$sql="select strMainID from mainstores where intCompanyId=$companyId and intStatus=1 ";
	else 
		$sql="select strMainID from mainstores where intCompanyId=$companyId and intStatus=1 and intAutomateCompany=1";
		
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	$mainStore = $row["strMainID"];
	
	$sql_grn = "select sum(dblQty)as grnQty,intMatDetailID,strColor,strSize from bulkgrndetails where intBulkGrnNo='$noArray[1]' and intYear='$noArray[0]' group by intMatDetailID,strColor,strSize";
	$result_grn=$db->RunQuery($sql_grn);
	while($row_grn=mysql_fetch_array($result_grn))
	{
		$grnQty = $row_grn["grnQty"];
		$stockQty = GetStockQty($mainStore,$row_grn["intMatDetailID"],$row_grn["strColor"],$row_grn["strSize"]);
		
		if($grnQty>$stockQty){
			echo "Sorry!\nNo stock available in following item.\nItem Name :";		 
			return;
		}
	}
	
	if($autoTransferNo=="")
		CancelTradingStock($noArray[0],$noArray[1],"GRN");
	else{
		CancelTradingStock($noArray[0],$autoTransferNo,"STNF");
		CancelTradingStock($noArray[0],$autoTransferNo,"STNT");
		CancelTradingStock($noArray[0],$noArray[1],"GRN");
	}
	UpGrnHeader($noArray[0],$noArray[1]);*/
	
	$sqlGRN  = " select * from bulkgrndetails
				where intBulkGrnNo=$noArray[1] and intYear=$noArray[0]";
	
	$result=$db->RunQuery($sqlGRN);	
	
	while($row =mysql_fetch_array($result))
	{
		$matdetailID = $row["intMatDetailID"];
		$color = $row["strColor"];
		$size = $row["strSize"];
		
		$grnQty = $row["dblQty"];
		
		$stockQty = getBulkStockQty($matdetailID,$color,$size,$noArray[1],$noArray[0]);
		
		if($grnQty>$stockQty)
		{
			echo "Some item(s) not in stock. Can't cancel Bulk GRN";
			return;
		}
		
		//check bulk allocation 
		$alloQty = getPendingBulkAlloQty($matdetailID,$color,$size,$noArray[1],$noArray[0]);
		
		if($alloQty>0)
		{
			echo "Item(s) already allocated to a style.\n Can't cancel Bulk GRN ";
			return;
		}
	}
	
	if($autoTransferNo=="")
	{
		CancelTradingStock($noArray[0],$noArray[1],"GRN");
		UpdateBinDetails($noArray[0],$noArray[1],"GRN");
	}
	else{
		CancelTradingStock($noArray[0],$noArray[1],"STNF");
		CancelTradingStock($noArray[0],$noArray[1],"STNT");
		CancelTradingStock($noArray[0],$noArray[1],"GRN");
		UpdateBinDetails($noArray[0],$noArray[1],"STNT");
	}
	
	updateBulkPOdetails($noArray[0],$noArray[1]);
	$resGRN = UpGrnHeader($noArray[0],$noArray[1]);
	
	echo $resGRN;

}
elseif($id=="RemoveFile")
{
	$url	= $_GET["url"];
	$fh = fopen($url, 'a');
	fclose($fh);	
	unlink($url);
}

function GetAutoTransferNo($grnYear,$grnNo)
{
global $db;
$sql="select intSTNno from bulkgrnheader where intBulkGrnNo='$grnNo' and intYear='$grnYear'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["intSTNno"];
}
function GetStockQty($mainStore,$detailId,$color,$size)
{
global $db;
$sql_stock="select sum(dblQty)as stockQty from stocktransactions_bulk where strMainStoresID='$mainStore' and strColor='$color' and strSize='$size' and intMatDetailId='$detailId' group by strMainStoresID,strColor,strSize";

$result_stock=$db->RunQuery($sql_stock);
$row_stock=mysql_fetch_array($result_stock);
return $row_stock["stockQty"];
}

function CancelTradingStock($grnYear,$grnNo,$type)
{	
global $db;
	$sql="select * from stocktransactions_bulk where intBulkGrnNo='$grnNo' and intBulkGrnYear='$grnYear' and strType='$type'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = ($row["dblQty"]*-1);
		$type = "C".$row["strType"];
		CancelTradingStockDB($row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["intDocumentNo"],$row["intDocumentYear"],$row["strUnit"],$qty,$type,$grnYear,$grnNo);
	}
}

function CancelTradingStockDB($mainStore,$subStore,$location,$bin,$matDetailId,$color,$size,$documentNo,$documentYear,$unit,$qty,$type,$grnYear,$grnNo)
{
global $userId;
global $db;
$year		= date("Y");
	$sql_1="insert into stocktransactions_bulk 
		(intYear, 
		strMainStoresID, 
		strSubStores, 
		strLocation, 
		strBin, 
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
		intBulkGrnNo,
		intBulkGrnYear
		)
		values
		('$year', 
		'$mainStore', 
		'$subStore', 
		'$location', 
		'$bin', 
		'$documentNo', 
		'$documentYear', 
		'$matDetailId', 
		'$color', 
		'$size', 
		'$type', 
		'$unit', 
		'$qty', 
		now(), 
		'$userId',
		$grnNo,
		$grnYear);";
	$result_1=$db->RunQuery($sql_1);
}

function UpGrnHeader($grnYear,$grnNo)
{
global $db;
global $userId;
$sql_header="update bulkgrnheader set
			intStatus = 10 ,	
			dtCancelledDate = now() , 
			intCancelledBy = '$userId' 
			where
			intBulkGrnNo = '$grnNo' 
			and intYear = '$grnYear';";
$result_header=$db->RunQuery($sql_header);
return $result_header;
}

function generateBulkGRNno()
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 

	$strSQL="update syscontrol set  dblBulkGrnNO= dblBulkGrnNO+1 WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblBulkGrnNO FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$GRNNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$GRNNo  =  $row["dblBulkGrnNO"] ;
		break;
	 }
	return $GRNNo;
}
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

function getAutomateMainstoreDet($mainstore)
{
	global $db;
	$sql = " select intAutomateCompany from mainstores where intSourceStores=$mainstore ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intAutomateCompany"];
}

function GetVirtualMainstore($mainStore)
{
	global $db;
	$sql="select strMainID from mainstores where intSourceStores='$mainStore' and intStatus=1";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strMainID"];
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

function saveDatatoStockTemp($intYear,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intGrnNo,$intGRNYear,$intMatDetailId,$strColor,$strSize,$strUnit,$dblQty,$intUserId)
{
	global $db;
	$SQL = "INSERT INTO stocktransactions_bulk_temp
									(intYear, 
									strMainStoresID, 
									strSubStores, 
									strLocation, 
									strBin, 
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
									intBulkGrnNo,
									intBulkGrnYear
									)
									values
									($intYear, 
									'$strMainStoresID', 
									'$strSubStores', 
									'$strLocation', 
									'$strBin', 
									 $intGrnNo, 
									 $intGRNYear, 
									 $intMatDetailId, 
									'$strColor', 
									'$strSize', 
									'GRN', 
									'$strUnit', 
									 $dblQty, 
									now(), 
									 $intUserId,
									 $intGrnNo, 
									 $intGRNYear
									)";
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
			$SQLCurrStock = "Select * from stocktransactions_bulk_temp 
						where intDocumentNo='$intGrnNo' and intDocumentYear='$intYear' and strType='GRN'";
			
			$ResultCrrStock = $db->RunQuery($SQLCurrStock);
			//$ResultCrrStock = getPendingStockDetails($intGrnNo,$intYear);
				while($row1 = mysql_fetch_array($ResultCrrStock))
				{
					$mainStoreID = $row1["strMainStoresID"];
					$subStoreID = $row1["strSubStores"];
					$locationID = $row1["strLocation"];
					$binID = $row1["strBin"];
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
						
					//if($chkInspect != 1)
//					{
						$SaveNegRec = saveStocktransactionData($intYear,$mainStoreID,$subStoreID,$locationID,$binID,$NewSTNno,$DocYear,$MatId,$Color,$size,'STNF',$Unit,$Qty1,$userId,$intGrnNo);
					
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
									
							$SaveStockUpdate = saveStocktransactionData($intYear,$MainStore,$vertualSubStore,$vertualLocation,$vertualBin,$NewSTNno,$DocYear,$MatId,$Color,$size,'STNT',$Unit,$Qty,$userId,$intGrnNo);	
						//update storesbinallocation 
								
						$y = updateBinLocation($Qty,$MainStore,$vertualSubStore,$vertualLocation,$vertualBin,$intSubCatNo);
							}
					//}	end if($chkInspect != 1)	
					
							
				} //end while
				
							
			}//end if bin availability
			else
			{
				$a="There is no bin to allocate stock";
			}
						
	return $a;	
}
function checkBinAvforTradingApperalTrans($grnNo,$grnYear,$mainStoreID)
{
	global $db; 
	
	$binCnt =0;
	
	$sql = "select  m.intSubCatID,st.strMainStoresID,st.strSubStores,st.strLocation,st.strBin
		from matitemlist m inner join stocktransactions_bulk_temp st on
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

function checkSTNnoAvinGRNheader($intGrnNo,$intYear)
{
	global $db;
	
	$sql = " select intSTNno from bulkgrnheader where intGrnNo='$intGrnNo' and intGRNYear='$intYear' ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["intSTNno"];
}
function generateSTNno($intCompanyId)
{
	global $db;
	
	//get Current STN No from Syscontrol
		$SQLgetSTN = "SELECT dblBulkSTNno FROM syscontrol WHERE intCompanyID='$intCompanyId'";
		
		$ResultSTN = $db->RunQuery($SQLgetSTN);
		$row = mysql_fetch_array($ResultSTN);
		$CurrSTNno = $row["dblBulkSTNno"];
		
		$NewSTNno = $CurrSTNno+1;
		updateSTNnoDetails($NewSTNno,$intCompanyId);
		
		return $NewSTNno;
}
function updateSTNnoDetails($STNno,$intCompanyId)
{
	global $db;
	
	$SqlSTNupdate = " UPDATE syscontrol SET dblBulkSTNno='$STNno' WHERE intCompanyID='$intCompanyId'";
	$STNupdate = $db->RunQuery($SqlSTNupdate);	
}
function updateSTNnoInGRN($NewSTNno,$intGrnNo,$intYear)
{
	global $db;
	$SQLGRN =  "UPDATE bulkgrnheader 
				set	intSTNno 			= '$NewSTNno'
				   WHERE 
				       intYear=$intYear 
				    AND intBulkGrnNo= $intGrnNo ";
				   
		return $db->RunQuery($SQLGRN);	
}
function getSubcatNo($MatId)
{
	global $db;
	$sql = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$MatId ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intSubCatID"];
}
function checkInnpectionForSubcat($intSubCat)
{
	global $db;
	$sql = " select intInspection from matsubcategory where intSubCatNo='$intSubCat' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intInspection"];
}
function saveStocktransactionData($intYear,$mainStoreID,$subStoreID,$locationID,$binID,$DocNo,$DocYear,$MatId,$Color,$size,$type,$Unit,$Qty1,$userId,$intGrnNo)
{
	global $db;
	$SQLNegQtyRec = "insert into stocktransactions_bulk 
											(intYear, 
											strMainStoresID, 
											strSubStores, 
											strLocation, 
											strBin, 
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
											intBulkGrnNo,
											intBulkGrnYear
											)
											values
											('$intYear', 
											'$mainStoreID', 
											'$subStoreID', 
											'$locationID', 
											'$binID', 
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
											'$intYear'
											)";
						//echo $SQLNegQtyRec;		
				return $db->RunQuery($SQLNegQtyRec);	
					//return $db->RunQuery($SQLNegQtyRec);	
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

function updateStocktransaction($intGrnNo,$intYear)
{
	global $db;
	$intUserId		    =$_SESSION["UserID"];
	$intCompanyId		=$_SESSION["FactoryID"]; 
	
	$SQLstock = getPendingStockDetails($intGrnNo,$intYear);
		while($rowS = mysql_fetch_array($SQLstock))
			{
					$mainStoreID = $rowS["strMainStoresID"];
					$subStoreID = $rowS["strSubStores"];
					$locationID = $rowS["strLocation"];
					$binID = $rowS["strBin"];
					$MatId = $rowS["intMatDetailId"];
					$Color = $rowS["strColor"];
					$size = $rowS["strSize"];
					$Unit = $rowS["strUnit"];
					$Qty = $rowS["dblQty"];	
					$dtmDate = $rowS["dtmDate"];
					$userId = $rowS["intUser"];
					
					$intSubCatNo = getSubcatNo($MatId);
					//check trim inspection need for the subcategory				
					$chkInspect = checkInnpectionForSubcat($intSubCatNo); 
					
					//if($chkInspect != 1)
//					{
						//insert data to stocktransaction 
						$SaveStockUpdate1 = saveStocktransactionData($intYear,$mainStoreID,$subStoreID,$locationID,$binID,$intGrnNo,$intYear,$MatId,$Color,$size,'GRN',$Unit,$Qty,$userId,$intGrnNo);
						
						if($SaveStockUpdate1 == 1)
						{
							//delete data from stock temp
							deleteStockTempData($intGrnNo,$intYear,$mainStoreID,$subStoreID,$locationID,$binID,$MatId,$Color,$size,'GRN',$Unit,$Qty,$userId);
							
						}
					//}	end if($chkInspect != 1)
			}
	$exRate = getExchangeRate($intGrnNo,$intYear);
	
	$SQL =    "UPDATE bulkgrnheader 
		set intStatus 			= 1,
		intConfirmedBy 		= $userId,
		dtmConfirmedDate 	= now(),
		dblRate = '$exRate'
		WHERE 
		intBulkGrnNo=$intGrnNo 
		AND intYear= $intYear ";
				   
			$result = $db->RunQuery($SQL);
			
			return $result;
}
function getPendingStockDetails($intGrnNo,$intYear)
{
	global $db;
	$SQLCurrStock = "Select * from stocktransactions_bulk_temp 
						where intDocumentNo='$intGrnNo' and intDocumentYear='$intYear' and strType='GRN'";
		
		return  $db->RunQuery($SQLCurrStock);	
}
function deleteStockTempData($intGrnNo,$intYear,$mainStoreID,$subStoreID,$locationID,$binID,$MatId,$Color,$size,$type,$Unit,$Qty,$userId)
{
	global $db;
	
	$sql = "delete from stocktransactions_bulk_temp 
			where
			intBulkGrnNo = '$intGrnNo' and intBulkGrnYear = '$intYear' and strMainStoresID='$mainStoreID' 
			and strSubStores = '$subStoreID' and strLocation = '$locationID' and strBin = '$binID' 
			 and  intMatDetailId = '$MatId' 
			and strColor = '$Color' and strSize = '$size' and strType = '$type' ";
			
			$result = $db->RunQuery($sql);	
}
function getBulkStockQty($matdetailID,$color,$size,$grnNo,$grnYear)
{
	global $db;
	
	$sql = "select sum(dblQty) as stockQty 
			from stocktransactions_bulk 
			where intBulkGrnNo='$grnNo' and intBulkGrnYear='$grnYear' and intMatDetailId='$matdetailID'
			and strColor='$color' and strSize='$size'";
			
		$result = $db->RunQuery($sql);
		$row= mysql_fetch_array($result);
		
		return $row["stockQty"];	
}

function UpdateBinDetails($grnYear,$grnNo,$type)
{
	global $db;
	
	$sql = "Select * from stocktransactions_bulk 
			where intBulkGrnNo='$grnNo' and intBulkGrnYear='$grnYear' and strType='$type'";
			
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$dblQty = $row["dblQty"];
		$strMainStoresID = $row["strMainStoresID"];
		$strSubStores	 = $row["strSubStores"];
		$strLocation	 = $row["strLocation"];
		$strBin		     = $row["strBin"];
		$intSubCatNo	 = getSubcatNo($row["intMatDetailId"]);
		
		$res = dedutStockFromBin($dblQty,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo);
		
		
	}
			
}

function updateBulkPOdetails($grnYear,$grnNo)
{
	global $db;
	
	$sql = "select intBulkPoNo,intBulkPoYear,intMatDetailID,strColor,strSize,dblQty
			from bulkgrnheader bgh inner join bulkgrndetails bgd on
			bgh.intBulkGrnNo= bgd.intBulkGrnNo and 
			bgh.intYear = bgd.intYear
			where bgd.intBulkGrnNo='$grnNo' and bgd.intYear='$grnYear'";
				
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$dblQty = $row["dblQty"];
		$bulkPO = $row["intBulkPoNo"];
		$bulkPOyear = $row["intBulkPoYear"];
		$matID = $row["intMatDetailID"];
		$color =$row["strColor"];
		$size = $row["strSize"];
		
		$sqlUpdate = " update bulkpurchaseorderdetails 
						set
						dblPending = dblPending+$dblQty
						where
						intBulkPoNo = '$bulkPO' and intYear = '$bulkPOyear' and intMatDetailId = '$matID' and strColor = '$color' and strSize = '$size' ";
						
		$res = $db->RunQuery($sqlUpdate);
	}
}

function getPendingBulkAlloQty($matdetailID,$color,$size,$grnNo,$grnYear)
{
	global $db;
	
	$sql = "select COALESCE(sum(BD.dblQty),0) as alloQty
			from commonstock_bulkdetails BD
			inner join commonstock_bulkheader BH on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
			where BD.intBulkGrnNo=$grnNo and BD.intBulkGRNYear=$grnYear
			and BD.intMatDetailId='$matdetailID' and BD.strColor='$color' and BD.strSize='$size' and BH.intStatus=0 ";
	
	$result = $db->RunQuery($sql);		
	$row = mysql_fetch_array($result);
	
	return $row["alloQty"];
}

function getExchangeRate($intGrnNo,$intYear)
{
	global $db;
	
	$sql = "select e.rate
			from exchangerate e inner join bulkpurchaseorderheader bph on
			bph.strCurrency = e.currencyID
			inner join bulkgrnheader bgh on
			bgh.intBulkPoNo = bph.intBulkPoNo and 
			bgh.intBulkPoYear = bph.intYear
			where bgh.intBulkGrnNo = '$intGrnNo' and bph.intYear='$intYear' and e.intStatus=1";
			
	$result = $db->RunQuery($sql);		
	$row = mysql_fetch_array($result);
	
	return $row["rate"];	
	
}
?>