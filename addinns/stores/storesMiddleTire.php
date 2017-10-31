<?php
session_start();
include "../../Connector.php";



$RequestType = $_GET["Request"];

if($RequestType == "SaveMainStores")
{	
$Search		= $_GET["Search"];
$storesName	= $_GET["storesName"];
$virtualStore	= $_GET["virtualStore"];
$remarks 	= $_GET["remarks"];
$compID 	= $_GET["compID"];
$active 	= $_GET["active"];
$autoBin 	= $_GET["autoBin"];
$commonBin 	= $_GET["commonBin"];
$category 	= $_GET["category"];
$category 	= $_GET["category"];

	if($category=="Save")
	{
		$sql = "INSERT INTO mainstores 
		(intCompanyId, 
		strName, 
		strRemarks, 
		intStatus,
		intAutomateCompany,
		intCommonBin)
		VALUES
		('$compID', 
		'$storesName', 
		'$remarks', 
		'$active',
		'0',
		'$commonBin');";	
		$id =  $db->AutoIncrementExecuteQuery($sql);
		
		if($autoBin==1){
		$sqlV = "INSERT INTO mainstores 
		(intCompanyId, 
		strName, 
		strRemarks, 
		intStatus,
		intAutomateCompany,
		intCommonBin,intSourceStores)
		VALUES
		('$compID', 
		'$virtualStore', 
		'$remarks', 
		'$active',
		'$autoBin',
		'$commonBin',
		'$id');";	
		$id2 =  $db->AutoIncrementExecuteQuery($sqlV);
		}
		
		echo GetMainStoresDetails($id,$category);
	}
	else if($category=="Update")
	{
		$sql ="update mainstores 
			  set
			  intCompanyId = '$compID' , 
			  strName = '$storesName' , 
			  strRemarks = '$remarks' , 
			  intStatus = '$active' , 
			  intAutomateCompany = '0' , 
			  intCommonBin = '$commonBin'	
			  where
			  strMainID = '$Search' AND intAutomateCompany = '0' ";
		$result=$db->RunQuery($sql);
		
		
		$SQL="SELECT *  FROM mainstores WHERE  intSourceStores = '$Search' AND intAutomateCompany = '1' ";
		$resultExist=$db->RunQuery($SQL);

		// echo "oooo".$resultExist=CheckRecordAvailability($SQL);
		// echo "p".$autoBin."q".$resultExist;
		if(($autoBin==1)&&($resultExist=='')){
		$sqlV = "INSERT INTO mainstores 
				(intCompanyId, 
				strName, 
				strRemarks, 
				intStatus,
				intAutomateCompany,
				intCommonBin,intSourceStores)
				VALUES
				('$compID', 
				'$virtualStore', 
				'$remarks', 
				'$active',
				'$autoBin',
				'$commonBin',
				'$Search');";	
				$id2 =  $db->AutoIncrementExecuteQuery($sqlV);	
				}
		else if(($autoBin==1)&&($resultExist!='')){
		 $sqlV ="update mainstores 
			  set
			  intCompanyId = '$compID' , 
			  strName = '$virtualStore' , 
			  strRemarks = '$remarks' , 
			  intStatus = '$active' , 
			  intAutomateCompany = '$autoBin' , 
			  intCommonBin = '$commonBin' ,
			  intSourceStores = '$Search'	
			  where
			    intSourceStores = '$Search' AND intAutomateCompany = '1' ";
			$resultV=$db->RunQuery($sqlV);
		}
		/*	else if(($autoBin==0)&&($resultExist=='true')){
			$sql = "DELETE FROM mainstores WHERE  strMainID = '$Search' AND intAutomateCompany = '1' ";
			echo $db->ExecuteQuery($sql);	
			}*/

		
		echo GetMainStoresDetails($Search,$category);
	}
}
else if($RequestType == "deleteStore")
{	
$storesID 	= $_GET["cboStoreID"];
			 $sql = "DELETE FROM mainstores WHERE  strMainID = '$storesID' OR intSourceStores = '$storesID' ";
			 $result = $db->RunQuery2($sql);
			 if(gettype($result)=='string')
			 {
				echo GetMainStoresDetails($result,'Failed');
				return;
			 }
			 else{
			echo GetMainStoresDetails($storesID,'Delete');
			}
}

