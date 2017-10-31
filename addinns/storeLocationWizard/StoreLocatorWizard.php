<?php

session_start();

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//$db =new DBManager();
$RequestType = $_GET["RequestType"]; 

	if (strcmp($RequestType,"GetMainStores") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<MainStores>\n";
		 $result=getAvailableMainStores();
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<StoreID><![CDATA[" . $row["strMainID"]  . "]]></StoreID>\n";
			$ResponseXML .= "<StoreName><![CDATA[" . $row["strName"]  . "]]></StoreName>\n";                
		 }
		 $ResponseXML .= "</MainStores>";
		 echo $ResponseXML;	
	}

	else if (strcmp($RequestType,"GetSubStores") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<SubStores>\n";
		 $MainID = $_GET["MainID"]; 	 
		 $result=getAvailableSubStores($MainID);
		 
		 while($row = mysql_fetch_array($result))
		 {
			 $ResponseXML .= "<StoreID><![CDATA[" . $row["strSubID"]  . "]]></StoreID>\n";
			 $ResponseXML .= "<StoreName><![CDATA[" . $row["strSubStoresName"]  . "]]></StoreName>\n";                
		 }
		 $ResponseXML .= "</SubStores>";
		 echo $ResponseXML;	
	}
//
	else if (strcmp($RequestType,"GetLocations") == 0)
	{
		 $MainID = $_GET["MainID"]; 
		 $SubID=$_GET["SubID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Locations>\n";
		 $result=getAvailableLocations($SubID);
		 
		 while($row = mysql_fetch_array($result))
		 {
			 $ResponseXML .= "<StoreID><![CDATA[" . $row["strLocID"]  . "]]></StoreID>\n";
			 $ResponseXML .= "<StoreName><![CDATA[" . $row["strLocName"]  . "]]></StoreName>\n";                
		 }
		 $ResponseXML .= "</Locations>";
		 echo $ResponseXML;	
	}

//

	else if (strcmp($RequestType,"GetBins") == 0)
	{
		 $LocID=$_GET["LocID"];
		 $ResponseXML = "";
		 $ResponseXML .= "<Bins>\n";
		 $result=getAvailableBins($LocID);

		 while($row = mysql_fetch_array($result))
		 {
			 $ResponseXML .= "<StoreID><![CDATA[" . $row["strBinID"]  . "]]></StoreID>\n";
			 $ResponseXML .= "<StoreName><![CDATA[" . $row["strBinName"]  . "]]></StoreName>\n";       
			 $ResponseXML .= "<StoreRemark><![CDATA[" . $row["strRemarks"]  . "]]></StoreRemark>\n";                
		 }
		 $ResponseXML .= "</Bins>";
		 echo $ResponseXML;	
	}

	else if (strcmp($RequestType,"GetMatSubCatogeris") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<MatSubCatogeris>\n";
		 $result=getAvailableMatSubCatogeris();
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<SubCatNo><![CDATA[" . $row["intSubCatNo"]  . "]]></SubCatNo>\n";
			$ResponseXML .= "<CatName><![CDATA[" . $row["StrCatName"]  . "]]></CatName>\n";                
		 }
		 $ResponseXML .= "</MatSubCatogeris>";
		 echo $ResponseXML;	
	}

	else if (strcmp($RequestType,"GetAvlMatSubCatogeris") == 0)
	{
		 $bid=$_GET["bid"];
		 $ResponseXML = "";
		 $ResponseXML .= "<AvlMatSubCatogeris>\n";
		 $result=getSelectedMatSubCatogeris($bid);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<MatCatID><![CDATA[" . $row["intSubCatNo"]  . "]]></MatCatID>\n";
			$ResponseXML .= "<MatCat><![CDATA[" . $row["StrCatName"]  . "]]></MatCat>\n";
			$ResponseXML .= "<UNITID><![CDATA[" . $row["strUnit"]  . "]]></UNITID>\n";
			$ResponseXML .= "<QTY><![CDATA[" . $row["dblQty"]  . "]]></QTY>\n";
			$ResponseXML .= "<REMARK><![CDATA[" . $row["strRemarks"]  . "]]></REMARK>\n";
		 }
		 $ResponseXML .= "</AvlMatSubCatogeris>";
		 echo $ResponseXML;	
	}


	else if (strcmp($RequestType,"GetUnits") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<Units>\n";
		 $result=getAvailableUnits();
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
			                
		 }
		 $ResponseXML .= "</Units>";
		 echo $ResponseXML;	
	}


	else if (strcmp($RequestType,"SaveMainStore") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<MainStore>\n";
		 $StoreName = $_GET["Loca"];
		 $Remarks = $_GET["Remarks"];
		 if(saveNewMainStore($StoreName,$Remarks))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</MainStore>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($RequestType,"SaveSubStore") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<SubStore>\n";
		 $intMainID= $_GET["intMainID"];
		 $StoreName = $_GET["strName"];
		 $Remarks = $_GET["strRemarks"];
	
		 if(saveNewSubStore($intMainID,$StoreName,$Remarks))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</SubStore>";
		 echo $ResponseXML;
	}

	else if (strcmp($RequestType,"SaveLocation") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<Location>\n";
		 $intMainID= $_GET["intMainID"];
		 $intSubID= $_GET["intSubID"];
		 $StoreName = $_GET["strName"];
		 $Remarks = $_GET["strRemarks"];
		 if(saveNewLocation($intMainID,$intSubID,$StoreName,$Remarks))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</Location>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($RequestType,"SaveBin") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<Bin>\n";
		 $intMainID= $_GET["intMainID"];
		 $intSubID= $_GET["intSubID"];
		 $intLocID= $_GET["intLocID"];
		 $BinName = $_GET["strName"];
		 $Remarks = $_GET["strRemarks"];
		 if(saveNewBin($intMainID,$intSubID, $intLocID,$BinName,$Remarks))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</Bin>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($RequestType,"SaveBinAllocation") == 0)
	{

		 $intMainID= $_GET["intMainID"];
		 $intSubID= $_GET["intSubID"];
		 $intLocID= $_GET["intLocID"];
		 $intBinID = $_GET["intBinID"];
		 $intSubCatID = $_GET["intSubCatID"];
		 $strUnitID = $_GET["strUnitID"];
		 $dblQty = $_GET["dblQty"];
		 $Remarks = $_GET["strRemarks"];
		 
		 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<BinAllocation>\n";
		 
		 if(saveBinAllowcation($intMainID,$intSubID, $intLocID,$intBinID,$intSubCatID,$strUnitID,$dblQty,$Remarks))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</BinAllocation>";
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"deleteBinAllocation") == 0)
	{
		 $intBinID = $_GET["intBinID"];
		 $ResponseXML = "";
		 $ResponseXML .= "<BinAllocationDel>\n";
		 if(deleteBinAllowcation($intBinID))
		 {
		 	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
		 	$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</BinAllocationDel>";
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"deleteAvlMatSubCatogeris") == 0)
	{
		 $intBinID = $_GET["bid"];
		 $catID = $_GET["catID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<BinAllocationCatDel>\n";
		 if(deleteCategoryFromBinAllowcation($intBinID,$catID))
		 {
		 	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
		 	$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</BinAllocationCatDel>";
		 echo $ResponseXML;
	}

//Delete selected Category from allowcation
function deleteCategoryFromBinAllowcation($intBinID,$catID)
{
	global $db;
	$strSQL="DELETE FROM storesbinallocation WHERE strBinID=$intBinID AND intSubCatNo=$catID";
	$db->RunQuery($strSQL);
	return true;


}
//RETRIEVE AVAILABLE MAIN STORES
function getAvailableMainStores()   
{
	global $db;
	$strSQL="select strMainID,strName from mainstores where intStatus = 1";
	$result=$db->RunQuery($strSQL);
	return $result;
}

//RETRIEVE AVAILABLE SUB STORES
function getAvailableSubStores($MainID)
{
	global $db;
	
	$strSQL= "select strSubID, strSubStoresName from substores where strMainID=$MainID and intstatus=1";
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}

//RETRIEVE AVAILABLE LOCATIONS
function getAvailableLocations($SubID)
{
	global $db;
	$strSQL="select strLocID,strLocName from storeslocations where strSubID=$SubID and intStatus=1";
	$result=$db->RunQuery($strSQL);
	return $result;
}

//RETRIEVE AVAILABLE BINS
function getAvailableBins($LocID)
{
	global $db;
	$strSQL="SELECT * FROM storesbins WHERE strLocID=$LocID and INTSTATUS=1";
	$result=$db->RunQuery($strSQL);
	return $result;
}

//RETRIEVE Mat Sub Catogeris
function getAvailableMatSubCatogeris()
{
	global $db;
	$strSQL="select intSubCatNo,StrCatName from matsubcategory where StrCatName<>'' and intStatus=1 order by StrCatName ";
	$result=$db->RunQuery($strSQL);
	return $result;
}

//RETRIEVE AVAILABLE Mat Sub Catogeris
function getSelectedMatSubCatogeris($bid)
{
	global $db;
	$strSQL="SELECT matsubcategory.StrCatName,storesbinallocation.intSubCatNo,storesbinallocation.strUnit,storesbinallocation.dblFillQty,  storesbinallocation.strRemarks FROM storesbinallocation INNER JOIN matsubcategory ON (storesbinallocation.intSubCatNo=matsubcategory.intSubCatNo) WHERE storesbinallocation.intStatus=1 AND storesbinallocation.strBinID='$bid'  ORDER BY storesbinallocation.intSubCatNo";	
	
	//print($strSQL);
	
	$result=$db->RunQuery($strSQL);
	return $result;
}

//RETRIEVE AVAILABLE UNITS
function getAvailableUnits()
{
	global $db;
	$strSQL="select strUnit from units where intStatus=1";
	$result=$db->RunQuery($strSQL);
	return $result;
}


//SAVE NEW MAIN STORE DETAILS
//============================
function saveNewMainStore($strName,$strRemark)
{
	global $db;
	$strSQL="insert into mainstores(strName,strRemarks,intStatus) values('$strName','$strRemark',1)";
	$db->ExecuteQuery($strSQL);
	return true;
	
}

//SAVE NEW SUB STORE DETAILS
//==============================
function saveNewSubStore($intMainID,$strName,$strRemark)
{
	global $db;
	$strSQL="insert into substores(strMainID,strSubStoresName,strRemarks,intStatus) values($intMainID,'$strName','$strRemark',1)";
	//echo($strSQL);
	
	$db->ExecuteQuery($strSQL);
	return true;
	
}

//SAVE NEW LOCATION DETAILS
//==============================
function saveNewLocation($intMainID,$intSubID,$strName,$strRemark)
{
	global $db;
	$strSQL="insert into storeslocations(strMainID,strSubID,strLocName,strRemarks,intStatus) values('$intMainID','$intSubID','$strName','$strRemark',1)";
	$db->ExecuteQuery($strSQL);
	return true;
	
}




//SAVE NEW BIN DETAILS
//==============================
function saveNewBin($intMainID,$intSubID,$intLocID,$strName,$strRemark)
{
	global $db;
	$strSQL="insert into storesbins(strMainID,strSubID,strLocID,strBinName,strRemarks,intStatus) values('$intMainID' ,'$intSubID', '$intLocID', '$strName','$strRemark',1)";

	
	$db->ExecuteQuery($strSQL);
	return true;
	
}


//SAVE BIN ALLOWCATION
//==============================
function saveBinAllowcation($intMainID,$intSubID,$intLocID,$intBinID,$intSubCatID,$strUnitID,$dblQty,$strRemark)
{
	global $db;
	
	$strSQL="insert into storesbinallocation (strMainID, strSubID, strLocID,strBinID, intSubCatNo,strUnit,dblCapacityQty, dblFillQty, strRemarks ,intStatus) values('$intMainID','$intSubID','$intLocID','$intBinID','$intSubCatID','$strUnitID','$dblQty',0,'$strRemark' ,1)" ;  
	
	
	$db->ExecuteQuery($strSQL);
	return true;
	
}

//DELETE BIN ALLOWCATION
//==============================
function deleteBinAllowcation($intBinID)
{
	global $db;
	
	$strSQL="delete from storesbinallocation where strBinID='$intBinID';" ;  
		
	$db->ExecuteQuery($strSQL);
	return true;
	
}

/*GET NEW MAIN STORE ID
function getMainStoreID()
{
	$dbs=new  LoginDBManager();    
	$dbs->OpenConnection();
	$strSQL="select MAX(intID)+1 as intID from mainstores";
	$result=$dbs->RunQuery($strSQL);
	//$nextID=mysql_fetch_field($result["intid"]) ;
	 while($row=mysql_fetch_array($result))
	 {
		 $nextID= $row['intID']  ;
	 }
	 return $nextID;   
}
*/
        

?>
