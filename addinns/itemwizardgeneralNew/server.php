<?php
session_start();
include"../../Connector.php";
$strButton=$_GET["q"];

//Save Sub Category		
if($strButton=="LoadSubCategory")
{ 
	echo $SQL = "SELECT genmatsubcategory.intSubCatNo, genmatsubcategory.StrCatCode, genmatsubcategory.StrCatName, genmatsubcategory.intCatNo FROM genmatsubcategory WHERE intStatus = 1 AND intCatNo= ".$_GET["intCatNo"]." ORDER BY genmatsubcategory.StrCatName;";
	
	$_SESSION["CatID"]=$_GET["intCatNo"];	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if(isset($_SESSION["intCatNo"]))
		{
			if ($_SESSION["intCatNo"] == $row["intSubCatNo"] )
				echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
			else
				echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
	}
}
else if($strButton=="Save")
{
	$StrCatName		= $_GET["StrCatName"];
	$StrCatCode		= $_GET["StrCatCode"];
	$allowEx		= $_GET["allowEx"];
	$category		= $_GET["category"];
	$categoryId		= $_GET["categoryId"];
	
	if($category=="S")
	{
		$sql = "insert into genmatmaincategory 
		(strID, 
		strDescription, 
		dblGRNExcess, 
		status)
		values
		('$StrCatCode', 
		'$StrCatName', 
		'$allowEx', 
		'1');";	
		$result=$db->RunQuery($sql);
		
		if($result)
			echo "Saved successfully.";
	}
	else if($category=="U")
	{
		$sql = "update genmatmaincategory 
		set
		strID = '$StrCatCode' , 
		strDescription = '$StrCatName' , 
		dblGRNExcess = '$allowEx' , 
		status = '1'	
		where
		intID = '$categoryId' ;";	
		$result=$db->RunQuery($sql);
		if($result)
			echo "Updated successfully.";
	}
}
else if($strButton=="SaveSubCategory")
{ 
	$StrCatName=$_GET["StrCatName"];
	$StrCatCode=$_GET["StrCatCode"];
	$intDisplay=$_GET["intDisplay"];
	$intInspection=$_GET["intInspection"];
	$intAdditional = $_GET["intAdditional"];
	$intCatNo=$_GET["mainCatId"];

	$SQL_Check="SELECT intSubCatNo FROM genmatsubcategory WHERE StrCatName='".$StrCatName."';";	
	$result = $db->RunQuery($SQL_Check);	
	
		if($row = mysql_fetch_array($result))
		{
			echo "-1";
		}
		else
		{
			$SQL_Check1="SELECT intSubCatNo FROM genmatsubcategory WHERE StrCatCode='".$StrCatCode."';";	
			$result1 = $db->RunQuery($SQL_Check1);	
			
			if($row1 = mysql_fetch_array($result1))
			{
				echo "-2";
			}
			else{
		
				$SQL = "insert into genmatsubcategory (intCatNo,StrCatCode,StrCatName,intDisplay,intInspection,strUserId,dtmDate) values (".$intCatNo.",'".$StrCatCode."','".$StrCatName."',".$intDisplay.",".$intInspection.",'".$_SESSION["UserID"]."',now());";
				$db->ExecuteQuery($SQL);

				$SQL_Check="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE StrCatName='".$StrCatName."';";		
				$result = $db->RunQuery($SQL_Check);
				$ResponseXML="";				
				while($row = mysql_fetch_array($result))
				 {
					if($StrCatName==$row["StrCatName"])
					  $ResponseXML .="<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
					else
					  $ResponseXML .="<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
				 }
				 echo $ResponseXML;	
			}
		}
}
elseif($strButton=="SaveModify")
{ 
$intSubCatNo	= $_GET["intSubCatNo"];
$StrCatName		= $_GET["StrCatName"];
$StrCatCode		= $_GET["StrCatCode"];
$intDisplay		= $_GET["intDisplay"];
$intInspection	= $_GET["intInspection"];
$intCatNo		= $_GET["mainCatId"];
	
	$sql="update genmatsubcategory 
	set
	intSubCatNo = '$intSubCatNo' , 
	StrCatName = '$StrCatName' , 
	intDisplay = '$intDisplay' , 
	intInspection = '$intInspection' , 
	dtmDate = now() , 
	intCatNo='$intCatNo'	
	where
	intSubCatNo = '$intSubCatNo' ;";
	
	$result=$db->RunQuery($sql);	
	if($result==1)
		$message = "Sub Category updated successfully";		
	else
		$message = "Unable to update";			
	
	echo $message;	
}
elseif($strButton=="DeleteMainCategory")
{ 
    $mainCatID=$_GET["MainCatID"];
		
	$sql="select count(intSubCatNo) as num from genmatsubcategory where intCatNo='$mainCatID';";	
	$result = $db->RunQuery($sql);
			
	if($row = mysql_fetch_array($result))
	{
		if($row["num"]>0)
			$message = "Unable to delete the Main Category, it is already used in one or more items.";
		else{		
			$sql="delete from genmatmaincategory where intID = '$mainCatID' ;";						
			$result=$db->RunQuery($sql);	
			if($result==1)
				$message = "D
				eleted successfully";		
			else
				$message = "Unable to delete";			
		}
		echo $message;
	}
}
elseif($strButton=="deleteSubCat")
{ 
    $intSubCatNo=$_GET["intSubCatNo"];
		
	$sql="select count(intItemSerial) as num from genmatitemlist where intSubCatID='$intSubCatNo';";
	$result = $db->RunQuery($sql);			
	if($row = mysql_fetch_array($result))
	{
		if($row["num"]>0)
			$message = "Unable to delete the Sub Category, it is already used in one or more items.";
		else
		{		
			$sql="delete from genmatsubcategory where intSubCatNo = '$intSubCatNo' ;";
						
			$result=$db->RunQuery($sql);	
			if($result==1)
				$message = "Deleted successfully.";		
			else
				$message = "Unable to delete";			
		}
		echo $message;
	}
}
else if($strButton=="Savepro")  
{ 	
$subCatID 			= $_GET["subCatID"];
$strPropertyName 	= $_GET["strPropertyName"];
$assign				= $_GET["assign"];
			
	$SQL_Checkproperty=" SELECT intPropertyId,strPropertyName FROM genmatproperties WHERE strPropertyName='".$strPropertyName."';";  
    $result = $db->RunQuery($SQL_Checkproperty);	
	if($row = mysql_fetch_array($result))
	{
		echo"-1";
		if($assign==1)
		{
			$intPropertyId=$row["intPropertyId"];
			$SQL_propasign1="insert into genmatpropertyassign(intPropertyId,intSubCatId) values (".$intPropertyId.",". $subCatID.");";		   
			$db->ExecuteQuery($SQL_propasign1);				
		}
	}
	else
	{    
		$SQL_MaxID="SELECT CASE WHEN ( MAX(intPropertyId) IS NULL ) THEN 1 ELSE MAX(intPropertyId)+1 END AS intPropertyId  FROM genmatproperties;";			   
		$result_MaxID = $db->RunQuery($SQL_MaxID);
					   
		if($row_MaxID = mysql_fetch_array($result_MaxID))
		{
			$intPropertyId=$row_MaxID["intPropertyId"];
		}
		      
		if($assign==1)
		{	     		 
			$SQL_property="insert into genmatproperties(intPropertyId,strPropertyCode,strPropertyName,strUserID,dtmDate) values (". $intPropertyId.",'".$intPropertyId."','".$strPropertyName."','".$_SESSION["UserID"]."',now());";			 
           $db->ExecuteQuery($SQL_property);		  
		   
			$SQL_propasign="insert into genmatpropertyassign(intPropertyId,intSubCatId) values (".$intPropertyId.",". $subCatID.");";
		    $db->ExecuteQuery($SQL_propasign);
		    echo $intPropertyId;		   
		}		 
		else
		{
			$SQL_property1="insert into genmatproperties(intPropertyId,strPropertyCode,strPropertyName,strUserID,dtmDate) values (".$intPropertyId.",'".$strPropertyCode."','".$strPropertyName."','".$_SESSION["UserID"]."',now());";
            $db->ExecuteQuery($SQL_property1);
		    echo $intPropertyId;
		 }		   
	}
}

