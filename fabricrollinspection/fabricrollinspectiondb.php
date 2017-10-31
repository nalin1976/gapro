<?php
session_start();
	include "../Connector.php";	
	
	header('Content-Type: text/xml'); 
	$CompanyId=$_SESSION["FactoryID"];
	$UserID=$_SESSION["UserID"];	
	$request=$_GET["request"];
	
if ($request=='matlist')
{
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$invoice=$_GET['invoice'];
		
		
		$str="select distinct bgd.intBulkGrnNo,bgd.intMatDetailID, mil.strItemDescription 
		from bulkgrndetails bgd left join matitemlist mil on mil.intItemSerial=bgd.intMatDetailID 
		inner join bulkgrnheader bgh on bgh.intBulkGrnNo=bgd.intBulkGrnNo 
		and bgh.intYear=bgd.intYear 
		where bgh.strInvoiceNo='$invoice'";
		
		$XMLString= "<Data>";
		$XMLString .= "<listz>";
		
		
		$result = $db->RunQuery($str); 
		while($row = mysql_fetch_array($result))
		{	
		$XMLString .= "<MatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></MatDetailID>\n";
		$XMLString .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		}
		
		$XMLString .= "</listz>";
		$XMLString .= "</Data>";
		echo $XMLString;
}
	
if ($request=='colorlist')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoice=$_GET['invoice'];
	$matid=$_GET['matid'];
	
	
	$str="select distinct bgd.strColor
			from bulkgrndetails bgd left join matitemlist mil on mil.intItemSerial=bgd.intMatDetailID 
			inner join bulkgrnheader bgh on bgh.intBulkGrnNo=bgd.intBulkGrnNo and bgh.intYear=bgd.intYear 
			where bgh.strInvoiceNo='$invoice' and bgd.intMatDetailID='$matid'";
	
			$XMLString= "<Data>";
			$XMLString .= "<listz>";
			
			
			$result = $db->RunQuery($str); 
			while($row = mysql_fetch_array($result))
				{	
					$XMLString .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
												
				}
		
	$XMLString .= "</listz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='supplierlist')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoice=$_GET['invoice'];
	
	
	
	$str="select distinct bpoh.strSupplierID, s.strTitle from bulkgrnheader bgh inner join bulkpurchaseorderheader bpoh
on bgh.intBulkPoNo=bpoh.intBulkPoNo and bgh.intBulkPoYear=bpoh.intYear inner join suppliers s
on s.strSupplierID=bpoh.strSupplierID where  bgh.strInvoiceNo='$invoice'";
	
			$XMLString= "<Data>";
			$XMLString .= "<listz>";
			
			
			$result = $db->RunQuery($str); 
			while($row = mysql_fetch_array($result))
				{	
					$XMLString .= "<supplier><![CDATA[" . $row["strTitle"]  . "]]></supplier>\n";
					$XMLString .= "<supplierId><![CDATA[" . $row["strSupplierID"]  . "]]></supplierId>\n";							
				}
		
	$XMLString .= "</listz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}


if ($request=='save_header')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$str_serial="select dblFabricRollSerialNo from syscontrol where intCompanyID='$CompanyId'";
	$result_serial=$db->RunQuery($str_serial); 
	$row_serial=mysql_fetch_array($result_serial);
	$serial_no=$row_serial["dblFabricRollSerialNo"];
	$updater="UPDATE syscontrol SET dblFabricRollSerialNo=dblFabricRollSerialNo+1 WHERE intCompanyID='$CompanyId';";
	$db->executeQuery($updater);
	$year=date('Y');
	$invoice=$_GET['invoice'];
	$matitem=$_GET['matitem'];
	$color=$_GET['color'];
	$supplier=$_GET['supplier'];
	$style=$_GET['style'];
	$Remarks=$_GET['Remarks'];
	$WashType=$_GET['WashType'];
	$date=$_GET['date'];
	$stores=$_GET['stores'];
	$date=$_GET['date'];
	$date_array=explode("/",$date);
	$date=$date_array[2]."-".$date_array[1]."-".$date_array[0];
	
	
	$str="insert into fabricrollheader 
						(intFRollSerialNO, 
						intFRollSerialYear, 
						strSupplierID, 
						intStyleId, 
						strMatDetailID, 
						strColor, 
						strWashType, 
						strInvoiceNo, 
						intStatus, 
						intStoresID, 
						intUserID, 
						dtmDate, 
						strRemarks, 
						intCompanyID
						)
						values
						('$serial_no', 
						'$year', 
						'$supplier', 
						'$style', 
						'$matitem', 
						'$color', 
						'$WashType', 
						'$invoice', 
						'0', 
						'$stores', 
						'$UserID', 
						'$date', 
						'$Remarks', 
						'$CompanyId'
						);";
	
			$XMLString= "<Data>";
			$XMLString .= "<respopnse>";
			
			
			$result = $db->RunQuery($str); 
				
					$XMLString .= "<year><![CDATA[" . $year  . "]]></year>\n";
					$XMLString .= "<serialno><![CDATA[" . $serial_no . "]]></serialno>\n";							
				
		
			$XMLString .= "</respopnse>";
			$XMLString .= "</Data>";
			echo $XMLString;
}

if ($request=='save_detail')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$pattern=$_GET['pattern'];
	$seral=$_GET['seral'];
	$rollnumber=$_GET['rollnumber'];
	$shade=$_GET['shade'];
	$shrink_length=$_GET['shrink_length'];
	$shrink_width=$_GET['shrink_width'];
	$skewness=($_GET['skewness']==""?0:$_GET['skewness']);
	$width=$_GET['width'];	
	$yards=$_GET['yards'];	
	$year=$_GET['year'];
	$elongation=($_GET['elongation']==""?0:$_GET['elongation']);	
	
	$str="insert into fabricrolldetails 
					(intFRollSerialNO, 
					intFRollSerialYear, 
					intRollNo, 
					dblLength, 
					dblWidth, 
					dblShrinkageLength, 
					dblShrinkageWidth,
					strShade, 
					dblQty, 
					dblBalQty, 
					intInspected, 
					intApproved, 
					intRejected, 
					dblPtrn, 
					dblSkewness, 
					dblElongation, 
					intStatus
					)
					values
					('$seral', 
					'$year', 
					'$rollnumber', 
					'$yards', 
					'$width', 
					'$shrink_length', 
					'$shrink_width',
					'$shade', 
					'0', 
					'0', 
					'1', 
					'1', 
					'0', 
					'$pattern', 
					'$skewness', 
					'$elongation', 
					'0'
					);
				";
	
			$XMLString= "<Data>";
			$XMLString .= "<respopnse>";
			
			
			$result = $db->RunQuery($str); 
				
					
					$XMLString .= "<serialno><![CDATA[".$str."]></serialno>\n";							
				
		
			$XMLString .= "</respopnse>";
			$XMLString .= "</Data>";
			echo $XMLString;
}


?>