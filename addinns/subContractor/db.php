<?php
include "../../Connector.php";

	$strButton=$_GET["q"];
	
	//New
	if($strButton=="New")
	{
		$intID=$_GET["intID"];
		$strName=trim($_GET["strName"],' ');
		$strAddress1=trim($_GET["strAddress1"],' ');
		//$strAddress2=trim($_GET["strAddress2"],' ');
		$strStreet=trim($_GET["strStreet"],' ');
		$strCity=trim($_GET["strCity"],' ');
		$strCountry=$_GET["strCountry"];
		$strPhone=trim($_GET["strPhone"],' ');
		$strEmail=trim($_GET["strEmail"],' ');
		$strWeb=trim($_GET["strWeb"],' ');
		$strRemarks=trim($_GET["strRemarks"],' ');
		$strState=trim($_GET["strState"],' ');
		$strZipCode=trim($_GET["strZipCode"],' ');
		$strFax=trim($_GET["strFax"],' ');
		$intStatus=trim($_GET["intStatus"],' ');
		$strContPerson = trim($_GET["strContPerson"],' ');
		$strContPhone = trim($_GET["strContPhone"],' ');
		$strVatNo = trim($_GET["strVatNo"],' ');
		
		$SQL_Check="SELECT subcontractors.strSubContractorID, subcontractors.strName, subcontractors.intStatus FROM subcontractors WHERE (((subcontractors.strName)='".$strName."'))";
		
		$result_Check = $db->RunQuery($SQL_Check);
		if($row_Check = mysql_fetch_array($result_Check))
		{
			$intID=$row_Check["strSubContractorID"];
			
			if($row_Check["intStatus"]==0||$row_Check["intStatus"]==10)
			{
				$SQL = "UPDATE subcontractors SET 	strName='".$strName."',strAddress1='".$strAddress1."',strStreet='".$strStreet."',strCity='".$strCity."',strCountry='".$strCountry."',strPhone='".$strPhone."',strEMail='".$strEmail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strState='".$strState."',strZipCode='".$strZipCode."',strFax='".$strFax."',strContPerson = '" .$strContPerson . "' , strContPersonPhone='" . $strContPhone. "', strVatNo = '$strVatNo' ,intStatus='".$intStatus."' WHERE strName='".$strName."'";
						
				$db->ExecuteQuery($SQL);
				echo "Updated successfully ";
			}
			else
			{
				echo "Record is all ready existes.";
			}
		}
		else
		{
			$SQL_MaxID="SELECT CASE WHEN ( MAX(strSubContractorID) IS NULL ) THEN 1 ELSE MAX(strSubContractorID)+1 END as strSubContractorID FROM subcontractors;";
			
			$result_MaxID = $db->RunQuery($SQL_MaxID);
			if($row_MaxID = mysql_fetch_array($result_MaxID))
			{
				$intID=$row_MaxID["strSubContractorID"];
			}
			
			$SQL = "insert into subcontractors   		(strSubContractorID,strName,strAddress1,strStreet,strCity,strCountry,strPhone,strEMail,strWeb,strRemarks,strState,strZipCode,strFax,strContPerson,strContPersonPhone, strVatNo, intStatus) values ('".$intID."','".$strName."','".$strAddress1."','".$strStreet."','".$strCity."','".$strCountry."','".$strPhone."','".$strEmail."','".$strWeb."','".$strRemarks."','".$strState."','".$strZipCode."','".$strFax."','$strContPerson','$strContPhone','$strVatNo','".$intStatus."');";
				
			$db->ExecuteQuery($SQL);
			//echo $SQL;
			echo "Saved successfully ";
		}
		
	}
	
	//Update
	if($strButton=="Save")
	{
		$intID=$_GET["intID"];
		$strName=trim($_GET["strName"],' ');
		$strAddress1=trim($_GET["strAddress1"],' ');
		//$strAddress2=trim($_GET["strAddress2"],' ');
		$strStreet=trim($_GET["strStreet"],' ');
		$strCity=trim($_GET["strCity"],' ');
		$strCountry=$_GET["strCountry"];
		$strPhone=trim($_GET["strPhone"],' ');
		$strEmail=trim($_GET["strEmail"],' ');
		$strWeb=trim($_GET["strWeb"],' ');
		$strRemarks=trim($_GET["strRemarks"],' ');
		$strState=trim($_GET["strState"],' ');
		$strZipCode=trim($_GET["strZipCode"],' ');
		$strFax=trim($_GET["strFax"],' ');
		$intStatus=trim($_GET["intStatus"],' ');
		$strContPerson = trim($_GET["strContPerson"],' ');
		$strContPhone = trim($_GET["strContPhone"],' ');
		$strVatNo = trim($_GET["strVatNo"],' ');
		
		
    // $SQL_Check1="SELECT * FROM subcontractors where strName='$strName' AND intStatus != '10'";
	 //$result_check1 = $db->RunQuery($SQL_Check1);	
	
	//	$SQL="SELECT * FROM subcontractors WHERE (((subcontractors.strSubContractorID)='".$intID."'))";
	//$result = $db->RunQuery($SQL);
	//$row = mysql_fetch_array($result);
	
	// if((mysql_num_rows($result_check1)>0) AND ($strName!=$row['strName'])){
	//	echo "Subcontractor already exists";	
	// }
	// else{
				$SQL = "UPDATE subcontractors SET 	strName='".$strName."',strAddress1='".$strAddress1."',strStreet='".$strStreet."',strCity='".$strCity."',strCountry='".$strCountry."',strPhone='".$strPhone."',strEMail='".$strEmail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strState='".$strState."',strZipCode='".$strZipCode."',strFax='".$strFax."',strContPerson = '" .$strContPerson . "' , strContPersonPhone='" . $strContPhone. "', strVatNo = '$strVatNo' ,intStatus='".$intStatus."' WHERE strSubContractorID='".$intID."'";
						
			$db->ExecuteQuery($SQL);
			echo "Updated successfully ";
		//}
		
	}
	
	
	
	//Delete
	if($strButton=="Delete")
	{
		$intID=$_GET["intID"];
		
		$SQL = "DELETE from subcontractors  WHERE strSubContractorID='".$intID."'";
						
		$db->ExecuteQuery($SQL);
		echo "Deleted successfully ";
	}

if($strButton=="clearReq")
{
	$sql="SELECT strSubContractorID, strName FROM subcontractors where intStatus<>10 order by strName ASC";
	$res=$db->ExecuteQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($res))
	{
		echo "<option value='".$row['strSubContractorID']."'>".$row['strName']."</option>";
	}
}

if($strButton=="LoadCountryMode")
{
	$SQL="SELECT country.strCountry,country.strCountryCode FROM country WHERE (((country.intStatus)=1)) order by strCountry ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountry"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}
else if($strButton=="GetCountryZipCode")
{
$countryId = $_GET["countryId"];
	$sql ="select strZipCode from country where strCountry='$countryId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo $row["strZipCode"];
	}
}
?>

