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
		$origin  = $_GET["origin"];
		$comPO   = $_GET["comPO"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<PO>";
				$SQL = 	"SELECT  DISTINCT ".
                      	"P.intPONo  AS dd, P.intPONo, S.strTitle, P.intYear, concat(P.intYear , '/' , P.intPONo , ' -- ' , S.strTitle) AS ListF, ".
                      	"concat(P.intYear  ,'/', P.intPONo) AS NPONO, P.strPINO, P.intDelToCompID ".
						"FROM         purchaseorderdetails PO INNER JOIN ".
                      	"purchaseorderheader P ON PO.intPONo = P.intPONo AND PO.intYear = P.intYear INNER JOIN ".
                      	"suppliers S ON P.strSupplierID = S.strSupplierID ".
						"WHERE      (P.intStatus = 10) AND (P.intDelToCompID = ".$_SESSION["FactoryID"].")";
				if ($strSupplierID!="")
				{
					$SQL .=" AND (S.strSupplierID = '$strSupplierID')";
				}
				if ($dtDateFrom!="")
				{
					$SQL .=" AND (date(P.dtmDate) >= '$dtDateFrom')";
				}
				if ($dtDateTo!="")
				{
					$SQL .=" AND (date(P.dtmDate) <= '$dtDateTo')";
				}
				if ($strPiNo!="")
				{
					$SQL .=" AND (P.intPONo like '%$strPiNo%')";
				}
				if($origin != "")
					$SQL .=" AND (S.strOrigin = '$origin')";
					
				if($comPO == 0)
					$SQL .=" AND (PO.dblPending < 0) ";	
					
				$SQL .= " order by NPONO desc";	
				//echo $SQL;
			$result = $db->RunQuery($SQL);
		$str = "<option value=\"". "" ."\">" . "" ."</option>" ;
		
			while($row = mysql_fetch_array($result))
			{
				 /*$ResponseXML .= "<strPINO><![CDATA[" . $row["NPONO"]  . "]]></strPINO>\n";
				 $ResponseXML .= "<ListF><![CDATA[" . $row["ListF"]  . "]]></ListF>\n"; */ 
				 
				 $str .= "<option value=\"". $row["NPONO"] ."\">" . trim($row["ListF"]) ."</option>";
				 
			}
			$ResponseXML .= "<strPINO><![CDATA[" . $str . "]]></strPINO>\n";
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
		
		$orderNo = $_GET["orderNo"];
		$itemID  = $_GET["itemID"];
		$color   = $_GET["color"];
		$size	 = $_GET["size"];
		$itemDes = $_GET["itemDes"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<Item>";
                
                // ================================================================
                // Comment On - 10/11/2016
                // Comment By - Nalin Jayakody
                // Comment for - Add estimated delivery date against the buyer po number and 
                //              chnage the query to Inner Join instead of the under the where clause.
                // ================================================================
		/* $SQL= "SELECT
matitemlist.strItemDescription AS Description,
specification.intStyleId,
specification.intSRNO,
purchaseorderdetails.strUnit AS strUnit,
purchaseorderdetails.dblPending AS Qty,
purchaseorderdetails.strColor,
purchaseorderdetails.strSize,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.intMatDetailID,
purchaseorderdetails.dblInvoicePrice AS dblUnitPrice,
purchaseorderdetails.strRemarks AS Remarks,
orders.strStyle,
orders.intStatus,
orders.strOrderNo,
orders.strStyle,
purchaseorderdetails.dblQty AS POQty,
matitemlist.intSubCatID,
orders.intBuyerID,
buyers.intBuyerID,
buyers.strName
FROM
purchaseorderdetails ,
matitemlist ,
specification ,
orders ,
buyers
WHERE purchaseorderdetails.intMatDetailId = matitemlist.intitemserial AND orders.intBuyerID  = buyers.intBuyerID AND purchaseorderdetails.intStyleId  = specification.intStyleId AND orders.intStyleId= purchaseorderdetails.intStyleId AND intPoNo= $strPoNo AND intPOType=0
			  AND purchaseorderdetails.intYear=$intYear"; */
		//echo $SQL;
                //
// =========================================
// Comment On - 12/27/2016
// Comment By - Nalin Jayakody
// =========================================
/*                $SQL = "SELECT
matitemlist.strItemDescription AS Description,
specification.intStyleId,
specification.intSRNO,
purchaseorderdetails.strUnit AS strUnit,
purchaseorderdetails.dblPending AS Qty,
purchaseorderdetails.strColor,
purchaseorderdetails.strSize,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.intMatDetailID,
purchaseorderdetails.dblInvoicePrice AS dblUnitPrice,
purchaseorderdetails.strRemarks AS Remarks,
orders.strStyle,
orders.intStatus,
orders.strOrderNo,
orders.strStyle,
purchaseorderdetails.dblQty AS POQty,
matitemlist.intSubCatID,
orders.intBuyerID,
buyers.intBuyerID,
buyers.strName,
deliveryschedule.estimatedDate
FROM
purchaseorderdetails INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
INNER JOIN specification ON specification.intStyleId = purchaseorderdetails.intStyleId
INNER JOIN orders ON orders.intStyleId = specification.intStyleId 
INNER JOIN buyers ON buyers.intBuyerID = orders.intBuyerID
LEFT JOIN deliveryschedule ON deliveryschedule.intStyleId = purchaseorderdetails.intStyleId AND deliveryschedule.intBPO = purchaseorderdetails.strBuyerPONO
WHERE  
intPoNo= $strPoNo AND intPOType=0
			  AND purchaseorderdetails.intYear=$intYear";*/
// =========================================   
    $SQL = " SELECT
matitemlist.strItemDescription AS Description,
specification.intStyleId,
specification.intSRNO,
purchaseorderdetails.strUnit AS strUnit,
purchaseorderdetails.dblPending AS Qty,
purchaseorderdetails.strColor,
purchaseorderdetails.strSize,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.intMatDetailID,
purchaseorderdetails.dblInvoicePrice AS dblUnitPrice,
purchaseorderdetails.strRemarks AS Remarks,
orders.strStyle,
orders.intStatus,
orders.strOrderNo,
orders.strStyle,
purchaseorderdetails.dblQty AS POQty,
matitemlist.intSubCatID,
orders.intBuyerID,
buyers.intBuyerID,
buyers.strName,
deliveryschedule.estimatedDate
FROM
purchaseorderdetails INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
INNER JOIN specification ON specification.intStyleId = purchaseorderdetails.intStyleId
INNER JOIN orders ON orders.intStyleId = specification.intStyleId 
INNER JOIN buyers ON buyers.intBuyerID = orders.intBuyerID
LEFT JOIN style_buyerponos ON style_buyerponos.intStyleId = purchaseorderdetails.intStyleId AND style_buyerponos.strBuyerPoName = purchaseorderdetails.strBuyerPONO
LEFT JOIN deliveryschedule ON deliveryschedule.intStyleId = style_buyerponos.intStyleId AND deliveryschedule.intBPO = style_buyerponos.strBuyerPONO 
WHERE  
intPoNo= $strPoNo AND intPOType=0
			  AND purchaseorderdetails.intYear=$intYear" ;          
		if($orderNo != ''){
			$SQL .= " and purchaseorderdetails.intStyleId = '$orderNo' ";
                }
			
		 if($itemID != ''){
			$SQL .= " and purchaseorderdetails.intMatDetailId = '$itemID' ";
                 }
		 if($color != ''){
                    $SQL .= " and strColor = '$color' ";
                    
                 }
		 if($size != ''){
                    $SQL .= " and strSize = '$size' ";
                    
                 }
		if($itemDes != ''){
                    $SQL .= " and matitemlist.strItemDescription like '%$itemDes%'";
                    
                }
                
                $SQL .= " ORDER BY
						  specification.intSRNO ASC,
						  deliveryschedule.estimatedDate ASC,
						  purchaseorderdetails.intMatDetailID ASC,
						  purchaseorderdetails.strColor ASC,
						  purchaseorderdetails.strSize ASC";
		//echo $SQL;
		$result = $db->RunQuery($SQL);

			while($row = mysql_fetch_array($result))
			{
				$POQty       = $row["POQty"];
				$PendingQty  = $row["Qty"];
				$StyleID     = $row["intStyleId"];
				/*if($PendingQty == $POQty )
				{
					//if item didn't purchase get the po unit price as unit price
					$unitPrice = $row["dblUnitPrice"];
				}
				else
				{
					//get the payment price from the grn table
				}*/
				
				$buyerPOno = $row["strBuyerPONO"];
				if($buyerPOno != '#Main Ratio#')
				{
					//$bpoNo = getBuerPOName($StyleID,$buyerPOno);
                                    $bpoNo =  getBuyerPO($StyleID,$buyerPOno);
				}
				else
				{
                                    $bpoNo = $buyerPOno;
					//$buyerPOno = 'ratio';
				}
				
				 $ResponseXML .= "<Description><![CDATA[" . $row["Description"]  . "]]></Description>\n";
				 $ResponseXML .= "<Remarks><![CDATA[" . $row["Remarks"]  . "]]></Remarks>\n";
				 $ResponseXML .= "<strStyleId><![CDATA[" . $row["intStyleId"]  . "]]></strStyleId>\n";
				 $ResponseXML .= "<SCNo><![CDATA[" . $row["intSRNO"]  . "]]></SCNo>\n";  
				 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
				 $ResponseXML .= "<Qty><![CDATA[" . number_format($row["Qty"],4,'.','')  . "]]></Qty>\n";  
				 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";  
				 $ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n"; 
				 $ResponseXML .= "<strBuyerPONO><![CDATA[" . $buyerPOno  . "]]></strBuyerPONO>\n"; //$bpoNo
				 $ResponseXML .= "<BuyerPOid><![CDATA[" . $buyerPOno  . "]]></BuyerPOid>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  . "]]></StyleName>\n";
				 $ResponseXML .= "<OrderNo><![CDATA[" . $row["strStyle"]  . "]]></OrderNo>\n";
				 $ResponseXML .= "<OrderStatus><![CDATA[" . $row["intStatus"]  . "]]></OrderStatus>\n";
				 $ResponseXML .= "<matSubCat><![CDATA[" . $row["intSubCatID"]  . "]]></matSubCat>\n";
                                 $ResponseXML .= "<estimateDate><![CDATA[" . $row["estimatedDate"]  . "]]></estimateDate>\n";
				 $ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";
			}
			$ResponseXML .= "</Item>";
			echo $ResponseXML;
} 
//addItemToGrn
//s$id="addItemToGrn";
if($id=="addItemToGrn")
{
// FOR EXCESS GRN QTY nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
	$xml = simplexml_load_file('../../config.xml');
	$exPercentage = $xml->GRN->DefaultGRNExcessQtyPercentage;
	$addPOAppMail = $xml->GRN->SendAdditionalPOApprovalMail;
// nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
		
		
		$strMatDetailId=$_GET["strMatDetailId"];
		$strColor=$_GET["strColor"];
		$strSize=$_GET["strSize"];
		$strOrderNo=$_GET["strOrderNo"];
		$strBuyerPoNo=$_GET["strBuyerPoNo"];
		//$strBuyerPoNo=$_GET["strBuyerPoNo"];
		$intNo=$_GET["No"];
		$poNo = $_GET["poNo"]; 
		$poNoarr = explode("/", $poNo);
		$poNo = $poNoarr[1];
		$matSubCat = $_GET["matSubCat"];
		
		if($strBuyerPoNo == 'ratio')
			$strBuyerPoNo = "#Main Ratio#";
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<addItemToGrid>";
		
		//$SQL="SELECT * FROM purchaseorderdetails ,matitemlist,specification  WHERE purchaseorderdetails.intMatDetailId = matitemlist.intitemserial AND purchaseorderdetails.intStyleId = specification.intStyleId  AND purchaseorderdetails.intMatDetailID='$strMatDetailId' AND specification.intStyleId='$strOrderNo' AND strSize='$strSize' AND strColor='$strColor' AND strBuyerPoNo='$strBuyerPoNo' and intPoNo = '$poNo'";
		
		$SQL = "SELECT
		*,specificationdetails.strUnit as specUnit,
		purchaseorderdetails.dblQty as poQty,
		purchaseorderdetails.dblUnitPrice as poUnitPrice,
		orders.strStyle,
		orders.strOrderNo,
		purchaseorderdetails.dblInvoicePrice
		FROM
		purchaseorderdetails
		Inner Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
		Inner Join specification ON specification.intStyleId = purchaseorderdetails.intStyleId
		Inner Join specificationdetails ON specificationdetails.intStyleId = purchaseorderdetails.intStyleId
		inner join orders on orders.intStyleId=specification.intStyleId  AND 
		specification.intStyleId = specificationdetails.intStyleId AND matitemlist.intItemSerial = specificationdetails.strMatDetailID
WHERE purchaseorderdetails.intMatDetailId = matitemlist.intitemserial AND purchaseorderdetails.intStyleId = specification.intStyleId  AND purchaseorderdetails.intMatDetailID='$strMatDetailId' AND specification.intStyleId='$strOrderNo' AND strSize='$strSize' AND strColor='$strColor' AND strBuyerPoNo='$strBuyerPoNo' and intPoNo = '$poNo'
		";
		//echo $SQL;
		
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				$poQty = $row["poQty"];
				//echo $poQty;
				$balance = $row["dblPending"];
				$styleID = $row["intStyleId"];
				
				$buyerPOno = $row["strBuyerPONO"];
				if($buyerPOno != '#Main Ratio#')
				{
                                    //$bpoNo = getBuerPOName($styleID,$buyerPOno);
                                    $bpoNo = getBuyerPO($styleID,$buyerPOno);
                                   
				}
				else
				{
                                    $bpoNo = $buyerPOno;
					//$buyerPOno = 'ratio';
				}
				 $ResponseXML .= "<Description><![CDATA[" . $row["strItemDescription"]  . "]]></Description>\n";
				 $ResponseXML .= "<strStyleId><![CDATA[" . $row["intStyleId"]  . "]]></strStyleId>\n"; 
				 $ResponseXML .= "<SCNo><![CDATA[" . $row["intSRNO"]  . "]]></SCNo>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . $row["specUnit"]  . "]]></strUnit>\n";
				 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";  
				 $ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n"; 
				 $ResponseXML .= "<strBuyerPONO><![CDATA[" . $buyerPOno  . "]]></strBuyerPONO>\n";
				 $ResponseXML .= "<strBuyerPOName><![CDATA[" . $bpoNo  . "]]></strBuyerPOName>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . number_format($row["dblInvoicePrice"],4,'.','') . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblPending><![CDATA[" . number_format($row["dblPending"],2,'.','')  . "]]></dblPending>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . number_format($row["dblQty"],2,'.','')  . "]]></dblQty>\n";
				 $ResponseXML .= "<dblAdditionalQty><![CDATA[" . number_format($row["dblAdditionalQty"],4,'.','')  . "]]></dblAdditionalQty>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<dblAdditionalPendingQty><![CDATA[" . $row["dblAdditionalPendingQty"]  . "]]></dblAdditionalPendingQty>\n";
				  $ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  . "]]></StyleName>\n";
				  $ResponseXML .= "<OrderNo><![CDATA[" . $row["strStyle"]  . " - " . $row["strOrderNo"]  . "]]></OrderNo>\n";  
				 $ResponseXML .= "<POqty><![CDATA[" . $poQty  . "]]></POqty>\n"; 
				 $ResponseXML .= "<matSubCat><![CDATA[" . $matSubCat  . "]]></matSubCat>\n"; 
				 //NNNNNNNNNNNNNNNNNNNNNNNNNNN  FOR EXCESS QTY  NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
				 //comment 2010-12-08
				 /*if($exPercentage == 0 )
				 {
				 	$exQty = 0;
				 }
				 else
				 {
				 	$SQL1 = "SELECT
							useraccounts.Name
							FROM
							useraccounts
							Inner Join userpermission ON userpermission.intUserID = useraccounts.intUserID
							Inner Join role ON userpermission.RoleID = role.RoleID
							WHERE
							role.RoleID =  '102' AND
							useraccounts.intUserID =  '".$_SESSION["UserID"]."'"; 
					$result1 = $db->RunQuery($SQL1);
					$Permision = 0;
					//echo $SQL1;
					while($row1 = mysql_fetch_array($result1))
					{
						$Permision = 1;
					}
					$exQty = $exPercentage;
					if($Permision==1)
					{
						$SQL2 = "SELECT grnexcessqty.dblPercentage as dblPercentage FROM grnexcessqty 
						WHERE grnexcessqty.intFrom <$poQty AND grnexcessqty.strTo >$poQty";
						$result2 = $db->RunQuery($SQL2);
						//echo $SQL2;
						while($row2 = mysql_fetch_array($result2))
						{
							$exQty = $row2["dblPercentage"];
						}
					}
				 	
				 }*/
				 //end 2010-12-08
				 
				//get Excess qty percentage for relavent user
				$exQty = getUserwiseExQty();
				 	//$calExcessQty = ($exQty * $row["dblPending"])/100;
					$calExcessQty = round(((($poQty * ($exQty+100))/100 )-($poQty-$balance)-$balance),2);
					
					if($addPOAppMail == true)
					{
						if($raiseAdditionalPOForExGRNQty  == true)
						{
							$calExcessQty = 100000000;
						}
					}
						
					
				 	$ResponseXML .= "<GrnExcessQty><![CDATA[" . $calExcessQty  . "]]></GrnExcessQty>\n";
				 //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
				 break;
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
		
		$SQL		  ="SELECT
						S.strTitle,
						P.intYear,
						concat(P.intYear ,'/' ,P.intPONo ,' -- ' ,S.strTitle) AS ListF,
						concat(P.intYear ,'/',P.intPONo) AS NPONO,
						P.strPINO,
						P.intDelToCompID,
						grnheader.strSupAdviceNo,
						grnheader.dtmAdviceDate,
						grnheader.strBatchNO,
						grnheader.dtmRecievedDate,
						grnheader.strInvoiceNo,
						grnheader.intGrnNo,
						grnheader.intGRNYear,
						grnheader.strCusdecNo,
						grnheader.strEntryNo,
						grnheader.dblGRNValue,
						grnheader.dblInvoiceValue,
						grnheader.strPayDisReason
						FROM
						purchaseorderheader AS P
						Inner Join suppliers AS S ON P.strSupplierID = S.strSupplierID
						Inner Join grnheader ON grnheader.intPoNo = P.intPONo AND P.intYear = grnheader.intYear
						WHERE
						(P.intStatus =  10) AND
						grnheader.intGRNYear = $intYear AND
						grnheader.intGrnNo =   $intGrnNo AND
						grnheader.intStatus = $intStatus";
						
		$result = $db->RunQuery($SQL);
		//echo $SQL;
		$hasRecord = 0;
			while($row = mysql_fetch_array($result))
			{
				 $hasRecord = 1;
				 $ResponseXML .= "<NPONO><![CDATA[" . trim($row["NPONO"])  . "]]></NPONO>\n";
				 $ResponseXML .= "<Year><![CDATA[" . trim($row["intGRNYear"])  . "]]></Year>\n";
				 $ResponseXML .= "<strSupAdviceNo><![CDATA[" . trim($row["strSupAdviceNo"])  . "]]></strSupAdviceNo>\n";
				 $ResponseXML .= "<dtmAdviceDate><![CDATA[" . trim($row["dtmAdviceDate"])  . "]]></dtmAdviceDate>\n";
				 $ResponseXML .= "<dtmRecievedDate><![CDATA[" . trim($row["dtmRecievedDate"])  . "]]></dtmRecievedDate>\n";
				 $ResponseXML .= "<strInvoiceNo><![CDATA[" . trim($row["strInvoiceNo"])  . "]]></strInvoiceNo>\n"; 
				 $ResponseXML .= "<strBatchNO><![CDATA[" . trim($row["strBatchNO"])  . "]]></strBatchNO>\n"; 
				 $ResponseXML .= "<strBatchNO><![CDATA[" . trim($row["strBatchNO"])  . "]]></strBatchNO>\n"; 
				 $ResponseXML .= "<strCusdecNo><![CDATA[" . trim($row["strCusdecNo"])  . "]]></strCusdecNo>\n";
				 $ResponseXML .= "<EntryNo><![CDATA[" . trim($row["strEntryNo"])  . "]]></EntryNo>\n"; 
				 $ResponseXML .= "<grnValue><![CDATA[" . trim($row["dblGRNValue"])  . "]]></grnValue>\n";
				 $ResponseXML .= "<invoiceValue><![CDATA[" . trim($row["dblInvoiceValue"])  . "]]></invoiceValue>\n";
				 $ResponseXML .= "<PayDisReason><![CDATA[" . trim($row["strPayDisReason"])  . "]]></PayDisReason>\n";
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
//$resultG='';
// FOR EXCESS GRN QTY nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
	$xml = simplexml_load_file('../../config.xml');
	$exPercentage = $xml->GRN->DefaultGRNExcessQtyPercentage;
	$addPOAppMail = $xml->GRN->SendAdditionalPOApprovalMail;
// nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn

	$intGrnNo=$_GET["intGrnNo"];
	$intYear=$_GET["intYear"];
	$intStatus = $_GET["intStatus"];
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<grnDetails>";
		//purchaseorderdetails.dblUnitPrice,
		$SQL		  ="SELECT
						grndetails.intStyleId,
						grndetails.strBuyerPONO,
						matitemlist.strItemDescription,
						matitemlist.intSubCatID,
						grndetails.strColor,
						grndetails.strSize,
						purchaseorderdetails.strUnit,
						grndetails.dblAditionalQty AS dblAditionalQty ,
						grndetails.dblPaymentPrice AS dblUnitPrice,
						purchaseorderdetails.dblPending AS pdblPending,
						purchaseorderdetails.dblQty as poQty,
						grndetails.dblQty AS gdblQty,
						grndetails.dblQty,
						grndetails.dblExcessQty,
						grndetails.intMatDetailID,
						grnheader.intYear,
						grnheader.intPoNo,
						purchaseorderdetails.dblAdditionalPendingQty AS POadditionalPendingQty,
						specification.intSRNO,
						orders.strStyle,
						orders.strOrderNo 
						FROM
						grndetails
						INNER JOIN grnheader ON grndetails.intGrnNo = grnheader.intGrnNo AND 
						
						grndetails.intGRNYear = grnheader.intGRNYear
						INNER JOIN specification ON grndetails.intStyleId = specification.intStyleId 
						INNER JOIN purchaseorderdetails ON purchaseorderdetails.intPoNo = grnheader.intPoNo 
						INNER JOIN orders ON orders.intStyleId = grndetails.intStyleId and 
						purchaseorderdetails.intYear = grnheader.intYear AND 
						grndetails.intStyleId = purchaseorderdetails.intStyleId AND 
						grndetails.strColor = purchaseorderdetails.strColor AND 
						grndetails.strSize = purchaseorderdetails.strSize AND 
						purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND						
						purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
						INNER JOIN matitemlist ON matitemlist.intItemSerial = grndetails.intMatDetailID
						WHERE
						grndetails.intGrnNo =  $intGrnNo AND
						grndetails.intGRNYear =$intYear AND 
						grnheader.intStatus = $intStatus";
						
					//echo $SQL;	
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$buyerPOid = $row["strBuyerPONO"];
				$buyerPOName = $row["strBuyerPONO"];
				$styleID = $row["intStyleId"];
				 $dblBalance = (float)$row["pdblPending"];
				 if($intStatus!=10)
				 	$dblBalance+=(float)$row["gdblQty"];
					
				 if($buyerPOid != '#Main Ratio#')
				 	$buyerPOName = getBuerPOName($styleID,$buyerPOid);
					
				 $poQty = $row["poQty"];
				 $ResponseXML .= "<POQty><![CDATA[" . $poQty . "]]></POQty>\n";
				 $ResponseXML .= "<strStyleID><![CDATA[" . trim($row["intStyleId"])  . "]]></strStyleID>\n";
				 $ResponseXML .= "<strStyleName><![CDATA[" . trim($row["strStyle"])  . "]]></strStyleName>\n";
				  $ResponseXML .= "<OrderNo><![CDATA[" . trim($row["strOrderNo"])  . "]]></OrderNo>\n";
 				 $ResponseXML .= "<SRNO><![CDATA[" . trim($row["intSRNO"])  . "]]></SRNO>\n";
				 $ResponseXML .= "<strBuyerPONO><![CDATA[" . trim($row["strBuyerPONO"])  . "]]></strBuyerPONO>\n";
				 $ResponseXML .= "<strBuyerPOName><![CDATA[" . $buyerPOName . "]]></strBuyerPOName>\n";
				 $ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
				 $ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				 $ResponseXML .= "<strSize><![CDATA[" . trim($row["strSize"])  . "]]></strSize>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 //$ResponseXML .= "<dblUnitPrice><![CDATA[" . number_format($row["dblUnitPrice"],4,'.','')  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . number_format($row["dblUnitPrice"],5,'.','')  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblBalance><![CDATA[" . number_format($dblBalance,2,'.','')  . "]]></dblBalance>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . number_format($row["dblQty"],2,'.','')  . "]]></dblQty>\n";
				 $ResponseXML .= "<dblExcessQty><![CDATA[" . number_format($row["dblExcessQty"],4,'.','')  . "]]></dblExcessQty>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . trim($row["intMatDetailID"])  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intYear"])  . "]]></intYear>\n";
				 $ResponseXML .= "<intPoNo><![CDATA[" . trim($row["intPoNo"])  . "]]></intPoNo>\n";
				 $ResponseXML .= "<dblAditionalQty><![CDATA[" . trim($row["dblAditionalQty"])  . "]]></dblAditionalQty>\n";
     		  	 $ResponseXML .= "<POadditionalPendingQty><![CDATA[" . trim($row["POadditionalPendingQty"])  . "]]></POadditionalPendingQty>\n";
				  $ResponseXML .= "<matSubCat><![CDATA[" . trim($row["intSubCatID"])  . "]]></matSubCat>\n";
				 
				
				 //NNNNNNNNNNNNNNNNNNNNNNNNNNN  FOR EXCESS QTY  NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
				/* if($exPercentage == 0 )
				 {
				 	$exQty = 0;
				 }
				 else
				 {
				 	$SQL1 = "SELECT
							useraccounts.Name
							FROM
							useraccounts
							Inner Join userpermission ON userpermission.intUserID = useraccounts.intUserID
							Inner Join role ON userpermission.RoleID = role.RoleID
							WHERE
							role.RoleID =  '102' AND
							useraccounts.intUserID =  '".$_SESSION["UserID"]."'"; 
					$result1 = $db->RunQuery($SQL1);
					$Permision = 0;
					//echo $SQL1;
					while($row1 = mysql_fetch_array($result1))
					{
						$Permision = 1;
					}
					$exQty = $exPercentage;
					//echo $exQty;
					if($Permision==1)
					{
						$SQL2 = "SELECT grnexcessqty.dblPercentage as dblPercentage FROM grnexcessqty 
						WHERE grnexcessqty.intFrom <".$dblBalance." AND grnexcessqty.strTo > ".$dblBalance."";
						$result2 = $db->RunQuery($SQL2);
						//echo $SQL2;
						while($row2 = mysql_fetch_array($result2))
						{
							
							$exQty = $row2["dblPercentage"];
						}
					}
				 	
				 }*/
				  
				 	//add date 2010-01-07 
					//$calExcessQty = (($poQty * $exQty)/100) -$dblBalance;
					
					$exQty = getUserwiseExQty();
					
					$calExcessQty = (($poQty * ($exQty+100))/100 )-($poQty-$dblBalance)-$dblBalance;
					
					
					if($addPOAppMail == true)
					{
						if($raiseAdditionalPOForExGRNQty  == true)
						{
							$calExcessQty = 100000000;
						}
					}
					
				 	//$finalExQty = ($exQty * $dblBalance)/100;
				 	$ResponseXML .= "<GrnExcessQty><![CDATA[" . $calExcessQty  . "]]></GrnExcessQty>\n";
				 //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
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
		
		
	//get status of grn
	$sql = "SELECT grnheader.intStatus FROM grnheader WHERE grnheader.intGrnNo =  '$intDocumentNo' AND grnheader.intGRNYear =  '$intDocumentYear' ";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$intStatus = $row["intStatus"];
	}	
	if($intStatus == 0)
		$TABLE = 'stocktransactions_temp';
	elseif($intStatus == 1)
		$TABLE = 'stocktransactions';
		
		$ResponseXML .="<grnBins>";
		
		/*$SQL		  = "SELECT 
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
						Inner Join matitemlist ON stocktransactions.intMatDetailId = matitemlist.intItemSerial AND 
						matitemlist.intSubCatID = storesbinallocation.intSubCatNo
						WHERE
						stocktransactions.strType =  'GRN' AND
						stocktransactions.strStyleNo =  '$strStyleId' AND
						stocktransactions.intDocumentNo =  $intDocumentNo AND
						stocktransactions.intDocumentYear =  $intDocumentYear AND
						stocktransactions.strBuyerPoNo =  '$strBuyerPoNo' AND
						stocktransactions.intMatDetailId =  $intMatDetailID AND
						stocktransactions.strColor =  '$strColor' AND
						stocktransactions.strSize =  '$strSize'";*/
						
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
							$TABLE.intStyleId =  '$strStyleId' AND
							$TABLE.intDocumentNo =  $intDocumentNo AND
							$TABLE.intDocumentYear =  $intDocumentYear AND
							$TABLE.strBuyerPoNo =  '$strBuyerPoNo' AND
							$TABLE.intMatDetailId =  $intMatDetailID AND
							$TABLE.strColor =  '$strColor' AND
							$TABLE.strSize =  '$strSize'";
							//echo $SQL;
			$result = $db->RunQuery($SQL);
			//echo $SQL;
			while($row = mysql_fetch_array($result))
			{
			
/*						//get bin name
						$SQL_bin = "SELECT storesbins.strBinName FROM storesbins WHERE storesbins.strBinID =  '".trim($row["strBin"])."'";
						$result_bin = $db->RunQuery($SQL_bin);
						while($row_bin = mysql_fetch_array($result_bin))
						{
							
						}*/
			
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
					}
					echo $active;*/
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .= "<MainstoreBinDetails>";
	$strMainStores		= $_GET["strMainStores"];
	
	$SQL = " select intCommonBin from mainstores where intCompanyId=".$_SESSION["FactoryID"]."  and intStatus=1 and intCommonBin=1 and strMainID=$strMainStores ";
	$count = 0;
	$result = $db->RunQuery($SQL);
	$count = mysql_num_rows($result);
	/*while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<commonbin><![CDATA[" . trim($row["intCommonBin"])  . "]]></commonbin>\n";
		 $ResponseXML .= "<autoBin><![CDATA[" . trim($row["intAutomateCompany"])  . "]]></autoBin>\n";
	}*/
	$ResponseXML .= "<commonbin><![CDATA[" . trim($count)  . "]]></commonbin>\n";
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

