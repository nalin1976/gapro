<?php
include "Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<order>";

$RequestType = $_GET["StyleID"];
$OperationType=$_GET["RequestType"];

if($OperationType=="getEstyy")
{
    $SQL="SELECT matitemlist.strItemDescription,orderdetails.reaConPc FROM orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial WHERE orderdetails.intStyleId = '".$RequestType."' AND matitemlist.intMainCatID = '1';";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<Estyy><![CDATA[" . $row["reaConPc"]  . "]]></Estyy>\n";
		 $ResponseXML .= "<Material><![CDATA[" . $row["strItemDescription"]  . "]]></Material>\n";
    
	}
	 $ResponseXML .= "</order>";
	 echo $ResponseXML;
}
elseif (strcmp($OperationType,"saveStyleDetails") == 0)//OK
{
		$StyleID 		=$_GET["StyleID"];
		$dblcm 			=$_GET["dblcm"];
		$dblQty 			=$_GET["dblQty"];
		$dtPLNDCutDate	=$_GET["dtPLNDCutDate"];
		$ActCutDate		=$_GET["ActCutDate"];
		$PLNDInputDate	=$_GET["PLNDInputDate"];
		$ActInputDate		=$_GET["ActInputDate"];
		$PLNDFinishDate	=$_GET["PLNDFinishDate"];
		$ActShipmentDate	=$_GET["ActShipmentDate"];
		$ShipmentQTY 		=$_GET["ShipmentQTY"];
		$plus_mines		=$_GET["plus_mines"];
		$FebPO			=$_GET["FebPO"];
		$SMPL_YDG_RCVD 	=$_GET["SMPL_YDG_RCVD"];
		$Lab_Dip_Aprvd 	=$_GET["Lab_Dip_Aprvd"];
		$Fab_Test_Sent 	=$_GET["Fab_Test_Sent"];
		$Feb_tet_Passd 	=$_GET["Feb_tet_Passd"];
		$Bulk_Approved 	=$_GET["Bulk_Approved"];
		$Fab_Inspect 		=$_GET["Fab_Inspect"];
		$PITN_ORG_SMP_TGT =$_GET["PITN_ORG_SMP_TGT"];
		$PTTD_RCVD 		=$_GET["PTTD_RCVD"];
		$ORG_SMPL_RCVD	=$_GET["ORG_SMPL_RCVD"];
		$SIZE_QTY 		=$_GET["SIZE_QTY"];
		$SIZE_SIZE 		=$_GET["SIZE_SIZE"];
		$SIZE_TGT 		=$_GET["SIZE_TGT"];
		$SIZE_SENT 		=$_GET["SIZE_SENT"];
		$SIZE_APVD 		=$_GET["SIZE_APVD"];
		$GoldSeal_SIZE 	=$_GET["GoldSeal_SIZE"];
		$GoldSeal_TGT 	=$_GET["GoldSeal_TGT"];
		$GoldSeal_SENT 	=$_GET["GoldSeal_SENT"];
		$GoldSeal_APVD 	=$_GET["GoldSeal_APVD"];
		$GoldSeal_QTY 	=$_GET["GoldSeal_QTY"];
		$TESTING_QTY 		=$_GET["TESTING_QTY"];
		$TESTING_SIZE 	=$_GET["TESTING_SIZE"];
		$TESTING_TGT 		=$_GET["TESTING_TGT"];
		$TESTING_SENT 	=$_GET["TESTING_SENT"];
		$TESTING_APVD		=$_GET["TESTING_APVD"];
		
		
		$ResponseXML = "";
		$ResponseXML .= "<StyleDataSaved>\n";

		if(SaveStyleDetails($StyleID,$dblcm,$dblQty,$dtPLNDCutDate,$ActCutDate,$PLNDInputDate,		$ActInputDate,$PLNDFinishDate,$ActShipmentDate,$ShipmentQTY,$plus_mines,$FebPO,$SMPL_YDG_RCVD,		$Lab_Dip_Aprvd,$Fab_Test_Sent,$Feb_tet_Passd,$Bulk_Approved,$Fab_Inspect,$PITN_ORG_SMP_TGT,$PTTD_RCVD,	$ORG_SMPL_RCVD,$SIZE_QTY,$SIZE_SIZE,$SIZE_TGT,$SIZE_SENT,$SIZE_APVD,$GoldSeal_SIZE,$GoldSeal_TGT,$GoldSeal_SENT,$GoldSeal_APVD,$GoldSeal_QTY,$TESTING_QTY,$TESTING_SIZE,$TESTING_TGT,$TESTING_SENT,		$TESTING_APVD))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 
		$ResponseXML .= "</StyleDataSaved>";
		echo $ResponseXML;
		
	
	
}
	//---------------------------------
elseif($OperationType=="GetNoOfStyles")
{
	$companyID	= $_GET["companyID"];
	$buyerID	= $_GET["buyerID"];
	$styleID	= $_GET["styleID"];
	$chkDate	= $_GET["chkDate"];
	$date		= $_GET["date"];
		$dateArray 	= explode('/',$date);
		$FormatDate 	= $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
	$no="";
	$no .="<GetNoOfStyles>";
	$sqlNOOfstyles="SELECT  O.intStyleId AS countStyle FROM  orders O ".
						"INNER JOIN buyers ON O.intBuyerID = buyers.intBuyerID ".
						"inner join deliveryschedule on deliveryschedule.intStyleId=O.intStyleId ".
						"WHERE  O.intStatus <>13";
					if($companyID!="")							
						$sqlNOOfstyles .=" AND O.intCompanyID = '$companyID'";
					if($buyerID!="")
						$sqlNOOfstyles .=" AND O.intBuyerID='$buyerID'";
					if($styleID!="")
						$sqlNOOfstyles .="AND O.intStyleId LIKE '$styleID%'";
					if($date!="")
						$sqlNOOfstyles .="AND dtDateofDelivery = '$FormatDate'";
						
	//echo 	$sqlNOOfstyles;				
	$result=$db->RunQuery($sqlNOOfstyles);
	
	while($row=mysql_fetch_array($result))
	{
		$no .= "<styleID><![CDATA[" . $row["countStyle"]  . "]]></styleID>\n";		
		
	}
	$no .="</GetNoOfStyles>";
	echo $no;
}
	//-----------------------------------
	function SaveStyleDetails() //OK
	{
	
		global $db;
	
/*	$SQL = "select intCompanyID from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$userFactory= $row["intCompanyID"];
	}
		$userID= $_SESSION["UserID"];*/
		
		$strSQL="";	
		$db->ExecuteQuery($strSQL);
		return true;
	}
?>