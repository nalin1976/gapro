<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$intCompanyId		=	$_SESSION["FactoryID"];

//---------Load Gp Number---(save part)------------------------------
if (strcmp($RequestType,"LoadGatePassNo") == 0)
{
$ResponseXML= "<GPass>";
$factoryID = $_GET["factoryID"];
	
	$SQL = "SELECT PH.intYear,PH.intGPnumber,PH.dtmDate,O.strStyle,O.strOrderNo
	FROM productiongpheader PH
	inner join productiongpdetail PD on PH.intGPnumber=PD.intGPnumber AND PH.intYear=PD.intYear
	inner join orders O on O.intStyleId=PH.intStyleId
	where PH.intTofactory='".$factoryID."' AND PD.dblBalQty >0 
	group by PH.intGPnumber 
	order by PH.intYear DESC,PH.intGPnumber DESC ";
	$result = $db->RunQuery($SQL);
	$ResponseXML .= "<gatePass>";
	$ResponseXML .= "<![CDATA[";
	$ResponseXML .= "<option value=\"". "" ."\">" . "Select One" . "</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intYear"] ."/".$row["intGPnumber"] ."\">" . $row["intYear"] ."/".$row["intGPnumber"]." : ".$row["dtmDate"]." : ".$row["strStyle"]." : ".$row["strOrderNo"]."</option>";
	}
$ResponseXML .= "]]>";
$ResponseXML .= "</gatePass>";
$ResponseXML .=  "</GPass>";
echo $ResponseXML;	
}
//---------Load Style---(View part)------------------------------
if (strcmp($RequestType,"LoadStyle") == 0)
{
$ResponseXML= "<ldStyles>";
$styleID = $_GET["styleID"];

	$SQL = "SELECT* FROM orders where intStyleId='".$styleID."' order by strStyle asc";
	$result = $db->RunQuery($SQL);
	$k=0;
	$ResponseXML .= "<style>";
	$ResponseXML .= "<![CDATA[";
	while($row = mysql_fetch_array($result))
	{
		if($k==0){
	$ResponseXML .= "<option value=\"". "" ."\">" . "Select One" . "</option>" ;
	}
	$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";

	$k++;
}
$ResponseXML .= "]]>";
$ResponseXML .= "</style>";
$ResponseXML .=  "</ldStyles>";
echo $ResponseXML;	
}
if (strcmp($RequestType,"LoadGPHeader") == 0)
{
$ResponseXML    = "<GatePass>";
$factoryID 		= $_GET["factoryID"];
$gatePassNo 	= $_GET["gatePassNo"];
$arrGPNo 		= explode('/',$gatePassNo);
$GPNumber 		= $arrGPNo[1];
$GPYear 		= $arrGPNo[0];
			
	$SQL = "SELECT intGPnumber,dtmDate,intYear FROM productiongpheader where intGPnumber='".$GPNumber."' and  intYear='".$GPYear."' order by intFromFactory asc";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<GpNoteNo><![CDATA[" . $row["intGPnumber"]  . "]]></GpNoteNo>\n";
		$ResponseXML .= "<GpDate><![CDATA[" . $row["dtmDate"]  . "]]></GpDate>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intYear"]  . "]]></Year>\n";
		$ResponseXML .= "<FromFactory><![CDATA[" . $factoryID  . "]]></FromFactory>\n";
	}
