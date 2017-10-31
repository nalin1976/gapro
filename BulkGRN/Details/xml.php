<?php

include "../../Connector.php";
include "../../HeaderConnector.php";
include "../../permissionProvider.php";


//$id="loadGrnHeader";
$id=$_GET["id"];

if($id=="supplier")
{

	$strOrigin=$_GET["value"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<Supplier>";
			if($strOrigin!=".")
				$SQL="SELECT * FROM suppliers WHERE strOrigin= '" . $strOrigin . "' ORDER BY strTitle";
			else
				$SQL="SELECT * FROM suppliers ORDER BY strTitle";
		$result = $db->RunQuery($SQL);
		$ResponseXML .= "<SupplierId><![CDATA[" . ""  . "]]></SupplierId>\n";
		$ResponseXML .= "<SupplierName><![CDATA[" . ""  . "]]></SupplierName>\n"; 
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<SupplierId><![CDATA[" . $row["strSupplierID"]  . "]]></SupplierId>\n";
				 $ResponseXML .= "<SupplierName><![CDATA[" . $row["strTitle"]  . "]]></SupplierName>\n";  
			}
			$ResponseXML .= "</Supplier>";
			echo $ResponseXML;
} 

if($id=="po-search")
{
		$strPiNo=$_GET["strPiNo"];
		$strSupplierID=$_GET["strSupplierID"];
		$dtDateFrom=$_GET["dtDateFrom"];
		$dtDateTo=$_GET["dtDateTo"];

		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<PO>";
/*				$SQL = 	"SELECT  DISTINCT ".
                      	"P.intPONo  AS dd, P.intPONo, S.strTitle, P.intYear, concat(P.intYear , '/' , P.intPONo , ' -- ' , S.strTitle) AS ListF, ".
                      	"concat(P.intYear  ,'/', P.intPONo) AS NPONO, P.strPINO, P.intDelToCompID ".
						"FROM         bulkpurchaseorderdetails PD INNER JOIN ".
                      	"purchaseorderheader P ON PO.intPONo = P.intPONo AND PO.intYear = P.intYear INNER JOIN ".
                      	"suppliers S ON P.strSupplierID = S.strSupplierID ".
						"WHERE      (P.intStatus = 10) AND (P.intDelToCompID = ".$_SESSION["intUserComp"].")";*/
						
				$SQL = 	"SELECT  DISTINCT PH.intBulkPoNo  AS dd, PH.intBulkPoNo, S.strTitle, PH.intYear, concat(PH.intYear,'/',PH.intBulkPoNo, ' -- ' , S.strTitle) AS ListF, 
concat(PH.intYear  ,'/', PH.intBulkPoNo) AS NPONO 
FROM bulkpurchaseorderdetails PD INNER JOIN 
bulkpurchaseorderheader  PH ON PH.intBulkPoNo = PD.intBulkPoNo AND PH.intYear = PD.intYear INNER JOIN 
suppliers S ON PH.strSupplierID = S.strSupplierID 
WHERE     (PH.intStatus = 1) AND (PH.intDeliverTo = ".$_SESSION["FactoryID"].")";

				if ($strSupplierID!="")
				{
					$SQL .=" AND (S.strSupplierID = '$strSupplierID')";
				}
				if ($dtDateFrom!="")
				{
					$SQL .=" AND (PH.dtDate >= '$dtDateFrom')";
				}
				if ($dtDateTo!="")
				{
					$SQL .=" AND (PH.dtDate <= '$dtDateTo')";
				}
				if ($strPiNo!="")
				{
					$SQL .=" AND (PH.intBulkPoNo like '%$strPiNo%')";
				}
				$SQL .= " order by PH.intYear, PH.intBulkPoNo DESC";
			$result = $db->RunQuery($SQL);
				$ResponseXML .= "<strPINO><![CDATA[" . ""  . "]]></strPINO>\n";
				$ResponseXML .= "<ListF><![CDATA[" . "Select One"  . "]]></ListF>\n"; 
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strPINO><![CDATA[" . $row["NPONO"]  . "]]></strPINO>\n";
				 $ResponseXML .= "<ListF><![CDATA[" . $row["ListF"]  . "]]></ListF>\n";  
			}
			$ResponseXML .= "</PO>";
			//echo $SQL;
			echo $ResponseXML;
}

