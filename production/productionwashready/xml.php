<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$intCompanyId		=	$_SESSION["FactoryID"];

//------------Load Po No And Style No------------------------------------------------------------
if (strcmp($RequestType,"loadPoNoAndStyle") == 0)
{
$ResponseXML	= "<Styles>";
$factoryID 		= $_GET["factoryID"];
	
	$sql = "SELECT PLOH.intStyleId, O.strStyle,O.strOrderNo 
		FROM productionlineoutputheader PLOH
		inner join orders O ON PLOH.intStyleId = O.intStyleId
		inner join productionlineoutdetail PLOD ON PLOH.intLineOutputSerial= PLOD.intLineOutputSerial and  PLOH.intLineOutputYear= PLOD.intLineOutputYear
		WHERE PLOH.intFactory = '".$factoryID."' and PLOD.dblBalQty>0 
		group by PLOH.intStyleId 
		order by O.strOrderNo";
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
//--------Load Cut Nos(releven to the style no)----------------------------------------------
if (strcmp($RequestType,"LoadCutNo") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	$styleID = $_GET["styleID"];
	
	
	   $sql = "SELECT 
	   productionbundleheader.strCutNo,
	   productionbundleheader.intCutBundleSerial 
	   FROM
	   productionlineoutputheader	   
	   inner join
	   productionlineoutdetail ON productionlineoutputheader.intLineOutputSerial= productionlineoutdetail.intLineOutputSerial
	   and productionlineoutputheader.intLineOutputYear= productionlineoutdetail.intLineOutputYear
	   inner join
	   productionbundleheader ON productionbundleheader.intCutBundleSerial= productionlineoutdetail.intCutBundleSerial	   
	   WHERE productionlineoutputheader.intFactory = '".$factoryID."'   AND productionlineoutputheader.intStyleId = '".$styleID."' 
	   and productionlineoutdetail.dblBalQty>0
	   GROUP BY productionbundleheader.intCutBundleSerial order by productionbundleheader.strCutNo ASC ";
	
//echo $sql;
	  global $db;
	  $result = $db->RunQuery($sql);
	  
		$k=0;
		$ResponseXML .= "<cutPC>";
		$ResponseXML .= "<![CDATA[";
		$ResponseXML .= "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNo"] ."</option>";
			
		$k++;
	 }
	$ResponseXML .= "]]>"."</cutPC>";
	 
	 $ResponseXML .=  "</Styles>";
	 echo $ResponseXML;	
}
//------------Load Bundle No------------------------------------------------------------
if (strcmp($RequestType,"loadBundleNo") == 0)
{
	$ResponseXML= "<headerBundleNo>";
	$factoryID = $_GET["factoryID"];
	$cutBundleSerial = $_GET["cutNo"];
	$PoNo = $_GET["PoNo"];
	
	$sql = "SELECT DISTINCT  productionlineoutdetail.dblBundleNo,
	 productionbundleheader.intCutBundleSerial, 
	 productionlineoutputheader.strPatternNo, 
	 productionlineoutputheader.strTeamNo, 
	 productionlineoutputheader.dtmDate 
	 FROM 
	  productionlineoutputheader
	  inner JOIN productionlineoutdetail 
	  ON productionlineoutputheader.intLineOutputSerial = productionlineoutdetail.intLineOutputSerial
	  inner JOIN productionbundleheader 
	  ON productionlineoutdetail.intCutBundleSerial = productionbundleheader.intCutBundleSerial
	  WHERE 
	  productionlineoutputheader.intFactory = '".$factoryID."' 
"; 
	 //   if($cutBundleSerial!="")
	  $sql .=" AND productionbundleheader.intCutBundleSerial = '".$cutBundleSerial."'"; 
   		if($PoNo!="")
	  $sql .=" AND productionlineoutputheader.intStyleId = '".$PoNo."'" ;
	  
	  $sql .=" Group by productionlineoutdetail.dblBundleNo order by productionlineoutdetail.dblBundleNo ASC";

	  global $db;
	  $result = $db->RunQuery($sql);
	$k=0;
	$tmpDate="";
	$ResponseXML1 .= "<Pattern>";
	$ResponseXML1 .= "<![CDATA[";
	$ResponseXML3 .= "<TeamNo>";
	$ResponseXML3 .= "<![CDATA[";
	$ResponseXML2 .= "<BundleNo>";
	$ResponseXML2 .= "<![CDATA[";
	$ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	
	$ResponseXML1 .= $row["strPatternNo"];
	$ResponseXML3 .= $row["strTeamNo"];
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML2 .= "<option value=\"". $row["dblBundleNo"] ."\">" . $row["dblBundleNo"] ."</option>";
			
		$k++;
	 }

	$ResponseXML1 .= "]]>"."</Pattern>";
	$ResponseXML3 .= "]]>"."</TeamNo>";
	$ResponseXML2 .= "]]>"."</BundleNo>";

	 
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML3.$ResponseXML2. "</headerBundleNo>";
	 echo $ResponseXML;	
}
//--------Load Header to serial no ----------------------------------------------
if (strcmp($RequestType,"LoadHeaderToSerial") == 0)
{
	$ResponseXML= "<Styles>";
	$serial = $_GET["serialNo"];
	$year = $_GET["year"];
	
	 $sql = "SELECT 
	  productionwashreadyheader.dtmDate AS Date,
	  productionwashreadyheader.intFactory,
	  productionwashreadyheader.intStyleId,
	  orders.strOrderNo,
	  orders.strStyle,
	  productionwashreadydetail.intCutBundleSerial,
	  productionwashreadydetail.dblBundleNo,
	  
	  productionwashreadyheader.strCutNo AS strCutNoHeader,
	  productionbundleheader.strCutNo AS strCutNoDetails
	  FROM
		 productionwashreadydetail
		 JOIN productionbundleheader ON
		  productionbundleheader.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial 
		  
		 JOIN productionbundledetails ON
		  productionbundledetails.dblBundleNo = productionwashreadydetail.dblBundleNo 
		 AND productionbundledetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial 
		 
		 JOIN productionwashreadyheader ON
		  productionwashreadydetail.intWashreadySerial = productionwashreadyheader.intWashreadySerial
		  
	   LEFT JOIN orders ON 
	   productionwashreadyheader.intStyleId = orders.intStyleId
		  
		LEFT JOIN productionfggpdetails ON productionbundledetails.dblBundleNo != productionfggpdetails.dblBundleNo 
		 AND productionbundledetails.intCutBundleSerial != productionfggpdetails.intCutBundleSerial 
		WHERE
		 productionwashreadyheader.intWashreadySerial = '".$serial."' 
		 AND productionwashreadyheader.intWashReadyYear = '".$year."'";
//removed-(15/09/2010)- (AND productionbundleheader.strStatus!=2)

//echo $sql;

	    global $db;
	    $result = $db->RunQuery($sql);
		
	$k=0;
		$ResponseXML1 .= "<factory>";
		$ResponseXML1 .= "<![CDATA[";
		
		$ResponseXML2 .= "<style>";
		$ResponseXML2 .= "<![CDATA[";
		
		$ResponseXML3 .= "<PoNo>";
		$ResponseXML3 .= "<![CDATA[";
		
		$ResponseXML4 .= "<cutNo>";
		$ResponseXML4 .= "<![CDATA[";
		
		$ResponseXML5 .= "<bundleNo>";
		$ResponseXML5 .= "<![CDATA[";
		
		$ResponseXML6 .= "<date>";
		$ResponseXML6 .= "<![CDATA[";
		
	$tempBundle="";	
	$noOfBundle=0;
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML12 = $ResponseXML1.$row["intFactory"] ;
		$ResponseXML22 =$ResponseXML2. "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		$ResponseXML32 =$ResponseXML3. "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		
		if($row["strCutNoHeader"]==""){
		$ResponseXML42 =$ResponseXML4. "<option value=\"\"></option>";
		$ResponseXML52 = $ResponseXML5."<option value=\"\"></option>";
		}
		else{
		$ResponseXML42 = $ResponseXML4."<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNoHeader"] ."</option>";
		}
		
		if($row["dblBundleNo"]!=$tempBundle){
		$noOfBundle++;
		$tempBundle=$row["dblBundleNo"];
		}
		if($tempBundle==1){
		$ResponseXML52 = $ResponseXML5. "<option value=\"". $row["dblBundleNo"] ."\">" . $row["dblBundleNo"] ."</option>";
		}
		else{
		$ResponseXML52 = $ResponseXML5. "";
		}
		
		$tmpDateDescT=$row["Date"];
		$ArrayDateDesc = explode('-',$tmpDateDescT);
		$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$ResponseXML62 =  $ResponseXML6.$DateDesc ;
		$k++;
	 }
	 

	$ResponseXML12 .= "]]>"."</factory>";
	$ResponseXML22 .= "]]>"."</style>";
	$ResponseXML32 .= "]]>"."</PoNo>";
	$ResponseXML42 .= "]]>"."</cutNo>";
	$ResponseXML52 .= "]]>"."</bundleNo>";
	$ResponseXML62 .= "]]>"."</date>";
	
	 $ResponseXML .=  $ResponseXML12.$ResponseXML22.$ResponseXML32.$ResponseXML42.$ResponseXML52.$ResponseXML62."</Styles>";
	 echo $ResponseXML;	
}
//----------------------------------Load Grid ----------------------------------------------
if (strcmp($RequestType,"LoadGrid") == 0)
{
	//if searching-------------------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];


	$ResponseXML= "<Grid>";
	$factoryID = $_GET["factoryID"];
	$cutBundleSerial = $_GET["cutNo"];
	$PoNo = $_GET["PoNo"];
	$bundleNo = $_GET["bundleNo"];
	
$sql = "SELECT
productionbundledetails.strSize,
productionbundledetails.dblBundleNo,
productionbundledetails.strNoRange,
productionbundledetails.strShade,
productionbundledetails.intCutBundleSerial,";

if(($searchYear!="") AND ($searchSerialNo!="")){
$sql =$sql."productionwashreadyheader.dtmDate,
productionwashreadyheader.strCutNo AS strCutNoHeader,
productionbundleheader.strCutNo AS strCutNoDetails,
productionwashreadydetail.intWashReadyYear,
productionwashreadydetail.strRemarks,
productionlineoutputheader.strTeamNo,
productionwashreadydetail.dblQty,
productionlineoutdetail.dblBalQty,
productionbundleheader.strColor
FROM productionwashreadydetail
JOIN productionbundleheader ON
productionbundleheader.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial 
JOIN productionbundledetails ON
productionbundledetails.dblBundleNo = productionwashreadydetail.dblBundleNo 
AND productionbundledetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial 
LEFT JOIN productionlineoutdetail ON
productionbundledetails.dblBundleNo = productionlineoutdetail.dblBundleNo 
AND productionbundledetails.intCutBundleSerial = productionlineoutdetail.intCutBundleSerial 
JOIN productionlineoutputheader ON
productionlineoutputheader.intLineOutputSerial = productionlineoutdetail.intLineOutputSerial 
JOIN productionwashreadyheader ON
productionwashreadyheader.intWashreadySerial = productionwashreadydetail.intWashreadySerial 
LEFT JOIN productionfggpdetails ON productionbundledetails.dblBundleNo != productionfggpdetails.dblBundleNo 
AND productionbundledetails.intCutBundleSerial != productionfggpdetails.intCutBundleSerial 
WHERE
productionwashreadyheader.intWashreadySerial = '".$searchSerialNo."' 
AND productionwashreadyheader.intWashReadyYear = '".$searchYear."'";
}
else{
$sql=$sql."productionlineoutdetail.dblBalQty,
productionlineoutputheader.strTeamNo,
productionlineoutdetail.intLineOutputYear,
productionbundleheader.strCutNo AS strCutNoDetails,
productionbundleheader.strColor
FROM productionbundledetails
inner join productionlineoutdetail ON productionlineoutdetail.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionlineoutdetail.dblBundleNo = productionbundledetails.dblBundleNo 
inner join productionbundleheader ON
productionbundleheader.intCutBundleSerial = productionlineoutdetail.intCutBundleSerial 
inner join productionlineoutputheader ON
productionlineoutputheader.intLineOutputSerial = productionlineoutdetail.intLineOutputSerial
WHERE
productionlineoutdetail.dblBalQty!=0 
AND productionlineoutputheader.intFactory = '".$factoryID."'"; 
if($cutBundleSerial!="")
$sql .=" AND productionlineoutdetail.intCutBundleSerial = '".$cutBundleSerial."'";
if($bundleNo!="")
$sql .=" AND productionlineoutdetail.dblBundleNo = '".$bundleNo."'";
if($PoNo!="")
$sql .=" AND productionlineoutputheader.intStyleId = '".$PoNo."'";
}	
$sql .=" GROUP BY productionbundledetails.dblBundleNo";
 

//echo $sql;
     global $db;
	  $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {

		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<CutBundserial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundserial>\n";
		$ResponseXML .= "<BundlNo><![CDATA[" . $row["dblBundleNo"]  . "]]></BundlNo>\n";
		$ResponseXML .= "<Range><![CDATA[" . $row["strNoRange"]  . "]]></Range>\n";
		$ResponseXML .= "<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>\n";
		
	if(($searchYear!="") AND ($searchSerialNo!="")){
		$date=$row["dtmDate"];
		$ArrayDateDesc = explode('-',$date);
		$date = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$ResponseXML .= "<Output><![CDATA[" . $row["dblBalQty"]  . "]]></Output>\n";
		$ResponseXML .= "<Wash><![CDATA[" . $row["dblQty"]  . "]]></Wash>\n";
		$ResponseXML .= "<remarks><![CDATA[" . $row["strRemarks"]  . "]]></remarks>\n";
		$ResponseXML .= "<color><![CDATA[" . $row["strColor"]  . "]]></color>\n";
		
		}
		else{
		$date="";
		$remarks="";
		$ResponseXML .= "<Output><![CDATA[" . $row["dblBalQty"]  . "]]></Output>\n";
		$ResponseXML .= "<Wash><![CDATA[" . $row["dblBalQty"]  . "]]></Wash>\n";
		$ResponseXML .= "<remarks><![CDATA[" . $remarks  . "]]></remarks>\n";
		$ResponseXML .= "<color><![CDATA[" . $row["strColor"]  . "]]></color>\n";
		}
		
		$ResponseXML .= "<cutNo><![CDATA[" .  $row["strCutNoDetails"]  . "]]></cutNo>\n";
		$ResponseXML .= "<date><![CDATA[" .  $date  . "]]></date>\n";
		$ResponseXML .= "<Line><![CDATA[" . $row["strTeamNo"]  . "]]></Line>\n";
	 }
	 
	 $ResponseXML .= "</Grid>";
	 echo $ResponseXML;	
}
//----------------save Wash Ready header---------------------------------------
if (strcmp($RequestType,"SaveWashReadyHeader") == 0)
{
	$factory = $_GET["factory"];
	$WashReadyYear = $_GET["WashReadyYear"];
	$styleID = $_GET["styleID"];
	
	$WashDateTemp = $_GET["WashDate"];
	$WashDatmArray		= explode('/',$WashDateTemp);
	$WashDate = $WashDatmArray[2]."-".$WashDatmArray[1]."-".$WashDatmArray[0];
	
	$cutNo = $_GET["cutNo"];
	$pattern = $_GET["pattern"];
	$teamID = $_GET["teamNo"];
	$totQty = $_GET["totQty"];
	$totBalQty = $_GET["totBalQty"];
	$Status = $_GET["Status"];

	
	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];
	//--------------------
	
	 if (($searchYear!="") AND ($searchSerialNo!=""))
	 {
	    $WashreadySerial=$searchSerialNo;	
	    $WashReadyYear=$searchYear;
		
	 	$result=UpdateProductionwashreadyheader($WashreadySerial,$factory,$WashReadyYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$WashDate);
	 }
	 else
	 {
	   $WashreadySerial=SelectMaxWashreadySerial();	
	 
	   $result=SaveProductionwashreadyheader($WashreadySerial,$factory,$WashReadyYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$WashDate);
	   
	 }	 
	
	   
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	 $ResponseXML .= "<WashreadySerial><![CDATA[" . $WashreadySerial  . "]]></WashreadySerial>\n";
	 $ResponseXML .= "<WashreadyYear><![CDATA[" . $WashReadyYear  . "]]></WashreadyYear>\n";
	 $ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}
