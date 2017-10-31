<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if($request=="get_preshipment_data")
{
		$invoiceno	=$_GET["invoiceno"];
		$xml_string	='<data>';
		$str		="select 	exportrelease.strInvoiceNo, 
					stEntryNo, 
					intShippedQty, 
					dtmDate, 
					strRemarks,
					sum(dblQuantity)as palnnedQuantity 					 
					from 
					invoicedetail  
					left join  exportrelease
					on invoicedetail.strInvoiceNo=exportrelease.strInvoiceNo
					where invoicedetail.strInvoiceNo ='$invoiceno' group by strInvoiceNo					";
		$result		=$db->RunQuery($str);
		while($row=mysql_fetch_array($result))
		{
			
			$release_Date=($row["dtmDate"]==""?date('Y-m-d'):$row["dtmDate"]);
			$release_Date_array	=explode("-",$release_Date);
			$release_Date		=$release_Date_array[2].'/'.$release_Date_array[1].'/'.$release_Date_array[0];
			$xml_string .= "<EntryNo><![CDATA[" . $row["stEntryNo"]   . "]]></EntryNo>\n";
			$xml_string .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]   . "]]></InvoiceNo>\n";
			$xml_string .= "<ShippedQty><![CDATA[" . $row["intShippedQty"]   . "]]></ShippedQty>\n";
			$xml_string .= "<Date><![CDATA[" . $release_Date   . "]]></Date>\n";
			$xml_string .= "<Remarks><![CDATA[" . $row["strRemarks"]   . "]]></Remarks>\n";
			$xml_string .= "<palnnedQuantity><![CDATA[" . $row["palnnedQuantity"]   . "]]></palnnedQuantity>\n";
		}
	$xml_string.='</data>';
	echo $xml_string;
}

if($request=="save_export_release")
{
	$invoiceno	 		=$_GET["invoiceno"];
	$EntryNo	 		=$_GET["EntryNo"];
	$ShippedQty	 		=($_GET["ShippedQty"]==""?'NULL':$_GET["ShippedQty"]);
	$release_Date		=$_GET["release_Date"];
	$release_Date_array	=explode("/",$release_Date);
	$release_Date		=$release_Date_array[2].'-'.$release_Date_array[1].'-'.$release_Date_array[0];
	$Remarks	 		=$_GET["Remarks"];
	
	$str_del		="delete from exportrelease where strInvoiceNo = '$invoiceno' ";
	$result_del		=$db->RunQuery($str_del);
	$str		="insert into exportrelease 
					(strInvoiceNo, 
					stEntryNo, 
					intShippedQty, 
					dtmDate, 
					strRemarks
					)
					values
					('$invoiceno', 
					'$EntryNo', 
					 $ShippedQty, 
					'$release_Date', 
					'$Remarks'
					);";
	$result		=$db->RunQuery($str);
		
	if($result)
		echo"saved";
	else 
	echo $str;
}

?>