if($id=="addItems")
{

		$strValue=$_GET["value"];
		$intChr1 = stripos($strValue,"/")+1;
		$intChr2 = stripos($strValue,"--");
		$strPoNo = substr($strValue,$intChr1,$intChr2-$intChr1);
		$intYear = substr($strValue,0,4);
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<Item>";
		
		$sql="SELECT MMC.strDescription,strItemDescription AS Description,PD.strUnit AS strUnit,dblPending AS Qty,strColor , 
strSize ,intMatDetailID,PD.dblUnitPrice,PD.dblQty as POQty 
FROM bulkpurchaseorderdetails PD,matitemlist MIL,matmaincategory MMC
WHERE PD.intMatDetailId = MIL.intItemSerial AND MIL.intMainCatID=MMC.intID AND PD.intBulkPoNo='$strPoNo' AND PD.intYear='$intYear'";
		
		$result = $db->RunQuery($sql);

			while($row = mysql_fetch_array($result))
			{
				$POQty       = $row["POQty"];								
				
				 $ResponseXML .= "<MainCategory><![CDATA[" . $row["strDescription"]  . "]]></MainCategory>\n";
				 $ResponseXML .= "<Description><![CDATA[" . $row["Description"]  . "]]></Description>\n";		
				 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
				 $ResponseXML .= "<Qty><![CDATA[" . number_format($row["Qty"],4,'.','')  . "]]></Qty>\n";  
				 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";  
				 $ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n"; 
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
			}
			$ResponseXML .= "</Item>";
			echo $ResponseXML;
} 
if($id=="addItemToGrn")
{
// FOR EXCESS GRN QTY nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
	$xml = simplexml_load_file('../../config.xml');
	$exPercentage = $xml->GRN->DefaultGRNExcessQtyPercentage;
// nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
		
		
		$matDetailId	= $_GET["matDetailId"];
		$color			= $_GET["color"];
		$size			= $_GET["size"];
		$intNo			= $_GET["No"];
		$poNo 			= $_GET["poNo"]; 
			$poNoarr 	= explode("/", $poNo);
		
		if($strBuyerPoNo == 'ratio')
			$strBuyerPoNo = "#Main Ratio#";
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<addItemToGrid>";
		
	$sql = "SELECT MC.strDescription,MIL.strItemDescription,PD.intMatDetailID,PD.strColor,PD.strSize,PD.strUnit,PD.dblUnitPrice,PD.dblQty,PD.dblPending,concat(intYear,'/',intBulkPoNo)as bulkPoNo
	FROM bulkpurchaseorderdetails PD 
	Inner Join matitemlist MIL ON MIL.intItemSerial = PD.intMatDetailID
	inner join matmaincategory MC on MC.intID=MIL.intMainCatID 
	AND MIL.intItemSerial = PD.intMatDetailId 
	AND strSize='$size' 
	AND strColor='$color' 
	AND intBulkPoNo = '$poNoarr[1]'
	AND intYear = '$poNoarr[0]'
	AND PD.intMatDetailId='$matDetailId'";
		$result = $db->RunQuery($sql);
		//echo $sql;
			while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<matCategory><![CDATA[" . $row["strDescription"]  . "]]></matCategory>\n";
				 $ResponseXML .= "<Description><![CDATA[" . $row["strItemDescription"]  . "]]></Description>\n";
				 $ResponseXML .= "<MatDetailId><![CDATA[" . $row["intMatDetailID"]  . "]]></MatDetailId>\n";
				 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";  
				 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n"; 
 				 $ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
				 $ResponseXML .= "<PoUnitPrice><![CDATA[" . number_format($row["dblUnitPrice"],4,'.','') . "]]></PoUnitPrice>\n";
				 $ResponseXML .= "<PoPendingQty><![CDATA[" . number_format($row["dblPending"],4,'.','')  . "]]></PoPendingQty>\n";
				 $ResponseXML .= "<PoQty><![CDATA[" . number_format($row["dblQty"],4,'.','')  . "]]></PoQty>\n";
				 $ResponseXML .= "<BulkPoNo><![CDATA[" . $row["bulkPoNo"] . "]]></BulkPoNo>\n";
			}
			$ResponseXML .= "</addItemToGrid>";
			echo $ResponseXML;
} 

