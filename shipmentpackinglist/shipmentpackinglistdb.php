<?php
session_start();
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='load_pl_grid')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	$str="select 
			distinct intStyleId,strBuyerPONO,strSize 
			from styleratio
			where 
			intStyleId='$style' order by strSize";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$xml_string .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
		$xml_string .= "<Size><![CDATA[" . $row["strSize"]   . "]]></Size>\n";	
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if ($request=='save_pl_size_index')
{
	$size		=$_GET['size'];
	$colm_index	=$_GET['colm_index'];
	$plno		=$_GET['plno'];
	$str="insert into shipmentplsizeindex 
				(strPLNo, 
				intColumnNo, 
				strSize	)
				values	
				('$plno', 
				'$colm_index', 
				'$size'	);";
	$result=$db->RunQuery($str);
	if($result)
		echo 'saved';
}

if ($request=='save_pl_subdetails')
{
	$pcs		=$_GET['pcs'];
	$colm_index	=$_GET['colm_index'];
	$plno		=$_GET['plno'];
	$row_index	=$_GET['row_index'];
	$str		="insert into shipmentplsubdetail 
				(strPLNo, 
				intRowNo, 
				intColumnNo, 
				dblPcs)
				values
				('$plno', 
				'$row_index', 
				'$colm_index', 
				'$pcs');";
	$result		=$db->RunQuery($str);
	if($result)
		echo 'saved';
}

if ($request=='save_pl_details')
{
	$plno			=$_GET['plno'];
	$row_index		=$_GET['row_index'];
	$ctns_no_from	=$_GET['ctns_no_from'];
	$ctns_no_to		=$_GET['ctns_no_to'];
	$color			=$_GET['color'];
	$pcs			=$_GET['pcs'];
	$ctns			=$_GET['ctns'];
	$qty_pcs		=$_GET['qty_pcs'];
	$qty_doz		=$_GET['qty_doz'];
	$gross			=$_GET['gross'];
	$net			=$_GET['net'];
	$net_net		=$_GET['net_net'];
	$tot_gross		=$_GET['tot_gross'];
	$tot_net		=$_GET['tot_net'];
	$tot_net_net	=$_GET['tot_net_net'];
	$str="insert into shipmentpldetail 
					(strPLNo, 
					intRowNo, 
					dblPLNoFrom, 
					dblPlNoTo, 
					strColor, 
					dblNoofPCZ, 
					dblNoofCTNS, 
					dblQtyPcs, 
					dblQtyDoz, 
					dblGorss, 
					dblNet, 
					dblNetNet, 
					dblTotGross, 
					dblTotNet, 
					dblTotNetNet
					)
					values
					('$plno', 
					'$row_index', 
					'$ctns_no_from', 
					'$ctns_no_to', 
					'$color', 
					'$pcs', 
					'$ctns', 
					'$qty_pcs', 
					'$qty_doz', 
					'$gross', 
					'$net', 
					'$net_net', 
					'$tot_gross', 
					'$tot_net', 
					'$tot_net_net'
					);";
	$result		=$db->RunQuery($str);
	if($result)
		echo 'saved';
}

