<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType    = $_GET["RequestType"];
$intCompanyId	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

//------------Load Style,Po No,Cut Nos------------------------------------------------------------
if (strcmp($RequestType,"loadStylePoCutNo") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	
	 $sqlS = "SELECT 
	 orders.strOrderNo, 
	 productionbundleheader.intStyleId,
	 productionbundleheader.strCutNo, 
	 orders.strStyle,
	 productionbundleheader.intCutBundleSerial 
	 FROM
	  productionbundleheader
	  LEFT JOIN productiongptindetail ON productionbundleheader.intCutBundleSerial = productiongptindetail.intCutBundleSerial
	  LEFT JOIN productiongptinheader ON productiongptindetail.dblCutGPTransferIN = productiongptinheader.dblCutGPTransferIN
	  LEFT JOIN orders ON productionbundleheader.intStyleId = orders.intStyleId
	  WHERE productiongptinheader.intFactoryId = '".$factoryID."' group by productionbundleheader.intStyleId order by productionbundleheader.strCutNo ASC";

$k=0;
     global $db;
	 $resultS = $db->RunQuery($sqlS);
	 while($row = mysql_fetch_array($resultS))
	 {
	 if($k==0){
		
		$ResponseXML1 .= "<style>";
		$ResponseXML1 .= "<![CDATA[";
		$ResponseXML1 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
		
		$ResponseXML2 .= "<orderNo>";
		$ResponseXML2 .= "<![CDATA[";
		$ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
		
		$ResponseXML3 .= "<cutPC>";
		$ResponseXML3 .= "<![CDATA[";
		$ResponseXML3 .="<option value=\"". "" ."\">" . "" ."</option>" ;
		}
		//$ResponseXML .= "\n";
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML2 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		$ResponseXML3 .= "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNo"] ."</option>";
			
		$k++;
	 }
	 if($k>0){
	$ResponseXML1 .= "]]>"."</style>";
	$ResponseXML2 .= "]]>"."</orderNo>";
	$ResponseXML3 .= "]]>"."</cutPC>";
	
	// $ResponseXML .= "</cutPC>";
	 }
	 
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2.$ResponseXML3. "</Styles>";
	 echo $ResponseXML;	
}
//--------Load Cut Nos(releven to the style no)----------------------------------------------
if (strcmp($RequestType,"LoadCutNo") == 0)
{
$ResponseXML = "<Styles>";
$styleID 	 = $_GET["styleID"];

	/*$sql = "SELECT PBH.intCutBundleSerial,PBH.strCutNo 
	FROM productionbundleheader PBH join productiongptindetail PTID on PBH.intCutBundleSerial=PTID.intCutBundleSerial 
	WHERE PBH.intStyleId = '".$styleID."' AND PTID.dblBalQty >0 
	group by PBH.strCutNo 
	order by PBH.strCutNo";*/
	
	$sql="SELECT PBH.intCutBundleSerial,PBH.strCutNo 
			FROM productionbundleheader PBH
			INNER JOIN productiongptindetail PTID ON PBH.intCutBundleSerial=PTID.intCutBundleSerial 
			INNER JOIN productiongptinheader PGTIH ON PTID.dblCutGPTransferIN = PGTIH.dblCutGPTransferIN AND PTID.intGPTYear = PGTIH.intGPTYear
			WHERE PBH.intStyleId = '$styleID' AND PTID.dblBalQty >0 
			AND intFactoryId='$intCompanyId'
			GROUP BY PBH.strCutNo 
			ORDER BY PBH.strCutNo";
	$result = $db->RunQuery($sql);	
	$ResponseXML .= "<cutPC>";
	$ResponseXML .= "<![CDATA[";
	$ResponseXML .= "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNo"] ."</option>";
	}
 