if($id=="subStores")
{

	$intMainStores=$_GET["value"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<subStores>";
				$SQL="Select * from substores Where strMainID='".$intMainStores."' AND intStatus = 1 ORDER BY substores.strSubStoresName  ";
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 /*$ResponseXML .= "<strSubID><![CDATA[" . trim($row["strSubID"])  . "]]></strSubID>\n";
				 $ResponseXML .= "<strSubStoresName><![CDATA[" . trim($row["strSubStoresName"])  . "]]></strSubStoresName>\n";  */
				 $str .= "<option value=\"". $row["strSubID"] ."\">" . $row["strSubStoresName"] ."</option>";
			}
			$ResponseXML .= "<strSubID><![CDATA[" . $str  . "]]></strSubID>\n";
			$ResponseXML .= "</subStores>";
			echo $ResponseXML;
} 


if($id=="intMatDetailId")
{
		$intMatDetailId=$_GET["value"];

		$SQL="SELECT distinct  StrCatName,matsubcategory.intSubCatNo as intSubCatNo from matsubcategory,matitemlist where matitemlist.intSubCatID = matsubcategory.intSubCatNo AND matitemlist.intItemSerial=".$intMatDetailId." ";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				echo $row["StrCatName"]."***".$row["intSubCatNo"];
				break;
			}
} 


if($id=="locations") 
{

	$strMainId=$_GET["strMainId"];
	$strSubId=$_GET["strSubId"];
	$intSubCatId=$_GET["intSubCatId"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<locations>";
		//$SQL="SELECT distinct strLocID FROM storesbinallocation WHERE strMainID = '".$strMainId."' AND strSubID = '".$strSubId."' AND intSubCatNo='".$intSubCatId."'";
		
		$SQL="	SELECT DISTINCT
				storesbinallocation.strLocID as strLocID,
				storeslocations.strLocName as locName
				FROM
				storesbinallocation
				Inner Join storeslocations ON storeslocations.strMainID = storesbinallocation.strMainID AND storeslocations.strSubID = storesbinallocation.strSubID AND storeslocations.strLocID = storesbinallocation.strLocID
				WHERE storesbinallocation.strMainID = '$strMainId' AND storesbinallocation.strSubID = '$strSubId' AND storesbinallocation.intSubCatNo='$intSubCatId'
				";
		//echo $SQL;
		$ResponseXML .= "<strLocID><![CDATA[" . ""  . "]]></strLocID>\n";
		$ResponseXML .= "<locName><![CDATA[" . ""  . "]]></locName>\n";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strLocID><![CDATA[" . trim($row["strLocID"])  . "]]></strLocID>\n";
				 $ResponseXML .= "<locName><![CDATA[" . trim($row["locName"])  . "]]></locName>\n";
				
			}
			$ResponseXML .= "</locations>";
			echo $ResponseXML;
} 