if($id=='loadComboDetails')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = '';
	$ResponseXML .= "<searchComboDetails>";
	
	$poNo		= $_GET["poNo"];
	$arrPOno = explode('/',$poNo);
	
	$poYear = $arrPOno[0];
	$poNo   = $arrPOno[1];
	
	$orderNo = getPOwiseOrderDetails($poYear,$poNo);
	$style  = getPOwiseOrderDetailsStyleName($poYear,$poNo);
	$scno   = getPOwiseOrderDetailsSCNO($poYear,$poNo);
	$itemDescription = getPOwiseItemDetails($poYear,$poNo);
	$color  = getPOwiseColor($poYear,$poNo);
	$size   = getPOwiseSize($poYear,$poNo);
	$buyerName = getPOwiseBuyerName($poYear,$poNo);
	
	$ResponseXML .= "<POorderNo><![CDATA[" . $orderNo  . "]]></POorderNo>\n";
	$ResponseXML .= "<POItemDet><![CDATA[" . $itemDescription  . "]]></POItemDet>\n";
	$ResponseXML .= "<POcolor><![CDATA[" . $color  . "]]></POcolor>\n";
	$ResponseXML .= "<POsize><![CDATA[" . $size  . "]]></POsize>\n";
	$ResponseXML .= "<style><![CDATA[" . $style  . "]]></style>\n";
	$ResponseXML .= "<scno><![CDATA[" . $scno  . "]]></scno>\n";
	$ResponseXML .= "<BuyterName><![CDATA[" . $buyerName  . "]]></BuyterName>\n";
	
	$ResponseXML .= "</searchComboDetails>";
	
	echo $ResponseXML;
}
if($id=='checkBinavailabiltyforSubcat')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = '';
	$strMainStores = $_GET["strMainStores"];
	$strSubStores = $_GET["strSubStores"];
	$pub_location = $_GET["pub_location"];
	$pub_bin = $_GET["pub_bin"];
	$mainCatNo = $_GET["mainCatNo"];
	
	$sql = "select * from storesbinallocation
	where strMainID='$strMainStores' and strSubID='$strSubStores' and strLocID='$pub_location' and 
	strBinID='$pub_bin' and intSubCatNo='$mainCatNo' and intStatus=1 ";
	
	$res = $db->CheckRecordAvailability($sql);
	//echo $sql;
	
	$ResponseXML .= "<binAvforSubcat>";
	$ResponseXML .= "<binResult><![CDATA[" . $res  . "]]></binResult>\n";
	$ResponseXML .= "</binAvforSubcat>";
	
	echo $ResponseXML;
}

