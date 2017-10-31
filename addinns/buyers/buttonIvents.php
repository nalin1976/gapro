
<?php
include "../../Connector.php";
$userId		= $_SESSION["UserID"];
$strButton=$_GET["q"];
	//New
if($strButton=="New")
{	
	    $intBuyerID=$_GET["intBuyerID"];	
		$buyerCode=$_GET["buyerCode"];
		$strName=$_GET["strName"];
		$strAddress1=$_GET["strAddress1"];
		$strStreet=$_GET["strStreet"];
		$strCity=$_GET["strCity"];
		$strCountry=$_GET["strCountry"];
		$strPhone=$_GET["strPhone"];
		$strEmail=$_GET["strEmail"];
		$strWeb=$_GET["strWeb"];
		$strRemarks=$_GET["strRemarks"];
		$strAgent=$_GET["strAgent"];
		$strState=$_GET["strState"];
		$strZipCode=$_GET["strZipCode"];
		$strFax=$_GET["strFax"];
		$intStatus=$_GET["intStatus"];
		//$bdName			= $_GET["bdName"];
		//$bdRemarks		= $_GET["bdRemarks"];
		$strDtFormat	= $_GET['strDtFormat'];
		$actualFOB		= $_GET['actualFOB'];
		$payterm = $_GET["payterm"];
		
		set_Used_tuple("country","intConID",$strCountry);
		
		$SQL_CheckCode="SELECT intBuyerID,strName,intStatus FROM buyers WHERE intBuyerID='$intBuyerID'";
		$result_CheckCode = $db->RunQuery($SQL_CheckCode);

		if($row_Bank = mysql_fetch_array($result_CheckCode))
		{
			if($row_Bank["intStatus"]==0)
			{	
				$SQL_Update="UPDATE buyers SET buyerCode= '$buyerCode' 	strName='".$strName."',strAddress1='".$strAddress1."',strStreet='".$strStreet."',strCity='".$strCity."',strCountry='".$strCountry."',strPhone='".$strPhone."',strEMail='".$strEmail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strAgentName='".$strAgent."',strState='".$strState."',strZipCode='".$strZipCode."',strFax='".$strFax."',intStatus='".$intStatus."',strDtFormat='".$strDtFormat."',intinvFOB='".$actualFOB."' ,intPayTermId=$payterm WHERE intBuyerID='".$intBuyerID."';"; 
		//echo $SQL_Update;
		$resId=$db->ExecuteQuery($SQL_Update);
		
		echo "Saved successfully";	
			}
			else
			{
				echo "Buyer is already exists.";
			}
		}
		else
		{
			$SQL = "insert into buyers   		(buyerCode,strName,strAddress1,strStreet,strCity,strCountry,strPhone,strEMail,strWeb,strRemarks,strAgentName,strState,strZipCode,strFax,intStatus,strDtFormat,intinvFOB,intPayTermId) values ('$buyerCode','".$strName."','".$strAddress1."','".$strStreet."','".$strCity."','".$strCountry."','".$strPhone."','".$strEmail."','".$strWeb."','".$strRemarks."','".$strAgent."','".$strState."','".$strZipCode."','".$strFax."','".$intStatus."','".$strDtFormat."','".$actualFOB."',$payterm);";

			$db->ExecuteQuery($SQL);
			$resId=$db->ExecuteQuery($SQL_Update);
			
			//Dinushi
			//get the Buyer ID to save data in buyer divisions
			$SQL_BID = "Select intBuyerID from buyers where buyerCode='$buyerCode' ";
			$resBID  = $db->RunQuery($SQL_BID);
			$BuyerID = '';
			while($rowB = mysql_fetch_array($resBID))
			{
				$BuyerID = $rowB["intBuyerID"];
			}
			
			//end
		
		echo $BuyerID;	
		}
}
//Save
if($strButton=="save")
{
	$intBuyerID=$_GET["intBuyerID"];
	$buyerCode = $_GET["buyerCode"];
	$strName=$_GET["strName"];
	$strAddress1=$_GET["strAddress1"];
	$strStreet=$_GET["strStreet"];
	$strCity=$_GET["strCity"];
	$strCountry=$_GET["strCountry"];
	$strPhone=$_GET["strPhone"];
	$strEmail=$_GET["strEmail"];
	$strWeb=$_GET["strWeb"];
	$strRemarks=$_GET["strRemarks"];
	$strAgent=$_GET["strAgent"];
	$strState=$_GET["strState"];
	$strZipCode=$_GET["strZipCode"];
	$strFax=$_GET["strFax"];
	$intStatus=$_GET["intStatus"];
	$bdName			= $_GET["bdName"];
	$bdRemarks		= $_GET["bdRemarks"];
	$strDtFormat	= $_GET['strDtFormat'];
	$actualFOB		= $_GET['actualFOB'];
	$payterm = $_GET["payterm"];
	
	set_Used_tuple("country","intConID",$strCountry);
	
	
		$SQL = "UPDATE buyers SET strName='".$strName."', buyerCode='".$buyerCode."',strAddress1='".$strAddress1."',strStreet='".$strStreet."',strCity='".$strCity."',strCountry='".$strCountry."',strPhone='".$strPhone."',strEMail='".$strEmail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strAgentName='".$strAgent."',strState='".$strState."',strZipCode='".$strZipCode."',strFax='".$strFax."',intStatus='".$intStatus."',strDtFormat='".$strDtFormat."',intinvFOB='".$actualFOB."' , intPayTermId=$payterm WHERE intBuyerID='".$intBuyerID."';";
				
		$db->ExecuteQuery($SQL);
		$resId=$db->ExecuteQuery($SQL_Update);
	
			echo "Updated successfully.";

}
if($strButton=="saveBuyerDevisions")
{	
	$buyerID = $_GET["buyerID"];
	$buyerDiv = $_GET["buyerDiv"];
	$buyerDivRemark = $_GET["buyerDivRemark"];
	
	insertBuyerDivisionDetails($buyerID,$buyerDiv,$buyerDivRemark,$userId);
}
if($strButton=="deleteDivision")
{
	$buyerDivId = $_GET["buyerDivId"];
	
	$sql = "delete from buyerdivisions 	where	intDivisionId = '$buyerDivId' ";
	$result = $db->RunQuery2($sql);
	 if(gettype($result)=='string')
	 {
		echo $result;
		return;
	 }
	 echo 1;
}	
if($strButton=="Delete")
{	
$intBuyerID=$_GET["intBuyerID"];	
$strName=$_GET["strName"];

	$SQL="delete from buyers where intBuyerID='$intBuyerID'";
	//$db->ExecuteQuery($SQL);		
	 $result = $db->RunQuery2($SQL);
 	if(gettype($result)=='string')
 	{
		echo $result;
		return;
 	}

	 echo "Deleted successfully.";
}

