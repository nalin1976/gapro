<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$intCompanyId =	$_SESSION["FactoryID"];

//------------Load Po No And Style No------------------------------------------------------------
if (strcmp($RequestType,"loadPoNoAndStyle") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	
	$sql = "SELECT 
	productionwashreadyheader.intStyleId, 
	orders.strStyle,
	orders.strOrderNo 
	FROM
	  productionwashreadyheader  LEFT JOIN orders ON productionwashreadyheader.intStyleId = orders.intStyleId
	  WHERE productionwashreadyheader.intFactory = '".$factoryID."' 
	  group by productionwashreadyheader.intStyleId 
	  order by productionwashreadyheader.intStyleId ASC";

	  global $db;
	  $result = $db->RunQuery($sql);
	  $k=0;
		
	 $ResponseXML1 .= "<style>";
	 $ResponseXML1 .= "<![CDATA[";
	 $ResponseXML1 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	
	 $ResponseXML2 .= "<orderNo>";
	 $ResponseXML2 .= "<![CDATA[";
	 $ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
		
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML2 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
			
		$k++;
	 }
	$ResponseXML1 .= "]]>"."</style>";
	$ResponseXML2 .= "]]>"."</orderNo>";
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2. "</Styles>";
	 echo $ResponseXML;	
}
//--------Load Header to serial no ----------------------------------------------
if (strcmp($RequestType,"LoadHeaderToSerial") == 0)
{
	$ResponseXML= "<Styles>";
	$serial = $_GET["serialNo"];
	$year = $_GET["year"];
	
	 $sql = "SELECT 
	  productionfggpheader.dtmGPDate AS Date,
	  productionfggpheader.strFromFactory,
	  productionfggpheader.strToFactory,
	  productionfggpheader.intStyleId,
	  productionfggpheader.strVehicleNo,
	  productionfggpheader.strRemarks,
	  orders.strOrderNo,
	  orders.strStyle,
	  productionfggpheader.intStatus
	  FROM
	  productionfggpheader 
	  INNER JOIN orders ON productionfggpheader.intStyleId = orders.intStyleId
	  WHERE
	  productionfggpheader.intGPnumber = '".$serial."' 
	  AND productionfggpheader.intGPYear = '".$year."'";
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
		
		$ResponseXML5 .= "<cutNo>";
		$ResponseXML5 .= "<![CDATA[";
		
		$ResponseXML6 .= "<date>";
		$ResponseXML6 .= "<![CDATA[";
		
		$ResponseXML7 .= "<vehicle>";
		$ResponseXML7 .= "<![CDATA[";
		
		$ResponseXML8 .= "<remarks>";
		$ResponseXML8 .= "<![CDATA[";
		$ResponseXMLRcv ='';
		$ResponseXMLCstatus='';
	$tempBundle="";	
	$noOfBundle=0;
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML12 = $ResponseXML1.$row["strFromFactory"] ;
		$ResponseXML22 = $ResponseXML2.$row["strToFactory"] ;
		$ResponseXML32 =$ResponseXML3. "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		$ResponseXML42 =$ResponseXML4. "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML52 = $ResponseXML5. $row["intCutBundleSerial"];
		
		$tmpDateDescT=$row["Date"];
		$ArrayDateDesc = explode('-',$tmpDateDescT);
		$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$ResponseXML62 =  $ResponseXML6.$DateDesc ;
		
		$ResponseXML72 = $ResponseXML7.$row["strVehicleNo"] ;
		$ResponseXML82 = $ResponseXML8.$row["strRemarks"] ;
		$ResponseXMLRcv .= "<RcvStatus><![CDATA[".getRcvStatus($year,$serial)."]]></RcvStatus>";
		$ResponseXMLCstatus .= "<CancelStatus><![CDATA[".$row["intStatus"]."]]></CancelStatus>";
		
		$k++;
	 }
	 

	$ResponseXML12 .= "]]>"."</fromFactory>";
	$ResponseXML22 .= "]]>"."</toFactory>";
	$ResponseXML32 .= "]]>"."</style>";
	$ResponseXML42 .= "]]>"."</PoNo>";
	$ResponseXML52 .= "]]>"."</cutNo>";
	$ResponseXML62 .= "]]>"."</date>";
	$ResponseXML72 .= "]]>"."</vehicle>";
	$ResponseXML82 .= "]]>"."</remarks>";
	
	 $ResponseXML .=  $ResponseXML12.$ResponseXML22.$ResponseXML32.$ResponseXML42.$ResponseXML52.$ResponseXML62.$ResponseXML72.$ResponseXML82.$ResponseXMLRcv.$ResponseXMLCstatus ."</Styles>";
	 echo $ResponseXML;	
}
//----------------------------------Load Grids ----------------------------------------------
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
global $db;
$factoryID 		= $_GET["factoryID"];
$styleID 		= $_GET["styleID"];
$searchYear 	= $_GET["searchYear"];
$searchSerialNo = $_GET["searchSerialNo"];

	if(($searchYear!="") AND ($searchSerialNo!=""))
	{
		$sql ="SELECT DISTINCT 
			productionbundleheader.strCutNo,
			productionfggpheader.dtmGPDate AS date
			FROM productionfggpdetails	 
			inner join productionfggpheader ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber 	 
			inner join  productionbundleheader ON productionbundleheader.intCutBundleSerial= productionfggpdetails.intCutBundleSerial   
			WHERE
			productionfggpheader.intGPYear = '".$searchYear."' 
			AND productionfggpheader.intGPnumber = '".$searchSerialNo."'"; 
	}
	else
	{
		$sql="SELECT DISTINCT 
			PBH.strCutNo,
			PWRH.dtmDate AS date
			FROM productionwashreadyheader PWRH
			inner join productionwashreadydetail PWRD ON PWRH.intWashreadySerial= PWRD.intWashreadySerial and PWRH.intWashReadyYear= PWRD.intWashReadyYear
			inner join productionbundleheader PBH ON PBH.intCutBundleSerial= PWRD.intCutBundleSerial
			WHERE PWRH.intFactory = '$factoryID' 
			AND PWRH.intStyleId = '$styleID'
			and PWRD.dblBalQty>0
			order by date desc";
	}	
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

	//if searching-------------------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];

	$length=0;
	$factoryID = $_GET["factoryID"];
	$styleID = $_GET["styleID"];
	$ArrayCutNos = $_GET["ArrayCutNos"];
	$CutNos = explode(',', $ArrayCutNos) ;
	$ArrayDates = $_GET["ArrayDates"];
	$explodeDates = explode(',', $ArrayDates) ;
	
	$length=count($CutNos);
	
	
	 $sql = "SELECT
	 productionbundledetails.strSize,
	 productionbundledetails.dblBundleNo,
	 productionbundledetails.strNoRange,
	 productionbundledetails.strShade,";
	 