//Asign Property to Sub Category
if($strButton=="Add")
{  
    $intSubCatId=$_GET["intSubCatId"];
	$intPropertyId=$_GET["intPropertyId"];
	//$strPropName=$_GET["strPropName"];
	
		$SQL_checkproperty="SELECT intSubCatId FROM genmatpropertyassign WHERE intSubCatId=".$intSubCatId." and intPropertyId=".$intPropertyId.";";		
		
	    $result = $db->RunQuery($SQL_checkproperty);	
	
		if($row = mysql_fetch_array($result))
		{
			echo"This property already exists.";
		}
		else
		{
	
	     $SQL_propertyasign="insert into genmatpropertyassign(intPropertyId,intSubCatId) values (".$intPropertyId.",".$intSubCatId.");";
		    $db->ExecuteQuery($SQL_propertyasign);
		    echo "The Property saved successfully.";
		}
}
//Assign Value to Property
if($strButton=="Assign")
{
   $intPropertyId=$_GET["intPropertyId"];
   $intSubPropertyid=$_GET["intSubPropertyid"];
   $strSubPropName=$_GET["SubPropertyName"];
   
// commented on 2009-09-17 for helaclothing error reported by priya  
   $SQL_checkvalue="SELECT genmatsubpropertyassign.intSubPropertyid FROM genmatsubpropertyassign WHERE (((genmatsubpropertyassign.intSubPropertyid)=".$intSubPropertyid.") AND ((genmatsubpropertyassign.intPropertyId)=".$intPropertyId."));";   
        $result = $db->RunQuery($SQL_checkvalue);	
	
		if($row = mysql_fetch_array($result))
		{
			echo "false";
		}
		else
		{	
			$intSubPropertyNo=0;
			
			$SQL="insert into genmatsubpropertyassign(intPropertyId,intSubPropertyid) values(".$intPropertyId.",".$intSubPropertyid.")";
		    $db->ExecuteQuery($SQL);
		   	echo "true";
		}
}
			