$ResponseXML .= "]]>"."</cutPC>";
$ResponseXML .=  "</Styles>";
echo $ResponseXML;	
}
//--------Load Cut No to serial no (releven to the style no)----------------------------------------------
if (strcmp($RequestType,"LoadCutNoToSerial") == 0)
{
	$ResponseXML= "<Styles>";
	$serial = $_GET["serialNo"];
	$year = $_GET["year"];
	
	 $sql = "SELECT Distinct productionlineindetail.intCutBundleSerial,
	 	 orders.strStyle,
		 orders.strOrderNo,
 productionlineinputheader.strCutNo, productionlineinputheader.intFactory, productionlineinputheader.intStyleId from productionlineindetail 
	join productionlineinputheader  
	on productionlineinputheader.intLineInputSerial=productionlineindetail.intLineInputSerial
	inner JOIN orders ON productionlineinputheader.intStyleId = orders.intStyleId
	 where productionlineinputheader.intLineInputSerial = '".$serial."' and productionlineinputheader.intLineInputYear = '".$year."'";
//removed-(15/09/2010)- (AND productionbundleheader.strStatus!=2)
	global $db;
	$result = $db->RunQuery($sql);
	
	$k=0;
	$ResponseXML1 .= "<style>";
	$ResponseXML1 .= "<![CDATA[";
	
	$ResponseXML2 .= "<orderNo>";
	$ResponseXML2 .= "<![CDATA[";
	
	$ResponseXML3 .= "<cutPC>";
	$ResponseXML3 .= "<![CDATA[";
	
	$ResponseXML4 .= "<factory>";
	$ResponseXML4 .= "<![CDATA[";
		
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML2 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		$ResponseXML3 .= "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strCutNo"] ."</option>";
		$ResponseXML4 .= $row["intFactory"] ;
		$k++;
	 }
	 
	$ResponseXML1 .= "]]>"."</style>";
	$ResponseXML2 .= "]]>"."</orderNo>";
	$ResponseXML3 .= "]]>"."</cutPC>";
	$ResponseXML4 .= "]]>"."</factory>";
	
	$ResponseXML .=  $ResponseXML1.$ResponseXML2.$ResponseXML3.$ResponseXML4."</Styles>";
	echo $ResponseXML;	
}
//---------Load Pattern No-------------------------------------------------------------------------
if($RequestType =="LoadPattNo")
{
$cutBundleSerial = trim($_GET["cutBundleSerial"],' ');
$ResponseXML	 = "<Styles>";
$ResponseXML 	.= "<pattern>";
$ResponseXML 	.= "<![CDATA[";
	
	$SQL = "SELECT PBH.intCutBundleSerial,PBH.strPatternNo FROM productionbundleheader PBH where PBH.intCutBundleSerial='".$cutBundleSerial."' order by PBH.intCutBundleSerial asc";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intCutBundleSerial"] ."\">" . $row["strPatternNo"] ."</option>" ;
	}
