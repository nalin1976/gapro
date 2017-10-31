<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType 		= $_GET["RequestType"];
$intCompanyId		= $_SESSION["FactoryID"];
$userId				= $_SESSION["UserID"];
//------------Load Po No And Style No------------------------------------------------
if (strcmp($RequestType,"loadPoNoAndStyle") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	$gatePassNo = $_GET["gatePassNo"];
	$arrGPNo = explode('/',$gatePassNo);
	$GPNumber = $arrGPNo[1];
	$GPYear = $arrGPNo[0];
	
	if($GPNumber==""){
	$sql = "SELECT 
	productionfggpheader.intStyleId, 
	orders.strStyle,
	productionfggpheader.strFromFactory,
	orders.strOrderNo 
	FROM
	  productionfggpheader  LEFT JOIN orders ON productionfggpheader.intStyleId = orders.intStyleId
	  WHERE productionfggpheader.strFromFactory = '".$factoryID."' 
	  group by productionfggpheader.intStyleId 
	  order by productionfggpheader.intStyleId ASC";
	  }
	  else{
	$sql = "SELECT 
	productionfggpheader.intStyleId, 
	orders.strStyle,
	productionfggpheader.strFromFactory,
	orders.strOrderNo 
	FROM
	  productionfggpheader  LEFT JOIN orders ON productionfggpheader.intStyleId = orders.intStyleId
	  WHERE productionfggpheader.intGPnumber = '".$GPNumber."' and productionfggpheader.intGPYear = '".$GPYear."'  
	  group by productionfggpheader.intStyleId 
	  order by productionfggpheader.intStyleId ASC";
	  }

//echo $sql;

	  global $db;
	  $result = $db->RunQuery($sql);
	  $k=0;
		
	 $ResponseXML1 .= "<style>";
	 $ResponseXML1 .= "<![CDATA[";
	 $ResponseXML1 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	
	 $ResponseXML2 .= "<orderNo>";
	 $ResponseXML2 .= "<![CDATA[";
	 $ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	 
	 $ResponseXML3 .= "<fromFactory>";
	 $ResponseXML3 .= "<![CDATA[";
		
	 while($row = mysql_fetch_array($result))
	 {
	// if($k==0){
	//fddgf	}
		//$ResponseXML .= "\n";
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML2 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		
		$ResponseXML3 .= $row["strFromFactory"];
			
		$k++;
	 }
	// if($k>0){
	$ResponseXML1 .= "]]>"."</style>";
	$ResponseXML2 .= "]]>"."</orderNo>";
	$ResponseXML3 .= "]]>"."</fromFactory>";
	
	// $ResponseXML .= "</cutPC>";
//	 }
	 
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2.$ResponseXML3. "</Styles>";
	 echo $ResponseXML;	
}
//------------Load Po No And Style No---------------------------------------
if (strcmp($RequestType,"loadColor") == 0)
{
$ResponseXML	= "<Styles>";
$factoryID 		= $_GET["factoryID"];
$gatePassNo 	= $_GET["gatePassNo"];
$arrGPNo 		= explode('/',$gatePassNo);
$GPNumber 		= $arrGPNo[1];
$GPYear 		= $arrGPNo[0];
$style 			= $_GET["style"];
	
	if($gatePassNo=="")
	{
	$sql = "SELECT productionbundleheader.strColor
		FROM productionfggpheader  
		JOIN productionfggpdetails ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber 
		JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
		WHERE productionfggpheader.strFromFactory = '".$factoryID."' 
		AND productionfggpheader.intStyleId = '".$style."' 
		group by productionbundleheader.strColor 
		order by productionbundleheader.strColor ASC";
	}
	else
	{
	$sql = "SELECT productionbundleheader.strColor
		FROM productionfggpheader  
		JOIN productionfggpdetails ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber 
		JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
		WHERE productionfggpheader.intGPnumber = '".$GPNumber."' and productionfggpheader.intGPYear = '".$GPYear."' AND productionfggpheader.intStyleId = '".$style."' 
		group by productionbundleheader.strColor 
		order by productionbundleheader.strColor ASC";
	}
	$result = $db->RunQuery($sql);
	$k=0;
	$ResponseXML .= "<OrderQty><![CDATA[" . GetOrderQty($style). "]]></OrderQty>\n";
	$ResponseXML1 .= "<color>";
	$ResponseXML1 .= "<![CDATA[";
	$ResponseXML1 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>";
		$k++;
	 }

	$ResponseXML1 .= "]]>"."</color>";	 
	$ResponseXML = $ResponseXML.$ResponseXML1. "</Styles>";
	echo $ResponseXML;	
}
//--------Load Header to serial no ----------------------------------------------
if (strcmp($RequestType,"LoadHeaderToSerial") == 0)
{
	$ResponseXML= "<Styles>";
	$serial = $_GET["serialNo"];
	$year = $_GET["year"];
	
	 $sql = "SELECT 
			productionfinishedgoodsreceiveheader.dtmTransInDate AS Date,
			productionfinishedgoodsreceiveheader.dblGatePassNo,
			productionfinishedgoodsreceiveheader.intGPYear,
			productionfinishedgoodsreceiveheader.strFComCode,
			productionfinishedgoodsreceiveheader.strTComCode,
			productionfinishedgoodsreceiveheader.intStyleNo,
			productionfinishedgoodsreceiveheader.strRemarks,
			productionbundleheader.strColor,
			orders.strOrderNo,
			orders.strStyle,
			productionfinishedgoodsreceivedetails.intCutBundleSerial,
			productionfinishedgoodsreceivedetails.dblBundleNo,			
			productionbundleheader.strCutNo AS strCutNoDetails
			FROM productionfinishedgoodsreceivedetails
			JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial 			
			JOIN productionbundledetails ON productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo 
			AND productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial 			
			JOIN productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceivedetails.dblTransInNo = productionfinishedgoodsreceiveheader.dblTransInNo			
			LEFT JOIN orders ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId			
			WHERE productionfinishedgoodsreceiveheader.dblTransInNo = '".$serial."' 
			AND productionfinishedgoodsreceiveheader.intGPTYear = '".$year."'";
//removed-(15/09/2010)- (AND productionbundleheader.strStatus!=2)

//echo $sql;

	    global $db;
	    $result = $db->RunQuery($sql);
		
	$k=0;
		$ResponseXML1 .= "<fromFactory>";
		$ResponseXML1 .= "<![CDATA[";
		
		$ResponseXML2 .= "<toFactory>";
		$ResponseXML2 .= "<![CDATA[";
		
		$ResponseXML3 .= "<style>";
		$ResponseXML3 .= "<![CDATA[";
		
		$ResponseXML4 .= "<PoNo>";
		$ResponseXML4 .= "<![CDATA[";

		$ResponseXML7 .= "<color>";
		$ResponseXML7 .= "<![CDATA[";
		
		$ResponseXML5 .= "<cutNo>";
		$ResponseXML5 .= "<![CDATA[";
		
		$ResponseXML6 .= "<date>";
		$ResponseXML6 .= "<![CDATA[";

		$ResponseXML8 .= "<gpNo>";
		$ResponseXML8 .= "<![CDATA[";

		$ResponseXML9 .= "<gpYear>";
		$ResponseXML9 .= "<![CDATA[";
		
		$ResponseXML10 .= "<Remarks>";
		$ResponseXML10 .= "<![CDATA[";
		
	$tempBundle="";	
	$noOfBundle=0;
	$styleNo="";
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML92 = $ResponseXML9.$row["intGPYear"] ;
		$ResponseXML82 = $ResponseXML8.$row["dblGatePassNo"] ;
		$ResponseXML12 = $ResponseXML1.$row["strFComCode"] ;
		$ResponseXML22 = $ResponseXML2.$row["strTComCode"] ;
		$styleNo=$row["intStyleNo"];
		$ResponseXML32 =$ResponseXML3. "<option value=\"". $row["intStyleNo"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML42 =$ResponseXML4. "<option value=\"". $row["intStyleNo"] ."\">" . $row["strOrderNo"] ."</option>";
		$ResponseXML72 =$ResponseXML7. "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>";
		$ResponseXML52 = $ResponseXML5. $row["intCutBundleSerial"];
		$ResponseXML102 = $ResponseXML10. $row["strRemarks"];
		$tmpDateDescT=$row["Date"];
		$ArrayDateDesc = explode('-',$tmpDateDescT);
		//$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$DateDesc =substr($row["Date"],0,10);
		$ResponseXML62 =  $ResponseXML6.$DateDesc ;
		$k++;
	 }
	 

	$ResponseXML12 .= "]]>"."</fromFactory>";
	$ResponseXML22 .= "]]>"."</toFactory>";
	$ResponseXML32 .= "]]>"."</style>";
	$ResponseXML42 .= "]]>"."</PoNo>";
	$ResponseXML52 .= "]]>"."</cutNo>";
	$ResponseXML62 .= "]]>"."</date>";
	$ResponseXML72 .= "]]>"."</color>";
	$ResponseXML82 .= "]]>"."</gpNo>";
	$ResponseXML92 .= "]]>"."</gpYear>";
	$ResponseXML102 .= "]]>"."</Remarks>";
	$ResponseXML103 .= "<OrderQty><![CDATA[" . GetOrderQty($styleNo). "]]></OrderQty>\n";
	 $ResponseXML .=  $ResponseXML12.$ResponseXML22.$ResponseXML32.$ResponseXML42.$ResponseXML52.$ResponseXML62.$ResponseXML72.$ResponseXML82.$ResponseXML92.$ResponseXML102.$ResponseXML103."</Styles>";
	 echo $ResponseXML;	
}

