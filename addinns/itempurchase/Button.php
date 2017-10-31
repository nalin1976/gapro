<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$intOriginNo=$_GET["intOriginNo"];
	$strOriginType=trim($_GET["strOriginType"], ' ');
    $intStatus=$_GET["intStatus"];
	$Type=$_GET["Type"];
	$OriginDescription = $_GET["OriginDescription"];
if($strButton=="New")
{
/* $SQL_Check="SELECT * FROM itempurchasetype where strOriginType='$strOriginType' ";
 $result_check = $db->RunQuery($SQL_Check);	
 
	if(mysql_num_rows($result_check))
	{
		echo "Origin  Already Exists";
	}else
	{*/
		$sql_insert  = "INSERT INTO itempurchasetype (strOriginType,intStatus,intType,strDescription) values
				  ('$strOriginType','$intStatus','$Type','$OriginDescription')";
		 $db->ExecuteQuery($sql_insert);		
		echo "Saved successfully";		  
	//}
}
elseif($strButton=="Save")
{  
/*	$SQL_Check1="SELECT * FROM itempurchasetype where strOriginType='$strOriginType' ";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	
	$SQL = "SELECT intOriginNo,strOriginType,intType,intStatus FROM itempurchasetype where  intOriginNo='$intOriginNo' ";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	if((mysql_num_rows($result_check1)>0) AND ($strOriginType!=$row['strOriginType']))
	{
		echo "Orgin Already Exists.";
	}
	else
	{	*/
		$SQL_Update="UPDATE itempurchasetype SET  strOriginType='$strOriginType',
		intType='$Type',
		intStatus='$intStatus',
		strDescription = '$OriginDescription'
		WHERE intOriginNo='$intOriginNo'"; 
		$db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";
	//}
}
elseif($strButton=="Delete")
{	
	$intOriginNo=$_GET["intOriginNo"];
	$SQL="delete from itempurchasetype where intOriginNo='$intOriginNo'";
	//$db->ExecuteQuery($SQL);
	$result = $db->RunQuery2($SQL);
	if(gettype($result)=='string')
	{
		echo $result;
		return;
	}
	echo "Deleted successfully.";
}
else if($strButton =="origins")
{
	$SQL = "SELECT itempurchasetype.intOriginNo, itempurchasetype.strOriginType FROM itempurchasetype where intStatus<>10;";
	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intOriginNo"] ."\">" . $row["strOriginType"] ."</option>" ;
	}
}
	
?>