$ResponseXML .= "]]>"."</pattern>";
$ResponseXML .= "</Styles>";
echo $ResponseXML;	
}
//----------------------------------Load Grid ----------------------------------------------
if (strcmp($RequestType,"LoadNewInputDataEntry") == 0)
{
$searchYear 		= $_GET["searchYear"];
$searchInputNo 		= $_GET["searchInputNo"];

$ResponseXML		= "<Styles>";
$cutBundleSerial 	= $_GET["cutBundleSerial"];
$remark				= '';

	if(($searchYear!="") AND ($searchInputNo!=""))
	{
		$sql = "SELECT 
		PBD.strSize,
		PBD.dblBundleNo,
		PBD.intCutBundleSerial,
		PBD.strNoRange,
		PBD.strShade,
		PLIH.dtmDate,
		PLIH.strTeamNo,
		PLID.intLineInputYear,
		PLID.dblQty,
		PLID.strRemarks,
		PGTD.dblBalQty,
		productionbundleheader.strColor
		FROM productionlineindetail PLID
		Inner Join productionbundledetails PBD ON PLID.intCutBundleSerial = PBD.intCutBundleSerial and PLID.dblBundleNo = PBD.dblBundleNo
		Inner Join productionlineinputheader PLIH ON PLID.intLineInputSerial = PLIH.intLineInputSerial and PLID.intLineInputYear = PLIH.intLineInputYear
		Inner Join productiongptindetail PGTD ON PGTD.intCutBundleSerial = PBD.intCutBundleSerial
		Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = PBD.intCutBundleSerial
		WHERE PLID.intLineInputSerial = '".$searchInputNo."' AND PLID.intLineInputYear = '".$searchYear."' 
		GROUP BY PLID.dblBundleNo";	
	}
	else
	{
		$sql ="SELECT
		PGTD.intCutBundleSerial,
		PGTD.dblBundleNo,
		PGTD.dblBalQty,
		PBD.strSize,
		PBD.strShade,
		PBD.strNoRange,
		productionbundleheader.strColor
		FROM productiongptindetail PGTD
		Inner Join productionbundledetails PBD ON PGTD.intCutBundleSerial = PBD.intCutBundleSerial AND PGTD.dblBundleNo = PBD.dblBundleNo
		Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = PBD.intCutBundleSerial
		WHERE 
		PGTD.intCutBundleSerial = '".$cutBundleSerial."' AND
		PGTD.dblBalQty >0 
		GROUP BY
		PGTD.intCutBundleSerial,
		PGTD.dblBundleNo ";//removed---(15/09/2010)-( AND productiongptindetail.intStatus!=2) & added ---(JOIN productionlineoutdetail ON productionbundledetails.dblBundleNo != productionlineoutdetail.dblBundleNo AND productionbundledetails.intCutBundleSerial != productionlineoutdetail.intCutBundleSerial) 
	}

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<CutBundserial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundserial>\n";
		$ResponseXML .= "<BundlNo><![CDATA[" . $row["dblBundleNo"]  . "]]></BundlNo>\n";
		$ResponseXML .= "<Range><![CDATA[" . $row["strNoRange"]  . "]]></Range>\n";
		$ResponseXML .= "<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>\n";
		
		if(($searchYear!="") AND ($searchInputNo!=""))
		{
			$date	= $row["dtmDate"];
			$ArrayDateDesc = explode('-',$date);
			$date 	= $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
			$team	= $row["strTeamNo"];
			$balQty	= $row["dblBalQty"];
		
			$ResponseXML .= "<Pcs><![CDATA[" . $balQty  . "]]></Pcs>\n";
			$ResponseXML .= "<Recieved><![CDATA[" .  $row["dblQty"]  . "]]></Recieved>\n";
			$ResponseXML .= "<date><![CDATA[" .  $date  . "]]></date>\n";
			$ResponseXML .= "<team><![CDATA[" .  $team  . "]]></team>\n";
			$ResponseXML .= "<remark><![CDATA[" .  $row["strRemarks"]  . "]]></remark>\n";
			$ResponseXML .= "<color><![CDATA[" .  $row["strColor"]  . "]]></color>\n";
		}
		else
		{
			$date="";
			$team="";
			$ResponseXML .= "<Pcs><![CDATA[" . $row["dblBalQty"]  . "]]></Pcs>\n";
			$ResponseXML .= "<Recieved><![CDATA[" .  $row["dblBalQty"]  . "]]></Recieved>\n";
			$ResponseXML .= "<date><![CDATA[" .  $date  . "]]></date>\n";
			$ResponseXML .= "<team><![CDATA[" .  $team  . "]]></team>\n";
			$ResponseXML .= "<remark><![CDATA[" .  $remark  . "]]></remark>\n";
			$ResponseXML .= "<color><![CDATA[" .  $row["strColor"]  . "]]></color>\n";
		}		
	 }	 
$ResponseXML .= "</Styles>";
echo $ResponseXML;	
}

