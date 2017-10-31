<?php
	include "../../Connector.php";
	
         $strButton=trim($_GET["q"],' ');
	     $strDepartment=trim($_GET["strDepartment"],' ');
		 $strDepartmentCode = trim($_GET["strDepartmentCode"],' ');
	     $strRemarks=trim($_GET["strRemarks"],' ');
		 $intStatus=trim($_GET["intStatus"],' ');
		 $intCompany = $_GET["intCompany"];

//--------------------------------------------------------------------------------------------------------------
	if($strButton=="New")
	{
		 $sql_insert  = "INSERT INTO department (strDepartmentCode,strDepartment,strRemarks,intCompayID,intStatus) values	                  ('$strDepartmentCode','$strDepartment','$strRemarks','$intCompany','$intStatus')";
	  $db->ExecuteQuery($sql_insert);		
	  echo "Saved successfully.";	
	 /*$SQL_Check="SELECT * FROM department where strDepartmentCode='$strDepartmentCode' AND intStatus != '10'";
	 $result_check = $db->RunQuery($SQL_Check);	
	 
	 $SQL_Check1="SELECT * FROM department where strDepartment='$strDepartment' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	 
	 
	 if(mysql_num_rows($result_check)){
		echo "Department Code Already Exists.";
		}
      else if(mysql_num_rows($result_check1)){
		echo "Department Name Already Exists.";			
	 }else{
	  $sql_insert  = "INSERT INTO department (strDepartmentCode,strDepartment,strRemarks,intCompayID,intStatus) values	                  ('$strDepartmentCode','$strDepartment','$strRemarks','$intCompany','$intStatus')";
	  $db->ExecuteQuery($sql_insert);		
	  echo "Saved successfully";		  
	 }*/
	
  }
//-------------------------------------------------------------------------------------------------------------
	// Update
	else if($strButton=="Save")
	{  
         $cbodepartment=$_GET["cbodepartment"]; 
	     $strDepartment=trim($_GET["strDepartment"],' ');
	     $strRemarks=trim($_GET["strRemarks"],' ');
		 $intStatus=trim($_GET["intStatus"],' ');
		 $intCompany = trim($_GET["intCompany"],' ');
		 $strDepartmentCode = $_GET["strDepartmentCode"];
		 
		  $SQL_Update="UPDATE department SET  strDepartmentCode='$strDepartmentCode',
		                             strDepartment='$strDepartment',
									 strRemarks='$strRemarks',
									 intCompayID='$intCompany',
		                             intStatus='$intStatus' 
                 WHERE intDepID='$cbodepartment'"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully.";	
	 /*$SQL_Check="SELECT * FROM department where strDepartmentCode='$strDepartmentCode' AND intStatus != '10'";
	 $result_check = $db->RunQuery($SQL_Check);	
	 
	 $SQL_Check1="SELECT * FROM department where strDepartment='$strDepartment' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	
	 $SQL = "SELECT * FROM department where intDepID='$cbodepartment' AND intStatus != '10'";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	 if((mysql_num_rows($result_check)>0) AND ($strDepartmentCode!=$row['strDepartmentCode'])){
		echo "Department Code Already Exists.";
		}
      else if((mysql_num_rows($result_check1)>0) AND ($strDepartment!=$row['strDepartment'])){
		echo "Department Name Already Exists.";
	  }else{
	 $SQL_Update="UPDATE department SET  strDepartmentCode='$strDepartmentCode',
		                             strDepartment='$strDepartment',
									 strRemarks='$strRemarks',
									 intCompayID='$intCompany',
		                             intStatus='$intStatus' 
                 WHERE intDepID='$cbodepartment'"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";			
	 }*/
  }	
  //-------------------------------------------------------------------------------------------------------------
		//Delete
			 
		else if($strButton=="Delete")
		{	
		$cbodepartment = $_GET["cbodepartment"]; 	
		 //$SQL="update department set intStatus='10'  where intDepID='$cbodepartment'";
			$SQL="delete from department where intDepID='$cbodepartment'";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted successfully.";
		 }
		 
		 else if($strButton =="loadDeps"){
	
	$SQL="SELECT * FROM department WHERE intStatus <> 10 order by strDepartment ASC";
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intDepID"] ."\">" . $row["strDepartment"] ."</option>" ;
		}
	}

?>