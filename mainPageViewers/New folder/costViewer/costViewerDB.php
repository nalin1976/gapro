<?php

session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$companyId = $_SESSION["FactoryID"];
$userid    = $_SESSION["UserID"];
$RequestType = $_GET["RequestType"];
if($RequestType=loadCost)
{
	$costCenter  = $_GET["CostCenter"];


	$ResponseXML = "<XMLCostCenter>\n";
	
	$Sql="SELECT
genitemwisereorderlevel.dblReorderLevel,
genmatitemlist.strItemDescription,
COALESCE(Sum(stocktransactions.dblQty),0) AS stockQty,
stocktransactions.dtmDate,
genitemwisereorderlevel.intMatDetailID,
genitemwisereorderlevel.intCostCenterId,
genmatitemlist.dblLastPrice,
costcenters.intFactoryId
FROM
genitemwisereorderlevel
INNER JOIN genmatitemlist ON genmatitemlist.intItemSerial = genitemwisereorderlevel.intMatDetailID
LEFT JOIN stocktransactions ON stocktransactions.intMatDetailId = genitemwisereorderlevel.intMatDetailID 
INNER JOIN costcenters ON genitemwisereorderlevel.intCostCenterId = costcenters.intCostCenterId
INNER JOIN usercompany ON costcenters.intFactoryId = usercompany.companyId
AND costcenters.intFactoryId = $companyId AND usercompany.userId = $userid";
        if($costCenter!=''){
            $Sql.= " AND genitemwisereorderlevel.intCostCenterId='$costCenter'";
        }
        $Sql.= " GROUP BY genitemwisereorderlevel.intMatDetailID";

		
		//echo $Sql;
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
                                        if($row["dblReorderLevel"]>=$row["stockQty"]){
                                            $ResponseXML .= "<intMatDetailId><![CDATA[".$row["strItemDescription"]."]]></intMatDetailId>\n";
                                            $ResponseXML .= "<dblReorderLevel><![CDATA[".$row["dblReorderLevel"]."]]></dblReorderLevel>\n";
                                            $ResponseXML .= "<dblQty><![CDATA[".$row["stockQty"]."]]></dblQty>\n";
                                        }
				
				}
				
		}
	 
	$ResponseXML .="</XMLCostCenter>";
	echo $ResponseXML;

	}	

?>