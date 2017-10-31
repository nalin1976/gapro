<?php
	session_start();
	include "../../Connector.php";	
	header('Content-Type: text/xml'); 	
	$request=$_GET["request"];
	
	if ($request=='filter')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyer=$_GET['buyer'];
	
	
	$str="select 	intStyleId, strStyle from orders where intBuyerID='$buyer' order by strStyle";
	
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$XMLString .= "<Style><![CDATA[" . $row["strStyle"]  . "]]></Style>\n";
		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getcutz')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$Style=$_GET['Style'];
	
	
	$str="select intCutBundleSerial, strCutNo, dblTotalQty from productionbundleheader where intStyleId='$Style'";
	
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<serial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></serial>\n";
		$XMLString .= "<cutNO><![CDATA[" . $row["strCutNo"]  . "]]></cutNO>\n";
		$XMLString .= "<Tot_Qty><![CDATA[" . $row["dblTotalQty"] . "]]></Tot_Qty>\n";
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getsizes')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial=$_GET['serial'];
	
	
	$str="select strSize,intCutBundleSerial,strShade,dblBundleNo,dblPcs from productionbundledetails where intCutBundleSerial ='$serial' ";
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
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getcomponents')
{
	$style=$_GET['style'];
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial=$_GET['serial'];
	
	
$str="select sccd.intStyleId,sccd.intCategoryId,sccd.intComponentId,cc.strComponent from style_cut_compo_dtl sccd 
inner join   cutting_component cc on sccd.intComponentId=cc.intComponentId and sccd.intCategoryId=cc.intCategory
where intStyleId='$style'";
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<catid><![CDATA[" . $row["intCategoryId"]  . "]]></catid>\n";
		$XMLString .= "<componentid><![CDATA[" . $row["intComponentId"]  . "]]></componentid>\n";
		$XMLString .= "<component><![CDATA[" . $row["strComponent"]  . "]]></component>\n";
		
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='saveheader')
{
		$str_gpno="select intDefectSerial from syscontrol";
		$result_gpno=$db->RunQuery($str_gpno);
		$str_syscontrol="update syscontrol set intDefectSerial = intDefectSerial+1";
		$result_syscontrol=$db->RunQuery($str_syscontrol);
		$row_gpno=mysql_fetch_array($result_gpno);
		$serial=$row_gpno["intDefectSerial"];
		$defectdate=$_GET["defectdate"];
		$factory=$_GET["factory"];
		$defectdate=($defectdate!=""? $defectdate:date("d/m/Y"));
		$datearray=explode("/",$defectdate);
		$defectdate=$datearray[2]."-".$datearray[1]."-".$datearray[0];
		$serialyear=date("Y");
		$stage=$_SESSION["stage"];
		$userid=$_SESSION["UserID"];
		
		$str="insert into productiondefectheader 
							(intDefectSerial, 
							intDefectYear, 
							intFactoryId, 
							dtmDate, 
							strStage, 
							intUserId
							)
							values
							('$serial', 
							'$serialyear', 
							'$factory', 
							'$defectdate', 
							'$stage', 
							'$userid'
							);	";
							
		$result = $db->RunQuery($str); 
		if($result)
		{
						
			echo $serial;
		}
		else echo "Error!";
}

if ($request=='savedetail')
{
	$bundleserial=$_GET["bundleserial"];
	$bundle=$_GET["bundle"];
	$cat_id=$_GET["cat_id"];
	$component_id=$_GET["component_id"];
	$defect_qty=$_GET["defect_qty"];
	$serial=$_GET["serial"];
	$serial_year=date("Y");
				$str="insert into productiondefectdetail 
							(intDefectSerial, 
							intDefectYear, 
							intCutBundleSerial, 
							dblBundleNo, 
							intCategoryId, 
							intComponentId, 
							dblQty
							)
							values
						   ('$serial', 
							'$serial_year', 
							'$bundleserial', 
							'$bundle', 
							'$cat_id', 
							'$component_id', 
							'$defect_qty'
							);";
				$result = $db->RunQuery($str); 
				
				if($result)
				{ 
					$str_status="update productionbundledetails set intStatus='11' where intCutBundleSerial='$bundleserial' and dblBundleNo='$bundle'";
					$result_status=$db->RunQuery($str_status); 
					/*$str_for_wip="select 	intCutBundleSerial,intStyleId,strColor,strFromFactory,dblTotalQty from productionbundleheader where  intCutBundleSerial='$serial'";
					$result_for_wip=$db->RunQuery($str_for_wip);
					$row_for_wip=mysql_fetch_array($result_for_wip);
					wip_update($row_for_wip["intStyleId"],$row_for_wip["strColor"],$factory,$qty,$row_for_wip["strFromFactory"],$row_for_wip["dblTotalQty"]);*/
					echo 'saved';		
						
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

function wip_update($style,$color,$factory,$qty,$frmfactory,$totqty)
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
}



?>