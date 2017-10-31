<?php
session_start();
include "../Connector.php";	
function update_production_wip($factory,$serial,$field,$qty)
{
	global $db;	
	$str_for_wip="select intCutBundleSerial,intStyleId,strColor,strFromFactory,dblTotalQty,cut_type from productionbundleheader where  intCutBundleSerial='$serial'";
	$result_for_wip=$db->RunQuery($str_for_wip);
	$row_for_wip=mysql_fetch_array($result_for_wip);
	
	$sql_check = "select intStyleID,intDestinationFactroyID from productionwip where intStyleID='".$row_for_wip["intStyleId"]."' and intDestinationFactroyID='$factory';";
	$result_Check=$db->RunQuery($sql_check);
	if(mysql_num_rows($result_Check)>0)
	{
		wip_update($row_for_wip["intStyleId"],$row_for_wip["strColor"],$factory,$qty,$row_for_wip["strFromFactory"],$row_for_wip["dblTotalQty"],$field);
	}
	else
	{
		wip_insert($row_for_wip["intStyleId"],$row_for_wip["strColor"],$row_for_wip["strFromFactory"],$factory,$qty);
	}
	if($row_for_wip["cut_type"]==1)
	final_wip_update($row_for_wip["intStyleId"],$qty,$field);
} 
function update_production_wip_withoutBserial($Fromfactory,$Desfactory,$StyleId,$color,$field,$qty)
{
	global $db;	
	$sql_check = "select intStyleID,intDestinationFactroyID from productionwip where intStyleID='$StyleId' and intDestinationFactroyID='$Desfactory';";
	$result_Check=$db->RunQuery($sql_check);
	if(mysql_num_rows($result_Check)>0)
	{
		wip_update($StyleId,$color,$Desfactory,$qty,$Fromfactory,'',$field);
		
	}
	else
	{
		wip_insert($StyleId,$color,$Fromfactory,$Desfactory,$qty);
	}
}   
function wip_update($style,$color,$factory,$qty,$frmfactory,$totqty,$field)
{
	global $db;
	$str_edit_wip="update productionwip 
				set	
				$field =$field+ '$qty' 	
				where
				intStyleID = '$style' and strColor = '$color' and intDestinationFactroyID = '$factory' ;";
	$wip_run=$db->RunQuery($str_edit_wip);
}
function wip_insert($style,$color,$FromFactory,$factory,$totqty)
{
	global $db;
	$str_insert="insert into productionwip 
				(intStyleID, strColor, intSourceFactroyID,  intDestinationFactroyID, intOrderQty)
				values
				('$style', '$color', '$FromFactory' ,'$factory', '$totqty');";
	$result_insert=$db->RunQuery($str_insert);
}
function final_wip_update($style,$qty,$field)
{
	global $db;
	$str_edit_wip="update wip 
				set	
				$field =$field+ '$qty' 	
				where
				intStyleID = '$style' ;";
	$wip_run=$db->RunQuery($str_edit_wip);
}
?>