//----------------save Line input header---------------------------------------
if (strcmp($RequestType,"SaveLineInputHeader") == 0)
{
	$factory = $_GET["factory"];
	$InpYear = $_GET["InpYear"];
	$styleID = $_GET["styleID"];
	$Status = $_GET["Status"];
	
	$GPTransferInDateT = $_GET["InputDate"];
	$AppDateFromArray		= explode('/',$GPTransferInDateT);
	$GPTransferInDateT;
	$InDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	
	$cutNo = $_GET["cutNo"];
	$teamNo = $_GET["teamNo"];
	$patternNo = $_GET["patternNo"];
	$totQty =$_GET["totQty"];
	$totBalQty = $_GET["totBalQty"];

	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchInput = $_GET["searchInput"];
	//--------------------
	
	 if (($searchYear!="") AND ($searchInput!=""))
	 {
	   $intLineInputSerial=$searchInput;
	   $InpYear=$searchYear;	
	 
		$result=UpdateProductLineInpHeader($intLineInputSerial,$InpYear,$InDate,$factory,$teamNo,$styleID,$cutNo,$patternNo,$totQty,$totBalQty,$Status);
	 }
	 else
	 {
	   $intLineInputSerial=SelectMaxLineInpSerialNo();	
	 
	   $result=SaveProductLineInpHeader($intLineInputSerial,$InpYear,$InDate,$factory,$teamNo,$styleID,$cutNo,$patternNo,$totQty,$totBalQty,$Status);
	   
	 }	 
	
	   
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	$ResponseXML .= "<Inputserial><![CDATA[" . $intLineInputSerial  . "]]></Inputserial>\n";
	$ResponseXML .= "<InputserialYear><![CDATA[" . $InpYear  . "]]></InputserialYear>\n";
	$ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}

//----------------Save Line Input Details-----------------------------------------------
if (strcmp($RequestType,"SaveLineInputDetails") == 0)
{
	$factory = $_REQUEST["factory"];
	$lineInputSerial = $_REQUEST["lineInputSerial"];
	$cutBundSerail = $_REQUEST["cutBundSerail"];
	$cutNo = $_REQUEST["cutNo"];
	$styleID = $_REQUEST["styleID"];
	$year = $_REQUEST["year"];
	$BundleNo = $_REQUEST["BundleNo"];
	$Qty = $_REQUEST["Qty"];
	$BalQty = $_REQUEST["BalQty"];
	$remarks = $_REQUEST["remarks"];
	
	$totQty=0;
	$totBalQty=0;
	$x=0;
	
	//------------------------------
	$ExistQty = CheckExistDetails($lineInputSerial,$year,$cutBundSerail,$BundleNo);
	if ($ExistQty != "")//update existing record
	{
	$result=UpdateLineInputDetails($lineInputSerial,$year,$cutBundSerail,$BundleNo,$Qty,$Qty,$ExistQty,$remarks);
	}
	else{
	$ExistQty=0;//insert as new record
	$result=SaveLineInputDetails($lineInputSerial,$year,$cutBundSerail,$BundleNo,$Qty,$Qty,$remarks);
	}
	
	$totQty += $Qty;
	$totBalQty += $BalQty;
	
	//update balance qty of previous process(transferin).
	updategptindetailForBalQty($cutBundSerail,$BundleNo,$ExistQty,$Qty,$year);
	
	//update production wip
	$wipQty=$Qty-$ExistQty;
	update_production_wip($factory,$cutBundSerail,"intInputQty",$wipQty);		 

	//update Header file for totQty & totBalQty
	productionlineinputheaderQty($lineInputSerial,$year,$totQty,$totBalQty);	
		
	//--------------------------------------
	$ResponseXML .= "<ResultDetails>";
	$ResponseXML .= "<year><![CDATA[".$year."]]></year>\n";
	$ResponseXML .= "<serial><![CDATA[".$lineInputSerial."]]></serial>\n";
	$ResponseXML .= "<result><![CDATA[" . $result  . "]]></result>\n";
	$ResponseXML .= "</ResultDetails>";
	echo $ResponseXML;	 
}
//-------retrieve existing  intLineInputSerial & update it by adding 1---------------------------------------
if (strcmp($RequestType,"URLLoadOrders") == 0)
{
	$SQL = "SELECT O.strOrderNo,PBH.intStyleId,PBH.strCutNo,O.strStyle,PBH.intCutBundleSerial FROM productionbundleheader PBH inner join productiongptindetail PGTID ON PBH.intCutBundleSerial = PGTID.intCutBundleSerial inner join productiongptinheader PGTIH ON PGTID.dblCutGPTransferIN = PGTIH.dblCutGPTransferIN inner join orders O ON PBH.intStyleId = O.intStyleId WHERE PGTIH.intFactoryId = '".$_SESSION["FactoryID"]."' and PGTID.dblBalQty!=0 group by PBH.intStyleId order by O.strOrderNo ASC";
	$result = $db->RunQuery($SQL);
		echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
	}
}