if ($request=='save_pl_header')
{
	$PLNo					=$_GET['PLNo'];
	$Factory				=$_GET['Factory'];
	$Style					=$_GET['Style'];
	$CTNS					=$_GET['CTNS'];
	$ManufactOrderNo		=$_GET['ManufactOrderNo'];
	$ManufactStyle			=$_GET['ManufactStyle'];
	$InvoiceNo				=$_GET['InvoiceNo'];
	$ProductCode			=$_GET['ProductCode'];
	$Fabric					=$_GET['Fabric'];
	$Lable					=$_GET['Lable'];
	$TotalQty				=$_GET['TotalQty'];
	$Vessel					=$_GET['Vessel'];
	$SailingDate			=$_GET['SailingDate'];
	$SailingDate			=date("Y-m-d");
	$OrginCountry			=$_GET['OrginCountry'];
	$Container				=$_GET['Container'];
	$Seal					=$_GET['Seal'];
	$BL						=$_GET['BL'];
	$Gross					=$_GET['Gross'];
	$Net					=$_GET['Net'];
	$TotalShipQty			=$_GET['TotalShipQty'];
	$Cartoon				=$_GET['Cartoon'];
	$LCNO					=$_GET['LCNO'];
	$Bank					=$_GET['Bank'];
	$SortingType			=$_GET['SortingType'];
	$PrePackCode			=$_GET['PrePackCode'];
	$WashCode				=$_GET['WashCode'];
	$Color					=$_GET['Color'];
	$Article				=$_GET['Article'];
	
	$str		="insert into shipmentplheader 
							(strPLNo, 
							strFactory, 
							strStyle, 
							strCTNS, 
							strManufactOrderNo, 
							strManufactStyle, 
							strInvoiceNo, 
							strProductCode, 
							strFabric, 
							strLable, 
							dblTotalQty, 
							strVessel, 
							dtmSailingDate, 
							strOrginCountry, 
							strContainer, 
							strSeal, 
							strBL, 
							strGross, 
							strNet, 
							dblTotalShipQty, 
							strCartoon, 
							strLCNO, 
							strBank, 
							strSortingType, 
							strPrePackCode, 
							strWashCode, 
							strColor, 
							strArticle
							)
							values
							('$PLNo', 
							'$Factory', 
							'$Style', 
							'$CTNS', 
							'$ManufactOrderNo', 
							'$ManufactStyle', 
							'$InvoiceNo', 
							'$ProductCode', 
							'$Fabric', 
							'$Lable', 
							'$TotalQty', 
							'$Vessel', 
							'$SailingDate', 
							'$OrginCountry', 
							'$Container', 
							'$Seal', 
							'$BL', 
							'$Gross', 
							'$Net', 
							'$TotalShipQty', 
							'$Cartoon', 
							'$LCNO', 
							'$Bank', 
							'$SortingType', 
							'$PrePackCode', 
							'$WashCode', 
							'$Color', 
							'$Article');";
	$result=$db->RunQuery($str);
	if($result)
		echo 'saved';
}

if ($request=='get_pl_header_data')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno=$_GET['plno'];
	$str="select 	strPLNo, 
					strFactory, 
					strStyle, 
					strCTNS, 
					strManufactOrderNo, 
					strManufactStyle, 
					strInvoiceNo, 
					strProductCode, 
					strFabric, 
					strLable, 
					dblTotalQty, 
					strVessel, 
					dtmSailingDate, 
					strOrginCountry, 
					strContainer, 
					strSeal, 
					strBL, 
					strGross, 
					strNet, 
					dblTotalShipQty, 
					strCartoon, 
					strLCNO, 
					strBank, 
					strSortingType, 
					strPrePackCode, 
					strWashCode, 
					strColor, 
					strArticle
					from 
					shipmentplheader 
					where strPLNo='$plno'";
	$result=$db->RunQuery($str);
	$xml_string="<data>\n";
	$xml_string.="<pldata>\n";
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<PLNo><![CDATA[" . $row["strPLNo"]  . "]]></PLNo>\n";
		$xml_string .= "<Factory><![CDATA[" . $row["strFactory"]  . "]]></Factory>\n";
		$xml_string .= "<Style><![CDATA[" . $row["strStyle"]   . "]]></Style>\n";
		$xml_string .= "<CTNS><![CDATA[" . $row["strCTNS"]   . "]]></CTNS>\n";
		$xml_string .= "<ManufactOrderNo><![CDATA[" . $row["strManufactOrderNo"]   . "]]></ManufactOrderNo>\n";
		$xml_string .= "<ManufactStyle><![CDATA[" . $row["strManufactStyle"]   . "]]></ManufactStyle>\n";
		$xml_string .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]   . "]]></InvoiceNo>\n";
		$xml_string .= "<ProductCode><![CDATA[" . $row["strProductCode"]   . "]]></ProductCode>\n";
		$xml_string .= "<Fabric><![CDATA[" . $row["strFabric"]   . "]]></Fabric>\n";
		$xml_string .= "<Lable><![CDATA[" . $row["strLable"]   . "]]></Lable>\n";
		$xml_string .= "<TotalQty><![CDATA[" . $row["dblTotalQty"]   . "]]></TotalQty>\n";
		$xml_string .= "<Vessel><![CDATA[" . $row["strVessel"]   . "]]></Vessel>\n";
		$xml_string .= "<SailingDate><![CDATA[" . $row["dtmSailingDate"]   . "]]></SailingDate>\n";
		$xml_string .= "<OrginCountry><![CDATA[" . $row["strOrginCountry"]   . "]]></OrginCountry>\n";
		$xml_string .= "<Container><![CDATA[" . $row["strContainer"]   . "]]></Container>\n";
		$xml_string .= "<Seal><![CDATA[" . $row["strSeal"]   . "]]></Seal>\n";
		$xml_string .= "<BL><![CDATA[" . $row["strBL"]   . "]]></BL>\n";
		$xml_string .= "<Gross><![CDATA[" . $row["strGross"]   . "]]></Gross>\n";
		$xml_string .= "<Net><![CDATA[" . $row["strNet"]   . "]]></Net>\n";	
		$xml_string .= "<TotalShipQty><![CDATA[" . $row["dblTotalShipQty"]   . "]]></TotalShipQty>\n";
		$xml_string .= "<Cartoon><![CDATA[" . $row["strCartoon"]   . "]]></Cartoon>\n";	
		$xml_string .= "<LCNO><![CDATA[" . $row["strLCNO"]   . "]]></LCNO>\n";
		$xml_string .= "<Bank><![CDATA[" . $row["strBank"]   . "]]></Bank>\n";	
		$xml_string .= "<SortingType><![CDATA[" . $row["strSortingType"]   . "]]></SortingType>\n";
		$xml_string .= "<PrePackCode><![CDATA[" . $row["strPrePackCode"]   . "]]></PrePackCode>\n";	
		$xml_string .= "<WashCode><![CDATA[" . $row["strWashCode"]   . "]]></WashCode>\n";
		$xml_string .= "<Color><![CDATA[" . $row["strColor"]   . "]]></Color>\n";	
		$xml_string .= "<Article><![CDATA[" . $row["strArticle"]   . "]]></Article>\n";
	}  
	$xml_string.="</pldata>\n";
	$xml_string.="</data>";
	echo $xml_string;
}

