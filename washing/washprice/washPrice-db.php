<?php

session_start();


include "../../Connector.php";

$id=$_GET["id"];
$company=$_SESSION["FactoryID"];
if($id=="saveWashPriceHeader")
{	
 
 		 $cboGmtType	= $_GET["cboGmtType"];
		
		 
		 $cboPoNo	    = $_GET["cboPoNo"];			
		 $cboColor		= $_GET["cboColor"];
		 $cboStyleName	= $_GET["cboStyleName"];
		 $txtStyleNo	= $_GET["txtStyleNo"];
		 $txtWashIncome	= $_GET["txtWashIncome"];
		 $txtFabricDes	= $_GET["txtFabricDes"];
		 $proFinishRecCompanyID = $_GET["proFinishRecCompanyID"];
		 $cat			=	$_GET['cat'];
		 if($txtWashIncome == ""){
			$txtWashIncome=0; 
		 }
		 
		 $txtWashCost	= $_GET["txtWashCost"];
		 if( $txtWashCost == ""){
			 $txtWashCost =0; 
		 }
		 $cboWashType	= $_GET["cboWashType"];
		  //echo vv."".$cboWashType;
		 $txtFactory	= $_GET["txtFactory"];
	 
		 $dtmDate       = date("Y/m/d");
		 $userID        = $_SESSION["UserID"];
         $companyID     = $_SESSION["FactoryID"];

/*intCompanyId,'$proFinishRecCompanyID',*/
	$SQL="insert into was_washpriceheader 
		(intStyleId, 
		dblIncome, 
		dblCost, 
		intGarmentId, 
		intWasTypeId, 
		strColor,
		strFabDes,
		dtmDate,
		intUserID,
		intCompanyId,
		intUserCompanyId,
		intCat
		)
		values
		('$cboPoNo', 
		'$txtWashIncome', 
		'$txtWashCost', 
		'$cboGmtType', 
		'$cboWashType', 
		'$cboColor',
		'$txtFabricDes',
		'$dtmDate',
		'$userID',
		'$txtFactory',
		'$companyID',
		'$cat'
		)";

		$intSave = $db->RunQuery($SQL);
		if ($intSave==1)
			echo "$cboPoNo";
		else
			echo "Saving-Error";//"Saving-Error";
			
}

if($id=="updateWashPriceHeader")
{	
 
 		 $cboGmtType	= $_GET["cboGmtType"];	 
		 $cboPoNo	    = $_GET["cboPoNo"];			
		 $cboColor		= $_GET["cboColor"];
		 $cboStyleName	= $_GET["cboStyleName"];
		 $txtStyleNo	= $_GET["txtStyleNo"];
		 $txtWashIncome	= $_GET["txtWashIncome"];
		 $txtFabricDes	= $_GET["txtFabricDes"];
		 $cat			= $_GET['cat'];
		 $proFinishRecCompanyID = $_GET["proFinishRecCompanyID"];
		 
		 if($txtWashIncome == ""){
			$txtWashIncome=0; 
		 }
		 
		 $txtWashCost	= $_GET["txtWashCost"];
		 if( $txtWashCost == ""){
			 $txtWashCost =0; 
		 }
		 $cboWashType	= $_GET["cboWashType"];
		  //echo vv."".$cboWashType;
		 $txtFactory	= $_GET["txtFactory"];
	 
		 $dtmDate       = date("Y/m/d");
		 $userID        = $_SESSION["UserID"];
         $companyID     = $_SESSION["FactoryID"];

		
		$SQL = "UPDATE was_washpriceheader SET dblIncome='$txtWashIncome',
		                                       dblCost='$txtWashCost',
											   intGarmentId='$cboGmtType',
											   intWasTypeId='$cboWashType',
											   strFabDes='$txtFabricDes',
											   strColor='$cboColor',
											   dtmDate='$dtmDate',
											   intUserID='$userID',
											   intCompanyId='$proFinishRecCompanyID',
											   intUserCompanyId = '$companyID',
											   intCat='$cat'
				WHERE intStyleId = '$cboPoNo'";							   
											  
		$intUpdate = $db->RunQuery($SQL);
		if ($intUpdate==1)
			echo "$cboPoNo";
		else
			echo "Saving-Error";//"Saving-Error";
			
}

if($id=="saveWashPriceDetails")
{
	    $cboPoNo		= $_GET["cboPoNo"];
		$chkBox			= $_GET["chkBox"];
		$descrip		= $_GET["descrip"];
		$washPrice		= $_GET["washPrice"];
		if($washPrice == ""){
		$washPrice = 0;	
		}

/*
	$delSQL = "DELETE FROM invoicecostingdetails WHERE intStyleId = '$cbointStyleId'";
	$delResult = $db->RunQuery($delSQL);
		*/
	if($chkBox =="yes"){	
	$SQL="INSERT INTO was_washpricedetails 
		(	intStyleId, 
			intDryProssId, 
			dblWashPrice
		)
		VALUES
		(	'$cboPoNo', 
			'$descrip', 
			'$washPrice'
		)";
//echo $SQL;
		$intSave = $db->RunQuery($SQL);

		if ($intSave==1){
			echo $intSave;
		}
		else
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
//			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			echo "Saving-Error";
			
		}
	}else{
	echo "1";	
	}
		
}


if($id=="deleteForUpdate")
{
  $cboPoNo		= $_GET["cboPoNo"];
	$delSQL = "DELETE FROM was_washpricedetails WHERE intStyleId = '$cboPoNo'";
	$intSave = $db->RunQuery($delSQL);
	//echo $delSQL;
	if ($intSave==1){
		echo $intSave;
	}else{
	echo "Error";
	}
}

if($id=="updateWashPriceDetails")
{
	    $cboPoNo		= $_GET["cboPoNo"];
		$chkBox			= $_GET["chkBox"];
		$descrip		= $_GET["descrip"];
		$washPrice		= $_GET["washPrice"];
		if($washPrice == ""){
		$washPrice = 0;	
		}




	if($chkBox =="yes"){	
	$SQL="INSERT INTO was_washpricedetails 
		(	intStyleId, 
			intDryProssId, 
			dblWashPrice
		)
		VALUES
		(	'$cboPoNo', 
			'$descrip', 
			'$washPrice'
		)";
		

//echo $SQL;
		$intSave = $db->RunQuery($SQL);

		if ($intSave==1){
			echo $intSave;
		}
		else
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
//			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			echo "Saving-Error";
			
		}
	}else{
	echo "1";	
	}
		
}

?>


