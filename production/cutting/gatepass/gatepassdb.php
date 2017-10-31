<?php
	session_start();
	include "../../../Connector.php";	
	include "../../production.php";
	header('Content-Type: text/xml'); 	
	$request=$_GET["request"];
	$report_companyId  = $_SESSION["FactoryID"];
	if ($request=='filter')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyer=$_GET['buyer'];
	
	
	$str="select  scch.intStyleId,strOrderNo from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId
where intBuyerID='$buyer' and  orders.intStatus=11 order by strOrderNo";
	
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$XMLString .= "<Style><![CDATA[" . $row["strOrderNo"]  . "]]></Style>\n";
		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getcutz')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$Style=$_GET['Style'];
	
	
	$str="select intCutBundleSerial, strCutNo, dblTotalQty from productionbundleheader where intStyleId='$Style' order by dtmCutDate desc";
	
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<serial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></serial>\n";
		$XMLString .= "<cutNO><![CDATA[" . $row["strCutNo"]  . "]]></cutNO>\n";
		$XMLString .= "<Tot_Qty><![CDATA[" . $row["dblTotalQty"] . "]]></Tot_Qty>\n";
		$XMLString .= "<cut_gp_status><![CDATA[" . check_cut_gp_status($row["intCutBundleSerial"]) . "]]></cut_gp_status>\n";
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getsizes')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial=$_GET['serial'];
	
	
	$str="select strSize,intCutBundleSerial,strShade,dblBundleNo,dblPcs,intStatus from productionbundledetails where intCutBundleSerial ='$serial' order by strSize";
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<serial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></serial>\n";
		$XMLString .= "<size><![CDATA[" . $row["strSize"]  . "]]></size>\n";
		$XMLString .= "<shade><![CDATA[" . $row["strShade"]  . "]]></shade>\n";
		$XMLString .= "<bundle><![CDATA[" . $row["dblBundleNo"]  . "]]></bundle>\n";
		$XMLString .= "<pcs><![CDATA[" . $row["dblPcs"]  . "]]></pcs>\n";
		$XMLString .= "<status><![CDATA[" . $row["intStatus"]  . "]]></status>\n";
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='saveheader')
{
		$str_gpno="select intGPnumber from syscontrol where intCompanyID='$report_companyId'";
		$result_gpno=$db->RunQuery($str_gpno);
		$str_syscontrol="update syscontrol set intGPnumber = intGPnumber+1 where intCompanyID='$report_companyId'";
		$result_syscontrol=$db->RunQuery($str_syscontrol);
		$row_gpno=mysql_fetch_array($result_gpno);
		$gpnumber=$row_gpno["intGPnumber"];
		$gpdate=$_GET["gpdate"];
		$totqty=$_GET["totqty"];
		$Styleno=$_GET["Styleno"];
		$PalletNo=$_GET["PalletNo"];
		$Vehicle=$_GET["Vehicle"];
		$tofactory=$_GET["tofactory"];
		$gpdate=($gpdate!=""? $gpdate:date("d/m/Y"));
		$datearray=explode("/",$gpdate);
		$gpdate=$datearray[2]."-".$datearray[1]."-".$datearray[0];
		$gpyear=date("Y");
		$userid=$_SESSION["UserID"];
		$transactiontype='GP';
		$str="insert into productiongpheader 
							(intGPnumber, 
							intYear, 
							intStyleId, 
							dtmDate, 
							intFromFactory, 
							intTofactory, 
							dblTotQty,
							strType, 
							intUserId,
							strVehicleNo,
							strPalletNo
							)
							values
							('$gpnumber', 
							'$gpyear', 
							'$Styleno', 
							'$gpdate', 
							'$report_companyId ', 
							'$tofactory', 
							'$totqty', 
							'I', 
							'$userid',
							'$Vehicle',
							'$PalletNo'
							);";
							
		$result = $db->RunQuery($str); 
		if($result)
		{	
			echo $gpnumber;
		}
		else echo "Error!";
}