$ResponseXML .= "</GatePass>";
echo $ResponseXML;
}
//--------Load Grid---(save part)--------------------------------------------
if (strcmp($RequestType,"LoadGPDetailsGrid") == 0)
{
$ResponseXML 	= "<EventsforLeadTime>";

$gatePassNo  	= $_GET["gatePassNo"];
$arrGPNo 		= explode('/',$gatePassNo);
$GPNumber 		= $arrGPNo[1];
$GPYear 	 	= $arrGPNo[0];
	
//if searching-------------------
$searchYear 	= $_GET["searchYear"];
$searchTransf 	= $_GET["searchTransf"];

	if(($searchYear!="") AND ($searchTransf!=""))
	{
		$sqlSearch ="SELECT 
		PGH.intFromFactory,
		PGH.dtmDate,
		PGH.intYear,
		PTIH.intFactoryId,
		C.strName,
		C.strCity,
		PTIH.intGPnumber,
		PTIH.dtmGPTransferInDate,
		O.strOrderNo,
		O.strStyle
		From productiongptinheader PTIH
		JOIN productiongpheader PGH ON PGH.intGPnumber=PTIH.intGPnumber and PGH.intYear=PTIH.intGPYear 
		JOIN companies C ON C.intCompanyID=PTIH.intFactoryId
		inner join orders O on O.intStyleId=PGH.intStyleId
		WHERE PTIH.intGPTYear = '".$searchYear."' AND PTIH.dblCutGPTransferIN = '".$searchTransf."'";	
		$result= $db->RunQuery($sqlSearch);
		$row = mysql_fetch_array($result);
		
		$GPTransferInDateT 	= $row["dtmGPTransferInDate"];
		$AppDateFromArray	= explode('-',$GPTransferInDateT);
		$GPTransferInDateT;
		$GPTransferInDate 	= $AppDateFromArray[2]."/".$AppDateFromArray[1]."/".$AppDateFromArray[0];
		
	 		$ResponseXML   .= "<fromFactory><![CDATA[" .  $row["intFactoryId"]  . "]]></fromFactory>\n";
	 		$ResponseXML   .= "<tofactory><![CDATA[". $row["intFactoryId"] ."]]></tofactory>\n";
	 		$ResponseXML   .= "<gatePassNo><![CDATA[" . $row["intYear"]."/".$row["intGPnumber"] . "]]></gatePassNo>\n";
			$ResponseXML   .= "<gatePassNoCombo><![CDATA[<option value=\"". $row["intYear"]."/".$row["intGPnumber"]."\">" . $row["intYear"]."/".$row["intGPnumber"].":".$row["dtmDate"].":".$row["strStyle"].":".$row["strOrderNo"] ."</option>]]></gatePassNoCombo>\n";
	 		$ResponseXML   .= "<date><![CDATA[" . $GPTransferInDate . "]]></date>\n";
		 	$ResponseXML   .= "<Year><![CDATA[" . $row["intYear"]  . "]]></Year>\n";
	 		$ResponseXML   .= "<gpNoteDate><![CDATA[" . $row["dtmDate"] . "]]></gpNoteDate>\n";
	}
	
	if(($searchYear!="") AND ($searchTransf!=""))
	{
/*BEGIN - 21-10-2011 - Comment this line becuase this inner join will duplocate data
		$sql ="SELECT
		productiongptindetail.dblQty,
		productiongptindetail.strRemarks,
		productiongpdetail.dblBalQty,
		productiongpdetail.dblQty AS GPQty,
		productiongptindetail.dblBundleNo,
		productiongptindetail.intCutBundleSerial,
		productionbundledetails.strSize,
		productionbundledetails.strNoRange,
		productionbundledetails.strShade,
		productionbundleheader.strCutNo,
		productionbundleheader.strColor,
		orders.strOrderNo,
		orders.strStyle
		FROM
		productiongptindetail
		Inner Join productiongpdetail ON productiongptindetail.intCutBundleSerial = productiongpdetail.intCutBundleSerial AND productiongptindetail.dblBundleNo = productiongpdetail.dblBundleNo
		Inner Join productionbundledetails ON productiongptindetail.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productiongptindetail.dblBundleNo = productionbundledetails.dblBundleNo
		Inner Join productionbundleheader ON productiongptindetail.intCutBundleSerial = productionbundleheader.intCutBundleSerial
		Inner Join orders ON productionbundleheader.intStyleId = orders.intStyleId
		WHERE
		productiongptindetail.dblCutGPTransferIN =  '$searchTransf' AND
		productiongptindetail.intGPTYear =  '$searchYear'";
END - 21-10-2011 - Comment this line becuase this inner join will duplocate data
*/
//BEGIN - 21-10-2011 - Add this query by comment the above query
		$sql="SELECT
		PGTD.dblQty,
		PGTD.strRemarks,
		PGD.dblBalQty,
		PGD.dblQty AS GPQty,
		PGTD.dblBundleNo,
		PGTD.intCutBundleSerial,
		PBD.strSize,
		PBD.strNoRange,
		PBD.strShade,
		PBH.strCutNo,
		PBH.strColor,
		O.strOrderNo,
		O.strStyle
		FROM
		productiongptindetail PGTD
		inner join productiongptinheader PGTH on PGTH.dblCutGPTransferIN=PGTD.dblCutGPTransferIN
		inner join productiongpheader PGH on PGH.intGPnumber=PGTH.intGPnumber
		Inner Join productiongpdetail PGD ON PGH.intGPnumber = PGD.intGPnumber and PGD.intCutBundleSerial=PGTD.intCutBundleSerial and PGD.dblBundleNo=PGTD.dblBundleNo
		Inner Join productionbundledetails PBD ON PGTD.intCutBundleSerial = PBD.intCutBundleSerial AND PGTD.dblBundleNo = PBD.dblBundleNo
		Inner Join productionbundleheader PBH ON PGTD.intCutBundleSerial = PBH.intCutBundleSerial
		Inner Join orders O ON PBH.intStyleId = O.intStyleId
		WHERE
		PGTD.dblCutGPTransferIN =  '$searchTransf' AND
		PGTD.intGPTYear =  '$searchYear'";
//END - 21-10-2011 - Add this query by comment the above query
	 }
	 else
	 {
		$sql =$sql."SELECT
		PGD.intCutBundleSerial,
		PGD.dblBundleNo,
		PGD.dblQty,
		PGD.dblBalQty,
		PBD.strSize,
		PBD.strNoRange,
		PBD.strShade,
		O.strStyle,
		O.strOrderNo,
		PBH.strCutNo,
		PBH.strColor
		FROM
		productiongpdetail PGD
		Inner Join productionbundledetails PBD ON PGD.intCutBundleSerial = PBD.intCutBundleSerial AND PGD.dblBundleNo = PBD.dblBundleNo
		Inner Join productionbundleheader PBH ON PBD.intCutBundleSerial = PBH.intCutBundleSerial
		Inner Join orders O ON PBH.intStyleId = O.intStyleId
		WHERE
		PGD.intYear =  '$GPYear' AND
		PGD.intGPnumber =  '$GPNumber' AND
		PGD.dblBalQty >0";
	}	
	$result= $db->RunQuery($sql);
	$remark='';
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<poNo><![CDATA[" .  $row["strOrderNo"]  . "]]></poNo>\n";
		$ResponseXML .= "<Style><![CDATA[" . $row["strStyle"] . "]]></Style>\n";
		$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"] . "]]></StyleID>\n";
		$ResponseXML .= "<CutNo><![CDATA[" .  $row["strCutNo"]  . "]]></CutNo>\n";
		$ResponseXML .= "<Size><![CDATA[" .  $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<status><![CDATA[" .  $row["intCutBundleSerial"]  . "]]></status>\n";
		$ResponseXML .= "<Remarks><![CDATA[" .  $row["intCutBundleSerial"]  . "]]></Remarks>\n";
		if(($searchYear!="") AND ($searchTransf!=""))
		{
			$ResponseXML .= "<GPPC><![CDATA[" . $row["GPQty"]  . "]]></GPPC>\n";
			$ResponseXML .= "<Recieved><![CDATA[" .  $row["dblQty"]  . "]]></Recieved>\n";
			$ResponseXML .= "<BalanceQty><![CDATA[" .  $row["dblBalQty"]  . "]]></BalanceQty>\n";
			$ResponseXML .= "<remarks><![CDATA[" .  $row["strRemarks"]  . "]]></remarks>\n";
			$ResponseXML .= "<color><![CDATA[" .  $row["strColor"]  . "]]></color>\n";
		}
		else
		{
			$ResponseXML .= "<GPPC><![CDATA[" . $row["dblQty"]  . "]]></GPPC>\n";
			$ResponseXML .= "<Recieved><![CDATA[" .  $row["dblBalQty"]  . "]]></Recieved>\n";
			$ResponseXML .= "<BalanceQty><![CDATA[" .  $row["dblBalQty"]  . "]]></BalanceQty>\n";
			$ResponseXML .= "<remarks><![CDATA[" .  $remark . "]]></remarks>\n";
			$ResponseXML .= "<color><![CDATA[" .  $row["strColor"]  . "]]></color>\n";
		}
		$ResponseXML .= "<CutBundleSerial><![CDATA[" .  $row["intCutBundleSerial"]  . "]]></CutBundleSerial>\n";
		$ResponseXML .= "<BundleNo><![CDATA[" .  $row["dblBundleNo"]  . "]]></BundleNo>\n";
	}
