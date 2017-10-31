<?php
include "../Connector.php";
$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"SaveMaterial") == 0) 
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ItemCode  = $_GET["ItemCode"];
	$ItemName = $_GET["ItemName"];
	$MainCatID = $_GET["MainCatID"];
	$subCatID = $_GET["subCatID"];
	$Wastage = $_GET["Wastage"];
	$unitID = $_GET["unitID"];
	$useID = $_SESSION["UserID"];
	if (!$Wastage)
		$Wastage = 0;
	
	$itemExists = false;
	$sql = "SELECT strItemDescription FROM matitemlist WHERE strItemDescription = '$ItemName'";
	
	$result = $db->RunQuery($sql);	 
	 while($row = mysql_fetch_array($result))
  	 {
  	 	$itemExists = true;
  	 	break;
  	 }
	
	if (!$itemExists)
	{
		$ItemCode = str_replace(",", "#", $ItemCode);
		$sql = "insert into matitemlist (strItemCode,strItemDescription,intMainCatID,intSubCatID,strUnit,sngWastage,intStatus,strUserId,dtmDate) values ('$ItemCode','$ItemName',$MainCatID,$subCatID,'$unitID',$Wastage,1,'$useID',now())";


		$db->executeQuery($sql);
	}
	$ResponseXML .= "<RequestDetails>\n";
	if ($itemExists)
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";   
		$ResponseXML .= "<Message><![CDATA[The item name already exists.]]></Message>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";   
		$ResponseXML .= "<Message><![CDATA[The new item added successfully.\nItem Code : $ItemCode \nItem Name :$ItemName]]></Message>\n";
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