if($strButton=="butBoDelete")
{	
 $intBuyerOffID=$_GET["intBuyerOffID"];	
 
	$SQL="delete from buyerbuyingoffices where intBuyingOfficeId='$intBuyerOffID'";
	$db->ExecuteQuery($SQL);		
	echo "Deleted successfully.";
}
//Start 23-04-2010 Buying Office Details Save
	if($strButton=="SaveBuyingOfficeDetails")	
	{	
	    $intBuyerID		= $_GET["intBuyerID"];
		$boID			= $_GET["boID"];		
		$strName		= $_GET["boName"];
		$strAddress1	= $_GET["boAddress1"];
		$strStreet		= $_GET["boStreet"];
		$strCity		= $_GET["boCity"];
		$strCountry		= $_GET["boCountry"];
		$strPhone		= $_GET["boPhone"];
		$strEmail		= $_GET["boEmail"];
		$strWeb			= $_GET["boWeb"];
		$strRemarks		= $_GET["boRemarks"];		
		$strState		= $_GET["boState"];
		$strZipCode		= $_GET["boZipCode"];
		$strFax			= $_GET["boFax"];
		$intStatus 		= $_GET["intStatus"];
		$res_id		= $_GET["res_id"];
		if($intBuyerID=="")
			 $intBuyerID=$res_id;		
		 
		/*if($boID==""){
			$sqlcheck="select strName from buyerbuyingoffices where strName='$strName'";
			$result_check = $db->RunQuery($sqlcheck);
			$check = mysql_num_rows($result_check);
			$row_check	= mysql_fetch_array($result_check);
			if($check >0){
				echo "Sorry!\nBuying Office : ".$row_check["strName"]."\nalready exits in the system";
				return;
			}
		}*/
			
		$SQL_CheckCode="select intBuyingOfficeId,intStatus from buyerbuyingoffices where intBuyingOfficeId='$boID'";
		$result_CheckCode = $db->RunQuery($SQL_CheckCode);
		//$check  =mysql_num_rows($result_CheckCode);
		if($row_Bank = mysql_fetch_array($result_CheckCode))
		{
			
			if($row_Bank["intStatus"]!=100)
			{
				$SQL_Update="UPDATE buyerbuyingoffices SET strName='".$strName."',strAddress1='".$strAddress1."',strStreet='".$strStreet."',strCity='".$strCity."',strCountry='".$strCountry."',strPhone='".$strPhone."',strEMail='".$strEmail."',strWeb='".$strWeb."',strRemarks='".$strRemarks."',strState='".$strState."',strZipCode='".$strZipCode."',strFax='".$strFax."',intStatus='".$intStatus."' WHERE intBuyingOfficeId='".$boID."';"; 
		
		$db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";	
			}
			else
			{
				echo "Buyer is already Exists.";
			}
		}
		else
		{
			$SQL = "insert into buyerbuyingoffices   		(intBuyerID,strName,strAddress1,strStreet,strCity,strCountry,strPhone,strEMail,strWeb,strRemarks,strState,strZipCode,strFax,intStatus) values ('$intBuyerID','".$strName."','".$strAddress1."','".$strStreet."','".$strCity."','".$strCountry."','".$strPhone."','".$strEmail."','".$strWeb."','".$strRemarks."','".$strState."','".$strZipCode."','".$strFax."','".$intStatus."');";

			$db->ExecuteQuery($SQL);
			echo "Saved successfully";
		}
	}