if($id=="bins") 
{

	$strMainId=$_GET["strMainId"];
	$strSubId=$_GET["strSubId"];
	$intLocId=$_GET["intLocId"];
	$subCatId = $_GET["subCatId"];
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<bins>";
		
/*		$SQL		  =" SELECT strBinID, dblCapacityQty, dblFillQty FROM storesbinallocation ".
			 		   " WHERE strMainID =  '$strMainId' AND strSubID =  '$strSubId' AND strLocID =  '$intLocId' AND intSubCatNo = '$subCatId'";*/
		$SQL 		  ="SELECT
						storesbinallocation.strBinID,
						storesbinallocation.dblCapacityQty,
						storesbinallocation.dblFillQty,
						storesbins.strBinName
						FROM
						storesbinallocation
						Inner Join storesbins ON storesbins.strBinID = storesbinallocation.strBinID 
						AND storesbins.strMainID = storesbinallocation.strMainID AND storesbins.strSubID = storesbinallocation.strSubID 
						AND storesbins.strLocID = storesbinallocation.strLocID
						WHERE storesbinallocation.strMainID =  '$strMainId' AND  storesbinallocation.strSubID =  '$strSubId' 
						AND  storesbinallocation.strLocID =  '$intLocId' AND  storesbinallocation.intSubCatNo = '$subCatId'";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strBinID><![CDATA[" . trim($row["strBinID"])  . "]]></strBinID>\n";
				 $ResponseXML .= "<strBinName><![CDATA[" . trim($row["strBinName"])  . "]]></strBinName>\n";
				 $ResponseXML .= "<dblCapacityQty><![CDATA[" . $row["dblCapacityQty"]  . "]]></dblCapacityQty>\n";
				 $ResponseXML .= "<dblFillQty><![CDATA[" . number_format($row["dblFillQty"],4,'.','')  . "]]></dblFillQty>\n";
			}
			$ResponseXML .= "</bins>";
			echo $ResponseXML;
} 

if($id=="loadGrnHeader")
{
	$intGrnNo=$_GET["intGrnNo"];
	$intYear=$_GET["intYear"];
	$intStatus = $_GET["intStatus"];
		
		header('Content-Type: text/xml');
		
		$ResponseXML .="<grnHeader>";
		
$SQL ="SELECT
S.strTitle,
PH.intYear,
concat(PH.intYear ,'/' ,PH.intBulkPoNo ,' -- ' ,S.strTitle) AS ListF,
concat(PH.intYear ,'/',PH.intBulkPoNo) AS NPONO,
PH.strPINO,
PH.intDeliverTo,
GH.strSupAdviceNo,
GH.dtAdviceDate,
GH.dtRecdDate,
GH.strInvoiceNo,
GH.intBulkGrnNo,
GH.intYear
FROM
bulkpurchaseorderheader AS PH
Inner Join suppliers AS S ON PH.strSupplierID = S.strSupplierID
Inner Join bulkgrnheader GH ON GH.intBulkPoNo = PH.intBulkPoNo AND PH.intYear = GH.intBulkPoYear
WHERE
(PH.intStatus =  1) AND
GH.intYear = $intYear AND
GH.intBulkGrnNo =   $intGrnNo AND
GH.intStatus = $intStatus";
						
		$result = $db->RunQuery($SQL);
		//echo $SQL;
		$hasRecord = 0;
			while($row = mysql_fetch_array($result))
			{
				 $hasRecord = 1;
				 $ResponseXML .= "<NPONO><![CDATA[" . trim($row["NPONO"])  . "]]></NPONO>\n";
				 $ResponseXML .= "<Year><![CDATA[" . trim($row["intGRNYear"])  . "]]></Year>\n";
				 $ResponseXML .= "<strSupAdviceNo><![CDATA[" . trim($row["strSupAdviceNo"])  . "]]></strSupAdviceNo>\n";
				 $ResponseXML .= "<dtmAdviceDate><![CDATA[" . trim($row["dtAdviceDate"])  . "]]></dtmAdviceDate>\n";
				 $ResponseXML .= "<dtmRecievedDate><![CDATA[" . trim($row["dtRecdDate"])  . "]]></dtmRecievedDate>\n";
				 $ResponseXML .= "<strInvoiceNo><![CDATA[" . trim($row["strInvoiceNo"])  . "]]></strInvoiceNo>\n"; 
				 break;
			}
			$ResponseXML .= "</grnHeader>";
			if($hasRecord == 0)
				echo "Record Not Found";
			else
			{
				echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
				echo $ResponseXML;
			}
}

