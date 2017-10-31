<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$intNo=$_GET["intNo"];
	
	 
	  //Save & New
	
	 if($strButton=="New")
	 {   
	     $intFrom=$_GET["intFrom"];
	     $strTo =$_GET["strTo"];
		 $dblPercentage=$_GET["dblPercentage"];
		 $intStatus=$_GET["intStatus"];
		 //if($dblPercentage=="")
		//$dblPercentage=0;
		
		 	$SQL_CheckData="SELECT intNo,intStatus FROM grnexcessqty where intFrom=".$intFrom." AND intStatus != '10'";
		$result = $db->RunQuery($SQL_CheckData);	
	
		if($row = mysql_fetch_array($result))
		{ $intNo=$row["intNo"];
		
		if($row["intStatus"]==0)
		{
				$SQL_Update="UPDATE grnexcessqty SET intFrom=".$intFrom.",strTo='".$strTo."',dblPercentage='".$dblPercentage."',intStatus='".$intStatus."' where intNo=".$intNo.";"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved successfully";
		}
		else
		{
		echo "Record all ready Exsist";
		}
		
		}
	else
	{
	$SQL = "insert into grnexcessqty (intFrom,strTo,dblPercentage,intStatus) values (".$intFrom.",'".$strTo."','".$dblPercentage."','".$intStatus."');";

			$db->ExecuteQuery($SQL);
		    echo "Saved successfully";
	}
	
	} 
	 	 	
	//Update
	if($strButton=="Save")
	{  
	     $intFrom=$_GET["intFrom"];
	     $strTo =$_GET["strTo"];
		 $dblPercentage=$_GET["dblPercentage"];
		 $intStatus=$_GET["intStatus"];
		//if($dblPercentage=="")
		//$dblPercentage=0;
	
       $SQL_Check1="SELECT * FROM grnexcessqty where intFrom='$intFrom' AND intStatus != '10'";
	 $result_check1 = $db->RunQuery($SQL_Check1);	
	
	 $SQL = "SELECT * FROM grnexcessqty where intNo=".$intNo." AND intStatus != '10'";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	 if((mysql_num_rows($result_check1)>0) AND ($intFrom!=$row['intFrom'])){
		echo "Record all ready Exsist";
	 }
	 else{
		$SQL_Update="UPDATE grnexcessqty SET intFrom=".$intFrom.",strTo='".$strTo."',dblPercentage=".$dblPercentage.",intStatus='".$intStatus."' where intNo=".$intNo.";"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved successfully";			
		//echo $SQL_Update;
	}

			
		}
	
	
		
		//Delete
			 
		if($strButton=="Delete")
		{		
		 $SQL="update grnexcessqty set intStatus=10  where intNo=".$intNo.";";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted successfully.";
		 }
	
//---------------------------- combo box values--------------------------------------------------------		
if($strButton =="GrnExcess"){
	
		$SQL = "SELECT * FROM grnexcessqty WHERE intStatus <> 10 order by  intFrom ASC";
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intNo"] ."\">" . $row["intFrom"] ."</option>" ;
		}
	}
?>


