<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";
$id=$_GET["id"];


if($id=="loadMainCategory")
{	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<genmatmaincategory>";
		$SQL="SELECT intID,strDescription FROM genmatmaincategory where status='1' ORDER BY strDescription";
				
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<intID><![CDATA[" . $row["intID"]  . "]]></intID>\n";
			 $ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";  
		}
		$ResponseXML .= "</genmatmaincategory>";
		echo $ResponseXML;
}

if($id=="loadSubCategory")
{	

		$intMainCatId = $_GET["mainCatId"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<genmatsubcategory>";

		$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";
				
		$result = $db->RunQuery($SQL);
		$ResponseXML .= "<intSubCatNo><![CDATA[" . "" . "]]></intSubCatNo>\n";
		$ResponseXML .= "<StrCatName><![CDATA[" . ""  . "]]></StrCatName>\n";
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<intSubCatNo><![CDATA[" . $row["intSubCatNo"]  . "]]></intSubCatNo>\n";
				 $ResponseXML .= "<StrCatName><![CDATA[" . $row["StrCatName"]  . "]]></StrCatName>\n";  
			}
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}

if($id=="loadMaterial")
{	

		$mainCatId = trim($_GET["mainCatId"]);
		$subCatId = trim($_GET["subCatId"]);
		$txtDetailsLike = trim($_GET["txtDetailsLike"]);
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<genmatsubcategory>";

		$SQL="SELECT intItemSerial,strItemDescription,strUnit FROM genmatitemlist WHERE intMainCatID =$mainCatId ";
		if($subCatId!="")
			$SQL.="  AND intSubCatID =$subCatId ";
		if($txtDetailsLike!="")
			$SQL.="  AND strItemDescription like '%$txtDetailsLike%' ";
		
			$SQL.="  ORDER BY strItemDescription";
				
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<intItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></intItemSerial>\n";
				 $ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";  
				 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";  
			}
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}

if($id=="loadColor")
{	
		$SQL="SELECT distinct strColor FROM colors ORDER BY strColor";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $text .= "<option>" . $row["strColor"]  ."</option>\n";
		}
		echo $text;
}

if($id=="loadSize")
{	
		$SQL="SELECT distinct strSize FROM sizes ORDER BY strSize";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $text .= "<option>" . $row["strSize"]  . "</option>\n";
			}
			echo $text;
}

if($id=="setCurrency")
{	
		$supId = $_GET["supId"];
		$SQL="SELECT strCurrency FROM suppliers  where intStatus='1' AND strSupplierID=$supId";
		$result = $db->RunQuery($SQL);
		$text= "";
		while($row = mysql_fetch_array($result))
		{
			 $text =  $row["strCurrency"]  ;
		}
		echo $text;
}

if($id=="loadBulkPo")
{
		$fromDate		= $_GET["fromDate"];
		$toDate			= $_GET["toDate"];
		$intStatus		= $_GET["intStatus"];
		$intPoNo		= $_GET["poNo"];
		$intSupplierID	= $_GET["intSupplierID"];
		$intCompanyId	=	$_SESSION["FactoryID"];
		 
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<BulkPo>";
		$SQL=  "	SELECT
					GH.intGenPONo,
					GH.intYear,
					GH.intUserID,
					(select Name from useraccounts UA where GH.intUserID=UA.intUserID)as userName,
					suppliers.strTitle,
					date(dtmDate)as genDate
					FROM
					generalpurchaseorderheader GH
					Inner Join suppliers ON suppliers.strSupplierID = GH.intSupplierID
					WHERE
					GH.intStatus =  '$intStatus'  ";				

				if($fromDate!="")
				{
					$SQL.=" AND GH.dtmDate>='$fromDate' ";
				}
				if($toDate!="")
				{
					$SQL.=" AND GH.dtmDate<='$toDate'";
				}
				
				if($intPoNo!="")
				{
					$SQL.=" AND GH.intGenPONo LIKE '%$intPoNo%' ";
				}
				if($intSupplierID!="")
				{
					$SQL.=" AND GH.intSupplierID = '$intSupplierID' ";
				}
				
					$SQL.=" order by dtmDate desc limit 0,20";
		
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$permision = 0;
				if($row["intUserID"]==$_SESSION["UserID"])
					$permision=1;
					
				 $ResponseXML .= "<intGenPONo><![CDATA[" . $row["intGenPONo"]  . "]]></intGenPONo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . $row["intYear"]  . "]]></intYear>\n"; 
				 $ResponseXML .= "<strTitle><![CDATA[" . $row["strTitle"]  . "]]></strTitle>\n";
				 $ResponseXML .= "<permision><![CDATA[" . $permision  . "]]></permision>\n";
				 $ResponseXML .= "<userName><![CDATA[" . $row["userName"]  . "]]></userName>\n";
				 $ResponseXML .= "<date><![CDATA[" .  $row["genDate"]  . "]]></date>\n";
				 
			}
			$ResponseXML .= "</BulkPo>";
			echo $ResponseXML;
}