if(($searchYear!="") AND ($searchSerialNo!="")){
	$sql =$sql."productionfggpheader.dtmGPDate,
	productionfggpdetails.intCutBundleSerial,
	productionbundleheader.strCutNo AS strCutNoDetails,
	productionfggpdetails.intGPYear,
	productionfggpdetails.dblQty,
	productionfggpdetails.strRemarks,
	productionwashreadydetail.dblBalQty
	FROM
	productionfggpdetails
	Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
	Inner Join productionbundledetails ON productionbundledetails.dblBundleNo = productionfggpdetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
	Inner Join productionfggpheader ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber
	Left Join productionfinishedgoodsreceivedetails ON productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial
	Inner Join productionwashreadydetail ON productionwashreadydetail.intCutBundleSerial = productionfggpdetails.intCutBundleSerial AND productionwashreadydetail.dblBundleNo = productionfggpdetails.dblBundleNo
	WHERE
	productionfggpheader.intGPnumber = '".$searchSerialNo."' 
	AND productionfggpheader.intGPYear = '".$searchYear."'	
	 "; 

	// $sql=$sql."AND productionfggpheader.dtmGPDate = '".$searchYear."'";
		 
}
else{
	$sql=$sql."productionwashreadydetail.dblBalQty,
	productionwashreadydetail.dblQty,
	 productionwashreadydetail.intCutBundleSerial,
	  productionbundleheader.strCutNo AS strCutNoDetails,
	 productionwashreadydetail.intWashReadyYear
	 FROM
	 productionwashreadyheader
	 JOIN productionwashreadydetail
	 ON productionwashreadyheader.intWashreadySerial=productionwashreadydetail.intWashreadySerial
	   JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial= productionwashreadydetail.intCutBundleSerial
	 JOIN productionbundledetails ON
	 productionbundledetails.dblBundleNo = productionwashreadydetail.dblBundleNo 
	 AND productionbundledetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial 
	 JOIN productionlineoutdetail ON
	 productionbundledetails.dblBundleNo = productionlineoutdetail.dblBundleNo 
	 AND productionbundledetails.intCutBundleSerial = productionlineoutdetail.intCutBundleSerial 
     WHERE ";
	 if($length<=1){
     $sql=$sql."productionwashreadyheader.intFactory = '".$factoryID."' 
	 AND productionwashreadyheader.intStyleId = '".$styleID."' 
	 AND productionwashreadydetail.dblBalQty != '0'"; 
	 }
	 else if($length>1){
		  for($i = 0 ;$i < $length-1 ; $i ++ ){
		  
			  if($i==0){
				$sql=$sql."productionwashreadyheader.intFactory = '".$factoryID."' 
						AND productionwashreadyheader.intStyleId = '".$styleID."' 
						AND productionwashreadydetail.dblBalQty != '0'"; 
				$sql .=" AND productionbundleheader.strCutNo = '".trim($CutNos[$i],' ')."'"; 
				$sql .=" AND productionwashreadyheader.dtmDate = '".trim($explodeDates[$i],' ')."'";
			  }
			  else{
				$sql=$sql." OR productionwashreadyheader.intFactory = '".$factoryID."' 
						AND productionwashreadyheader.intStyleId = '".$styleID."' 
						AND productionwashreadydetail.dblBalQty != '0'"; 
				$sql .=" AND productionbundleheader.strCutNo = '".trim($CutNos[$i],' ')."'"; 
				$sql .=" AND productionwashreadyheader.dtmDate = '".trim($explodeDates[$i],' ')."'";
			  }
		  }
	  }
  }
		  $sql .=" GROUP BY  productionbundledetails.dblBundleNo"; 
	  
 