//----------------------------------Load Grids -----------------------------
if (strcmp($RequestType,"loadGrids") == 0)
{
$ResponseXML= "<Grid>";
$ResponseXML=loadGrid1($ResponseXML);
$ResponseXML=loadGrid2($ResponseXML);
$ResponseXML .= "</Grid>";
 echo $ResponseXML;	
}
//-----load first grid-------------------------------------------------------
function loadGrid1($ResponseXML)
{
	$factoryID = $_GET["factoryID"];
	$styleID = $_GET["styleID"];
	$gatePassNo = $_GET["gatePassNo"];
	
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];

if(($searchYear!="") AND ($searchSerialNo!="")){
	  $sql ="SELECT DISTINCT 
	 productionbundleheader.strCutNo,
	 productionfinishedgoodsreceiveheader.dtmTransInDate AS date
	 FROM
	 productionfinishedgoodsreceivedetails
	 
	 JOIN productionfinishedgoodsreceiveheader ON
	  productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo
	 
   JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial= productionfinishedgoodsreceivedetails.intCutBundleSerial
   
     WHERE
     productionfinishedgoodsreceiveheader.intGPTYear = '".$searchYear."' 
	 AND productionfinishedgoodsreceiveheader.dblTransInNo = '".$searchSerialNo."'"; 
	 }
	 else{
	$sql = "SELECT 
	 productionfggpdetails.strCutNo,
	 productionfggpheader.dtmGPDate AS date
	 FROM
	 productionfggpdetails
	 JOIN productionfggpheader
	 ON productionfggpdetails.intGPnumber=productionfggpheader.intGPnumber
     WHERE
     productionfggpheader.strFromFactory = '".$factoryID."' 
	 AND productionfggpheader.intStyleId = '".$styleID."' GROUP BY productionfggpdetails.strCutNo"; 
	 }
	 
