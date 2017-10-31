<?php 
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["req"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];


//------------------
if($RequestType=="loadGrid"){
	$style		= $_GET["style"];
	$maincatid		= $_GET["maincatid"];
	$subcatid			= $_GET["subcatid"];	
	$material		= $_GET["material"];
	$color		= $_GET["color"];
	$size		= $_GET["size"];
	$grnNo			= $_GET["grnNo"];	
	$poNo		= $_GET["poNo"];
	
	
	
	$SQL = "select stocktransactions.strMainStoresID  ,
	mainstores.strName as mainStoreDesc,
	matitemlist.strItemDescription,
	stocktransactions.strSubStores,
	substores.strSubStoresName,
	stocktransactions.strLocation,
	storeslocations.strLocName,
	stocktransactions.strBin,
	storesbins.strBinName,
	stocktransactions.strStyleNo,
	stocktransactions.intMatDetailId,
	sum(stocktransactions.dblQty) as Qty, 
	stocktransactions.dblQty 
	 from stocktransactions 
	 join matitemlist  on stocktransactions.intMatDetailId=matitemlist.intItemSerial 
	 join grndetails on  grndetails.intMatDetailID=stocktransactions.intMatDetailId and  grndetails.strStyleID=stocktransactions.strStyleNo 
	 join grnheader on  grndetails.intGrnNo=grnheader.intGrnNo and grndetails.intGRNYear=grnheader.intGRNYear 
	 join mainstores on mainstores.strMainID=stocktransactions.strMainStoresID 
	 join substores on substores.strSubID=stocktransactions.strSubStores 
	 join storeslocations on storeslocations.strLocID=stocktransactions.strLocation 
	 join storesbins on storesbins.strBinID=stocktransactions.strBin 
	 where matitemlist.intMainCatID =  '$maincatid' and matitemlist.intSubCatID =  '$subcatid' and stocktransactions.strStyleNo =  '$style'";
	
if($material!="")
	 $SQL.=" and stocktransactions.intMatDetailId =  '$material'";
	
if($color!="")
	 $SQL.=" and stocktransactions.strColor = '$color'";

if($size!="")
	 $SQL.=" and stocktransactions.strSize = '$size'";
	 
if($grnNo!="")
	 $SQL.=" and grndetails.intGrnNo = '$grnNo'";
	 
if($poNo!="")
	 $SQL.=" and grnheader.intPoNo = '$poNo'";
	 
	 
	
	 $SQL.=" group by stocktransactions.intMatDetailId,stocktransactions.strSubStores,stocktransactions.strLocation,stocktransactions.strBin,stocktransactions.strStyleNo";
				//echo $SQL;
				$result = $db->RunQuery($SQL);
				$ResponseXML .="<LoadDisposeList>\n";
			while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<strMainStoresID><![CDATA[" . $row["mainStoreDesc"] . "]]></strMainStoresID>\n";
				$ResponseXML .= "<strSubStores><![CDATA[" . $row["strSubStoresName"]  . "]]></strSubStores>\n";  
				$ResponseXML .= "<strLocation><![CDATA[" . $row["strLocName"]  . "]]></strLocation>\n";
				$ResponseXML .= "<strBin><![CDATA[" . $row["strBinName"]  . "]]></strBin>\n";
				$ResponseXML .= "<strStyleNo><![CDATA[" . $row["strStyleNo"]  . "]]></strStyleNo>\n";
				$ResponseXML .= "<intMatDetailId><![CDATA[" . $row["strItemDescription"]  . "]]></intMatDetailId>\n";
				$ResponseXML .= "<dblQty><![CDATA[" . $row["Qty"]  . "]]></dblQty>\n";
			}
			  $ResponseXML .="</LoadDisposeList>\n";
			  echo $ResponseXML ;
}
//---------------------------------------

if($RequestType=="loadGrid2"){
	$mainStore		= $_GET["mainStore"];
	$subStore		= $_GET["subStore"];
	$location			= $_GET["location"];	
	$bin		= $_GET["bin"];
	
	
	
	$SQL = "select stocktransactions.strMainStoresID  ,
	mainstores.strName as mainStoreDesc,
	matitemlist.strItemDescription,
	stocktransactions.strSubStores,
	substores.strSubStoresName,
	stocktransactions.strLocation,
	storeslocations.strLocName,
	stocktransactions.strBin,
	storesbins.strBinName,
	stocktransactions.strStyleNo,
	stocktransactions.intMatDetailId,
	sum(stocktransactions.dblQty) as Qty, 
	stocktransactions.strSize,
	stocktransactions.strColor,
	grndetails.intGrnNo,
	grnheader.intPoNo,
	stocktransactions.dblQty 
	 from stocktransactions 
	 join matitemlist  on stocktransactions.intMatDetailId=matitemlist.intItemSerial 
	 join grndetails on  grndetails.intMatDetailID=stocktransactions.intMatDetailId and  grndetails.strStyleID=stocktransactions.strStyleNo 
	 join grnheader on  grndetails.intGrnNo=grnheader.intGrnNo and grndetails.intGRNYear=grnheader.intGRNYear 
	 join mainstores on mainstores.strMainID=stocktransactions.strMainStoresID 
	 join substores on substores.strSubID=stocktransactions.strSubStores 
	 join storeslocations on storeslocations.strLocID=stocktransactions.strLocation 
	 join storesbins on storesbins.strBinID=stocktransactions.strBin 
	 ";
	
if($mainStore!="")
	 $SQL.=" where mainstores.strMainID =  '$mainStore'";
	
if($subStore!="")
	 $SQL.=" and substores.strSubID = '$subStore'";

if($location!="")
	 $SQL.=" and storeslocations.strLocID = '$location'";
	 
if($bin!="")
	 $SQL.=" and storesbins.strBinID = '$bin'";
	 
	 
	 
	
	 $SQL.=" group by mainstores.strMainID,substores.strSubID,storeslocations.strLocID,storesbins.strBinID,stocktransactions.intMatDetailId,stocktransactions.strStyleNo";
			//	echo $SQL;
				$result = $db->RunQuery($SQL);
				$ResponseXML .="<LoadDisposeList>\n";
			while($row = mysql_fetch_array($resultx))
			{
				$ResponseXML .= "<strMainStoresID><![CDATA[" . $row["mainStoreDesc"] . "]]></strMainStoresID>\n";
				$ResponseXML .= "<strSubStores><![CDATA[" . $row["strSubStoresName"]  . "]]></strSubStores>\n";  
				$ResponseXML .= "<strLocation><![CDATA[" . $row["strLocName"]  . "]]></strLocation>\n";
				$ResponseXML .= "<strBin><![CDATA[" . $row["strBinName"]  . "]]></strBin>\n";
				$ResponseXML .= "<strStyleNo><![CDATA[" . $row["strStyleNo"]  . "]]></strStyleNo>\n";
	
	
				$ResponseXML .= "<intGrnNo><![CDATA[" . $row["intGrnNo"]  . "]]></intGrnNo>\n";
				$ResponseXML .= "<intPoNo><![CDATA[" . $row["intPoNo"]  . "]]></intPoNo>\n";
				
				
				$ResponseXML .= "<intMatDetailId><![CDATA[" . $row["strItemDescription"]  . "]]></intMatDetailId>\n";
				
	
	
				$ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
				$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
				
				
				$ResponseXML .= "<dblQty><![CDATA[" . $row["Qty"]  . "]]></dblQty>\n";
			}
			  $ResponseXML .="</LoadDisposeList>\n";
			  echo $ResponseXML ;
}
?>