$ResponseXML .= "</EventsforLeadTime>";
echo $ResponseXML;	
}
//--------Load Grid---(View part)--------------------------------------------
if (strcmp($RequestType,"LoadGPDetailsGridShow") == 0)
{
$ResponseXML	= "<GridShow>";
$year 			= $_GET["year"];
$styleID 		= $_GET["style"];
$TrnfInNote 	= $_GET["TrnfInNote"];
	
	$result=LoadDetailsToView($year,$styleID,$TrnfInNote);
	while($row = mysql_fetch_array($result))
	{	  
		$ResponseXML .= "<date><![CDATA[" .  $row["dtmGPTransferInDate"]  . "]]></date>\n";
		$ResponseXML .= "<factory><![CDATA[" . $row["strName"] . "]]></factory>\n";
		$ResponseXML .= "<pONo><![CDATA[" .  $row["strOrderNo"]  . "]]></pONo>\n";
		$ResponseXML .= "<StyleID><![CDATA[" .  $row["intStyleId"]  . "]]></StyleID>\n";
		$ResponseXML .= "<GpNo><![CDATA[" . $row["intGPnumber"]  . "]]></GpNo>\n";
	}
$ResponseXML .= "</GridShow>";
echo $ResponseXML;	
}

function LoadDetailsToView($year,$styleID,$TrnfInNote)
{
global $db;
	$sql = "SELECT DISTINCT
	productiongptinheader.dtmGPTransferInDate,companies.strName, orders.strOrderNo,productiongpheader.intStyleId,productiongpdetail.intGPnumber
	FROM orders
	inner join productionbundleheader ON orders.intStyleId = productionbundleheader.intStyleId
	inner join productiongpdetail ON productionbundleheader.intCutBundleSerial = productiongpdetail.intCutBundleSerial
	inner join productiongptindetail ON productiongpdetail.intCutBundleSerial = productiongptindetail.intCutBundleSerial
	AND productiongpdetail.dblBundleNo = productiongptindetail.dblBundleNo
	inner join productiongptinheader ON productiongptindetail.dblCutGPTransferIN = productiongptinheader.dblCutGPTransferIN
	inner join productiongpheader ON orders.intStyleId = productiongpheader.intStyleId
	inner join companies ON productiongpheader.intFromFactory = companies.intCompanyID
	WHERE productiongptinheader.intGPYear = '".$year."' and productiongpheader.intStyleId = '".$styleID."' and productiongptinheader.dblCutGPTransferIN = '".$TrnfInNote."'";
return $db->RunQuery($sql);
}
//--------------Save productiontinheader------------------------------------------------------------
if (strcmp($RequestType,"SaveCutPCTransferINHeader") == 0)
{
	$CutGPTransferIN = $_GET["CutGPTransferIN"];
	$GPTYear = $_GET["GPTYear"];
	$GPnumber = $_GET["GPnumber"];
	$GPYear = $_GET["GPYear"];
	$GPTransferInDateT = $_GET["GPTransferInDate"];
	$AppDateFromArray		= explode('/',$GPTransferInDateT);
	$GPTransferInDateT;
	$GPTransferInDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	$Status = $_GET["Status"];
	$User = $_GET["User"];
	$PrintStatus = $_GET["PrintStatus"];
	$TotQty = 0;
	$TotBalQty = 0;
	$toFactory = $_GET["toFactory"];
	
	
	$arrGPNo = explode('/',$GPnumber);
	$gatePassNo = $arrGPNo[1];
	$gatePassYear = $arrGPNo[0];
	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchTransf = $_GET["searchTransf"];
	//--------------------
	 
	if (($searchYear!="") AND ($searchTransf!=""))
	{
		$CutGPTransferIN=$searchTransf;	
		$GPTYear=$searchYear;
		$result=UpdateCutPCTransferINHeader($CutGPTransferIN,$GPTYear,$gatePassNo,$gatePassYear,$GPTransferInDate,$Status,$User,$PrintStatus,$TotQty,$TotBalQty);
	}
	else
	{
		$CutGPTransferIN=SelectMaxTrnsfInNo();
		$searchYear = date("Y");	
		$result=SaveCutPCTransferINHeader($CutGPTransferIN,$searchYear,$gatePassNo,$gatePassYear,$GPTransferInDate,$Status,$User,$PrintStatus,$TotQty,$TotBalQty,$toFactory);
		//update pruductiongphear for status	
	}	 
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 	$ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 	$ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	 $ResponseXML .= "<cutGPTrnsfIn><![CDATA[" . $CutGPTransferIN  . "]]></cutGPTrnsfIn>\n";
	 $ResponseXML .= "<cutGPTrnsfInYear><![CDATA[" . $searchYear  . "]]></cutGPTrnsfInYear>\n";
	 $ResponseXML .= "</Result>";	 
echo $ResponseXML;
}