//Save Values
if($strButton=="savevalue")
{
$strSubPropertyName	= $_GET["strSubPropertyName"];
$intPropertyId		= $_GET["intPropertyId"];
$assivalu			= $_GET["assivalu"];	
$intSubPropertyNo	= 0;
$maxPropID			= 0;
$maxValID			= 0;
	 //add new Values
	if(!$strSubPropertyName=="" && $intPropertyId=="" && $assivalu==0 || !$strSubPropertyName=="" && !$intPropertyId=="" && $assivalu==0  )
	{
		$SQL_Checkvalue="select intSubPropertyNo,strSubPropertyName from genmatpropertyvalues where strSubPropertyName='".$strSubPropertyName."';";	
		$result = $db->RunQuery($SQL_Checkvalue);
	
		if($row = mysql_fetch_array($result))
		{	 	
			echo"-1";	
		}
		else
		{
			$SQL_maxpropID="SELECT CASE WHEN ( MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END AS intPropertyId from genmatpropertyvalues";
			$result_MaxproID = $db->RunQuery($SQL_maxpropID);
			
			if($row_MaxPropID = mysql_fetch_array($result_MaxproID))
			{
				 $maxPropID= $row_MaxPropID["intPropertyId"];
			}
			
			//commnet by roshan -  change strSubPropertyCode for "0"
			$SQL_insertNewValue="insert into genmatpropertyvalues (intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) values(".$maxPropID.",'0','".$strSubPropertyName."',1,".$_SESSION["UserID"].",now()) ";
			
			 $db->RunQuery($SQL_insertNewValue);
			 echo  $maxPropID;
		} 
	}
	//Assign New Value for Property
	if(!$strSubPropertyName=="" && !$intPropertyId=="" && $assivalu==1 )
    {  
	 	$MaxPropID=0;		
	 	$SQL="select intSubPropertyNo,strSubPropertyName  from genmatpropertyvalues where strSubPropertyName='".$strSubPropertyName."';";	 
		$result = $db->RunQuery($SQL);
	 
		if($row = mysql_fetch_array($result))	 	
	 		$intSubPropertyNo=$row["intSubPropertyNo"];		
		else
		{			
			$SQL_maxValID="SELECT CASE WHEN ( MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END AS intPropertyId FROM genmatpropertyvalues";
			$result_MaxValID = $db->RunQuery($SQL_maxValID);
			if($row_MaxValID = mysql_fetch_array($result_MaxValID))
			{
				$intSubPropertyNo=$row_MaxValID["intPropertyId"];
			}
			
			$SQL_insertNewValue="insert into genmatpropertyvalues (intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) values(".$intSubPropertyNo.",'".$intPropertyId."','".$strSubPropertyName."',1,".$_SESSION["UserID"].",now()) ";		
		 	$db->ExecuteQuery($SQL_insertNewValue);
		 	echo $intSubPropertyNo;	
		}
	
		$SQL1="SELECT genmatsubpropertyassign.intPropertyId, genmatsubpropertyassign.intSubPropertyid, genmatpropertyvalues.strSubPropertyName, genmatproperties.strPropertyName
FROM (genmatpropertyvalues INNER JOIN genmatsubpropertyassign ON genmatpropertyvalues.intSubPropertyNo = genmatsubpropertyassign.intSubPropertyid) INNER JOIN genmatproperties ON genmatsubpropertyassign.intPropertyId = genmatproperties.intPropertyId
WHERE (((genmatsubpropertyassign.intPropertyId)=".$intPropertyId.") AND ((genmatsubpropertyassign.intSubPropertyid)=".$intSubPropertyNo."));";

        $result_addpropval = $db->RunQuery($SQL1);
		if($row_addpropval = mysql_fetch_array($result_addpropval))
	 	{	 		
	 		echo "-1";
		}
		else
	    {
			$SQL_maxPropID="SELECT CASE WHEN (MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END as intSubPropertyNo FROM genmatsubpropertyassign; ";
			$result_maxProID = $db->RunQuery($SQL_maxPropID);
	 
			if($row_MaxProID = mysql_fetch_array($result_maxProID))
			{
				$MaxPropID=$row_MaxProID["intSubPropertyNo"];	 			
			}
			
			$SQL_Insertval="insert into genmatsubpropertyassign (intSubPropertyNo,intPropertyId,intSubPropertyid,intStatus) values (".$MaxPropID.",".$intPropertyId.",".$intSubPropertyNo.",1)";
			$result=$db->ExecuteQuery($SQL_Insertval);
		}
    }
}
		
