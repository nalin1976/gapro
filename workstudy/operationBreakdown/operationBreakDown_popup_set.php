<?php
include "../../Connector.php";
$id = $_GET['id'];

if($id=='saveCategory')
{
	$name = $_GET["name"];
	$sql = "INSERT INTO `componentcategory` (`strCategory`,`strDescription`) VALUES ('$name','$name')";
	$x = $db->RunQuery2($sql);
	if($x[0]==1062)
		echo $x[1];
}
//saveComponents
else if($id=='saveComponents')
{
	$name = $_GET["name"];
	$intCatId = $_GET['intCatId'];
	
	$sql = "INSERT INTO `components` (`intCategory`,`strComponent`,`strDescription`) VALUES ('$intCatId','$name','$name')";
	$x = $db->RunQuery2($sql);
	if($x[0]==1062)
		echo $x[1];
}
else if($id=='saveOperation')
{
	$intCatId = $_GET["intCatId"];
	$intCompId = $_GET['intCompId'];
	$strComp = $_GET['strComp'];
	$name      = $_GET['name'];
	
	///////////////////////////////// before update components ///////////////////////////////
	$sql = "INSERT INTO `components` (`intCategory`,`strComponent`,`strDescription`) VALUES ('$intCatId','$strComp','$strComp')";
	$intNewCompId = $db->AutoIncrementExecuteQuery($sql);
	if($intNewCompId>0)
		$intCompId = $intNewCompId;
	//////////////////////////////////////////////////////////////////////////////////////////
	
	$sql = "INSERT INTO `ws_operations` (`intCompCatId`,`intCompId`,`strOperationCode`,`strOperationName`) VALUES ('$intCatId','$intCompId','$name','$name')";
	$x = $db->RunQuery2($sql);
	if($x[0]==1062)
		echo $x[1];
}
else if($id=='saveMachine')
{
	$name      = $_GET['name'];
	$sql = "INSERT INTO ws_machines(strName) VALUES ('$name')";
	$x = $db->RunQuery2($sql);
	if($x[0]==1062)
		echo $x[1];
}
else if($id=='saveMachineType')
{
	$name      = $_GET['name'];
	$intHelper = $_GET['intHelper'];
	$intMachine = $_GET['intMachine'];
	$sql = "INSERT INTO `ws_machinetypes` (`strMachineCode`,`strMachineName`,`intMachineId`,intHelper) VALUES ('$name','$name','$intMachine','$intHelper')";
	$x = $db->RunQuery2($sql);
	if($x[0]==1062)
		echo $x[1];
}
else if($id=='allocateToTables')
{
	$intCategory      	= $_GET['intCategory'];
	
	$intComponentId 	= $_GET['intComponentId'];
	$strComponent 		= $_GET['intComponent'];
	
	$intOperationId	 	= $_GET['intOperationId'];
	$strOperation	 	= $_GET['intOperation'];
	
	$intManual	 		= $_GET['intManual'];
	
	$intMachine 		= $_GET['intMachine'];
	
	$intMachineTypeId 	= $_GET['intMachineTypeId'];
	$strMachineType 	= $_GET['intMachineType'];
	
	$dblSMV 			= $_GET['dblSMV'];
	$dblTMU				=round(1667*$dblSMV,2);
	
	/////////////////////////////// FIRST ALLOCATE COMPONENT TO CATEGORY //////////////////////////////////
	$sql = "INSERT INTO `components` (`intCategory`,`strComponent`,`strDescription`) VALUES ('$intCategory','$strComponent','$strComponent')";
	$x = $db->RunQuery2($sql);
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////// FIRST ALLOCATE COMPONENT TO CATEGORY //////////////////////////////////
	$sql = "INSERT INTO `ws_operations` (`intCompCatId`,`intCompId`,`strOperationCode`,`strOperationName`) 
			VALUES ('$intCategory','$intComponentId','$strOperation','$strOperation')";
	$x = $db->RunQuery2($sql);
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////// FIRST ALLOCATE COMPONENT TO CATEGORY //////////////////////////////////
	$sql = "delete FROM ws_smv WHERE  ws_smv.intMachineTypeId =  '$intMachineTypeId' AND ws_smv.intOperationId =  '$intOperationId'";
	$result = $db->RunQuery($sql);
	
	$sql = "INSERT INTO `ws_smv` (`intMachineTypeId`,`intOperationId`,`dblSMV`,`dblTMU`) 
			VALUES ('$intMachineTypeId','$intOperationId','$dblSMV','$dblTMU')";
	$x = $db->RunQuery2($sql);
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
}

