<?php 
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["req"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];
/*
Item Disposal Status (itemdispose table)
1-Pending
2-Confirm 
*/

if($RequestType=="getSubCat")
{
	$mainCat  = $_GET["mainCat"];
	
	$ResponseXML .="<LoadSubCat>\n";
	
	$SQL = "select intSubCatNo,StrCatName 
			from matsubcategory
			 where intCatNo='$mainCat' 
			  order by intSubCatNo ";
			  
	$result =$db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			$ResponseXML .= "<SubCatId><![CDATA[" . $row["intSubCatNo"]  . "]]></SubCatId>\n";
			$ResponseXML .= "<SubCatName><![CDATA[" . $row["StrCatName"]  . "]]></SubCatName>\n";
	}
	
	$ResponseXML .="</LoadSubCat>";
	echo $ResponseXML;
}
if($RequestType=="loadSubStore")
{
	$mainStore=$_GET['mainStore'];
	$sql_sub="SELECT strSubID,strSubStoresName FROM substores WHERE strMainID='$mainStore';";
	$result=$db->RunQuery($sql_sub);
	//echo $sql_sub;
	$ResponseXML .="<LoadSubStores>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<strSubID><![CDATA[" . $row["strSubID"]  . "]]></strSubID>\n";
		$ResponseXML .="<strSubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></strSubStoresName>\n";
	}
	$ResponseXML .="</LoadSubStores>\n";
	echo $ResponseXML;
}
if($RequestType=="loadListing")
{
	$docNo=$_GET['docNo'];
	$sql_listing="SELECT st.intDocumentNo,o.strStyle,sb.strBuyerPoName,mt.strItemDescription,st.dblQty 
				  FROM stocktransactions st
				  LEFT Join matitemlist AS mt ON st.intMatDetailId = mt.intItemSerial
				  INNER JOIN orders o ON o.intStyleId=st.intStyleId
				  LEFT JOIN style_buyerponos sb ON sb.strBuyerPONO=st.strBuyerPoNo AND sb.intStyleId=o.intStyleId
				  WHERE st.dblQty<0 AND st.intDocumentNo='$docNo' ORDER BY st.intDocumentNo ASC;";
	$result=$db->RunQuery($sql_listing);
	//echo $sql_sub;
	$ResponseXML .="<DiposeListing>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<DocumentNo><![CDATA[" . $row["intDocumentNo"]  . "]]></DocumentNo>\n";
		$ResponseXML .="<Style><![CDATA[" . $row["strStyle"]  . "]]></Style>\n";
		$ResponseXML .="<BuyerPoName><![CDATA[" . $row["strBuyerPoName"]  . "]]></BuyerPoName>\n";
		$ResponseXML .="<Description><![CDATA[" . $row["strItemDescription"]  . "]]></Description>\n";
		$ResponseXML .="<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";
	}
	$ResponseXML .="</DiposeListing>\n";
	echo $ResponseXML;
}
if($RequestType=="serachReq"){
	$disposeNo		= 	$_GET["disposeNo"];
	$fromDate		= 	$_GET["fromDate"];
	$toDate			= 	$_GET["toDate"];	
	$companyId		= 	$_SESSION["FactoryID"];
	$status			=	$_GET['status'];
	$mainStore		=	$_GET['mainStore'];
	$tbl="";
	($status==1)?$tbl="stocktransactions_temp":$tbl="stocktransactions";
		$SQL=  "SELECT DISTINCT
				date(dtmDate) AS dt,
				intDocumentYear,
				intDocumentNo,
				intStyleId,
				mainstores.strName as MainStore,
				useraccounts.Name as uname,
				companies.strName
				FROM
				$tbl
				Inner Join useraccounts ON useraccounts.intUserID = $tbl.intUser
				Inner Join mainstores on mainstores.strMainID=$tbl.strMainStoresID
				Inner Join companies ON companies.intCompanyID = mainstores.intCompanyId
				WHERE strType = 'DISPOSE' and companies.intCompanyID= $companyId ";
				
				if($disposeNo!='')
				{
					$disposeNo		= split('/',$_GET["disposeNo"]);
					$disposeNo		= $disposeNo[1];
					$SQL.=" AND $tbl.intDocumentNo=$disposeNo";
				}
				if($fromDate!="" && $toDate!="")
				{
					$fromDate		= split('/',$_GET["fromDate"]);
					$fromDate		= $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
					$toDate			= split('/',$_GET["toDate"]);
					$toDate			= $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
					$SQL.=" AND date($tbl.dtmDate) BETWEEN '$fromDate' AND '$toDate'";
				}
				if($mainStore!=""){
					$SQL.=" AND mainstores.strMainID=$mainStore ";
				}
					$SQL.=" group by  intDocumentNo, intDocumentNo DESC";
				$SQL.=" order by dtmDate DESC";
				//echo $SQL;
				$result = $db->RunQuery($SQL);
				$ResponseXML .="<LoadDisposeList>\n";
			while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<DocNo><![CDATA[" . $row["intDocumentNo"] . "]]></DocNo>\n";
				$ResponseXML .= "<Year><![CDATA[" . $row["intDocumentYear"]  . "]]></Year>\n";  
				$ResponseXML .= "<StyleNo><![CDATA[" . getStyleName($row["intStyleId"])  . "]]></StyleNo>\n";
				$ResponseXML .= "<MainStore><![CDATA[" . $row["MainStore"]  . "]]></MainStore>\n";
				$ResponseXML .= "<Dt><![CDATA[" . $row["dt"]  . "]]></Dt>\n";
				$ResponseXML .= "<Uname><![CDATA[" . $row["uname"]  . "]]></Uname>\n";
			}
			  $ResponseXML .="</LoadDisposeList>\n";
			  echo $ResponseXML ;
}
if($RequestType=="loadStoreType")
{
	$mainStore=$_GET['mainStore'];
	$sql_sub="SELECT * FROM mainstores WHERE strMainID='$mainStore';";
	$result=$db->RunQuery($sql_sub);
	//echo $sql_sub;
	$ResponseXML .="<LoadStoreType>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<type><![CDATA[" . $row["intCommonBin"]  . "]]></type>\n";
	}
	$ResponseXML .="</LoadStoreType>\n";
	echo $ResponseXML;
}
if($RequestType=="getDisposeNo")
{
	$status=$_GET['status'];
	$tbl="";
	($status==1)?$tbl="stocktransactions_temp":$tbl="stocktransactions";
					
	$sql_sub = "select concat(intYear,'/',intDocumentNo) as disposeNo from itemdispose where intStatus='$status'";			
	$result=$db->RunQuery($sql_sub);
	
	$ResponseXML .="<LoadDisposeNo>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<Result><![CDATA[" . $row["disposeNo"]  . "]]></Result>\n";
	}
	$ResponseXML .="</LoadDisposeNo>\n";
	echo $ResponseXML;
}
if($RequestType=="getMainStore")
{
	$ComId=$_GET['ComId'];	
	$sql_sub="SELECT mainstores.strName,mainstores.strMainID FROM mainstores WHERE mainstores.intCompanyId =  '$ComId';";
	$result=$db->RunQuery($sql_sub);
	//echo $sql_sub;
	$ResponseXML .="<LoadMainStore>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<MainID><![CDATA[" . $row["strMainID"]  . "]]></MainID>\n";
		$ResponseXML .="<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
	}
	$ResponseXML .="</LoadMainStore>\n";
	echo $ResponseXML;
}
else if($RequestType=="LoadStyleWiseOrderNo")
{
$styleNo	= $_GET["styleNo"];
	$SQL = "SELECT DISTINCT O.strOrderNo,S.intStyleId FROM specification S Inner Join orders O ON S.intStyleId = O.intStyleId AND O.intStatus <> 13 ";
	if($styleNo!="")
		$SQL .= " And O.strStyle='$styleNo' ";
		
	$SQL .= "order by O.strStyle ";
	$result=$db->RunQuery($SQL);
		echo "<option value =\"".""."\">Select One</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>\n";
	}
}
else if($RequestType=="LoadStyleWiseScNo")
{
$styleNo	= $_GET["styleNo"];
	$SQL = "SELECT distinct S.intStyleId, S.intSRNO FROM specification S inner join orders O on O.intStyleId=S.intStyleId";	
	if($styleNo!="")
		$SQL .= " And O.strStyle='$styleNo' ";
		
	$SQL .= " order by S.intSRNO DESC ";
	$result=$db->RunQuery($SQL);
		echo "<option value =\"".""."\">Select One</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>\n";
	}
}
function getStyleName($StyleID)
{
global $db;
	$SQLS = " select strOrderNo from orders where intStyleId='$StyleID'";	
	$resultS=$db->RunQuery($SQLS);
	$rowS=mysql_fetch_array($resultS);
	return $rowS["strOrderNo"];
}
?>