if($strButton=="SaveFinish")
{   
$insertname="";
$SubCatid		= $_SESSION["SubCatid"];
$MainCatid		= $_SESSION["CatID"];
$propertyid		= $_SESSION["property"];
$intSubpropNo	= array();
$count			= $_GET["count"];
$wastage		= $_GET["wastage"];
$StrUnit		= $_GET["StrUnit"];

	for( $loop=0;$loop<$count;$loop++)
	{
		$name="intSubpropNo".$loop;
		$intSubpropNo[$loop]=$_GET["".$name.""];
	} 

	$SQL_selmain="select strID from genmatmaincategory where intID=".$MainCatid.";";
	$result = $db->RunQuery($SQL_selmain);	  
	if($row_strID = mysql_fetch_array($result))
	{
		$strID=$row_strID["strID"];
	}

	$maxitemID=0;
	$SQL_Maxid="SELECT max(genmatitemlist.intItemSerial)+1 as intItemSerial  FROM genmatitemlist;";	  
	$result_maxID = $db->RunQuery($SQL_Maxid);	 
	if($row_MaxID = mysql_fetch_array( $result_maxID))
	{
		$maxitemID=$row_MaxID["intItemSerial"];	 			
	}

	$SQL_SELsubcatnam="select StrCatName from genmatsubcategory where intSubCatNo = ".$SubCatid.";";
	$result_SELsubcatnam = $db->RunQuery($SQL_SELsubcatnam);
	
	if($row_SELsubcatnam = mysql_fetch_array($result_SELsubcatnam))
	{
		$Subcatname=$row_SELsubcatnam["StrCatName"];	 			
	}

	for( $loop=0;$loop<$count;$loop++)
	{
		$SQL_selepropnam="select strSubPropertyName from genmatpropertyvalues where intSubPropertyNo = ".$intSubpropNo[$loop].";";
		$result_selepropnam = $db->RunQuery($SQL_selepropnam);
	
		if($row_selepropnam = mysql_fetch_array($result_selepropnam))
		{
			$Subpropname=$row_selepropnam["strSubPropertyName"];	 			
		}
	
		$ItemDescription=$Subcatname." ".$Subpropname;
		$insertname=$strID."_".$SubCatid."#".$propertyid[$loop].".".$Subpropname."#";
	
		$insert_matitemlist="insert into genmatitemlist (intItemSerial,strItemCode,strItemDescription,intMainCatID,intSubCatID,strUnit,sngWastage,intStatus,strUserId,dtmDate) values (".$maxitemID.",'".$insertname."','".$ItemDescription."',".$MainCatid.",".$SubCatid.",'".$StrUnit."','".$wastage."',1,".$_SESSION["UserID"].",now());";
		$db->ExecuteQuery($insert_matitemlist);
		$maxitemID+=1;
	}
echo "Saved successfully.";
}	

if($strButton=="subCategoryID")
{ 
	$SQL = "SELECT CASE WHEN ( MAX(intSubCatNo) IS NULL ) THEN 1 ELSE MAX(intSubCatNo)+1 END AS Num FROM genmatsubcategory;";	
	$result = $db->RunQuery($SQL);	
	$row = mysql_fetch_array($result);	
	echo $row["Num"]; 
}	
?>