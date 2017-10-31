<?php
session_start();

include "../../../Connector.php";
//$id="saveGrnHeader";
$id=$_GET["id"];
$intUserId	=$_SESSION["UserID"];
$factoryID = $_SESSION["FactoryID"];
if($id=="saveGrnHeader")
{
		  //var tblGrn = document.getElementById("tblMainGrn");		  	
		  	
		  $strGenGrnNo		=	$_GET["strGenGrnNo"];
		  $intGRNYear		=	$_GET["intBulkGrnyear"];
		  $intGenPONo		=	$_GET["intGenPoNo"];
		  $intGenPOYear		=	$_GET["intGenPoYear"];
		  //$dtRecdDate		=	$_GET["dtRecdDate"];
		  $dtRecdDate		=	date("Y-m-d");
		  $strInvoiceNo		=	$_GET["strInvoiceNo"];
		  $strSupAdviceNo	=	$_GET["strSupAdviceNo"];
		  $dtAdviceDate		=	$_GET["dtAdviceDate"];
		  $intUserId		=	$_SESSION["UserID"];
		  $intCompanyId		=	$_SESSION["FactoryID"];
		  
		 // =======================GET NEXT GRN NO================================
		 
		 if($intGRNYear=="")
			$intGRNYear=date("Y");
		 		 
		  if($strGenGrnNo=="")
		  {
		    $SQL="SELECT dblGGRNNo FROM syscontrol WHERE intCompanyID='$intCompanyId'";
			$result =  $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$strGenGrnNo =  $row["dblGGRNNo"];
				$SQL = "UPDATE syscontrol set dblGGRNNo=dblGGRNNo+1 where intCompanyID='$intCompanyId'";
				$result = $db->RunQuery($SQL);
				break;
			}
		  }
		//--------------------------------------------------------------		 
		 
		  //==========================================================
		  
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	//delete grn header
	
		$delSQL = "DELETE FROM gengrnheader WHERE strGenGrnNo = '$strGenGrnNo' AND intYear = '$intGRNYear'";
		$delResult = $db->RunQuery($delSQL);
	
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	$SQL=    "insert into gengrnheader (strGenGrnNo,intYear,intGenPONo,intGenPOYear,dtRecdDate,strInvoiceNo, strLocation, 
			strSupAdviceNo,	intStatus, intPrintStatus,intUserId,intCompId,dtAdviceDate)
			values	('$strGenGrnNo','$intGRNYear','$intGenPONo',$intGenPOYear,'$dtRecdDate','$strInvoiceNo', '', 				'$strSupAdviceNo', '0', '0', '$intUserId','$intCompanyId','$dtAdviceDate')";
	//echo $SQL;
		
		$intSave = $db->RunQuery($SQL);

		if ($intSave==1)
			echo $intGRNYear."/".$strGenGrnNo;
		else
		{
			echo "Saving-Error";
			
			/////// sending error emails to my mail /////////////////////////
			$_GET["body"]= $SQL;
			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
		}
		
		//////////////////////////////// delete gen grn details //////////////////////////////
			//echo $count;
			$SQL_A = "SELECT * FROM gengrndetails where strGenGrnNo='$strGenGrnNo' AND intYear='$intGRNYear'";
			$qSQL="";
			$result_A = $db->RunQuery($SQL_A);	
			while($row = mysql_fetch_array($result_A))
			{
			   $intMatDetailID2	=$row["intMatDetailID"];
			   $dblQty2			=(float)$row["dblQty"];
			   $costCenterId = $row["intCostCenterId"];
			   $glAlloId	= $row["intGLAllowId"];
			   				
				$qSQL = "UPDATE generalpurchaseorderdetails set dblPending = dblPending + $dblQty2
					   WHERE intGenPONo = $intGenPONo 
					   AND intYear=$intGenPOYear 
					   AND intMatDetailID=$intMatDetailID2 ";
				$qResult = $db->RunQuery($qSQL);	
					
			}
			
			$delSQL = "DELETE FROM gengrndetails WHERE strGenGrnNo='$strGenGrnNo' AND intYear='$intGRNYear'";
			$delResult = $db->RunQuery($delSQL);
		
}

