<?php 
include "../../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="getStylewiseOrderNo")
{
	$styleNo = $_GET["styleNo"];
	$sql = " SELECT DISTINCT O.intStyleId,O.strOrderNo FROM productionbundleheader PBH
INNER JOIN orders O ON O.intStyleId=PBH.intStyleId ";
	
	if($styleNo != '')
		$sql .= " where O.strStyle ='$styleNo' ";
		
		$sql .= "ORDER BY O.strOrderNo ";
	$result = $db->RunQuery($sql);
	$str = "<option value=\"\"></option>";
	while($row=mysql_fetch_array($result))
	{
		 $str .= "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>\n";
	}
	
	echo $str;	
}
if($requestType=="getOrdernoWiseColorDetails")
{
	$styleId = $_GET["styleId"];
	$sql = " SELECT DISTINCT strColor FROM productionbundleheader WHERE intStyleId='$styleId' ";	
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		 $str .= "<option value=\"".$row["strColor"]."\">".$row["strColor"]."</option>\n";
	}
	
	echo $str;	
}

if($requestType=="getOrdernoHeaderDetails")
{
	$styleId = $_GET["styleId"];
	$sql = " SELECT intQty FROM orders WHERE intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	
	$row = mysql_fetch_array($result);
	echo number_format($row["intQty"],0);
}

if($requestType=="getOrdernoDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<ordernoDetails>\n";
	
	$styleId = $_GET["styleId"];
	$color = $_GET["color"];
	
	$sql = " SELECT DISTINCT S.strSize,
	(SELECT SUM(FLID.dblQty)
FROM finishing_lineissue_header FLIH
INNER JOIN finishing_lineissue_details FLID ON FLIH.intFLIssueID=FLID.intFLIssueID AND FLIH.intFLIssueYear=FLID.intFLIssueYear where S.intStyleId=FLIH.intStyleId and S.strColor=FLIH.strColor and S.strSize=FLID.strSize)as issuedQty FROM styleratio S WHERE S.intStyleId=$styleId and S.strColor='$color' ";
	
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<balQty><![CDATA[" . $row["dblBalQty"]  . "]]></balQty>\n";
		$ResponseXML .= "<IssuedQty><![CDATA[" . $row["issuedQty"]  . "]]></IssuedQty>\n";	
	}
	
	$ResponseXML .= "</ordernoDetails>";
	echo $ResponseXML;
}

if($requestType=="saveFinishingLineIssueHeader")
{
	$styleId = $_GET["styleId"];
	$color = $_GET["color"];
	
	$result = saveFinishingLineIssueHeaderData($styleId,$color,$userId);
	echo $result;
}
if($requestType=="saveFinishingLineIssueDetails")
{
	$styleId = $_GET["styleId"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$issueQty = $_GET["issueQty"];
	$lineInNo = $_GET["lineInNo"];
	$arrLineInNo = explode('/',$lineInNo);
	
	$response = updateWashIssuedtoFinishingData($styleId,$color,$size,$issueQty); 
	if($response==1)
		$result = saveFinishingLineIssueDetails($arrLineInNo[0],$arrLineInNo[1],$size,$issueQty);
	echo $result;
}
function saveFinishingLineIssueHeaderData($styleId,$color,$userId)
{
	global $db;
	$lineInNo = getFinishingLineIssueNo();
	$lineInYear = date('Y');
	
	$sql = "INSERT INTO finishing_lineissue_header (intFLIssueID,intFLIssueYear,intStyleId, 
strColor,intUserId,dtmDate) VALUES ($lineInNo,$lineInYear,$styleId,'$color',$userId,now()) ";	
	$result = $db->RunQuery($sql);
	
	if($result==1)
		echo $lineInYear.'/'.$lineInNo;
	else
		echo 'N/A';	
}

function getFinishingLineIssueNo()
{
	global $db;
	global $companyId;
	$sql = " SELECT dblFLIssueID FROM syscontrol WHERE intCompanyID=$companyId ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$lineNo = $row["dblFLIssueID"];
	
	$sql_u = " UPDATE syscontrol SET  dblFLIssueID = dblFLIssueID+1 WHERE intCompanyID=$companyId ";
	$result_u = $db->RunQuery($sql_u);
	
	return $lineNo;	
}

function updateWashIssuedtoFinishingData($styleId,$color,$size,$issueQty)
{
	global $db;
	$sql = " SELECT WIFH.intSerialNo,WIFH.intSerialYear
FROM was_issuestofinishing_detail WIFD INNER JOIN was_issuestofinishing_header WIFH ON
WIFD.intSerialNo = WIFH.intSerialNo AND WIFD.intSerialYear = WIFH.intSerialYear
WHERE WIFH.intStyleId=$styleId AND WIFH.intStatus=1 AND  WIFH.strColor='$color' AND WIFD.strSize='$size' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$serialNo = $row["intSerialNo"];
	$serialYear = $row["intSerialYear"];
	
	$sql_u = " UPDATE was_issuestofinishing_detail 	SET
	dblBalQty = dblBalQty-$issueQty
	WHERE
	intSerialNo = '$serialNo' AND intSerialYear = '$serialYear' AND strSize = '$size' ";
	
	return $db->RunQuery($sql_u);
	
}

function saveFinishingLineIssueDetails($lineInYear,$lineInNo,$size,$issueQty)
{
	global $db;
	$sql = " INSERT INTO finishing_lineissue_details (intFLIssueID,intFLIssueYear, 
strSize,dblQty,	dblBalQty) VALUES ($lineInNo,$lineInYear,'$size',$issueQty,$issueQty)";	

	return $db->RunQuery($sql);
}
?>