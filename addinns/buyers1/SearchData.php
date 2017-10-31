<?php
include "../../Connector.php";
$RequestType = $_GET["RequestType"];

if($RequestType=="SearchBuyers")
{
    header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyerName = $_GET["BuyerName"];
	$ResponseXML .= "<Buyer>";
	
	$SQL="SELECT * FROM buyers where intBuyerID='$buyerName'";	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<buyerCode><![CDATA[" . $row["buyerCode"]  . "]]></buyerCode>\n";
         $ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";
		 $ResponseXML .= "<strAddress1><![CDATA[" . $row["strAddress1"]  . "]]></strAddress1>\n";  
		 $ResponseXML .= "<strAddress2><![CDATA[" . $row["strAddress2"]  . "]]></strAddress2>\n";
		 $ResponseXML .= "<strStreet><![CDATA[" . $row["strStreet"]  . "]]></strStreet>\n";
		 $ResponseXML .= "<strCity><![CDATA[" . $row["strCity"]  . "]]></strCity>\n";
		 $ResponseXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
		 $ResponseXML .= "<strPhone><![CDATA[" . $row["strPhone"]  . "]]></strPhone>\n";
		 $ResponseXML .= "<strEmail><![CDATA[" . $row["strEMail"]  . "]]></strEmail>\n";
		 $ResponseXML .= "<strWeb><![CDATA[" . $row["strWeb"]  . "]]></strWeb>\n";
		 $ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		 $ResponseXML .= "<strAgent><![CDATA[" . $row["strAgentName"]  . "]]></strAgent>\n";
		 $ResponseXML .= "<strState><![CDATA[" . $row["strState"]  . "]]></strState>\n";
		 $ResponseXML .= "<strZipCode><![CDATA[" . $row["strZipCode"]  . "]]></strZipCode>\n";
		 $ResponseXML .= "<strFax><![CDATA[" . $row["strFax"]  . "]]></strFax>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";  
		 $ResponseXML .= "<strDtFormat><![CDATA[" . $row["strDtFormat"]  . "]]></strDtFormat>\n";
		 $ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n";   
		 $ResponseXML .= "<actualFOB><![CDATA[" . $row["intinvFOB"]  . "]]></actualFOB>\n"; 
		 $ResponseXML .= "<PayTermId><![CDATA[" . $row["intPayTermID"]  . "]]></PayTermId>\n"; 
		 
	}
	 $ResponseXML .= "</Buyer>";
	 echo $ResponseXML;
}
elseif($RequestType=="SearchBuyingOffice")
{
    header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyingOfficeId = $_GET["BuyingOfficeName"];
	$ResponseXML = "<BuyingOffice>";

	$SQL="SELECT * FROM buyerbuyingoffices where intBuyingOfficeId='$buyingOfficeId'";	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<buyerCode><![CDATA[" . $row["buyerCode"]  . "]]></buyerCode>\n";
         $ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";
		 $ResponseXML .= "<strAddress1><![CDATA[" . $row["strAddress1"]  . "]]></strAddress1>\n";  
		 $ResponseXML .= "<strAddress2><![CDATA[" . $row["strAddress2"]  . "]]></strAddress2>\n";
		 $ResponseXML .= "<strStreet><![CDATA[" . $row["strStreet"]  . "]]></strStreet>\n";
		 $ResponseXML .= "<strCity><![CDATA[" . $row["strCity"]  . "]]></strCity>\n";
		 $ResponseXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
		 $ResponseXML .= "<strPhone><![CDATA[" . $row["strPhone"]  . "]]></strPhone>\n";
		 $ResponseXML .= "<strEmail><![CDATA[" . $row["strEMail"]  . "]]></strEmail>\n";
		 $ResponseXML .= "<strWeb><![CDATA[" . $row["strWeb"]  . "]]></strWeb>\n";
		 $ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		 $ResponseXML .= "<strAgent><![CDATA[" . $row["strAgentName"]  . "]]></strAgent>\n";
		 $ResponseXML .= "<strState><![CDATA[" . $row["strState"]  . "]]></strState>\n";
		 $ResponseXML .= "<strZipCode><![CDATA[" . $row["strZipCode"]  . "]]></strZipCode>\n";
		 $ResponseXML .= "<strFax><![CDATA[" . $row["strFax"]  . "]]></strFax>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n"; 
		
	}
	 $ResponseXML .= "</BuyingOffice>";
	 echo $ResponseXML;
}
elseif($RequestType=="SearchBuyerDivision")
{
    header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyerDivisionId = $_GET["buyerDivisionId"];
	$ResponseXML = "<BuyerDivision>";

	$SQL="SELECT * FROM buyerdivisions where intDivisionId='$buyerDivisionId'";	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<Name><![CDATA[" . $row["strDivision"]  . "]]></Name>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";         
	}
	 $ResponseXML .= "</BuyerDivision>";
	 echo $ResponseXML;
}

else if($RequestType=="getBuyingOffcDetails")
{
	
    
	$buyerId = $_GET["buyerId"];
	
	$ResponseXML = "<tr>
						  <td width='39' height='17' bgcolor='#498CC2' class='normaltxtmidb2'></td>
                          <td width='436' bgcolor='#498CC2' class='normaltxtmidb2' style='text-align:center'>Buying Office Name</td>
						</tr>";
						
	$SQL="select strName from buyerbuyingoffices where intBuyerID='$buyerId' and intStatus=1 ";	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			$name = $row["strName"];
			
		$ResponseXML .= "<tr class='bcgcolor-tblrowWhite'>
							<td class='normalfntMid'><input type='checkbox' checked='checked'/></td>
							<td class='normalfnt' >$name</td>
						</tr>";
		    
	}
	 echo $ResponseXML;
	
}
else if($RequestType=="getBuyingOffcmboDetails")
{
	$buyerId = $_GET["buyerId"];
	
	$SQL="select intBuyingOfficeId, strName from buyerbuyingoffices where intBuyerID='$buyerId' and intStatus=1 ";	
	$result = $db->RunQuery($SQL);
	$ResponseXML = "<option value=\"". "" ."\">" . "" ."</option>";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intBuyingOfficeId"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	echo $ResponseXML;
}
elseif($RequestType=="ReloadCombo")
{
$ResponseXML = "<XMLReloadCombo>\n";
$sql = "SELECT intBuyerID, strName FROM buyers where intStatus<>10 order by strName;";
$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value="."".">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=".$row["intBuyerID"].">".$row["strName"]."</option>\n";
}
$ResponseXML .= "</XMLReloadCombo>";
echo $ResponseXML;
}

else if($RequestType=="GetCountryZipCode")
{
	$countryId = $_GET["countryId"];
	$sql ="select strZipCode from country where strCountryCode='$countryId'";
	$result=$db->RunQuery($sql);
	//die($sql);
	while($row=mysql_fetch_array($result))
	{
		echo $row["strZipCode"];
	}
}
?>	