function SaveCutPCTransferINHeader($CutGPTransferIN,$GPTYear,$GPnumber,$GPYear,$GPTransferInDate,$Status,$User,$PrintStatus,$TotQty,$TotBalQty,$toFactory)
{
global $db;
	$sql= "INSERT INTO productiongptinheader(dblCutGPTransferIN,intGPTYear,intGPnumber,intGPYear,dtmGPTransferInDate,intStatus,dblUser,intPrintStatus,dblTotQty,dblTotBalQty,intFactoryId) VALUES($CutGPTransferIN,$GPTYear,$GPnumber,$GPYear,'$GPTransferInDate',$Status,$User,$PrintStatus,$TotQty,$TotBalQty,$toFactory)";
	return $db->RunQuery($sql);
}

function UpdateCutPCTransferINHeader($CutGPTransferIN,$GPTYear,$GPnumber,$GPYear,$GPTransferInDate,$Status,$User,$PrintStatus,$TotQty,$TotBalQty)
{
global $db;
	$sql= "UPDATE productiongptinheader SET  intGPnumber='$GPnumber',intGPYear='$GPYear',dtmGPTransferInDate='$GPTransferInDate',intStatus='$Status',dblUser='$User',intPrintStatus='$PrintStatus' WHERE dblCutGPTransferIN='$CutGPTransferIN' AND intGPTYear='$GPTYear'";
	return $db->RunQuery($sql);
}