if($id=="loadgrndetail")
{
	$intGrnNo=$_GET["intGrnNo"];
	$intYear=$_GET["intYear"];
	$intStatus = $_GET["intStatus"];
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<grnDetails>";
	$SQL="SELECT
		MIL.strItemDescription,
		GD.strColor,
		GD.strSize,
		PD.strUnit,
		GD.dblRate AS dblUnitPrice,
		PD.dblPending AS pdblPending,
		PD.dblQty as poQty,
		GD.dblQty AS gdblQty,
		GD.dblExQty,
		GD.intMatDetailID,
		GH.intBulkPoNo,
		GH.intBulkPoYear,
		MC.strDescription as mainCategory
		FROM
		bulkgrndetails GD
		INNER JOIN bulkgrnheader GH ON GD.intBulkGrnNo = GH.intBulkGrnNo AND GD.intYear = GH.intYear
		INNER JOIN bulkpurchaseorderdetails PD ON PD.intBulkPoNo = GH.intBulkPoNo and  PD.intYear = GH.intBulkPoYear AND
		GD.strColor = PD.strColor AND 
		GD.strSize = PD.strSize AND 
		PD.intMatDetailId = GD.intMatDetailID					
		INNER JOIN matitemlist MIL ON MIL.intItemSerial = GD.intMatDetailID
		inner join matmaincategory MC on MC.intID=MIL.intMainCatID
		WHERE
		GD.intBulkGrnNo =  $intGrnNo AND
		GD.intYear =$intYear AND 
		GH.intStatus = $intStatus";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $dblBalance = (float)$row["pdblPending"];
				 if($intStatus!=10)
				 	$dblBalance+=(float)$row["gdblQty"];
				
				 $poQty = $row["poQty"];
				 $ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
				 $ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				 $ResponseXML .= "<strSize><![CDATA[" . trim($row["strSize"])  . "]]></strSize>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . number_format($row["dblUnitPrice"],4,'.','')  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblBalance><![CDATA[" . number_format($dblBalance,4,'.','')  . "]]></dblBalance>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . number_format($row["gdblQty"],4,'.','')  . "]]></dblQty>\n";
				 $ResponseXML .= "<dblExcessQty><![CDATA[" . number_format($row["dblExQty"],4,'.','')  . "]]></dblExcessQty>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . trim($row["intMatDetailID"])  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intBulkPoYear"])  . "]]></intYear>\n";
				 $ResponseXML .= "<intPoNo><![CDATA[" . trim($row["intBulkPoNo"])  . "]]></intPoNo>\n";
				 $ResponseXML .= "<POQty><![CDATA[" . $poQty . "]]></POQty>\n";	
				 $ResponseXML .= "<MainCategory><![CDATA[" .$row["mainCategory"] . "]]></MainCategory>\n";
			}
			$ResponseXML .= "</grnDetails>";
			echo $ResponseXML;

}

