<?php
	session_start();
	$backwardseperator = "../../";
	include "$backwardseperator".''."Connector.php";
	header('Content-Type: text/xml'); 	

	$request=$_GET["request"];
	$des=$_GET["des"];	
	//die("PASS");

	if ($request=="load_pl_grid")
		{
			
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			$des=$_GET["des"];
			$datefrom=$_GET["datefrom"];
			$dateto=$_GET["dateto"];
			
	
			$sql="SELECT commercial_invoice_header.strInvoiceNo,commercial_invoice_detail.strISDno,SUBSTRING(commercial_invoice_header.dtmInvoiceDate,1,10)AS dtmInvoiceDate,commercial_invoice_header.strCarrier,commercial_invoice_header.strVoyegeNo 
		FROM commercial_invoice_header,commercial_invoice_detail WHERE commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo ";
		
		if($des!="")
		{
			$sql.=" AND commercial_invoice_header.strCarrier='$des'";
		}
		
		if($datefrom!="" && $dateto!="")
		{
			$sql.="  AND commercial_invoice_header.dtmInvoiceDate BETWEEN '$datefrom' AND '$dateto' ";
		}
		
			$sql.="GROUP BY commercial_invoice_detail.strInvoiceNo ;";
			
			$result = $db->RunQuery($sql);
			$xml_string='<data>';
		
		while($row=mysql_fetch_array($result))
			{	
				$strVoyegeNo 	 = ($row["strVoyegeNo"]==""?'n/a':$row["strVoyegeNo"]);	
				$strISDno		 = ($row["strISDno"]==""?'n/a':$row["strISDno"]);
				$dtmInvoiceDate	 = ($row["dtmInvoiceDate"]==""?'n/a':$row["dtmInvoiceDate"]);
				$strCarrier	 	 = ($row["strCarrier"]==""?'n/a':$row["strCarrier"]);
				
				$xml_string .= "<INVNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></INVNo>\n";
				$xml_string .= "<ISD><![CDATA[" . $strISDno   . "]]></ISD>\n";	
				$xml_string .= "<DATE><![CDATA[" . $dtmInvoiceDate   . "]]></DATE>\n";	
				$xml_string .= "<VESSEL><![CDATA[" . $strCarrier   . "]]></VESSEL>\n";	
				$xml_string .= "<VOYAGE><![CDATA[" . $strVoyegeNo   . "]]></VOYAGE>\n";
				
			} 
		$xml_string.='</data>';
		echo $xml_string;
		
		
		}
	
	
/*if ($request=="load_pl_grid2")	
	{
		
		$sql="SELECT commercial_invoice_header.strInvoiceNo,commercial_invoice_detail.strISDno,SUBSTRING(commercial_invoice_header.dtmInvoiceDate,1,10)AS dtmInvoiceDate,commercial_invoice_header.strCarrier,commercial_invoice_header.strVoyegeNo 
		FROM commercial_invoice_header,commercial_invoice_detail
		WHERE commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo AND 
		commercial_invoice_header.strFinalDest='$des'
		GROUP BY commercial_invoice_header.strInvoiceNo,commercial_invoice_detail.strISDno,dtmInvoiceDate,commercial_invoice_header.strCarrier,commercial_invoice_header.strVoyegeNo
		ORDER BY dtmInvoiceDate ;";
		
		$result = $db->RunQuery($sql);
		$xml_string='<data>';
		
		while($row=mysql_fetch_array($result))
			{	
				$strVoyegeNo 	 = ($row["strVoyegeNo"]==""?'n/a':$row["strVoyegeNo"]);	
				$strISDno		 = ($row["strISDno"]==""?'n/a':$row["strISDno"]);
				$dtmInvoiceDate	 = ($row["dtmInvoiceDate"]==""?'n/a':$row["dtmInvoiceDate"]);
				$strCarrier	 	 = ($row["strCarrier"]==""?'n/a':$row["strCarrier"]);
				
				$xml_string .= "<INVNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></INVNo>\n";
				$xml_string .= "<ISD><![CDATA[" . $strISDno   . "]]></ISD>\n";	
				$xml_string .= "<DATE><![CDATA[" . $dtmInvoiceDate   . "]]></DATE>\n";	
				$xml_string .= "<VESSEL><![CDATA[" . $strCarrier   . "]]></VESSEL>\n";	
				$xml_string .= "<VOYAGE><![CDATA[" . $strVoyegeNo   . "]]></VOYAGE>\n";
				} 
		$xml_string.='</data>';
		echo $xml_string;
		
	}*/