if($id=="loadBulkPoHeader")
{
	$intGenPONo	=$_GET["intGenPONo"];
	$intYear		=$_GET["intYear"];
	$intStatus		=$_GET["intStatus"];
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<BulPoHeader>";
		
		$SQL		  ="SELECT
						generalpurchaseorderheader.intGenPONo,
						generalpurchaseorderheader.intYear,
						generalpurchaseorderheader.intSupplierID,
						generalpurchaseorderheader.dtmDate,
						generalpurchaseorderheader.dtmDeliveryDate,
						generalpurchaseorderheader.strCurrency,
						generalpurchaseorderheader.intStatus,
						generalpurchaseorderheader.intCompId,
						generalpurchaseorderheader.intDeliverTo,
						generalpurchaseorderheader.strPayTerm,
						generalpurchaseorderheader.intPayMode,
						generalpurchaseorderheader.intShipmentModeId,
						generalpurchaseorderheader.strInstructions,
						generalpurchaseorderheader.strPINO,
						generalpurchaseorderheader.intInvoiceComp
						FROM
						generalpurchaseorderheader
						WHERE
						intYear = 	$intYear AND
						intGenPONo =   '$intGenPONo' AND intStatus	= '$intStatus'";
						
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<intGenPONo><![CDATA[" . trim($row["intGenPONo"])  . "]]></intGenPONo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intYear"])  . "]]></intYear>\n";
				 $ResponseXML .= "<intSupplierID><![CDATA[" . trim($row["intSupplierID"])  . "]]></intSupplierID>\n";
				 $ResponseXML .= "<dtmDate><![CDATA[" . trim($row["dtmDate"])  . "]]></dtmDate>\n";
				 $ResponseXML .= "<dtmDeliveryDate><![CDATA[" . trim($row["dtmDeliveryDate"])  . "]]></dtmDeliveryDate>\n";
				 $ResponseXML .= "<strCurrency><![CDATA[" . trim($row["strCurrency"])  . "]]></strCurrency>\n";
				 $ResponseXML .= "<intStatus><![CDATA[" . trim($row["intStatus"])  . "]]></intStatus>\n";
				 $ResponseXML .= "<intCompId><![CDATA[" . trim($row["intCompId"])  . "]]></intCompId>\n";
				 $ResponseXML .= "<intDeliverTo><![CDATA[" . trim($row["intDeliverTo"])  . "]]></intDeliverTo>\n";
				 $ResponseXML .= "<strPayTerm><![CDATA[" . trim($row["strPayTerm"])  . "]]></strPayTerm>\n";
				 $ResponseXML .= "<intPayMode><![CDATA[" . trim($row["intPayMode"])  . "]]></intPayMode>\n";
				 $ResponseXML .= "<intShipmentModeId><![CDATA[" . trim($row["intShipmentModeId"])  . "]]></intShipmentModeId>\n";
				 $ResponseXML .= "<strInstructions><![CDATA[" . trim($row["strInstructions"])  . "]]></strInstructions>\n";
				 $ResponseXML .= "<strPINO><![CDATA[" . trim($row["strPINO"])  . "]]></strPINO>\n";
				 $ResponseXML .= "<intInvoiceComp><![CDATA[" . trim($row["intInvoiceComp"])  . "]]></intInvoiceComp>\n";
				 break;
			}
			$ResponseXML .= "</BulPoHeader>";
			echo $ResponseXML;

}