if ($request=='savedetail')
{
	$gpnumber=$_GET["gpnumber"];
	$bundle=$_GET["cutno"];
	$serial=$_GET["serial"];
	$factory=$_GET["tofactory"];
	$gpyear=date("Y");
	$str_qty="select dblPcs from productionbundledetails where intCutBundleSerial='$serial' and dblBundleNo='$bundle'";
	$results_qty=$db->RunQuery($str_qty);
	$row_qty=mysql_fetch_array($results_qty);
	$qty=$row_qty['dblPcs'];
	$qty=($qty?$qty:0);
	
			$str="insert into productiongpdetail 
						(intGPnumber, 
						intYear, 
						intCutBundleSerial, 
						dblBundleNo, 
						dblQty, 
						dblBalQty
						)
						values
						('$gpnumber', 
						'$gpyear', 
						'$serial', 
						'$bundle', 
						'$qty', 
						'$qty');";
				$result = $db->RunQuery($str); 
				if($result)
				{ 
					$str_status="update productionbundledetails set intStatus='2' where intCutBundleSerial='$serial' and dblBundleNo='$bundle'";
					$result_status=$db->RunQuery($str_status); 
					$str_for_wip="select 	intCutBundleSerial,intStyleId,strColor,strFromFactory,dblTotalQty from productionbundleheader where  intCutBundleSerial='$serial'";
					$result_for_wip=$db->RunQuery($str_for_wip);
					$row_for_wip=mysql_fetch_array($result_for_wip);
					//wip_update($row_for_wip["intStyleId"],$row_for_wip["strColor"],$factory,$qty,$row_for_wip["strFromFactory"],$row_for_wip["dblTotalQty"]);
					update_production_wip($factory,$serial,"intCutIssueQty",$qty);
					echo "saved";		
						
				}
			
}


if ($request=='tofac')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$tofactory=$_GET['tofactory'];
	
	if($tofactory=='IN')
		$str="select intCompanyID as facid,strName from companies order by strName  ";
	if($tofactory=='EX')
		$str="select strSubContractorID as facid,strName from subcontractors order by strName ";
	$XMLString= "<Data>";
	$XMLString .= "<factory>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<facid><![CDATA[" . $row["facid"]  . "]]></facid>\n";
		$XMLString .= "<facname><![CDATA[" . $row["strName"]  . "]]></facname>\n";
	}
	
	$XMLString .= "</factory>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if($request=='saveVerify')
{
		$gpnumber=$_GET["gpnumber"];
		$pub_records=$_GET["pub_records"];
		$gpyear=date("Y");
		
		$str="select 	count(intCutBundleSerial) as records_count from	productiongpdetail where intGPnumber='$gpnumber' and intYear='$gpyear'";
		$results=$db->RunQuery($str);
		$row=mysql_fetch_array($results);
		if($pub_records==$row['records_count'])
			echo "saved";
}

/*function wip_update($style,$color,$factory,$qty,$frmfactory,$totqty)
{
	global $db;

$str_check_wip="select 	intStyleID from productionwip where intStyleID='$style' and strColor='$color' and intDestinationFactroyID = '$factory'";
				$results_check_wip=$db->RunQuery($str_check_wip);
				$row_check_wip=mysql_num_rows($results_check_wip);
					if($row_check_wip>0)
						{
							$str_edit_wip="update productionwip 
											set	
											intCutIssueQty =intCutIssueQty+ '$qty' 	
											where
											intStyleID = '$style' and strColor = '$color' and intDestinationFactroyID = '$factory' ;
										";
						}
					else
						{
							$str_edit_wip="insert into productionwip 
											(intStyleID, 
											strColor, 
											strSeason, 
											intSourceFactroyID, 
											intDestinationFactroyID, 
											intOrderQty, 
											intCutQty,
											intCutIssueQty											
											)
											values
											('$style', 
											'$color', 
											'SEASON', 
											'$frmfactory', 
											'$factory', 
											'$totqty', 
											'$totqty',
											'$qty'
											);";
						
						}
						
$result_check="ok";
$wip_run=$db->RunQuery($str_edit_wip);
//return $str_check_wip;
}*/
if ($request=='get_style_buyer')
{	

	$style=$_GET['style'];
	
	$str="select intBuyerID from orders where intStyleId='$style'";
	
	$result = $db->RunQuery($str); 
	$row=mysql_fetch_array($result);		
	echo $row["intBuyerID"];
}
if ($request=='load_gp_list')
{	

	$gp=$_GET['gp'];
	$gp_array=explode("/",$gp);
	$gp_number=$gp_array[1];
	$gp_year=$gp_array[0];
	$str="select PGPH.intGPnumber,PGPH.intYear,PGPH.intStyleId,PGPH.dtmDate,PGPH.intFromFactory,PGPH.intTofactory,PGPH.dblTotQty,PGPH.dblTotBalQty,PGPH.strTransInSt,PGPH.intStatus,PGPH.strType,PGPH.intUserId,
	(select Name from useraccounts UA where UA.intUserID=PGPH.intUserId)as userName,
	PGPH.strVehicleNo,PGPH.strPalletNo,O.intBuyerID 
	from productiongpheader PGPH 
	inner join orders O on O.intStyleId=PGPH.intStyleId 
	where PGPH.intGPnumber='$gp_number' and PGPH.intYear='$gp_year'";
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";

	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$XMLString .= "<FromFactory><![CDATA[" . $row["intFromFactory"]  . "]]></FromFactory>\n";
		$XMLString .= "<Tofactory><![CDATA[" . $row["intTofactory"]  . "]]></Tofactory>\n";
		$XMLString .= "<VehicleNo><![CDATA[" . $row["strVehicleNo"]  . "]]></VehicleNo>\n";
		$XMLString .= "<PalletNo><![CDATA[" . $row["strPalletNo"]  . "]]></PalletNo>\n";
		$date_array=explode("-",$row["dtmDate"]);
		$gp_date=$date_array[2]."/".$date_array[1]."/".$date_array[0];
		$XMLString .= "<gpdate><![CDATA[" . $gp_date . "]]></gpdate>\n";
		$XMLString .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
		$XMLString .= "<BuyerId><![CDATA[" . $row["intBuyerID"] . "]]></BuyerId>\n";
		$XMLString .= "<UserName><![CDATA[" . $row["userName"] . "]]></UserName>\n";
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
	
}