//-------update header file-----------------------------------------------------------------------
function UpdateProductionwashreadyheader($WashreadySerial,$factory,$WashReadyYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$WashDate)
{
	global $db;
	$sql= "UPDATE productionwashreadyheader SET dtmDate='$WashDate' WHERE intFactory='$factory' AND intWashReadyYear='$WashReadyYear' AND intStyleId='$styleID' AND strTeamNo='$teamID' AND strPatternNo='$pattern' AND strCutNo='$cutNo' AND intWashreadySerial='$WashreadySerial'";
	return $db->RunQuery($sql);
}

//-------retrieve existing  intLineOutputSerial & update it by adding 1---------------------------------------
function SelectMaxWashreadySerial(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sql1="SELECT MAX(intWashreadySerial) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result= $db->RunQuery($sql1);

	$row = mysql_fetch_array($result);
	$old= $row["MAX(intWashreadySerial)"];
	$newSerial=$old+1;
	
		updateSysControl($old,$newSerial);
		return $old; 
}
//--------update syscontrol for intWashreadySerial(by Adding 1)----------------------
function updateSysControl($old,$newSerial){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET intWashreadySerial='$newSerial' WHERE intWashreadySerial='$old' and intCompanyID='$intCompanyId'";
	 $db->executeQuery($sqls);
}
//-------save new record for header---------------------------------------------------
function SaveProductionwashreadyheader($WashreadySerial,$factory,$WashReadyYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$WashDate)
{
	global $db;
	$sql= "INSERT INTO productionwashreadyheader(intWashreadySerial ,intFactory ,intWashReadyYear ,intStyleId, strTeamNo ,strPatternNo ,strCutNo, dblTotQty, dblBalQty, intStatus, dtmDate) VALUES($WashreadySerial, $factory, $WashReadyYear, $styleID, '$teamID', '$pattern', '$cutNo', $totQty, $totBalQty, $Status, '$WashDate')";
	return $db->RunQuery($sql);
}
//----------------Save Wash Ready Details-----------------------------------------------
if (strcmp($RequestType,"SaveWashReadyDetails") == 0)
{
	$WashreadySerial = $_REQUEST["WashreadySerial"];
	$year = $_REQUEST["year"];
	$factory = $_REQUEST["factory"];
	$cutBundleSerial = $_REQUEST["CutBundleSerial"];
	$bundleNo = $_REQUEST["BundleNo"];
	$qty = $_REQUEST["Qty"];
	$balQty = $_REQUEST["BalQty"];
	$remarks= $_REQUEST["remarks"];
	
	
	$totQty=0;
	$totBalQty=0;
	$x=0;
	
			  $ExistQty = CheckExistDetails($WashreadySerial,$year,$cutBundleSerial,$bundleNo);
			 if ($ExistQty != "")
			 {
	            $result=UpdateProductionwashreadydetail($WashreadySerial,$year,$cutBundleSerial,$bundleNo,$qty,$qty,$ExistQty,$remarks);
			   
			 }
			 else{
			   $ExistQty=0;
			 
		       $result=SaveProductionwashreadydetail($WashreadySerial,$year,$cutBundleSerial,$bundleNo,$qty,$qty,$remarks);
			   
			 }
				$totQty += $qty;
				$totBalQty += $balQty;
				
			   updatelineOutdetailForBalQty($cutBundleSerial,$bundleNo,$ExistQty,$qty,$year);
			   
		       $wipQty=$qty-$ExistQty;
			   update_production_wip($factory,$cutBundleSerial,"intWashReady",$wipQty);		 
		
	//-----------------Update Header file for totQty & totBalQty-
	updateProductionwashreadyheaderQty($WashreadySerial,$year,$totQty,$totBalQty);	
	
	$ResponseXML .= "<ResultDetails>";
	$ResponseXML .= "<year><![CDATA[".$year."]]></year>\n";
	$ResponseXML .= "<serial><![CDATA[".$WashreadySerial."]]></serial>\n";
	$ResponseXML .= "<result><![CDATA[" . $result  . "]]></result>\n";
	$ResponseXML .= "</ResultDetails>";
	echo $ResponseXML;	 
}
//-----check whether record existing in details file-------------------------------------------------------
function CheckExistDetails($WashreadySerial,$year,$cutBundleSerial,$bundleNo)
{
	global $db;
	 $sql= "select * from productionwashreadydetail where intWashreadySerial = ". $WashreadySerial ." AND intWashReadyYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["dblQty"];
	return $exitQty;
}
//------Update records in details file------------------------------------------------------------------
function UpdateProductionwashreadydetail($WashreadySerial,$year,$cutBundleSerial,$bundleNo,$qty,$balQty,$ExistQty,$remarks)
{
	global $db;
    $sql= "UPDATE productionwashreadydetail SET dblQty='$qty', strRemarks='$remarks' WHERE intWashreadySerial = ". $WashreadySerial ." AND intWashReadyYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
     $db->RunQuery($sql);
	 
   $sql2= "UPDATE productionwashreadydetail SET dblBalQty=(dblBalQty+'$qty'-'$ExistQty') WHERE intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
     return $db->RunQuery($sql2);
}
//-----Save Records in details file------------------------------------------------------------------
function SaveProductionwashreadydetail($WashreadySerial,$year,$cutBundleSerial,$bundleNo,$qty,$balQty,$remarks)
{
	global $db;
	
	 $sql2= "select MAX(dblBalQty) from productionwashreadydetail where intWashReadyYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$MaxbalQty = $row["MAX(dblBalQty)"]+$balQty;
	
	 $sql= "INSERT INTO productionwashreadydetail(intWashreadySerial,intWashReadyYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,strRemarks) VALUES($WashreadySerial,$year,$cutBundleSerial,$bundleNo,$qty,$balQty,'$remarks')";
    $res1=$db->RunQuery($sql);
	 
     $sql= "UPDATE productionwashreadydetail SET  dblBalQty= ". $MaxbalQty ." where intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	return $db->RunQuery($sql);
	 
}
//------------------------------------------------------------------------------------------
function updatelineOutdetailForBalQty($cutBundleSerial,$bundleNo,$ExistQty,$qty,$year){
global $db;
	
	 $sql2= "select * from productionlineoutdetail where intCutBundleSerial= '". $cutBundleSerial ."' AND dblBundleNo= '". $bundleNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
		$balQty = $ExistQty+$row["dblBalQty"]-$qty;
	
	  $sql= "UPDATE productionlineoutdetail SET dblBalQty='$balQty' where intCutBundleSerial= '". $cutBundleSerial ."' AND dblBundleNo= '". $bundleNo ."'";
	 	$db->executeQuery($sql);
}
//--------Update productionwashreadyheader for total line input Quantities------------------------
function updateProductionwashreadyheaderQty($WashreadySerial,$year,$totQty,$totBalQty){
global $db;
	
	 $sql2= "select * from productionwashreadydetail where intWashreadySerial = '". $WashreadySerial ."' AND intWashReadyYear= '". $year ."'";
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
	
	$sql= "UPDATE productionwashreadyheader SET dblTotQty='$totQty',dblBalQty='$totBalQty' WHERE intWashreadySerial='$WashreadySerial' AND intWashReadyYear='$year'";
	 	$db->executeQuery($sql);
}
//----------------------------------------------------------------------------------------------------------
