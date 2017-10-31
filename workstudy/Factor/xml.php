<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 

$RequestType = $_GET["RequestType"];
//--------------------------------------------------------------------
if($RequestType=="saveFactorName")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$name = $_GET["name"];
	
	
	   $sql= "select * from ws_factors where strName ='".$name."'";
	 $res3= $db->RunQuery($sql);
	$row = mysql_fetch_array($res3);
	$exist = $row["intId"];
	
	if($exist==""){	
		   $sql_save="INSERT INTO 
					ws_factors(strName)
					VALUE
					('$name')";	
					//echo $sql_save;
		$res=$db->RunQuery($sql_save);
		}
		else{
	
		$res2=1;
		}
		
		
	 if($res!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else if($res2!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[exist]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//--------------------------------------------------------------------
if($RequestType=="saveMachineFactors")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLSave>";
	
	$machineId=trim($_GET["machineId"]);
	$stitchTypeId=trim($_GET["stitchTypeId"]);
	$seamTypeId=trim($_GET["seamTypeId"]);
	$length=trim($_GET["length"]);	
	
	 $SQL="SELECT * FROM ws_machinefactors WHERE intMachineTypeId='$machineId' and intStitchTypeId='$stitchTypeId'";
	$result = $db->RunQuery($SQL);	
	$row = mysql_fetch_array($result);
		
	if($row["intMachineTypeId"]=='')
	{
    	$query="INSERT INTO ws_machinefactors (intMachineTypeId,intStitchTypeId,intSeamTypeId,dblFactor)
				VALUES
				('$machineId','$stitchTypeId',$seamTypeId,$length)";											 
		$message = "Saved successfully."; 
	}
	else
	{
		$query="UPDATE ws_machinefactors SET 
                                    dblFactor='$length',intSeamTypeId='$seamTypeId'  
									WHERE intMachineTypeId='$machineId' and 
									intStitchTypeId='$stitchTypeId'";
		$message = "Updated successfully.";
	}
	
	$result = $db->ExecuteQuery($query);
	if($result)
		$ResponseXML .="<response><![CDATA[".$message."]]></response>\n";
	else	
		$ResponseXML .="<response><![CDATA[".$query."]]></response>\n";
		
	echo $ResponseXML .="</XMLSave>";
}
//--------------------------------------------------------------------
if($RequestType=="deleteFactor")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLDelete>";
	
	$machineId=trim($_GET["machineId"]);
	$stitchTypeId=trim($_GET["stitchTypeId"]);
	
	$SQL="DELETE FROM ws_machinefactors WHERE intMachineTypeId='$machineId' and intStitchTypeId='$stitchTypeId'";
	$db->ExecuteQuery($SQL);
	
	$message= "Deleted successfully.";
	$ResponseXML .="<response><![CDATA[".$message."]]></response>\n";
	
echo $ResponseXML .="</XMLDelete>";
	
 }

//--------------------------------------------------------------------
if($RequestType=="loadMachineFactorDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$machineId=trim($_GET["machineId"]);
	$stitchTypeId=trim($_GET["stitchTypeId"]);
	$seamTypeId=trim($_GET["seamTypeId"]);
	
	$ResponseXML="<XMLmachinesFactors>";
	
	  $SQL="SELECT * FROM ws_machinefactors WHERE intMachineTypeId='$machineId' and intStitchTypeId='$stitchTypeId'";
	  if($seamTypeId!=''){
	  $SQL .= " and intSeamTypeId='$seamTypeId'";
	  }
	  
	//  echo $SQL;
	
	$result = $db->RunQuery($SQL);	
	$j=0;
	while($row = mysql_fetch_array($result))
		{
		$j++;
		$ResponseXML .="<seamType><![CDATA[".$row["intSeamTypeId"]."]]></seamType>\n";
		$ResponseXML .="<length><![CDATA[".$row["dblFactor"]."]]></length>\n";
		}
		if($j==0){
		$ResponseXML .="<seamType><![CDATA[".$seamTypeId."]]></seamType>\n";
		$ResponseXML .="<length><![CDATA[]]></length>\n";
		}
				
$ResponseXML .="</XMLmachinesFactors>"; 
echo $ResponseXML;
} 

if($RequestType=="delete")
{
	$machineId=trim($_GET["machineId"]);
	
	$newDELETE = "DELETE FROM ws_machinefactors WHERE intId=$machineId";
	$result = $db->RunQuery($newDELETE);
	
	$message= "Deleted successfully.";
	
	echo $message;
	
}
?>