//echo $sql;
     global $db;
	  $result = $db->RunQuery($sql);
	  
	  $remarks = '';
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<CutNo1><![CDATA[" . $row["strCutNoDetails"]  . "]]></CutNo1>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<Bundle><![CDATA[" . $row["dblBundleNo"]  . "]]></Bundle>\n";
		$ResponseXML .= "<Range><![CDATA[" . $row["strNoRange"]  . "]]></Range>\n";
		$ResponseXML .= "<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>\n";
	if(($searchYear!="") AND ($searchSerialNo!="")){
		$date=$row["dtmGPDate"];
		$ArrayDateDesc = explode('-',$date);
		$date = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$ResponseXML .= "<WashQty><![CDATA[" . $row["dblBalQty"]  . "]]></WashQty>\n";
		$ResponseXML .= "<GPQty><![CDATA[" . $row["dblQty"]  . "]]></GPQty>\n";
		$remarks = $row["strRemarks"];
		}
		else{
		$date="";
		$ResponseXML .= "<WashQty><![CDATA[" . $row["dblBalQty"]  . "]]></WashQty>\n";
		$ResponseXML .= "<GPQty><![CDATA[" . $row["dblBalQty"]  . "]]></GPQty>\n";
		}
		$ResponseXML .= "<CutBundserial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundserial>\n";
		$ResponseXML .= "<remarks><![CDATA[" . $remarks  . "]]></remarks>\n";
	 }
	return $ResponseXML;	
 
}
//----------------save finished goods gate pass header-------------------------------------------------------
if (strcmp($RequestType,"SaveFinishGoodGPHeader") == 0)
{
	
	$GPDateTemp = $_GET["GPDate"];
	$GPDateArray		= explode('/',$GPDateTemp);
	$GPDate = $GPDateArray[2]."-".$GPDateArray[1]."-".$GPDateArray[0];
	
	$GPYear = $_GET["GPYear"];
	$fromFactory = $_GET["fromFactory"];
	$toFactory = $_GET["toFactory"];
	$styleID = $_GET["styleID"];
	$totBalQty = $_GET["totBalQty"];
	$Status = $_GET["Status"];
	$totQty = $_GET["totQty"];
	$vehicleNo = $_GET["vehicleNo"];
	$Remarks   = $_GET["Remarks"];
	
	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];
	//--------------------
	
	 if (($searchYear!="") AND ($searchSerialNo!=""))
	 {
	    $GatePassNo=$searchSerialNo;	
	    $GPYear=$searchYear;
		
	 	$result=UpdateProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$vehicleNo,$Remarks);
	 }
	 else
	 {
	   $GatePassNo=SelectMaxGatePassNo();	
	   $searchYear = date("Y");	
	  $result=SaveProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$totQty,$totBalQty,$Status,$vehicleNo,$Remarks);
	   
	 }	 
	
	   
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	 $ResponseXML .= "<GatePassNo><![CDATA[" . $GatePassNo  . "]]></GatePassNo>\n";
	  $ResponseXML .= "<GPyear><![CDATA[" . $searchYear  . "]]></GPyear>\n";
	  
	 $ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}