//-------------------------Cancle line input ----------------------------------------------------------------
if($RequestType=="CancleLineInput")
{
	$lineInputNo 	= $_GET["lineInputNo"];
	$lineInputYear 	= $_GET["lineInputYear"];
	$reason 		= $_GET["reason"];
	$boolcheck = false;
	$ResponseXML .= "<CancleResult>";
	$checkCancle = checkCancleStatus($lineInputNo,$lineInputYear);
	if($checkCancle)
	{
		$checkLineOut = checkLineOutput($lineInputNo,$lineInputYear);
		if($checkLineOut)
		{
			$sql_update = "update productionlineinputheader set intStatus='10',strRemarks='$reason',intCancleBy='$userId',dtmCancleDate=now() where intLineInputSerial='$lineInputNo' and intLineInputYear='$lineInputYear'";
			$result_update= $db->RunQuery($sql_update);
			if($result_update)
				$boolcheck = true;
			else
				$boolcheck = false;
			
			$updateTIBal = "update productiongptindetail PT
Inner join productionlineindetail PL on PL.intCutBundleSerial=PT.intCutBundleSerial and PT.dblBundleNo=PL.dblBundleNo
set PT.dblBalQty = PT.dblBalQty+PL.dblQty
where PL.intLineInputSerial='$lineInputNo' and PL.intLineInputYear='$lineInputYear'";
			$result_updateTIBal= $db->RunQuery($updateTIBal);
			if($result_updateTIBal)
				$boolcheck = true;
			else
				$boolcheck = false;
			
			$sql_prodWip = "select sum(PL.dblQty) as dblQty ,PT.intCutBundleSerial
from productiongptindetail PT
Inner join productionlineindetail PL on PL.intCutBundleSerial=PT.intCutBundleSerial and PL.dblBundleNo=PT.dblBundleNo
where PL.intLineInputSerial='$lineInputNo' and PL.intLineInputYear='$lineInputYear'
group by PL.intLineInputSerial,PL.intLineInputYear";
			$result_prodWip= $db->RunQuery($sql_prodWip);
			$row_proWip = mysql_fetch_array($result_prodWip);
			update_production_wip($intCompanyId,$row_proWip['intCutBundleSerial'],'intInputCancleQty',$row_proWip['dblQty']);
			
			$updateLineInput = "update productionlineindetail set dblBalQty ='0'
where intLineInputSerial='$lineInputNo' and intLineInputYear='$lineInputYear'";
			$result_updateLineInput= $db->RunQuery($updateLineInput);
			if($result_updateLineInput)
				$boolcheck = true;
			else
				$boolcheck = false;
				
			if($boolcheck)
				$ResponseXML .= "<cancleResponse><![CDATA[Updated]]></cancleResponse>\n";
			else
				$ResponseXML .= "<cancleResponse><![CDATA[Error]]></cancleResponse>\n";
		}
		else
			$ResponseXML .= "<cancleResponse><![CDATA[LineOut]]></cancleResponse>\n";
	}
	else
		$ResponseXML .= "<cancleResponse><![CDATA[Cancle]]></cancleResponse>\n";
		
	$ResponseXML .= "</CancleResult>";
	echo $ResponseXML;	  
}
function checkCancleStatus($lineInputNo,$lineInputYear)
{
	global $db;
	$sql = "select intStatus from productionlineinputheader where intLineInputSerial='$lineInputNo' and intLineInputYear='$lineInputYear' ";
	$result= $db->RunQuery($sql);
	$row =  mysql_fetch_array($result);
	if($row["intStatus"]==10)
	return false;
	else
	return true;
}
function checkLineOutput($lineInputNo,$lineInputYear)
{
	global $db;
	$sql = "select sum(PLI.dblQty),sum(coalesce((select sum(PLO.dblQty) from productionlineoutdetail PLO where PLO.intCutBundleSerial=PLI.intCutBundleSerial and PLO.dblBundleNo=PLI.dblBundleNo group by PLO.intCutBundleSerial,PLO.dblBundleNo),0)) as lineout
from productionlineindetail PLI
where PLI.intLineInputSerial='$lineInputNo' and PLI.intLineInputYear='$lineInputYear'
group by PLI.intCutBundleSerial";
	$result= $db->RunQuery($sql);
	$row =  mysql_fetch_array($result);
	if($row["lineout"]==0)
	return true;
	else
	return false;
}
function SelectMaxLineInpSerialNo()
{
	global $db;
	$intCompanyId =	$_SESSION["FactoryID"];
	
	$sql1="SELECT MAX(intLineInputSerial) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result= $db->RunQuery($sql1);
	
	$row = mysql_fetch_array($result);
	$old= $row["MAX(intLineInputSerial)"];
	$newSerial=$old+1;
	
	updateSysControl($old,$newSerial);
	return $old; 
}

