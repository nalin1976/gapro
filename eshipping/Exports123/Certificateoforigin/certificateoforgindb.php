<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];

if($request=='getco')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceno=$_GET["invoiceno"];
	$xmlText="<Data>";
	$xmlText.="<COdata>";
	$sql="select 
		(select strName from customers where strCustomerID=ih.strCompanyID)as company,
		(select strName from buyers where strBuyerID=ih.strBuyerID)as buyers,
		co.strInvoiceNo, 
		co.strCONO, 
		co.intNoOfCartons, 
		co.strVessel, 
		co.strPortOfDischarge, 
		co.strFinalDestination, 
		co.strExportYear, 
		co.strSuplimentaryDetails, 
		co.strMarks,
		co.	strCage2 
		from 
		certificateoforigin co inner join invoiceheader ih on co.strInvoiceNo=ih.strInvoiceNo
		where 
		co.strInvoiceNo='$invoiceno'";
	
	$results=$db->RunQuery($sql);
	if(mysql_num_rows($results)<1)
	{
	
	$sql="select 
		(select strName from customers where strCustomerID=ih.strCompanyID)as company,
		(select strName from buyers where strBuyerID=ih.strBuyerID)as buyers,	
		ih.strInvoiceNo, 
		ih.strCarrier as strVessel, 	
		cdn.strPortOfDischarge as strPortOfDischarge, 	
		cdn.strPlaceOfDelivery as strFinalDestination, 	
		cdn.dblNetWt, 	
		ih.strMarksAndNos as strMarks	 
		from 
		invoiceheader ih left join  cdn cdn on ih.strInvoiceNo=cdn.strInvoiceNo
		where
		ih.strInvoiceNo='$invoiceno'";
	
	$results=$db->RunQuery($sql);
	}
	
	while($r=mysql_fetch_array($results))
	{
		if($r["strExportYear"]=="")
			$r["strExportYear"]=date("Y");
		$xmlText.="<company><![CDATA[" . $r["company"]  . "]]></company>\n";
		$xmlText.="<buyers><![CDATA[" . $r["buyers"]  . "]]></buyers>\n";
		$xmlText.="<Vessel><![CDATA[" . $r["strVessel"]  . "]]></Vessel>\n";
		$xmlText.="<NoOfCartons><![CDATA[" . $r["intNoOfCartons"]  . "]]></NoOfCartons>\n";
		$xmlText.="<Vessel><![CDATA[" . $r["strVessel"]  . "]]></Vessel>\n";
		$xmlText.="<PortOfDischarge><![CDATA[" . $r["strPortOfDischarge"]  . "]]></PortOfDischarge>\n";	
		$xmlText.="<FinalDestination><![CDATA[" . $r["strFinalDestination"]  . "]]></FinalDestination>\n";	
		$xmlText.="<ExportYear><![CDATA[" . $r["strExportYear"]  . "]]></ExportYear>\n";
		$xmlText.="<SuplimentaryDetails><![CDATA[" . $r["strSuplimentaryDetails"]  . "]]></SuplimentaryDetails>\n";	
		$xmlText.="<Marks><![CDATA[" . $r["strMarks"]  . "]]></Marks>\n";
		$xmlText.="<Cage2><![CDATA[" . $r["strCage2"]  . "]]></Cage2>\n";
		$xmlText.="<SuplimentaryDetails><![CDATA[" . $r["strSuplimentaryDetails"]  . "]]></SuplimentaryDetails>\n";					
	
	}
	
	

	$xmlText.="</COdata>";
	$xmlText.="</Data>";
	echo $xmlText;
}

if($request=='saveco')
{
	$invoiceno=$_GET["invoiceno"];
	$Cage2=$_GET["Cage2"];
	$Cartoons=$_GET["Cartoons"];
	$Destination=$_GET["Destination"];
	$MarksnNos=$_GET["MarksnNos"];
	$PortofDischarge=$_GET["PortofDischarge"];
	$Supplimentry=$_GET["Supplimentry"];
	$Vessel=$_GET["Vessel"];
	$Year=$_GET["Year"];
	
	
	
	$strdeletefirst="delete from certificateoforigin where strInvoiceNo = '$invoiceno'; ";
	$delresult=$db->RunQuery($strdeletefirst);
	
	if($delresult)
	{
		$insertstr="insert into certificateoforigin 
										(strInvoiceNo,										
										intNoOfCartons, 
										strVessel, 
										strPortOfDischarge, 
										strFinalDestination, 
										strExportYear, 
										strSuplimentaryDetails, 
										strMarks, 
										strCage2
										)
										values
										('$invoiceno', 
										'$Cartoons', 
										'$Vessel', 
										'$PortofDischarge', 
										'$Destination', 
										'$Year', 
										'$Supplimentry', 
										'$MarksnNos', 
										'$Cage2'
										);";
		$insertresult=$db->RunQuery($insertstr);
		if($insertresult)
		echo"Sucessfully saved.";
		else
		echo"Please try again later.";	
		
	}
	else 
	echo "Sorry! please try agai later.";

}

if($request=='print')
{
		$invoiceno=$_GET["invoiceno"];
		$str="select intItemNo  from invoicedetail id where id.strInvoiceNo='$invoiceno'";
		$results=$db->RunQuery($str);
		$XMLString= "<Data>";
		$XMLString .= "<InvoiceData>";
			while($row=mysql_fetch_array($results))
			{
				$XMLString .= "<ItemNo><![CDATA[" . $row["intItemNo"]  . "]]></ItemNo>\n";
			}
			
		$XMLString .= "</InvoiceData>";
		$XMLString .= "</Data>";
	echo $XMLString;
}
?>