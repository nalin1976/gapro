<?php
session_start();
include "../../../Connector.php";
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
		$strPiNoFromArray	= explode('/',$strPiNo);
	    $strPiNo= $strPiNoFromArray[1];
		
		
		
		$intSupplierID=$_GET["intSupplierID"];
		$dtDateFrom=$_GET["dtDateFrom"];
		$dtDateTo=$_GET["dtDateTo"];

		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<PO>";
				$SQL = 	"select * from (SELECT
						generalpurchaseorderheader.intGenPONo,
						suppliers.strTitle,
						generalpurchaseorderheader.intYear,
						concat(generalpurchaseorderheader.intYear ,'/' ,generalpurchaseorderheader.intGenPONo ,' -- ' ,strTitle) AS ListF,
						concat(generalpurchaseorderheader.intYear,'/',generalpurchaseorderheader.intGenPONo) AS GenPONo,
						generalpurchaseorderheader.strPINO as strPiNo,
						generalpurchaseorderheader.intStatus,
						Sum(generalpurchaseorderdetails.dblPending) as TotalQty,
						suppliers.strSupplierID as strSuppId,
						generalpurchaseorderheader.dtmDate as bpoDate
						FROM
						generalpurchaseorderheader
						Inner Join suppliers ON suppliers.strSupplierID = generalpurchaseorderheader.intSupplierID
						Inner Join generalpurchaseorderdetails ON 
						generalpurchaseorderdetails.intGenPONo = generalpurchaseorderheader.intGenPONo 
						AND generalpurchaseorderdetails.intYear = generalpurchaseorderheader.intYear
						
						WHERE
						generalpurchaseorderheader.intStatus =  '1' AND
						generalpurchaseorderheader.intDeliverTo =  ".$_SESSION["FactoryID"]."
						
						 GROUP BY
						generalpurchaseorderheader.intGenPONo,
						suppliers.strTitle,
						generalpurchaseorderheader.intYear,
						generalpurchaseorderheader.strPINO,
						generalpurchaseorderheader.intStatus
						) as bpoheader where TotalQty>0 ";
				
				if ($intSupplierID!="")
				{
					$SQL .=" AND (strSuppId = '$intSupplierID')";
				}
				if ($dtDateFrom!="")
				{
					$SQL .=" AND (bpoDate >= '$dtDateFrom')";
				}
				if ($dtDateTo!="")
				{
					$SQL .=" AND (bpoDate <= '$dtDateTo')";
				}
				if ($strPiNo!="")
				{
					$SQL .=" AND (strPiNo like '%$strPiNo%')";
				}
//echo $SQL;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strPINO><![CDATA[" . $row["GenPONo"]  . "]]></strPINO>\n";
				 $ResponseXML .= "<ListF><![CDATA[" . $row["ListF"]  . "]]></ListF>\n";  
			}
			$ResponseXML .= "</PO>";
			echo $ResponseXML;

}

if($id=="addItems")
{
		$strValue=$_GET["value"];
		$intChr1 = stripos($strValue,"/")+1;
		$intChr2 = stripos($strValue,"--");
		$strPoNo = substr($strValue,$intChr1,$intChr2-$intChr1);
		$intYear = substr($strValue,0,$intChr1-1);
		//echo $intYear;
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<Item>";
		$SQL=" 	select
			 	strItemDescription as Description,
				generalpurchaseorderdetails.strUnit as strUnit,
				dblPending as Qty,
				intGenPONo ,
				intMatDetailID 
				from generalpurchaseorderdetails ,genmatitemlist 
			 	where generalpurchaseorderdetails.intMatDetailID = genmatitemlist.intitemserial  
				AND intGenPONo= '$strPoNo' AND intYear=$intYear";
				
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<Description><![CDATA[" . $row["Description"]  . "]]></Description>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
				 $ResponseXML .= "<Qty><![CDATA[" . $row["Qty"]  . "]]></Qty>\n";  
				 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";  
				 $ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n"; 
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n";
			}
			$ResponseXML .= "</Item>";
			echo $ResponseXML;
} 


