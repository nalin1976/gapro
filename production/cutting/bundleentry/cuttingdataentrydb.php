<?php
	session_start();
	include "../../../Connector.php";	
	header('Content-Type: text/xml'); 	
	$request		=$_GET["request"];
	$c_company		=$_SESSION["FactoryID"];
	$sys_user		=$_SESSION["UserID"];
	if ($request=='filter')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyer=$_GET['buyer'];
	
	if($buyer!="")
	{
	$str="select  scch.intStyleId,concat(strOrderNo,'/ ',strStyle) as strOrderNo from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId
where intBuyerID='$buyer' and  orders.intStatus=11 order by strOrderNo";
	}
	else
	{
	$str="select  scch.intStyleId,concat(strOrderNo,'/ ',strStyle) as strOrderNo from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId  where orders.intStatus=11 order by strOrderNo";
	}
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$XMLString .= "<Style><![CDATA[" . $row["strOrderNo"]  . "]]></Style>\n";
		//$XMLString .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}
	
	if ($request=='filterColor')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$Style=$_GET['Style'];
	
	
	$str="select distinct strColor from styleratio where intStyleId='$Style'order by strColor";
	
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='filterSize')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$Style=$_GET['Style'];
	$color=$_GET['color'];
	
	
	$str="select 	intStyleId, 
					strSize 
					from 
					styleratio 
					where intStyleId='$Style'and strColor='$color' order by strSize";
				
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if($request=='saveHeader')
{	
		
		$style=$_GET['style'];
		reset_bundlenos($style);
		$str_serial="select 	intCutBundleSerial, intNumberRange from syscontrol where intCompanyID='$c_company'";
		$result_serial=$db->RunQuery($str_serial);		
		$row_serail=mysql_fetch_array($result_serial);
		
		$str_bundle="select intBundleNo,intNumberRange from style_cut_compo_header where intStyleId='$style'";
		$result_bundle=$db->RunQuery($str_bundle);		
		$row_bundle=mysql_fetch_array($result_bundle);
		
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$XMLString= "<Data>";
		$XMLString .= "<cut>";
		$buyer=$_GET['buyer'];
		$color=$_GET['color'];
		$from_factory=$_GET['from_factory'];
		$cutdate=$_GET['cutdate'];
		$cutno=$_GET['cutno'];
		$garment=$_GET['garment'];
		$invoiceno=$_GET['invoiceno'];
		$markerlength=$_GET['markerlength'];
		$patternno=$_GET['patternno'];
		$plyheight=$_GET['plyheight'];
		$shifts=$_GET['shifts'];
		$size=$_GET['size'];		
		$bundles=$_GET["bundles"];
		$tofactory=$_GET['tofactory'];
		$pcs=$_GET['pcs'];
		$bundle_serial=$row_serail["intCutBundleSerial"];
		$spreader=$_GET['spreader'];
		$totpcs=$_GET['totpcs'];
		$cut_type=$_GET['cut_type'];
		$cutdate_array=explode("/",$cutdate);
		$cutdate=$cutdate_array[2]."-".$cutdate_array[1]."-".$cutdate_array[0];
		$str_update="update syscontrol set intCutBundleSerial=intCutBundleSerial+1, intNumberRange=intNumberRange+$totpcs,dblBundleNo=dblBundleNo+$bundles where intCompanyID='$c_company'";
		$result_update=$db->RunQuery($str_update);
		
		$str_update_bundle="update style_cut_compo_header set intBundleNo=intBundleNo+$bundles,intNumberRange=intNumberRange +$totpcs where intStyleId='$style'";
		$result_update_bundle=$db->RunQuery($str_update_bundle);
		
		$str="insert into productionbundleheader 
						(intCutBundleSerial, 
						strFromFactory, 
						strToFactory, 
						strShift, 
						dtmCutDate, 
						strPatternNo, 
						strPOno, 
						intStyleId, 
						strCutNo, 
						strColor, 
						dblTotalQty, 
						strStatus, 
						strPlyHeight, 
						strMarkerLength, 
						strSpreader, 
						strInvoiceNo, 
						intPCS,
						intUserId,
						cut_type
						)
						values
						($bundle_serial, 
						'$from_factory', 
						'$tofactory', 
						'$shifts', 
						'$cutdate', 
						'$patternno', 
						'PO', 
						'$style', 
						'$cutno', 
						'$color', 
						'$totpcs', 
						1, 
						'$plyheight', 
						'$markerlength', 
						'$spreader', 
						'$invoiceno', 
						'$pcs',
						'$sys_user',
						'$cut_type'						
						);";
		$result=$db->RunQuery($str);
		if($result)
		{
			if($cut_type=='1' || $cut_type=='6' || $cut_type=='7' || $cut_type=='10' || $cut_type=='11')
				update_wip($style,$tofactory,$totpcs);
				
				$str_check_wip="select 	intStyleID from productionwip where intStyleID='$style' and strColor='$color' and intDestinationFactroyID = '$tofactory'";
				$results_check_wip=$db->RunQuery($str_check_wip);
				$row_check_wip=mysql_num_rows($results_check_wip);
					if($row_check_wip>0)
						{
							$str_edit_wip="update productionwip 
											set	
											intOrderQty =intOrderQty+ '$totpcs' , 
											intCutQty =intCutQty+ '$totpcs' 	
											where
											intStyleID = '$style' and strColor = '$color' and intDestinationFactroyID = '$tofactory' ;
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
											intCutQty
											
											)
											values
											('$style', 
											'$color', 
											'SEASON', 
											'$from_factory', 
											'$tofactory', 
											'$totpcs', 
											'$totpcs');";
						
						}
				$result_check="ok";
				$wip_run=$db->RunQuery($str_edit_wip);
				/*$str_update="update syscontrol set intCutBundleSerial=intCutBundleSerial+1";
				$result_update=$db->RunQuery($str_update);*/
				
				
					
					$XMLString .= "<serial><![CDATA[" . $row_serail["intCutBundleSerial"]  . "]]></serial>\n";	
					$XMLString .= "<bundleno><![CDATA[" . $row_bundle["intBundleNo"]  . "]]></bundleno>\n";	
					$XMLString .= "<numrange><![CDATA[" . $row_bundle["intNumberRange"]  . "]]></numrange>\n";		
					$XMLString .= "<resultz><![CDATA[".$result_check."]]></resultz>\n";	
									
		}
		else
			$XMLString .= "<resultz><![CDATA[no]]></resultz>\n";	