else if($RequestType == "SaveSubStores")
{	
$storesName 	= $_GET["storesName"];
$remarks 		= $_GET["remarks"];
$mainStore 		= $_GET["mainStore"];
$virtualMainStore 	= $_GET["virtualMainStore"];
$category 		= $_GET["category"];
$active 		= $_GET["active"];
$Search			= $_GET["Search"];
	
	if($category=="Save")
	{
		$sql = "INSERT INTO substores ".
			"( ".
			"strMainID, ".
			"strSubStoresName, ".
			"strRemarks, ".
			"intStatus) ".
			"VALUES ".
			"('$mainStore', ".
			"'$storesName', ".
			"'$remarks', ".
			"'$active');";
			
		$id = $db->AutoIncrementExecuteQuery($sql);
		
		if($virtualMainStore!=""){
		
		$sql = "INSERT INTO substores ".
			"( ".
			"strMainID, ".
			"strSubStoresName, ".
			"strRemarks, ".
			"intStatus, ".
			"intSourceStores) ".
			"VALUES ".
			"('$virtualMainStore', ".
			"'$storesName', ".
			"'$remarks', ".
			"'$active', ".
			"'$id');";
			
		$id = $db->AutoIncrementExecuteQuery($sql);
		}
		
		
		echo GetSubStoresDetails($category,$mainStore,'');
	}
	elseif($category=="Update")
	{	
		$sql="update substores ".
			"set ".
			//"strMainID = '$mainStore' ,  ".
			"strSubStoresName = '$storesName' , ".
			"strRemarks = '$remarks', ".
			"intStatus = '$active' ".
			"where ".
			"strSubID = '$Search';";
		$result=$db->RunQuery($sql);
		
		if($virtualMainStore!=""){
		/*	 $sql="UPDATE mainstores AS m, substores AS s
	SET s.strSubStoresName='$storesName',s.strRemarks='$remarks', s.intStatus='$active'  
	WHERE  m.strMainID=s.strMainID AND m.intSourceStores='$mainStore' AND m.intAutomateCompany=1;";*/
		$sql="update substores ".
			"set ".
			//"strMainID = '$mainStore' ,  ".
			"strSubStoresName = '$storesName' , ".
			"strRemarks = '$remarks', ".
			"intStatus = '$active' ".
			"where ".
			"intSourceStores = '$Search';";
			
		$result=$db->RunQuery($sql);
		}
		
		echo GetSubStoresDetails($category,$mainStore,'');
	}	
}
else if($RequestType == "deleteSubStore")
{	
$storesID 	= $_GET["cboStoreID"];
$mainStoresID 	= $_GET["mainStore"];

			  $sql = "DELETE FROM substores WHERE  strSubID = '$storesID' OR intSourceStores = '$storesID' ";
			 $result = $db->RunQuery2($sql);
			 if(gettype($result)=='string')
			 {
			echo GetSubStoresDetails('Failed',$mainStoresID,$result);
				return;
			 }
			 else{
			echo GetSubStoresDetails('Delete',$mainStoresID,'');
			}
}
else if($RequestType == "SaveLocation")
{
	
	$storesName = $_GET["storesName"];
	$remarks 	= $_GET["remarks"];
	$mainStore 	= $_GET["mainStore"];
	$virtualMainStore 	= $_GET["virtualMainStore"];
	$subStore 	= $_GET["subStore"];
	$virtualSubStore 	= $_GET["virtualSubStore"];
	$Search		= $_GET["Search"];
	$category	= $_GET["category"];
	$active 	= $_GET["active"];
	
	if($category=="Save")
	{
		$sql = "INSERT INTO storeslocations 
			(strMainID, 
			strSubID, 
			strLocName, 
			strRemarks, 
			intStatus)
			VALUES
			('$mainStore', 
			'$subStore', 
			'$storesName', 
			'$remarks',
			'$active');";		
		$id = $db->AutoIncrementExecuteQuery($sql);
		
		if($virtualMainStore!=""){
		
			$sql = "INSERT INTO storeslocations 
				(strMainID, 
				strSubID, 
				strLocName, 
				strRemarks, 
				intStatus, 
				intSourceStores)
				VALUES
				('$virtualMainStore', 
				'$virtualSubStore', 
				'$storesName', 
				'$remarks',
				'$active',
				'$id');";		
			$id = $db->AutoIncrementExecuteQuery($sql);
		
		}
		
		echo GetLocationDetails($category,$mainStore,$subStore,'');
	}
	elseif($category=="Update")
	{
		$sql="update storeslocations ".
			"set ".
			//"strMainID = '$mainStore', ".
			//"strSubID = '$subStore', ". 
			"strLocName = '$storesName', ". 
			"strRemarks = '$remarks', ". 
			"intStatus = '$active' ".	
			"where ".
			"strLocID = '$Search';";
		$result=$db->RunQuery($sql);
		
		if($virtualMainStore!=""){
			/* $sql="UPDATE mainstores AS m, storeslocations AS s
	SET s.strLocName='$storesName',s.strRemarks='$remarks', s.intStatus='$active'  
	WHERE  m.strMainID=s.strMainID AND m.intSourceStores='$mainStore' AND m.intAutomateCompany=1;";*/
		$sql="update storeslocations ".
			"set ".
			//"strMainID = '$mainStore', ".
			//"strSubID = '$subStore', ". 
			"strLocName = '$storesName', ". 
			"strRemarks = '$remarks', ". 
			"intStatus = '$active' ".	
			"where ".
			"intSourceStores = '$Search';";
			
		$result=$db->RunQuery($sql);
		}
		
		echo GetLocationDetails($category,$mainStore,$subStore,'');
	}
}
else if($RequestType == "deleteLocation")
{	
$locationID 	= $_GET["locationID"];
$storesID 	= $_GET["substore"];
$mainStoresID 	= $_GET["mainStore"];

			  $sql = "DELETE FROM storeslocations WHERE  strLocID = '$locationID' OR intSourceStores = '$locationID' ";
			 $result = $db->RunQuery2($sql);
			 if(gettype($result)=='string')
			 {
		echo GetLocationDetails('Failed',$mainStoresID,$storesID,$result);
				return;
			 }
			 else{
		echo GetLocationDetails('Delete',$mainStoresID,$storesID,'');
			}
}
else if($RequestType == "BinLocation")
{
	
	$storesName = $_GET["storesName"];
	$remarks 	= $_GET["remarks"];
	$mainStore 	= $_GET["mainStore"];
	$virtualMainStore 	= $_GET["virtualMainStore"];
	$subStore 	= $_GET["subStore"];
	$virtualSubStore 	= $_GET["virtualSubStore"];
	$location 	= $_GET["locationID"];
	$virtualLocation 	= $_GET["virtualLocation"];
	$Search		= $_GET["Search"];
	$category	= $_GET["category"];
	$active 	= $_GET["active"];
	
	
	
	
	if($category=="Save")
	{
		$sql = "INSERT INTO storesbins 
			(strMainID, 
			strSubID, 
			strLocID, 
			strBinName, 
			strRemarks, 
			intStatus)
			VALUES
			('$mainStore', 
			'$subStore', 
			'$location', 
			'$storesName', 
			'$remarks', 
			'$active');";
		$id = $db->AutoIncrementExecuteQuery($sql);
		
		if($virtualMainStore!=""){
		
			$sql = "INSERT INTO storesbins 
				(strMainID, 
				strSubID, 
				strLocID, 
				strBinName, 
				strRemarks, 
				intStatus, 
				intSourceStores)
				VALUES
				('$virtualMainStore', 
				'$virtualSubStore', 
				'$virtualLocation', 
				'$storesName', 
				'$remarks', 
				'$active', 
				'$id');";
			$id = $db->AutoIncrementExecuteQuery($sql);
		
		}		
		
		echo GetBinDetails($category,$mainStore,$subStore,$location,'');
	}
	elseif($category=="Update")
	{
		$sql="update storesbins ". 
				"set ". 
				//"strMainID='$mainStore', ".
				//"strSubID='$subStore', ".
				//"strLocID='$location', ".
				"strBinName='$storesName', ".
				"strRemarks='$remarks', ".
				"intStatus='$active' ".
				"where strBinID='$Search'";
		$result=$db->RunQuery($sql);
		
		if($virtualMainStore!=""){
			/* $sql="UPDATE mainstores AS m, storesbins AS s
	SET s.strBinName='$storesName',s.strRemarks='$remarks', s.intStatus='$active'  
	WHERE  m.strMainID=s.strMainID AND m.intSourceStores='$mainStore' AND m.intAutomateCompany=1;";*/
		 $sql="update storesbins ". 
				"set ". 
				//"strMainID='$mainStore', ".
				//"strSubID='$subStore', ".
				//"strLocID='$location', ".
				"strBinName='$storesName', ".
				"strRemarks='$remarks', ".
				"intStatus='$active' ".
			"where intSourceStores = '$Search';";
			
		$result=$db->RunQuery($sql);
		}
		
		echo GetBinDetails($category,$mainStore,$subStore,$location,'');
	}	
}
else if($RequestType == "deleteBin")
{
$binID 	= $_GET["binId"];	
$locationID 	= $_GET["locationID"];
$storesID 	= $_GET["substore"];
$mainStoresID 	= $_GET["mainStore"];

			  $sql = "DELETE FROM storesbins WHERE  strBinID = '$binID' OR intSourceStores = '$binID' ";
			 $result = $db->RunQuery2($sql);
			 if(gettype($result)=='string')
			 {
		echo GetBinDetails('Delete',$mainStoresID,$storesID,$locationID,$result);
				return;
			 }
			 else{
		echo GetBinDetails('Delete',$mainStoresID,$storesID,$locationID,'');
			}
}
else if($RequestType == "getCategories")
{
	$binID = $_GET["binID"];
	$locID = $_GET["locationID"];
	$substoreID = $_GET["substore"];
	$mainID = $_GET["mainStore"];
	$mainCategory = $_GET["mainCat"];
	$subCategory = $_GET["SubCategory"];
	
	$unitText = "<select name=\"noname\" class=\"txtbox\" style=\"width:170px\"  id=\"cboUnit\">";
	$sql = "select strUnit, strTitle from units;";
	
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$unitText .= "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
   $unitText .= "</select>";
	
	$sql = "SELECT matsubcategory.intSubCatNo,matsubcategory.StrCatCode,matsubcategory.StrCatName,binalc.strUnit,binalc.dblCapacityQty,binalc.dblFillQty,binalc.strRemarks FROM matsubcategory LEFT JOIN 
(SELECT * FROM storesbinallocation WHERE strMainID = '$mainID' AND strSubID = '$substoreID' AND strLocID = '$locID' AND strBinID = '$binID')  binalc ON 
 binalc.intSubCatNo = matsubcategory.intSubCatNo   WHERE intCatNo = '$mainCategory' ";
 if($subCategory!="")
 	$sql .= "and matsubcategory.StrCatName like '%$subCategory%' ";
 
 $sql .= "order by matsubcategory.StrCatName";
	
	$result=$db->RunQuery($sql);
	
	$html = "<tr>
					<td bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\" width=\"5%\"><div style=\"width:25px;\">Select</div></td>
					<td bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\" width=\"20%\" ><div style=\"width:250px;\">Item Category</div></td>
					<td bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\" width=\"20%\"><div style=\"width:100px;\">Unit</div></td>
					<td bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\" width=\"20%\"><div style=\"width:80px;\">Capacity</div></td>
					<td bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\" width=\"15%\"><div style=\"width:100px;\">Used Capacity</div></td>
					<td bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\" width=\"20%\"><div style=\"width:125px;\">Remarks</div></td>
					</tr>";

	while($row=mysql_fetch_array($result))
	{
		$class = "bcgcolor-tblrowWhite";
		$checked = "";
		$disabled = "";
		
		if($row["dblCapacityQty"] != NULL)
		{
			$class = "bcgcolor";
			$checked = " checked=\"checked\" ";
		}
		
		if($row["dblFillQty"] != NULL && $row["dblFillQty"] > 0)
			$disabled = " disabled=\"disabled\" ";
		$unitTextlist = $unitText;
		if($row["strUnit"] != NULL && $row["strUnit"] != "")
			$unitTextlist = str_replace("<option value=\"". $row["strUnit"] ."\">","<option selected=\"selected\" value=\"". $row["strUnit"] ."\">",$unitTextlist);
		
		$html .= "<tr class=\"$class\">
					<td class=\"normalfntMid\"><input id=\"" . $row["intSubCatNo"] . "\" type=\"checkbox\" $checked $disabled></td>
					<td class=\"normalfnt\">" . $row["StrCatName"] ."</td>
					<td class=\"normalfnt\">$unitTextlist</td>
					<td class=\"normalfnt\"><input style=\"width:100px;\" maxlength=\"10\" class=\"txtbox\" type=\"text\" value=\"" . $row["dblCapacityQty"] ."\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td>
					<td class=\"normalfnt\">" . $row["dblFillQty"] ."</td>
					<td class=\"normalfnt\"><input style=\"width:100px;\" class=\"txtbox\" type=\"text\" value=\"" . $row["strRemarks"] ."\"></td>
					</tr>";
					
					//$pos ++;
		
	}
	
	echo $html;
}
else if($RequestType == "removeUnwanted")
{
	$binID = $_GET["binID"];
	$locID = $_GET["locationID"];
	$substoreID = $_GET["substore"];
	$mainID = $_GET["mainStore"];
	$selectedlist = $_GET["selectedList"];
	$mainCatID =$_GET["matID"]; 
	$virtualMainStore 	= $_GET["virtualMainStore"];
	$virtualSubStore 	= $_GET["virtualSubStore"];
	$virtualLocation 	= $_GET["virtualLocation"];
	
	$SQL="select s.strBinID from storesbins as s join mainstores as m on s.strMainID=m.strMainID WHERE  m.strMainID=s.strMainID AND s.intSourceStores='$binID' AND m.intAutomateCompany=1;";
	$result=$db->RunQuery($SQL);
	$rowS=mysql_fetch_array($result);
	$virtualBin=$rowS["strBinID"];
	
	$sql = "SELECT *  FROM storesbinallocation WHERE  strMainID = '$mainID' AND strSubID = '$substoreID' AND strLocID = '$locID' AND strBinID = '$binID' AND intSubCatNo NOT IN ('$selectedlist');";
	
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		$sql = "SELECT intSubCatNo FROM matsubcategory WHERE intSubCatNo = '" . $row["intSubCatNo"] . "' and  intCatNo = '$mainCatID'";
		$catresult = $db->RunQuery($sql);	
		while($catrow = mysql_fetch_array($catresult))
		{
			$sql = "DELETE FROM storesbinallocation WHERE  strMainID = '$mainID' AND strSubID = '$substoreID' AND strLocID = '$locID' AND strBinID = '$binID' AND intSubCatNo IN ('" .  $row["intSubCatNo"]  . "');";
			
			echo $db->ExecuteQuery($sql);	
			$sql = "DELETE FROM storesbinallocation WHERE  strMainID = '$virtualMainStore' AND strSubID = '$virtualSubStore' AND strLocID = '$virtualLocation' AND strBinID = '$virtualBin' AND intSubCatNo IN ('" .  $row["intSubCatNo"]  . "');";
			
			$db->ExecuteQuery($sql);	
		}
	}
	
}
else if($RequestType == "SaveAllocation")
{
	$binID = $_GET["binID"];
	$locID = $_GET["locationID"];
	$substoreID = $_GET["substore"];
	$mainID = $_GET["mainStore"];
	$category = $_GET["category"];
	$capacity = $_GET["capacity"];
	$unit = $_GET["unit"];
	$remarks = $_GET["remarks"];
	$virtualMainStore 	= $_GET["virtualMainStore"];
	$virtualSubStore 	= $_GET["virtualSubStore"];
	$virtualLocation 	= $_GET["virtualLocation"];
	
	$SQL="select s.strBinID from storesbins as s join mainstores as m on s.strMainID=m.strMainID WHERE  m.strMainID=s.strMainID AND s.intSourceStores='$binID' AND m.intAutomateCompany=1;";
	$result=$db->RunQuery($SQL);
	$rowS=mysql_fetch_array($result);
	$virtualBin=$rowS["strBinID"];
	
	$insertRequired = true;
	$sql = "Select strMainID FROM storesbinallocation WHERE  strMainID = '$mainID' AND strSubID = '$substoreID' AND strLocID = '$locID' AND strBinID = '$binID' AND intSubCatNo = '$category';";
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		$insertRequired = false;
		break;
	}
	
	if($insertRequired)
	{
		$sql = "INSERT INTO storesbinallocation 
	(strMainID, 
	strSubID, 
	strLocID, 
	strBinID, 
	intSubCatNo, 
	strUnit, 
	dblCapacityQty,  
	strRemarks, 
	intStatus
	)
	VALUES
	('$mainID', 
	'$substoreID', 
	'$locID', 
	'$binID', 
	'$category', 
	'$unit', 
	'$capacity',  
	'$remarks', 
	'1'
	);";
	echo $db->ExecuteQuery($sql);	
	
		$sql = "INSERT INTO storesbinallocation 
	(strMainID, 
	strSubID, 
	strLocID, 
	strBinID, 
	intSubCatNo, 
	strUnit, 
	dblCapacityQty,  
	strRemarks, 
	intStatus
	)
	VALUES
	('$virtualMainStore', 
	'$virtualSubStore', 
	'$virtualLocation', 
	'$virtualBin', 
	'$category', 
	'$unit', 
	'$capacity',  
	'$remarks', 
	'1'
	);";
	$db->ExecuteQuery($sql);	
	}
	else
	{
		$sql = "UPDATE storesbinallocation 
	SET 
	strUnit = '$unit' , 
	dblCapacityQty = '$capacity' , 
	strRemarks = '$remarks' 
	
	WHERE
	strMainID = '$mainID' AND strSubID = '$substoreID' AND strLocID = '$locID' AND strBinID = '$binID' AND intSubCatNo = '$category' ;";
	echo $db->ExecuteQuery($sql);	
	
		$sql = "UPDATE storesbinallocation 
	SET 
	strUnit = '$unit' , 
	dblCapacityQty = '$capacity' , 
	strRemarks = '$remarks' 
	
	WHERE
	strMainID = '$virtualMainStore' AND strSubID = '$virtualSubStore' AND strLocID = '$virtualLocation' AND strBinID = '$virtualBin' AND intSubCatNo = '$category' ;";
	$db->ExecuteQuery($sql);	
	}
}
else if($RequestType=="LoadMainStoreDetails")
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

 $ResponseXML = "<XMLLoadMainStoreDetails>";
