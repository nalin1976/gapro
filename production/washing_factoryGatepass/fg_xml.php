<?php
session_start();
include('../../Connector.php');
$intCompanyId =	$_SESSION["FactoryID"];
$userId		= $_SESSION['UserID'];
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$req=$_GET['req'];
if(strcmp($req,"loadShadeGrid")==0){
	$po=$_GET['po'];
	$gpNo=$_GET['GPass'];
	$gpYear=$_GET['SearchYear'];
	$gp=$_GET['gp'];
	
	if($gpNo!="" && $gpYear!=""){
		$sql="SELECT
				p.strShade,
				Sum(p.dblQty) AS QTY,
				productionbundleheader.strInvoiceNo
				FROM
				productionfggpdetails AS p
				INNER JOIN productionbundleheader ON p.intCutBundleSerial = productionbundleheader.intCutBundleSerial
				WHERE
							p.intGPYear = '$gpYear'
							AND
							p.intGPnumber = '$gpNo'
				GROUP BY
				p.strShade,productionbundleheader.strInvoiceNo
				ORDER BY
				p.dblBundleNo ASC;";
	}
	else{
	$sql="SELECT
		pbh.strInvoiceNo,
		pfgrd.strShade,
		Sum(pfgrd.dblBalQty) AS QTY,
		pfgrd.strColor
		FROM
		productionfinishedgoodsreceiveheader AS pfgrh
		INNER JOIN productionfinishedgoodsreceivedetails AS pfgrd ON pfgrh.dblTransInNo = pfgrd.dblTransInNo AND pfgrh.intGPTYear = pfgrd.intGPTYear
		INNER JOIN productionbundledetails AS pbd ON pfgrd.intCutBundleSerial = pbd.intCutBundleSerial AND pbd.dblBundleNo = pfgrd.dblBundleNo
		INNER JOIN productionbundleheader AS pbh ON pbd.intCutBundleSerial = pbh.intCutBundleSerial
		WHERE
		pfgrh.strTComCode = '".$_SESSION['FactoryID']."' AND
		pfgrh.intStyleNo = '$po' AND
		pfgrd.dblBalQty <> 0 ";
		
		if($gp!='')
			$sql.="AND concat(pfgrh.intGPYear,'/',pfgrh. dblGatePassNo ) = '$gp' ";
		
		$sql.="GROUP BY
		pbd.strShade,
		pbh.strInvoiceNo
		HAVING QTY > 0
		ORDER BY pbh.strInvoiceNo,pbd.strShade,
		pbd.dblBundleNo,
		pbd.intCutBundleSerial,
		pfgrd.strColor;";
	}
	//echo $sql;
		$res=$db->RunQuery($sql);
		$color='';
		$ResponseXML.= "<Dets>";
		while($row=mysql_fetch_assoc($res)){
			$color=$row["strColor"];
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$ResponseXML .= "<Shade><![CDATA[" . trim($row["strShade"])  . "]]></Shade>\n";
			$ResponseXML .= "<QTY><![CDATA[" . $row["QTY"]  . "]]></QTY>\n";
			if($gpNo!="" && $gpYear!=""){
				$ResponseXML .= "<BundleNo><![CDATA[" . getSavedBundleNos($po,$_SESSION['FactoryID'],$row["strInvoiceNo"],$row["strShade"],'dblBundleNo',$gpNo,$gpYear)  . "]]></BundleNo>\n";
			}
			else{
				$ResponseXML .= "<BundleNo><![CDATA[" . getBundleNos($po,$_SESSION['FactoryID'],$row["strInvoiceNo"],$row["strShade"],'dblBundleNo')  . "]]></BundleNo>\n";
			}
			if($gpNo!="" && $gpYear!=""){
				$ResponseXML .= "<CutBundleSerial><![CDATA[" . getSavedBundleNos($po,$_SESSION['FactoryID'],$row["strInvoiceNo"],$row["strShade"],'intCutBundleSerial',$gpNo,$gpYear) . "]]></CutBundleSerial>\n";
			}
			else{
				$ResponseXML .= "<CutBundleSerial><![CDATA[" . getBundleNos($po,$_SESSION['FactoryID'],$row["strInvoiceNo"],$row["strShade"],'intCutBundleSerial') . "]]></CutBundleSerial>\n";
			}
		}
		$ResponseXML .= "<AvlQty><![CDATA[" . getAvailableQty($po,$color,$_SESSION['FactoryID']). "]]></AvlQty>\n";
			
		$ResponseXML.= "</Dets>";
		echo $ResponseXML;
}

