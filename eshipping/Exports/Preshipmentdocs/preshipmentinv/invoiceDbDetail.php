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
	strPLNO, 
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
	strFabrication,
	strColor,
	intCBM,
	strSC_No
	FROM 
	invoicedetail 
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
			$XMLString .= "<PL><![CDATA[" . $detailrow["strPLNO"]  . "]]></PL>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow["strColor"]  . "]]></Color>\n";
			$XMLString .= "<CBM><![CDATA[" . $detailrow["intCBM"]  . "]]></CBM>\n";
			$XMLString .= "<strSC_No><![CDATA[" . $detailrow["strSC_No"]  . "]]></strSC_No>\n";
				
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
	$cbm=$_GET["cbm"];
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
	if($ISDNo=="")
	$ISDNo="n/a";
	$fabrication=$_GET["fabrication"];
	$PL=$_GET["PL"];
	$ScNo=$_GET["ScNo"];
	$chkGsp=$_GET["chkGsp"];
	
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
	if ($pos=="" || $pos=="NaN")
		$pos=0;
	if ($cbm=="")
		$cbm=0;
	if ($chkGsp==0)
		$chkGsp=0;
		
	
	
	if ($wut=='update')
	{
	$sqlupdate="UPDATE invoicedetail 
	SET
	strInvoiceNo = '$invoiceno' , 
	strPLNO = '$PL' ,
	strStyleID = '$style' , 
	intCBM = '$cbm' ,
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
	strFabrication='$fabrication',
	strSC_No='$ScNo',
	intChkGsp='$chkGsp'
	WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = $pos";
	
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
	 $sqlinsert="INSERT INTO invoicedetail 
	(strInvoiceNo, 
	strStyleID, 
	intCBM,
	strPLNO,
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
	'$cbm',
	'$PL', 
	$pos, 
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

if ($request=='saveData')
{
	$invoiceno = $_GET["invoiceno"];
	
	
	$bpo=$_GET["bpo"];
	$cbm=$_GET["cbm"];
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
	$qty=$_GET["qty"];
	$Color=$_GET["Color"];
	$category=$_GET["category"];
	$procedurecode=$_GET["procedurecode"];
	$umoqty1=$_GET["umoqty1"];
	$umoqty2=$_GET["umoqty2"];
	$umoqty3=$_GET["umoqty3"];
	$umoUnit1=$_GET["umoUnit1"];
	$umoUnit2=$_GET["umoUnit2"];
	$umoUnit3=$_GET["umoUnit3"];
	$ISDNo=$_GET["ISDNo"];
	$chkGsp=$_GET["chkGsp"];
	$SeNo=$_GET["SeNo"];
	if($ISDNo=="")
	$ISDNo="n/a";
	$fabrication=$_GET["fabrication"];
	$PL=$_GET["PL"];
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
		if ($cbm=="")
		$cbm=0;
		
	$sqlinsert="INSERT INTO invoicedetail 
	(strInvoiceNo, 
	strStyleID, 
	intCBM,
	strPLNO,
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
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
	strFabrication,
	strColor,
	intChkGsp,
	strSC_No
	)
	VALUES
	('$invoiceno', 
	'$style',
	$cbm,
	'$PL', 
	'$bpo', 
	'$dsc', 
	'$qty', 
	'$unitqty', 
	'$unitprice', 
	'$unit', 
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
	'$fabrication',
	'$Color',
	'$chkGsp',
	'$SeNo'
	);";
	 $insertresultsql=$db->RunQuery($sqlinsert);
	if($insertresultsql)
	{
		echo "saved";
	}
}

if ($request=='delData')
{	
	$invoiceno = $_GET["invoiceno"];
	$sqlDelete="DELETE FROM invoicedetail WHERE
	strInvoiceNo = '$invoiceno'";
	$resultDelete=$db->RunQuery($sqlDelete);
	
	/*if ($resultDelete)
	{	
		echo "Sucessfully deleted";
		$strdelfirst="DELETE FROM excusdectax 
					WHERE
					strInvoiceNo = '$invoiceno' AND intPosition='$item';";
		$resultstrdelfirst=$db->RunQuery($strdelfirst);
		
	}
*/
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


if ($request=='getMass')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno		=$_GET["plno"];
	
	 $sqlDetail="select shipmentpldetail.strPLNo,sum(dblQtyPcs) as qty,sum(dblNoofCTNS) as ctns,sum(dblTotGross) as dblGorss, sum(dblTotNet) as dblNet, sum(dblTotNetNet) as dblNetNet,strStyle,strProductCode,strISDno,strItem,strDO,strLable,strUnit,strFabric,strMaterial,strCTNsvolume,strDc
				from shipmentpldetail 
				left join shipmentplheader on shipmentplheader.strPLNo=shipmentpldetail.strPLNo
				where shipmentpldetail.strPLNo='$plno' group by  shipmentpldetail.strPLNo ";
						
	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		
	
			$seight_array=explode("/",color_wise_ctns($plno));	
			$ctns				=$seight_array[0];
			$totgross			=$seight_array[1];
			$totnet				=$seight_array[2];
			$totNetNet			=$seight_array[3];
			
			$vol_arr=explode("X",$detailrow['strCTNsvolume']);
		  	$cbm_fm=round($vol_arr[0]*$vol_arr[1]*$vol_arr[2]*$ctns*.0000164,2);
				
			$isd=($detailrow["strISDno"]==""?$detailrow["strDO"]:$detailrow["strISDno"]);
			
			$Gorss		=($detailrow["strUnit"]=="lbs"?round(($totgross*0.4536),2):round($totgross,2));
			$Net		=($detailrow["strUnit"]=="lbs"?round(($totnet*0.4536),2):round($totnet,2));						
			$NetNet		=($detailrow["strUnit"]=="lbs"?round(($totNetNet*0.4536),2):round($totNetNet,2));
			$XMLString .= "<plno><![CDATA[" . $detailrow["strPLNo"]  . "]]></plno>\n";
			$XMLString .= "<Gorss><![CDATA[" . $Gorss  . "]]></Gorss>\n";
			$XMLString .= "<Net><![CDATA[" . $Net. "]]></Net>\n";
			$XMLString .= "<NetNet><![CDATA[" . $NetNet . "]]></NetNet>\n";	
			$XMLString .= "<ctns><![CDATA[" . $ctns . "]]></ctns>\n";	
			$XMLString .= "<qty><![CDATA[" . $detailrow["qty"] . "]]></qty>\n";	
			$XMLString .= "<PO><![CDATA[" . $detailrow["strStyle"] . "]]></PO>\n";	
			$XMLString .= "<style><![CDATA[" . ($detailrow["strProductCode"]==""?$detailrow["strMaterial"]:$detailrow["strProductCode"]) . "]]></style>\n";
			$XMLString .= "<ISDno><![CDATA[" . $isd . "]]></ISDno>\n";
			$XMLString .= "<Item><![CDATA[" . $detailrow["strItem"] . "]]></Item>\n";
			$XMLString .= "<pllable><![CDATA[" . $detailrow["strLable"] . "]]></pllable>\n";	
			$XMLString .= "<plfabric><![CDATA[" . $detailrow["strFabric"] . "]]></plfabric>\n";	
			$XMLString .= "<Dc><![CDATA[" . $detailrow["strDc"] . "]]></Dc>\n";		
			$XMLString .= "<CBM><![CDATA[" . $cbm_fm . "]]></CBM>\n";				
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

function color_wise_ctns($pl)
{
	global $db;
	$ctns				=0;
	$totgross			=0;
	$totnet				=0;
	$totNetNet			=0;
	$str			="select  dblNoofCTNS ,dblTotGross,dblTotNet,dblTotNetNet from shipmentpldetail where strPLNo='$pl'group by dblPLNoFrom,dblPlNoTo";
	$results		=$db->RunQuery($str);
	while($row=mysql_fetch_array($results))
	{
		$ctns		+=$row['dblNoofCTNS'];
		$totgross	+=$row['dblTotGross'];
		$totnet		+=$row['dblTotNet'];
		$totNetNet	+=$row['dblTotNetNet'];
	}
	
	return $ctns."/".$totgross."/".$totnet."/".$totNetNet;
}


if ($request=='addSizePrice')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno = $_GET["plno"];
	$pono = $_GET["po"];
	
    $sqlDetail1  =  "SELECT shipmentpldetail.strColor,shipmentpldetail.strPLNo,sum(dblQtyPcs) as qty,
	 				 sum(dblNoofCTNS) as ctns,sum(dblTotGross) as dblGorss, sum(dblTotNet) as dblNet, 
					 sum(dblTotNetNet) as dblNetNet,strStyle,strProductCode,strISDno,strItem,strDO,
					 strLable,strFabric,strUnit,strMaterial,strCTNsvolume,strDc,strCBM
					 from shipmentpldetail 
					 left join shipmentplheader on shipmentplheader.strPLNo=shipmentpldetail.strPLNo
					 where shipmentpldetail.strPLNo='$plno' and shipmentpldetail.strColor!='' group by  shipmentpldetail.strColor";
					 
	 $detailResult1 = $db->RunQuery($sqlDetail1);
		
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow1=mysql_fetch_array($detailResult1))
	{		
		$TOTCBM = calCBM($detailrow1['strColor'],$plno);
		
		$sqlDetail2  = "SELECT	orderspecdetails.dblPrice,
								orderspec.strUnit,
								orderspecdetails.dblPrice,
								orderspecdetails.strDescription,
								Sum(orderspecdetails.dblPcs),
								orderspec.strOrder_No,
								orderspecdetails.intOrderId
						FROM 			orderspecdetails
						Inner Join 	    orderspec ON orderspecdetails.intOrderId = orderspec.intOrderId
						WHERE 			orderspec.strOrder_No='$pono'
						group by 		orderspecdetails.dblPrice";
							
						
		$detailResult2 = $db->RunQuery($sqlDetail2);
		
		while($detailrow2=mysql_fetch_array($detailResult2))
		{
			
			//$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow1["strProductCode"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow1["strItem"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $pono  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow1["strItem"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow1["qty"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow2["strUnit"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow2["dblPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow1["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow1["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow1["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow1["dblGorss"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow1["dblNet"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow1["strUnit"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow1["ctns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow1["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow1["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1>0</dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2>0</dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3>0</dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1>0</UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2>0</UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3>0</UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow1["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabrication><![CDATA[" . $detailrow1["strLable"]  . "]]></Fabrication>\n";
			$XMLString .= "<PL><![CDATA[" . $plno  . "]]></PL>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow1["strColor"]  . "]]></Color>\n";
			$XMLString .= "<CBM><![CDATA[" . number_format($TOTCBM,2)  . "]]></CBM>\n";
		}
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

function calCBM($color,$pl)
{
	global $db;
	$CTNCBMTOT = 0;
	//echo $color; echo $pl;
	$sqlDetailCBM  =   "SELECT
						Sum(shipmentpldetail.dblNoofCTNS) AS sumCTN,
						shipmentpldetail.strCTN
						FROM
						shipmentpldetail
						WHERE
						shipmentpldetail.strPLNo =  '$pl' AND
						shipmentpldetail.strColor =  '$color'
						GROUP BY
						shipmentpldetail.strCTN";
			//shipmentpldetail.dblQtyPcs"
			//shipmentpldetail.strCTN"			
	$detailResultCBM = $db->RunQuery($sqlDetailCBM);
		
	while($detailrowCBM=mysql_fetch_array($detailResultCBM))
	{
		$sqlDetailCBMCTN   =   "SELECT
								cartoon.intLength,
								cartoon.intWidth,
								cartoon.intHeight
								FROM
								cartoon
								WHERE
								cartoon.intCartoonId =  ".$detailrowCBM["strCTN"];
								
		$detailResultCBMCTN = $db->RunQuery($sqlDetailCBMCTN);
		$detailrowCBMRow    = mysql_fetch_array($detailResultCBMCTN);
		
		$Length = (float) $detailrowCBMRow["intLength"];
		$Width  = (float) $detailrowCBMRow["intWidth"];
		$Height = (float) $detailrowCBMRow["intHeight"];
		
	    $sumCTN = (float) $detailrowCBM["sumCTN"];
		$CTNCBMTOT += ($Length*$Width*$Height*$sumCTN*0.0000164);
		
		
	}
	//echo $CTNCBMTOT;
	return $CTNCBMTOT;
}


?>	
	