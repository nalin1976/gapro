<?php
include "../../Connector.php";

//echo '11';

$id =$_GET["id"];
$id2 =$_GET["q"];

if($id=='loadTaxTypes')
{
		$SQL_taxtype="SELECT taxtypes.strTaxTypeID,taxtypes.strTaxType FROM taxtypes where intStatus=1 Order By strTaxType ASC";
	    $result_taxtype = $db->RunQuery($SQL_taxtype);
	  	echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
	  	while($row = mysql_fetch_array($result_taxtype))	
	    {
			echo "<option value=\"". $row["strTaxTypeID"] ."\">" . $row["strTaxType"] ."</option>" ;
	    }
}
else if($id=="loadCurrency")
{
			$SQL="SELECT currencytypes.intCurID,currencytypes.strCurrency FROM currencytypes WHERE currencytypes.intStatus=1 order by currencytypes.strCurrency;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
}
else if($id=="loadShipmentMode")
{
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}

}
else if($id=="LoadCountryMode")
{
	$SQL="SELECT country.intConID,country.strCountry FROM country WHERE country.intStatus=1 order by country.strCountry;";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}

else if($id=="LoadShipmentTerm")
{
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1' order by strShipmentTerm;";	
	$result = $db->RunQuery($SQL);		
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
}
//
else if($id=="LoadPaymentMode")
{
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
}
else if($id=="LoadPayTerm")
{
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
}
else if($id=="loadOrigin")
{
$SQL="SELECT intOriginNo,strDescription FROM itempurchasetype WHERE intStatus=1 order by strDescription;";
	$result = $db->RunQuery($SQL);		
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intOriginNo"] ."\">" . $row["strDescription"] ."</option>" ;
	}
}
else if($id=="LoadCreditPeriod")
{
	$SQL = "SELECT C.intSerialNO,C.strDescription FROM creditperiods C where C.intStatus =1 order by C.strDescription;";	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSerialNO"] ."\">" . $row["strDescription"] ."</option>" ;
	}
}
else if($id=="RemoveFile")
{
$url	= $_GET["url"];
	$fh = fopen($url, 'a');
	fclose($fh);
	
	unlink($url);
}
else if($id=="GetCountryZipCode")
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