//BEGIN - 17-06-2011
if($id=='URLISEntryNoRequire')
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<URLISEntryNoRequire>\n";
$poNoArray = explode('/',$_GET["PONo"]);
	$sql="select S.intEntryNoRequire from purchaseorderheader PH inner join suppliers S on S.strSupplierID=PH.strSupplierID where PH.intPONo='$poNoArray[1]' and PH.intYear='$poNoArray[0]';";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<EntryNoRequired><![CDATA[" . $row["intEntryNoRequire"] . "]]></EntryNoRequired>\n";
	}
$ResponseXML .= "</URLISEntryNoRequire>";
echo $ResponseXML;
}
//END - 17-06-2011

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

// =========================
// Add On - 12/27/2016
// Add By - Nalin Jayakody
// =========================
function getBuyerPO($StyleID,$buyerPOno)
{
	$SQL = " SELECT distinct strBuyerPoName FROM style_buyerponos
			 WHERE intStyleId='$StyleID' AND strBuyerPoName='$buyerPOno'";
	
        
			 global $db;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$BPOname = $row["strBuyerPoName"];
			}
		return $BPOname;	 
			 
}

function getUserwiseExQty()
{
	 global $db;
	  $intUserId	= $_SESSION["UserID"];
	 $SQL = "select intExPercentage from useraccounts where intUserID= '$intUserId' ";
	 $result = $db->RunQuery($SQL);
	 $row = mysql_fetch_array($result);
	 
	 return $row["intExPercentage"];
}

