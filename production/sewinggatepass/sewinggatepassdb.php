<?php
session_start();
header('Content-Type: text/xml'); 
include "../../Connector.php";
include "../production.php";

$companyId = $_SESSION["FactoryID"];
$userId	   = $_SESSION["UserID"];
$Request   = $_GET["Request"];

if($Request=="LoadOrderNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$transferNo = $_GET["transferNo"];
	$transferArry = explode('/',$transferNo);
	$ResponseXML = "<XMLOrderNo>\n";
	
	$sql_orederNo = "select distinct O.strOrderNo,O.intStyleId
						from productiongptindetail PGTD
						inner join productionbundleheader PBH ON PGTD.intCutBundleSerial = PBH.intCutBundleSerial
						inner join orders O ON PBH.intStyleId = O.intStyleId
						inner join productiongptinheader PGTH ON PGTH.dblCutGPTransferIN = PGTD.dblCutGPTransferIN
						where PGTH.intFactoryId='$companyId'";
	if($transferNo!="")
		$sql_orederNo.=" AND PGTH.dblCutGPTransferIN = '$transferArry[1]' and PGTH.intGPTYear = '$transferArry[0]'";
	$sql_orederNo.=" order by O.strOrderNo;";

	$result_order =$db->RunQuery($sql_orederNo);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_order))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
		$ResponseXML .= "</XMLOrderNo>\n";
		echo $ResponseXML;
}
if($Request=="LoadCutNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$transferNo = $_GET["transferNo"];
	$orderNo    = $_GET["orderNo"];
	$transferArry = explode('/',$transferNo);
	$ResponseXML = "<XMLCutNo>\n";
	
	$sql_cutno = "select distinct PBH.intCutBundleSerial,PBH.strCutNo
					from productionbundleheader PBH 
					inner join productiongptindetail PGTD ON PGTD.intCutBundleSerial = PBH.intCutBundleSerial
					inner join productiongptinheader PGTH ON PGTH.dblCutGPTransferIN = PGTD.dblCutGPTransferIN
					where PGTH.intFactoryId='$companyId'";
	if($transferNo!="")
		$sql_cutno.=" AND PGTH.dblCutGPTransferIN = '$transferArry[1]' and PGTH.intGPTYear = '$transferArry[0]'";
	if($orderNo!="")
		$sql_cutno.=" AND PBH.intStyleId='$orderNo'";
	$sql_cutno.=" order by PBH.strCutNo;";
	$result_cut =$db->RunQuery($sql_cutno);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";				
	while($row=mysql_fetch_array($result_cut))
		{
			$ResponseXML .= "<option value=\"". $row["intCutBundleSerial"] ."\">".$row["strCutNo"]."</option>\n";	
		}
		$ResponseXML .= "</XMLOrderNo>\n";
		echo $ResponseXML;									
}
if($Request=="loadGatepassDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$orderNo    = $_GET["orderNo"];
	$transferNo = $_GET["transferNo"];
	$cutNo      = $_GET["cutNo"];
	$transferArry = explode('/',$transferNo);
	$ResponseXML = "<XMLloadGatepassDetails>\n";
	
	$sql_loadDetails = "select distinct PBD.strSize,PBD.dblBundleNo,PGTD.dblBalQty,PBH.strCutNo,PBD.strShade,PBH.intCutBundleSerial
from productionbundledetails PBD
inner join productiongptindetail PGTD ON PBD.intCutBundleSerial=PGTD.intCutBundleSerial and PBD.dblBundleNo=PGTD.dblBundleNo
inner join productiongptinheader PGTH ON PGTH.dblCutGPTransferIN = PGTD.dblCutGPTransferIN
inner join productionbundleheader PBH ON PBD.intCutBundleSerial=PBH.intCutBundleSerial
where PGTH.intFactoryId='$companyId' and PGTD.dblCutGPTransferIN='$transferArry[1]' and PGTD.intGPTYear='$transferArry[0]'";
	if($cutNo!="")
		$sql_loadDetails .=" and PBH.intCutBundleSerial='$cutNo'";
	if($orderNo!="")
		$sql_loadDetails .=" and PBH.intStyleId='$orderNo'";
	$sql_loadDetails .=" order by PBH.strCutNo";

	$result_loadDetails = $db->RunQuery($sql_loadDetails);
	while($row=mysql_fetch_array($result_loadDetails))
	{
		if($row["dblBalQty"]==0)
			continue;
		$bundleSerial = $row["intCutBundleSerial"];
		$bundleNo	  = $row["dblBundleNo"];
		$bool		  = checkBundleAvailble($bundleSerial,$bundleNo);
		if(!$bool)
		{
			$ResponseXML .= "<strCutNo><![CDATA[" . $row["strCutNo"]  . "]]></strCutNo>\n";
			$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
			$ResponseXML .= "<dblBundleNo><![CDATA[" . $bundleNo  . "]]></dblBundleNo>\n";
			$ResponseXML .= "<dblQty><![CDATA[" . $row["dblBalQty"]  . "]]></dblQty>\n";
			$ResponseXML .= "<strShade><![CDATA[" . $row["strShade"]  . "]]></strShade>\n";
			$ResponseXML .= "<CutBundleSerial><![CDATA[" . $bundleSerial  . "]]></CutBundleSerial>\n";
		}
		
	}
	$ResponseXML .= "</XMLloadGatepassDetails>\n";
	echo $ResponseXML;		
}
if($Request=="getGatePassNo")
{
	$sql = "select intGPnumber from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$GatePassNo = $row["intGPnumber"];
	$sql_u = "update syscontrol set intGPnumber=intGPnumber+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	$FullgatePassNo = $GatePassNo.'/'.date('Y');
	echo $FullgatePassNo;
}
if($Request=="saveGatePassHeader")
{
	$pub_GPNo  	= $_GET["pub_GPNo"];
	$vehicleNo 	= $_GET["vehicleNo"];
	$palletNo 	= $_GET["palletNo"];
	$gpDate    	= $_GET["gpDate"];
	$toFactory 	= $_GET["toFactory"];
	$totQty    	= $_GET["totQty"];
	$reMarks  	= $_GET["reMarks"];
	$styleId   	= $_GET["styleId"];
	$reasonCode	= $_GET["ReasonCode"];
	
	$GPDateArray	 = explode('/',$gpDate);
	$formatedGPDate = $GPDateArray[2].'-'.$GPDateArray[1].'-'.$GPDateArray[0];
	$arrPub_GPNo   = explode('/',$pub_GPNo);
	
	$sql_check = "select intGPnumber,intYear,intStyleId from productiongpheader
					where intGPnumber='$arrPub_GPNo[0]' and intYear='$arrPub_GPNo[1]' and intStyleId='$styleId'; ";
	
	$result_check = $db->RunQuery($sql_check);
  if(mysql_num_rows($result_check)==0)
  {
	insertGPHeaderData($arrPub_GPNo[0],$arrPub_GPNo[1],$styleId,$formatedGPDate,$toFactory,$totQty,$vehicleNo,$palletNo,$reMarks,$reasonCode);	
  }
  else
  {
	updateGPHeaderData($arrPub_GPNo[0],$arrPub_GPNo[1],$styleId,$formatedGPDate,$toFactory,$totQty,$vehicleNo,$palletNo,$reMarks,$reasonCode);
  }

}
if($Request=="SaveGatePassDetails")
{
	$GPNo 			 = $_GET["GPNo"];
	$transferInNo	 = $_GET["transferInNo"];
	$cutBundleSerial = $_GET["cutBundleSerial"];
	$bundleNo 		 = $_GET["bundleNo"];
	$Qty 			 = $_GET["Qty"];
	$arrGPNo 		 = explode('/',$GPNo);
	$arrTINo		 = explode('/',$transferInNo);
	
	$sql_DetInsert = "insert into productiongpdetail 
						(intGPnumber, 
						intYear, 
						intCutBundleSerial, 
						dblBundleNo, 
						dblQty, 
						dblBalQty
						)
						values
						(
						$arrGPNo[0],
						$arrGPNo[1],
						$cutBundleSerial,
						$bundleNo,
						$Qty,
						$Qty
						)";
	$result = $db->RunQuery($sql_DetInsert);
	if($result)
		echo "Detail Saved";
	else
		echo "Error saving";
	
	$sql_updaterTin = "update productiongptindetail 
						set
						dblBalQty ='0'
						where
						dblCutGPTransferIN = '$arrTINo[1]' 
						and intGPTYear = '$arrTINo[0]' 
						and intCutBundleSerial = '$cutBundleSerial' 
						and dblBundleNo = '$bundleNo';";
	$result_updateTIn = $db->RunQuery($sql_updaterTin);
	update_production_wip($companyId,$cutBundleSerial,'intCutReturnQty',$Qty);
}
if($Request=="load_gp_list")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$GPNO 	  = $_GET["GPNO"];
	$GPNOArry = explode('/',$GPNO);
	$ResponseXML = "<XMLloadGatepassList>\n";
	
	$sql = "select PGH.dtmDate,intTofactory,strVehicleNo,strPalletNo,PGH.strRemarks,PGH.intStyleId,concat(PTD.intGPTYear,'/',PTD.dblCutGPTransferIN) as TINo,O.strOrderNo,intReasonCodeId
