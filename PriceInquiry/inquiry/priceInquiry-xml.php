<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";
$id=$_GET["id"];

if (strcmp($id,"loadSubCategory") == 0)
{
	ob_get_clean();
	
	$cboCategory = $_GET["cboCategory"];
	
	$sql = "SELECT intSubCatNo,StrCatName from matsubcategory ";	
	//echo $sql;
	if ($cboCategory!="")
	{
		$sql .= " WHERE matsubcategory.intCatNo = '$cboCategory' ";
	}
		$sql .= "  ORDER BY intSubCatNo ";

	$result = $db->RunQuery($sql);
	echo "<option value=\"\"></option>";
	//echo "<option value=\"#Main Ratio#\">#Main Ratio#</option>";	
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intSubCatNo"]  . "\">" . $row["StrCatName"]  . "</option>";
	}
}

if($id=="loadPriceInquiry")
{
 $cboSupplier = $_GET["cboSupplier"];
 $cboCategory = $_GET["cboCategory"];
 $cboSubCategory = $_GET["cboSubCategory"];
 $cboItem = $_GET["cboItem"];
 $chkDate = $_GET["chkDate"];
 if($chkDate == 'true'){
 $DateFrom		= $_GET["DateFrom"];
  $DateFromArray		= explode('/',$DateFrom);
   $formatedDateFrom = $DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];

  $DateTo		= $_GET["DateTo"];
   $DateToArray		= explode('/',$DateTo);
    $formatedDateTo = $DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
 }else{
 $formatedDateFrom = "";
 $formatedDateTo   = "";
 }
 $sortDate  = $_GET["sortDate"];
 $sortPrice = $_GET["sortPrice"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadPriceInquiry>";
		

		$SQL = "SELECT suppliers.strTitle,purchaseorderheader.intPONo,date(purchaseorderheader.dtmDate)AS dtmDate,matitemlist.strItemDescription,
		        purchaseorderdetails.strColor,purchaseorderdetails.strSize,purchaseorderdetails.dblUnitPrice,purchaseorderheader.strCurrency
				FROM 
				purchaseorderheader INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo=purchaseorderdetails.intPONo
				                    INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
									INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
     			WHERE purchaseorderheader.intUserID != ''";
				
		 if($cboSupplier != "" ){
		  $SQL .= " AND purchaseorderheader.strSupplierID = '$cboSupplier'";
		  }	
				
		  if($cboCategory != "" ){
		  $SQL .= " AND matitemlist.intMainCatID = '$cboCategory'";
		  }	
		  
		  if($cboSubCategory != "" ){
		  $SQL .= " AND matitemlist.intSubCatID = '$cboSubCategory'";
		  }	
		  
		  if($cboItem != "" ){
		  $SQL .= " AND purchaseorderdetails.intMatDetailID = '$cboItem'";
		  }	
		  
		  if($DateFrom != ""){
		  $SQL .= " AND purchaseorderheader.dtmDate >= '$formatedDateFrom'";
		  }	
		  
		  if($DateTo != ""){
		  $SQL .= " AND purchaseorderheader.dtmDate <= '$formatedDateTo'";
		  }	
		  

		  $SQL .= " GROUP BY purchaseorderdetails.intMatDetailID,purchaseorderheader.strSupplierID ORDER BY";
		  
		  if($sortDate == "DL"){
		  $SQL .= " purchaseorderheader.dtmDate DESC,";
		  }	
		  
		  if($sortDate == "DE"){
		  $SQL .= " purchaseorderheader.dtmDate ASC,";
		  }	
		  
		  if($sortDate == "NO"){
		  $SQL .= " purchaseorderheader.intPONo,";
		  }	
		  
		  if($sortPrice == "PL"){
		  $SQL .= " purchaseorderdetails.dblUnitPrice ASC";
		  }	
		  
		  if($sortPrice == "PH"){
		  $SQL .= " purchaseorderdetails.dblUnitPrice DESC";
		  }	
		  
		  if($sortPrice == "NO"){
		  $SQL .= " purchaseorderheader.intPONo";
		  }	
		$result = $db->RunQuery($SQL);
		//echo $SQL;

			while($row = mysql_fetch_array($result))
			{
    			 $ResponseXML .= "<suppliers><![CDATA[" . trim($row["strTitle"])  . "]]></suppliers>\n";	
				 $ResponseXML .= "<intPONo><![CDATA[" . trim($row["intPONo"])  . "]]></intPONo>\n";
				 $ResponseXML .= "<dtmDate><![CDATA[" . trim($row["dtmDate"])  . "]]></dtmDate>\n";
				 $ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
  				 $ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				 $ResponseXML .= "<strSize><![CDATA[" . trim($row["strSize"])  .  "]]></strSize>\n";	
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . number_format(trim($row["dblUnitPrice"]),2)  .  "]]></dblUnitPrice>\n";	
				 $ResponseXML .= "<strCurrency><![CDATA[" . trim($row["strCurrency"])  .  "]]></strCurrency>\n";		 
			}
			$ResponseXML .= "</loadPriceInquiry>";
			
		echo $ResponseXML;
}
?>