if ($request=='load_saved_pl_details')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno=$_GET['plno'];
	$str="select 	strPLNo, 
					intColumnNo, 
					strSize	 
					from 
					shipmentplsizeindex 
					where strPLNo='$plno'
					order by intColumnNo";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<Size><![CDATA[" . $row["strSize"]   . "]]></Size>\n";	
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if ($request=='load_saved_pl_data')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno=$_GET['plno'];
	$str="select 	strPLNo, 
					intRowNo, 
					dblPLNoFrom, 
					dblPlNoTo, 
					strColor, 
					dblNoofPCZ, 
					dblNoofCTNS, 
					dblQtyPcs, 
					dblQtyDoz, 
					dblGorss, 
					dblNet, 
					dblNetNet, 
					dblTotGross, 
					dblTotNet, 
					dblTotNetNet					 
					from 
					shipmentpldetail 
					where strPLNo='$plno'";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<RowNo><![CDATA[" . $row["intRowNo"]   . "]]></RowNo>\n";
		$xml_string .= "<PLNoFrom><![CDATA[" . $row["dblPLNoFrom"]   . "]]></PLNoFrom>\n";	
		$xml_string .= "<PlNoTo><![CDATA[" . $row["dblPlNoTo"]   . "]]></PlNoTo>\n";	
		$xml_string .= "<Color><![CDATA[" . $row["strColor"]   . "]]></Color>\n";	
		$xml_string .= "<NoofPCZ><![CDATA[" . $row["dblNoofPCZ"]   . "]]></NoofPCZ>\n";	
		$xml_string .= "<NoofCTNS><![CDATA[" . $row["dblNoofCTNS"]   . "]]></NoofCTNS>\n";	
		$xml_string .= "<QtyPcs><![CDATA[" . $row["dblQtyPcs"]   . "]]></QtyPcs>\n";	
		$xml_string .= "<QtyDoz><![CDATA[" . $row["dblQtyDoz"]   . "]]></QtyDoz>\n";	
		$xml_string .= "<Gorss><![CDATA[" . $row["dblGorss"]   . "]]></Gorss>\n";	
		$xml_string .= "<Net><![CDATA[" . $row["dblNet"]   . "]]></Net>\n";	
		$xml_string .= "<NetNet><![CDATA[" . $row["dblNetNet"]   . "]]></NetNet>\n";	
		$xml_string .= "<TotGross><![CDATA[" . $row["dblTotGross"]   . "]]></TotGross>\n";	
		$xml_string .= "<TotNet><![CDATA[" . $row["dblTotNet"]   . "]]></TotNet>\n";	
		$xml_string .= "<TotNetNet><![CDATA[" . $row["dblTotNetNet"]   . "]]></TotNetNet>\n";	
			
	} 
	$xml_string.='</data>';
	echo $xml_string;
}


?>