$mainStoreId = $_GET["mainStoreId"];
	$sql="select intCompanyId,strName,strRemarks,intStatus,intAutomateCompany,intCommonBin from mainstores where strMainID='$mainStoreId' OR  intSourceStores='$mainStoreId' order by intAutomateCompany ASc";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<CompanyId><![CDATA[" . $row["intCompanyId"]  . "]]></CompanyId>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		$ResponseXML .= "<AutomateCompany><![CDATA[" . $row["intAutomateCompany"]  . "]]></AutomateCompany>\n";
		$ResponseXML .= "<CommonBin><![CDATA[" . $row["intCommonBin"]  . "]]></CommonBin>\n";
	}
 $ResponseXML .= "</XMLLoadMainStoreDetails>";
 echo $ResponseXML;
}
else if($RequestType=="LoadSubStoreDetails")
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLLoadMainStoreDetails>";
$subStoreId = $_GET["subStoreId"];

	$sql="SELECT strSubStoresName,strRemarks,intStatus FROM substores where strSubID='$subStoreId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<SubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></SubStoresName>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}
 $ResponseXML .= "</XMLLoadMainStoreDetails>";
 echo $ResponseXML;
}
else if($RequestType=="LoadLocationDetails")
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLLoadLocationDetails>";
$locationId = $_GET["locationId"];

	$sql="select strLocName,strRemarks,intStatus from storeslocations where strLocID='$locationId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<SubStoresName><![CDATA[" . $row["strLocName"]  . "]]></SubStoresName>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}
 $ResponseXML .= "</XMLLoadLocationDetails>";
 echo $ResponseXML;
}
else if($RequestType=="LoadBinDetails")
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLLoadBinDetails>";
$binId = $_GET["binId"];

	$sql="select strBinName,strRemarks,intStatus from storesbins where strBinID='$binId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<BinName><![CDATA[" . $row["strBinName"]  . "]]></BinName>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}
 $ResponseXML .= "</XMLLoadBinDetails>";
 echo $ResponseXML;
}
//Start - Start function
function GetMainStoresDetails($id,$category)
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLLoadBinDetails>";
global $db;
	$sql="select strMainID,strName,strRemarks from mainstores where mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."' AND intAutomateCompany <>1 AND intStatus<>10 order by strName;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($category=="Save")
			$ResponseXML .= "<Message><![CDATA[" . "Saved successfully."  . "]]></Message>\n";
		elseif($category=="Update")
			$ResponseXML .= "<Message><![CDATA[" . "Updated successfully."  . "]]></Message>\n";
		elseif($category=="Delete")
			$ResponseXML .= "<Message><![CDATA[" . "Deleted successfully."  . "]]></Message>\n";
		elseif($category=="Failed")
			$ResponseXML .= "<Message><![CDATA[" . $id  . "]]></Message>\n";
			
		$ResponseXML .= "<page><![CDATA[1]]></page>\n";
		$ResponseXML .= "<Id><![CDATA[" . $row["strMainID"]  . "]]></Id>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
	}
