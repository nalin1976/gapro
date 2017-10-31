<?php
session_start();


include "../../Connector.php";
//$db->CloseConnection();
//$id="saveGrnHeader";
$id=$_GET["id"];
///$abc = '';
//$db=NULL;
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
		  $intGRNYear		= date("Y");
		  $intPoNo			=trim($_GET["intPoNo"]);
		  $intYear			=trim($_GET["intYear"]);
		  $dtmRecievedDate	=$_GET["dtmRecievedDate"];
		  $strInvoiceNo		=trim($_GET["strInvoiceNo"]);
		  $strSupAdviceNo	=trim($_GET["strSupAdviceNo"]);
		  $dtmAdviceDate	=$_GET["dtmAdviceDate"];
		  $strBatchNO		=trim($_GET["strBatchNO"]);
		  $intUserId		=$_SESSION["UserID"];
		  $intCompanyId		=$_SESSION["FactoryID"];
		  
		 // ======================= GET NEXT GRN NO ================================
		 
		// $result = $db->RunQuery('BEGIN');
		 
		  if($intGrnNo=="")
		  {
		    $SQL="SELECT strValue FROM settings WHERE strKey='GRNID$intCompanyId'";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$intGrnNo =  $row["strValue"];
				break;
			}
			
			$strRange = "";
			$SQL="SELECT strValue FROM settings WHERE strKey='$intCompanyId'";
			//echo $SQL;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$strRange =  $row["strValue"];
				//echo $strRange;
				break;
			}
			
			$A = split("-",$strRange);
			// VALIDATION GRN RANGE
			if((int)$A[1]<$intGrnNo+1)
			{
				echo "error->GRN no is exceeded. GRN Not Saved";
				return;
			}
			//
			if($intGrnNo=="")
			{
						$intGrnNo = $A[0];
						$SQL="INSERT INTO settings(strKey,strValue)values('GRNID".$intCompanyId."','".($A[0]+1)."')";
						$result = $db->RunQuery($SQL);
			}
			else
			{
						$SQL = "UPDATE settings set strValue=strValue+1 where strKey='GRNID$intCompanyId'";
						$result = $db->RunQuery($SQL);
			}
		 }
		  //==========================================================
		
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	//delete grn header
	$delSQL = "DELETE FROM grnheader WHERE intGrnNo = $intGrnNo AND intGRNYear = $intGRNYear";
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
	"intCompanyID".
	")".
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
	"$intCompanyId".
	")";
	
		//$result = $db->RunQuery('ROLLBACK');
		//return;
		//echo $SQL;
		$intSave = $db->RunQuery($SQL);
		
		if (!$intSave)
		{
			echo 'error->GRN Header not saved. Pls save it again.';
			return;
		}
		
	/*	////////////////////////////////FOR RALL BACK GRN DETAILS
		
										//below code for Allocate default Bins
	//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

					$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
					$result = $db->RunQuery($SQL);
					$active =10;
					while($row = mysql_fetch_array($result))
					{
						$active = $row["strValue"];
						break;
					}
					
		if($active==1)
		{
		//echo "xxxxxxxxxxxxxxx";
/*							$SQL = "SELECT
									storesbins.strBinID,
									storesbins.strMainID as strMainID,
									storesbins.strSubID,
									storesbins.strLocID,
									storesbins.strBinName,
									storesbins.strRemarks,
									storesbins.intStatus
									FROM
									storesbins
									Inner Join mainstores ON mainstores.strMainID = storesbins.strMainID
									where storesbins.intStatus=1 AND mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."'";
									
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								$strMainStoresID	=$row["strMainID"];
								$strSubStores		=$row["strSubID"];
								$strLocation		=$row["strLocID"];
								$strBin				=$row["strBinID"];
							}	
							$strStyleNo			=$strStyleID;
							$strBuyerPoNo		=$strBuyerPONO;
							$intMatDetailId		=$intMatDetailID;
							$intUserId			=$_SESSION["UserID"];
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
								
								$x = "INSERT INTO storesbinallocation(strMainID,strSubID,strLocID,strBinID,intSubCatNo,intStatus,dblCapacityQty)
									VALUES($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo,'1','10000000')
									/* For find subcatno query = $x * /";
								//echo $x;
								$x1 = $db->RunQuery($x);	


				$pSQL = "SELECT * FROM stocktransactions_temp where intDocumentNo=$intGrnNo AND intDocumentYear=$intYear AND strType='GRN'";
				$pResult = $db->RunQuery($pSQL);	
				while($row = mysql_fetch_array($pResult))
				{
					
								$strMainID = $row["strMainStoresID"]; 	
								$strSubID = $row["strSubStores"];  		 
								$strLocID = $row["strLocation"];  		 
								$strBinID = $row["strBin"];  			 		 
								$dblQty3 = $row["dblQty"]; 
								
								
								
					$SQL4 = "   UPDATE storesbinallocation 
								SET
								dblFillQty = dblFillQty-$dblQty3 
								WHERE
								strMainID = '$strMainID' 	AND
								strSubID = '$strSubID' 		AND 
								strLocID = '$strLocID' 		AND 
								strBinID = '$strBinID' 		AND 
								intSubCatNo = $intSubCatNo AND 
								intStatus = 1";
								
								$y = $db->RunQuery($SQL4);	
								
								if(!$y)
								{
									echo 'error';
									return;
								}
				}
					$delSQL = "DELETE FROM stocktransactions_temp WHERE intDocumentNo=$intGrnNo AND intDocumentYear=$intGRNYear AND strType='GRN'";
					$delResult = $db->RunQuery($delSQL);
					//echo $delSQL;
					
					
						//$fullQty = $dblPendingAddtionalQty + $dblQty;
						$fullQty =  $dblQty;
					//echo "vvvvvvvvvvvvvv";
						//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ STOCK TRANSACTION TABLE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
						
					
		}
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ END OF DEFAULT BIN @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	//<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	
	
		//^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^^^
		//delete grn Details and update purchaseorder details table*/

			$pSQL = "SELECT * FROM grndetails where intGrnNo=$intGrnNo AND intGRNYear=$intGRNYear";
			$qSQL="";
			$pResult = $db->RunQuery($pSQL);	
			while($row = mysql_fetch_array($pResult))
			{
			    	   $strStyleID2		 =$row["strStyleID"];
					   $intMatDetailID2	 =$row["intMatDetailID"];
					   $strColor2		 =$row["strColor"];
					   $strSize2		 =$row["strSize"];
					   $strBuyerPONO2	 = $row["strBuyerPONO"];
					   $dblQty2			 =$row["dblQty"];
					   //$dblAdditionalQty =$row["dblAditionalQty"];

				   $qSQL = "UPDATE purchaseorderdetails set dblPending = dblPending + $dblQty2 
						   WHERE intPoNo = $intPoNo 
						   AND intYear=$intYear 
						   AND strStyleID='$strStyleID2' 
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
			$delSQL = "DELETE FROM grndetails WHERE intGrnNo=$intGrnNo AND intGRNYear=$intGRNYear";
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
				echo "saved->$intGrnNo";
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
			//$db->$RunQuery('LOCK TABLES grndetails WRITE');
			//print_r($db);
			$count	   			= $_GET["count"];
			$intGrnNo   		= $_GET["intGrnNo"];
			$intGRNYear			= date("Y");
			$strStyleID			= trim($_GET["strStyleID"]);
			$strBuyerPONO		= str_replace("***","#",$_GET["strBuyerPONO"]);
			$intMatDetailID		= $_GET["intMatDetailID"];
			$strColor			= $_GET["strColor"];
			$strSize			= $_GET["strSize"];
			$dblQty 			= $_GET["dblQty"];
			$dblCapacityQty		= $_GET["dblCapacityQty"];
			$dblExcessQty		= $_GET["dblExcessQty"];
			$dblRate			= $_GET["dblRate"];
			$intPoNo			= $_GET["intPoNo"];
			$intYear			= $_GET["intYear"];
			$dblBalance			=   $dblQty;
			$dblValueBalance	=  ($dblQty * $dblRate);
			$strUnit			=$_GET["strUnit"];//dblPendingAddtionalQty
			///$dblPendingAddtionalQty			=$_GET["dblPendingAddtionalQty"];//dblPendingAddtionalQty

	
				//!!!!!!	FIND SUB CAT NO 	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$intSubCatNo='';
				$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailID ";
					$x1 = $db->RunQuery($x);	
					while($row = mysql_fetch_array($x1))
					{
						$intSubCatNo=$row["intSubCatID"];
					}
			    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				


// INSERT GRN DETAILS 
		
	$SQLdetails = "insert into grndetails 
				(intGrnNo, 
				intGRNYear, 
				strStyleID, 
				strBuyerPONO, 
				intMatDetailID, 
				strColor, 
				strSize, 
				dblQty, 
				dblExcessQty, 
				dblBalance, 
				dblValueBalance
				)
				values
			    ($intGrnNo, 
				 $intGRNYear, 
				'$strStyleID', 
				'$strBuyerPONO', 
				 '$intMatDetailID', 
				'$strColor', 
				'$strSize', 
				 $dblQty, 
				 $dblExcessQty, 
				 $dblBalance, 
				 $dblValueBalance
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
				   AND strStyleID='$strStyleID' 
				   AND intMatDetailID=$intMatDetailID
				   AND strColor='$strColor'
				   AND strSize='$strSize'
				   AND strBuyerPONO='$strBuyerPONO'";
			$result = $db->RunQuery($SQL2);	
			if(!$result)
			{
				echo 'error->purchaseorder details update error. row no $count';
				return;
			}
			
			
			//////////////////				FOR STOCK TRANS ACTION  ///////////////////////////////////
				$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
				$result = $db->RunQuery($SQL);
				$active =10;
				while($row = mysql_fetch_array($result))
				{
					$active = $row["strValue"];
					break;
				}
					
		if($active==1)
		{
		
					$SQL = "SELECT
									storesbins.strBinID,
									storesbins.strMainID as strMainID,
									storesbins.strSubID,
									storesbins.strLocID,
									storesbins.strBinName,
									storesbins.strRemarks,
									storesbins.intStatus
									FROM
									storesbins
									Inner Join mainstores ON mainstores.strMainID = storesbins.strMainID
									where storesbins.intStatus=1 AND mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."'";
									
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								$strMainStoresID	=$row["strMainID"];
								$strSubStores		=$row["strSubID"];
								$strLocation		=$row["strLocID"];
								$strBin				=$row["strBinID"];
							}	

							$strBuyerPoNo		=$strBuyerPONO;
							$intMatDetailId		=$intMatDetailID;
							$intUserId			=$_SESSION["UserID"];
							$dtmDate			= date("Y-m-d");
						
			    		//==================================================================================================
								
								$x = "INSERT INTO storesbinallocation(strMainID,strSubID,strLocID,strBinID,intSubCatNo,intStatus,dblCapacityQty)
									VALUES($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo,'1','10000000')
									/* For find subcatno query = $x * /";
								//echo $x;
								$x1 = $db->RunQuery($x);
						//===================================================================================================
		
						$SQL = "INSERT INTO stocktransactions_temp
									(intYear, 
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
									values
									($intYear, 
									'$strMainStoresID', 
									'$strSubStores', 
									'$strLocation', 
									'$strBin', 
									'$strStyleID', 
									'$strBuyerPoNo', 
									 $intGrnNo, 
									 $intGRNYear, 
									 $intMatDetailId, 
									'$strColor', 
									'$strSize', 
									'GRN', 
									'$strUnit', 
									 $dblQty, 
									'$dtmDate', 
									 $intUserId
									)";
						$result = $db->RunQuery($SQL);	
						//echo $SQL;
						
					
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
						
						$y = $db->RunQuery($SQL);		
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
				$strBuyerPoNo		=str_replace("***","#",$_GET["strBuyerPoNo"]);
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
			
			
/*			$pSQL="";
			if($count ==1)
			{
				$pSQL = "SELECT * FROM stocktransactions_temp where intDocumentNo=$intGrnNo AND intDocumentYear=$intYear AND strType='GRN'";
				$pResult = $db->RunQuery($pSQL);	
				while($row = mysql_fetch_array($pResult))
				{
					
								$strMainID = $row["strMainStoresID"]; 	
								$strSubID = $row["strSubStores"];  		 
								$strLocID = $row["strLocation"];  		 
								$strBinID = $row["strBin"];  			 		 
								$dblQty3 = $row["dblQty"]; 
								
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

				}
					$delSQL = "DELETE FROM stocktransactions WHERE intDocumentNo=$intGrnNo AND intDocumentYear=$intYear AND strType='GRN'";
					$delResult = $db->RunQuery($delSQL);

			}*/
			
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ STOCK TRANSACTION TABLE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
			$SQL = "INSERT INTO stocktransactions_temp 
						(intYear, 
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
						values
						($intYear, 
						'$strMainStoresID', 
						'$strSubStores', 
						'$strLocation', 
						'$strBin', 
						'$strStyleNo', 
						'$strBuyerPoNo', 
						 $intGrnNo, 
						 $intYear, 
						 $intMatDetailId, 
						'$strColor', 
						'$strSize', 
						'GRN', 
						'$strUnit', 
						 $dblQty, 
						'$dtmDate', 
						 $intUserId
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
	$intUserId	=	$_SESSION["UserID"];
	$dtmDate	= 	date("Y-m-d");
	
	$SQLstock = "INSERT INTO stocktransactions ( intYear,strMainStoresID,strSubStores,strLocation,strBin,strStyleNo,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser) SELECT intYear,strMainStoresID,strSubStores,strLocation,strBin,strStyleNo,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser FROM stocktransactions_temp  
	where intDocumentNo='$intGrnNo' and intDocumentYear='$intYear' and strType='GRN'";
	$resultStock = $db->RunQuery($SQLstock);
	
	$SQLdel		="delete from stocktransactions_temp 
	where intDocumentNo='$intGrnNo' and intDocumentYear='$intYear' and strType='GRN'";
	$resultDel	= $db->RunQuery($SQLdel);
	
	$SQL =    "UPDATE grnheader 
				set intStatus 			= 1 			,
				    intConfirmedBy 		= $intUserId	,
				    dtmConfirmedDate 	= '$dtmDate'	,
				    intGRNApproved 		= 1
					
				   WHERE 
				       intGRNYear=$intYear 
				    AND intGrnNo= $intGrnNo ";
				   
			$result = $db->RunQuery($SQL);

			echo $result;
			
			if($result<=0)
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
			//include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
		}
}

if($id=="cancel")
{
	$intGrnNo 		= 	$_GET["intGrnNo"];
	$intGrnYear 	= 	$_GET["intGrnYear"];
	$intYear		= 	$_GET["intYear"];
	$intUserId		= 	$_SESSION["UserID"];
	$dtmDate		= 	date("Y-m-d");
	$intPoNo 		= 	$_GET["intPoNo"];
	
	///////////////////////////           update stores bin 
	$pSQL = "SELECT * FROM stocktransactions where intDocumentNo=$intGrnNo AND intDocumentYear=$intGrnYear AND strType='GRN'";
				$pResult = $db->RunQuery($pSQL);	
				while($row = mysql_fetch_array($pResult))
				{
					
								$strMainID = $row["strMainStoresID"]; 	
								$strSubID = $row["strSubStores"];  		 
								$strLocID = $row["strLocation"];  		 
								$strBinID = $row["strBin"];  			 		 
								$dblQty3 = $row["dblQty"]; 
								$intMatDetailId=$row["intMatDetailId"]; 
								
								
							//!!!!!!	FIND SUB CAT NO 	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
								$intSubCatNo='';
								$x = "SELECT intSubCatID FROM  matitemlist 	WHERE intItemSerial=$intMatDetailId ";
									$x1 = $db->RunQuery($x);	
									while($row = mysql_fetch_array($x1))
									{
										$intSubCatNo=$row["intSubCatID"];
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

				}
					$delSQL = "DELETE FROM stocktransactions WHERE intDocumentNo=$intGrnNo AND intDocumentYear=$intGrnYear AND strType='GRN'";
					$delResult = $db->RunQuery($delSQL);

	//////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\1
	
	///////////////////////////////   update puchase orders 
	$pSQL = "SELECT * FROM grndetails where intGrnNo=$intGrnNo AND intGRNYear=$intGrnYear";
	//echo $pSQL;
	$qSQL="";
	$pResult = $db->RunQuery($pSQL);
		
			while($row = mysql_fetch_array($pResult))
			{
			    	   $strStyleID2		=$row["strStyleID"];
					   $intMatDetailID2	=$row["intMatDetailID"];
					   $strColor2		=$row["strColor"];
					   $strSize2		=$row["strSize"];
					   $strBuyerPONO2	=$row["strBuyerPONO"];
					   $dblQty2			=$row["dblQty"];

				   $qSQL = "UPDATE purchaseorderdetails set dblPending = dblPending + $dblQty2
						   WHERE intPoNo = $intPoNo 
						   AND intYear=$intYear 
						   AND strStyleID='$strStyleID2' 
						   AND intMatDetailID=$intMatDetailID2
						   AND strColor='$strColor2'
						   AND strSize='$strSize2'
						   AND strBuyerPONO='$strBuyerPONO2'";
					$qResult = $db->RunQuery($qSQL);
					//echo $qSQL;
			if($qResult<=0)
			{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
			//include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			}
			
			}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	$SQL =    "UPDATE grnheader 
				set intStatus 			= 10 			,
				    intCancelledBy		= $intUserId	,
				    dtmCancelledDate 	= '$dtmDate'
					
				   WHERE
				   intGRNYear=$intGrnYear  AND
				   intGrnNo= $intGrnNo ";
				   
			$result = $db->RunQuery($SQL);
			echo $result;
			
			if($result<=0)
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
			//include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
		}
}





?>