if($id=="loadBins")
{
$intDocumentNo		= $_GET["intDocumentNo"];
$intDocumentYear	= $_GET["intDocumentYear"];
$intMatDetailID		= $_GET["intMatDetailID"];
$strColor			= $_GET["strColor"];
$strSize			= $_GET["strSize"];
$strType			= $_GET["strType"];
		
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$sql = "SELECT GH.intStatus FROM bulkgrnheader GH WHERE GH.intBulkGrnNo =  '$intDocumentNo' AND GH.intYear =  '$intDocumentYear' ";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$intStatus = $row["intStatus"];
	}	
	if($intStatus == 0)
		$TABLE = 'stocktransactions_bulk_temp';
	elseif($intStatus == 1)
		$TABLE = 'stocktransactions_bulk';
		
		$ResponseXML .="<grnBins>";
			$SQL		  = "SELECT
			     			$TABLE.strBin,
							$TABLE.dblQty,
							$TABLE.strMainStoresID,
							$TABLE.strSubStores,
							$TABLE.strLocation,
							storesbinallocation.dblCapacityQty,
							(dblCapacityQty - dblFillQty) AS availableQty,
							$TABLE.strUnit,
							storesbinallocation.intSubCatNo,
							storesbins.strBinName
							FROM
							$TABLE
							Inner Join storesbinallocation ON $TABLE.strMainStoresID = storesbinallocation.strMainID 
							AND $TABLE.strSubStores = storesbinallocation.strSubID 
							AND $TABLE.strLocation = storesbinallocation.strLocID
							AND $TABLE.strBin = storesbinallocation.strBinID
							Inner Join matitemlist ON $TABLE.intMatDetailId = matitemlist.intItemSerial 
							AND matitemlist.intSubCatID = storesbinallocation.intSubCatNo
							Inner Join storesbins ON storesbins.strBinID = $TABLE.strBin
							WHERE
							$TABLE.strType =  'GRN' AND
							$TABLE.intDocumentNo =  $intDocumentNo AND
							$TABLE.intDocumentYear =  $intDocumentYear AND
							$TABLE.intMatDetailId =  $intMatDetailID AND
							$TABLE.strColor =  '$strColor' AND
							$TABLE.strSize =  '$strSize'";
			$result = $db->RunQuery($SQL);

			while($row = mysql_fetch_array($result))
			{			
				 $ResponseXML .= "<strBin><![CDATA[" . trim($row["strBin"])  . "]]></strBin>\n";
				 $ResponseXML .= "<strBinName><![CDATA[" . trim($row["strBinName"])  . "]]></strBinName>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . number_format($row["dblQty"],4,'.','')  . "]]></dblQty>\n";
				 $ResponseXML .= "<strMainStoresID><![CDATA[" . trim($row["strMainStoresID"])  . "]]></strMainStoresID>\n";
				 $ResponseXML .= "<strSubStores><![CDATA[" . trim($row["strSubStores"])  . "]]></strSubStores>\n";
				 $ResponseXML .= "<strLocation><![CDATA[" . trim($row["strLocation"])  . "]]></strLocation>\n";
				 $ResponseXML .= "<dblCapacityQty><![CDATA[" . trim($row["dblCapacityQty"])  . "]]></dblCapacityQty>\n";
				 $ResponseXML .= "<availableQty><![CDATA[" . trim($row["availableQty"])  . "]]></availableQty>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 $ResponseXML .= "<intSubCatNo><![CDATA[" . trim($row["intSubCatNo"])  . "]]></intSubCatNo>\n";
				 $ResponseXML .= "<intSubCatNo><![CDATA[" . trim($row["intSubCatNo"])  . "]]></intSubCatNo>\n";
			}
			$ResponseXML .= "</grnBins>";
			echo $ResponseXML;
}

