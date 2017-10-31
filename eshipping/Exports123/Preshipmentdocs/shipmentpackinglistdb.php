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
	$str="select distinct strSize,dblNet from style_ratio_plugin where strStyle='$style' ";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		//$xml_string .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
		$xml_string .= "<Size><![CDATA[" . $row["strSize"]   . "]]></Size>\n";	
		$xml_string .= "<Net><![CDATA[" . $row["dblNet"]   . "]]></Net>\n";
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if ($request=='save_pl_size_index')
{
	$size		=$_GET['size'];
	$Style		=$_GET['Style'];
	$colm_index	=$_GET['colm_index'];
	$plno		=$_GET['plno'];
	$style_copy ="select 	strStyle, 
	strSize, 
	strDesc, 
	dblGross, 
	dblNet, 
	dblNetNet, 
	dblPcs
	from 
	style_ratio_plugin 
	where strStyle='$Style' and strSize='$size' ";
	$result_copy=$db->RunQuery($style_copy);
	$row_copy_style=mysql_fetch_array($result_copy);
	$pcs=$row_copy_style["dblPcs"];
	$pcs=($pcs==""?0:$pcs);
	$gross=$row_copy_style["dblGross"];
	$gross=($gross==""?0:$gross);
	$net=$row_copy_style["dblNet"];
	$net=($net==""?0:$net);
	$netnet=$row_copy_style["dblNetNet"];
	$netnet=($netnet==""?0:$netnet);
	
	
		
	$str="insert into shipmentplsizeindex 
				(strPLNo, 
				intColumnNo, 
				strSize, 
				dblPcs, 
				dblGross, 
				dblNet, 
				dblNetNet
				)
				values
				('$plno', 
				'$colm_index', 
				'$size', 
				'$pcs', 
				'$gross', 
				'$net', 
				'$netnet');";
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
	$tag_no			=$_GET['tag_no'];
	$shade			=$_GET['shade'];
	$color			=$_GET['color'];
	$lengths		=$_GET['lengths'];
	$pcs			=$_GET['pcs'];
	$ctns			=$_GET['ctns'];
	$qty_pcs		=$_GET['qty_pcs'];
	$qty_doz		=$_GET['qty_doz'];
	$gross			=($_GET['gross']==""?0:$_GET['gross']);
	$net			=($_GET['net']==""?0:$_GET['net']);
	$net_net		=($_GET['net_net']==""?0:$_GET['net_net']);
	$tot_gross		=$_GET['tot_gross'];
	$tot_net		=$_GET['tot_net'];
	$tot_net_net	=$_GET['tot_net_net'];
	$CTNWeight		=($_GET['CTNWeight']==""?'null':$_GET['CTNWeight']);
	$str="insert into shipmentpldetail 
					(strPLNo, 
					intRowNo, 
					dblPLNoFrom, 
					dblPlNoTo,
					dblCTNWeight, 
					strTagNo,
					strShade, 
					strColor, 
					strLength, 
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
					 $CTNWeight, 
					'$tag_no',
					'$shade',
					'$color',
					'$lengths', 
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
	else
		echo "failed";
}

if ($request=='save_pl_header')
{
	$PLNo					=$_GET['PLNo'];
	if($PLNo=="")
	{	
		$str_plno			="select dblPLno from  syscontrol";
		$result_plno		=$db->RunQuery($str_plno);
		$holder_plno		=mysql_fetch_array($result_plno);
		$str_plno_update	="update syscontrol set dblPLno=dblPLno+1";
		$result_plno_update	=$db->RunQuery($str_plno_update);
		$PLNo				=$holder_plno['dblPLno'];
		
	}	
	$str_del_header			="delete from shipmentplheader where strPLNo='$PLNo'";
	$result_del_header		=$db->RunQuery($str_del_header);
	$str_del_index			="delete from shipmentplsizeindex where strPLNo='$PLNo'";
	$result_del_index		=$db->RunQuery($str_del_index);
	$str_del_detail			="delete from shipmentpldetail where strPLNo='$PLNo'";
	$result_del_detail		=$db->RunQuery($str_del_detail);
	$str_del_subdetail		="delete from shipmentplsubdetail where strPLNo='$PLNo'";
	$result_del_subdetail	=$db->RunQuery($str_del_subdetail);
	
	
	
	$Article		=$_GET['Article'];
	$CBM			=$_GET['CBM'];
	$Color			=$_GET['Color'];
	$DO				=$_GET['DO'];
	$Fabric			=$_GET['Fabric'];
	$Factory		=$_GET['Factory'];
	$Item			=$_GET['Item'];
	$ItemNo			=$_GET['ItemNo'];
	$Lable			=$_GET['Lable'];
	$ManufactOrderNo=$_GET['ManufactOrderNo'];
	$ManufactStyle	=$_GET['ManufactStyle'];
	$PrePackCode	=$_GET['PrePackCode'];
	$ProductCode	=$_GET['ProductCode'];
	$SailingDate	=$_GET['SailingDate'];
	$SortingType	=$_GET['SortingType'];
	$Style			=$_GET['Style'];	
	$Unit			=$_GET['Unit'];
	$WashCode		=$_GET['WashCode'];
	$ctnsvolume		=$_GET['ctnsvolume'];
	$division		=$_GET['division'];
	$isdno			=$_GET['isdno'];
	$material		=$_GET['material'];
	$season			=$_GET['season'];
	$container		=$_GET['container'];
	$trnsmode		=$_GET['trnsmode'];
	$destination	=$_GET['destination'];
	$dc				=$_GET['dc'];
	
	
	$str		="insert into shipmentplheader 
	(strPLNo, 
	strSailingDate, 
	strStyle, 
	strProductCode, 
	strMaterial, 
	strFabric, 
	strLable, 
	strColor, 
	strISDno, 
	strPrePackCode, 
	strSeason, 
	strDivision, 
	strCTNsvolume, 
	strWashCode, 
	strArticle, 
	strCBM, 
	strItemNo, 
	strItem, 
	strManufactOrderNo, 
	strManufactStyle, 
	strDO, 
	strSortingType, 
	strFactory, 
	strUnit, 
	strContainer, 
	strTrnsportMode, 
	strDestination, 
	strDc
	)
	values
	('$PLNo', 
	'$SailingDate', 
	'$Style', 
	'$ProductCode', 
	'$material', 
	'$Fabric', 
	'$Lable', 
	'$Color', 
	'$isdno', 
	'$PrePackCode', 
	'$season', 
	'$division', 
	'$ctnsvolume', 
	'$WashCode', 
	'$Article', 
	'$CBM', 
	'$ItemNo', 
	'$Item', 
	'$ManufactOrderNo', 
	'$ManufactStyle', 
	'$DO', 
	'$SortingType', 
	'$Factory', 
	'$Unit', 
	'$container', 
	'$trnsmode', 
	'$destination', 
	'$dc'
	);";
	$result=$db->RunQuery($str);
	if($result)
		echo $PLNo;
	else 
		echo "fail";
}

if ($request=='get_pl_header_data')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno=$_GET['plno'];
	$str="select 	strPLNo, 
					strSailingDate, 
					strStyle, 
					strProductCode, 
					strMaterial, 
					strFabric, 
					strLable, 
					strColor, 
					strISDno, 
					strPrePackCode, 
					strSeason, 
					strDivision, 
					strCTNsvolume, 
					strWashCode, 
					strArticle, 
					strCBM, 
					strItemNo, 
					strItem, 
					strManufactOrderNo, 
					strManufactStyle, 
					strDO, 
					strSortingType, 
					strFactory, 
					strUnit, 
					strContainer, 
					strTrnsportMode, 
					strDestination, 
					strDc
					from 
					shipmentplheader 
					where strPLNo='$plno'";
	$result=$db->RunQuery($str);
	$xml_string="<data>\n";
	$xml_string.="<pldata>\n";
	while($row=mysql_fetch_array($result))
	{
		$ctnsize_arr =explode("X",$row["strCTNsvolume"]);
		$xml_string .= "<PLNo><![CDATA[" . $row["strPLNo"]  . "]]></PLNo>\n";
		$xml_string .= "<SailingDate><![CDATA[" . $row["strSailingDate"]  . "]]></SailingDate>\n";
		$xml_string .= "<Style><![CDATA[" . $row["strStyle"]   . "]]></Style>\n";
		$xml_string .= "<ProductCode><![CDATA[" . $row["strProductCode"]   . "]]></ProductCode>\n";
		$xml_string .= "<Material><![CDATA[" . $row["strMaterial"]   . "]]></Material>\n";
		$xml_string .= "<Fabric><![CDATA[" . $row["strFabric"]   . "]]></Fabric>\n";
		$xml_string .= "<Lable><![CDATA[" . $row["strLable"]   . "]]></Lable>\n";
		$xml_string .= "<Color><![CDATA[" . $row["strColor"]   . "]]></Color>\n";
		$xml_string .= "<ISDno><![CDATA[" . $row["strISDno"]   . "]]></ISDno>\n";
		$xml_string .= "<PrePackCode><![CDATA[" . $row["strPrePackCode"]   . "]]></PrePackCode>\n";
		$xml_string .= "<Season><![CDATA[" . $row["strSeason"]   . "]]></Season>\n";
		$xml_string .= "<Division><![CDATA[" . $row["strDivision"]   . "]]></Division>\n";
		$xml_string .= "<CTNsvolume><![CDATA[" . $row["strCTNsvolume"]   . "]]></CTNsvolume>\n";
		$xml_string .= "<WashCode><![CDATA[" . $row["strWashCode"]   . "]]></WashCode>\n";
		$xml_string .= "<Article><![CDATA[" . $row["strArticle"]   . "]]></Article>\n";
		$xml_string .= "<CBM><![CDATA[" . $row["strCBM"]   . "]]></CBM>\n";
		$xml_string .= "<ItemNo><![CDATA[" . $row["strItemNo"]   . "]]></ItemNo>\n";
		$xml_string .= "<Item><![CDATA[" . $row["strItem"]   . "]]></Item>\n";
		$xml_string .= "<ManufactOrderNo><![CDATA[" . $row["strManufactOrderNo"]   . "]]></ManufactOrderNo>\n";	
		$xml_string .= "<ManufactStyle><![CDATA[" . $row["strManufactStyle"]   . "]]></ManufactStyle>\n";
		$xml_string .= "<DO><![CDATA[" . $row["strDO"]   . "]]></DO>\n";	
		$xml_string .= "<SortingType><![CDATA[" . $row["strSortingType"]   . "]]></SortingType>\n";
		$xml_string .= "<Factory><![CDATA[" . $row["strFactory"]   . "]]></Factory>\n";	
		$xml_string .= "<Unit><![CDATA[" . $row["strUnit"]   . "]]></Unit>\n";
		$xml_string .= "<ctn_length><![CDATA[" . $ctnsize_arr[0]   . "]]></ctn_length>\n";
		$xml_string .= "<ctn_height><![CDATA[" . $ctnsize_arr[1]   . "]]></ctn_height>\n";
		$xml_string .= "<ctn_width><![CDATA[" . $ctnsize_arr[2]   . "]]></ctn_width>\n";
		$xml_string .= "<Container><![CDATA[" . $row["strContainer"]   . "]]></Container>\n";
		$xml_string .= "<TrnsportMode><![CDATA[" . $row["strTrnsportMode"]   . "]]></TrnsportMode>\n";
		$xml_string .= "<Destination><![CDATA[" . $row["strDestination"]   . "]]></Destination>\n";
		$xml_string .= "<Dc><![CDATA[" . $row["strDc"]   . "]]></Dc>\n";
		
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
					strSize,
					dblNet	 
					from 
					shipmentplsizeindex 
					where strPLNo='$plno'
					order by intColumnNo";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<Size><![CDATA[" . $row["strSize"]   . "]]></Size>\n";	
		$xml_string .= "<Net><![CDATA[" . $row["dblNet"]   . "]]></Net>\n";	
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if ($request=='load_saved_pl_data')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno=$_GET['plno'];
	$str="select 	*			 
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
		$xml_string .= "<CTNWeight><![CDATA[" . $row["dblCTNWeight"]   . "]]></CTNWeight>\n";
		$xml_string .= "<TagNo><![CDATA[" . $row["strTagNo"]   . "]]></TagNo>\n";		
		$xml_string .= "<Shade><![CDATA[" . $row["strShade"]   . "]]></Shade>\n";	
		$xml_string .= "<Color><![CDATA[" . $row["strColor"]   . "]]></Color>\n";	
		$xml_string .= "<Length><![CDATA[" . $row["strLength"]   . "]]></Length>\n";	
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

if ($request=='set_value_subdetails')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno=$_GET['plno'];
	$str="select 	strPLNo, 
					intRowNo, 
					intColumnNo, 
					dblPcs					 
					from 
					shipmentplsubdetail 
					where strPLNo='$plno'";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{
		$xml_string .= "<RowNo><![CDATA[" . $row["intRowNo"]   . "]]></RowNo>\n";
		$xml_string .= "<ColumnNo><![CDATA[" . $row["intColumnNo"]   . "]]></ColumnNo>\n";	
		$xml_string .= "<Pcs><![CDATA[" . $row["dblPcs"]   . "]]></Pcs>\n";	
					
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if ($request=='save_pl_format')
{
	$plno		=$_GET['plno'];
	$pl_report	=$_GET['pl_report'];
	
	$str_pl_format			="delete from shipmentplformat where intPLno='$plno'";
	$result_pl_format		=$db->RunQuery($str_pl_format);
	
	$str_save_pl_format		="insert into shipmentplformat 
							(intPLno, 
							strFormat, 
							strDesc
							)
							values
							('$plno', 
							'$pl_report', 
							''
							);";
	$result_save_pl_format	=$db->RunQuery($str_save_pl_format);
	if($result_save_pl_format)
		echo 'saved';
	else
		echo "failed";
}

if ($request=='load_pl_format')
{
	$plno		=$_GET['plno'];
	
	$str_pl_format			="select strFormat from shipmentplformat where intPLno='$plno'";
	$result_pl_format		=$db->RunQuery($str_pl_format);
	while($row=mysql_fetch_array($result_pl_format))
	{
		echo $row['strFormat'];
	}
}
?>