else if (strcmp($RequestType,"getOtherProperties") == 0) 
{
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	 $ResponseXML = "";
	 $propID = $_GET["PropID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getOtherPropertyValues($propID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
         $ResponseXML .= "<PropID><![CDATA[" . $row["intSubPropertyNo"]  . "]]></PropID>\n";   
		 $ResponseXML .= "<PropName><![CDATA[" . $row["strSubPropertyName"]  . "]]></PropName>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}

else if($RequestType=="savevalue")
{
 	$strSubPropertyName=$_GET["strSubPropertyName"];
    $intPropertyId=$_GET["intPropertyId"];
	$assivalu=$_GET["assivalu"];	
	
	
	
	 $intSubPropertyNo=0;
	 $maxPropID=0;
	 $maxValID=0;
	 
	 
	 //add new Values
	 if(!$strSubPropertyName=="" && $intPropertyId=="" && $assivalu==0 || !$strSubPropertyName=="" && !$intPropertyId=="" && $assivalu==0  )
{
	 	$SQL_Checkvalue="select intSubPropertyNo,strSubPropertyName  from matpropertyvalues where strSubPropertyName='".$strSubPropertyName."';";
	 
	 $result = $db->RunQuery($SQL_Checkvalue);
	 
	 if($row = mysql_fetch_array($result))
	 {	 	
	 	echo"-1";		
	 }
	 else
	 {
	 	$SQL_maxpropID="SELECT CASE WHEN ( MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END AS intPropertyId from matpropertyvalues";
		$result_MaxproID = $db->RunQuery($SQL_maxpropID);
		
		if($row_MaxPropID = mysql_fetch_array($result_MaxproID))
		{
			 $maxPropID= $row_MaxPropID["intPropertyId"];
		}
		
		$SQL_insertNewValue="insert into matpropertyvalues (intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) values(".$maxPropID.",'".$intPropertyId."','".$strSubPropertyName."',1,".$_SESSION["UserID"].",now()) ";
		
		 $db->ExecuteQuery($SQL_insertNewValue);
		 echo  $maxPropID;
	 } 
	
}

		//Assign New Value for Property
	 
	if(!$strSubPropertyName=="" && !$intPropertyId=="" && $assivalu==1 )
    {  
	 	
	 	$MaxPropID=0;		
		
	 	$SQL="select intSubPropertyNo,strSubPropertyName  from matpropertyvalues where strSubPropertyName='".$strSubPropertyName."';";
		 
	 
	$result = $db->RunQuery($SQL);
	 
		 if($row = mysql_fetch_array($result))
	 	{
	 		$intSubPropertyNo=$row["intSubPropertyNo"];	 			
		}
		else
		{
			
			$SQL_maxValID="SELECT CASE WHEN ( MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END AS intPropertyId FROM matpropertyvalues";
			$result_MaxValID = $db->RunQuery($SQL_maxValID);
			if($row_MaxValID = mysql_fetch_array($result_MaxValID))
			{
				$intSubPropertyNo=$row_MaxValID["intPropertyId"];
			}
			
			$SQL_insertNewValue="insert into matpropertyvalues (intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) values(".$intSubPropertyNo.",'".$intPropertyId."','".$strSubPropertyName."',1,".$_SESSION["UserID"].",now()) ";
		
		 $db->ExecuteQuery($SQL_insertNewValue);

		 //echo "New value ".$strSubPropertyName." Saved successfully.";
	
		}
	
		$SQL1="SELECT matsubpropertyassign.intPropertyId, matsubpropertyassign.intSubPropertyid, matpropertyvalues.strSubPropertyName, matproperties.strPropertyName
FROM (matpropertyvalues INNER JOIN matsubpropertyassign ON matpropertyvalues.intSubPropertyNo = matsubpropertyassign.intSubPropertyid) INNER JOIN matproperties ON matsubpropertyassign.intPropertyId = matproperties.intPropertyId
WHERE (((matsubpropertyassign.intPropertyId)=".$intPropertyId.") AND ((matsubpropertyassign.intSubPropertyid)=".$intSubPropertyNo."));";

        $result_addpropval = $db->RunQuery($SQL1);
		if($row_addpropval = mysql_fetch_array($result_addpropval))
	 	{	 		
	 		echo "-1";
			//echo $strSubPropertyName."  is all ready exists for Property " . $row_addpropval["strPropertyName"];		
		}
		else
	    {
			$SQL_maxPropID="SELECT CASE WHEN ( MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END as intSubPropertyNo FROM matsubpropertyassign; ";
			$result_maxProID = $db->RunQuery($SQL_maxPropID);
	 
			if($row_MaxProID = mysql_fetch_array($result_maxProID))
			{
				$MaxPropID=$row_MaxProID["intSubPropertyNo"];	 			
			}
			
			$SQL_Insertval="insert into matsubpropertyassign (intSubPropertyNo,intPropertyId,intSubPropertyid,intStatus) values (".$MaxPropID.",".$intPropertyId.",".$intSubPropertyNo.",1)";
			$result=$db->ExecuteQuery($SQL_Insertval);
			//echo "Saved successfully";
		 	
		}
		
    }

}

//Assign Value to Property
if($RequestType=="Assign")
{
   $intPropertyId=$_GET["intPropertyId"];
   $intSubPropertyid=$_GET["intSubPropertyid"];
   $strSubPropName=$_GET["SubPropertyName"];

          /*$SQL_MaxID="SELECT CASE WHEN ( MAX(intPropertyId) IS NULL ) THEN 1 ELSE MAX(intPropertyId)+1 END AS intPropertyId  FROM matproperties;";
			   
			   $result_MaxID = $db->RunQuery($SQL_MaxID);
			   
			if($row_MaxID = mysql_fetch_array($result_MaxID))
		    {
			     $intPropertyId=$row_MaxID["intPropertyId"];
		    } */
   
// commented on 2009-09-17 for helaclothing error reported by priya  
   $SQL_checkvalue="SELECT matsubpropertyassign.intSubPropertyid FROM matsubpropertyassign WHERE (((matsubpropertyassign.intSubPropertyid)=".$intSubPropertyid.") AND ((matsubpropertyassign.intPropertyId)=".$intPropertyId."));";
   
   // commented on 2009-10-14 for jinadasa error reported by vipula 
   //$SQL_checkvalue = "SELECT* FROM matpropertyvalues WHERE strSubPropertyCode = '$intPropertyId'  AND intSubPropertyNo = '$intSubPropertyid'";
        $result = $db->RunQuery($SQL_checkvalue);	
	
		if($row = mysql_fetch_array($result))
		{
			echo "false";
			//echo  $SQL_checkvalue;
		}
		else
		{	
			$intSubPropertyNo=0;
			
			$SQL="insert into matsubpropertyassign(intPropertyId,intSubPropertyid) values(".$intPropertyId.",".$intSubPropertyid.")";
			//$sql = "INSERT INTO matpropertyvalues (intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) VALUES(".$maxPropID.",'".$intPropertyId."','".$strSubPropertyName."',1,".$_SESSION["UserID"].",now()) ";
		    $db->ExecuteQuery($SQL);
			//echo "true";
			
			 // commented on 2009-10-14 for jinadasa error reported by vipula 
			 /*
			$SQL="select  max(intSubPropertyNo)+1 as intSubPropertyNo from matpropertyvalues";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$intSubPropertyNo=$row["intSubPropertyNo"];
			}
			
			$SQL="insert into matpropertyvalues(intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) values(".$intSubPropertyNo.",$intPropertyId,'".$strSubPropName."',1,'".$_SESSION["UserID"]."',now())";
			
		    $db->ExecuteQuery($SQL);
		   */
			//echo $SQL;
		   echo "true";
		}
		

}

function getOtherPropertyValues($propID)
{
	global $db;
	/*
	$sql= "select intSubPropertyNo,strSubPropertyName from matpropertyvalues where intSubPropertyNo not in (
SELECT matpropertyvalues.intSubPropertyNo
FROM (matproperties INNER JOIN matsubpropertyassign ON matproperties.intPropertyId = matsubpropertyassign.intPropertyId) INNER JOIN matpropertyvalues ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo
WHERE (((matproperties.intPropertyId)=$propID))); " ;
*/
$sql = "SELECT intSubPropertyNo,strSubPropertyName FROM matpropertyvalues WHERE strSubPropertyCode <> $propID order by strSubPropertyName";
	return $db->RunQuery($sql);
}
?>