//echo $sql;
     global $db;
	  $result = $db->RunQuery($sql);
	  
	 while($row = mysql_fetch_array($result))
	 {
	$ResponseXML .= "<CutNo><![CDATA[" . $row["strCutNo"]  . "]]></CutNo>\n";
	$ResponseXML .= "<Date><![CDATA[" . $row["date"]  . "]]></Date>\n";
	 }
	return $ResponseXML;	
}
//-----load second grid-------------------------------------------------------
function loadGrid2($ResponseXML)
{
	$length=0;
	$factoryID = $_GET["factoryID"];
	$gatePassNo = $_GET["gatePassNo"];
	$arrGPNo = explode('/',$gatePassNo);
	$GPNumber = $arrGPNo[1];
	$GPYear = $arrGPNo[0];
	
	$styleID = $_GET["styleID"];
	$color = $_GET["color"];
	$ArrayCutNos = $_GET["ArrayCutNos"];
	$explodeCutNos = explode(',', $ArrayCutNos) ;
	$length=count($explodeCutNos);
	
		//if searching-------------------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];

	
	  $sql = "SELECT
	 productionbundledetails.strSize,
	 productionbundledetails.dblBundleNo,
	 productionbundledetails.strNoRange,
	 productionbundledetails.strShade,
	 productionbundleheader.strColor,
	 productionbundleheader.strCutNo,
	 productionbundleheader.intCutBundleSerial,";
	 
if(($searchYear!="") AND ($searchSerialNo!="")){
	  $sql =$sql." productionfinishedgoodsreceivedetails.lngRecQty, productionfinishedgoodsreceivedetails.strRemarks,
productionfggpdetails.dblBalQty 
	  FROM
productionfinishedgoodsreceivedetails
Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial
Inner Join productionbundledetails ON productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial
Inner Join productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo
Inner Join productionfggpdetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial AND productionfinishedgoodsreceivedetails.dblBundleNo = productionfggpdetails.dblBundleNo
WHERE
		 productionfinishedgoodsreceiveheader.dblTransInNo = '".$searchSerialNo."' 
		 AND productionfinishedgoodsreceiveheader.intGPTYear = '".$searchYear."'
		 AND productionfggpdetails.intStatus <> 2 ";
		 
}
else{
	 
	$sql=$sql." productionfggpdetails.dblBalQty
	 FROM
	 productionfggpdetails
	 
	 JOIN productionfggpheader
	 ON productionfggpdetails.intGPnumber=productionfggpheader.intGPnumber
	 
	 JOIN productionbundleheader ON
	 productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial 
	 
	 JOIN productionbundledetails ON
	  productionbundledetails.dblBundleNo = productionfggpdetails.dblBundleNo 
	 AND productionbundledetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial 
	 
     WHERE
     productionfggpheader.strFromFactory = '".$factoryID."'";
	 if($gatePassNo!=""){
	 $sql .="AND productionfggpheader.intGPnumber = '".$GPNumber."'"; 
	 $sql .="AND productionfggpheader.intGPYear = '".$GPYear."'"; 
	 }
     $sql .="AND productionfggpdetails.dblBalQty != '0' 
	 AND productionfggpheader.intStyleId = '".$styleID."'"; 
     $sql .="AND productionbundleheader.strColor = '".$color."'"; 
	  if($length>1){
		  for($i = 0 ;$i < $length-1 ; $i ++ ){
		  $sql .=" AND productionfggpdetails.strCutNo = '".trim($explodeCutNos[$i],' ')."'"; 
		  }
	  }
  }
	  
		  $sql .=" GROUP BY  productionbundledetails.dblBundleNo"; 
	  
 //echo $sql;
    global $db;
	$result = $db->RunQuery($sql);
	$remarks = "";
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<CutNo1><![CDATA[" . $row["strCutNo"]  . "]]></CutNo1>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<Bundle><![CDATA[" . $row["dblBundleNo"]  . "]]></Bundle>\n";
		$ResponseXML .= "<Range><![CDATA[" . $row["strNoRange"]  . "]]></Range>\n";
		$ResponseXML .= "<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>\n";
		
	if(($searchYear!="") AND ($searchSerialNo!="")){
		$ResponseXML .= "<GPQty><![CDATA[" . $row["lngRecQty"]  . "]]></GPQty>\n";//$row["dblBalQty"]
		$ResponseXML .= "<ReceiveQty><![CDATA[" . $row["lngRecQty"]  . "]]></ReceiveQty>\n";
		$remarks = $row["strRemarks"];
		}
		else{
		$ResponseXML .= "<GPQty><![CDATA[" . $row["dblBalQty"]  . "]]></GPQty>\n";
		$ResponseXML .= "<ReceiveQty><![CDATA[" . $row["dblBalQty"]  . "]]></ReceiveQty>\n";
		}
		
		$ResponseXML .= "<CutBundserial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundserial>\n";
		$ResponseXML .= "<FromFactory><![CDATA[" . $row["strFromFactory"]  . "]]></FromFactory>\n";
		$ResponseXML .= "<GPNumber><![CDATA[" . $row["intGPnumber"]  . "]]></GPNumber>\n";
		$ResponseXML .= "<GPYear><![CDATA[" . $row["intGPYear"]  . "]]></GPYear>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		
		$ResponseXML .= "<remarks><![CDATA[" . $remarks  . "]]></remarks>\n";
	 }
		$ResponseXML .= "<FromFactory><![CDATA[]]></FromFactory>\n";
		$ResponseXML .= "<GPNumber><![CDATA[]]></GPNumber>\n";
		$ResponseXML .= "<GPYear><![CDATA[]]></GPYear>\n";
		$ResponseXML .= "<TotGPQty><![CDATA[".getGPQty($factoryID,$GPNumber,$GPYear,$styleID,$color)."]]></TotGPQty>\n";
	return $ResponseXML;	
 
}
//----------------save finish goods receive header----------------------
if (strcmp($RequestType,"SaveFinishGoodReceiveHeader") == 0)
{
	
	$fgRcvDateTemp 	= $_GET["fgRcvDate"];
	$fgRcvDateArray	= explode('/',$fgRcvDateTemp);
	$fgRcvDate 		= $fgRcvDateArray[2]."-".$fgRcvDateArray[1]."-".$fgRcvDateArray[0];
	
	$fgRcvYear 		= $_GET["fgRcvYear"];
	$factory 		= $_GET["factory"];
	$toFactory 		= $_GET["toFactory"];
	$styleID 		= $_GET["styleID"];
	$Status 		= $_GET["Status"];
	$totQty 		= $_GET["totQty"];
	$totBalQty 		= $_GET["totBalQty"];
	$FromFactory 	= $_GET["FromFactory"];
	$remarks 		= $_GET["Remarks"];
	$GpNo 			= $_GET["GpNo"];
	$arrGPNo 		= explode('/',$GpNo);
	$GpNo 			= $arrGPNo[1];
	$GPYear 		= $arrGPNo[0];	
	$GPTYear 		= $_GET["GPTYear"];
	
	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];
	//--------------------
	
	 if (($searchYear!="") AND ($searchSerialNo!=""))
	 {
	    $fgRecvTrasfInNo=$searchSerialNo;	
	    $fgRcvYear=$searchYear;
		
	 	$result=UpdateProductionfinishedgoodsreceiveheader($fgRecvTrasfInNo,$factory,$styleID,$fgRcvYear,$fgRcvDate,$remarks);
	 }
	 else
	 {
	   $fgRecvTrasfInNo=SelectMaxFgRecvTrasfInNo();	
	 
	  $result=SaveProductionfinishedgoodsreceiveheader($fgRecvTrasfInNo,$factory,$styleID,$fgRcvYear,$fgRcvDate,$totQty,$totBalQty,$Status,$toFactory,$GpNo,$GPYear,$GPTYear,$remarks);
	   
	 }	 
	
	   
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	 $ResponseXML .= "<fgRcvTrsfInNo><![CDATA[" . $fgRecvTrasfInNo  . "]]></fgRcvTrsfInNo>\n";
	 $ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}