//-------update header file-----------------------------------------------------------------------
function UpdateProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$vehicleNo,$Remarks)
{
	global $db;
	$sql= "UPDATE productionfggpheader SET dtmGPDate='$GPDate', strVehicleNo='$vehicleNo' , strRemarks='$Remarks' WHERE strFromFactory='$fromFactory' AND strToFactory='$toFactory' AND intStyleId='$styleID' AND intGPYear='$GPYear' AND intGPnumber='$GatePassNo'";
	return $db->RunQuery($sql);
}

//-------retrieve existing  intLineOutputSerial & update it by adding 1---------------------------------------
function SelectMaxGatePassNo(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sql1="SELECT MAX(intFinishGoodGPNo) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result= $db->RunQuery($sql1);

	$row = mysql_fetch_array($result);
	$old= $row["MAX(intFinishGoodGPNo)"];
	$newSerial=$old+1;
	
	updateSysControl($old,$newSerial);
	return $old; 
}
//--------update syscontrol for intWashreadySerial(by Adding 1)----------------------
function updateSysControl($old,$newSerial){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET intFinishGoodGPNo='$newSerial' WHERE intFinishGoodGPNo='$old' and intCompanyID='$intCompanyId'";
	 $db->executeQuery($sqls);
}
//-------save new record for header----------------------------------------------------------------------------------------
function SaveProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$totQty,$totBalQty,$Status,$vehicleNo,$Remarks)
{

	global $db;
	$userid = $_SESSION["UserID"];
	   $sql= "INSERT INTO productionfggpheader(intGPnumber ,strFromFactory ,strToFactory ,intStyleId, intGPYear ,dtmGPDate ,dblTotQty, dblBalQty, intStatus,intUser,strVehicleNo,strRemarks) VALUES($GatePassNo, $fromFactory, $toFactory, $styleID, $GPYear, '$GPDate', $totQty, $totBalQty, $Status,$userid,'$vehicleNo','$Remarks')";
	return $db->RunQuery($sql);
}
//----------------Save finished goods gate pass Details---------------------------------
if (strcmp($RequestType,"SaveFinishGoodGPDetails") == 0)
{
	$GatePassNo = $_REQUEST["GatePassNo"];
	$year = $_REQUEST["year"];
	$factory = $_REQUEST["factory"];
	
	$CutBundleSerial = $_REQUEST["CutBundleSerial"];
	$BundleNo = $_REQUEST["BundleNo"];
	$Qty = $_REQUEST["Qty"];
	$BalQty = $_REQUEST["BalQty"];
/*	$ArrayCutNo = $_REQUEST["CutNo"];
	$ArraySize = $_REQUEST["Size"];
	$ArrayRange = $_REQUEST["Range"];
	$ArrayShade = $_REQUEST["Shade"];
	$ArrRemarks = $_REQUEST["Remarks"];*/
	$CutNo = $_REQUEST["CutNo"];
	$Size = $_REQUEST["Size"];
	$Range = $_REQUEST["Range"];
	$Shade = $_REQUEST["Shade"];
	$Remarks = $_REQUEST["remarks"];

	$totQty=0;
	$totBalQty=0;
	$x=0;
	
	 //if $ExistQty !=0 means already saved record and then shd update.
	 $AllreadyExist = false;
	 $ExistQty = CheckExistDetails($GatePassNo,$year,trim($CutBundleSerial,' '),trim($BundleNo,' '));
	 
	 if ($ExistQty != "")
	 {
		$resultDetail=UpdateProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$Qty,trim($CutNo,' '),trim($Size,' '),trim($Range,' '),trim($Shade,' '),$ExistQty,$Remarks);
	 }
	 else{
	   $ExistQty=0;
	   $resultDetail=SaveProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$Qty,trim($CutNo,' '),trim($Size,' '),trim($Range,' '),trim($Shade,' '),$Remarks);
	 }
	 
		$totQty += $Qty;
		$totBalQty += $BalQty;
		
		//new
		updateWashReadydetailForBalQty($CutBundleSerial,$BundleNo,$ExistQty,$Qty,$year);

		$wipQty=$Qty-$ExistQty;
		update_production_wip($factory,$CutBundleSerial,"intFGgatePass",$wipQty);		 
	 
		//Update Productionfggpheader for totQty & totBalQty------
		updateProductionfggpheaderQty($GatePassNo,$year,$totQty,$totBalQty);	
	
	
		$ResponseXML = "<data>";
		$ResponseXML .= "<result><![CDATA[" . $resultDetail  . "]]></result>\n";
		$ResponseXML .= "</data>";
		
			echo $ResponseXML;	
}
//-----check whether record existing in details file-------------------------------------------------------
function CheckExistDetails($GatePassNo,$year,$CutBundleSerial,$BundleNo)
{
	global $db;
	 $sql= "select * from productionfggpdetails where intGPnumber = ". $GatePassNo ." AND intCutBundleSerial = '". $CutBundleSerial ."' AND dblBundleNo = '". $BundleNo ."'";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["dblQty"];
	return $exitQty;
}
//------Update records in details file------------------------------------------------------------------
function UpdateProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$BalQty,$CutNo,$Size,$Range,$Shade,$ExistQty,$remarks)
{
	global $db;
	
    $sql= "UPDATE productionfggpdetails SET dblQty=$Qty, strRemarks='$remarks' WHERE intGPnumber = ". $GatePassNo ." AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . "";
     $db->RunQuery($sql);
	 
   $sql2= "UPDATE productionfggpdetails SET dblBalQty=(dblBalQty+'$Qty'-'$ExistQty')  where intGPnumber= ". $GatePassNo ." AND intGPYear = ". $year ." AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . " ";
     return $db->RunQuery($sql2);
}
//-----Save Record in details file------------------------------------------------------------------
function SaveProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$BalQty,$CutNo,$Size,$Range,$Shade,$remarks)
{
	global $db;
	 $sql2= "select MAX(dblBalQty) from productionfggpdetails where intGPnumber= ". $GatePassNo ." AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . " ";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	 $MaxbalQty = $row["MAX(dblBalQty)"]+$BalQty;
	
	
	 $sql= "INSERT INTO productionfggpdetails(intGPnumber,intGPYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,strCutNo,strSize,strRange,strShade,strRemarks) VALUES($GatePassNo, $year, $CutBundleSerial,$BundleNo, $Qty, $BalQty, '$CutNo', '$Size', '$Range', '$Shade','$remarks')";
     $res1= $db->RunQuery($sql);
	 
	 
      $sql2= "UPDATE productionfggpdetails SET  dblBalQty= ". $MaxbalQty ." where intGPnumber= ". $GatePassNo ." AND intGPYear = ". $year ." AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . " ";
	return $db->RunQuery($sql2);
	 
}
//------------------------------------------------------------------------------------------
function updateWashReadydetailForBalQty($CutBundleSerial,$BundleNo,$ExistQty,$Qty,$year){
global $db;
	
	 $sql2= "select * from productionwashreadydetail where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
		$balQty = $ExistQty+$row["dblBalQty"]-$Qty;
	
	  $sql= "UPDATE productionwashreadydetail SET dblBalQty='$balQty' where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	 	$db->executeQuery($sql);
}
//--------Update productionlineoutputheader for total line output Quantities------------------------
function updateProductionfggpheaderQty($GatePassNo,$year,$totQty,$totBalQty){
global $db;
	
	 $sql2= "select * from productionfggpdetails where intGPnumber = '". $GatePassNo . "' AND intGPYear= '". $year ."'";
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
	
	$sql= "UPDATE productionfggpheader SET dblTotQty='$totQty',dblBalQty='$totBalQty' where intGPnumber = '". $GatePassNo . "' AND intGPYear= '". $year ."'";
	 	$db->executeQuery($sql);
}
//----------------------------------------------------------------------------------------------------------
//03-08-2011 getRcvStatus

function getRcvStatus($year,$serial){
	global $db;
	$sql="SELECT
		  CONCAT(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo) AS GPNo
		  FROM productionfinishedgoodsreceiveheader
		  WHERE CONCAT(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo)='".$year."/".$serial."'";
		  
	//echo $sql;
	$res=$db->RunQuery($sql);
	$numRow=mysql_num_rows($res);	
	if($numRow > 0)
		return 1;
	else
		return 0;
	 
} 
?>