<?php

session_start();


include "../../Connector.php";

$id=$_GET["id"];

if($id=="saveBulkPoHeader")
{		  
		 $intGenPONo			= $_GET["intGenPONo"];			
		 $intYear				= $_GET["intYear"];
		 $intSupplierID			= $_GET["intSupplierID"];
		 $strRemarks			= $_GET["strRemarks"];
		 $dtmDate				= $_GET["dtmDate"];
		 $dtmDeliveryDate		= $_GET["dtmDeliveryDate"];
		 $strCurrency			= $_GET["strCurrency"];
		 $dblTotalValue			= $_GET["dblTotalValue"];
		 $intInvoiceComp		= $_GET["intInvoiceComp"];
		 $intDeliverTo			= $_GET["intDeliverTo"];
		 $strPayTerm			= $_GET["strPayTerm"];
		 $intPayMode			= $_GET["intPayMode"];
		 /*$intShipmentModeId  	= $_GET["intShipmentModeId"];*/
		 $strInstructions		= $_GET["strInstructions"];
		/* $strPINO				= $_GET["strPINO"];*/
		 $FactoryID				= $_SESSION["FactoryID"];
		 $intUserID				= $_SESSION["UserID"];

		 // =======================GET NEXT bulk po NO================================
		 if($intYear=="")
			$intYear=date("Y");
			
		  if($intGenPONo=="")
		  {
		    $SQL="SELECT strValue FROM settings WHERE strKey='GPOID$FactoryID'";
			$result =  $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$intGenPONo =  $row["strValue"];
				break;
			}
						
			$strRange = "";
			$SQL="SELECT strValue FROM settings WHERE strKey='$FactoryID'";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$strRange =  $row["strValue"];
				
				break;
			}
			
			$A = split("-",$strRange);
			// VALIDATION GRN RANGE
			if((int)$A[1]<$intGenPONo+1)
			{
				echo "exceedRange";
				return;
			}
			//
			if($intGenPONo=="")
			{
					$intGenPONo = $A[0]+1;
					$SQL="INSERT INTO settings(strKey,strValue)values('GPOID".$FactoryID."','".$intGenPONo."')";
					$result = $db->RunQuery($SQL);
			}
			else
			{
					$SQL = "UPDATE settings set strValue=strValue+1 where strKey='GPOID$FactoryID'";
					$result = $db->RunQuery($SQL);
			}
		 }
		 //echo $intGenPONo;
		  //==========================================================
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	//delete grn header
	$delSQL = "DELETE FROM generalpurchaseorderheader WHERE intGenPONo = '$intGenPONo' AND intYear='$intYear'";
	$delResult = $db->RunQuery($delSQL);
	
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	
	$delSQL = "DELETE FROM generalpurchaseorderdetails WHERE intGenPONo = '$intGenPONo' AND intYear='$intYear'";
		$delResult = $db->RunQuery($delSQL);
	
	$SQL="insert into generalpurchaseorderheader 
		(intGenPONo, 
		intYear, 
		intSupplierID, 
		dtmDate, 
		dtmDeliveryDate, 
		strCurrency, 
		intStatus,  
		intUserID, 
		intInvoiceComp, 
		intPrintStatus, 
		intCompId, 
		intDeliverTo, 
		intPreviousUserId, 
		strPayTerm, 
		intPayMode, 
		strInstructions,
		dblPoBalance
		)
		values
		('$intGenPONo', 
		'$intYear', 
		'$intSupplierID', 
		'$dtmDate', 
		'$dtmDeliveryDate', 
		'$strCurrency', 
		'0',
		'$intUserID', 
		'$intInvoiceComp', 
		'0', 
		'$FactoryID', 
		'$intDeliverTo', 
		'0', 
		'$strPayTerm', 
		'$intPayMode', 
		'$strInstructions',
		'$dblTotalValue'
		)";
		//echo $SQL;
		$intSave = $db->RunQuery($SQL);
		if ($intSave==1)
			echo "$intYear/$intGenPONo";
		else
			echo "Saving-Error";//"Saving-Error";
}

