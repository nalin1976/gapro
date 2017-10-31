<?php
include "../../Connector.php";

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"GetDivision") == 0)
{
	 $buyerID=$_GET["CustID"];
	 $sql = "SELECT intDivisionId,strDivision FROM buyerdivisions b where intStatus=1 and intBuyerID=".$buyerID." order by strDivision;";
	 $result = $db->RunQuery($sql);
	 	echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {
		echo "<option value=\"". $row["intDivisionId"] ."\">" . $row["strDivision"] ."</option>" ;           
	 }
}
elseif (strcmp($RequestType,"GetBuyerDivisionColors") == 0)
{
	 $BuyerID 		= $_GET["BuyerID"];
	 $DivisionID 	= $_GET["DivisionID"];
	 $sql="select distinct strColor from colors where intCustomerId = " . $BuyerID . " AND intDivisionID = " . $DivisionID . " AND intStatus!='10' order by strColor";
	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
  	 {
		 echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;     
	 }
}
elseif (strcmp($RequestType,"GetAllColors") == 0)
{
$buyerId 		= $_GET["BuyerID"];
$divisionId 	= $_GET["DivisionID"];
	 $sql="select distinct strColor from colors where strColor not in(select distinct strColor from colors where intCustomerId ='$buyerId' AND intDivisionID = '$divisionId' AND intStatus!='10') order by strColor
";
	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
  	 {
		 echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;     
	 }
}
?>