//-------update header file------------------------------------------------------------------
function UpdateProductionfinishedgoodsreceiveheader($fgRecvTrasfInNo,$toFactory,$styleID,$fgRcvYear,$fgRcvDate,$remarks)
{
	global $db;
	$sql= "UPDATE productionfinishedgoodsreceiveheader SET dtmTransInDate='$fgRcvDate',strRemarks='$remarks' WHERE strFComCode='$toFactory' AND intStyleNo='$styleID' AND intGPTYear='$fgRcvYear' AND dblTransInNo='$fgRecvTrasfInNo'";
	return $db->RunQuery($sql);
}

//-------retrieve exis-------------------------------
function SelectMaxFgRecvTrasfInNo(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sql1="SELECT MAX(dblFGReceiveTransIn) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result= $db->RunQuery($sql1);

	$row = mysql_fetch_array($result);
	$old= $row["MAX(dblFGReceiveTransIn)"];
	$newSerial=$old+1;
	
	updateSysControl($old,$newSerial);
	return $old; 
}
//--------update syscontrol for intWashreadySerial(by Adding 1)----------------------
function updateSysControl($old,$newSerial){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET dblFGReceiveTransIn='$newSerial' WHERE dblFGReceiveTransIn='$old' and intCompanyID='$intCompanyId'";
	 $db->executeQuery($sqls);
}
//-------save new record for header-------------------------------
function SaveProductionfinishedgoodsreceiveheader($fgRecvTrasfInNo,$factory,$styleID,$fgRcvYear,$fgRcvDate,$totQty,$totBalQty,$Status,$toFactory,$GpNo,$GPYear,$GPTYear,$remarks)
{

	global $db;
	$sql= "INSERT INTO productionfinishedgoodsreceiveheader(dblTransInNo ,strTComCode ,intStyleNo , intGPTYear ,dtmTransInDate ,dblTotQty, dblBalQty, intStatus, strFComCode,dblGatePassNo,intGPYear,strRemarks,intUser) VALUES($fgRecvTrasfInNo, $toFactory, $styleID, $fgRcvYear, now(), $totQty, $totBalQty, $Status, $factory,$GpNo,$GPYear,'$remarks','".$_SESSION['UserID']."')";
	//echo $sql;
	return $db->RunQuery($sql);
}
//----------------Save finish goods receive Details-------------------------
if (strcmp($RequestType,"SaveFinishGoodReceiveDetails") == 0)
{
	$fgRcvTrsfInNo = $_REQUEST["fgRcvTrsfInNo"];
	$year = $_REQUEST["year"];
	$factory = $_REQUEST["factory"];
	$gpNo = $_REQUEST["gpNo"];
	$arrGPNo = explode('/',$gpNo);
	$gpNo = $arrGPNo[1];
	$styleId = $_REQUEST["StyleId"];
	$ArrayCutBundleSerial = $_REQUEST["ArrayCutBundleSerial"];
	$ArrayBundleNo = $_REQUEST["ArrayBundleNo"];
	$ArrayQty = $_REQUEST["ArrayQty"];
	$ArrayBalQty = $_REQUEST["ArrayBalQty"];
	$ArrayCutNo = $_REQUEST["ArrayCutNo"];
	$ArraySize = $_REQUEST["ArraySize"];
	$ArrayRange = $_REQUEST["ArrayRange"];
	$ArrayShade = $_REQUEST["ArrayShade"];
	$ArrayColor = $_REQUEST["ArrayColor"];
	$ArrRemark = $_REQUEST["ArrRemark"];
	$exe	   = $_REQUEST["rCount"];
 	$noOfRows = $_REQUEST["noOfRows"];
	
	$explodeCutBundleSerial = $ArrayCutBundleSerial ;
	$explodeBundleNo = $ArrayBundleNo ;
	$explodeQty = $ArrayQty;
	$explodeBalQty = $ArrayBalQty ;
	$explodeCutNo = $ArrayCutNo ;
	$explodeSize = $ArraySize ;
	$explodeRange = $ArrayRange ;
	$explodeShade = $ArrayShade ;
	$explodeColor = $ArrayColor ;
	$explodeRemark = $ArrRemark;
	
	//$noOfChecked = count($explodeBundleNo)-1;
	$totQty=0;
	$totBalQty=0;
	$x=0;
	
		/*for ($i = 0;$i < $noOfChecked;$i++)
		{*/
			 $AllreadyExist = false;
			 $ExistQty = CheckExistDetails($fgRcvTrsfInNo,$year,$explodeCutBundleSerial,$explodeBundleNo);
			
			 if ($ExistQty != "")
			 {
	            $result=UpdateProductionfinishedgoodsreceivedetails($fgRcvTrsfInNo,$year,$explodeCutBundleSerial,$explodeBundleNo,$explodeQty,$explodeQty,$ExistQty,$explodeRemark);
				
			 }
			 else{
			   $ExistQty=0;
			 
		       $result=SaveProductionfinishedgoodsreceivedetails($fgRcvTrsfInNo,$year,$explodeCutBundleSerial,$explodeBundleNo,$explodeQty,$explodeQty,$explodeCutNo,$explodeSize,$explodeColor,$explodeShade,$explodeRemark);
			   
			 }
		   
			$totQty = $explodeQty;
			$totBalQty = $explodeBalQty;
			 
		    updateFinishGdGatePassForBalQty($gpNo,$explodeCutBundleSerial,$explodeBundleNo,$ExistQty,$explodeQty,$year);

			$wipQty=$explodeQty[$i]-$ExistQty;
			update_production_wip($factory,$explodeCutBundleSerial,"intFGReceived",$wipQty);	
			 
		 //}// end of for
		
	//Update Productionfggpheader for totQty & totBalQty---------------------------------
	updateProductionfinishedgoodsreceiveheaderQty($fgRcvTrsfInNo,$year,$totQty,$totQty);	
//BEGIN

	if($exe==0){
		$sqlWRF="SELECT DISTINCT productionwashreadyheader.intFactory FROM productionwashreadyheader WHERE productionwashreadyheader.intStyleId = '$styleId';";
	
		$resWRF=$db->RunQuery($sqlWRF);
		$wrFac=array();
		while($row=mysql_fetch_array($resWRF)){
			$wrFac[]=$row['intFactory'];
		}
	
		/*if(count($wrFac)==1){
			InsertToWasStock($totQty,$fgRcvTrsfInNo,$year,$explodeColor,$styleId,$wrFac[0]);
		}
		else{*/
	
			for($i=0;$i<count($wrFac);$i++){
				$cutBNo=array();
				$bNo=array();
				
				$cutBNo=getBundleAndBundleSerials($styleId,$wrFac[$i],'intCutBundleSerial');
				$bNo=getBundleAndBundleSerials($styleId,$wrFac[$i],'dblBundleNo');
				$c=implode(',',$cutBNo);
				$b=implode(',',$bNo);
				$sqlWR=" SELECT p.strCutNo,p.strColor,p.lngRecQty,p.intGPTYear,p.dblTransInNo,h.intStyleNo,p.dblBundleNo,p.intCutBundleSerial
				FROM
				productionfinishedgoodsreceivedetails AS p
				INNER JOIN productionfinishedgoodsreceiveheader AS h ON h.dblTransInNo = p.dblTransInNo AND h.intGPTYear = p.intGPTYear
				WHERE
				p.intGPTYear = '$year' AND
				p.dblTransInNo = '$fgRcvTrsfInNo' 
				and p.intCutBundleSerial in (".$c.") 
				and p.dblBundleNo in (".$b.")
				and h.intStyleNo='$styleId';";
	//echo $sqlWR;
				$resQ=$db->RunQuery($sqlWR);
				$qtyW=0;
				while($rowQ=mysql_fetch_array($resQ)){
					$qtyW+=$rowQ['lngRecQty'];
				}
					InsertToWasStock($qtyW,$fgRcvTrsfInNo,$year,$explodeColor,$styleId,$wrFac[$i]);
			}
		}
	//}
//END
	 $ResponseXML .= "<ResultDetails>";
	 if($result!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 $ResponseXML .= "</ResultDetails>";
	 echo $ResponseXML;	
}
//-------------
function getBundleAndBundleSerials($styleId,$wrFac,$field){
	global $db;
	$sql="select distinct wrd.`$field`  from productionwashreadyheader wrh 
	inner join productionwashreadydetail wrd on wrd.intWashreadySerial=wrh.intWashreadySerial and wrd.intWashReadyYear=wrh.intWashReadyYear
	where wrh.intStyleId='$styleId' and wrh.intFactory='$wrFac';";
			$res=$db->RunQuery($sql);
			$No=array();
			while($row=mysql_fetch_array($res)){
				$No[]	= $row[$field];
				
			}
			//print_r($No);
			return $No;
}
//-------------
//-----check whether record existing in details file-------------------------------------------------------
function CheckExistDetails($fgRcvTrsfInNo,$year,$explodeCutBundleSerial,$explodeBundleNo)
{
	global $db;
	 $sql= "select * from productionfinishedgoodsreceivedetails where dblTransInNo = ". $fgRcvTrsfInNo ." AND intGPTYear= ". $year ." AND intCutBundleSerial = ". $explodeCutBundleSerial ." AND dblBundleNo= ". $explodeBundleNo . " ";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["lngRecQty"];
	return $exitQty;
}
//------Update records in details file------------------------------------------------------------------
function UpdateProductionfinishedgoodsreceivedetails($fgRcvTrsfInNo,$year,$explodeCutBundleSerial,$explodeBundleNo,$explodeQty,$explodeBalQty,$ExistQty,$remarks)
{
	global $db;
    $sql= "UPDATE productionfinishedgoodsreceivedetails SET lngRecQty=$explodeQty, strRemarks = '$remarks' WHERE dblTransInNo = ". $fgRcvTrsfInNo ." AND intGPTYear= ". $year ." AND intCutBundleSerial = ". $explodeCutBundleSerial ." AND dblBundleNo= ". $explodeBundleNo . " ";
	//echo $sql;
     $db->RunQuery($sql);
	 
    $sql2= "UPDATE productionfinishedgoodsreceivedetails SET dblBalQty=(dblBalQty+'$explodeQty'-'$ExistQty') WHERE intGPTYear= ". $year ." AND dblTransInNo = ". $fgRcvTrsfInNo ." AND intCutBundleSerial = ". $explodeCutBundleSerial ." AND dblBundleNo= ". $explodeBundleNo . " ";
	//echo $sql2;
     return $db->RunQuery($sql2);
	 
}
//-----Save Record in details file------------------------------------------------------------------
function SaveProductionfinishedgoodsreceivedetails($fgRcvTrsfInNo,$year,$explodeCutBundleSerial,$explodeBundleNo,$explodeQty,$explodeBalQty,$explodeCutNo,$explodeSize,$explodeColor,$explodeShade,$remarks)
{
	global $db;
	
	 $sql2= "select MAX(dblBalQty) from productionfinishedgoodsreceivedetails where dblTransInNo='$fgRcvTrsfInNo' and intGPTYear= ". $year ." AND intCutBundleSerial = ". $explodeCutBundleSerial ." AND dblBundleNo= ". $explodeBundleNo . " ";// AND dblTransInNo='$fgRcvTrsfInNo'
	// echo $sql2;
	 
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	 $MaxbalQty = $row["MAX(dblBalQty)"]+$explodeBalQty;
	
	
	 $sql= "INSERT INTO productionfinishedgoodsreceivedetails(dblTransInNo,intGPTYear,lngRecQty,dblBalQty,strCutNo,strSize,strColor,strShade,intCutBundleSerial,dblBundleNo,strRemarks) VALUES($fgRcvTrsfInNo, $year, $explodeQty,$explodeBalQty,'".trim($explodeCutNo)."', '$explodeSize', '$explodeColor', '$explodeShade', '$explodeCutBundleSerial', '$explodeBundleNo','$remarks')";
     $res1=  $db->RunQuery($sql);
	 
      $sql1= "UPDATE productionfinishedgoodsreceivedetails SET  dblBalQty= ". $MaxbalQty ." where dblTransInNo='$fgRcvTrsfInNo' and intGPTYear= ". $year ." AND intCutBundleSerial = ". $explodeCutBundleSerial ." AND dblBundleNo= ". $explodeBundleNo . ";";
	return $res2=$db->RunQuery($sql1);
	 
}
//------------------------------------------------------------------------------------------
function updateFinishGdGatePassForBalQty($gpNo,$explodeCutBundleSerial,$explodeBundleNo,$ExistQty,$explodeQty,$year){
global $db;
	
	 $sql2= "select * from productionfggpdetails where intCutBundleSerial= '". $explodeCutBundleSerial ."' AND dblBundleNo= '". $explodeBundleNo ."' AND intGPYear= '". $year ."' AND  intGPnumber= '". $gpNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);

		$balQty = $ExistQty+$row["dblBalQty"]-$explodeQty;
	
	  $sql= "UPDATE productionfggpdetails SET dblBalQty='$balQty' where intCutBundleSerial= '". $explodeCutBundleSerial ."' AND dblBundleNo= '". $explodeBundleNo ."' AND  intGPnumber= '". $gpNo ."'";

	 	$db->executeQuery($sql);
}
//--------Update productionfinishedgoodsreceiveheader for total line output Quantities-----
function updateProductionfinishedgoodsreceiveheaderQty($fgRcvTrsfInNo,$year,$totQty,$totBalQty){
global $db;
	
	 $sql2= "select * from productionfinishedgoodsreceivedetails where dblTransInNo = '". $fgRcvTrsfInNo ."' AND intGPTYear= '". $year ."'";
	$result2 = $db->RunQuery($sql2);
	$k=0;
	 while($row = mysql_fetch_array($result2))
  	 {	  
		 if($k==0){
			$totQty=0;
			$totBalQty=0;
		 }
		$totQty += $row["lngRecQty"];
		$totBalQty += $row["dblBalQty"];
		$k++;
	 }
	
	$sql= "UPDATE productionfinishedgoodsreceiveheader SET dblTotQty='$totQty', dblBalQty='$totBalQty' WHERE dblTransInNo='$fgRcvTrsfInNo' AND intGPTYear='$year'";
	 	return $db->RunQuery($sql);
}
//--------------------------------------------------------------------------------
function InsertToWasStock($totQty,$fgRcvTrsfInNo,$year,$color,$styleId,$fromFactory)
{
global $userId;
global $intCompanyId;
global $db;
$year = date('Y');
$sql="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory) values ('$year ',1,'$styleId','$fgRcvTrsfInNo','$year','$color','FTransIn','$totQty',now(),'$userId','$intCompanyId','$fromFactory','In');";
$result=$db->RunQuery($sql);
}

function GetOrderQty($style)
{
global $db;
	$sql="select intQty from orders where intStyleId='$style'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["intQty"];
	}
}

function getGPQty($factory,$gpNo,$gpYear,$poNo,$color){
	global $db;
	$sql="SELECT Sum(productionfggpdetails.dblQty) as GPQty 
	FROM productionfggpdetails 	 
	 JOIN productionfggpheader
	 ON productionfggpdetails.intGPnumber=productionfggpheader.intGPnumber 
	 JOIN productionbundleheader ON
	 productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial 
	 JOIN productionbundledetails ON
	  productionbundledetails.dblBundleNo = productionfggpdetails.dblBundleNo 
	 AND productionbundledetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
WHERE
     productionfggpheader.strFromFactory = '$factory'AND productionfggpheader.intGPnumber = '$gpNo' AND productionfggpheader.intGPYear = '$gpYear' -- AND productionfggpdetails.dblBalQty != '0' 
	 AND productionfggpheader.intStyleId = '$poNo' AND productionbundleheader.strColor = '$color'
GROUP BY
productionbundleheader.strColor;";	
//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['GPQty'];
}
?>