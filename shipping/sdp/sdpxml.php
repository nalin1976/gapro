<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
$Request 		= $_GET["Request"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];


if($Request=="loadBuyerBranch")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyerId = $_GET["buyerId"];
	
	$ResponseXML = "<XMLLoadBuyerBranch>\n";
	
	$sql_load = "select FBBN.intBuyerBranchId,FBBN.strBranchName
					from finishing_buyer_branch_network FBBN
					INNER JOIN buyers B ON B.intBuyerID=FBBN.intMotherCompany
					where FBBN.intMotherCompany='$buyerId'
					order by FBBN.strBranchName";
					
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intBuyerBranchId"] ."\">".$row["strBranchName"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadBuyerBranch>\n";
		echo $ResponseXML;
}
if($Request=="loadNotify")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyerBranchId = $_GET["buyerBranchId"];
	$ResponseXML = "<XMLLoadNotify>\n";
	
	$sql_load = "select FBN.intNotifyId,FBN.strNotifyName
					from finishing_buyer_notifyparty FBN
					INNER JOIN finishing_buyer_branch_network FBBN ON FBBN.intBuyerBranchId=FBBN.intBuyerBranchId
					where FBBN.intBuyerBranchId='$buyerBranchId'
					order by FBN.strNotifyName";
					
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=".$row["intNotifyId"].">".$row['strNotifyName']."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadNotify>\n";
		echo $ResponseXML;
}
if($Request=="getComInvNo")
{
	$comInvNo = getcomInvNo();
	echo $comInvNo;
}
if($Request=="saveHeaderData")
{
	$commercialid	= $_GET["commercialid"];
	$commercial		= $_GET['commercial'];
	$buyer			= $_GET['buyer'];
	$buyerBranch	= ($_GET['buyerBranch']==""?'null':$_GET['buyerBranch']);
	$destination	= $_GET['destination'];
	$transport		= $_GET['transport'];
	$notify1		= ($_GET['notify1']==""?'null':$_GET['notify1']);
	$notify2		= ($_GET['notify2']==""?'null':$_GET['notify2']);
	$notify3		= ($_GET['notify3']==""?'null':$_GET['notify3']);
	$notify4		= ($_GET['notify4']==""?'null':$_GET['notify4']);
	$incoterm		= ($_GET['incoterm']==""?'null':$_GET['incoterm']);
	$termDes		= $_GET['termDes'];
	$paymentterm	= ($_GET['paymentterm']==""?'null':$_GET['paymentterm']);
	$paytermDes		= $_GET['paytermDes'];
	$Bank			= ($_GET['Bank']==""?'null':$_GET['Bank']); 
	$BuyerBank		= ($_GET['BuyerBank']==""?'null':$_GET['BuyerBank']);
	$VAT			= $_GET['VAT'];
	$forwader		=($_GET['forwader']==""?'null':$_GET['forwader']); 
	$mline1			= $_GET['mline1'];
	$mline2			= $_GET['mline2'];
	$mline3			= $_GET['mline3'];
	$mline4			= $_GET['mline4'];
	$mline5			= $_GET['mline5'];
	$mline6			= $_GET['mline6'];
	$mline7			= $_GET['mline7'];
	$sline1			= $_GET['sline1'];
	$sline2			= $_GET['sline2'];
	$sline3			= $_GET['sline3'];
	$sline4			= $_GET['sline4'];
	$sline5			= $_GET['sline5'];
	$sline6			= $_GET['sline6'];
	$sline7			= $_GET['sline7'];
	$buyerTitle		= $_GET['buyerTitle'];
	$notify1Title	= $_GET['notify1Title'];
	$notify2Title	= $_GET['notify2Title'];
	$notify3Title	= $_GET['notify3Title'];
	$notify4Title	= $_GET['notify4Title'];
	$IncoDesc		= $_GET['IncoDesc'];
	$portOfLoading	= ($_GET['portOfLoading']==""?'null':$_GET['portOfLoading']);
	$exporter		= ($_GET['exporter']==""?'null':$_GET['exporter']);
	$manufacturer	= ($_GET['manufacturer']==""?'null':$_GET['manufacturer']);
	
	$sql_deleteHeader = "delete from shipping_sdp where intSDPID ='$commercialid' ;";
	$db->executeQuery($sql_deleteHeader);
	$sql_deleteDetail = "delete from gapro.shipping_com_inv_docs where intFormatId ='$commercialid' ";
	$db->executeQuery($sql_deleteDetail);
	
	$sql_insertHeader = "insert into shipping_sdp 
						(intSDPID, 
						strSDP_Title, 
						intBuyerId, 
						strBuyerTitle, 
						intBuyerBranchId, 
						intDestination, 
						intTransportMode, 
						intNotify1, 
						strNotify1Title, 
						intNotify2, 
						strNotify2Title, 
						intNotify3, 
						strNotify3Title, 
						intNotify4, 
						strNotify4Title, 
						intIncoterm, 
						strIncotermDescription, 
						intPaymentTerm, 
						strPaymentTermDescription, 
						intBank, 
						intBuyerBank, 
						strVAT, 
						intForwader, 
						strMainMark1, 
						strMainMark2, 
						strMainMark3, 
						strMainMark4, 
						strMainMark5, 
						strMainMark6, 
						strMainMark7, 
						strSideMark1, 
						strSideMark2, 
						strSideMark3, 
						strSideMark4, 
						strSideMark5, 
						strSideMark6, 
						strSideMark7,
						dtmDate,
						intUserId,
						intPortOfLoading, 
						intExporter, 
						intManufacturer
						)
						values
						(
						$commercialid,
						'$commercial',
						$buyer,
						'$buyerTitle',
						$buyerBranch,
						$destination,
						$transport,
						$notify1,
						'$notify1Title',
						$notify2,
						'$notify2Title',
						$notify3,
						'$notify3Title',
						$notify4,
						'$notify4Title',
						$incoterm,
						'$IncoDesc',
						$paymentterm,
						'$paytermDes',
						$Bank,
						$BuyerBank,
						'$VAT',
						$forwader,
						'$mline1',
						'$mline2',
						'$mline3',
						'$mline4',
						'$mline5',
						'$mline6',
						'$mline7',
						'$sline1',
						'$sline2',
						'$sline3',
						'$sline4',
						'$sline5',
						'$sline6',
						'$sline7',
						now(),
						$userId,
						$portOfLoading,
						$exporter,
						$manufacturer
						)";
	$result_header=$db->RunQuery($sql_insertHeader);
	//echo $sql_insertHeader;
	if($result_header)
		echo "HeaderSaved";
	else
		echo "ErrorSave";
}
if($Request=="savedetailData")
{
	$doc_id		    = $_GET['doc_id'];
	$format_id		= $_GET['format_id'];
	
	$sql_saveDetail ="insert into gapro.shipping_com_inv_docs 
					(intFormatId, 
					intDocumentId
					)
					values
					(
					$format_id,
					$doc_id
					)";
	$result=$db->RunQuery($sql_saveDetail);
	if($result)
	{
		echo"saved";
	}
	else
	{
		echo"error";
	}
}
if($Request=="loadDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceId = $_GET["invoiceId"];
	
	$ResponseXML = "<XMLLoadHeaderData>\n";
	
	$sql = "SELECT * FROM shipping_sdp WHERE intSDPID='$invoiceId' ;";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Commercial><![CDATA[".($row["strSDP_Title"])  . "]]></Commercial>\n";	
		$ResponseXML .= "<Buyer><![CDATA[".($row["intBuyerId"])  . "]]></Buyer>\n";
		$ResponseXML .= "<BuyerTitle><![CDATA[".($row["strBuyerTitle"])  . "]]></BuyerTitle>\n";
		$ResponseXML .= "<BuyerBranch><![CDATA[".($row["intBuyerBranchId"])  . "]]></BuyerBranch>\n";
		$ResponseXML .= "<Destination><![CDATA[".($row["intDestination"])  . "]]></Destination>\n";
		$ResponseXML .= "<Transport><![CDATA[".($row["intTransportMode"])  . "]]></Transport>\n";
		$ResponseXML .= "<Notify1><![CDATA[".($row["intNotify1"])  . "]]></Notify1>\n";	
		$ResponseXML .= "<Notify2><![CDATA[".($row["intNotify2"])  . "]]></Notify2>\n";	
		$ResponseXML .= "<Notify3><![CDATA[".($row["intNotify3"])  . "]]></Notify3>\n";	
		$ResponseXML .= "<Notify4><![CDATA[".($row["intNotify4"])  . "]]></Notify4>\n";	
		$ResponseXML .= "<Notify1Title><![CDATA[".($row["strNotify1Title"])  . "]]></Notify1Title>\n";	
		$ResponseXML .= "<Notify2Title><![CDATA[".($row["strNotify2Title"])  . "]]></Notify2Title>\n";
		$ResponseXML .= "<Notify3Title><![CDATA[".($row["strNotify3Title"])  . "]]></Notify3Title>\n";
		$ResponseXML .= "<Notify4Title><![CDATA[".($row["strNotify4Title"])  . "]]></Notify4Title>\n";
		$ResponseXML .= "<Incoterm><![CDATA[".($row["intIncoterm"])  . "]]></Incoterm>\n";
		$ResponseXML .= "<IncotermDescription><![CDATA[".($row["strIncotermDescription"])  . "]]></IncotermDescription>\n";
		$ResponseXML .= "<PaymentTerm><![CDATA[".($row["intPaymentTerm"])  . "]]></PaymentTerm>\n";	
		$ResponseXML .= "<PayTermDescription><![CDATA[".($row["strPaymentTermDescription"])  . "]]></PayTermDescription>\n";
		$ResponseXML .= "<Bank><![CDATA[".($row["intBank"])  . "]]></Bank>\n";
		$ResponseXML .= "<BuyerBank><![CDATA[".($row["intBuyerBank"])  . "]]></BuyerBank>\n";
		$ResponseXML .= "<VAT><![CDATA[".($row["strVAT"])  . "]]></VAT>\n";
		$ResponseXML .= "<Forwader><![CDATA[".($row["intForwader"])  . "]]></Forwader>\n";
		$ResponseXML .= "<MMline1><![CDATA[".($row["strMainMark1"])  . "]]></MMline1>\n";	
		$ResponseXML .= "<MMline2><![CDATA[".($row["strMainMark2"])  . "]]></MMline2>\n";
		$ResponseXML .= "<MMline3><![CDATA[".($row["strMainMark3"])  . "]]></MMline3>\n";
		$ResponseXML .= "<MMline4><![CDATA[".($row["strMainMark4"])  . "]]></MMline4>\n";
		$ResponseXML .= "<MMline5><![CDATA[".($row["strMainMark5"])  . "]]></MMline5>\n";
		$ResponseXML .= "<MMline6><![CDATA[".($row["strMainMark6"])  . "]]></MMline6>\n";
		$ResponseXML .= "<MMline7><![CDATA[".($row["strMainMark7"])  . "]]></MMline7>\n";
		$ResponseXML .= "<SMline1><![CDATA[".($row["strSideMark1"])  . "]]></SMline1>\n";
		$ResponseXML .= "<SMline2><![CDATA[".($row["strSideMark2"])  . "]]></SMline2>\n";
		$ResponseXML .= "<SMline3><![CDATA[".($row["strSideMark3"])  . "]]></SMline3>\n";
		$ResponseXML .= "<SMline4><![CDATA[".($row["strSideMark4"])  . "]]></SMline4>\n";
		$ResponseXML .= "<SMline5><![CDATA[".($row["strSideMark5"])  . "]]></SMline5>\n";
		$ResponseXML .= "<SMline6><![CDATA[".($row["strSideMark6"])  . "]]></SMline6>\n";
		$ResponseXML .= "<SMline7><![CDATA[".($row["strSideMark7"])  . "]]></SMline7>\n";
		
		$ResponseXML .= "<PortOfLoading><![CDATA[".($row["intPortOfLoading"])  . "]]></PortOfLoading>\n";
		$ResponseXML .= "<Exporter><![CDATA[".($row["intExporter"])  . "]]></Exporter>\n";
		$ResponseXML .= "<Manufacturer><![CDATA[".($row["intManufacturer"])  . "]]></Manufacturer>\n";
	}
	$ResponseXML .= "</XMLLoadHeaderData>";
	echo $ResponseXML;
}
if($Request=="load_format_details")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$format_id=$_GET['format_id'];

	$ResponseXML .= "<RequestDetails>\n";
	
	$sql="SELECT * FROM shipping_com_inv_docs WHERE intFormatId='$format_id' ;";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{		
		
		$ResponseXML .= "<DocumentId><![CDATA[".($row["intDocumentId"])  . "]]></DocumentId>\n";		
			
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
if($Request=="deleteData")
{
	$comInvId = $_GET["comInvId"];
	$sql_delete = "delete from shipping_sdp where intSDPID ='$comInvId'";
	$result = $db->RunQuery($sql_delete);
	if($result)
		echo "Deleted";
	else
		echo "Error";
}
function getcomInvNo()
{
	global $db;
	global $companyId;
	
	$sql = "select intSDPID from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$comInvNo = $row["intSDPID"];
	
	$sql_u = "update syscontrol set intSDPID=intSDPID+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	return $comInvNo;
}
?>