//--------update syscontrol for intLineInputSerial(by Adding 1)----------------------
function updateSysControl($old,$newSerial){
	global $db;
	$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET intLineInputSerial='$newSerial' WHERE intLineInputSerial='$old' and intCompanyID='$intCompanyId'";
	$db->executeQuery($sqls);
}

//-------save new record for header---------------------------------------------------
function SaveProductLineInpHeader($intLineInputSerial,$InpYear,$InDate,$factory,$teamNo,$styleID,$cutNo,$patternNo,$totQty,$totBalQty,$Status)
{

	global $db;
	$sql= "INSERT INTO productionlineinputheader(intLineInputSerial ,intLineInputYear ,dtmDate ,intFactory, strTeamNo ,intStyleId ,strCutNo, strPatternNo, dblTotQty, dblBalQty, intStatus) VALUES($intLineInputSerial, $InpYear, '$InDate', $factory, '$teamNo', $styleID, '$cutNo', '$patternNo', $totQty, $totBalQty, $Status)";
	return $db->RunQuery($sql);
}

//-------update header file-----------------------------------------------------------------------
function UpdateProductLineInpHeader($intLineInputSerial,$InpYear,$InDate,$factory,$teamNo,$styleID,$cutNo,$patternNo,$totQty,$totBalQty,$Status)
{
	global $db;
	$sql= "UPDATE productionlineinputheader SET  intFactory='$factory',intLineInputYear='$InpYear',dtmDate='$InDate',intStyleId='$styleID',strPatternNo='$patternNo',strTeamNo='$teamNo' WHERE strCutNo='$cutNo' AND intLineInputSerial='$intLineInputSerial'";
	return $db->RunQuery($sql);
}
//-----check whether record existing in detail file------------------------------------------------
function CheckExistDetails($intLineInputSerial,$year,$cutBundSerail,$BundleNo)
{
	global $db;
	$sql= "select * from productionlineindetail where intLineInputSerial = ". $intLineInputSerial ." AND intLineInputYear= ". $year ." AND intCutBundleSerial = ". $cutBundSerail ." AND dblBundleNo= ". $BundleNo . " ";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["dblQty"];
	return $exitQty;
}