function getPOwiseOrderDetails($poYear,$poNo)
{
	global $db;
	
	$sql = "select distinct po.intStyleId,o.strOrderNo
			from purchaseorderdetails po inner join orders o on
			po.intStyleId = o.intStyleId
			where intPoNo='$poNo' and intYear='$poYear' ";
	
	 $result = $db->RunQuery($sql);	
	 
	 $ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	 while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
			}	
	return $ResponseXML;		
}

function getPOwiseOrderDetailsStyleName($poYear,$poNo)
{
	global $db;
	
	$sql = "select distinct o.strStyle
			from purchaseorderdetails po inner join orders o on
			po.intStyleId = o.intStyleId
			where intPoNo='$poNo' and intYear='$poYear' ";
	
	 $result = $db->RunQuery($sql);	
	 
	 $ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	 while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<option value=\"". $row["strStyle"] ."\">".$row["strStyle"]."</option>\n";	
			}	
	return $ResponseXML;		
}

function getPOwiseOrderDetailsSCNO($poYear,$poNo)
{
	global $db;
	
	$sql = "SELECT DISTINCT
			specification.intSRNO,
			o.intStyleId
			FROM
			purchaseorderdetails AS po
			Inner Join orders AS o ON po.intStyleId = o.intStyleId
			Inner Join specification ON o.intStyleId = specification.intStyleId
			where intPoNo='$poNo' and intYear='$poYear' ";
	
	 $result = $db->RunQuery($sql);	
	 
	 $ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	 while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
			}	
	return $ResponseXML;		
}

