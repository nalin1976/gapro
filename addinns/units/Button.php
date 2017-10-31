<?php
	include "../../Connector.php";
	
	//echo '----- '.$db->getFormName();
	
	$strButton=$_GET["q"];
	$strUnit=$_GET["strUnit"];
	$cboUnit=$_GET["cboUnit"];
	 //New
	 if($strButton=="New")
	 {
	     $strTitle=$_GET["strTitle"];
	     $intPcsForUnit=$_GET["intPcsForUnit"];
		 $intStatus=$_GET["intStatus"];
		 if($intPcsForUnit=="")
		 $intPcsForUnit=0;
		 $SQL = "insert into units ( strUnit,strTitle,intPcsForUnit,intStatus) values ('".$strUnit."','".$strTitle."','".$intPcsForUnit."','".$intStatus."');";

			$db->ExecuteQuery($SQL);
		    echo "Saved successfully.";
		 /*$SQL_CheckData="SELECT strUnit,intStatus FROM units where strUnit='".$strUnit."' ";
	$result = $db->RunQuery($SQL_CheckData);	

	if($row = mysql_fetch_array($result))
	{
	$strUnit=$row["strUnit"];
	
	if($row["intStatus"]==0)
	{
			$SQL_Update="UPDATE units SET strTitle='".$strTitle."',intPcsForUnit='". $intPcsForUnit."',intStatus='".$intStatus."' where strUnit='".$strUnit."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved successfully";
	}
	else
	{
	echo"Record All Ready Exsists";
	}
	
	}
	else
	{
	$SQL = "insert into units ( strUnit,strTitle,intPcsForUnit,intStatus) values ('".$strUnit."','".$strTitle."','".$intPcsForUnit."','".$intStatus."');";

			$db->ExecuteQuery($SQL);
		    echo "Saved successfully";
	}*/
	 
	 
	 
	 }
	 
	 	
	//Update
	if($strButton=="Save")
	{    
	     $strTitle=$_GET["strTitle"];
	     $intPcsForUnit=$_GET["intPcsForUnit"];
		 $intStatus=$_GET["intStatus"];
		 if($intPcsForUnit=="")
		 $intPcsForUnit=0;
		
		
    // $SQL_Check1="SELECT * FROM units where strUnit='".$strUnit."' AND intStatus != '10'";
	 $SQL_Check1="SELECT * FROM units where intUnitID='".$cboUnit."' ";
	 $result_check1 = $db->RunQuery($SQL_Check1);
	 $rowU = mysql_fetch_array($result_check1);	
	 $SQL_Update="UPDATE units SET strUnit='".$strUnit."',strTitle='".$strTitle."',intPcsForUnit='". $intPcsForUnit."',intStatus='".$intStatus."' where intUnitID='".$cboUnit."'"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully.";	
	 /*if((mysql_num_rows($result_check1)>0) AND ($strUnit!=$rowU["strUnit"])){
		echo "Units Already Exists";	
	 }
	 else{
		$SQL_Update="UPDATE units SET strUnit='".$strUnit."',strTitle='".$strTitle."',intPcsForUnit='". $intPcsForUnit."',intStatus='".$intStatus."' where intUnitID='".$cboUnit."'"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";			
		//echo $SQL_Update;
	}*/
			
		}
	
	
		
		//Delete
			 
if($strButton=="Delete")
{		
//$SQL="update units set intStatus=10  where strUnit='".$strUnit."';";
$SQL="delete from units   where intUnitID='".$strUnit."';";
//$db->ExecuteQuery($SQL);

 $result = $db->RunQuery2($SQL);
 if(gettype($result)=='string')
 {
	echo $result;
	return;
 }

 echo "Deleted successfully.";
}
if($strButton=="clearReq")
{
	$sql="SELECT units.strUnit,units.strTitle,units.intPcsForUnit FROM units ;";
	$res=$db->ExecuteQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($res))
	{
		echo "<option value='".$row['strUnit']."'>".$row['strUnit']."</option>";
	}
}
?>