//-----Save Record in detail file------------------------------------------------------------------
function SaveLineInputDetails($lineInputSerial,$year,$cutBundSerail,$BundleNo,$Qty,$BalQty,$remark)
{
	global $db;
	
	$sql2= "select MAX(dblBalQty) from productionlineindetail where intLineInputYear= ". $year ." AND intCutBundleSerial = ". $cutBundSerail ." AND dblBundleNo= ". $BundleNo . " ";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$MaxbalQty = $row["MAX(dblBalQty)"]+$BalQty;
	
	
	$sql1= "INSERT INTO productionlineindetail(intLineInputSerial,intLineInputYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,strRemarks) VALUES($lineInputSerial,$year,$cutBundSerail,$BundleNo,$Qty,$MaxbalQty,'$remark')";
	$db->RunQuery($sql1);
	
	$sql= "UPDATE productionlineindetail SET  dblBalQty= ". $MaxbalQty ." where intCutBundleSerial = ". $cutBundSerail ." AND dblBundleNo= ". $BundleNo . " ";
	return $db->RunQuery($sql);
	 
}

//------Update records in detail file------------------------------------------------------------------
function UpdateLineInputDetails($lineInputSerial,$year,$cutBundSerail,$BundleNo,$Qty,$BalQty,$ExistQty,$remark)
{
	global $db;
	$sql= "UPDATE productionlineindetail SET dblQty='$Qty',strRemarks='$remark' WHERE intLineInputSerial = ". $lineInputSerial ." AND intLineInputYear= ". $year ." AND intCutBundleSerial = ". $cutBundSerail ." AND dblBundleNo= ". $BundleNo . " ";
	$db->RunQuery($sql);
	
	
	$sql2= "UPDATE productionlineindetail SET dblBalQty=(dblBalQty+'$Qty'-'$ExistQty') WHERE intCutBundleSerial = ". $cutBundSerail ." AND dblBundleNo= ". $BundleNo . " ";
	return $db->RunQuery($sql2);
	 
}

//------------------------------------------------------------------------------------------
function updategptindetailForBalQty($CutBundleSerial,$BundleNo,$ExistQty,$Qty,$year){
global $db;
	
	$sql2= "select * from productiongptindetail where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$balQty = $ExistQty+$row["dblBalQty"]-$Qty;
	
	$sql= "UPDATE productiongptindetail SET dblBalQty='$balQty' where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	$db->executeQuery($sql);
}
//-----hem(20/09/2010)----update gpheader for tot balQty------------------
function updategptinheaderForBalQty($transfNo,$Qty,$ExistQty){
global $db;
	
	$sql2= "select * from productiongptinheader where dblCutGPTransferIN = '". $transfNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	$balQty = $exitQty+$row["dblTotBalQty"]-$Qty;
	
	$sql= "UPDATE productiongptinheader SET dblTotBalQty='$balQty' where dblCutGPTransferIN = '". $transfNo ."'";
	$db->executeQuery($sql);
}

//--------Update productionlineinputheader for total line input Quantities------------------------
function productionlineinputheaderQty($lineInputSerial,$year,$totQty,$totBalQty){
global $db;
	
	$sql2= "select * from productionlineindetail where intLineInputSerial = '". $lineInputSerial ."' AND intLineInputYear= '". $year ."'";
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
	
	$sql= "UPDATE productionlineinputheader SET dblTotQty='$totQty',dblBalQty='$totQty' WHERE intLineInputSerial='$lineInputSerial' AND intLineInputYear='$year'";
	$db->executeQuery($sql);
}
//----------------------------------------------------------------------------------------------------------
?>