<?php


	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	
	
if($strButton=="add")  
{ 	
		$Colorname = $_GET["Colorname"];
		$Description = $_GET["Description"];
		//$assign = $_GET["assign"];
		$BuyerID = $_GET["BuyerID"];
		$DivisionID = $_GET["DivisionID"];
		 
		$SQL_CheckColor="select sizes.strSize from sizes where intCustomerId = ".$BuyerID." AND intDivisionID = ".$DivisionID." AND strSize = '".$Colorname."';";  
	
		$result_CheckColor = $db->RunQuery($SQL_CheckColor);	
	
		if($row = mysql_fetch_array($result_CheckColor))
		{
		     echo"-1";
		}
		else
		{
			
		 	$SQL_SaveColor="insert into sizes(strSize,intCustomerID,intDivisionID,strDescription,intStatus)values('".$Colorname."',".$BuyerID.",".$DivisionID.",'".$Description."',1);";

		//echo $SQL_SaveColor;
			$db->ExecuteQuery($SQL_SaveColor);		   
		}

}

else if($strButton=="save")
{
	$BuyerID = $_GET["BuyerID"];
	$DivisionID = $_GET["DivisionID"];
	$NewColor=$_GET["NewColor"];
	$ExplodeColor= explode(',', $NewColor);
	
	$sql_del="UPDATE sizes SET intStatus=10 WHERE intCustomerID=$BuyerID AND intDivisionID=$DivisionID;";
			$db->RunQuery($sql_del); 
			//echo  $sql_del; 
	
	for ($i = 0;$i < count($ExplodeColor)-1;$i++)
	   {
		  SaveNewColor($ExplodeColor[$i],$BuyerID,$DivisionID,'1');
	   }
}

function SaveNewColor($Color,$Buyer,$Division,$Status)
{
	global $db;
	$sql_del="UPDATE sizes SET intStatus=1 WHERE intCustomerID=$Buyer AND intDivisionID=$Division AND strSize = '$Color';";
			$db->RunQuery($sql_del); 
   $sql= "insert into sizes(strSize,intCustomerID,intDivisionID,strDescription,intStatus)values('".$Color."',".$Buyer.",".$Division.",'',".$Status.");";

   $db->executeQuery($sql); 
   


}

?>