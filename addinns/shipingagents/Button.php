
<?php
	include "../../Connector.php";
	
	

	$strButton=$_GET["q"];
	

	if($strButton=="New")
	{
		$intAgentId=$_GET["intAgentId"];
		$strName=trim($_GET["strName"],' ');
		$strAddress1=trim($_GET["strAddress1"],' ');
		$strAddress2=trim($_GET["strAddress2"],' ');
		$strStreet=trim($_GET["strStreet"],' ');
		$strCity=trim($_GET["strCity"],' ');
		$strState=trim($_GET["strState"],' ');
		$strCountry=$_GET["strCountry"];
		$strZipCode=trim($_GET["strZipCode"],' ');
		$strPhone=trim($_GET["strPhone"],' ');
		$strEMail=trim($_GET["strEMail"],' ');
		$strFax=trim($_GET["strFax"],' ');
		$strWeb=trim($_GET["strWeb"],' ');
		$strContactPerson=trim($_GET["strContactPerson"],' ');
		$strRemarks=trim($_GET["strRemarks"],' ');
		$intStatus=$_GET["intStatus"];
		
		$SQL_Check="SELECT shipping_agents.intAgentId, shipping_agents.strName, shipping_agents.intStatus FROM shipping_agents WHERE (((shipping_agents.strName)='".$strName."'));";
		
		$result_Check = $db->RunQuery($SQL_Check);
		if($row_Check = mysql_fetch_array($result_Check))
		{
			$intAgentId=$row_Check["intAgentId"];
			
			if($row_Check["intStatus"]==0)
			{
				$SQL_Update="UPDATE shipping_agents SET strName='".$strName."',strAddress1='".$strAddress1."',strAddress2='".$strAddress2."',strStreet='".$strStreet."',strCity='".$strCity."',strState='".$strState."',strCountry='".$strCountry."',strZipCode='".$strZipCode."',strPhone='".$strPhone."',strEMail='".$strEMail."',strFax='".$strFax."',strWeb='".$strWeb."',strContactPerson='".$strContactPerson."',strRemarks='".$strRemarks."',intStatus='".$intStatus."' where intAgentId=".$intAgentId.";";
		
				$db->ExecuteQuery($SQL_Update);
				echo "Saved successfully";
			}
			else
			{
				echo "Record is all ready exists.";
			}
		}
		else
		{
				$SQL ="insert into shipping_agents(strName,strAddress1,strAddress2,strStreet,strCity,strState,strCountry,strZipCode,strPhone,strEMail,strFax,strWeb,strContactPerson,strRemarks,intStatus) values ('".$strName."','".$strAddress1."','".$strAddress2."','".$strStreet."','".$strCity."','".$strState."','".$strCountry."','".$strZipCode."','".$strPhone."','".$strEMail."','".$strFax."','".$strWeb."','".$strContactPerson."','".$strRemarks."','".$intStatus."');";

			$db->ExecuteQuery($SQL);
			echo "Saved successfully";
		}
		
	}
	
	
	//Update
		if($strButton=="Save")
	{
	
	$intAgentId=$_GET["intAgentId"];
	$strName=trim($_GET["strName"],' ');
	$strAddress1=trim($_GET["strAddress1"],' ');
	$strAddress2=trim($_GET["strAddress2"],' ');
	$strStreet=trim($_GET["strStreet"],' ');
	$strCity=trim($_GET["strCity"],' ');
	$strState=trim($_GET["strState"],' ');
	$strCountry=$_GET["strCountry"];
	$strZipCode=trim($_GET["strZipCode"],' ');
	$strPhone=trim($_GET["strPhone"],' ');
	$strEMail=trim($_GET["strEMail"],' ');
	$strFax=trim($_GET["strFax"],' ');
	$strWeb=trim($_GET["strWeb"],' ');
	$strContactPerson=trim($_GET["strContactPerson"],' ');
	$strRemarks=trim($_GET["strRemarks"],' ');
	$intStatus=$_GET["intStatus"];
 

	 
     $SQL_Check1="SELECT * FROM shipping_agents where strName='$strName' AND intStatus != '10'";
	 $result_check1 = $db->RunQuery($SQL_Check1);	
	
	$SQL = "SELECT * FROM shipping_agents where intAgentId=".$intAgentId.";";	
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	 if((mysql_num_rows($result_check1)>0) AND ($strName!=$row['strName'])){
		echo "Agent Already Exists";	
	 }
	 else{


$SQL_Update="UPDATE shipping_agents SET strName='".$strName."',strAddress1='".$strAddress1."',strAddress2='".$strAddress2."',strStreet='".$strStreet."',strCity='".$strCity."',strState='".$strState."',strCountry='".$strCountry."',strZipCode='".$strZipCode."',strPhone='".$strPhone."',strEMail='".$strEMail."',strFax='".$strFax."',strWeb='".$strWeb."',strContactPerson='".$strContactPerson."',strRemarks='".$strRemarks."',intStatus='".$intStatus."' where intAgentId=".$intAgentId.";";
		
		$db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";	
		}
 
			  	
	

		}


		//Delete
			 
		if($strButton=="Delete")
		{		
		$intAgentId=$_GET["intAgentId"];
		 $SQL="update shipping_agents set intStatus=10  where intAgentId=".$intAgentId.";";
		 
		 $db->ExecuteQuery($SQL);		
		 echo "Deleted successfully";
		 }

if($strButton=="clearReq")
{
	$sql="SELECT intAgentId,strName FROM shipping_agents where intStatus<>10 order by strName ASC";
	$res=$db->ExecuteQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($res))
	{
		echo "<option value='".$row['intAgentId']."'>".$row['strName']."</option>";
	}
}

else if($strButton=="LoadCountryMode")
{
	$SQL="SELECT country.strCountry,country.strCountryCode FROM country WHERE (((country.intStatus)=1)) order by strCountry ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountry"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}
?>