if($id=="getCommonBinsActive")
{
					/*$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
					$result = $db->RunQuery($SQL);
					$active =10;
					while($row = mysql_fetch_array($result))
					{
						$active = $row["strValue"];
						break;
					}
					
					if ($active==10)
					{
						$SQL1 = "INSERT INTO settings(strKey,strValue)VALUES('CommonStockActivate','1')";
						$result1 = $db->RunQuery($SQL1);
						$active=1;
					}*/
					//echo $active;
			header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .= "<MainstoreBinDetails>";
	$strMainStores		= $_GET["strMainStores"];
	
	$SQL = " select intCommonBin from mainstores where intCompanyId=".$_SESSION["FactoryID"]."  and intStatus=1 and intCommonBin=1 and strMainID=$strMainStores ";
	$count = 0;
	$result = $db->RunQuery($SQL);
	$count = mysql_num_rows($result);
	
	$ResponseXML .= "<commonbin><![CDATA[" . trim($count)  . "]]></commonbin>\n";
	$ResponseXML .= "</MainstoreBinDetails>";
	echo $ResponseXML;
}
if($id=='getCommonBin')
{

		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .= "<MainstoreBinDetails>";
	$strMainStores		= $_GET["strMainStores"];
	
	$SQL = " select intCommonBin,intAutomateCompany from mainstores where strMainID=$strMainStores  and intStatus=1 ";
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<commonbin><![CDATA[" . trim($row["intCommonBin"])  . "]]></commonbin>\n";
		 $ResponseXML .= "<autoBin><![CDATA[" . trim($row["intAutomateCompany"])  . "]]></autoBin>\n";
	}
	
	$ResponseXML .= "</MainstoreBinDetails>";
	echo $ResponseXML;
}
if($id=='loadAutoBins')
{
			$strMainStores		= $_GET["strMainStores"];
			$strSubStores		= $_GET["strSubStores"];
			$reqQty				= $_GET["reqQty"];
			$strUnit			= $_GET["strUnit"];
			
			$SQL = "SELECT * 
					FROM
					storesbinallocation
					Inner Join storesbins ON storesbins.strBinID = storesbinallocation.strBinID
			WHERE storesbinallocation.strMainID =  '$strMainStores' AND storesbinallocation.strSubID =  '$strSubStores'";
			$result = $db->RunQuery($SQL);
			//echo			$SQL;
			while($row = mysql_fetch_array($result))
			{
				$out		= 	 "<tr>".
								 "<td class=\"normalfntMid\">".$row['strBinID']."</td>".
								 "<td class=\"normalfntRite\">".$reqQty."</td>".
								 "<td class=\"normalfntMid\">".$row['strMainID']."</td>".
								 "<td class=\"normalfntMid\">".$row['strSubID']."</td>".
								 "<td class=\"normalfntMid\">".$row['strLocID']."</td>".
								 "<td class=\"normalfntRite\">".$row['dblCapacityQty']."</td>".
								 "<td class=\"normalfntRite\">".((float)$row['dblCapacityQty'] - (float)$row['dblFillQty'])."</td>".
								 "<td class=\"normalfntMid\">".$strUnit."</td>".
								 "<td class=\"normalfntMid\">".$row['intSubCatNo']."</td>".
								 "<td class=\"normalfntMid\">".$row['strBinName']."</td>".
								 "</tr>";
					break;
			}
			echo $out;
			//echo $result;
}

if($id=="URLListingPONo")
{
	$sql="SELECT  DISTINCT 
	PH.intBulkPoNo  AS dd,concat(PH.intYear , '/' , PH.intBulkPoNo , ' -- ' , S.strTitle) AS ListF
	FROM bulkpurchaseorderdetails PD INNER JOIN 
	bulkpurchaseorderheader PH ON PD.intBulkPoNo = PH.intBulkPoNo AND PD.intYear = PH.intYear INNER JOIN 
	suppliers S ON PH.strSupplierID = S.strSupplierID 
	INNER JOIN bulkgrnheader BG ON BG.intBulkPoNo=PH.intBulkPoNo AND BG.intBulkPoYear=PH.intYear
	WHERE  (PH.intStatus = 1) AND (BG.intCompanyId = ".$_SESSION["FactoryID"].")
	order by ListF ;";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$pr_arr.= $row['dd']."|";	
	}
	echo $pr_arr;
}
if($id=="getGRNstatus")
{
	$grnNo = $_GET["grnNo"];
	$arrGRN = explode('/',$grnNo);
	$sql = "select intStatus from bulkgrnheader where intBulkGrnNo='$arrGRN[1]' and intYear='$arrGRN[0]' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	echo $row["intStatus"];
}
function getBuerPOName($StyleID,$buyerPOno)
{
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos
			 WHERE intStyleId='$StyleID' AND strBuyerPONO='$buyerPOno'";
			 
			 global $db;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$BPOname = $row["strBuyerPoName"];
			}
		return $BPOname;	 
			 
}
?>	