if($id=="addItemToGrn")
{
	$strDescription = $_GET["strDescription"];
	$poNo= $_GET["poNo"];
	$year= $_GET["year"];
	$matDetailId = $_GET["matDetailId"];
	$costCenterId = $_GET["costCenterId"];
	$glAlloId = $_GET["glAlloId"];
//	$intNo=$_GET["No"];
	//echo $poNo;
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML .= "<addItemToGrid>";
	
	/*$SQL = " SELECT	genmatmaincategory.strDescription as strMainCategory, genmatsubcategory.StrCatName as strSubCategory, 			genmatitemlist.strItemDescription as strItemDescription, generalpurchaseorderdetails.strColor, 			generalpurchaseorderdetails.strSize, generalpurchaseorderdetails.strUnit, generalpurchaseorderdetails.dblUnitPrice, generalpurchaseorderdetails.dblPending,  generalpurchaseorderdetails.intMatDetailID, generalpurchaseorderdetails.intGenPONo, 			generalpurchaseorderdetails.intYear from generalpurchaseorderdetails ,genmatitemlist,genmatmaincategory,genmatsubcategory WHERE generalpurchaseorderdetails.intMatDetailID = genmatitemlist.intitemserial and	genmatmaincategory.intID = generalpurchaseorderdetails.strMatID and genmatsubcategory.intSubCatNo = generalpurchaseorderdetails.strMatCategoryId and 			genmatitemlist.strItemDescription = '$strDescription' AND generalpurchaseorderdetails.intGenPONo = '". $poNo ."' ";*/
	$SQL = " select gmil.strItemDescription, gmc.strDescription as strMainCategory, gmsub.StrCatName as strSubCategory, 
gpd.strUnit,gpd.dblUnitPrice,gpd.dblPending,gpd.intMatDetailID,gpd.intGenPONo,gpd.intYear
from generalpurchaseorderdetails gpd inner join genmatitemlist  gmil on 
gpd.intMatDetailID = gmil.intItemSerial 
inner join genmatmaincategory gmc on gmc.intID = gmil.intMainCatID 
inner join genmatsubcategory gmsub on gmsub.intSubCatNo = gmil.intSubCatID
where gpd.intGenPoNo='$poNo' and gpd.intYear='$year' and gpd.intMatDetailID = '$matDetailId' ";
	
	
	//echo $SQL;

		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<strMainCategory><![CDATA[" . $row["strMainCategory"]  . "]]></strMainCategory>\n";
			 $ResponseXML .= "<strSubCategory><![CDATA[" . $row["strSubCategory"]  . "]]></strSubCategory>\n";
			 $ResponseXML .= "<Description><![CDATA[" . $row["strItemDescription"]  . "]]></Description>\n";
			 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
			 $ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
			 $ResponseXML .= "<dblPending><![CDATA[" . $row["dblPending"]  . "]]></dblPending>\n";
			 $ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n";
			 /*$ResponseXML .= "<costCenter><![CDATA[" . $row["costCenter"]  . "]]></costCenter>\n";
			 $ResponseXML .= "<costCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></costCenterId>\n";
			 $ResponseXML .= "<glAlloId><![CDATA[" . $glAlloId  . "]]></glAlloId>\n";
			 $ResponseXML .= "<glAccId><![CDATA[" . $row["strAccID"]  . "]]></glAccId>\n";
			 $ResponseXML .= "<costCenterCode><![CDATA[" . $row["costCenterCode"]  . "]]></costCenterCode>\n";*/
			// break;
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
				$SQL="Select * from SubStores Where strMainID='".$intMainStores."' AND intStatus = 1 ORDER BY substores.strSubStoresName  ";
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strSubID><![CDATA[" . trim($row["strSubID"])  . "]]></strSubID>\n";
				 $ResponseXML .= "<strSubStoresName><![CDATA[" . trim($row["strSubStoresName"])  . "]]></strSubStoresName>\n";  
			}
			$ResponseXML .= "</subStores>";
			echo $ResponseXML;
} 


if($id=="intMatDetailId")
{
		$intMatDetailId=$_GET["value"];

		$SQL="SELECT distinct  StrCatName,genmatsubcategory.intSubCatNo as intSubCatNo from genmatsubcategory,genmatitemlist where genmatitemlist.intSubCatID = genmatsubcategory.intSubCatNo AND genmatitemlist.intItemSerial=".$intMatDetailId." ";
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
		$SQL="SELECT distinct strLocID FROM storesbinallocation WHERE strMainID = '".$strMainId."' AND strSubID = '".$strSubId."' AND intSubCatNo='".$intSubCatId."'";
		
		$ResponseXML .= "<strLocID><![CDATA[" . ""  . "]]></strLocID>\n";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strLocID><![CDATA[" . trim($row["strLocID"])  . "]]></strLocID>\n";
			}
			$ResponseXML .= "</locations>";
			echo $ResponseXML;
} 

