<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];


if ($request=='getDetailData')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceno=$_GET["invoiceno"];
	
	$sqlDetail="SELECT 	strInvoiceNo, 
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblCMP, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind,
	dblUMOnQty1, 
	UMOQtyUnit1, 
	dblUMOnQty2, 
	UMOQtyUnit2, 
	dblUMOnQty3, 
	UMOQtyUnit3,
	strISDno,
	strFabrication
	FROM 
	bookingdetail 
	WHERE strInvoiceNo='$invoiceno'ORDER BY intItemNo";
	
	//die($sqlDetail);

	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		//die("pass");
			$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow["strStyleID"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow["intItemNo"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $detailrow["strBuyerPONo"]  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow["strDescOfGoods"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow["dblQuantity"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow["strUnitID"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow["dblUnitPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow["dblGrossMass"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow["dblNetMass"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow["strPriceUnitID"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow["intNoOfCTns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1><![CDATA[" . $detailrow["dblUMOnQty1"]  . "]]></dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2><![CDATA[" . $detailrow["dblUMOnQty2"]  . "]]></dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3><![CDATA[" . $detailrow["dblUMOnQty3"]  . "]]></dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1><![CDATA[" . $detailrow["UMOQtyUnit1"]  . "]]></UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2><![CDATA[" . $detailrow["UMOQtyUnit2"]  . "]]></UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3><![CDATA[" . $detailrow["UMOQtyUnit3"]  . "]]></UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabrication><![CDATA[" . $detailrow["strFabrication"]  . "]]></Fabrication>\n";
			
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='editData')
{
	$invoiceno=$_GET["invoiceno"];
	$bpo=$_GET["bpo"];
	$cm=$_GET["cm"];
	$ctns=$_GET["ctns"];
	$dsc=$_GET["dsc"];
	$gross=$_GET["gross"];	
	$hs=$_GET["hs"];	
	$net=$_GET["net"];	
	$style=$_GET["style"];	
	$unit=$_GET["unit"];	
	$unitprice=$_GET["unitprice"];	
	$unitqty=$_GET["unitqty"];	
	$value=$_GET["value"];
	$pos=$_GET["pos"];	
	$wut=$_GET["wut"];
	$qty=$_GET["qty"];
	$category=$_GET["category"];
	$procedurecode=$_GET["procedurecode"];
	$umoqty1=$_GET["umoqty1"];
	$umoqty2=$_GET["umoqty2"];
	$umoqty3=$_GET["umoqty3"];
	$umoUnit1=$_GET["umoUnit1"];
	$umoUnit2=$_GET["umoUnit2"];
	$umoUnit3=$_GET["umoUnit3"];
	$ISDNo=$_GET["ISDNo"];
	$fabrication=$_GET["fabrication"];
	if ($gross=="")
		$gross=0;
	if ($net=="")
		$net=0;
	if ($ctns=="")
		$ctns=0;
	if ($umoqty1=="")
		$umoqty1=0;
	if ($umoqty2=="")
		$umoqty2=0;
	if ($umoqty3=="")
		$umoqty3=0;
	if ($cm=="")
		$cm=0;
	
	
	if ($wut=='update')
	{
	$sqlupdate="UPDATE bookingdetail 
	SET
	strInvoiceNo = '$invoiceno' , 
	strStyleID = '$style' , 
	intItemNo = '$pos' , 
	strBuyerPONo = '$bpo' , 
	strDescOfGoods = '$dsc' , 
	dblQuantity = '$qty' , 
	strUnitID = '$unitqty' , 
	dblUnitPrice = '$unitprice' , 
	strPriceUnitID = '$unit' , 
	dblCMP = '$cm' , 
	dblAmount = '$value' , 
	strHSCode = '$hs' , 
	dblGrossMass = '$gross' , 
	dblNetMass = '$net' , 
	strProcedureCode = '$procedurecode' , 
	strCatNo = '$category' , 
	intNoOfCTns = '$ctns' , 
	strKind = '1',
	dblUMOnQty1 = '$umoqty1' , 
	UMOQtyUnit1 = '$umoUnit1' , 
	dblUMOnQty2 = '$umoqty2' , 
	UMOQtyUnit2 = '$umoUnit2' , 
	dblUMOnQty3 = '$umoqty3' , 
	UMOQtyUnit3 = '$umoUnit3',
	strISDno = '$ISDNo',
	strFabrication='$fabrication'
	WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = '$pos'";
	
	$updateresult=$db->RunQuery($sqlupdate);
	
	if($updateresult){
	echo "Successfully updated";
	$state=1;
	}
	else 
	echo $sqlupdate; 
	//echo "Sorry,Operation Failed!";	
	
	
	}
	
	if ($wut=='insert')
	{
	 $sqlinsert="INSERT INTO bookingdetail 
	(strInvoiceNo, 
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblCMP, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind,
	dblUMOnQty1, 
	UMOQtyUnit1, 
	dblUMOnQty2, 
	UMOQtyUnit2, 
	dblUMOnQty3, 
	strISDno,
	strFabrication
	)
	VALUES
	('$invoiceno', 
	'$style', 
	'$pos', 
	'$bpo', 
	'$dsc', 
	'$qty', 
	'$unitqty', 
	'$unitprice', 
	'$unit', 
	'$cm', 
	'$value', 
	'$hs', 
	'$gross', 
	'$net', 
	'$procedurecode', 
	'$category', 
	'$ctns', 
	'1',
	'$umoqty1',
	'$umoUnit1',
	'$umoqty2',
	'$umoUnit2',
	'$umoqty3',
	'$ISDNo',
	'$fabrication'
	);";
	 $insertresultsql=$db->RunQuery($sqlinsert);
	 if ($insertresultsql)
	 {
	 echo "Successfully saved";	
	 $state=1;
	 }
	 else 
	 	echo $sqlinsert; 
	  //echo "Sorry,Operation Failed!";	
	 		
	}
	
	if($state==1)
	{
		$strdelfirst="DELETE FROM excusdectax 
					WHERE
					strInvoiceNo = '$invoiceno' AND intPosition='$pos';";
		$resultstrdelfirst=$db->RunQuery($strdelfirst);
		$extaxstr="SELECT
 		strCommodityCode, 
		strTaxCode, 
		intPosition, 
		dblPercentage, 
		strRemarks, 
		intMP	 
		FROM 
		excommoditycodes 
		WHERE
		strCommodityCode='$hs' and strTaxCode!=''";
		$taxpos=1;
		$extaxresult=$db->RunQuery($extaxstr);
		while($taxresultrow=mysql_fetch_array($extaxresult))
		{
			$taxcodeof=$taxresultrow["strTaxCode"];
			$Percentage=$taxresultrow["dblPercentage"];
			/*$taxcodeof=$taxresultrow["strTaxCode"];
			$taxcodeof=$taxresultrow["strTaxCode"];
			$taxcodeof=$taxresultrow["strTaxCode"];*/
			//$amount=$umoqty1*50/100;
			$amount=$umoqty1*$taxresultrow["dblPercentage"];
			$strtaxing="INSERT INTO excusdectax 
						(strInvoiceNo, 
						strHScode, 
						strTaxCode, 
						intPosition, 
						dblTaxBase, 
						dblRate, 
						dblAmount, 
						intMP, 
						RecordType)
						VALUES
						('$invoiceno', 
						'$hs', 
						'$taxcodeof', 
						'$pos', 
						'$umoqty1', 
						'$Percentage', 
						'$amount', 
						'1', 
						'0');";
			$strtaxingresult=$db->RunQuery($strtaxing);
			//die($strtaxing ."  ".$pos);
		}
	//die($TaxCode);
	
	}	
		
}
if ($request=='deleteData')
{	
	$invoiceno=$_GET["invoiceno"];
	$item=$_GET["item"];
	
	$sqlDelete="DELETE FROM bookingdetail WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = '$item' ;";
	$resultDelete=$db->RunQuery($sqlDelete);
	
	if ($resultDelete)
	{	
		echo "Sucessfully deleted";
		$strdelfirst="DELETE FROM excusdectax 
					WHERE
					strInvoiceNo = '$invoiceno' AND intPosition='$item';";
		$resultstrdelfirst=$db->RunQuery($strdelfirst);
		
	}

}

if ($request=='save_po_wise_ci')
{	
	$InvoiceNo	=$_GET["InvoiceNo"];
	$amount		=$_GET["amount"];
	$currency	=$_GET["currency"];
	$catno		=$_GET["catno"];
	$desc		=$_GET["desc"];
	$hs			=$_GET["hs"];
	$isd		=$_GET["isd"];
	$po			=$_GET["po"];
	$price		=$_GET["price"];
	$qty		=$_GET["qty"];
	$unt		=$_GET["unt"];
	
	$str="insert into commercialinvoice 
				(strInvoiceNo, 
				strPONO, 
				strISDNo,
				strHScode,
				strCatNo, 
				strDesc, 
				dblQty, 
				strUnit, 
				dblPrice, 
				strCurrency, 
				dblAmount
				)
				values
				('$InvoiceNo', 
				'$po', 
				'$isd', 
				'$hs',
				'$catno',
				'$desc', 
				'$qty', 
				'$unt', 
				'$price', 
				'$currency', 
				'$amount'
				);";
	$result=$db->RunQuery($str);
	
	if ($result)
	{	
		echo "saved";
				
	}

}

if ($request=='retrv_po_wise_ci')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$InvoiceNo=$_GET["InvoiceNo"];
	$str="select 	
				intCIserial, 
				strInvoiceNo, 
				strPONO, 
				strISDNo, 
				strHScode,
				strCatNo, 
				strDesc, 
				dblQty, 
				strUnit, 
				dblPrice, 
				strCurrency, 
				dblAmount	 
				from 
				commercialinvoice
				where 
				strInvoiceNo='$InvoiceNo'";
	$result=$db->RunQuery($str);
		
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($row=mysql_fetch_array($result))
	{		
			$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<PONO><![CDATA[" . $row["strPONO"]  . "]]></PONO>\n";
			$XMLString .= "<ISDNo><![CDATA[" . $row["strISDNo"]  . "]]></ISDNo>\n";
			$XMLString .= "<HScode><![CDATA[" . $row["strHScode"]  . "]]></HScode>\n";
			$XMLString .= "<Desc><![CDATA[" . $row["strDesc"]  . "]]></Desc>\n";
			$XMLString .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";
			$XMLString .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
			$XMLString .= "<Price><![CDATA[" . $row["dblPrice"]  . "]]></Price>\n";
			$XMLString .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
			$XMLString .= "<Amount><![CDATA[" . $row["dblAmount"]  . "]]></Amount>\n";	
			$XMLString .= "<CatNo><![CDATA[" . $row["strCatNo"]  . "]]></CatNo>\n";			
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='delete_po_wise_ci')
{	
	$InvoiceNo=$_GET["InvoiceNo"];
	$str="delete from commercialinvoice 
	where
	strInvoiceNo = '$InvoiceNo'";
	$result=$db->RunQuery($str);
	echo($str);
}
/*
if($request=='rowupdater')
{

$invoiceno=$_GET["invoiceno"];
	$item=$_GET["item"];
	$newitem=$_GET["new"];



$sqlRowUp="
UPDATE bookingdetail 
	SET
	
	intItemNo = '$newitem'  
	
	WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = '$item' ";
	
	$resultRowUp=$db->RunQuery($sqlRowUp);
	
	if ($resultRowUp)		
		echo "Rowupdatd";


}
*/
?>	
	