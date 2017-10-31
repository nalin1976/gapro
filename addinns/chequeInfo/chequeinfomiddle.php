<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$command = $_GET["q"];

if($command =="cheque"){

	$ResponseXML .= "<Cheque>";
	//$db =new DBManager();
	
	$RequestType = $_GET["ChequeID"];
	//$RequestType =$_POST["txtbankcode"];
	
		$SQL="SELECT 
		bankchequeinfo.strName,
		bankchequeinfo.intBankID,
		bankchequeinfo.intBranchId,
		bank.strBankName as bankName,
		branch.strName as branchName,
		bankchequeinfo.intStartNo,
		bankchequeinfo.intEndNo,
		bankchequeinfo.intStatus,
		bankchequeinfo.intUsed  
		FROM 
		bankchequeinfo 
		INNER JOIN bank ON bankchequeinfo.intBankID = bank.intBankID
		INNER JOIN branch ON bankchequeinfo.intBranchId=branch.intBranchId
		WHERE bankchequeinfo.intId='$RequestType' 
		ORDER BY bankchequeinfo.strName asc";
		//echo $SQL;
		
		
		$result = $db->RunQuery($SQL);
		
	while($row = mysql_fetch_array($result))
	{
	$ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";
	$ResponseXML .= "<bank><![CDATA[". $row["intBankID"] ."]]></bank>\n";
	$ResponseXML .= "<branch><![CDATA[<option value=\"". $row["intBranchId"] ."\">" . $row["branchName"] ."</option>]]></branch>\n"; 
	$ResponseXML .= "<intStartNo><![CDATA[" . $row["intStartNo"]  . "]]></intStartNo>\n";
	$ResponseXML .= "<intEndNo><![CDATA[" . $row["intEndNo"]  . "]]></intEndNo>\n";
	$ResponseXML .= "<status><![CDATA[" . $row["intStatus"]  . "]]></status>\n";
	$ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n";
	 
	}	
	 $ResponseXML .= "</Cheque>";
	echo  $ResponseXML;
}
//------------------------------------------------------------------------------

if($command =="loadBankandBranch"){

	$ResponseXML= "<Branch>";
	$bankID = $_GET["bank"];
	
	$SQL = "SELECT* FROM branch where intBankId='".$bankID."' AND intStatus != '2' order by strName asc";

	  global $db;
	  $result = $db->RunQuery($SQL);
	  $k=0;
	
		$ResponseXML .= "<branches>";
		$ResponseXML .= "<![CDATA[";
		$ResponseXML .= "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	 while($row = mysql_fetch_array($result))
	 {
		//$ResponseXML .= "\n";
		$ResponseXML .= "<option value=\"". $row["intBranchId"] ."\">" . $row["strName"] ."</option>";
			
		$k++;
	 }
	 
	 $ResponseXML .= "]]>"."</branches>";
	
	 $ResponseXML .=  "</Branch>";
	 echo $ResponseXML;	
	 
}
//----------------------------------------------------------------------------------------------
else if($command=="LoadBankMode")
{
	$SQL = "SELECT bank.intBankId, bank.strBankName FROM bank  where intStatus<>10 order by strBankName asc";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$x = $row["strBankName"];
		echo "<option value=\"". $row["intBankId"] ."\">" . cdata($x) ."</option>" ;
	}
}
//----------------------------------------------------------------------------------------------
else if($command=="LoadBranchMode")
{
	$SQL = "SELECT intBranchId, strName FROM branch WHERE intStatus<>10 order by strName ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$x = $row["strName"];
		echo "<option value=\"". $row["intBranchId"] ."\">" . cdata($x) ."</option>" ;
	}
}
?>