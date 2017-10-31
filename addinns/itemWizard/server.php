<?php
session_start();


	include"../../Connector.php";


 	$strButton=$_GET["q"];

//Save Sub Category		
if($strButton=="LoadSubCategory")
{ 
	echo $SQL = "SELECT matsubcategory.intSubCatNo, matsubcategory.StrCatCode, matsubcategory.StrCatName, matsubcategory.intCatNo FROM matsubcategory WHERE intStatus = 1 AND intCatNo= ".$_GET["intCatNo"]." ORDER BY matsubcategory.StrCatName;";
	
	$_SESSION["CatID"]=$_GET["intCatNo"];
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		//echo "<option value=\"". "" ."\">" . "" ."Pass</option>" ;
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
    //$intSubCatNo=$_GET["intSubCatNo"];
	$StrCatName=$_GET["StrCatName"];
	$StrCatCode=$_GET["StrCatCode"];
	//$strUserId=$_GET["strUserId"];
	$intDisplay=$_GET["intDisplay"];
	$intInspection=$_GET["intInspection"];
	$intAdditional = $_GET["intAdditional"];
	$intCatNo=$_SESSION["CatID"];


	$SQL_Check="SELECT matsubcategory.intSubCatNo FROM matsubcategory WHERE ((matsubcategory.StrCatName)='".$StrCatName."');";
	
	$result = $db->RunQuery($SQL_Check);	
	
		if($row = mysql_fetch_array($result))
		{
			echo "-1";
		}
		else
		{
			$SQL_Check1="SELECT matsubcategory.intSubCatNo FROM matsubcategory WHERE ((matsubcategory.StrCatCode)='".$StrCatCode."');";
	
			$result1 = $db->RunQuery($SQL_Check1);	
			
			if($row1 = mysql_fetch_array($result1))
			{
				echo "-2";
			}
			else{
		
				$SQL = "insert into matsubcategory (intCatNo,StrCatCode,StrCatName,intDisplay,intInspection,strUserId,dtmDate,intAdditionalAllowed ) values (".$intCatNo.",'".$StrCatCode."','".$StrCatName."',".$intDisplay.",".$intInspection.",'".$_SESSION["UserID"]."',now(),$intAdditional);";
	
				$db->ExecuteQuery($SQL);
				
				$SQL_Check="SELECT matsubcategory.intSubCatNo, matsubcategory.StrCatName FROM matsubcategory WHERE ((matsubcategory.StrCatName)='".$StrCatName."');";
		
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
    $intSubCatNo=$_GET["intSubCatNo"];
	$StrCatName=$_GET["StrCatName"];
	$StrCatCode=$_GET["StrCatCode"];
	//$strUserId=$_GET["strUserId"];
	$intDisplay=$_GET["intDisplay"];
	$intInspection=$_GET["intInspection"];
	$intAdditional = $_GET["intAdditional"];
	$intCatNo=$_SESSION["CatID"];
	
	$sql="update matsubcategory 
	set
	intSubCatNo = '$intSubCatNo' , 
	StrCatName = '$StrCatName' , 
	intDisplay = '$intDisplay' , 
	intInspection = '$intInspection' , 
	dtmDate = now() , 
	intAdditionalAllowed = '$intAdditional',
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

elseif($strButton=="deleteSubCat")
{ 
    $intSubCatNo=$_GET["intSubCatNo"];
		
	$sql="select count(intItemSerial) as num from matitemlist where intSubCatID='$intSubCatNo';";
	
	$result = $db->RunQuery($sql);	
			
	if($row = mysql_fetch_array($result))
	{
		if($row["num"]>0)
			$message = "Unable to delete the Sub Category, it is already used in one or more items.";
		else{		
			$sql="delete from matsubcategory where intSubCatNo = '$intSubCatNo' ;";
						
			$result=$db->RunQuery($sql);	
			if($result==1)
				$message = "Sub Category deleted successfully";		
			else
				$message = "Unable to delete";			
		}
		echo $message;
	}
}

elseif($strButton=="deleteProperty")
{ 
    $intPropertyId=$_GET["ID"];
		
	$sql="select count(intPropertyId) as num from matpropertyassign where intPropertyId='$intPropertyId';";
	
	$result = $db->RunQuery($sql);	
			
	if($row = mysql_fetch_array($result))
	{
		if($row["num"]>0)
			$message = "Unable to delete the Property, it is already assigned to one or more Sub Category.";
		else{		
			$sql="delete from matproperties where intPropertyId = '$intPropertyId';";
						
			$result=$db->RunQuery($sql);	
			if($result==1)
				$message = "Property deleted successfully";		
			else
				$message = "Unable to delete";			
		}
		echo $message;
	}
}



//Save Property & asign to Sub Category
  if($strButton=="Savepro")  
{ 	
		$subCatID = $_GET["subCatID"];
		$sql = "";

			//$strPropertyCode=$_GET["strPropertyCode"];
			$strPropertyName=$_GET["strPropertyName"];
			$assign=$_GET["assign"];
			
			$SQL_Checkproperty=" SELECT matproperties.intPropertyId, matproperties.strPropertyName FROM matproperties WHERE                                  (((matproperties.strPropertyName)='".$strPropertyName."'));";  
		
            $result = $db->RunQuery($SQL_Checkproperty);	
	
		if($row = mysql_fetch_array($result))
		{
		     echo"-1";
			 if($assign==1)
		    {
	     		$intPropertyId=$row["intPropertyId"];
               	$SQL_propasign1="insert into matpropertyassign(intPropertyId,intSubCatId) values (".$intPropertyId.",". $subCatID.");";
			   
		    	$db->ExecuteQuery($SQL_propasign1);				
		    }
		}
		else
		{    
		
		       $SQL_MaxID="SELECT CASE WHEN ( MAX(intPropertyId) IS NULL ) THEN 1 ELSE MAX(intPropertyId)+1 END AS intPropertyId  FROM matproperties;";
			   
			   $result_MaxID = $db->RunQuery($SQL_MaxID);
			   
			if($row_MaxID = mysql_fetch_array($result_MaxID))
		    {
			     $intPropertyId=$row_MaxID["intPropertyId"];
		    }
		      
		    if($assign==1)
		    {
	     		 
               $SQL_property="insert into matproperties(intPropertyId,strPropertyCode,strPropertyName,strUserID,dtmDate) values (". $intPropertyId.",'".$intPropertyId."','".$strPropertyName."','".$_SESSION["UserID"]."',now());";
			 
           $db->ExecuteQuery($SQL_property);
		  
		   
		       $SQL_propasign="insert into matpropertyassign(intPropertyId,intSubCatId) values (".$intPropertyId.",". $subCatID.");";
			   //echo $SQL_propasign;
		    $db->ExecuteQuery($SQL_propasign);
		    echo $intPropertyId;
		   
		    }
			 
		    else
		    {
                  $SQL_property1="insert into matproperties(intPropertyId,strPropertyCode,strPropertyName,strUserID,dtmDate) values                  (".$intPropertyId.",'".$strPropertyCode."','".$strPropertyName."','".$_SESSION["UserID"]."',now());";
		   
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
	
		$SQL_checkproperty="SELECT intSubCatId FROM matpropertyassign WHERE intSubCatId=".$intSubCatId." and intPropertyId=".$intPropertyId.";";		
		
	    $result = $db->RunQuery($SQL_checkproperty);	
	
		if($row = mysql_fetch_array($result))
		{
			echo"This property already exists.";
		}
		else
		{
	
	     $SQL_propertyasign="insert into matpropertyassign(intPropertyId,intSubCatId) values (".$intPropertyId.",".$intSubCatId.");";
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
			


//Save Values
if($strButton=="savevalue")
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
		//echo 'pass1';	
	 }
	 else
	 {
	 	$SQL_maxpropID="SELECT CASE WHEN ( MAX(intSubPropertyNo) IS NULL ) THEN 1 ELSE MAX(intSubPropertyNo)+1 END AS intPropertyId from matpropertyvalues";
		$result_MaxproID = $db->RunQuery($SQL_maxpropID);
		
		if($row_MaxPropID = mysql_fetch_array($result_MaxproID))
		{
			 $maxPropID= $row_MaxPropID["intPropertyId"];
		}
		
		//commnet by roshan -  change strSubPropertyCode for "0"
		
		$SQL_insertNewValue="insert into matpropertyvalues (intSubPropertyNo,strSubPropertyCode,strSubPropertyName,intStatus,strUserID,dtmDate) values(".$maxPropID.",'0','".$strSubPropertyName."',1,".$_SESSION["UserID"].",now()) ";
		
		 $db->RunQuery($SQL_insertNewValue);
		 echo  $maxPropID;
		 //echo 'pass2';
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
		 echo $intSubPropertyNo;
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
		
if($strButton=="SaveFinish")
{   
	  $insertname="";
	  $SubCatid=$_SESSION["SubCatid"];
	  $MainCatid=$_SESSION["CatID"];
	  $propertyid=$_SESSION["property"];
	  $intSubpropNo=array();
	  $count=$_GET["count"];
	  $wastage=$_GET["wastage"];
	  $StrUnit=$_GET["StrUnit"];
	  
   //echo $count;

 for( $loop=0;$loop<$count;$loop++)
 {
 $name="intSubpropNo".$loop;
 //$intSubpropNo[$loop]=$_GET[("intSubpropNo")+$loop];
 //echo $intSubpropNo[$loop];
 $intSubpropNo[$loop]=$_GET["".$name.""];
 //echo $intSubpropNo[$loop];
 } 
 
       $SQL_selmain="select strID from matmaincategory where intID=".$MainCatid.";";
	  $result = $db->RunQuery($SQL_selmain);
	  
	  if($row_strID = mysql_fetch_array($result))
	  {
	  	$strID=$row_strID["strID"];
		 
	  }
	  
	  
	  //maxid
	  $maxitemID=0;
	  $SQL_Maxid="SELECT max(matitemlist.intItemSerial)+1 as intItemSerial  FROM matitemlist;";
	  
	  $result_maxID = $db->RunQuery($SQL_Maxid);
	 
	  if($row_MaxID = mysql_fetch_array( $result_maxID))
	  {
		$maxitemID=$row_MaxID["intItemSerial"];	 			
	  }
	  
	  
	  $SQL_SELsubcatnam="select StrCatName from matsubcategory where intSubCatNo = ".$SubCatid.";";
	  $result_SELsubcatnam = $db->RunQuery($SQL_SELsubcatnam);
	 
	  if($row_SELsubcatnam = mysql_fetch_array($result_SELsubcatnam))
	  {
		$Subcatname=$row_SELsubcatnam["StrCatName"];	 			
	  }
      
 
	  for( $loop=0;$loop<$count;$loop++)
	 {
	  
	    $SQL_selepropnam="select strSubPropertyName from matpropertyvalues where intSubPropertyNo = ".$intSubpropNo[$loop].";";
	     $result_selepropnam = $db->RunQuery($SQL_selepropnam);
	 
	  if($row_selepropnam = mysql_fetch_array($result_selepropnam))
	  {
		$Subpropname=$row_selepropnam["strSubPropertyName"];	 			
	  }
	   
	    $ItemDescription=$Subcatname." ".$Subpropname;
		$insertname=$strID."_".$SubCatid."#".$propertyid[$loop].".".$Subpropname."#";
		
		
		$insert_matitemlist="insert into matitemlist (intItemSerial,strItemCode,strItemDescription,intMainCatID,intSubCatID,strUnit,sngWastage,intStatus,strUserId,dtmDate) values (".$maxitemID.",'".$insertname."','".$ItemDescription."',".$MainCatid.",".$SubCatid.",'".$StrUnit."','".$wastage."',1,".$_SESSION["UserID"].",now());";
		
	
		
		 
		$db->ExecuteQuery($insert_matitemlist);

	 //echo $propertyid[$loop] ."Value=". $intSubpropNo[$loop].",";
	  $maxitemID+=1;
	//echo $insert_matitemlist;		
     }
	 
	 echo "Saved successfully.";
 
}	

if($strButton=="subCategoryID")
{ 
	$SQL = "SELECT CASE WHEN ( MAX(intSubCatNo) IS NULL ) THEN 1 ELSE MAX(intSubCatNo)+1 END AS Num FROM matsubcategory;";	
	$result = $db->RunQuery($SQL);	
	$row = mysql_fetch_array($result);
	
	echo $row["Num"];
 
}	

?>