function getPOwiseBuyerName($poYear,$poNo)
{
	global $db;
	 $sql = "SELECT DISTINCT
po.intStyleId,
o.strOrderNo,
buyers.strName,
o.strStyle
FROM
purchaseorderdetails AS po
Inner Join orders AS o ON po.intStyleId = o.intStyleId
Inner Join buyers ON o.intBuyerID = buyers.intBuyerID
where intPoNo='$poNo' and intYear='$poYear' ";	

	$result = $db->RunQuery($sql);
	
	$ResponseXML .= "<option value=\"". "". "\">".""."</option>\n";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strName"]."</option>\n";
	}
	
	return $ResponseXML;
}

function getPOwiseItemDetails($poYear,$poNo)
{
	global $db;
	
	$sql = " select distinct po.intMatDetailID,m.strItemDescription
			from purchaseorderdetails po inner join matitemlist m on
			po.intMatDetailID = m.intItemSerial
			where intPoNo='$poNo' and intYear='$poYear' ";
	
	 $result = $db->RunQuery($sql);	
	 
	 $ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	 while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<option value=\"". $row["intMatDetailID"] ."\">".$row["strItemDescription"]."</option>\n";	
			}	
	return $ResponseXML;		
}

function getPOwiseColor($poYear,$poNo)
{
	global $db;
	
	$sql = " select distinct strColor from purchaseorderdetails
			where intPoNo='$poNo' and intYear='$poYear' ";
	
	 $result = $db->RunQuery($sql);	
	 
	 $ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	 while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<option value=\"". $row["strColor"] ."\">".$row["strColor"]."</option>\n";	
			}	
	return $ResponseXML;		
}

function getPOwiseSize($poYear,$poNo)
{
	global $db;
	
	$sql = " select distinct strSize from purchaseorderdetails
			where intPoNo='$poNo' and intYear='$poYear' ";
	
	 $result = $db->RunQuery($sql);	
	 
	 $ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	 while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<option value=\"". $row["strSize"] ."\">".$row["strSize"]."</option>\n";	
			}	
	return $ResponseXML;		
}
?>	