if($id=="loadBulkPoDetails")
{
		$intGenPONo		=$_GET["intGenPONo"];
		$intYear		=$_GET["intYear"];
		$intStatus		=$_GET["intStatus"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<BulPoDetails>";
		
		/*$SQL		  =" SELECT
						generalpurchaseorderdetails.strDescription AS itemDescription,
						genmatmaincategory.strDescription AS strMainCategory,
						generalpurchaseorderdetails.strUnit,
						generalpurchaseorderdetails.dblUnitPrice,
						generalpurchaseorderdetails.dblQty,
						generalpurchaseorderdetails.intMatDetailID,
						generalpurchaseorderheader.intStatus
						FROM
						generalpurchaseorderdetails
						Inner Join genmatmaincategory ON genmatmaincategory.intID = generalpurchaseorderdetails.strMatID
						Inner Join generalpurchaseorderheader ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo 
						AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
						WHERE
						generalpurchaseorderheader.intStatus 		=  $intStatus AND
						generalpurchaseorderdetails.intYear 		= 	$intYear AND
						generalpurchaseorderdetails.intGenPONo 	=   '$intGenPONo'";*/
		$SQL		  =" SELECT
						
						genmatmaincategory.strDescription AS strMainCategory,
						genmatitemlist.strItemDescription as itemDescription,
						generalpurchaseorderdetails.strUnit,
						generalpurchaseorderdetails.dblUnitPrice,
						generalpurchaseorderdetails.dblQty,
						generalpurchaseorderdetails.intMatDetailID,
						generalpurchaseorderheader.intStatus,
						genmatmaincategory.strDescription AS strMainCategory
						FROM
						generalpurchaseorderdetails
						Inner Join generalpurchaseorderheader 
						ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo 
						AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
						Inner Join genmatitemlist ON generalpurchaseorderdetails.intMatDetailID = genmatitemlist.intItemSerial
						Inner Join genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID
						WHERE
						generalpurchaseorderheader.intStatus 		= $intStatus AND
						generalpurchaseorderdetails.intYear 		= $intYear AND
						generalpurchaseorderdetails.intGenPONo 	=  '$intGenPONo' ";
		$result = $db->RunQuery($SQL);
		//echo $SQL;
		
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strMainCategory><![CDATA[" . trim($row["strMainCategory"])  . "]]></strMainCategory>\n";
				 $ResponseXML .= "<itemDescription><![CDATA[" . trim($row["itemDescription"])  . "]]></itemDescription>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . trim($row["dblUnitPrice"])  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblBalance><![CDATA[" . trim($row["dblBalance"])  . "]]></dblBalance>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . trim($row["intMatDetailID"])  . "]]></intMatDetailID>\n";
				 
			}
			$ResponseXML .= "</BulPoDetails>";
			echo $ResponseXML;

}

if($id=="GetPO")
{
	$intCompanyId	=	$_SESSION["FactoryID"];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	global $db;
	$sql="SELECT DISTINCT p.intGenPONo,p.intYear FROM generalpurchaseorderheader p INNER JOIN generalpurchaseorderdetails d  ON p.intGenPONo=d.intGenPONo where intStatus='10' OR intStatus='11'
	and intCompId = '$intCompanyId' ORDER BY intGenPONo DESC";
	$result=$db->RunQuery($sql);
	$ResponseXML = "";	
	$ResponseXML .= "<PONos>\n";
		while($row = mysql_fetch_array($result))
		{
		$ResponseXML .= "<PO><![CDATA[" . $row["intGenPONo"]. "]]></PO>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intYear"]. "]]></Year>\n";
		}
	$ResponseXML .= "</PONos>";
	echo $ResponseXML;
}

?>