$XMLString .= "</cut>";
$XMLString .= "</Data>";
echo $XMLString;
}
if($request=='saveDetail')
{
		$bundle_serial=$_GET["bundle_serial"];
		$pcs=$_GET["pcs"];
		$shade=$_GET["shade"];
		$size=$_GET["size"];
		$num_range=$_GET["num_range"];
		$bundleno=$_GET["bundleno"];
		$style=$_GET["style"];
		$layno=$_GET["layno"];
		
		$str="insert into productionbundledetails 
					(intCutBundleSerial,
					dblBundleNo,
					strSize,
					intLayNo, 
					dblPcs, 
					strNoRange, 
					strShade
					)
					values
					('$bundle_serial',
					'$bundleno', 
					'$size',
					'$layno', 
					'$pcs', 
					'$num_range', 
					'$shade');";
		$results=$db->RunQuery($str);
		if($results)
		{
			$str_compo="select intCategoryId,intComponentId from style_cut_compo_dtl where intStyleId='$style' order by intserial";
			$result_compo=$db->RunQuery($str_compo);
			
		while($row_comp=mysql_fetch_array($result_compo))
					{
						$category=$row_comp["intCategoryId"];
						$compoid=$row_comp["intComponentId"];
						$str_subdetails="insert into productionbundlesubdetail 
										(intCutBundleSerial, 
										dblBundleNo, 
										intCategoryId,
										intComponentId	
										)
										values
										('$bundle_serial', 
										'$bundleno', 
										'$category', 
										'$compoid'	
										);";
						$resilt_subdetails=$db->RunQuery($str_subdetails);
		
					}
		}
}

