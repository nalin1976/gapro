<?php 
require_once('../../Connector.php');
$RequestType = $_GET["RequestType"];
$companyId 		= $_SESSION["FactoryID"];

if($RequestType=="loadOrderNo")
{
	$style = $_GET["style"];
	
	$sql = "select distinct O.strOrderNo
						from orders O 
						inner join productionwashreadyheader PWRH on PWRH.intStyleId=O.intStyleId
						where PWRH.intFactory='$companyId' ";
	if($style!="")
		$sql.="and o.strStyle='$style' ";
	$sql.="order by o.strOrderNo ";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['strOrderNo']."|";
				 
			}
			echo $pr_arr;
}
?>