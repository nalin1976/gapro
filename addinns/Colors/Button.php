<?php
include "../../Connector.php";	
$strButton=$_GET["q"];	
	
if($strButton=="add")
{ 	
$Colorname 		= $_GET["Colorname"];
$Description 	= $_GET["Description"];
$BuyerID 		= $_GET["BuyerID"];
$DivisionID 	= $_GET["DivisionID"];
	 
	$SQL_CheckColor="select strColor from colors where intCustomerId = ".$BuyerID." AND intDivisionID = ".$DivisionID." AND strColor = '".$Colorname."';";
	$result_CheckColor = $db->RunQuery($SQL_CheckColor);
	if($row = mysql_fetch_array($result_CheckColor))
	{
		 echo"-1";
	}
	else
	{
		$SQL_SaveColor="insert into colors(strColor,intCustomerId,intDivisionID,strDescription,intStatus)values('".$Colorname."',".$BuyerID.",".$DivisionID.",'".$Description."',1);";
		$db->ExecuteQuery($SQL_SaveColor);
	}
}
else if($strButton=="delete")
{
	$BuyerID    = $_GET["BuyerID"];
	$DivisionID = $_GET["DivisionID"];

	$sql = "DELETE FROM colors where intCustomerId='$BuyerID' AND intDivisionID='$DivisionID'";
	$db->executeQuery($sql);
}

else if($strButton=="save2")
{
	$BuyerID    = $_GET["BuyerID"];
	$DivisionID = $_GET["DivisionID"];
	$text1       = $_GET["text"];
	$text = str_replace(",", "#", $text1);
	$description1  = $_GET["description"];
	$description = str_replace(",", "#", $description1);
	$Status     = 1;
		$sql1 = "UPDATE colors SET intStatus='10' where intCustomerId='$BuyerID' AND intDivisionID='$DivisionID'";
		 $db->executeQuery($sql1);
		 
		 $sql2 = "SELECT * FROM colors where intCustomerId='$BuyerID' AND intDivisionID='$DivisionID' AND strColor='$text'";
		 $result =  $db->executeQuery($sql2);
	

	 if(mysql_num_rows($result)){
		 	$sql3 = "UPDATE colors SET intStatus='1' where intCustomerId='$BuyerID' AND intDivisionID='$DivisionID' AND strColor='$text'";
			 $db->executeQuery($sql3);
	 }else{
         $sql4 = "INSERT INTO colors (intCustomerId,intDivisionID,strColor,strDescription,intStatus)VALUE('$BuyerID','$DivisionID','$text','$description','1')";
		  $db->executeQuery($sql4);
	 }
}

else if($strButton=="delete2")
{
	$BuyerID    = $_GET["BuyerID"];
	$DivisionID = $_GET["DivisionID"];
	$strColor1   = $_GET["strcolor"];
	$strColor = str_replace(",", "#", $strColor1);

	/*
	$sql = "DELETE FROM colors where intCustomerId='$BuyerID' AND intDivisionID='$DivisionID' AND strColor='$strColor'";*/
	
	$sql = "UPDATE colors SET intStatus='10' where intCustomerId='$BuyerID' AND intDivisionID='$DivisionID' AND strColor='$strColor'";
	$db->executeQuery($sql);
	//echo $sql;

}
else if($strButton=="save")
{
	$BuyerID = $_GET["BuyerID"];
	$DivisionID = $_GET["DivisionID"];
	$NewColor=$_GET["NewColor"];
	$Description=$_GET["Description"];
	$text = str_replace("@@@***", "#", $NewColor);
	$Description = str_replace("@@@***", "#", $Description);
	$ExplodeColor= explode(',', $text);
	$ExplodeDescription= explode(',', $Description);
	
	$sql_del="UPDATE colors SET intStatus=10 WHERE intCustomerID=$BuyerID AND intDivisionID=$DivisionID;";
			$db->RunQuery($sql_del); 
			//echo  $sql_del; 
	//echo count($ExplodeColor)-1;
	for ($i = 0;$i < count($ExplodeColor)-1;$i++)
	   {
		  SaveNewColor($ExplodeColor[$i],$ExplodeDescription[$i],$BuyerID,$DivisionID,'1');
	   }
}

function SaveNewColor($Color,$Description,$Buyer,$Division,$Status)
{
	global $db;
	$sql_del="UPDATE colors SET intStatus=1 WHERE intCustomerID=$Buyer AND intDivisionID=$Division AND strColor = '$Color';";
			$db->RunQuery($sql_del);
			//echo $sql_del;
   $sql= "insert into colors(strColor,strDescription,intCustomerID,intDivisionID,intStatus)values('".$Color."','$Description',".$Buyer.",".$Division.",".$Status.");";
//echo $sql;
   $db->executeQuery($sql); 
}

	$sql = $_GET["sql"];
	$result = $db->RunQuery($sql);

	while($row = mysql_fetch_array($result))
	{
		$id = $row[0];
		$name= $row[1];
		$value.="<option value=\"$name\">$id</option>";
	}
	 
	 echo $value;

?>