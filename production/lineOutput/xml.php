<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType 		= $_GET["RequestType"];
$intCompanyId		=	$_SESSION["FactoryID"];

if (strcmp($RequestType,"loadLineNo") == 0)
{
$ResponseXML = "<headerLineNo>";
$factoryID = $_GET["factoryID"];
$PoNo = $_GET["PoNo"];

	$sql = "SELECT distinct
	PLIH.strTeamNo, 
	PT.strTeam 
	FROM productionlineinputheader PLIH
	inner join productionlineindetail PLID ON PLIH.intLineInputSerial= PLID.intLineInputSerial and PLIH.intLineInputYear= PLID.intLineInputYear
	inner join plan_teams PT ON PLIH.strTeamNo=PT.intTeamNo
	WHERE PLIH.intFactory = '".$factoryID."'  
	AND PLIH.intStyleId = '".$PoNo."' 
	and PLID.dblBalQty >0
	order by PLIH.strTeamNo";
	$result = $db->RunQuery($sql);
	
		$ResponseXML .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;	
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["strTeamNo"] ."\">" . $row["strTeam"] ."</option>";
	}

$ResponseXML .= "<headerLineNo>";
echo $ResponseXML;	
}

if (strcmp($RequestType,"loadCutNo") == 0)
{
$ResponseXML	= "<headerCutNo>";
$factoryID 		= $_GET["factoryID"];
$lineNo 		= $_GET["lineNo"];
$PoNo 			= $_GET["PoNo"];
	
	$sql = "select distinct PBH.strCutNo, PLIH.dtmDate, PBH.intCutBundleSerial 
	from productionlineinputheader PLIH
	inner join productionlineindetail PLID ON PLIH.intLineInputSerial= PLID.intLineInputSerial and PLIH.intLineInputYear= PLID.intLineInputYear
	inner join productionbundleheader PBH ON PBH.intCutBundleSerial= PLID.intCutBundleSerial
	where PLIH.intFactory = '".$factoryID."' 
	and PLIH.strTeamNo = '".$lineNo."' 
	and PLIH.intStyleId = '".$PoNo."'
	and PLID.dblBalQty >0
	group by PBH.intCutBundleSerial 
	order by PBH.strCutNo ASC";
	$result = $db->RunQuery($sql);
	  
	$ResponseXML1 .= "<cutNo>";
	$ResponseXML1 .= "<![CDATA[";
	$ResponseXML1 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	$ResponseXML2 .= "<StartDate>";
	$ResponseXML2 .= "<![CDATA[";
	while($row = mysql_fetch_array($result))
	{
		$tmpDateDescT=$row["dtmDate"];
		$ArrayDateDesc = explode('-',$tmpDateDescT);
		$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		
		$ResponseXML1 .= "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNo"] ."</option>";
		$ResponseXML2 .= $row["dtmDate"];
	}