if ($request=='load_gp_details')
{	

	$gp=$_GET['gp'];
	$gp_array=explode("/",$gp);
	$gp_number=$gp_array[1];
	$gp_year=$gp_array[0];
	$str_details="select 	gpd.intGPnumber, 
					pbd.strSize,
					pbd.dblPcs,	
					pbd.strShade,	
					gpd.intYear, 
					gpd.intCutBundleSerial, 
					gpd.dblBundleNo, 
					gpd.dblQty, 
					gpd.dblBalQty,
					pbh.intStyleId,
					orrds.strStyle,
					orrds.strOrderNo,
					pbh.strCutNo
					from 
					productiongpdetail gpd left join productionbundledetails pbd on pbd.intCutBundleSerial = gpd.intCutBundleSerial	
					and pbd.dblBundleNo = gpd.dblBundleNo 
					left join productionbundleheader pbh on pbh.intCutBundleSerial = gpd.intCutBundleSerial 
					inner join orders orrds on pbh.intStyleId =orrds.intStyleId 
					where  gpd.intGPnumber='$gp_number' and gpd.intYear='$gp_year' order by pbh.intStyleId,pbh.strCutNo,pbd.strSize;";
	  
	$results_details=$db->RunQuery($str_details);	
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($results_details))
	{	
		$XMLString .= "<serial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></serial>\n";
		$XMLString .= "<size><![CDATA[" . $row["strSize"]  . "]]></size>\n";
		$XMLString .= "<shade><![CDATA[" . $row["strShade"]  . "]]></shade>\n";
		$XMLString .= "<bundle><![CDATA[" . $row["dblBundleNo"]  . "]]></bundle>\n";
		$XMLString .= "<pcs><![CDATA[" . $row["dblPcs"]  . "]]></pcs>\n";
		$XMLString .= "<status><![CDATA[" . $row["intStatus"]  . "]]></status>\n";
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
	
}

if ($request=='URLValidateCancel')
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$gatePassNo		= $_GET['GatePassNo'];
$gatePassNo		= explode('/',$gatePassNo);
$XMLString 		= "<URLValidateCancel>";
	$str="select count(dblCutGPTransferIN)as count from productiongptinheader where intGPnumber='$gatePassNo[1]' and intGPYear='$gatePassNo[0]'";
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		if($row["count"]>0)
			$XMLString .= "<Validate><![CDATA[FALSE]]></Validate>\n";
		else
			$XMLString .= "<Validate><![CDATA[TRUE]]></Validate>\n";
	}
$XMLString 		.= "</URLValidateCancel>";
echo $XMLString;
}
if ($request=='URLCancelGP')
{
$gatePassNo		= $_GET['GatePassNo'];
$gatePassNo		= explode('/',$gatePassNo);
	
	$str="update productiongpheader set intStatus=10 where intGPnumber='$gatePassNo[1]' and intYear='$gatePassNo[0]'";	
	$result = $db->RunQuery($str); 
	$str="update productiongpdetail set dblBalQty=0 where intGPnumber='$gatePassNo[1]' and intYear='$gatePassNo[0]'";	
	$result = $db->RunQuery($str); 
	$str="select intCutBundleSerial,dblBundleNo from productiongpdetail where intGPnumber='$gatePassNo[1]' and intYear='$gatePassNo[0]'";	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$sql1="update productionbundledetails set intStatus=0 where intCutBundleSerial='".$row["intCutBundleSerial"]."' and dblBundleNo='".$row["dblBundleNo"]."'";		
		$db->RunQuery($sql1); 
	}
}

function check_cut_gp_status($cut)
{
	global $db;
	$str_check_status="select intCutBundleSerial from productionbundledetails where intCutBundleSerial='$cut' and intStatus=2";
	$result_check_status=$db->RunQuery($str_check_status);
	if(mysql_num_rows($result_check_status)>0)	
		return 'complete';	
	
	else
		return 'incomplete';
		
}

?>