if($id=="bins") 
{

	$strMainId=$_GET["strMainId"];
	$strSubId=$_GET["strSubId"];
	$intLocId=$_GET["intLocId"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<bins>";
		
		$SQL		  =" SELECT strBinID, dblCapacityQty, dblFillQty FROM storesbinallocation ".
			 		   " WHERE strMainID =  '".$strMainId."' AND strSubID =  '".$strSubId."' AND strLocID =  '".$intLocId."'";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strBinID><![CDATA[" . trim($row["strBinID"])  . "]]></strBinID>\n";
				 $ResponseXML .= "<dblCapacityQty><![CDATA[" . trim($row["dblCapacityQty"])  . "]]></dblCapacityQty>\n";
				 $ResponseXML .= "<dblFillQty><![CDATA[" . trim($row["dblFillQty"])  . "]]></dblFillQty>\n";
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
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<grnHeader>";
		
		$SQL		  ="SELECT
						S.strTitle AS Supplier,
						P.intYear,
						concat(P.intYear ,'/' ,P.intGenPONo ,' -- ' ,S.strTitle) AS ListF,
						concat(P.intYear ,'/',P.intGenPONo) AS NPONO,
						P.strPINO,
						P.intDeliverTo,
						gengrnheader.strSupAdviceNo,
						gengrnheader.dtAdviceDate,
						gengrnheader.dtRecdDate,
						gengrnheader.strInvoiceNo,
						gengrnheader.strGenGrnNo
						FROM
						generalpurchaseorderheader AS P
						Inner Join suppliers AS S ON P.intSupplierID = S.strSupplierID
						Inner Join gengrnheader ON gengrnheader.intGenPONo = P.intGenPONo AND gengrnheader.intGenPOYear = P.intYear
						WHERE
						(gengrnheader.intStatus = '$intStatus' ) AND P.intStatus=1 and 
						gengrnheader.intYear = '". $intYear ."' AND
						gengrnheader.strGenGrnNo =   '". $intGrnNo ."' ";
		
		$hasRecord=0;
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$hasRecord=1;
				 $ResponseXML .= "<NPONO><![CDATA[" . trim($row["NPONO"])  . "]]></NPONO>\n";
				 $ResponseXML .= "<strSupAdviceNo><![CDATA[" . trim($row["strSupAdviceNo"])  . "]]></strSupAdviceNo>\n";
				 $ResponseXML .= "<dtAdviceDate><![CDATA[" . trim($row["dtAdviceDate"])  . "]]></dtAdviceDate>\n";
				 $ResponseXML .= "<dtRecdDate><![CDATA[" . trim($row["dtRecdDate"])  . "]]></dtRecdDate>\n";
				 $ResponseXML .= "<strInvoiceNo><![CDATA[" . trim($row["strInvoiceNo"])  . "]]></strInvoiceNo>\n"; 
				 $ResponseXML .= "<Supplier><![CDATA[" . trim($row["Supplier"])  . "]]></Supplier>\n"; 
/*				 $ResponseXML .= "<strBatchNO><![CDATA[" . trim($row["strBatchNO"])  . "]]></strBatchNO>\n"; 
*/				
			}
			 $ResponseXML .= "<hasRecord><![CDATA[" . $hasRecord . "]]></hasRecord>\n";
			$ResponseXML .= "</grnHeader>";
			echo $ResponseXML;

}