$ResponseXML1 .= "]]>"."</cutNo>";
$ResponseXML2 .= "]]>"."</StartDate>";
$ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2. "</headerCutNo>";
echo $ResponseXML;	
}
//------------Load Po No------------------------------------------------------------
if (strcmp($RequestType,"loadPoNo") == 0)
{
	$ResponseXML= "<headerPoNo>";
	$factoryID = $_GET["factoryID"];
//	$lineNo = $_GET["lineNo"];
//	$cutBundleSerial = $_GET["cutNo"];
	
	 /*$sql = "SELECT productionlineinputheader.intStyleId, orders.strOrderNo, productionbundleheader.strPatternNo FROM 
	  productionlineinputheader
	  LEFT JOIN orders ON productionlineinputheader.intStyleId = orders.intStyleId
	  LEFT JOIN productionbundleheader ON productionlineinputheader.strCutNo = productionbundleheader.strCutNo
	  WHERE 
	  productionlineinputheader.intFactory = '".$factoryID."' 
	  AND productionlineinputheader.strTeamNo = '".$lineNo."'  
	  GROUP BY  productionlineinputheader.intStyleId order by orders.strOrderNo ASC";*/

	 $sql = "SELECT productionlineinputheader.intStyleId, orders.strOrderNo, productionbundleheader.strPatternNo FROM 
	  productionlineinputheader
	  LEFT JOIN orders ON productionlineinputheader.intStyleId = orders.intStyleId
	  LEFT JOIN productionbundleheader ON productionlineinputheader.strCutNo = productionbundleheader.strCutNo
	  WHERE 
	  productionlineinputheader.intFactory = '".$factoryID."'  
	  GROUP BY  productionlineinputheader.intStyleId order by orders.strOrderNo ASC";

	  global $db;
	  $result = $db->RunQuery($sql);
	  
		$k=0;
		$ResponseXML1 .= "<PatternNo><![CDATA[" . $row["strPatternNo"] . "]]></PatternNo>\n";
		$ResponseXML2 .= "<PoNo>";
		$ResponseXML2 .= "<![CDATA[";
		$ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML2 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		$k++;
	 }

	$ResponseXML2 .= "]]>"."</PoNo>";
	 
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2. "</headerPoNo>";
	 echo $ResponseXML;	
}
//--------Load Header to serial no ----------------------------------------------
if (strcmp($RequestType,"LoadHeaderToSerial") == 0)
{
$ResponseXML	= "<Styles>";
$serial 		= $_GET["serialNo"];
$year 			= $_GET["year"];
	
$sql = "SELECT 
PLOH.dtmDate AS Date,
PLIH.dtmDate AS StartDate,
PLOH.intFactory,
PLOH.strTeamNo,
PLOH.intStyleId,
O.strOrderNo,
PLOD.intCutBundleSerial,
PLOD.dblBundleNo,
PLOH.strCutNo AS strCutNoHeader,
PBH.strCutNo AS strCutNoDetails
FROM productionlineoutdetail PLOD
inner join productionbundleheader PBH ON PBH.intCutBundleSerial = PLOD.intCutBundleSerial
inner join productionbundledetails PBD ON PBD.dblBundleNo = PLOD.dblBundleNo and PBD.intCutBundleSerial = PLOD.intCutBundleSerial
inner join productionlineindetail PLID ON PLOD.dblBundleNo = PLID.dblBundleNo AND PLOD.intCutBundleSerial = PLID.intCutBundleSerial
inner join productionlineinputheader PLIH ON PLIH.intLineInputSerial = PLID.intLineInputSerial and PLIH.intLineInputYear = PLID.intLineInputYear
inner join productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial and PLOH.intLineOutputYear = PLOD.intLineOutputYear
inner join orders O ON PLOH.intStyleId = O.intStyleId
-- LEFT JOIN productionwashreadydetail ON PBD.dblBundleNo != productionwashreadydetail.dblBundleNo AND PBD.intCutBundleSerial != productionwashreadydetail.intCutBundleSerial 
WHERE PLOH.intLineOutputSerial = '".$serial."' 
AND PLOH.intLineOutputYear = '".$year."'";
$result = $db->RunQuery($sql);

$k=0;
$ResponseXML1 .= "<factory>";
$ResponseXML1 .= "<![CDATA[";

$ResponseXML2 .= "<lineNo>";
$ResponseXML2 .= "<![CDATA[";

$ResponseXML3 .= "<PoNo>";
$ResponseXML3 .= "<![CDATA[";

$ResponseXML4 .= "<cutNo>";
$ResponseXML4 .= "<![CDATA[";

$ResponseXML5 .= "<bundleNo>";
$ResponseXML5 .= "<![CDATA[";

$ResponseXML6 .= "<date>";
$ResponseXML6 .= "<![CDATA[";

$ResponseXML7 .= "<start>";
$ResponseXML7 .= "<![CDATA[";
		
	$tempBundle="";	
	$noOfBundle=0;
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML12 = $ResponseXML1.$row["intFactory"] ;
		$ResponseXML22 =$ResponseXML2. "<option value=\"". $row["strTeamNo"] ."\">" . $row["strTeamNo"] ."</option>";
		$ResponseXML32 =$ResponseXML3. "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		
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
		
		$tmpDateDescT=$row["StartDate"];
		$ArrayDateDesc = explode('-',$tmpDateDescT);
		$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$ResponseXML72 = $ResponseXML7. $DateDesc ;
		$k++;
	 }
	 
	$ResponseXML12 .= "]]>"."</factory>";
	$ResponseXML22 .= "]]>"."</lineNo>";
	$ResponseXML32 .= "]]>"."</PoNo>";
	$ResponseXML42 .= "]]>"."</cutNo>";
	$ResponseXML52 .= "]]>"."</bundleNo>";
	$ResponseXML62 .= "]]>"."</date>";
	$ResponseXML72 .= "]]>"."</start>";
	
	 $ResponseXML .=  $ResponseXML12.$ResponseXML22.$ResponseXML32.$ResponseXML42.$ResponseXML52.$ResponseXML62.$ResponseXML72."</Styles>";
	 echo $ResponseXML;	
}
//------------Load Bundle No------------------------------------------------------------
if (strcmp($RequestType,"loadBundleNo") == 0)
{
$ResponseXML	 = "<headerBundleNo>";
$factoryID 		 = $_GET["factoryID"];
$lineNo 		 = $_GET["lineNo"];
$cutBundleSerial = $_GET["cutNo"];
$PoNo 			 = $_GET["PoNo"];
	
	$sql = "SELECT DISTINCT PLID.dblBundleNo, PLIH.dtmDate 
	FROM productionlineinputheader PLIH	
	inner join productionlineindetail PLID ON PLIH.intLineInputSerial = PLID.intLineInputSerial and PLIH.intLineInputYear = PLID.intLineInputYear
	-- inner join orders O ON PLIH.intStyleId = O.intStyleId
	inner join productionbundleheader PBH ON PLID.intCutBundleSerial = PBH.intCutBundleSerial
	WHERE PLID.dblBalQty > 0 
	AND PLIH.intFactory = '".$factoryID."' 
	AND PLIH.strTeamNo = '".$lineNo."'";
if($cutBundleSerial!="")
	$sql .= " AND PLID.intCutBundleSerial = '".$cutBundleSerial."'"; 
if($PoNo!="")
	$sql .= " AND PLIH.intStyleId = '".$PoNo."'" ;
	$sql .= " order by PLID.dblBundleNo ASC";
	$result = $db->RunQuery($sql);

	$tmpDate = "";
	$ResponseXML1 .= "<StartDate>";
	$ResponseXML1 .= "<![CDATA[";
	$ResponseXML2 .= "<BundleNo>";
	$ResponseXML2 .= "<![CDATA[";
	$ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	 while($row = mysql_fetch_array($result))
	 {
		if($tmpDate!=$row["dtmDate"])
		{			
			$tmpDateDescT=$row["dtmDate"];
			$ArrayDateDesc = explode('-',$tmpDateDescT);
			$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
			
			$ResponseXML1 .=  $row["dtmDate"];
			$tmpDate=$row["dtmDate"];
		}		
		$ResponseXML2 .= "<option value=\"". $row["dblBundleNo"] ."\">" . $row["dblBundleNo"] ."</option>";
	 }
$ResponseXML1 .= "]]>"."</StartDate>";
$ResponseXML2 .= "]]>"."</BundleNo>";
$ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2. "</headerBundleNo>";
echo $ResponseXML;	
}
//----------------------------------Load Grid ----------------------------------------------
if (strcmp($RequestType,"LoadGrid") == 0)
{
$ResponseXML		= "<Grid>";
$searchYear 		= $_GET["searchYear"];
$searchOutputNo 	= $_GET["searchOutputNo"];
$factoryID 			= $_GET["factoryID"];
$lineNo 			= $_GET["lineNo"];
$cutBundleSerial	= $_GET["cutNo"];
$PoNo 				= $_GET["PoNo"];
$bundleNo 			= $_GET["bundleNo"];
	
if(($searchYear!="") AND ($searchOutputNo!=""))
{
$sql = "SELECT
PBD.strSize,
PBD.dblBundleNo,
PBD.strNoRange,
PBD.strShade,
PBD.intCutBundleSerial,
PLOH.dtmDate,
PLOH.strCutNo AS strCutNoHeader,
PBH.strCutNo AS strCutNoDetails,
PLOD.intLineOutputYear,
PLOD.dblQty,
PLOD.strRemarks,
PLID.dblBalQty,
PBH.strColor
FROM productionlineoutdetail PLOD
Inner Join productionbundleheader PBH ON PBH.intCutBundleSerial = PLOD.intCutBundleSerial
Inner Join productionbundledetails PBD ON PBD.intCutBundleSerial = PBH.intCutBundleSerial and PLOD.dblBundleNo = PBD.dblBundleNo
Inner Join productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial and PLOH.intLineOutputYear = PLOD.intLineOutputYear
-- Left Join productionwashreadydetail PWRD ON PBD.intCutBundleSerial = PWRD.intCutBundleSerial
Inner Join productionlineindetail PLID ON PLOD.intCutBundleSerial = PLID.intCutBundleSerial and PLOD.dblBundleNo = PLID.dblBundleNo
WHERE PLOH.intLineOutputSerial = '".$searchOutputNo."' AND PLOH.intLineOutputYear = '".$searchYear."' 
GROUP BY PBD.dblBundleNo";
}
else
{
	$sql = "SELECT  
	PBD.strSize,
	PBD.dblBundleNo,
	PBD.strNoRange,
	PBD.strShade,
	PBD.intCutBundleSerial,
	PLIH.strCutNo AS strCutNoInput,
	PLID.intLineInputYear,
	PLID.dblBalQty ,
	productionbundleheader.strColor
	FROM productionlineindetail PLID
	inner join productionbundledetails PBD ON PBD.dblBundleNo = PLID.dblBundleNo AND PBD.intCutBundleSerial = PLID.intCutBundleSerial 
	inner join productionlineinputheader PLIH ON PLIH.intLineInputSerial = PLID.intLineInputSerial and PLIH.intLineInputYear = PLID.intLineInputYear
	Inner Join productionbundleheader ON PBD.intCutBundleSerial = productionbundleheader.intCutBundleSerial
	WHERE PLID.dblBalQty >0 AND PLIH.intFactory = '".$factoryID."' AND PLIH.strTeamNo = '".$lineNo."'";
if($cutBundleSerial!="")
	$sql .=" AND PLID.intCutBundleSerial = '".$cutBundleSerial."'";
if($bundleNo!="")
	$sql .=" AND PLID.dblBundleNo = '".$bundleNo."'";
if($PoNo!="")
	$sql .=" AND PLIH.intStyleId = '".$PoNo."'";
	$sql .=" GROUP BY PBD.dblBundleNo";
}
	$remark="";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{	 
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<CutBundserial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundserial>\n";
		$ResponseXML .= "<BundlNo><![CDATA[" . $row["dblBundleNo"]  . "]]></BundlNo>\n";
		$ResponseXML .= "<Range><![CDATA[" . $row["strNoRange"]  . "]]></Range>\n";
		$ResponseXML .= "<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>\n";
		
		if(($searchYear!="") AND ($searchOutputNo!=""))
		{
			$date=$row["dtmDate"];
			$ArrayDateDesc = explode('-',$date);
			$date = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
			$ResponseXML .= "<cutNo><![CDATA[" .  $row["strCutNoDetails"]  . "]]></cutNo>\n";
			$ResponseXML .= "<Input><![CDATA[" . $row["dblBalQty"]  . "]]></Input>\n";
			$ResponseXML .= "<OutPut><![CDATA[" . $row["dblQty"]  . "]]></OutPut>\n";
			$remark =$row["strRemarks"];
		}
		else
		{
			$date="";
			$ResponseXML .= "<cutNo><![CDATA[" .  $row["strCutNoInput"]  . "]]></cutNo>\n";
			$ResponseXML .= "<Input><![CDATA[" . $row["dblBalQty"]  . "]]></Input>\n";
			$ResponseXML .= "<OutPut><![CDATA[" . $row["dblBalQty"]  . "]]></OutPut>\n";
		}
		
		$ResponseXML .= "<date><![CDATA[" .  $date  . "]]></date>\n";
		$ResponseXML .= "<Remarks><![CDATA[" .  $remark  . "]]></Remarks>\n";
		$ResponseXML .= "<color><![CDATA[" . $row["strColor"] . "]]></color>\n";
	}	 
$ResponseXML .= "</Grid>";
echo $ResponseXML;	
}
//----------------save Line Output header---------------------------------------
if (strcmp($RequestType,"SaveLineOutputHeader") == 0)
{
	$factory = $_GET["factory"];
	$OutputYear = $_GET["OutputYear"];
	$styleID = $_GET["styleID"];
	$teamID = $_GET["teamID"];
	
	$OutputDateTemp = $_GET["OutputDate"];
	$AppDateFromArray		= explode('/',$OutputDateTemp);
	$OutDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	
	$pattern = $_GET["pattern"];
	$cutNo = $_GET["cutNo"];
	$totQty = $_GET["totQty"];
	$totBalQty = $_GET["totBalQty"];
	$Status = $_GET["Status"];

	
	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchOutputNo = $_GET["searchOutputNo"];
	//--------------------
	
	 if (($searchYear!="") AND ($searchOutputNo!=""))
	 {
	   $lineOutputSerial=$searchOutputNo;	
	   $OutputYear=$searchYear;
	   
	 	$result=UpdateProductLineOutputHeader($lineOutputSerial,$factory,$OutputYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$OutDate);
	 }
	 else
	 {
	   $lineOutputSerial=SelectMaxLineOutputSerialNo();	
	 
	   $result=SaveProductLineOutputHeader($lineOutputSerial,$factory,$OutputYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$OutDate);
	   
	 }	 
	
	   
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	 $ResponseXML .= "<Outputserial><![CDATA[" . $lineOutputSerial  . "]]></Outputserial>\n";
	$ResponseXML .= "<OutputYear><![CDATA[" . $OutputYear  . "]]></OutputYear>\n";
	 $ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}