if($id=="saveBulkPoDetails")
{
		$count						= $_GET["count"];
		$intGenPONo				= $_GET["intGenPONo"];
		$intYear					= $_GET["intYear"];
		$intMatDetailID				= $_GET["intMatDetailID"];
		$strDescription				= str_replace("***","#",$_GET["strDescription"]);
		$strUnit					= $_GET["strUnit"];
		$dblUnitPrice				= $_GET["dblUnitPrice"];
		$dblQty						= $_GET["dblQty"];
		$dblPending					= $_GET["dblPending"];
		$dblDlPrice					= $_GET["dblDlPrice"];
		$strDeliveryDates			= $_GET["strDeliveryDates"];
		$intDeliverTo				= $_GET["intDeliverTo"];
		$intMainCatID				="";
		$intSubCatID				="";

	//G E T   M A I N C A T   I D   A N D   S U B C A T  I D 
		$SQL = "SELECT intMainCatID,intSubCatID,strItemDescription FROM genmatitemlist WHERE intItemSerial=$intMatDetailID";
		$iResult = $db->RunQuery($SQL);
		while ($row=mysql_fetch_array($iResult))
		{
			$intMainCatID 		= $row["intMainCatID"];
			$intSubCatID		= $row["intSubCatID"];
			$strItemDescription	= $row["strItemDescription"];
		}
	// end of line



	$SQL="insert into generalpurchaseorderdetails 
		(	intGenPONo, 
			intYear, 
			intMatDetailID, 
			strUnit, 
			dblUnitPrice, 
			dblQty, 
			dblPending, 
			intDeliverTo
		)
		values
		(	'$intGenPONo', 
			'$intYear', 
			'$intMatDetailID', 
			'$strUnit', 
			'$dblUnitPrice', 
			'$dblQty', 
			'$dblPending', 
			'$intDeliverTo'
		);";

		$intSave = $db->RunQuery($SQL);
		//echo $SQL;
		if ($intSave==1)
			echo $intSave ."-". $intYear ."/". $intGenPONo;
		else
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
//			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			echo "Saving-Error";
			
		}
		
}

if($id=="confirmBulkPo")
{
		$intGenPONo	= $_GET["intGenPONo"];
		$intYear		= $_GET["intYear"];
		$intUserId		= $_SESSION["UserID"];
		$dtmDate		= date("Y-m-d");
	
	$SQL =    "UPDATE generalpurchaseorderheader 
				set intStatus 			= 1 			,
				    intConfirmedBy 		= $intUserId	,
				    dtmConfirmedDate 	= '$dtmDate'	
					
				   WHERE
				       intGenPONo	=	'$intGenPONo' 
				   AND intYear		= 	'$intYear' ";
			
			$result = $db->RunQuery($SQL);
			echo $result;
		if ($result!=1)
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
//			include "errorEmail.php";
			///////////////////////////
			//////////////////////////////////////
			echo "Saving-Error";
		}
}

if($id=="cancelBulkPo")
{
		$intGenPONo	= $_GET["intGenPONo"];
		$intYear	= $_GET["intYear"];
		$intUserId	= $_SESSION["UserID"];
		$dtmDate	= date("Y-m-d");
		
		$row1 = "";
		$SQL = "SELECT strGenGRNNo,intYear FROM gengrnheader WHERE intGenPONo = '$intGenPONo' AND intGenPOYear = $intYear ";
		$result1 = $db->RunQuery($SQL);
		while($row1 = mysql_fetch_array($result1))
		{
			$grnExist .= $row1["intYear"] . "/" . $row1["strGenGRNNo"] . ",";
		}

		//$row1 = mysql_fetch_array($result1);
		//echo count($row1);
		if ($grnExist == "")
		{
			$SQL =    "UPDATE generalpurchaseorderheader 
						set intStatus 			= 10 			,
							intCancelledUserId		= $intUserId	,
							dtmCancelledDate 		= '$dtmDate'	
						   WHERE
							   intGenPONo	=	'$intGenPONo' 
						   AND intYear		= 	'$intYear' ";
					   
			$result = $db->RunQuery($SQL);
			echo $result;
			
			if ($result!=1)
			{
				/////// sending error emails to my mail /////////////////////////
				//$_GET["body"]= $SQL;
//				include "errorEmail.php";
				/////////////////////////////////////////////////////////////////
				echo "Saving-Error";
			}
		}
		else
		{
/*			while($row1 = mysql_fetch_array($result1))
			{
				$grnExist .= $row1["intYear"] . "/" . $row1["strGenGRNNo"] . ",";
			}
*/			
			//echo "Can not cancel, GRN exist !";
			echo $grnExist ;
		}
}
?>


