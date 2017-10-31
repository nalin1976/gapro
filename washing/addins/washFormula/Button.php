
<?php
	include "../../../Connector.php";
	
	    $strButton=trim($_GET["q"],' ');
	
	//--------------------------------------------------------------------------------------------
	
	if($strButton=="New")
	{	
	    $strDes=trim($_GET["strDes"],' ');
		$Liqour= $_GET["Liqour"];
		$runTime= $_GET["runTime"];
		$temperature= $_GET["temperature"];
		$intStatus=$_GET["intStatus"];
		$pType=$_GET['pType'];
		
		$sql_insert  = "INSERT INTO was_washformula (strProcessName,dblTemp,dblLiqour,dblTime,intStatus,intProcType) values
						 ('$strDes','$temperature','$Liqour','$runTime','$intStatus','$pType')";
		$db->ExecuteQuery($sql_insert);		
		  echo "Saved successfully";	
	
		
	}

//---------------------------------------------------------------------------------------------------
	// Update
	else if($strButton=="Save")
	{  
		$strFormulaID= $_GET["strFormulaID"];
	    $strDes=trim($_GET["strDes"],' ');
		$Liqour= $_GET["Liqour"];
		$runTime= $_GET["runTime"];
		$temperature= $_GET["temperature"];
		$intStatus=$_GET["intStatus"];
		$pType=$_GET['pType'];
		
		/*$SQL = "delete from  was_washformula  where intSerialNo='$strFormulaID';";
		$db->ExecuteQuery($SQL);*/	
		 
		$sql_insert  = "update was_washformula set strProcessName='$strDes',dblTemp='$temperature',dblLiqour='$Liqour',dblTime='$runTime',intStatus='$intStatus',intProcType='$pType' where intSerialNo='$strFormulaID';";
						//echo $sql_insert;
		$db->ExecuteQuery($sql_insert);	
		echo "Updated successfully";			

		
  }
	
//--------------------------------------------------------------------------------------------------------	
		//Delete
			 
		else if($strButton=="Delete")
		{		
		
		$strFormulaID= $_GET["strFormulaID"];
		// $SQL="update seasons set intStatus='10' where intSeasonId='$strSeasonId';";
		$SQL = "delete from  was_washformula  where intSerialNo='$strFormulaID';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted successfully.";
		 }
		 
 else if($strButton=="checkProcess"){
 $process= $_GET["process"];
 $temp= $_GET["temp"];
 
 $SQL_Check="SELECT * FROM was_washformula where strProcessName='$process' AND dblTemp = '$temp'";
 //echo $SQL_Check;
 $result_check = $db->RunQuery($SQL_Check);	
 if(mysql_num_rows($result_check)){
 echo "1";
 } 
 } 

?>