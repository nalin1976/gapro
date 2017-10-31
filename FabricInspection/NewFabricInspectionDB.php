<?php
	session_start();
	include "../Connector.php";
	

	$RequestType = $_GET["RequestType"];		
	if (strcmp($RequestType,"Save") == 0)
	{
		$strInvoice						=	trim($_GET["strInvoice"]);	
		$intSupplierId					=	trim($_GET["intSupplierId"]);
		$intItemSerial					=	trim($_GET["intItemSerial"]);
		$strStyle						=	trim($_GET["strStyle"]);
		$strColor 						=	trim($_GET["strColor"]);
		$receivedDate					=	cdate($_GET["receivedDate"]);
		$receivedQty 					=	$_GET["receivedQty"];
		$swatImformedDate				=	cdate($_GET["swatImformedDate"]);
		$swatReceivedDate				=	cdate($_GET["swatReceivedDate"]);
		$srinkageLength 				=	$_GET["srinkageLength"];
		$srinkageWidth					=	$_GET["srinkageWidth"];
		$orderWidth						=	$_GET["orderWidth"];
		$cuttableWidth					=	$_GET["cuttableWidth"];
		$lessWidthSampleSendDate		=	cdate($_GET["lessWidthSampleSendDate"]);
		$gatepassNo1					=	$_GET["gatepassNo1"];
		$inspectedQty					=	$_GET["inspectedQty"];
		$inspected						=	$_GET["inspected"];
		$defected						=	$_GET["defected"];
		$gatepassNo2					=	$_GET["gatepassNo2"];
		$defectSentDate					=	cdate($_GET["defectSentDate"]);
		$defectApproved					=	$_GET["defectApproved"];
		$defectivePanelReplace			=	$_GET["defectivePanelReplace"];
		$inrollShortage					=	$_GET["inrollShortage"];
		$totalYardsWeNeeded				=	$_GET["totalYardsWeNeeded"];
		$claimReportUpDate				=	cdate($_GET["claimReportUpDate"]);
		$mailedDate						=	cdate($_GET["mailedDate"]);
		$shadeBandSendDate				=	cdate($_GET["shadeBandSendDate"]);
		$gatepassNo3					=	$_GET["gatepassNo3"];
		$shadeBandApproval				=	$_GET["shadeBandApproval"];
		$matchingLabdip					=	$_GET["matchingLabdip"];
		$sendDate1						=	cdate($_GET["sendDate1"]);
		$gatepassNo4					=	$_GET["gatepassNo4"];
		$colorApproval					=	$_GET["colorApproval"];
		$skewingBowing					=	$_GET["skewingBowing"];
		$sendDate2						=	cdate($_GET["sendDate2"]);
		$gatepassNo5					=	$_GET["gatepassNo5"];
		
		$BowingskeyApproval				=	$_GET["BowingskeyApproval"];
		$ClrShading						=	$_GET["ClrShading"];
		$ClrShadingDate					=	$_GET["ClrShadingDate"];
		$GatepassNo6					=	$_GET["GatepassNo6"];
		
		$shadingApproval				=	$_GET["shadingApproval"];
		$fabricWay						=	$_GET["fabricWay"];
		$grade							=	$_GET["grade"];
		$status							=	$_GET["status"];
		$invoiceNo2						=	$_GET["invoiceNo2"];
		$supplierId2					=	$_GET["supplierId2"];
		$styleNo2						=	$_GET["styleNo2"];
		$Po_Pi2							=	$_GET["Po_Pi2"];
		$Buyer2							=	$_GET["Buyer2"];
		$strColor2						=	$_GET["strColor2"];
		$receivedQty2					=	$_GET["receivedQty2"];

		$SQLdel = "delete from `fabricinspection` 
					where
	`strInvoice` = '$strInvoice' and `intSupplierId` = '$intSupplierId' and `intItemSerial` = '$intItemSerial' and `strColor` = '$strColor' ";
	
		$resultdel=$db->RunQuery($SQLdel);
		
			$SQL = 	"		insert into `fabricinspection` 
							(`strInvoice`, 
							`intSupplierId`, 
							`intItemSerial`, 
							`strStyle`, 
							`strColor`, 
							`receivedDate`, 
							`receivedQty`, 
							`swatImformedDate`, 
							`swatReceivedDate`, 
							`srinkageLength`, 
							`srinkageWidth`, 
							`orderWidth`, 
							`cuttableWidth`, 
							`lessWidthSampleSendDate`, 
							`gatepassNo1`, 
							`inspectedQty`, 
							`inspected`, 
							`defected`, 
							`gatepassNo2`, 
							`defectSentDate`, 
							`defectApproved`, 
							`defectivePanelReplace`, 
							`inrollShortage`, 
							`totalYardsWeNeeded`, 
							`claimReportUpDate`, 
							`mailedDate`, 
							`shadeBandSendDate`, 
							`gatepassNo3`, 
							`shadeBandApproval`, 
							`matchingLabdip`, 
							`sendDate1`, 
							`gatepassNo4`, 
							`colorApproval`, 
							`skewingBowing`, 
							`sendDate2`, 
							`gatepassNo5`, 
							
							`bowingSkewApproval`, 
							`clrShading`, 
							`sendDate3`, 
							`gatepassNo6`, 
							
							`shadingApproval`, 
							`fabricWay`, 
							`grade`, 
							`status`, 
							`invoiceNo2`, 
							`supplierId2`, 
							`styleNo2`, 
							`Po_Pi2`, 
							`Buyer2`, 
							`strColor2`, 
							`receivedQty2`
							)
							values
							('$strInvoice', 
							'$intSupplierId', 
							'$intItemSerial', 
							'$strStyle', 
							'$strColor', 
							'$receivedDate', 
							$receivedQty, 
							'$swatImformedDate', 
							'$swatReceivedDate', 
							'$srinkageLength', 
							'$srinkageWidth', 
							'$orderWidth', 
							'$cuttableWidth', 
							'$lessWidthSampleSendDate', 
							'$gatepassNo1', 
							'$inspectedQty', 
							'$inspected', 
							'$defected', 
							'$gatepassNo2', 
							'$defectSentDate', 
							'$defectApproved', 
							'$defectivePanelReplace', 
							'$inrollShortage', 
							'$totalYardsWeNeeded', 
							'$claimReportUpDate', 
							'$mailedDate', 
							'$shadeBandSendDate', 
							'$gatepassNo3', 
							'$shadeBandApproval', 
							'$matchingLabdip', 
							'$sendDate1', 
							'$gatepassNo4', 
							'$colorApproval', 
							'$skewingBowing', 
							'$sendDate2', 
							'$gatepassNo5', 
							'$BowingskeyApproval',
							'$ClrShading',
							'$ClrShadingDate',
							'$GatepassNo6',
							'$shadingApproval', 
							'$fabricWay', 
							'$grade', 
							'$status', 
							'$invoiceNo2', 
							'$supplierId2', 
							'$styleNo2', 
							'$Po_Pi2', 
							'$Buyer2', 
							'$strColor2', 
							'$receivedQty2'
							)";
		$result=$db->RunQuery($SQL);
		echo $result;
		
	}
	else if (strcmp($RequestType,"getInvoiceDetails") == 0)
	{
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$invoiceNo		= $_GET["invoiceNo"];
		$intSupplier	= $_GET["intSupplier"];
		$intItemSerial	= $_GET["intItemSerial"];
		$strColor		= $_GET["strColor"];
		//echo $intItemSerial;		
		$ResponseXML = "";
		$ResponseXML .= "<Details>\n";				 
		$invResult=getInvoiceDetails($invoiceNo,$intSupplier,$intItemSerial,$strColor);		
		$row =mysql_fetch_array($invResult);
					
			$ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"] . "]]></strUnit>\n";	
			$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"] . "]]></dblQty>\n";	//dtmRecievedDate
			$ResponseXML .= "<date><![CDATA[" . substr($row["dtmRecievedDate"],0,10) . "]]></date>\n";	//dtmRecievedDate
					
		$result=getFabricInspectionDetails($invoiceNo,$intSupplier,$intItemSerial,$strColor);
		$row =mysql_fetch_array($result);
		
		$ResponseXML .= "<Item><![CDATA[" . $row["strInvoice"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["intSupplierId"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["intItemSerial"] . "]]></Item>\n";		
		$ResponseXML .= "<Item><![CDATA[" . $row["strStyle"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["strColor"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["receivedDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["receivedQty"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["swatImformedDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["swatReceivedDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["srinkageLength"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["srinkageWidth"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["orderWidth"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["cuttableWidth"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["lessWidthSampleSendDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["gatepassNo1"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["inspectedQty"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["inspected"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["defected"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["gatepassNo2"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["defectSentDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["defectApproved"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["defectivePanelReplace"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["inrollShortage"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["totalYardsWeNeeded"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["claimReportUpDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["mailedDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["shadeBandSendDate"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["gatepassNo3"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["shadeBandApproval"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["matchingLabdip"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["sendDate1"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["gatepassNo4"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["colorApproval"] . "]]></Item>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["skewingBowing"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["sendDate2"] . "]]></Item>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["gatepassNo5"] . "]]></Item>\n";
		
		$ResponseXML .= "<Item><![CDATA[" . $row["bowingSkewApproval"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["clrShading"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["sendDate3"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["gatepassNo6"] . "]]></Item>\n";
		
		$ResponseXML .= "<Item><![CDATA[" . $row["shadingApproval"] . "]]></Item>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["fabricWay"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["grade"] . "]]></Item>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["status"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["invoiceNo2"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["supplierId2"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["styleNo2"] . "]]></Item>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["Po_Pi2"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["Buyer2"] . "]]></Item>\n";	
		$ResponseXML .= "<Item><![CDATA[" . $row["strColor2"] . "]]></Item>\n";
		$ResponseXML .= "<Item><![CDATA[" . $row["receivedQty2"] . "]]></Item>\n";			
		$ResponseXML .= "</Details>";
		
		echo $ResponseXML;		
	}
	else if (strcmp($RequestType,"SaveLot") == 0)
	{
		header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$strInvoice 	= trim($_GET["strInvoice"]);
		$intSupplier 	= trim($_GET["intSupplier"]);
		$strLotNumber 	= trim($_GET["strLotNumber"]);
		$strRollNumber 	= $_GET["strRollNumber"];
		$dblQty 		= $_GET["dblQty"];
		$strRemarks 	= $_GET["strRemarks"];
		$intItemSerial	= $_GET["intItemSerial"];
		$strColor		= trim($_GET["strColor"]);		
		$dblPassRate	= $_GET["dblPassRate"];		
		$intStatus		= $_GET["intStatus"];		
		if (is_null($dblQty) || $dblQty == "") $dblQty=0;
		$ResponseXML 	= "<RequestDetails>";
		$ResponseXML .= "<Result><![CDATA[".SaveLot($strInvoice,$intSupplier,$strLotNumber,$strRollNumber,$dblQty,$strRemarks,$intItemSerial,$strColor,$dblPassRate,$intStatus)."]]></Result>\n";
		$ResponseXML .= "</RequestDetails>";
		echo $ResponseXML;
	} 
	else if (strcmp($RequestType,"LoadLotDetails") == 0)
	{	
		header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
		$strInvoice=trim($_GET["strInvoice"]);		
		$intSupplier=trim($_GET["intSupplier"]);		
		$intItemSerial	= trim($_GET["intItemSerial"]);
		$strColor		= trim($_GET["strColor"]);		
		$ResponseXML = "";
		$ResponseXML .= "<LotDetails>\n";				 
		
		$LotResult=loadLotDetails($strInvoice,$intSupplier,$intItemSerial,$strColor);	
		while($row = mysql_fetch_array($LotResult))
		{	
			$ResponseXML .= "<strLotNo><![CDATA[" . $row["strLotNo"] . "]]></strLotNo>\n";
			$ResponseXML .= "<strRollNo><![CDATA[" . $row["strRollNo"] . "]]></strRollNo>\n";			
			$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"] . "]]></dblQty>\n";			
			$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"] . "]]></strRemarks>\n";
			$ResponseXML .= "<dblPassRate><![CDATA[" . $row["dblPassRate"] . "]]></dblPassRate>\n";
			$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"] . "]]></intStatus>\n";			
		}
		$ResponseXML .= "</LotDetails>";
		echo $ResponseXML;
	}
	else if (strcmp($RequestType,"DeleteInspectin") == 0)
	{
		header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$strInvoice		= $_GET["strInvoice"];		
		$intSupplier	= $_GET["intSupplier"];
		$intItemSerial	= $_GET["intItemSerial"];
		$strColor		= $_GET["strColor"];
		
		$ResponseXML = "<RequestDetails>";
		DeleteInspection($strInvoice,$intSupplier,$intItemSerial,$strColor);
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
		$ResponseXML .= "</RequestDetails>";
		echo $ResponseXML;		
	}
	else if (strcmp($RequestType,"getColor") == 0)
	{

		$strInvoiceNo	= $_GET["strInvoiceNo"];		
		$intSupplier	= $_GET["intSupplier"];	
		$intItemNo		= $_GET["intItemNo"];	
		$ICResult=loadColorRecordSet($strInvoiceNo,$intSupplier,$intItemNo);	
		$string = "<option value='0'>Select One</option>";
		while($row = mysql_fetch_array($ICResult))
		{	
			$string .= "<option value=\"".trim($row["strColor"])."\">".trim($row["strColor"])."</option>";	
		}

		echo $string;	
	} 
	///////////////////////////////////////////
	else if (strcmp($RequestType,"getStyles") == 0)
	{

		$strInvoiceNo = $_GET["invNo"];
		$intMatDetailID = $_GET["itemNo"];
		$strColor = $_GET["strColor"];
		
	$sql="	
			SELECT DISTINCT
			grndetails.intStyleId,
			purchaseorderheader.strSupplierID,
			suppliers.strTitle
			FROM
			grndetails
			Inner Join grnheader ON grndetails.intGrnNo = grnheader.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
			Inner Join purchaseorderheader ON purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear
			Inner Join suppliers ON suppliers.strSupplierID = purchaseorderheader.strSupplierID
			WHERE
			grnheader.strInvoiceNo =  '$strInvoiceNo' AND
			grndetails.intMatDetailID =  '$intMatDetailID' AND
			grndetails.strColor =  '$strColor'
			";
		$result=$db->RunQuery($sql);

		while($row = mysql_fetch_array($result))
		{	
			$strSupplier = $row["strSupplierID"] .'<B>'. $row["strTitle"];
			$style = $row["intStyleId"];
			$comboString .= "$style  / ";
		}
		echo $comboString.'<A>'.$strSupplier;
	}
	//////////////////////////////////////////
	else if (strcmp($RequestType,"DeleteLot")==0)
	{
		header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$strInvoice		= $_GET["strInvoice"];
		$intSupplier	= $_GET["intSupplier"];
		$intItemSerial	= $_GET["intItemSerial"];
		$strColor		= $_GET["strColor"];
		DeleteLot($strInvoice,$intSupplier,$intItemSerial,$strColor);		
	} else if (strcmp($RequestType,"getItem") == 0)
	{

		$strInvoiceNo	= $_GET["strInvoiceNo"];		
		$intSupplier	= $_GET["intSupplier"];		
		$ICResult=loadItemDetails($strInvoiceNo,$intSupplier);	
		$string = "<option value='0'>Select One</option>";
		while($row = mysql_fetch_array($ICResult))
		{					  
			$string .= "<option value=\"".$row["intMatDetailID"]."\">".$row["strItemDescription"]."</option>";
		}
		echo $string;	
	}

	
function DeleteLot($strInvoice,$intSupplier,$intItemSerial,$strColor)
{
	global $db;
	$sql="DELETE FROM fabricinspectionlot WHERE strInvoice='$strInvoice' AND intSupplierId=$intSupplier AND intItemSerial=$intItemSerial AND strColor='$strColor';"; 		
  	$db->ExecuteQuery($sql);	
}
	
function SaveLot($strInvoice,$intSupplier,$strLotNo,$strRollNo,$dblQty,$strRemarks,$intItemSerial,$strColor,$dblPassRate,$intStatus)
{
		global $db;		
$sql = "SELECT strInvoice, intSupplierId FROM fabricinspectionlot WHERE (strInvoice = '$strInvoice') AND (intSupplierId = '$intSupplier') AND (strLotNo='$strLotNo') AND (strRollNo='$strRollNo') AND (intItemSerial=$intItemSerial) AND (strColor='$strColor') ;";	
		$result = $db->RunQuery($sql);
		$rows = mysql_num_rows($result);
		//echo ($rows);
		if ($rows >0)
		{		
			$sql ="UPDATE fabricinspectionlot SET dblQty=$dblQty,strRollNo='$strRollNo',strLotNo='$strLotNo',strRemarks='$strRemarks', dblPassRate=$dblPassRate, intStatus=$intStatus WHERE (strInvoice ='$strInvoice') AND (intSupplierId='$intSupplier') AND (strLotNo='$strLotNo') AND (strRollNo='$strRollNo') AND (intItemSerial=$intItemSerial) AND (strColor='$strColor');";					
			//echo ($sql);
			$affrows = $db->AffectedExecuteQuery($sql);		
			if ( $affrows != 0 ) return -2;		
		}
		else
		{	
			$sql = "INSERT INTO fabricinspectionlot (strInvoice, intSupplierId, strLotNo, strRollNo, dblQty, strRemarks,intItemSerial,strColor,dblPassRate,intStatus) VALUES ('$strInvoice', $intSupplier, '$strLotNo', '$strRollNo', $dblQty, '$strRemarks',$intItemSerial,'$strColor',$dblPassRate,$intStatus);";
			//echo($sql);
			$newID = $db->AutoIncrementExecuteQuery($sql);
			return $newID;	
		}
	return -2;
}
	
function getFabricinspectionDetails($invoiceNo,$intSupplier,$intItemSerial,$strColor)
{
	global $db;
	$strSQL="SELECT * FROM fabricinspection WHERE strInvoice='$invoiceNo' AND intSupplierId='$intSupplier' AND intItemSerial='$intItemSerial' AND strColor='$strColor';";
	
	//echo $strSQL;

	$recordset=$db->RunQuery($strSQL);
	return $recordset;
}

function getInvoiceDetails($invoiceNo,$intSupplier,$intItemSerial,$strColor)
{
	global $db;
/*$strSQL="SELECT DISTINCT matitemlist.intItemSerial,matitemlist.strItemDescription,suppliers.strTitle AS suppliersName,grndetails.intStyleId ,grndetails.strColor, purchaseorderheader.strSupplierID,purchaseorderdetails.strUnit ,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.dblQty FROM grnheader INNER JOIN purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo=purchaseorderdetails.intPoNo INNER JOIN suppliers ON purchaseorderheader.strSupplierID=suppliers.strSupplierID INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intgrnno and grnheader.intGRNYear =grndetails.intGRNYear and grndetails.intStyleId=purchaseorderdetails.intStyleId and grndetails.intMatDetailID=purchaseorderdetails.intMatDetailID and grndetails.strColor=purchaseorderdetails.strColor and grndetails.strSize=purchaseorderdetails.strSize INNER JOIN matitemlist ON grndetails.intMatDetailID=matitemlist.intItemSerial WHERE matitemlist.intMainCatID=1 AND grnheader.strInvoiceNo='$invoiceNo' AND purchaseorderheader.strSupplierID='$intSupplier' and matitemlist.intItemSerial=$intItemSerial and grndetails.strColor='$strColor' ";*/
$strSQL = "SELECT
			SUM(grndetails.dblQty) as dblQty,
			purchaseorderdetails.strUnit,
			grnheader.dtmRecievedDate
FROM
grndetails
Inner Join grnheader ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
Inner Join purchaseorderheader ON purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear
Inner Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor
WHERE
			grnheader.strInvoiceNo =  '$invoiceNo' AND
			grndetails.intMatDetailID =  '$intItemSerial' AND
			purchaseorderheader.strSupplierID =  '$intSupplier'  AND
			grndetails.strColor =  '$strColor' 
			GROUP BY
			purchaseorderdetails.strUnit,grnheader.strInvoiceNo,grndetails.intMatDetailID,
			purchaseorderheader.strSupplierID,grndetails.strColor

			";
			
$recordset=$db->RunQuery($strSQL);
//echo $strSQL;
	return $recordset;
}
	
function SaveFabric($SupplierID,$InvoiceNo ,$Style ,$ItemDescription,$ItemSerial,$Color ,$RecievedDate,$ReceivedQty,$Unit,$AppSWATImformedDate,$AppSWATReceivedDate,$SinkAgeLegth,$SinkAgeWidth,$OrderWidth,$CuttableWidth,$LessWidthSampleSendDate,$LessWidthSampleSendGatepassNo,$InspectedQty,$InspectedRate,$DefectiveRate,$DefectSentGatepassNo,$DefectSentDate,$DefectApprovaed,$DefectivePannelRep,$InrollShortages,$TotalQty,$ClaimReportUpDate,$MailedDate,$ShadeBandSendDate,$ShadeBandSendGatepassNo,$ShadeBandApprovale,$CLRMatchingLabdip,$CLRMatchingLabdipSentDate,$CLRMatchingLabdipGatepassNo,$ColourApproval,$SkewingBowingRate,$SkewingBowingGatepassNo,$BowingSkewApproval,$ClrShading,$ClrShadingDate,$ClrShadingGatepassNo,$ShadingApprovel,$FabricWay,$Grade,$Status,$InvoiceNo2,$Supplier2,$StyleNo2,$POPI2,$Buyer2,$Colour2,$RecQty2)
	{
		global $db;			
		$userid=$_SESSION["UserID"] ;		
		$date = date("Y-m-d");
				
		$sql = "SELECT strInvoice, intSupplierId, strStyle FROM FabricInspection WHERE  (strInvoice = '$strInvoice') AND (intSupplierId = '$intSupplier') AND (intItemSerial = '$intItemSerial') AND (strColor='$strColor');";	
		//echo ($sql);
		$result = $db->RunQuery($sql);
		$rows = mysql_num_rows($result);			
		if ($rows >0)
		{		
			$sql ="UPDATE fabricinspection SET strDescription='$strDescription', strStyle='$strStyle',strComposition='$strComposition',dblOrderWidth=$dblOrderWidth,dblCutWidth=$dblCutWidth, dblReceivedQty=$dblReceivedQty,strUnit='$strUnit', dblPrice=$dblPrice,dblInrollShortageValue=$dblInrollShortageValue, dblInrollShortageRate=$dblInrollShortageRate, dblInrollShortageCutting=$dblInrollShortageCutting, boolRelax24Hours='$boolRelax24Hours', boolSpreaderLay='$boolSpreaderLay', boolWidthVariation='$boolWidthVariation', boolBowingSkewing='$boolBowingSkewing', strComments='$strComments', strColorShading='$strColorShading', strDyeLotVariation='$strDyeLotVariation', dblInspectedQty=$dblInspectedQty, dblInspectionRate=$dblInspectionRate,dblDefectRate=$dblDefectRate,dblDefectReplaceQty=$dblDefectReplaceQty,dblDefectReplaceRate=$dblDefectReplaceRate ,dblTotalYDSReplace=$dblTotalYDSReplace,strMajorDefects='$strMajorDefects',strMinorDefects='$strMinorDefects', strColorMatchingLabDip='$strColorMatchingLabDip', strRemarks='$strRemarks',strGrade='$strGrade',strStatus='$strStatus',booFabricWay='$booFabricWay', dtmSwatchInfDate='$dtmSwatchInfDate', dtmSwatchRecDate='$dtmSwatchRecDate', dblSinkAgeLength=$dblSinkAgeLength, dblSinkAgeWidth=$dblSinkAgeWidth WHERE (strInvoice ='$strInvoice') AND (intSupplierId='$intSupplier') AND (intItemSerial=$intItemSerial) AND (strColor='$strColor'); ";					
		//echo ($sql);
		$affrows = $db->AffectedExecuteQuery($sql);
		if ( $affrows != 0 ) return -2;		
		}
		else
		{	
			$sql = "INSERT INTO  fabricinspection (strInvoice, intSupplierId, strColor, strDescription,strStyle, strComposition, dblOrderWidth, dblCutWidth, dblReceivedQty, strUnit, dblPrice,dblInrollShortageValue,dblInrollShortageRate, dblInrollShortageCutting, boolRelax24Hours, boolSpreaderLay, boolWidthVariation, boolBowingSkewing,strComments,strColorShading, strDyeLotVariation,	dblInspectedQty,dblInspectionRate,dblDefectRate, dblDefectReplaceQty,dblDefectReplaceRate,dblTotalYDSReplace,strMajorDefects, strMinorDefects, strColorMatchingLabDip, strRemarks, strGrade, strStatus,booFabricWay,intUserID,dtDate,intItemSerial,dtmSwatchInfDate,dtmSwatchRecDate,dblSinkAgeLength,dblSinkAgeWidth) VALUES ('$strInvoice', $intSupplier, '$strColor', '$strDescription', '$strStyle','$strComposition', $dblOrderWidth, $dblCutWidth, $dblReceivedQty, '$strUnit', $dblPrice, $dblInrollShortageValue, $dblInrollShortageRate, $dblInrollShortageCutting, '$boolRelax24Hours', '$boolSpreaderLay', '$boolWidthVariation', '$boolBowingSkewing','$strComments', '$strColorShading', '$strDyeLotVariation', $dblInspectedQty,$dblInspectionRate, $dblDefectRate, $dblDefectReplaceQty, $dblDefectReplaceRate, $dblTotalYDSReplace,'$strMajorDefects', '$strMinorDefects', '$strColorMatchingLabDip', '$strRemarks', '$strGrade', '$strStatus','$booFabricWay','$userid', '$date',$intItemSerial,'$dtmSwatchInfDate','$dtmSwatchRecDate',$dblSinkAgeLength,$dblSinkAgeWidth);";
			//echo($sql);
			$newID = $db->AutoIncrementExecuteQuery($sql);
			return $sql;	
		}
		
	return -2;
	}
	
	function loadLotDetails($strInvoice,$intSupplier,$intItemSerial,$strColor)
	{
		global $db;
		$sql ="SELECT strInvoice,intSupplierId,dblQty,strLotNo,strRemarks,strRollNo,dblPassRate,intStatus FROM fabricinspectionlot WHERE strInvoice='$strInvoice' AND intSupplierId=$intSupplier AND intItemSerial=$intItemSerial AND strColor='$strColor' ORDER BY strLotNo,strRollNo;";	
		$recordset=$db->RunQuery($sql);
		return $recordset;		
	}
		
	function DeleteInspection($strInvoice,$intSupplier,$intItemSerial,$strColor)
	{
		global $db;
		$sql="DELETE FROM fabricinspection WHERE strInvoice=$strInvoice AND intSupplierId=$intSupplier AND intItemSerial=$intItemSerial AND strColor='$strColor';";
		$db->ExecuteQuery($sql);
		
		$sql="DELETE FROM fabricinspectionlot WHERE strInvoice='$strInvoice' AND intSupplierId=$intSupplier AND intItemSerial=$intItemSerial AND strColor='$strColor';"; 		
	  	$db->ExecuteQuery($sql);		
	}	
	
	function loadColorRecordSet ($strInvoiceNo,$intSupplier,$intItemNo)
	{
		global $db;
/*		$sql="SELECT DISTINCT grndetails.intMatDetailID,grndetails.strColor  FROM grnheader INNER JOIN purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intgrnno INNER JOIN matitemlist ON grndetails.intMatDetailID= matitemlist.intItemSerial WHERE  (grnheader.strInvoiceNo ='$strInvoiceNo')  and (grndetails.intMatDetailID=$intItemNo) ORDER BY matitemlist.strItemDescription";*/
		$sql = "SELECT distinct  materialratio.strColor as strColor
				FROM
				grnheader
				Inner Join purchaseorderdetails ON grnheader.intPoNo = purchaseorderdetails.intPoNo
				AND grnheader.intYear = purchaseorderdetails.intYear
				Inner Join materialratio ON purchaseorderdetails.intStyleId = materialratio.intStyleId
				WHERE  (grnheader.strInvoiceNo ='$strInvoiceNo')  and (purchaseorderdetails.intMatDetailID=$intItemNo)";
		$recordSet=$db->RunQuery($sql);
		$have = 0;
		while($row1 = mysql_fetch_array($recordSet))
		{
			$color = strtoupper($row1["strColor"]);
			
			if(($color!='NA') && ($color!='N/A'))
				$have = 1;
		}

		$recordSet=$db->RunQuery($sql);

		if($have==1)
		{
			return $recordSet;
		}
		else
		{
			$sql2 = "SELECT DISTINCT
					styleratio.strColor
					FROM
					grnheader
					Inner Join purchaseorderdetails ON grnheader.intPoNo = purchaseorderdetails.intPoNo 
					AND grnheader.intYear = purchaseorderdetails.intYear
					Inner Join styleratio ON purchaseorderdetails.intStyleId = styleratio.intStyleId
					WHERE  (grnheader.strInvoiceNo ='$strInvoiceNo')  and (purchaseorderdetails.intMatDetailID=$intItemNo)";
			$recordSet2=$db->RunQuery($sql2);
			return  $recordSet2;
		}
	}
	
	function loadItemDetails ($strInvoiceNo,$intSupplier)
	{
		global $db;
/*		$sql="SELECT DISTINCT grndetails.intMatDetailID, matitemlist.strItemDescription FROM grnheader INNER JOIN purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intgrnno INNER JOIN matitemlist ON grndetails.intMatDetailID= matitemlist.intItemSerial WHERE (grnheader.strInvoiceNo ='$strInvoiceNo') AND (purchaseorderheader.strSupplierID = $intSupplier) ORDER BY matitemlist.strItemDescription";*/
		$sql="	SELECT distinct grndetails.intMatDetailID, matitemlist.strItemDescription
				FROM
				grndetails
				Inner Join matitemlist ON matitemlist.intItemSerial = grndetails.intMatDetailID
				Inner Join grnheader ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
				WHERE
				grnheader.strInvoiceNo =  '$strInvoiceNo'";
		$recordSet=$db->RunQuery($sql);
		//echo $sql;
		return $recordSet;
	}
	
	function cdate($value)
	{
		if(trim($value)=='')
			return '1900/01/01';
		else
			return $value;
	}
?>