if($id=="loadgrndetail")
{
	$intGrnNo=$_GET["intGrnNo"];
	$intYear=$_GET["intYear"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<grnDetails>";
		
		$SQL		  ="SELECT
		GMIL.strItemDescription,
		GPD.strUnit,
		GPD.dblUnitPrice,
		(GPD.dblPending+GD.dblQty) AS dblBalance,
		GD.dblQty,
		GD.dblExQty,
		GD.intMatDetailID,
		GH.intYear,
		GH.intGenPONo,
		GMC.strDescription AS Material,
		GSub.StrCatName AS Category
		FROM gengrndetails GD
		Inner Join gengrnheader GH ON GD.strGenGrnNo = GH.strGenGrnNo AND GD.intYear = GH.intYear
		Inner Join generalpurchaseorderdetails GPD ON GPD.intGenPONo = GH.intGenPONo AND GPD.intYear = GH.intGenPOYear AND 
		GPD.intMatDetailID = GD.intMatDetailID 
		Inner Join genmatitemlist GMIL ON GMIL.intItemSerial = GD.intMatDetailID
		Inner Join genmatmaincategory GMC ON GMIL.intMainCatID = GMC.intID
		Inner Join genmatsubcategory GSub ON GMIL.intSubCatID = GSub.intSubCatNo
		WHERE 	GD.strGenGrnNo =  '". $intGrnNo ."' AND GD.intYear = '". $intYear ."' ";
		//echo $SQL;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<Material><![CDATA[" . trim($row["Material"])  . "]]></Material>\n";
				$ResponseXML .= "<Category><![CDATA[" . trim($row["Category"])  . "]]></Category>\n";
				 $ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . trim($row["dblUnitPrice"])  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblBalance><![CDATA[" . trim($row["dblBalance"])  . "]]></dblBalance>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				 $ResponseXML .= "<dblExcessQty><![CDATA[" . trim($row["dblExQty"])  . "]]></dblExcessQty>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . trim($row["intMatDetailID"])  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intYear"])  . "]]></intYear>\n";
				 $ResponseXML .= "<intGenPONo><![CDATA[" . trim($row["intGenPONo"])  . "]]></intGenPONo>\n";
				 $ResponseXML .= "<costCenter><![CDATA[" . trim($row["costCenter"])  . "]]></costCenter>\n";
				 $ResponseXML .= "<costCenterID><![CDATA[" . trim($row["intCostCenterId"])  . "]]></costCenterID>\n";
				 $ResponseXML .= "<intGLId><![CDATA[" . trim($row["intGLAllowId"])  . "]]></intGLId>\n";
				 $ResponseXML .= "<strAccID><![CDATA[" . trim($row["strAccID"])  . "]]></strAccID>\n";
				 $ResponseXML .= "<costCenterCode><![CDATA[" . trim($row["costCenterCode"])  . "]]></costCenterCode>\n";
			}
			$ResponseXML .= "</grnDetails>";
			echo $ResponseXML;

}

if($id=="loadBins")
{


	$strStyleId			= $_GET["strStyleId"];
	$intDocumentNo		= $_GET["intDocumentNo"];
	$strBuyerPoNo		= str_replace("***","#",$_GET["strBuyerPoNo"]);
	$intDocumentYear	= $_GET["intDocumentYear"];
	$intMatDetailID		= $_GET["intMatDetailID"];
	$strColor			= $_GET["strColor"];
	$strSize			= $_GET["strSize"];
	$strType			= $_GET["strType"];
	//$strBuyerPoNo=str_replace("***","#",$_GET["strBuyerPoNo"]);
					
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML .="<grnBins>";
	
	$SQL		  = "SELECT
					stocktransactions.strBin,
					stocktransactions.dblQty,
					stocktransactions.strMainStoresID,
					stocktransactions.strSubStores,
					stocktransactions.strLocation,
					storesbinallocation.dblCapacityQty,
					(dblCapacityQty - dblFillQty) AS availableQty,
					stocktransactions.strUnit,
					storesbinallocation.intSubCatNo
					FROM
					stocktransactions
					Inner Join storesbinallocation ON stocktransactions.strMainStoresID = storesbinallocation.strMainID AND 
					stocktransactions.strSubStores = storesbinallocation.strSubID AND 
					stocktransactions.strLocation = storesbinallocation.strLocID AND 
					stocktransactions.strBin = storesbinallocation.strBinID
					Inner Join genmatitemlist ON stocktransactions.intMatDetailId = genmatitemlist.intItemSerial AND 
					genmatitemlist.intSubCatID = storesbinallocation.intSubCatNo
					WHERE
					stocktransactions.strType =  'GRN' AND
					stocktransactions.intStyleId =  '$strStyleId' AND
					stocktransactions.intDocumentNo =  $intDocumentNo AND
					stocktransactions.intDocumentYear =  $intDocumentYear AND
					stocktransactions.strBuyerPoNo =  '$strBuyerPoNo' AND
					stocktransactions.intMatDetailId =  $intMatDetailID AND
					stocktransactions.strColor =  '$strColor' AND
					stocktransactions.strSize =  '$strSize'";
					
	$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<strBin><![CDATA[" . trim($row["strBin"])  . "]]></strBin>\n";
			 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
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
	$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
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
	}
	echo $active;
}
?>	