if($id=="saveGrnDetails")
{	
			$count	   			= $_GET["count"];
			$intGrnNo   		= $_GET["strGenGrnNo"];
			$intGRNYear			= $_GET["intBulkGrnYear"];
			$intMatDetailID		= $_GET["intMatDetailID"];
			$dblQty 			= $_GET["dblQty"];
			$dblCapacityQty		= $_GET["dblCapacityQty"];
			$dblExcessQty		= $_GET["dblExcessQty"];
			$dblRate			= $_GET["dblRate"];
			$intGenPONo			= $_GET["intGenPONo"];
			$intYear			= $_GET["intYear"];
			$dblBalance			= $dblQty;
			$dblValueBalance	= ($dblQty * $dblRate);
			$strUnit			=$_GET["strUnit"];
			$strInvoiceNo		=$_GET["strInvoiceNo"];
			$strDesc			=$_GET["strDesc"];
			$costCenterId		= $_GET["costCenterId"];
			$glAlloId			= $_GET["glAlloId"];

			// INSERT GRN DETAILS 
			//echo $count;
			$SQL = "insert into gengrndetails 
				(strGenGrnNo,intYear, intMatDetailID, strUnit,dblRate,dblQty,dblExQty,dblBalance, dblValueBalance )
				values  ('$intGrnNo', '$intGRNYear', '$intMatDetailID', '$strUnit', '$dblRate', '$dblQty',  '$dblExcessQty', 				 '$dblBalance', '$dblValueBalance')";
				
		//echo $SQL;
		$intSave = $db->RunQuery($SQL);
		
		if ($intSave==1)
		{
					  
		  $SQL2 =  " UPDATE generalpurchaseorderdetails set dblPending = dblPending - $dblQty 
					   WHERE intGenPONo = $intGenPONo 
					   AND intYear=$intYear 
					   AND intMatDetailID=$intMatDetailID ";
				   //echo $SQL2;
			$result = $db->RunQuery($SQL2);
			

			
			if($result==1)
				//echo $intSave;
				echo $intSave . "-" . $intGRNYear . "/" . $intGrnNo ;
			else
				echo $SQL2;
		}
		else
			echo $SQL;
			//echo $qSQL;
} 

if($id=="confirmed")
{
	$intGrnNo 	= $_GET["intGrnNo"];
	$intYear	= $_GET["intYear"];
	$intUserId	= $_SESSION["UserID"];
	$dtmDate	= date("Y-m-d");
	
	$exRate = getExchangeRate($intGrnNo,$intYear);
	$SQL = "UPDATE gengrnheader 
				SET intStatus 			= 1 			,
				    intConfirmedBy 		= $intUserId	,
				    dtmConfirmedDate 	= '$dtmDate'	,
				    intGRNApproved 		= 1,
					dblExRate = '$exRate'
				   WHERE
				       intYear=$intYear 
				   AND strGenGrnNo= '". $intGrnNo ."' ";
			//echo $SQL;
			$result = $db->RunQuery($SQL);
			echo $result;
}


if($id=="cancelGrnDetails")
{	
			
	$intGrnNo   		= $_GET["strGenGrnNo"];
	$intGRNYear			= $_GET["intBulkGrnYear"];
	$reason				= $_GET["reason"];
	$dtmDate = date('Y-m-d');

	$sql = "select * from gengrndetails where strGenGrnNo='$intGrnNo' and intYear='$intGRNYear' ";
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		//start check stock availability
		$matDetailId = $row["intMatDetailID"];
		$CostCenterId = $row["intCostCenterId"];
		$GLAllowId = $row["intGLAllowId"];
		
		$sql_s = "select sum(st.dblQty) as stockQty from genstocktransactions st where intMatDetailId='$matDetailId' and intGRNNo='$intGrnNo' and intGRNYear='$intGRNYear' and intCostCenterId='$CostCenterId' and intGLAllowId='$GLAllowId' ";
		$result_s = $db->RunQuery($sql_s);	
		$row_s = mysql_fetch_array($result_s);
		
		if($row_s["stockQty"]<$row["dblQty"])
		{
			echo "Some items not in stock . So you can't cancel GRN No. \"$intGRNYear/$intGrnNo\"";
			return;
		}
		
		//end check stock availability
		
		//start Check MRN availability
		
		$sql_m = " select sum(mrd.dblQty) as mrnQty from genmatrequisitiondetails mrd inner join genmatrequisition mrn on
mrn.intMatRequisitionNo = mrd.intMatRequisitionNo and mrn.intMRNYear = mrd.intYear
where mrn.intCostCenterId='$CostCenterId' and mrd.strMatDetailID='$matDetailId' and mrd.intGRNNo='$intGrnNo' and mrd.intGRNYear='$intGRNYear' and intGLAllowId='$GLAllowId' ";
		$result_m = $db->RunQuery($sql_m);	
		$row_m = mysql_fetch_array($result_m);
		
		if($row_m["mrnQty"]>0)
		{
			echo "Items already MRN. Can't cancel GRN ";
			return;

		}
		
		//end Check MRN availability
	}
	
	//insert stock minus record
	$sql_st = " select * from genstocktransactions where intDocumentNo='$intGrnNo' and  intDocumentYear= '$intGRNYear' ";
	$result_st = $db->RunQuery($sql_st);
	while($row_st = mysql_fetch_array($result_st))
	{
		$strMainStoresID = $row_st["strMainStoresID"];
		$intMatDetailId  = $row_st["intMatDetailId"];
		$strType		 = $row_st["strType"];
		$strUnit		 = $row_st["strUnit"];
		$intCostCenterId = $row_st["intCostCenterId"];
		$intGLAllowId    = $row_st["intGLAllowId"];
		$intYear = date('Y');
		
		$stockQty = $row_st["dblQty"]*-1;
		
		
		$sql_s = " insert into genstocktransactions (intYear,strMainStoresID,intDocumentNo,intDocumentYear, intMatDetailId,strType, strUnit, dblQty,dtmDate,intUser, intGRNNo,intGRNYear,intCostCenterId, intGLAllowId)
values	('$intYear','$strMainStoresID','$intGrnNo','$intGRNYear','$intMatDetailId','$strType', 
'$strUnit','$stockQty', '$dtmDate','$intUserId','$intGrnNo','$intGRNYear','$intCostCenterId', '$intGLAllowId') ";
		$result_s = $db->RunQuery($sql_s);
	}
	
	//update po details 
	$sql_grn = " select gh.intGenPONo,gh.intGenPOYear,gd.dblQty,gd.intMatDetailID,gd.intCostCenterId,gd.intGLAllowId
