<?php
include("Connector.php");
$requestType=$_GET["requestType"];

if($requestType =="requestNo")
{	
	$FactoryID= $_SESSION["FactoryID"];
	
	 $SQL ="SELECT dblRequestNo FROM syscontrol WHERE intCompanyID='$FactoryID' ";
		$result = $db->executeQuery($SQL); 
		while($row = mysql_fetch_array($result))
			{
				$maxID=$row["dblRequestNo"];		
			}
		if($maxID == '' || is_null($maxID))
		{
			return -1000;
		}
		$intMax=0;
		$intMax=(int)$maxID;
		
		$request_No=$intMax+1;
		 
		$sql1="UPDATE syscontrol SET dblRequestNo='$request_No' WHERE intCompanyID='$FactoryID'";
	
		$db->executeQuery($sql1); 
		echo $intMax;
}
if($requestType=="saveIssueList")
{
	$requestNo       =$_GET["requestNo"];
	$projectName     =$_GET["projectName"];
	$attentTo        =$_GET["attentTo"];
	$user            =$_GET["user"];
	$description     =$_GET["description"];
	$reportBy        =$_GET["reportBy"];
	$status          =$_GET["status"];
	
	  $SQL = "insert into issueslog 
				(intRequestNo,strProjectName,intProgrammer,intUser, strDescription,
				 strReportedBy,intStatus)
			values
			    ('$requestNo','$projectName','$attentTo','$user','$description',
				'$reportBy','$status')";
	$result = $db->RunQuery($SQL);
	
	if($result){
		echo "1";
	}
	else{
		echo "0";
	}
}
?>