function CheckExistHeader($GPTYear,$GPnumber,$toFactory)
{
global $db;
	$sql= "select * from productiongptinheader where intGPTYear = '". $GPTYear ."' AND intGPnumber= '". $GPnumber ."' AND intFactoryId= '". $toFactory ."'";
	return $db->RunQuery($sql);
}

function CheckExistDetails($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo)
{
$exitQty="";
global $db;
	$sql= "select * from productiongptindetail where dblCutGPTransferIN = ". $CutGPTransferIN ." AND intGPTYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["dblQty"];
	return $exitQty;
}
//-------------save Productiontindetails---------------------------------------------------
if (strcmp($RequestType,"SaveCutPCTransferINDetails") == 0)
{
$CutGPTransferIN 	= $_REQUEST["CutGPTransferIN"];
$year 				= $_REQUEST["year"];
$GPnumber 			= $_REQUEST["GPnumber"]; 
$cutBundleSerial 	= $_REQUEST["CutBundleSerial"];
$bundleNo 			= $_REQUEST["BundleNo"];
$Qty 				= $_REQUEST["Qty"];
$balQty 			= $_REQUEST["BalQty"];
$remark 			= $_REQUEST["ArrRemarks"];

//for wip-----
$trnsType			= "TIN";
$styleID 			= $_REQUEST["styleID"];
$factory 			= $_REQUEST["factory"];
	
$GPTransferInDateT 	= $_REQUEST["date"];
$AppDateFromArray	= explode('/',$GPTransferInDateT);
$GPTransferInDateT;
$date 				= $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
$totQty				= 0;
$totBalQty			= 0;
	
$arrGPnumber		= explode('/',$GPnumber);
$GPNo 				= $arrGPnumber[1];
$GPYear 			= $arrGPnumber[0];

//if $ExistQty !=0 means already saved record and then shd update.
$AllreadyExist 		= false;
$ExistQty = CheckExistDetails($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo);
if ($ExistQty != "")//update productiongptindetail
{
	$resultDetail = UpdateCutPCTransferINDetails($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo,$Qty,$ExistQty,$remark);
	updategpdetailForBalQty($GPNo,$Qty,$cutBundleSerial,$bundleNo,$ExistQty,$GPYear);
	$wipQty = $Qty-$ExistQty;
	update_production_wip($factory,$cutBundleSerial,"intCutReceiveQty",$wipQty);
	$totQty += $Qty;
	$totBalQty += $balQty;
}
else
{ //save productiongptindetail-------
	$ExistQty=0;
	$resultDetail = SaveCutPCTransferINDetails($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo,$Qty,$Qty,$remark);
	updategpdetailForBalQty($GPNo,$Qty,$cutBundleSerial,$bundleNo,$ExistQty,$GPYear);
	update_production_wip($factory,$cutBundleSerial,"intCutReceiveQty",$Qty);		 
	$totQty += $Qty;
	$totBalQty += $balQty;
}
//-----------------Update Header file for totQty & totBalQty------------------------------------------
	updatePruductiongpheaderQty($CutGPTransferIN,$year,$totQty);	
	
$ResponseXML = "<data>";
$ResponseXML .= "<result><![CDATA[" . $resultDetail  . "]]></result>\n";
$ResponseXML .= "</data>";
echo $ResponseXML;	
}