//End 23-04-2010 Buying Office Details Save

//Start 23-04-2010 Buyer Division Details Save
	if($strButton=="SaveBuyerDivisionDetails")	
	{	
	    $intBuyerID		= $_GET["intBuyerID"];
		$bdID			= $_GET["bdID"];		
		$bdName			= $_GET["bdName"];
		$bdRemarks		= $_GET["bdRemarks"];
		$intStatus 		= $_GET["intStatus"];		
		
		if($bdID==""){
			$sqlcheck="select strDivision from buyerdivisions where strDivision='$bdName'";
			$result_check = $db->RunQuery($sqlcheck);
			$check = mysql_num_rows($result_check);
			$row_check	= mysql_fetch_array($result_check);
			if($check >0){
				echo "Sorry!\nBuyer Division : ".$row_check["strDivision"]."\nalready exits in the system";
				return;
			}
		}
		
		$SQL_CheckCode="select intDivisionId from buyerdivisions where intDivisionId='$bdID'";
		$result_CheckCode = $db->RunQuery($SQL_CheckCode);		
		
		if($row_Bank = mysql_fetch_array($result_CheckCode))
		{			
			$SQL_Update="UPDATE buyerdivisions SET strDivision='".$bdName."',strRemarks='".$bdRemarks."',intStatus='".$intStatus."',strUserId='$userId',dtmDate=now() WHERE intDivisionId='".$bdID."';"; 
		
			$db->ExecuteQuery($SQL_Update);
			echo "Updated successfully";
		}
		else
		{
			$SQL = "insert into buyerdivisions(intBuyerID,strDivision,strRemarks,intStatus,strUserId,dtmDate) values ('$intBuyerID','".$bdName."','".$bdRemarks."','".$intStatus."','$userId',now());";
//echo $SQL;
			$db->ExecuteQuery($SQL);
			echo "Saved successfully";
		}
	}
//End 23-04-2010 Buyer Division Details Save	

if($strButton=="searchDivisions")
{
	$txtBuyerCode = $_GET["txtBuyerCode"];
	
	$SQL="SELECT * FROM buyerdivisions where intBuyerID='$txtBuyerCode'";	
	$result = $db->RunQuery($SQL);
	//echo $SQL;
    if(mysql_num_rows($result)){
	 echo "1";
	}else{
	 echo "1";
	}
}

if($strButton=="loadBuyerDivs")
{
$buyerName	= $_GET["buyerName"];

$sql="select intDivisionId,strDivision,strRemarks from buyerdivisions where intBuyerID='$buyerName' order By strDivision";
$result=$db->RunQuery($sql);
$count=1;
$htmlTab="";
while($row=mysql_fetch_array($result))
{

	$remarks = $row['strRemarks'];
	if($remarks == "")
		$remarks = '&nbsp;';
	$htmlTab .='<tr class="bcgcolor-tblrowWhite">
		<td class="normalfntMid"><input type="hidden" id="txtDivHidden" value="'.$count.'"/></td>
		<td class="normalfnt" width="20px" id="'.$row['intDivisionId'].'"><img src="../../images/del.png" id="'.$count.'" onClick="removeRow(this);"/></td>
		<td class="normalfnt" width="100px"><label id="txtD'.$count.'" name="txtD'.$count.'">'.$row['strDivision'].'</lable></td>
		
		<td class="normalfnt" ><label id="txtDR'.$count.'" name="txtDR'.$count.'">'.$remarks.'</lable></td>
	</tr>';
	$count++;
}
echo $htmlTab;
}

function set_Used_tuple($table,$idField,$id){
	
	global $db;
	$sql = "update  $table set intUsed=1 where $idField=$id";
	$result = $db->RunQuery($sql);
	
	}
function insertBuyerDivisionDetails($buyerID,$buyerDiv,$buyerDivRemark,$userId)
{
	global $db;
	$sql = " insert into buyerdivisions (intBuyerID,strDivision, strRemarks,intStatus,strUserId, dtmDate
	)
	values 	('$buyerID', '$buyerDiv','$buyerDivRemark','1', '$userId', now()) ";
	$result = $db->RunQuery($sql);
}	
?>