if(strcmp($req,"loadGPDets")==0){
	$gpNo=$_GET['gp'];
	$sql="SELECT
			productionfinishedgoodsreceiveheader.intStyleNo,
			productionfinishedgoodsreceiveheader.strFComCode
			FROM
			productionfinishedgoodsreceiveheader
			WHERE
			concat(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo) =  '$gpNo';";
	$ResponseXML.= "<Dets>";
	$res=$db->RunQuery($sql);
		while($row=mysql_fetch_assoc($res)){	
			$ResponseXML .= "<PO><![CDATA[" . $row['intStyleNo']. "]]></PO>\n";
			$ResponseXML .= "<FComCode><![CDATA[" . $row['strFComCode']. "]]></FComCode>\n";
		}
		$ResponseXML.= "</Dets>";
		echo $ResponseXML;
  
}

if(strcmp($req,"loadGP")==0){
	$sql="SELECT DISTINCT p.intStatus,p.dblTotQty,p.dblBalQty,p.intGPYear,p.dblGatePassNo,concat(p.intGPYear,'/',p.dblGatePassNo,'-->',o.strOrderNo) AS GP FROM productionfinishedgoodsreceiveheader p Inner Join orders o ON p.intStyleNo = o.intStyleId WHERE p.strTComCode =  '".$_SESSION['FactoryID']."' HAVING p.dblTotQty =  p.dblBalQty ORDER BY concat(p.intGPYear,'/',p.dblGatePassNo) ASC;";	
	//echo $sql;
	$res=$db->RunQuery($sql);
	$ResponseXML.= "";
	
	$op="<option value=\"\">Select One</option>";
	while($row=mysql_fetch_assoc($res)){
		$op.="<option value=\"" . $row['intGPYear'].'/'.$row['dblGatePassNo']. "\">".$row['GP']."</option>\n";
	}
	$ResponseXML .="<Dets><GPNo><![CDATA[".$op."]]></GPNo></Dets>";
	echo $ResponseXML;
}
function getBundleNos($po,$fac,$inv,$shade,$f){
	global $db;
	$sql="  SELECT
			productionfinishedgoodsreceivedetails.dblBundleNo,
			productionfinishedgoodsreceivedetails.intCutBundleSerial
			FROM
			productionfinishedgoodsreceiveheader
			INNER JOIN productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceiveheader.intGPTYear = productionfinishedgoodsreceivedetails.intGPTYear
			INNER JOIN productionbundledetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo
			INNER JOIN productionbundleheader ON productionbundledetails.intCutBundleSerial = productionbundleheader.intCutBundleSerial
			WHERE productionfinishedgoodsreceiveheader.strTComCode =  '$fac' AND
			productionfinishedgoodsreceiveheader.intStyleNo =  '$po' AND
			productionfinishedgoodsreceivedetails.dblBalQty > 0 AND
			TRIM(productionfinishedgoodsreceivedetails.strShade)='".trim($shade)."' AND
			TRIM(productionbundleheader.strInvoiceNo)='".trim($inv)."'
			GROUP BY  productionbundledetails.dblBundleNo
			ORDER BY productionfinishedgoodsreceivedetails.dblBundleNo,
			productionfinishedgoodsreceivedetails.intCutBundleSerial ASC";
			//echo $sql;
	$res=$db->RunQuery($sql);
	$nos='';
	while($row=mysql_fetch_assoc($res)){
		$nos.=$row[$f]."~";
	}
	$len=strlen($nos);
	return substr($nos,0,$len-1);
}

function getSavedBundleNos($po,$fac,$inv,$shade,$f,$gpNo,$gpYear){
	global $db;
	$sql=" SELECT
			p.intCutBundleSerial,
			p.dblBundleNo
			FROM
			productionfggpdetails AS p
			INNER JOIN productionbundleheader AS pbh ON pbh.intCutBundleSerial = p.intCutBundleSerial
			WHERE
			p.intGPYear = '$gpYear' AND
			p.intGPnumber = '$gpNo' AND
			TRIM(p.strShade) = '$shade' AND
			TRIM(pbh.strInvoiceNo) ='$inv'
			ORDER BY
			p.dblBundleNo,
			p.intCutBundleSerial ASC;";
			//echo $sql;
	$res=$db->RunQuery($sql);
	$nos='';
	while($row=mysql_fetch_assoc($res)){
		$nos.=$row[$f]."~";
	}
	$len=strlen($nos);
	return substr($nos,0,$len-1);
}

function getAvailableQty($po,$color,$fac){
	global $db;
	$sql="SELECT
			Sum(was_stocktransactions.dblQty) as QTY
			FROM
			was_stocktransactions
			WHERE
			was_stocktransactions.intCompanyId = '$fac' AND
			was_stocktransactions.intStyleId = '$po' AND
			was_stocktransactions.strColor='$color' 
			GROUP BY
			was_stocktransactions.intStyleId,
			was_stocktransactions.strColor;";
			//echo $sql;
					$res=$db->RunQuery($sql);
		$row=mysql_fetch_assoc($res);
		return $row['QTY'];
}
/*AND
			was_stocktransactions.intFromFactory='$sFac'*/
?>