from productiongpheader PGH
inner join productiongpdetail PGD on PGH.intGPnumber=PGD.intGPnumber and PGH.intYear=PGD.intYear
inner join productiongptindetail PTD on PTD.intCutBundleSerial=PGD.intCutBundleSerial and PTD.dblBundleNo=PGD.dblBundleNo
inner join orders O on O.intStyleId=PGH.intStyleId
where strType='R'
and PGH.intGPnumber='$GPNOArry[0]'
and PGH.intYear='$GPNOArry[1]'";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{	
		$ResponseXML .= "<intTofactory><![CDATA[" . $row["intTofactory"]  . "]]></intTofactory>\n";
		$ResponseXML .= "<strVehicleNo><![CDATA[" . $row["strVehicleNo"]  . "]]></strVehicleNo>\n";
		$ResponseXML .= "<strPalletNo><![CDATA[" . $row["strPalletNo"]  . "]]></strPalletNo>\n";
		$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<TINo><![CDATA[" . $row["TINo"]  . "]]></TINo>\n";
		$date_array = explode("-",$row["dtmDate"]);
		$gp_date=$date_array[2]."/".$date_array[1]."/".$date_array[0];
		$ResponseXML .= "<gpdate><![CDATA[" . $gp_date . "]]></gpdate>\n";
		$ResponseXML .= "<ReasonCode><![CDATA[" . $row["intReasonCodeId"] . "]]></ReasonCode>\n";
	}	
	$ResponseXML .= "</XMLloadGatepassList>\n";
	echo $ResponseXML;	
}
if($Request=="load_gp_details")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$GPNO = $_GET["GPNO"];
	$GPNOArry = explode('/',$GPNO);
	$ResponseXML = "<XMLloadGatepassListDetail>\n";
	
	$sql_detail = "select PGD.intCutBundleSerial,PGD.dblBundleNo,PGD.dblQty,PBH.strCutNo,PBD.strSize,PBD.strShade
					from productiongpdetail PGD
					inner join productionbundleheader PBH on PBH.intCutBundleSerial=PGD.intCutBundleSerial
					inner join productionbundledetails PBD on PBD.intCutBundleSerial=PGD.intCutBundleSerial and PBD.dblBundleNo=PGD.dblBundleNo
					where intGPnumber='$GPNOArry[0]'
					and intYear='$GPNOArry[1]'";
					
	$result_detail = $db->RunQuery($sql_detail);
	while($row = mysql_fetch_array($result_detail))
	{	
		$ResponseXML .= "<CutBundleSerial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundleSerial>\n";
		$ResponseXML .= "<dblBundleNo><![CDATA[" . $row["dblBundleNo"]  . "]]></dblBundleNo>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<strCutNo><![CDATA[" . $row["strCutNo"]  . "]]></strCutNo>\n";
		$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
		$ResponseXML .= "<strShade><![CDATA[" . $row["strShade"]  . "]]></strShade>\n";
	}	
	$ResponseXML .= "</XMLloadGatepassListDetail>\n";
	echo $ResponseXML;	
	
}
function insertGPHeaderData($GatePassNo,$GatePassYear,$styleId,$formatedGPDate,$toFactory,$totQty,$vehicleNo,$palletNo,$reMarks,$reasonCode)
{
	global $db;
	global $userId;
	global $companyId;
	$sql_insert = "insert into productiongpheader 
					(
					intGPnumber, 
					intYear, 
					intStyleId, 
					dtmDate, 
					intFromFactory, 
					intTofactory, 
					dblTotQty, 
					dblTotBalQty, 
					strType, 
					intUserId, 
					strVehicleNo, 
					strPalletNo, 
					strRemarks,
					intReasonCodeId
					)
					values
					(
					'$GatePassNo',
					'$GatePassYear',
					'$styleId',
					'$formatedGPDate',
					'$companyId',
					'$toFactory',
					'$totQty',
					'$totQty',
					'R',
					'$userId',
					'$vehicleNo',
					'$palletNo',
					'$reMarks',
					'$reasonCode');";
	$result_ins = $db->RunQuery($sql_insert);
	if($result_ins)
		echo "Header Saved";
	else
		echo "Error saving";
}
function updateGPHeaderData($GatePassNo,$GatePassYear,$styleId,$formatedGPDate,$toFactory,$totQty,$vehicleNo,$palletNo,$reMarks,$reasonCode)
{
	global $db;
	$sql_update = "update productiongpheader 
					set
					dtmDate = '$formatedGPDate' , 
					intTofactory = '$toFactory' , 
					dblTotQty = '$totQty' , 
					dblTotBalQty = '$totQty' , 
					strVehicleNo = '$vehicleNo' , 
					strPalletNo = '$palletNo' , 
					strRemarks = '$reMarks',
					intReasonCodeId = '$reasonCode'
					where
					intGPnumber = '$GatePassNo' and intYear = '$GatePassYear' and intStyleId = '$styleId' ;";
	$result_upd = $db->RunQuery($sql_update);
	if($result_upd)
		echo "Header Updated";
	else
		echo "Error updating";
}
function checkBundleAvailble($bundleSerial,$bundleNo)
{
	global $db;
	//$sql = "select intLineInputSerial from productionlineindetail where intCutBundleSerial='$bundleSerial' and dblBundleNo='$bundleNo'";
	$sql="select PLD.intLineInputSerial from productionlineindetail PLD 
inner join productionlineinputheader PLH on PLH.intLineInputSerial=PLD.intLineInputSerial and PLH.intLineInputYear=PLD.intLineInputYear
where PLD.intCutBundleSerial='$bundleSerial' and PLD.dblBundleNo='$bundleNo' and PLH.intStatus<>10";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
		return true;
	else
		return false;
}	
?>