if($request=='saveVerify')
{
		$bundle_serial=$_GET["bundle_serial"];
		$pub_records=$_GET["pub_records"];
		
		$str="select 	count(intCutBundleSerial) as records_count from	productionbundledetails where intCutBundleSerial='$bundle_serial'";
		$results=$db->RunQuery($str);
		$row=mysql_fetch_array($results);
		if($pub_records==$row['records_count'])
			echo "ok";
}

if($request=='syscontrol')
{
		/*$number_range=$_GET["number_range"];
		$pub_bundle_no=$_GET["pub_bundle_no"];
		$str_update="update syscontrol set intNumberRange='$number_range',dblBundleNo='$pub_bundle_no'";
		$result_update=$db->RunQuery($str_update);
		if ($result_update)*/
			echo 'ok';
		
}

if ($request=='getCutNoz')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['styleid'];
	
	
	
	$str="select strCutNo from productionbundleheader where intStyleId='$style'";
		
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<CutNo><![CDATA[" . $row["strCutNo"]  . "]]></CutNo>\n";		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getsizetoedit')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial=$_GET['serial'];	
	
	$str="select distinct strSize from productionbundledetails  where intCutBundleSerial='$serial'";
		
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	$size_array=explode("-",$row["strSize"]);
		$sizes=$size_array[0];
		$shade=$size_array[1];
		$XMLString .= "<size><![CDATA[" . $sizes  . "]]></size>\n";
		$XMLString .= "<shade><![CDATA[" . $shade  . "]]></shade>\n";		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
}

if ($request=='getlayertoedit')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial=$_GET['serial'];	
	
	$str="select  intCutBundleSerial,strShade,dblPcs from productionbundledetails where intCutBundleSerial='$serial' group by intCutBundleSerial,intLayNo order by intLayNo ";
		
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{			
		$XMLString .= "<shade><![CDATA[" . $row["strShade"] . "]]></shade>\n";		
		$XMLString .= "<Pcs><![CDATA[" . $row["dblPcs"]  . "]]></Pcs>\n";
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
}

if ($request=='delallcut')
{
	$serial=$_GET['serial'];
	$str_check="select intCutBundleSerial from productionbundledetails where intCutBundleSerial = '$serial' and intStatus=2 ;";
	$result_check=$db->RunQuery($str_check);
	if(mysql_num_rows($result_check)==0)
	{
		$str="SELECT
				  intStyleId,
				  dblTotalQty,
				  cut_type
				FROM productionbundleheader
				WHERE intCutBundleSerial = $serial";
		$result=$db->RunQuery($str);
		$dataset=mysql_fetch_array($result);
		$styleid=$dataset["intStyleId"];
		$TotalQty=$dataset["dblTotalQty"];
		$cut_type=$dataset["cut_type"];
		
		$str="	delete from productionbundleheader where intCutBundleSerial = '$serial';";			
		$result=$db->RunQuery($str);
		$str="delete from productionbundledetails where	intCutBundleSerial = '$serial' ;";
		$result=$db->RunQuery($str);
		$str="delete from productionbundlesubdetail where intCutBundleSerial = '$serial' ;";
		$result=$db->RunQuery($str);	
			if($result){
				if($cut_type=='1' || $cut_type=='6' || $cut_type=='7' || $cut_type=='10' || $cut_type=='11')
				del_update_wip($styleid,$TotalQty);
				echo "Deleted successfully.";				
			}
			else
				echo "error";
	}
	else 
		echo "Sorry! you cannot delete this cut.";
			
}

if ($request=='saveSizeChange')
{
	$serial=$_GET['serial'];
	$size=$_GET['size'];
	$new_size=$_GET['newsize'];
	$str="	update productionbundledetails 	set strSize = '$new_size' where intCutBundleSerial = '$serial' and strSize = '$size' ;";			
	$result=$db->RunQuery($str);
	if($result)
	echo "Updated successfully.";
	else
	echo "error";
}