function SelectMaxTrnsfInNo()
{
global $db;
$intCompanyId =	$_SESSION["FactoryID"];

	$sql1 = "SELECT MAX(dblCutGPTransferIN) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result = $db->RunQuery($sql1);	
	$row = mysql_fetch_array($result);
	$old = $row[0];
	$newTrnsfIn = $old+1;
	updateSysControl($old,$newTrnsfIn);
	return $old; 
}
//------update syscontrol for dblCutGPTransferIN-----------------------------------------------
function updateSysControl($old,$newTrnsfIn){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls = "UPDATE syscontrol SET dblCutGPTransferIN='$newTrnsfIn' WHERE dblCutGPTransferIN='$old' and  intCompanyID='$intCompanyId'";
	$db->executeQuery($sqls);
}
//-----------------update gptinheader for Qty & balQty------------------------------------------
function updatePruductiongpheaderQty($CutGPTransferIN,$year,$totQty){
global $db;
	
	 $sql2= "select dblQty,dblBalQty from productiongptindetail where dblCutGPTransferIN = '". $CutGPTransferIN ."' AND intGPTYear= '". $year ."'";
	$result2 = $db->RunQuery($sql2);
	$k=0;
	 while($row = mysql_fetch_array($result2))
  	 {	  
		 if($k==0){
			$totQty=0;
			$totBalQty=0;
		 }
		$totQty += $row["dblQty"];
		$totBalQty += $row["dblBalQty"];
		$k++;
	 }
	
	 $sql= "UPDATE productiongptinheader SET dblTotQty='$totQty',dblTotBalQty='$totBalQty' WHERE dblCutGPTransferIN='$CutGPTransferIN' AND intGPTYear='$year'";
	 	$db->executeQuery($sql);
}
//--------hem(20/09/2010)--update gpdetail for bal Qty----------------------
function updategpdetailForBalQty($GPnumber,$Qty,$cutBundleSerial,$bundleNo,$exitQty,$year){
global $db;
	
	 $sql2= "select dblBalQty from productiongpdetail where intGPnumber = '". $GPnumber ."' AND intCutBundleSerial= '". $cutBundleSerial ."' AND dblBundleNo= '". $bundleNo ."' AND intYear= '". $year ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$balQty = $exitQty+$row["dblBalQty"]-$Qty;
	
	 $sql= "UPDATE productiongpdetail SET dblBalQty='$balQty' where intGPnumber = '". $GPnumber ."' AND intCutBundleSerial= '". $cutBundleSerial ."' AND dblBundleNo= '". $bundleNo ."' AND intYear= '". $year ."'";
	 	$db->executeQuery($sql);
}
//-----hem(20/09/2010)----update gpheader for tot balQty------------------
function updategpdheaderForBalQty($GPnumber,$Qty,$exitQty){
global $db;
	
	$sql2 = "select dblTotBalQty from productiongpheader where intGPnumber = '". $GPnumber ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$balQty = $exitQty+$row["dblTotBalQty"]-$Qty;
	
	$sql= "UPDATE productiongpheader SET dblTotBalQty='$balQty' where intGPnumber = '". $GPnumber ."'";
	$db->executeQuery($sql);
}

function SaveCutPCTransferINDetails($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo,$Qty,$balQty,$remarks)
{
global $db;
	
	$sql2 = "select MAX(dblBalQty) from productiongptindetail where intGPTYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$MaxbalQty = $row["MAX(dblBalQty)"]+$Qty;
	
	$sql1 = "INSERT INTO productiongptindetail(dblCutGPTransferIN,intGPTYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,strRemarks) VALUES($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo,$Qty,$MaxbalQty,'$remarks')";
	$db->RunQuery($sql1);
	
	$sql = "UPDATE productiongptindetail SET  dblBalQty= ". $MaxbalQty ." where intGPTYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	return $db->RunQuery($sql);
	
}

function UpdateCutPCTransferINDetails($CutGPTransferIN,$year,$cutBundleSerial,$bundleNo,$Qty,$ExistQty,$remark)
{
global $db;
	$sql = "UPDATE productiongptindetail SET  dblQty='$Qty' , strRemarks='$remark'
	where dblCutGPTransferIN = ". $CutGPTransferIN ." AND intGPTYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	$db->RunQuery($sql);
	
	$sql2 = "UPDATE productiongptindetail SET dblBalQty=(dblBalQty+'$Qty'-'$ExistQty') where intGPTYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	return $db->RunQuery($sql2);
}
?>