$ResponseXML .= "</XMLLoadBinDetails>";
return $ResponseXML; 
}
function GetSubStoresDetails($category,$mainStore,$failed)
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

 //$result="ouyy";
$ResponseXML = "<XMLGetSubStoresDetails>";
global $db;
	$sql="select strSubID,strSubStoresName,strRemarks from substores where intStatus<>10 and strMainID='$mainStore' order by strSubStoresName;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($category=="Save")
			$ResponseXML .= "<Message><![CDATA[" . "Saved successfully."  . "]]></Message>\n";
		elseif($category=="Update")
			$ResponseXML .= "<Message><![CDATA[" . "Updated successfully."  . "]]></Message>\n";
		elseif($category=="Delete")
			$ResponseXML .= "<Message><![CDATA[" . "Deleted successfully."  . "]]></Message>\n";
		elseif($category=="Failed")
			$ResponseXML .= "<Message><![CDATA[" . $failed  . "]]></Message>\n";
	
		$ResponseXML .= "<page><![CDATA[2]]></page>\n";
		$ResponseXML .= "<Id><![CDATA[" . $row["strSubID"]  . "]]></Id>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strSubStoresName"]  . "]]></Name>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
	}
$ResponseXML .= "</XMLGetSubStoresDetails>";
return $ResponseXML; 
}
function GetLocationDetails($category,$mainStore,$subStore,$failed)
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLGetLocationDetails>";
global $db;
	$sql="select strLocID,strLocName,strRemarks from storeslocations where intStatus<>10 and strMainID='$mainStore' and strSubID='$subStore' order by strLocName;";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($category=="Save")
			$ResponseXML .= "<Message><![CDATA[" . "Saved successfully."  . "]]></Message>\n";
		elseif($category=="Update")
			$ResponseXML .= "<Message><![CDATA[" . "Updated successfully."  . "]]></Message>\n";
		elseif($category=="Delete")
			$ResponseXML .= "<Message><![CDATA[" . "Deleted successfully."  . "]]></Message>\n";
		elseif($category=="Failed")
			$ResponseXML .= "<Message><![CDATA[" . $failed  . "]]></Message>\n";
			
		$ResponseXML .= "<page><![CDATA[3]]></page>\n";
		$ResponseXML .= "<Id><![CDATA[" . $row["strLocID"]  . "]]></Id>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strLocName"]  . "]]></Name>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
	}