//-------check whether the record is existing--------------------------
function CheckExistHeader($factory,$OutputYear,$styleID,$teamID,$pattern,$cutNo)
{
	global $db;
	$sql= "select * from productionlineoutputheader WHERE intFactory = '". $factory ."' AND intLineOutputYear = '". $OutputYear ."' AND intStyleId = '". $styleID ."' AND strTeamNo = '". $teamID ."' AND strPatternNo = '". $pattern ."' AND strCutNo = '". $cutNo ."'";
	return $db->RunQuery($sql);
}
//-------update header file-----------------------------------------------------------------------
function UpdateProductLineOutputHeader($lineOutputSerial,$factory,$OutputYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$OutDate)
{
	global $db;
	$sql= "UPDATE productionlineoutputheader SET  dtmDate='$OutDate' WHERE intFactory='$factory' AND intLineOutputYear='$OutputYear' AND intStyleId='$styleID' AND strTeamNo='$teamID' AND strPatternNo='$pattern' AND strCutNo='$cutNo' AND intLineOutputSerial='$lineOutputSerial'";
	return $db->RunQuery($sql);
}
//-------retrieve existing  intLineOutputSerial & update it by adding 1---------------------------------------

function SelectMaxLineOutputSerialNo(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sql1="SELECT MAX(intLineOutputSerial) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result= $db->RunQuery($sql1);

	$row = mysql_fetch_array($result);
	$old= $row["MAX(intLineOutputSerial)"];
	$newSerial=$old+1;
	
		updateSysControl($old,$newSerial);
		return $old; 
}
//--------update syscontrol for intLineOutputSerial(by Adding 1)----------------------
function updateSysControl($old,$newSerial){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET intLineOutputSerial='$newSerial' WHERE intLineOutputSerial='$old' and intCompanyID='$intCompanyId'";
	 $db->executeQuery($sqls);
}
//-------save new record for header---------------------------------------------------
function SaveProductLineOutputHeader($lineOutputSerial,$factory,$OutputYear,$styleID,$teamID,$pattern,$cutNo,$totQty,$totBalQty,$Status,$OutDate)
{

	global $db;
	$sql= "INSERT INTO productionlineoutputheader(intLineOutputSerial ,intFactory ,intLineOutputYear ,intStyleId, strTeamNo ,strPatternNo ,strCutNo, dblTotQty, dblBalQty, intStatus, dtmDate) VALUES($lineOutputSerial, $factory, $OutputYear, $styleID, '$teamID', '$pattern', '$cutNo', $totQty, $totBalQty, $Status, '$OutDate')";
	return $db->RunQuery($sql);
}
//----------------Save Line Output Details-----------------------------------------------
if (strcmp($RequestType,"SaveLineOutputDetails") == 0)
{
	$lineOutputSerial = $_REQUEST["lineOutputSerial"];
	$year = $_REQUEST["year"];
	$factory = $_REQUEST["factory"];
	$cutBundleSerial = $_REQUEST["CutBundleSerial"];
	$bundleNo = $_REQUEST["BundleNo"];
	$qty = $_REQUEST["Qty"];
	$balQty = $_REQUEST["BalQty"];
	$remark = $_REQUEST["remark"];
		
	$totQty=0;
	$totBalQty=0;
	$x=0;
	
			$ExistQty = CheckExistDetails($lineOutputSerial,$year,$cutBundleSerial,$bundleNo);
			 if ($ExistQty != "")
			 {
	            $result=UpdateLineOutputDetails($lineOutputSerial,$year,$cutBundleSerial,$bundleNo,$qty,$qty,$ExistQty,$remark);
			 }
			 else{
			   $ExistQty=0;
		       $result=SaveLineOutputDetails($lineOutputSerial,$year,$cutBundleSerial,$bundleNo,$qty,$qty,$remark);
			   
			 }
			 
			$totQty += $qty;
			$totBalQty += $balQty;
			
		   updategpinputdetailForBalQty($cutBundleSerial,$bundleNo,$ExistQty,$qty,$year);

		   $wipQty=$qty-$ExistQty;
		   update_production_wip($factory,$cutBundleSerial,"intOutPutQty",$wipQty);		 
			 
		
	//------Update Header file for totQty & totBalQty
	updateProductionlineoutputheaderQty($lineOutputSerial,$year,$totQty,$totBalQty);	
		
	
	 $ResponseXML .= "<ResultDetails>";
	 $ResponseXML .= "<result><![CDATA[" . $result  . "]]></result>\n";
	 $ResponseXML .= "</ResultDetails>";
	 echo $ResponseXML;	 
}
//-----check whether record existing in detail file------------------------------------------------
function CheckExistDetails($lineOutputSerial,$year,$cutBundleSerial,$bundleNo)
{
	global $db;
	$sql= "select * from productionlineoutdetail where intLineOutputSerial = ". $lineOutputSerial ." AND intLineOutputYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["dblQty"];
	return $exitQty;
}
//------Update records in details file------------------------------------------------------------------
function UpdateLineOutputDetails($lineOutputSerial,$year,$cutBundleSerial,$bundleNo,$qty,$balQty,$ExistQty,$remarks)
{
	global $db;
   $sql= "UPDATE productionlineoutdetail SET dblQty='$qty',strRemarks='$remarks' WHERE intLineOutputSerial = ". $lineOutputSerial ." AND intLineOutputYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
     $db->RunQuery($sql);
	 
    $sql2= "UPDATE productionlineoutdetail SET dblBalQty=(dblBalQty+'$qty'-'$ExistQty') WHERE intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
     return $db->RunQuery($sql2);
}
//-----Save Record in details file------------------------------------------------------------------
function SaveLineOutputDetails($lineOutputSerial,$year,$cutBundleSerial,$bundleNo,$qty,$balQty,$remark)
{
	global $db;
	
	 $sql2= "select MAX(dblBalQty) from productionlineoutdetail where intLineOutputYear= ". $year ." AND intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	 $MaxbalQty = $row["MAX(dblBalQty)"]+$balQty;
	
	
	$sql= "INSERT INTO productionlineoutdetail(intLineOutputSerial,intLineOutputYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,strRemarks) VALUES($lineOutputSerial,$year,$cutBundleSerial,$bundleNo,$qty,$balQty,'$remark')";
     $res1=$db->RunQuery($sql);
	 
     $sql= "UPDATE productionlineoutdetail SET  dblBalQty= ". $MaxbalQty ." where intCutBundleSerial = ". $cutBundleSerial ." AND dblBundleNo= ". $bundleNo . " ";
	return $db->RunQuery($sql);
	 
}
//------------------------------------------------------------------------------------------
function updategpinputdetailForBalQty($cutBundleSerial,$bundleNo,$ExistQty,$qty,$year){
global $db;
	
	 $sql2= "select * from productionlineindetail where intCutBundleSerial= '". $cutBundleSerial ."' AND dblBundleNo= '". $bundleNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
		$balQty = $ExistQty+$row["dblBalQty"]-$qty;
	
	  $sql= "UPDATE productionlineindetail SET dblBalQty='$balQty' where intCutBundleSerial= '". $cutBundleSerial ."' AND dblBundleNo= '". $bundleNo ."'";
	 	$db->executeQuery($sql);
}
//--------Update productionlineoutputheader for total line output Quantities------------------------
function updateProductionlineoutputheaderQty($lineOutputSerial,$year,$totQty,$totBalQty){
global $db;
	
	 $sql2= "select * from productionlineoutdetail where intLineOutputSerial = '". $lineOutputSerial ."' AND intLineOutputYear= '". $year ."'";
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
	
	$sql= "UPDATE productionlineoutputheader SET dblTotQty='$totQty',dblBalQty='$totBalQty' WHERE intLineOutputSerial='$lineOutputSerial' AND intLineOutputYear='$year'";
	 	$db->executeQuery($sql);
}

if (strcmp($RequestType,"URLLoadOrders") == 0)
{
	$sql = "SELECT distinct PLIH.intStyleId, O.strOrderNo 
	FROM productionlineinputheader PLIH
	inner join productionlineindetail PLID on PLIH.intLineInputSerial=PLID.intLineInputSerial and PLIH.intLineInputYear=PLID.intLineInputYear
	inner JOIN orders O ON PLIH.intStyleId = O.intStyleId
	WHERE PLIH.intFactory = '".$_SESSION["FactoryID"]."'
	and PLID.dblBalQty >0
	GROUP BY  PLIH.intStyleId 
	order by O.strOrderNo ASC";
	$result = $db->RunQuery($sql);
		echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
	}
}
?>