if($id=='saveOperationPopup')
{
 //$oprationId   = $_GET['oprationId'];
 $operatinoCode   = $_GET['operatinoCode'];
 $name      = $_GET['name'];
 $comCat       = $_GET['comCat'];
 $component    = $_GET['component'];
 $chkStatus    = $_GET['chkStatus'];

 if($oprationId == ''){
		
	 $sql2 = "insert into ws_operations (intCompCatId,intCompId,strOperationCode,strOperationName,intStatus)values('$comCat','$component','$operatinoCode','$name','$chkStatus')";
	 $result2 = $db->RunQuery($sql2);
	if($result2){
	echo "Saved Successfully";
	}
	else{
		echo "Saving Error...";
		}
}
				
 else{
    $sql2 = "update ws_operations set 
           strOperationCode='$txtOptCode',
		   strOperationName='$txtName',
		   intStatus='$chkStatus'
		   where intCompCatId = '$comCat' and intCompId = '$component' and intId = '$oprationId'";
		   $result2 = $db->RunQuery($sql2);
		   	 if($result2 == '1'){
			  echo "Updated successfully";
			 }else{
			  echo "Updating Error...";
			 }
 }
}


else if($id=='deleteOperationPopup')
{
 $oprationId   = $_GET['oprationId'];
 $comCat       = $_GET['comCat'];
 $component    = $_GET['component'];
 $txtName    = $_GET['txtName'];
 
 
$sql1 = "delete from ws_operations where  intCompCatId = '$comCat' and intCompId = '$component' and intId = '$oprationId' and strOperationName = '$txtName' ";
 $result2 = $db->RunQuery($sql1);
 if($result2)
 echo "1";
}

//-----------------------------------------------Machine popup-----------------------------------------------

else if($id=='saveMachinePopup')
{
 $machCode   = $_GET['machCode'];
 $machName   = $_GET['machName'];
 $chkStatusMach= $_GET['chkStatusMach'];
 
 if($oprationId == ''){
		
	 $sql2 = "insert into ws_machinetypes (strMachineCode,strMachineName,intStatus)values('$machCode','$machName','$chkStatusMach')";
	 $result2 = $db->RunQuery($sql2);
	 
	 if($result2)
	  echo "1";
}
				
 else{
    $sql2 = "update ws_machinetypes set 
           strMachineCode='$txtOptCode',
		   strMachineName='$txtName',
		   intStatus='$chkStatus'
		   where intMachineTypeId = '$oprationId'";
		   $result2 = $db->RunQuery($sql2);
		   	 if($result2){
			  echo "Updated successfully";
			 }else{
			  echo "Updating Error...";
			 }
 }
}