if ($request=="save_header")
{
	$title=$_GET["title"];
	$date=$_GET["date"];
	
	$str_id			    = "select strTitleid from  syscontrol ";
	$result_id			= $db->RunQuery($str_id);
	$data_id			= mysql_fetch_array($result_id);
	$str_id_update		= "update syscontrol set strTitleid=strTitleid+1";
	$result_id_update	= $db->RunQuery($str_id_update);
	$id					=$data_id["strTitleid"];
	
	$sql				="INSERT INTO exportreport_header (strTitleid,strTitle,strDate) VALUES ('$id','$title','$date');";
	
	$result_sql			= $db->RunQuery($sql) ;
	
	$xml_string.='<data>';
	
	if($result_sql) 
		{
			$xml_string .=  "<response><![CDATA[saved]]></response>\n";
			$xml_string .=  "<ID><![CDATA[". $id  ."]]></ID>\n";
	
		}
	
	$xml_string.='</data>';
	echo $xml_string;
	
}

if($request=="save_detail")

{
	$xml_id=$_GET["xml_id"];
	$INO=$_GET["INO"];
	
	$sql="INSERT INTO exportreport_detail (strTitleid,strInvoiceNo) VALUES ('$xml_id','$INO');";
	$result=$db->RunQuery($sql);
	
	if($result)
		{
			echo "Saved Successfully.";
		}
	
}

if($request=="getData")
{
	$searchid=$_GET["searchid"];
		
	$sql="select exportreport_detail.strTitleid,exportreport_detail.strInvoiceNo,strISDno,SUBSTRING(dtmInvoiceDate,1,10)AS dtmInvoiceDate,commercial_invoice_header.strCarrier,commercial_invoice_header.strVoyegeNo
from exportreport_detail 
left join  commercial_invoice_header on  commercial_invoice_header.strInvoiceNo=exportreport_detail.strInvoiceNo  
left join commercial_invoice_detail on commercial_invoice_detail.strInvoiceNo=exportreport_detail.strInvoiceNo
where exportreport_detail.strTitleid='$searchid' group by commercial_invoice_detail.strInvoiceNo;";

	$result = $db->RunQuery($sql);
	$xml_string='<data>';
		
	while($row=mysql_fetch_array($result))
		{	
			$strVoyegeNo 	 = ($row["strVoyegeNo"]==""?'n/a':$row["strVoyegeNo"]);
			$strISDno		 = ($row["strISDno"]==""?'n/a':$row["strISDno"]);
			$dtmInvoiceDate	 = ($row["dtmInvoiceDate"]==""?'n/a':$row["dtmInvoiceDate"]);
			$strCarrier	 	 = ($row["strCarrier"]==""?'n/a':$row["strCarrier"]);
			
			$xml_string .= "<INVNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></INVNo>\n";
			$xml_string .= "<ISD><![CDATA[" . $strISDno   . "]]></ISD>\n";	
			$xml_string .= "<DATE><![CDATA[" . $dtmInvoiceDate   . "]]></DATE>\n";	
			$xml_string .= "<VESSEL><![CDATA[" . $strCarrier   . "]]></VESSEL>\n";	
			$xml_string .= "<VOYAGE><![CDATA[" . $strVoyegeNo   . "]]></VOYAGE>\n";
		} 
	$xml_string.='</data>';
	echo $xml_string;
		
}

if($request=="del_details")

{
	$titleid=$_GET["titleid"];
	$INO=$_GET["INO"];
	
	$sql="delete from exportreport_detail where strTitleid = '$titleid'";
	$result=$db->RunQuery($sql);
	
	if($result)
		{
			echo "deleted";
		}
	
}

if($request=="update_final_inv")

{
	
	$INO=$_GET["INO"];
	$Document=$_GET["Document"];
	$Payments=$_GET["Payments"];
	
	$sql="update finalinvoice 	set	 
							dtmDocumentSubDate = '$Document' ,	
							dtmPaymentSubDate = '$Payments' 	
							where
							strInvoiceNo = '$INO' ;";
	$result=$db->RunQuery($sql);
	
	if($result)
		{
			echo "updated";
		}
	
}

?>	