if ($request=='getStyleQtys')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];	
	$cuttype=$_GET['cuttype'];	
	
	$str="select intQty,reaExPercentage from orders where intStyleId='$style'";
		
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{			
		$XMLString .= "<cutqty><![CDATA[" . $row["intQty"] . "]]></cutqty>\n";		
		$XMLString .= "<ExPercentage><![CDATA[" . $row["reaExPercentage"] . "]]></ExPercentage>\n";	
		$XMLString .= "<orderqty><![CDATA[" . $row["intQty"]  . "]]></orderqty>\n";
		
	}
	$XMLString .= "<accumulated><![CDATA[" . get_accum_CutQty($style,$cuttype)  . "]]></accumulated>\n";
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
}

function get_accum_CutQty($style,$type)
{	
	$type=($type==''?1:$type);
	global $db;
	$str="select sum(dblTotalQty) as dblTotalQty from productionbundleheader where intStyleId='$style' and cut_type='$type' group by intStyleId";
	$result = $db->RunQuery($str); 
	$row = mysql_fetch_array($result);
	$total_accum_qty=$row['dblTotalQty'];	
	return $total_accum_qty;
}

if ($request=='getHeaderdata')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$serial=$_GET['serial'];	

			$str="select 	intCutBundleSerial, 
			strFromFactory, 
			strToFactory, 
			strShift, 
			dtmCutDate, 
			strPatternNo, 
			strPOno, 
			intStyleId, 
			strCutNo, 
			strColor, 
			dblTotalQty, 
			strStatus, 
			strPlyHeight, 
			strMarkerLength, 
			strSpreader, 
			strInvoiceNo, 
			intPCS,
			cut_type
			 
			from 
			productionbundleheader  where intCutBundleSerial='$serial' ";
		
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	$cutdate_array=explode("-",$row["dtmCutDate"] );
		$cutdate=$cutdate_array[2]."/".$cutdate_array[1]."/".$cutdate_array[0];		
		$XMLString .= "<FromFactory><![CDATA[" . $row["strFromFactory"] . "]]></FromFactory>\n";		
		$XMLString .= "<ToFactory><![CDATA[" . $row["strToFactory"]  . "]]></ToFactory>\n";
		$XMLString .= "<Shift><![CDATA[" . $row["strShift"]  . "]]></Shift>\n";
		$XMLString .= "<cutdate><![CDATA[" . $cutdate . "]]></cutdate>\n";
		$XMLString .= "<PatternNo><![CDATA[" . $row["strPatternNo"]  . "]]></PatternNo>\n";
		$XMLString .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$XMLString .= "<PlyHeight><![CDATA[" . $row["strPlyHeight"]  . "]]></PlyHeight>\n";
		$XMLString .= "<MarkerLength><![CDATA[" . $row["strMarkerLength"]  . "]]></MarkerLength>\n";
		$XMLString .= "<Spreader><![CDATA[" . $row["strSpreader"]  . "]]></Spreader>\n";
		$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$XMLString .= "<cut_type><![CDATA[" . $row["cut_type"]  . "]]></cut_type>\n";

		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
}

if ($request=='load_SW_Qtys')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	$size=$_GET['size'];	
	$color=$_GET['color'];		
	$SW_Order_Qty=get_SW_OrdQty($style,$size,$color);	
	$SW_Cut_Qty=get_SW_CutQty($style,$size,$color);			
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
		
		$XMLString .= "<SW_Order_Qty><![CDATA[" . $SW_Order_Qty. "]]></SW_Order_Qty>\n";		
		$XMLString .= "<SW_Cut_Qty><![CDATA[" . $SW_Cut_Qty  . "]]></SW_Cut_Qty>\n";
		
		
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
	
}

function get_SW_OrdQty($style,$size,$color)
{
	global $db;
	$str="select sum(dblQty) as SWQty from styleratio where intStyleId='$style' and strSize='$size' and strColor='$color'";
	$result = $db->RunQuery($str); 
	$row = mysql_fetch_array($result);
	return $row["SWQty"]; 
}


