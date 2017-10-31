<?php
include "../../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$id =$_GET["id"];


if($id=="LoadDetails")
{
$BranchID = $_GET["BranchID"];
$ResponseXML = "<Branch>";
$SQL="SELECT * FROM branch where intBranchId= '".$BranchID."' AND intStatus != '10'";	
$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<BankID><![CDATA[" . $row["intBankId"]  . "]]></BankID>\n";
		$ResponseXML .= "<strBranchCode><![CDATA[" . $row["strBranchCode"]  . "]]></strBranchCode>\n"; 
		$ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
		$ResponseXML .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		$ResponseXML .= "<strStreet><![CDATA[" . $row["strStreet"]  . "]]></strStreet>\n";
		$ResponseXML .= "<strCity><![CDATA[" . $row["strCity"]  . "]]></strCity>\n";
		$ResponseXML .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";         
		$ResponseXML .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		$ResponseXML .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		$ResponseXML .= "<EMail><![CDATA[" . $row["strEMail"]  . "]]></EMail>\n";
		$ResponseXML .= "<ContactPerson><![CDATA[" . $row["strContactPerson"]  . "]]></ContactPerson>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<RefNo><![CDATA[" . $row["strRefNo"]  . "]]></RefNo>\n";   
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n"; 
		$ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n"; 
		$ResponseXML .= "<AccountNo><![CDATA[" . $row["strAccountNo"]  . "]]></AccountNo>\n";
		$ResponseXML .= "<CurrencyId><![CDATA[" . $row["intCurrencyId"]  . "]]></CurrencyId>\n";
	}
$ResponseXML .= "</Branch>";
echo $ResponseXML;
}
else if($id=="LoadCountryMode")
{
	$SQL="SELECT country.strCountry,country.strCountryCode FROM country WHERE country.intStatus=1 order by country.strCountry;";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountry"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}

else if($id=="LoadBankMode")
{
	$SQL = "SELECT bank.intBankId, bank.strBankName FROM bank  where intStatus=1 order by strBankName asc";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$x = $row["strBankName"];
		echo "<option value=\"". $row["intBankId"] ."\">" . cdata($x) ."</option>" ;
	}
}
else if($id=="LoadAccountDetails")
{
$ResponseXML = "<Branch>\n";
	$branchID	= $_GET["BranchID"];
	$SQL = "select BA.intCurrencyId,BA.strAccountNo,CT.strCurrency from branch_accounts BA inner join currencytypes CT on CT.intCurID=BA.intCurrencyId where BA.intBranchId=$branchID order by BA.strAccountNo";	
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<AccountNo><![CDATA[" . $row["strAccountNo"]  . "]]></AccountNo>\n";
		$ResponseXML .= "<CurrencyId><![CDATA[" . $row["intCurrencyId"]  . "]]></CurrencyId>\n";
		$ResponseXML .= "<CurrencyName><![CDATA[" . $row["strCurrency"]  . "]]></CurrencyName>\n";		
	}
$ResponseXML .= "</Branch>";
echo $ResponseXML;
}
?>