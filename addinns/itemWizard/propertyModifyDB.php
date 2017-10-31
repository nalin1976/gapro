<?php
	session_start();
	include"../../Connector.php";

 	$strButton=$_GET["q"];
	
	if($strButton=="Save")
	{ 
		$intPropertyId=$_GET["intPropertyId"];		
		$strPropertyName=$_GET["strPropertyName"];	
		
		$sql1="SELECT count(intPropertyId) as num FROM matproperties WHERE strPropertyName='".$strPropertyName."';";		
		$result1=$db->RunQuery($sql1);	
		$message="";
		
		if($row1 = mysql_fetch_array($result1))
		{
			if($row1["num"]>0)
				$message = "Property is already exist";
			
			else{
		
				$sql="update matproperties set strPropertyName = '$strPropertyName' , dtmDate = now() where intPropertyId = '$intPropertyId' ;";		
				$result=$db->RunQuery($sql);	
				if($result==1)
					$message = "Property modified successfully";		
				else
					$message = "Unable to modify";		
			}
		}		
		echo $message;	
	}
	
	elseif($strButton=="Delete")
	{ 
		$intPropertyId=$_GET["intPropertyId"];
			
		$sql="delete from matproperties where intPropertyId = '$intPropertyId';";
							
		$result=$db->RunQuery($sql);	
		if($result==1)
			$message = "Property deleted successfully";		
		else
			$message = "Unable to delete";			
			
		echo $message;
	}

/*

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
			echo"This property allready exists.";
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

         
   $SQL_checkvalue="SELECT matsubpropertyassign.intSubPropertyid FROM matsubpropertyassign WHERE (((matsubpropertyassign.intSubPropertyid)=".$intSubPropertyid.") AND ((matsubpropertyassign.intPropertyId)=".$intPropertyId."));";
   
   
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
			
		    $db->ExecuteQuery($SQL);
			
		   echo "true";
		}
}
*/			

?>