$ResponseXML .= "</XMLGetLocationDetails>";
return $ResponseXML; 
}
function GetBinDetails($category,$mainStore,$subStore,$location,$failed)
{
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLGetLocationDetails>";
global $db;
	$sql="select strBinID,strBinName,strRemarks from storesbins where intStatus <>10 and strMainID='$mainStore' and strSubID='$subStore' and strLocID='$location' order by strBinName;";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($category=="Save")
			$ResponseXML .= "<Message><![CDATA[" . "Saved successfully."  . "]]></Message>\n";
		elseif($category=="Update")
			$ResponseXML .= "<Message><![CDATA[" . "Updated successfully."  . "]]></Message>\n";
		elseif($category=="Delete")
			$ResponseXML .= "<Message><![CDATA[" . "Deleted successfully."  . "]]></Message>\n";
		elseif($category=="Failed")
			$ResponseXML .= "<Message><![CDATA[" . $failed  . "]]></Message>\n";
	
		$ResponseXML .= "<page><![CDATA[4]]></page>\n";
		$ResponseXML .= "<Id><![CDATA[" . $row["strBinID"]  . "]]></Id>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strBinName"]  . "]]></Name>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
	}
$ResponseXML .= "</XMLGetLocationDetails>";
return $ResponseXML; 
}
?>