from gengrnheader gh inner join gengrndetails gd on
gh.strGenGrnNo = gd.strGenGrnNo and gh.intYear = gd.intYear
where gh.strGenGrnNo='$intGrnNo' and gh.intYear='$intGRNYear' ";
	$result_grn = $db->RunQuery($sql_grn);	
	while($rowG = mysql_fetch_array($result_grn))
	{
		$intGenPONo = $rowG["intGenPONo"];
		$intGenPOYear = $rowG["intGenPOYear"];
		$dblQty = $rowG["dblQty"];
		$intMatDetailID = $rowG["intMatDetailID"];
		$intCostCenterId = $rowG["intCostCenterId"];
		$intGLAllowId = $rowG["intGLAllowId"];
		
		$sql_po = " UPDATE generalpurchaseorderdetails set dblPending = dblPending + $dblQty 
					   WHERE intGenPONo = $intGenPONo 
					   AND intYear=$intGenPOYear 
					   AND intMatDetailID=$intMatDetailID and intCostCenterId='$intCostCenterId' and intGLAllowId='$intGLAllowId'";
		$result_po = $db->RunQuery($sql_po);	
	}	
			
	$SQL =    "UPDATE gengrnheader 
				SET intStatus 			= 10 			,
				    intCancelledBy		= $intUserId	,
				    dtCancelledDate 	= '$dtmDate',
					strCancelledReason = '$reason'
				   WHERE
				       intYear=$intGRNYear 
				   AND strGenGrnNo = '". $intGrnNo ."' ";
				   
			$result = $db->RunQuery($SQL);
			echo $result;			
} 

if ($id=="saveStockTransaction")
{
	$intGrnNo 	= $_GET["intGrnNo"];
	$intYear	= $_GET["intYear"];
	$intUserId	=$_SESSION["UserID"];
	$dtmDate	= date("Y-m-d");
	
	
	//$factoryID = $_SESSION["FactoryID"];
	
	$factoryID  = GetMainStoresID($_SESSION["FactoryID"]);
	
	$arrMatdetID = $_GET["arrMatdetID"];
	$arrQty = $_GET["arrQty"];
	$arrUnit = $_GET["arrUnit"];
	$costcenterID = $_GET["costcenterID"];
	$glAlloID = $_GET["glAlloID"];
	
		$SQL = "";
		 $SQL = "insert into genstocktransactions 
					(intYear, 
					strMainStoresID,
					intDocumentNo, 
					intDocumentYear, 
					intMatDetailId, 
					strType, 
					strUnit, 
					dblQty, 
					dtmDate, 
					intUser,
					intGRNNo,
					intGRNYear,intCostCenterId,intGLAllowId
					)
					values
					('". $intYear ."', 
					'$factoryID',
					'". $intGrnNo ."', 
					'". $intYear ."', 
					'". $arrMatdetID ."', 
					'GRN', 
					'". $arrUnit ."', 
					'". $arrQty ."', 
					now(), 
					'". $intUserId ."',
					'". $intGrnNo ."', 
					'". $intYear ."','$costcenterID','$glAlloID'	
					);";
				$result = $db->RunQuery($SQL);
		
	echo $result;
}
function getExchangeRate($intGrnNo,$intYear)
{
	global $db;
	$sql = "select e.rate
from exchangerate e inner join generalpurchaseorderheader gph on
gph.strCurrency = e.currencyID
inner join gengrnheader ggh on
ggh.intGenPONo = gph.intGenPONo and 
ggh.intGenPOYear = gph.intYear
where ggh.strGenGrnNo = '$intGrnNo' and ggh.intYear='$intYear' and e.intStatus=1";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["rate"];

}

function GetMainStoresID($prmCompanyId){
	
	global $db;
	
	$sql = " SELECT * FROM mainstores WHERE intCompanyId = ".$prmCompanyId;
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result)){		
		return $row['strMainID'];		
	}
}


?>