else if($id=='deleteMachinePopup')
{
 $machId   = $_GET['machId'];
 
  $sql1 = "delete from ws_machinetypes where  intMachineTypeId = '$machId' ";
 $result2 = $db->RunQuery($sql1);
 if($result2)
 echo "1";
}
//-------------------------Edit By Badra 01/07/2012-------------------------------------------------
if($id=='checkDuplicate')
{
	$component = $_GET["component"];
	$compCatgry = $_GET["compCatgry"];
	
	$str="SELECT components.strComponent FROM components where strComponent='$component' and intStatus!=0 and intCategory = '$compCatgry' ";
    $result=$db->RunQuery($str);
	$row=mysql_fetch_array($result);
	$category=$row["strComponent"];
	if($category!='')
	{
		 $category=1;
	}
	else
	{
	 	$category=0;
	}
	echo $category;
	


} 
if($id=='saveComponent')
{
	$process = $_GET["process"];
	$compCatgry = $_GET["compCatgry"];
	$component = $_GET["component"];
	$description = $_GET["description"];
	$componentid = $_GET["componentid"];
	
	
	if($componentid=="")
	{
			 $str="insert into components 
					( 
					intCategory, 
					strComponent, 
					strDescription,
					intStatus
					)
					values
					( 
					'$compCatgry', 
					'$component', 
					'$description',
					'$process'
					)";
					//echo $str;
	}
	else 
	{
		$str="update components
					set
					
					strComponent = '$component' , 
					strDescription = '$description' ,
					intStatus = 	'$processId'
					
					where
					intComponentId = '$componentid' and intCategory = '$compCatgry'  ;";
	
	}
	
	$result = $db->RunQuery($str); 
	if($result)
		echo "1";
} 
if ($id=='delete_component')
{	
	$category=$_GET['category'];
	$componentid=$_GET['componentid'];
	
	$str="delete from components where intComponentId = '$componentid' and intCategory='$category';";
	$result = $db->RunQuery($str); 
	if($result)
	echo "1";

}
if ($id=='delete_category')
{	
	$catid=$_GET['catid'];
	$str="delete from componentcategory where intCategoryNo='$catid'";
	$result = $db->RunQuery($str); 
	if($result)
	{
		$str="delete from components where  intCategory='$catid';";
		$result = $db->RunQuery($str); 
		if($result)
			echo $result[1];
	}
	
}
//-------------------------- Edit By Badra 03/07/2012-------------------------------------------------
if ($id=='saveProcess')
{
	$processid=$_GET['processid'];
	$pro_description=$_GET['pro_description'];
	$process=$_GET['process'];
	if($processid=="")
		{
		$str="insert into ws_processes 
		(strProcess,strDescription)
		values
		('$process','$pro_description')";
		}
	else
		{
		$str="update ws_processes set strProcess = '$process' ,
		 strDescription = '$pro_description' 
		 where	intProcessId = '$processid'";
		}
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}
if ($id=='delete_process')
{	
	$processId=$_GET['processId'];
	$str="delete from ws_processes where intProcessId='$processId'";
	$result = $db->RunQuery($str); 
	if($result)
	{
			echo $result[1];
	}
	
}

if ($id=='saveCat')
{
	$catid=$_GET['catid'];
	$cat_description=$_GET['cat_description'];
	$category=$_GET['category'];
	if($catid=="")
		{
		$str="insert into componentcategory 
		(strCategory,strDescription)
		values
		('$category','$cat_description');";
		}
	else
		{
		$str="update componentcategory set strCategory = '$category' ,
		 strDescription = '$cat_description' 
		 where	intCategoryNo = '$catid' ;";
		}
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}
if ($id=='deleteCategory')
{	
	$categoryId=$_GET['categoryId'];
	$str="delete from componentcategory where intCategoryNo='$categoryId'";
	$result = $db->RunQuery($str); 
	if($result)
	{
			echo $result[1];
	}
	
}

if($id=='loadComponentsProcessCatWise')
{
	$intCatId = $_GET["intCatId"];
	$intProcessId = $_GET["intProcessId"];
	
	$str = "select 	intComponentId, 
					intCategory, 
					strComponent, 
					components.strDescription,
					ws_processes.strProcess,
					ws_processes.intProcessId	 
					from 
					components left join ws_processes on components.intStatus=ws_processes.intProcessId";
					
				if($intCatId != '' and $intProcessId != ''){
				$str.= "  where intCategory='$intCatId' and ws_processes.intProcessId='$intProcessId' and intStatus!=0";
				}	
				else if($intCatId != ''){
				$str.= "  where intCategory='$intCatId' and intStatus!=0";
				}
				else if($intProcessId != ''){
				$str.= "  where ws_processes.intProcessId='$intProcessId' and intStatus!=0";
				}
				//echo $str; 
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		echo "<option value=\"". $row["intComponentId"] ."\">" . $row["strComponent"] ."</option>" ;	
	}
} 
 
?>