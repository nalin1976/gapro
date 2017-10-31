<?php 

session_start();
include("../Connector.php");
header('Content-Type: text/xml'); 	
$request = $_GET["REQUEST"];
$userId	 = $_SESSION["UserID"];

if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
	$keys=$_GET["MRNNO"];
	$keysarray=explode("/",$keys);
	$mrnno=$keysarray[0];
	$year=$keysarray[1];
	$XMLString= "<Data>";
	$XMLString .= "<MRNDetailData>";
	
	$sql="
	select 	mrd.intMatRequisitionNo, 
	mrd.intYear, 
	mrd.intStyleId,
	O.strOrderNo, 
	mrd.strBuyerPONO, 
	mrd.strMatDetailID, 
	mrd.strColor, 
	mrd.strSize, 
	mrd.dblQty as MRNQty, 
	mrd.dblBalQty, 
	mrd.strNotes,
	mrd.intGrnNo,
	mrd.intGrnYear,
	mrd.strGRNType,
	ml.strItemDescription,
	mr.materialRatioID as strItemCode,
	(select sum(dblQty) from issuesdetails where intMatRequisitionNo=mrd.intMatRequisitionNo and intMatDetailID=mrd.strMatDetailID and intMatReqYear=mrd.intYear and intStyleId=mrd.intStyleId and strBuyerPONO=mrd.strBuyerPONO and strColor=mrd.strColor and strSize=mrd.strSize and intGrnNo=mrd.intGrnNo and intGrnYear=mrd.intGrnYear and strGRNType=mrd.strGRNType)as IssueQty	 
	from 
	matrequisitiondetails mrd  
	inner join matitemlist ml on ml.intItemSerial=mrd.strMatDetailID
	inner join orders O on O.intStyleId = mrd.intStyleId
	left join  materialratio mr on mr.strMatDetailID=mrd.strMatDetailID and 
	mr.intStyleId=mrd.intStyleId and mr.strColor=mrd.strColor and mr.strSize=mrd.strSize and mr.strBuyerPONO=mrd.strBuyerPONO
	WHERE  mrd.intMatRequisitionNo='$mrnno' and mrd.intYear='$year'
	group by
	mrd.intMatRequisitionNo,mrd.intYear,mrd.intStyleId,mrd.strBuyerPONO,mrd.strMatDetailID,
	mrd.strColor,mrd.strSize,mrd.intGrnNo,mrd.intGrnYear ;";
	
	//echo $sql;
	//die($sql);
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$StyleID = 	$row["intStyleId"];
		$BuyerPOName = $row["strBuyerPONO"];
		
		if($row["strBuyerPONO"] != '#Main Ratio#')
			$BuyerPOName = getBuyerPOName($StyleID,$row["strBuyerPONO"]);
		$issueQty = $row["IssueQty"];
		if($issueQty == '' || is_null($issueQty))
		{
			$issueQty = 0;
		}	
		$XMLString .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
		$XMLString .= "<StyleName><![CDATA[" . $row["strOrderNo"]  . "]]></StyleName>\n";
		$XMLString .= "<ItemCode><![CDATA[" . $row["strItemCode"]  . "]]></ItemCode>\n";
		$XMLString .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
		$XMLString .= "<BuyerPOName><![CDATA[" . $BuyerPOName  . "]]></BuyerPOName>\n";
		$XMLString .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		$XMLString .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$XMLString .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$XMLString .= "<MRNQty><![CDATA[" . $row["MRNQty"]  . "]]></MRNQty>\n";
		$XMLString .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n";
		$XMLString .= "<IssueQty><![CDATA[" .  $issueQty . "]]></IssueQty>\n";
		$XMLString .= "<MatDetailID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatDetailID>\n";
		$XMLString .= "<GRNNo><![CDATA[" . $row["intGrnNo"]  . "]]></GRNNo>\n";
		$XMLString .= "<GRNYear><![CDATA[" . $row["intGrnYear"]  . "]]></GRNYear>\n";
		$XMLString .= "<GRNType><![CDATA[" . $row["strGRNType"]  . "]]></GRNType>\n";
	}
	
	$XMLString .= "</MRNDetailData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='deleteFirst')
{
		$keys=$_GET["MRNno"];
		$keysarray=explode("/",$keys);
		$mrnno=$keysarray[0];
		$year=$keysarray[1];
		$sqlDuplicate="insert into 
	historymatrequisitiondetails
	(
	intMatRequisitionNo, intYear, intStyleId, strBuyerPONO, strMatDetailID, strColor, strSize, dblQty, dblBalQty, strNotes,
	intGrnNo,intGrnYear,strGRNType,
	intUserId
		
	)
	select 	
	intMatRequisitionNo, intYear, intStyleId, strBuyerPONO, strMatDetailID, strColor, strSize, dblQty, dblBalQty, strNotes,
	intGrnNo,intGrnYear,strGRNType,$userId as intUserId
	from matrequisitiondetails
	where intMatRequisitionNo='$mrnno' and intYear='$year';";
	//die($sqlDuplicate);
	$resultDup = $db->RunQuery($sqlDuplicate); 	
	if($resultDup)	
	{	
		echo "Updated successfully.";
	}
	else
		echo "Select \"MRN No\"";
}
	

if ($request=='editMrn')
{
				$keys=$_GET["mrnno"];
				$keysarray=explode("/",$keys);
				$mrnno=$keysarray[0];
				$year=$keysarray[1];
				$buyerpo=$_GET["buyerpo"];
				$color=$_GET["color"];
				$matdetailtid=$_GET["matdetailtid"];
				$size=$_GET["size"];
				$style=$_GET["style"];
				$mrnqty=$_GET["mrnqty"];
				$balqty=$_GET["balqty"];
				$grnno=$_GET["grnno"];
				$grnYear=$_GET["grnYear"];
				$grnType=$_GET["grnType"];
	
	$sql="update matrequisitiondetails 
			set dblQty=$mrnqty,
				dblBalQty=$balqty
			where intMatRequisitionNo='$mrnno' and
				  intYear='$year' and
				  intStyleId='$style' and
				  strBuyerPONO='$buyerpo' and
				  strMatDetailID='$matdetailtid' and
				  strColor='$color' and
				  strSize='$size' and
				  intGrnNo='$grnno' and
				  intGrnYear='$grnYear' ;";
	
	$result = $db->RunQuery($sql); 
	if($result)
	{
	echo "Successfully updated.";
	}
	
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
?>