function get_SW_CutQty($style,$size,$color)
{
	global $db;
	$size=$size.'-%';
	$total_size_qty=0;
	$str="select intCutBundleSerial from productionbundleheader where intStyleId='$style' and strColor='$color'";
	$result = $db->RunQuery($str); 
	while ($row = mysql_fetch_array($result))
	{	
		$total_size_qty+=cal_size_qty($size,$row['intCutBundleSerial']);
	}
	return $total_size_qty;
}


function cal_size_qty($size,$serial)
{
	global $db;
	$str	 ="select sum(dblPcs) as qty from productionbundledetails where intCutBundleSerial='$serial' and strSize like '$size'";
	$result  = $db->RunQuery($str); 
	$row	 = mysql_fetch_array($result);
	$qty	 = 	$row["qty"];
	return $qty;

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
if ($request=='get_style_buyer')
{	

	$style=$_GET['style'];
	
	$str="select intBuyerID from orders where intStyleId='$style'";
	
	$result = $db->RunQuery($str); 
	$row=mysql_fetch_array($result);		
	echo $row["intBuyerID"];
}

if ($request=='check_cutno')
{	

	$cut=$_GET['cutno'];
	$style=$_GET['style'];
	$str="select intStyleId from productionbundleheader where intStyleId='$style' and strCutNo='$cut'";
	
	$result = $db->RunQuery($str); 
	$rows=mysql_num_rows($result);	
	if($rows>0)	
	echo "exist";
	else
	echo $rows;
}

function edit_vip($cut_serial)
{
	global $db;
}

if ($request=='check_fabric')
{	

	$style=$_GET['style'];
	$str="select intStyleId from issuesdetails where intStyleId='$style'";	
	$result = $db->RunQuery($str); 
	$rows=mysql_num_rows($result);	
	if($rows>0)	
	echo "exist";
	else
	//echo $rows; // comment bue to cannot proceed
	echo "exist";
}

function reset_bundlenos($style)
{
	global $db;
	$str_max		="select dblBundleNo , strNoRange from productionbundleheader pbh
inner join productionbundledetails pbd on pbh.intCutBundleSerial=pbd.intCutBundleSerial
where pbh.intStyleId='$style' and dblBundleNo=(select max(dblBundleNo) from productionbundleheader pbh
inner join productionbundledetails pbd on pbh.intCutBundleSerial=pbd.intCutBundleSerial
where pbh.intStyleId='$style' )";
	$result_max		=$db->RunQuery($str_max);
	$row_max		=mysql_fetch_array($result_max);
	$bundle_no		=($row_max["dblBundleNo"]==""?0:$row_max["dblBundleNo"]);
	$norange_array	=($row_max["strNoRange"]==""?explode("-","0-0"):explode("-",$row_max["strNoRange"]));
	$norange		=$norange_array[1]+1;
	$str_update		="update style_cut_compo_header set intBundleNo='$bundle_no',intNumberRange='$norange'
where intStyleId='$style'";
	$result_update	=$db->RunQuery($str_update);	
	
}

function update_wip($style,$factory,$qty){
	
	global $db;
	$cutQty = GetCutQty($style);
	$str_check_db="SELECT intStyleId FROM wip WHERE intStyleId=$style";
	$result_check_db=$db->RunQuery($str_check_db);
	if(mysql_num_rows($result_check_db)>0)
		$str="UPDATE wip SET intCutQty=$cutQty WHERE intStyleId='$style'";
	else
		$str="INSERT INTO wip 
			(intStyleID, 
			intSourceFactroyID, 
			intDestinationFactroyID, 
			intCutQty
			)
			VALUES
			('$style', 
			'$factory', 
			'$factory', 
			'$qty'
			);";
	$result=$db->RunQuery($str);
}

function GetCutQty($styleId)
{
	global $db;
	$sql="SELECT qty FROM wip_cut_tempt WHERE intStyleId=$styleId";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["qty"];
}

function del_update_wip($style,$qty)
{
	$cutQty = GetCutQty($style);
	$str="UPDATE wip SET intCutQty=$cutQty WHERE intStyleId='$style'";
	$result=$db->RunQuery($str);	
} 
?>